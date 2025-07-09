<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;


class RecoverController extends BaseController
{

    public function index()
    {
        $accessGranted = grantAccess();
        if ($accessGranted)
            return $accessGranted;
        return view('auth/recover');
    }
}
