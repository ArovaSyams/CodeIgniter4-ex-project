<?php

namespace App\Controllers;

use App\Models\TemanModel;
use CodeIgniter\CodeIgniter;

class Teman extends BaseController
{
    protected $temanModel;
    public function __construct()
    {
        //agar dapat digunakan oleh method lain
        $this->temanModel = new TemanModel();
    }

    public function index()
    {
        session()->get('email');

        if(!session()->has('email')) {
            return redirect()->to('/login');
        }

        $currentPage = ($this->request->getVar('page_teman')) ? $this->request->getVar('page_teman') : 1;

        $keyword = $this->request->getVar('keyword');

        $keyA = $this->request->getVar('alamat');
        $keyName = $this->request->getVar('nama');
        if ($keyword) {
            $teman = $this->temanModel->search($keyword);
        } else {
            $teman = $this->temanModel;
        }
        
        if ($keyA || $keyName) {
            // $teman = $this->temanModel->searchDouble($keyA, $keyName);
            if ($keyA) {
                $teman = $this->temanModel->searchA($keyA);
            }
            if ($keyName) {
                $teman = $this->temanModel->searchName($keyName);
            }
            if ($keyA && $keyName) {
                $teman = $this->temanModel->searchDouble($keyA, $keyName);
            } else {
                $teman = $this->temanModel;
            }
        }

        $pages = $this->request->getVar('page');
        if ($pages) {
            $page = $this->request->getVar('page');
        } else {
            $page = 10;
        }

        $data = [
            'title' => 'Teman List',
            // 'teman' => $this->temanModel->findAll()
            'teman' => $teman->paginate($page, 'teman'),
            'pager' => $this->temanModel->pager,
            'currentPage' => $currentPage
        ];

        //$komikModel = new $komikModel();

        return view('teman/index', $data);
    }
}
