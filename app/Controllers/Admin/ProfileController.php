<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = $this->userModel->find(session('user_id'));

        return view('admin/profile', [
            'title'     => 'Profil Saya — TickTrack Admin',
            'pageTitle' => 'Profil Saya',
            'user'      => $user,
        ]);
    }

    public function update()
    {
        $userId = session('user_id');
        $rules = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        if ($this->request->getPost('new_password')) {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'min_length[6]';
            $rules['new_password_confirmation'] = 'matches[new_password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find($userId);

        if ($this->request->getPost('new_password')) {
            if (!$this->userModel->verifyPassword($this->request->getPost('current_password'), $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Password saat ini tidak cocok.');
            }
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // Handle Avatar Upload
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array(strtolower($avatarFile->getClientExtension()), $allowedTypes)) {
                return redirect()->back()->withInput()->with('error', 'Format foto profil hanya boleh JPG, PNG, atau GIF.');
            }
            if ($avatarFile->getSize() > (2 * 1024 * 1024)) {
                return redirect()->back()->withInput()->with('error', 'Ukuran foto maksimal 2MB.');
            }

            $newName = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads/avatars', $newName);
            
            // Hapus foto lama jika ada
            $userRecord = $this->userModel->find($userId);
            if (!empty($userRecord['avatar']) && file_exists(FCPATH . $userRecord['avatar'])) {
                unlink(FCPATH . $userRecord['avatar']);
            }
            
            $data['avatar'] = 'uploads/avatars/' . $newName;
            $this->session->set('user_avatar', $data['avatar']);
        }

        if ($this->request->getPost('new_password')) {
            $data['password'] = $this->userModel->hashPassword($this->request->getPost('new_password'));
        }

        $this->userModel->update($userId, $data);

        // Update session
        $this->session->set([
            'user_name'  => $data['name'],
            'user_email' => $data['email'],
        ]);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
