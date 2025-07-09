<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;


class LoginController extends BaseController
{

    private $loginModel;
    private $usersModel;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
        $this->usersModel = new UsersModel();
        $this->session = session();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $accessGranted = grantAccess();
        if ($accessGranted)
            return $accessGranted;
        return view('auth/login');
    }

    public function registerView()
    {
        $accessGranted = grantAccess();
        if ($accessGranted)
            return $accessGranted;
        return view('auth/register');
    }

    public function forgotPasswordView()
    {
        $accessGranted = grantAccess();
        if ($accessGranted)
            return $accessGranted;
        return view('auth/forgot_password');
    }
    public function codeVerification()
    {
        $accessGranted = grantAccess();
        if ($accessGranted)
            return $accessGranted;
        return view('auth/code_verification');
    }


    public function login()
    {
        try {
            $ci = $this->request->getPost('ci');
            $password = $this->request->getPost('password');
            $redirect = $this->request->getPost('redirect'); // Capturar la URL de redirección

            $data = [
                'ci' => trim($ci),
                'password' => trim($password)
            ];

            $validation = \Config\Services::validation();
            $validation->setRules([
                'ci' => [
                    'label' => 'Cédula',
                    'rules' => 'required',
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                ],
            ]);

            if ($validation->run($data)) {
                $user = $this->loginModel->findUserByCI($ci);

                if ($user && password_verify($password, $user['password'])) {
                    // Guardamos los datos en sesión
                    $sessionData = [
                        'user_id' => $user['id'],
                        'ci' => $user['ci'],
                        'email' => $user['email'],
                        'names' => $user['name'],
                        'surnames' => $user['surname'],
                        'rol' => $user['role'],
                        'image' => $user['image'],
                        'logged_in' => true
                    ];
                    $this->session->set($sessionData);

                    // 🔹 Si hay una URL de redirección, ir a esa página
                    if (!empty($redirect)) {
                        return redirect()->to(base_url($redirect));
                    }

                    return redirectView('admin', null, [['Sesión iniciada correctamente.', 'success']]);
                }

                return redirectView('/auth/login', null, [['Credenciales inválidas', 'error']]);
            } else {
                return redirectView('/auth/login', $validation, [['Credenciales inválidas', 'error']]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error en el login: ' . $e->getMessage());
            return redirectView('/auth/login', null, [['Error al iniciar sesión', 'danger']]);
        }
    }

    public function register()
    {
        $redirect = $this->request->getGet('redirect'); // Capturar la URL de redirección

        // Obtener los campos de los dos nombres y dos apellidos
        $ic = $this->request->getPost('ic');
        $first_name = strtoupper($this->request->getPost('first_name'));
        $second_name = strtoupper($this->request->getPost('second_name'));
        $first_surname = strtoupper($this->request->getPost('first_surname'));
        $second_surname = strtoupper($this->request->getPost('second_surname'));
        $email = $this->request->getPost('email');
        $phone_number = $this->request->getPost('phone_number');
        $password = $this->request->getPost('password');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_repeat = $this->request->getPost('password_repeat');

        $verification_code = bin2hex(random_bytes(32));

        // Preparar los datos con los dos nombres y dos apellidos
        $data = [
            'rol' => '3',
            'ic' => trim($ic),
            'first_name' => trim($first_name),
            'second_name' => trim($second_name),
            'first_surname' => trim($first_surname),
            'second_surname' => trim($second_surname),
            'email' => trim($email),
            'phone_number' => trim($phone_number),
            'password' => trim($hashed_password),
            'password_match' => $password,
            'verification_code' => $verification_code,
            'password_repeat' => $password_repeat,
        ];

        try {
            // Validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'ic' => ['label' => 'Cédula', 'rules' => 'required'],
                'first_name' => ['label' => 'Primer nombre', 'rules' => 'required'],
                'second_name' => ['label' => 'Segundo nombre', 'rules' => 'required'],
                'first_surname' => ['label' => 'Primer apellido', 'rules' => 'required'],
                'second_surname' => ['label' => 'Segundo apellido', 'rules' => 'required'],
                'email' => ['label' => 'Correo electrónico', 'rules' => 'required|valid_email'],
                'phone_number' => ['label' => 'Número de teléfono', 'rules' => 'required'],
                'password' => ['label' => 'Contraseña', 'rules' => 'required|min_length[8]'],
                'password_repeat' => ['label' => 'Repetir contraseña', 'rules' => 'required|min_length[8]|matches[password_match]'],
            ]);

            if ($validation->run($data)) {
                unset($data['password_repeat']);
                unset($data['password_match']);

                // Iniciar transacción
                $this->db->transStart();

                // Insertar el usuario en la base de datos
                $insertUsers = $this->usersModel->insert($data);
                if (!$insertUsers) {
                    throw new \RuntimeException('No fue posible guardar el usuario en la base de datos.');
                }

                // Guardamos la redirección en la sesión
                if (!empty($redirect)) {
                    $this->session->set('redirect_after_verification', $redirect);
                }

                // Generar enlace de verificación
                $verificationLink = base_url("verify-email/{$verification_code}");

                // Enviar el email de verificación
                $emailData = [
                    'to' => $email,
                    'subject' => 'Verificación de email',
                    'message' => 'Estimado/a ' . $first_name . ', por favor, verifica tu correo electrónico haciendo clic en el botón a continuación.',  // Agregado
                    'htmlContent' => view('email/verification', [
                        'nombreUsuario' => $first_name . ' ' . $second_name . ' ' . $first_surname . ' ' . $second_surname,
                        'verificationLink' => $verificationLink,
                        'nombreEmpresa' => 'Softect Apps',
                        'date' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss')
                    ])
                ];

                try {
                    service('queue')->push('emails', 'email', $emailData);
                } catch (\Exception $e) {
                    // Si falla el envío del correo, hacer rollback
                    $this->db->transRollback();
                    log_message('error', 'Error al enviar el correo: ' . $e->getMessage());
                    return redirectView('register', null, [['No se pudo enviar el correo de verificación', 'warning']], $data);
                }

                // Completar la transacción
                $this->db->transComplete();

                // Si la transacción fue exitosa
                if ($this->db->transStatus()) {
                    return redirectView('register', null, [['Por favor, revisa tu correo electrónico para verificar tu cuenta.', 'success']], $data);
                } else {
                    throw new \RuntimeException('No fue posible completar la transacción.');
                }
            } else {
                return redirectView('register', $validation, [['Error en los datos enviados', 'warning']], $data);
            }
        } catch (\Exception $e) {
            // Hacer rollback en caso de error
            $this->db->transRollback();
            log_message('error', 'Error en el registro: ' . $e->getMessage());
            return redirectView('register', null, [['El usuario no pudo registrarse', 'warning']], $data);
        }
    }

    // Método para verificar el email
    public function verifyEmail($code)
    {
        try {
            $user = $this->usersModel->where('verification_code', $code)->first();

            if (!$user) {
                return redirect()->to('/auth/login')->with('flashMessages', [['Código de verificación inválido', 'danger']]);
            }

            $this->usersModel->update($user['id'], [
                'is_verified' => 1,
                'verification_code' => null
            ]);

            // Revisar si hay una redirección pendiente
            $redirectUrl = $this->session->get('redirect_after_verification');
            $this->session->remove('redirect_after_verification');

            if (!empty($redirectUrl)) {
                return redirect()->to(base_url($redirectUrl));
            }

            return redirect()->to('/auth/login')->with('flashMessages', [['Tu cuenta ha sido verificada. Ahora puedes iniciar sesión.', 'success']]);
        } catch (\Exception $e) {
            log_message('error', 'Error en la verificación de email: ' . $e->getMessage());
            return redirect()->to('/auth/login')->with('flashMessages', [['Error al verificar la cuenta', 'danger']]);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth/login');
    }
}
