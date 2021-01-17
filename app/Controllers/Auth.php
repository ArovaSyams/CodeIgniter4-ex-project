<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Auth extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Stackware | Login',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    public function loging()
    {
        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'valid_email' => 'Email Tidak valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            return redirect()->to('index')->withInput();
        }
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->authModel->where(['email' => $email])->first();

        //pengecekan email user ada
        if ($user) {

            // Jika user aktif
            if ($user['is_active'] == 1) {
                //pengecekan password
                if (password_verify($password, $user['password'])) {
                    //inisiasi session
                    $uData = [
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
    
                    session()->set('email', $uData);
    
                    //pengecekan session
                    if (session()->has('email')) {
                        return redirect()->to('/pages/index');
                    }
                } else {
                    
                    session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">Password anda salah</div>');
                    return redirect()->to('index')->withInput();
                }  
            } else {
                
                session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert">Email ini belum diaktivasi</div>');
                return redirect()->to('index')->withInput();
            }         
        } else {
            
            session()->setFlashdata('pesan', '<div class="alert alert-danger" role="alert"> Email Tidak terdaftar </div>');
            return redirect()->to('index')->withInput();
            
        }
    }

    public function logout()
    {
        unset($_SESSION['email']);

        return redirect()->to('index');
    }

    public function registration()
    {
        $data = [
            'title' => 'Stackware | Registration',
            'validation' => \Config\Services::validation()
        ];
        return view('auth/registration', $data);
    }

    public function register()
    {

        if (!$this->validate([
            'username' => [
                'rules' => 'required|trim|is_unique[user.username]',
                'errors' => [
                    'required' => '{field} Wajib Diisi',
                    'is_unique' => '{field} sudah terdaftar'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|trim|is_unique[user.email]',
                    'errors' => [
                        'required' => '{field} Harus diisi',
                        'valid_email' => 'Email Tidak valid',
                        'is_unique' => '{field} sudah terdaftar'
                ]
            ],
            'password1' => [
                'rules' => 'required|matches[password2]|trim',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'matches' => 'Password tidak sama'
                ]
            ]
        ])) {
            return redirect()->to('registration')->withInput();
        }

        $this->authModel->save([
            'username' => htmlspecialchars($this->request->getPost('username')),
            'email' => htmlspecialchars($this->request->getPost('email')),
            'image' => 'default.jpg',
            'password' => password_hash($this->request->getPost('password1'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 1       
        ]);

        session()->setFlashdata('pesan', '<div class="alert alert-success" role="alert">Akun anda telah di registrasi, Silahkan Login</div>');

        return redirect()->to('index');
    }
}
