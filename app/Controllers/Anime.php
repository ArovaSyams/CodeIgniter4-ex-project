<?php

namespace App\Controllers;

use App\Models\AnimeModel;
use CodeIgniter\CodeIgniter;

class Anime extends BaseController
{
    protected $animeModel;
    public function __construct()
    {
        //agar dapat digunakan oleh method lain
        $this->animeModel = new AnimeModel();
    }

    public function index()
    {
        session()->get('email');

        if(!session()->has('email')) {
            return redirect()->to('/');
        }

        $keyword = $this->request->getVar('keyword');

        if ($keyword == null) {
            $anime = $this->animeModel;
        }else {
            $anime = $this->animeModel->search($keyword);
        }
        

        $data = [
            'title' => 'Anime List',
            'anime' => $anime->getAnime()
        ];

        //$komikModel = new $komikModel();

        return view('anime/index', $data);
    }

    public function detail($slug)
    {
        session()->get('email');

        if(!session()->has('email')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Detail Anime',
            'anime' => $this->animeModel->getAnime($slug)
        ];

        if (empty($data['anime'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dari $slug Tidak Ditemukan");
        }

        return view('anime/detail', $data);
    }

    public function tambah()
    {
        session()->get('email');

        if(!session()->has('email')) {
            return redirect()->to('/');
        }
        //session();
        $data = [
            'title' => 'Form Tambah Data Anime',
            'validation' => \Config\Services::validation()
        ];

        return view('anime/tambah', $data);
    }

    public function saves()
    {
        //validasi
        if (!$this->validate([
            'judul' => [    
                'rules' => 'required|is_unique[anime.judul]',
                'errors' => [
                    'required' => '{field} Anime Harus Diisi',
                    'is_unique' => '{field} Anime Sudah Terdaftar'
                ]
            ],
            'pengarang' => [
                'rules' => 'required|is_unique[anime.pengarang]',
                'errors' => [
                    'required' => '{field} Anime Harus Diisi',
                    'is_unique' => '{field} Anime Sudah Terdaftar'
                ]
            ],
            'studio' => [
                'rules' => 'required|is_unique[anime.studio]',
                'errors' => [
                    'required' => '{field} Anime Harus Diisi',
                    'is_unique' => '{field} Anime Sudah Terdaftar'
                ]
            ],
            'key_visual' => [
                'rules' => 'max_size[key_visual,2048]|is_image[key_visual]|mime_in[key_visual,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar Terlalu Besar',
                    'is_image' => 'Yang Anda Pilih Bukan Gambar',
                    'mime_in' => 'Yang Anda Pilih Bukan Gambar'

                ]
            ]

        ])) {
            //aslinya ini bisa berjalan tanpa with() dan $validation
            // $validation = \Config\Services::validation();
            // return redirect()->to('/anime/tambah')->withInput()->with('validation', $validation);
            return redirect()->to('/anime/tambah')->withInput();
        }

        //ambil file gambar
        $fileGambar = $this->request->getFile('key_visual');
        //jila tidak ada gambar dikirim
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default.jpg';
        } else {
            //Genetare nama random file gambar
            $namaGambar = $fileGambar->getRandomName();
            //letakkan di local folder img
            $fileGambar->move('img', $namaGambar);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->animeModel->save([
            'judul' => $this->request->getVar('judul'),
            'pengarang' => $this->request->getVar('pengarang'),
            'studio' => $this->request->getVar('studio'),
            'key_visual' => $namaGambar,
            'slug' => $slug
        ]);

        session()->setFlashData('pesan', 'Data Berhasil Ditambahkan');

        return redirect()->to('/anime');
    }

    public function delete($id)
    {
        //cari gambar berdasarkan id
        $anime = $this->animeModel->find($id);
        //cek jika image bukan default.jpg
        if ($anime['key_visual'] != 'default.jpg') {
            //hapus data dalam img
            unlink('img/' . $anime['key_visual']);
        }

        $this->animeModel->delete($id);

        session()->setFlashData('pesan', 'Data Berhasil Dihapus');

        return redirect()->to('/anime');
    }

    public function edit($slug)
    {
        session()->get('email');

        if(!session()->has('email')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Form Tambah Data Anime',
            'validation' => \Config\Services::validation(),
            'anime' => $this->animeModel->getAnime($slug)
        ];

        return view('anime/edit', $data);
    }

    public function update($id)
    {
        $animeLama = $this->animeModel->getAnime($this->request->getVar('slug'));

        if ($animeLama['judul'] == $this->request->getVar('judul') || $animeLama['pengarang'] == $this->request->getVar('pengarang') || $animeLama['studio'] == $this->request->getVar('studio')) {

            $rules = ['required', 'required', 'required', 'required'];
        } else {
            $rules = ['required|is_unique[anime.judul]', 'required|is_unique[anime.pengarang]', 'required|is_unique[anime.studio]'];
        }

        //validasi
        if (!$this->validate([
            'judul' => [
                'rules' => $rules[0],
                'errors' => [
                    'required' => '{field} Anime Harus Diisi',
                    'is_unique' => '{field} Anime Sudah Terdaftar'
                ]
            ],
            'pengarang' => [
                'rules' => $rules[1],
                'errors' => [
                    'required' => '{field} Anime Harus Diisi',
                    'is_unique' => '{field} Anime Sudah Terdaftar'
                ]
            ],
            'studio' => [
                'rules' => $rules[2],
                'errors' => [
                    'required' => '{field} Anime Harus Diisi',
                    'is_unique' => '{field} Anime Sudah Terdaftar'
                ]
            ],
            'key_visual' => [
                'rules' => 'max_size[key_visual,2048]|is_image[key_visual]|mime_in[key_visual,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Gambar Terlalu Besar',
                    'is_image' => 'Yang Anda Pilih Bukan Gambar',
                    'mime_in' => 'Yang Anda Pilih Bukan Gambar'
                ]
            ]

        ])) {
            return redirect()->to('/anime/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('key_visual');

        //cek apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('key_visualLama');
        } else {
            $namaSampul = $fileSampul->getRandomName();
            //pindah gambar
            $fileSampul->move('img', $namaSampul);
            //hapus file lama
            unlink('img/' . $this->request->getVar('key_visualLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->animeModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'pengarang' => $this->request->getVar('pengarang'),
            'studio' => $this->request->getVar('studio'),
            'key_visual' => $namaSampul,
            'slug' => $slug
        ]);

        session()->setFlashData('pesan', 'Data Berhasil Diubah');

        return redirect()->to('/anime');
    }
}
