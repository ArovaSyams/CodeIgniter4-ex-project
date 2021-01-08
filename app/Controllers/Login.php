<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Login extends BaseController
{
    protected $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Log In'
        ];
        
        return view('login', $data);
    }

    public function loging()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->loginModel->where(['email' => $email])->first();

        if(!$this->validate([

        ]))


        if (!$user) {

            return redirect()->to('index')->withInput();

        } else if ($user['email'] == $email && $user['password'] == $password) {
            session()->set('email', $user['email']);
    
            if(session()->has('email')) {
                return redirect()->to('/pages/index');
            } 
        }

    }

    public function logout() {
        unset($_SESSION ['email']);

        return redirect()->to('index');
    }
}
