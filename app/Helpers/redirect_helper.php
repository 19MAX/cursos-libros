<?php

if (!function_exists('redirectView')) {
    /**
     * Redirige a una ruta específica con mensajes flash y datos de validación.
     *
     * @param string $route Ruta de redirección.
     * @param mixed $validation Datos de validación (opcional).
     * @param array|null $flashMessages Mensajes flash (opcional).
     * @param array|null $last_data Datos del último formulario enviado (opcional).
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección configurada.
     */
    function redirectView($route = '/auth/login', $validation = null, $flashMessages = null, $last_data = null)
    {
        return redirect()->to($route)
            ->with('flashValidation', isset($validation) ? $validation->getErrors() : null)
            ->with('flashMessages', $flashMessages)
            ->with('last_data', $last_data);
    }
}
