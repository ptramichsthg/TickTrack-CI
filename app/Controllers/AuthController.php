<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ── Halaman Login ──
    public function login()
    {
        return view('auth/login', [
            'title' => 'Login — TickTrack',
        ]);
    }

    // ── Proses Login ──
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        if (!$user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        // Set session
        $this->session->set([
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'user_email'=> $user['email'],
            'user_role' => $user['role'],
            'is_logged_in' => true,
        ]);

        // Redirect sesuai role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $user['name'] . '!');
        }

        return redirect()->to('/user/dashboard')->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    // ── Halaman Register ──
    public function register()
    {
        return view('auth/register', [
            'title' => 'Register — TickTrack',
        ]);
    }

    // ── Proses Register ──
    public function attemptRegister()
    {
        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Email sudah terdaftar.',
            ],
            'password_confirm' => [
                'matches' => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->userModel->hashPassword($this->request->getPost('password')),
            'role'     => 'user',
        ];

        $this->userModel->insert($userData);
        $userId = $this->userModel->getInsertID();

        // Auto-login setelah register
        $this->session->set([
            'user_id'      => $userId,
            'user_name'    => $userData['name'],
            'user_email'   => $userData['email'],
            'user_role'    => 'user',
            'is_logged_in' => true,
        ]);

        return redirect()->to('/user/dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $userData['name'] . '!');
    }

    // ── Logout ──
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/')->with('success', 'Anda berhasil logout.');
    }
}
