<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get('isLoggedIn'))
        {
            return redirect()
                ->to('/dashboard');
        }
        helper(['form']);
        $data['title'] = "Login";
        echo  view('templates/header', $data) 
            . view('auth/login') 
            . view('templates/footer');
    }


    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        

        $session->setFlashdata('data', [
            "username" => $username,
            "password" => $password
        ]);

        $data = $userModel->where('username', $username)->first();
        
        if($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'id' => $data['id'],
                    'fullname' => $data['fullname'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/profile');
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        }else{
            $session->setFlashdata('msg', 'Username does not exist.');
            return redirect()->to('/login');
        }
    }
}
