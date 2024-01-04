<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\Exceptions\PageNotFoundException;

class AuthController extends BaseController
{
    public function view($page = 'login')
    {
        if (! is_file(APPPATH . 'Views/auth/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('auth/' . $page)
            . view('templates/footer');
    }
}
