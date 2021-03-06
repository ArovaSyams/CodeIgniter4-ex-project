<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $uData = session()->get('email');

        if (!session()->has('email')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Home | Stackware Dev',
            'uData' => $uData['username']
        ];

        return view("pages/home", $data);
    }

    public function about()
    {
        session()->get('email');

        if (!session()->has('email')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'About Me'
        ];
        return view("pages/about", $data);
    }

    public function  contact()
    {
        session()->get('email');

        if (!session()->has('email')) {
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl, hibrida 8 No. 13A',
                    'kota' => 'Bengkulu'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. Rejoso No. 13A',
                    'kota' => 'Jombang'
                ]
            ]
        ];
        return view("pages/contact", $data);
    }
}
