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
        } elseif ($session->get('OTP_TOKEN')) {
            $session->setFlashdata('msg', 'Please verify your email first!');
            return redirect()->to('/verify');
        
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
                <p>We have sent a 6-digit verification code to your Gmail address. Please use the code below to complete your registration:</p>
                <h2 style="text-align:center; font-size:32px;">'. $OTP_TOKEN .'</h2>
                <p>This code is valid for <b>10 minutes</b>. Please enter it on the registration page as soon as possible.</p>
                <p>If you did not initiate this request, you can safely ignore this email.</p>
                <p>If you encounter any issues or have questions, feel free to contact us at <a href="mailto:your.email@example.com">your.email@example.com</a>.</p>
            </body>
            </html>';

            if (!$this->sendMail($to, $subject, $message)) {
                $data['title'] = "Register User";
                $session->setFlashdata('msg', 'Please check your internet connection');
                echo view('templates/header', $data)
                    . view('auth/register')
                    . view('templates/footer');
            } else {
                
                $ses_data = [
                        'OTP_TOKEN' => $OTP_TOKEN,
                        'email'    => $this->request->getVar('email'),
                        'username'     => $this->request->getVar('username'),
                        'password'     => $this->request->getVar('password'),
                ];
                $session->set($ses_data);
                return redirect()->to('/verify');
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




    public function verify() 
    {
        $session = session();
        if(!$session->get('OTP_TOKEN')) 
        {
            return redirect()->to('/register');
        }

        
        $data['title'] = "Email Verification";
        echo view('templates/header', $data)
            . view('auth/verify')
            . view('templates/footer');
    }

    public function verifyMail() 
    {
        $session = session();
        $OTP = $this->request->getVar('otp');
        if($session->get('OTP_TOKEN') == $OTP) {
            $userModel = new UserModel();
            $data = [
                'email'    => $session->get('email'),
                'username' => $session->get('username'),
                'password' => password_hash($session->get('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            $session->destroy();
            $session->setFlashdata('msg', 'Please login your account');
            return redirect()->to('/login');
        } else {
            $session->setFlashdata('msg', 'Invalid OTP, please try again');
            return redirect()->to('/verify');
        }
    }


    
  
}