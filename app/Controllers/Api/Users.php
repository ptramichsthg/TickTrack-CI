<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

/**
 * REST API Controller untuk resource Users.
 *
 * Endpoint:
 *   GET    /api/users          → index()
 *   GET    /api/users/{id}     → show($id)
 *   POST   /api/users          → create()
 *   PUT    /api/users/{id}     → update($id)
 *   DELETE /api/users/{id}     → delete($id)
 */
class Users extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

    /**
     * GET /api/users
     * Menampilkan seluruh data pengguna.
     */
    public function index()
    {
        $users = $this->model->orderBy('created_at', 'DESC')->findAll();

        // Hapus field password dari response untuk keamanan
        $users = array_map(function ($user) {
            unset($user['password'], $user['reset_token'], $user['reset_expires']);
            return $user;
        }, $users);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Data pengguna berhasil diambil.',
            'data'    => $users,
        ]);
    }

    /**
     * GET /api/users/{id}
     * Menampilkan detail pengguna berdasarkan ID.
     */
    public function show($id = null)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return $this->failNotFound('Pengguna dengan ID ' . $id . ' tidak ditemukan.');
        }

        unset($user['password'], $user['reset_token'], $user['reset_expires']);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Detail pengguna berhasil diambil.',
            'data'    => $user,
        ]);
    }

    /**
     * POST /api/users
     * Membuat pengguna baru.
     */
    public function create()
    {
        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'permit_empty|in_list[admin,user]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => $this->model->hashPassword($this->request->getVar('password')),
            'role'     => $this->request->getVar('role') ?? 'user',
            'phone'    => $this->request->getVar('phone'),
        ];

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->failServerError('Gagal menyimpan data pengguna.');
        }

        $user = $this->model->find($id);
        unset($user['password'], $user['reset_token'], $user['reset_expires']);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Pengguna berhasil ditambahkan.',
            'data'    => $user,
        ]);
    }

    /**
     * PUT /api/users/{id}
     * Memperbarui data pengguna berdasarkan ID.
     */
    public function update($id = null)
    {
        $user = $this->model->find($id);
        if (!$user) {
            return $this->failNotFound('Pengguna dengan ID ' . $id . ' tidak ditemukan.');
        }

        $rules = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'permit_empty|in_list[admin,user]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'role'  => $this->request->getVar('role') ?? $user['role'],
            'phone' => $this->request->getVar('phone') ?? $user['phone'],
        ];

        // Jika password dikirim, update juga passwordnya
        $password = $this->request->getVar('password');
        if (!empty($password)) {
            $data['password'] = $this->model->hashPassword($password);
        }

        $this->model->update($id, $data);

        $updatedUser = $this->model->find($id);
        unset($updatedUser['password'], $updatedUser['reset_token'], $updatedUser['reset_expires']);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Pengguna berhasil diperbarui.',
            'data'    => $updatedUser,
        ]);
    }

    /**
     * DELETE /api/users/{id}
     * Menghapus pengguna berdasarkan ID.
     */
    public function delete($id = null)
    {
        $user = $this->model->find($id);
        if (!$user) {
            return $this->failNotFound('Pengguna dengan ID ' . $id . ' tidak ditemukan.');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Pengguna dengan ID ' . $id . ' berhasil dihapus.',
        ]);
    }
}
