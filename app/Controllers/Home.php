<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if ($this->session->get('user_id')) {
            $role = $this->session->get('user_role');
            return redirect()->to($role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        return view('landing');
    }

    /**
     * Halaman About Us — Profil anggota kelompok dan deskripsi proyek.
     */
    public function about()
    {
        return view('about');
    }
}
