<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
    [
        'name' => 'Sugeng Hariyanto',
        'username' => 'admin',
        'password' => '123456',
        'role' => 'admin',
        'job' => 'Admin/pengelolah Tempat'
    ],
    [
        'name' => 'Zaenal Abidin',
        'username' => 'petugas1',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Parkir'
    ],
    [
        'name' => 'Sujito',
        'username' => 'petugas2',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Parkir'
    ],
    [
        'name' => 'Tangguh Yudhanto',
        'username' => 'petugas3',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Parkir'
    ],
    [
        'name' => 'Suparman',
        'username' => 'petugas4',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Parkir'
    ],
    [
        'name' => 'Sugeng Prayitno',
        'username' => 'petugas5',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Keamanan/Security'
    ],
    [
        'name' => 'Budi Lukisan',
        'username' => 'petugas6',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Loket Retribusi'
    ],
    [
        'name' => 'Rizal Agung',
        'username' => 'petugas7',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Loket Retribusi'
    ],
    [
        'name' => 'Wardoyo',
        'username' => 'petugas8',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Parkir'
    ],
    [
        'name' => 'Darmaji',
        'username' => 'petugas9',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Keamanan/Security'
    ],
    [
        'name' => 'Ah. Fatih Syarul M',
        'username' => 'petugas10',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Loket Retribusi'
    ],
    [
        'name' => 'Rahmat Puji Cahyono',
        'username' => 'petugas11',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Loket Retribusi'
    ],
    [
        'name' => 'Hadi Suyatno',
        'username' => 'petugas12',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Keamanan/Security'
    ],
    [
        'name' => 'Abdul Hanif',
        'username' => 'petugas13',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kelistrikan'
    ],
    [
        'name' => 'Zainal Abidin',
        'username' => 'petugas14',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kebersihan'
    ],
    [
        'name' => 'Misbahul Islam',
        'username' => 'petugas15',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kebersihan'
    ],
    [
        'name' => 'Wildan',
        'username' => 'petugas16',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kebersihan'
    ],
    [
        'name' => 'Moh Erfan',
        'username' => 'petugas17',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kebersihan'
    ],
    [
        'name' => 'Sutomo',
        'username' => 'petugas18',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kebersihan'
    ],
    [
        'name' => 'Suhartin',
        'username' => 'petugas19',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Museum'
    ],
    [
        'name' => 'Luluk Masmudah',
        'username' => 'petugas20',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Museum'
    ],
    [
        'name' => 'Khoirotun Nikmah',
        'username' => 'petugas21',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Museum'
    ],
    [
        'name' => 'Hasan Muktar',
        'username' => 'petugas22',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kios'
    ],
    [
        'name' => 'Moh. Sholeh',
        'username' => 'petugas23',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kios'
    ],
    [
        'name' => 'Nur Akib',
        'username' => 'petugas24',
        'password' => '123456',
        'role' => 'petugas',
        'job' => 'Petugas Pengelolah Kios'
    ]
];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
