<?php

namespace App\Models;

use CodeIgniter\Model;

class TemanModel extends Model
{
    protected $table = 'teman';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'alamat'];

    public function search($keyword)
    {
        return $this->table('teman')->like('nama', $keyword)->orLike('alamat', $keyword);
    }

    public function searchA($keyA)
    {
        return $this->table('teman')->like('alamat', $keyA);
    }

    public function searchName($keyName)
    {
        return $this->table('teman')->like('nama', $keyName);
    }    

    public function searchDouble($keyA, $keyName)
    {
        return $this->table('teman')->like('nama', $keyName)->like('alamat', $keyA);
    }    
}
