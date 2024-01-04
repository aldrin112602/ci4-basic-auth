<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
  
class SignupController extends Controller
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
        $data['title'] = "Register User";
        echo  view('templates/header', $data) 
            . view('auth/register') 
            . view('templates/footer');
    }
  
    public function store()
    {
        $session = session();
        helper(['form']);
        $rules = [
            'email'             => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'username'          => 'required|min_length[4]|max_length[50]|alpha_dash|is_unique[users.username]',
            'password'          => 'required|min_length[4]|max_length[50]'
        ];

        $session->setFlashdata('data', [
            'email'    => $this->request->getVar('email'),
            'username'     => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password'     => $this->request->getVar('password'),
        ]);

          
        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'email'    => $this->request->getVar('email'),
                'username'     => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            return redirect()->to('/login');
        } else {
            $validation['validation'] = $this->validator;
            $data['title'] = "Register User";
            echo  view('templates/header', $data) 
            . view('auth/register', $validation) 
            . view('templates/footer');
        }
          
    }
  
}