<?php

use App\Models\User;

test('halaman login dapat dibuka', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('admin berhasil login dan diarahkan ke dashboard admin', function () {
    $admin = User::factory()->admin()->create([
        'password' => 'password123',
    ]);

    $response = $this->post('/login', [
        'username' => $admin->username,
        'password' => 'password123',
        'role'     => 'admin',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard.admin'));
});

test('petugas berhasil login dan diarahkan ke dashboard petugas', function () {
    $petugas = User::factory()->create([
        'password' => 'password123',
    ]);

    $response = $this->post('/login', [
        'username' => $petugas->username,
        'password' => 'password123',
        'role'     => 'petugas',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard.petugas'));
});

test('login gagal jika password salah', function () {
    $user = User::factory()->create([
        'password' => 'password123',
    ]);

    $response = $this->post('/login', [
        'username' => $user->username,
        'password' => 'password-salah',
        'role'     => 'petugas',
    ]);

    $this->assertGuest();
});

test('login gagal jika role tidak sesuai', function () {
    $user = User::factory()->create([
        'password' => 'password123',
        'role'     => 'petugas',
    ]);

    $response = $this->post('/login', [
        'username' => $user->username,
        'password' => 'password123',
        'role'     => 'admin',
    ]);

    $this->assertGuest();
});

test('pengguna dapat logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/login');
});
