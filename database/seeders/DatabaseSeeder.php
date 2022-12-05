<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\keys;
use App\Models\mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        mahasiswa::create(
            [
                'nrp' => '043040001',
                'nama' => 'Doddy Ferdiansyah',
                'email' => 'doy@gmail.com',
                'jurusan' => 'Teknik Mesin'
            ]
        );
        mahasiswa::create(
            [
                'nrp' => '023040123',
                'nama' => 'Erik',
                'email' => 'erik@gmail.com',
                'jurusan' => 'Teknik Industri'
            ]
        );
        mahasiswa::create(
            [
                'nrp' => '043040321',
                'nama' => 'Rommy Fauzi',
                'email' => 'rommy@gmail.com',
                'jurusan' => 'Teknik Planologi'
            ]
        );
        mahasiswa::create(
            [
                'nrp' => '033040023',
                'nama' => 'Fajar Darmawan',
                'email' => 'fajar@yahoo.com',
                'jurusan' => 'Teknik Informatika'
            ]
        );
        mahasiswa::create(
            [
                'nrp' => '113040321',
                'nama' => 'Ferry Mulyanto',
                'email' => 'ferry@yahoo.com',
                'jurusan' => 'Manajemen'
            ]
        );
        // keys::create(
        //     [
        //         'user_id' => 1,
        //         'key' => 'overcast',
        //     ]
        // );

        User::create(
            [
                'name' => 'amirul',
                'email' => 'amirul@gmail.com',
                'password' => '$2y$10$VVV8dnw.ikykhh.mdEqROOwbJQlfGdXhWMlbOBeAlaX3OYcyQzaju',
            ]
        );
    }
}
