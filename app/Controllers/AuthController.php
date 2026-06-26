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
            'user_id'     => $user['id'],
            'user_name'   => $user['name'],
            'user_email'  => $user['email'],
            'user_role'   => $user['role'],
            'user_avatar' => $user['avatar'] ?? null,
            'is_logged_in'=> true,
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

        return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    // ── Halaman Lupa Password ──
    public function forgotPassword()
    {
        return view('auth/forgot_password', [
            'title' => 'Lupa Password — TickTrack',
        ]);
    }

    // ── Proses Kirim Token Reset ──
    public function processForgotPassword()
    {
        if (!$this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->withInput()->with('error', 'Masukkan email yang valid.');
        }

        $email = $this->request->getPost('email');
        $user  = $this->userModel->where('email', $email)->first();

        // Selalu tampilkan pesan sukses (hindari enumerasi email)
        if (!$user) {
            return redirect()->to('/auth/forgot-password')
                ->with('success', 'Jika email terdaftar, link reset telah dikirim. Silakan periksa inbox Anda.');
        }

        // Generate token & expired 1 jam
        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->userModel->update($user['id'], [
            'reset_token'   => hash('sha256', $token),
            'reset_expires' => $expires,
        ]);

        // Kirim link reset (simulasi: tampilkan di halaman, di produksi pakai email)
        $resetLink = base_url('auth/reset-password/' . $token);

        // Untuk lingkungan development — simpan link ke session agar bisa dilihat
        return redirect()->to('/auth/forgot-password')
            ->with('reset_link', $resetLink)
            ->with('success', 'Link reset password berhasil dibuat! (Development: lihat link di bawah)');
    }

    // ── Halaman Reset Password ──
    public function resetPassword($token = null)
    {
        if (!$token) return redirect()->to('/auth/forgot-password')->with('error', 'Token tidak valid.');

        $hashedToken = hash('sha256', $token);
        $user = $this->userModel
            ->where('reset_token', $hashedToken)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('/auth/forgot-password')
                ->with('error', 'Link reset tidak valid atau sudah kadaluarsa. Minta link baru.');
        }

        return view('auth/reset_password', [
            'title' => 'Reset Password — TickTrack',
            'token' => $token,
        ]);
    }

    // ── Proses Reset Password ──
    public function processResetPassword()
    {
        $token = $this->request->getPost('token');
        $rules = [
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $hashedToken = hash('sha256', $token);
        $user = $this->userModel
            ->where('reset_token', $hashedToken)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('/auth/forgot-password')
                ->with('error', 'Token tidak valid atau sudah kadaluarsa.');
        }

        // Update password & hapus token
        $this->userModel->update($user['id'], [
            'password'      => $this->userModel->hashPassword($this->request->getPost('password')),
            'reset_token'   => null,
            'reset_expires' => null,
        ]);

        return redirect()->to('/auth/login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }

    // ── Logout ──

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/')->with('success', 'Anda berhasil logout.');
    }
}
