<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function index()
    {
        $data['title'] = "Profile";
        echo  view('templates/header', $data) 
            . view('user/profile', $data) 
            . view('templates/footer');
    }


    public function dashboard()
    {
        $data['title'] = "Dashboard";
        echo  view('templates/header', $data) 
            . view('user/dashboard', $data) 
            . view('templates/footer');
    }
}
