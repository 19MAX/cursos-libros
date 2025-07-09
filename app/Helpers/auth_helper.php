<?php
if (!function_exists('getPaymentStatusText')) {

    function grantAccess(int $rol = null)
    {
        $userSessionRol = session('rol');
        if (isset($userSessionRol)) {
            $userSessionRol = (int) $userSessionRol;
            if (isset($rol)) {
                if ($rol !== $userSessionRol) {
                    session()->destroy();
                    return redirect()->to(base_url('/auth/login'));
                }
                return true;
            } else {
                switch ($userSessionRol) {
                    case RolesOptions::Admin:
                        return redirect()->to(base_url("admin"));
                    case RolesOptions::Docente:
                        return redirect()->to(base_url("docente"));
                    default:
                        session()->destroy();
                        return redirect()->to(base_url("/auth/login"));
                }
            }
        }
        return false;
    }

}

function checkActiveModule($modulo, $value)
{
    return ($modulo == $value) ? true : false;
}