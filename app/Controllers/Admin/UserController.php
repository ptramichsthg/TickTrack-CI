<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $builder = $this->userModel->orderBy('created_at', 'DESC');

        if ($search) {
            $builder->groupStart()->like('name', $search)->orLike('email', $search)->groupEnd();
        }

        return view('admin/users/index', [
            'title'     => 'Manajemen User — TickTrack',
            'pageTitle' => 'Manajemen Pengguna',
            'users'     => $builder->paginate(15),
            'pager'     => $this->userModel->pager,
            'search'    => $search,
        ]);
    }

    public function create()
    {
        return view('admin/users/create', [
            'title'    => 'Tambah User — TickTrack',
            'pageTitle' => 'Tambah Pengguna',
        ]);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,user]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->userModel->hashPassword($this->request->getPost('password')),
            'role'     => $this->request->getPost('role'),
            'phone'    => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');

        return view('admin/users/edit', [
            'title'    => 'Edit User — TickTrack',
            'pageTitle' => 'Edit Pengguna',
            'user'     => $user,
        ]);
    }

    public function update($id)
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'required|in_list[admin,user]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'phone'     => $this->request->getPost('phone'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->userModel->hashPassword($this->request->getPost('password'));
        }

        $this->userModel->update($id, $data);
        return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($id == session('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
