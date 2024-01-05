<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Controllers\SendMail;

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
            'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'username'=> 'required|min_length[4]|max_length[50]|alpha_dash|is_unique[users.username]',
            'password'=> 'required|min_length[6]|max_length[50]'
        ];

        $session->setFlashdata('data', [
            'email'    => $this->request->getVar('email'),
            'username'     => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password'     => $this->request->getVar('password'),
        ]);

          
        if ($this->validate($rules)) {
            $to = $this->request->getVar('email');
            $OTP_TOKEN = rand(100000, 999999);
            $subject = "Email verification";
            $message = '
                    <!DOCTYPE html>
                    <html>
                        <body>
                            <p>Dear '. $to .',</p>
                            <p>Please verify your account. If you did not initiate this request, please ignore this email, please enter the following verification code:</p>
                            <h2 style="text-align:center; font-size:32px;">'. $OTP_TOKEN .'</h2>
                            <p>This code is valid for <b>10 minutes</b>, so please enter it as soon as possible.</p>
                            <p>If you have any trouble entering the code, please don\'t hesitate to contact us at <a href="mailto:cabaleroaldrin02@gmail.com">cabaleroaldrin02@gmail.com</a>.</p>
                        </body>
                    </html>';
            

            if (!$this->sendMail($to, $subject, $message)) {
                $data['title'] = "Register User";
                echo view('templates/header', $data)
                    . view('auth/register')
                    . view('templates/footer');
            } else {
                $session->set('OTP_TOKEN', $OTP_TOKEN);
                return redirect->to('/verify');
                // $userModel = new UserModel();
                // $data = [
                //     'email'    => $this->request->getVar('email'),
                //     'username' => $this->request->getVar('username'),
                //     'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
                // ];
                // $userModel->save($data);
                // return redirect()->to('/login');
            }
        } else {
            $validation['validation'] = $this->validator;
            $data['title'] = "Register User";
            echo view('templates/header', $data)
                . view('auth/register', $validation)
                . view('templates/footer');
        }

          
    }



    public function sendMail($to, $subject, $message) 
    { 
       
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('caballeroaldrin02@gmail.com', 'Confirm Registration');
        
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) 
		{
            return true;
        } 
		else 
		{
            return false;
        }
    }




    public function verify() {
        $data['title'] = "Email Verification";
        echo view('templates/header', $data)
            . view('auth/verify')
            . view('templates/footer');
    }


    
  
}