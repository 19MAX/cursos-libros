<?php

namespace App\Controllers\Admin\Courses;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CoursesController extends BaseController
{
    public function index()
    {
        return view('admin/courses/index');
    }
}
