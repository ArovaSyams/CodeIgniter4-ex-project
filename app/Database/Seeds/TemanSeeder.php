<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;


class TemanSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama'       => 'Arova Syams Wifqo',
        //         'alamat'     => 'Jl. hibrida 8 Bengkulu',
        //         'created_at' => Time::now(),
        //         'updated_at' =>  Time::now()
        //     ],
        //     [
        //         'nama'       => 'Arova Syams',
        //         'alamat'     => 'Jl. hibrida 9 Bengkulu',
        //         'created_at' => Time::now(),
        //         'updated_at' =>  Time::now()
        //     ],
        //     [
        //         'nama'       => 'Arova Wifqo',
        //         'alamat'     => 'Jl. hibrida 10 Bengkulu',
        //         'created_at' => Time::now(),
        //         'updated_at' =>  Time::now()
        //     ],
        // ];
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i <= 100; $i++) {

            $data = [
                'nama'       => $faker->name,
                'alamat'     => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::now()
            ];
            $this->db->table('teman')->insert($data);
        }

        // Simple Queries
        // $this->db->query(
        //     "INSERT INTO teman (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)",
        //     $data
        // );

        // Using Query Builder
        // $this->db->table('teman')->insert($data);
        // $this->db->table('teman')->insertBatch($data);
    }
}
