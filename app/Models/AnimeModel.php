<?php

namespace App\Models;

use CodeIgniter\Model;

class AnimeModel extends Model
{
    protected $table = 'anime';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'pengarang', 'studio', 'key_visual', 'slug'];

    public function getAnime($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    public function search($keyword)
    {
        return $this->table('anime')->like('judul', $keyword);
    }
}
