<?php

namespace App\Controllers\User;

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
        
        $db = \Config\Database::connect();
        
        $totalTickets = $db->table('tickets')->where('user_id', $user['id'])->countAllResults();
        $resolvedTickets = $db->table('tickets')->where('user_id', $user['id'])->where('status', 'resolved')->countAllResults();
        $pendingTickets = $db->table('tickets')->where('user_id', $user['id'])->whereIn('status', ['open', 'in_progress'])->countAllResults();

        return view('user/profile', [
            'title'     => 'Profil — TickTrack',
            'pageTitle' => 'Profil Saya',
            'user'      => $user,
            'stats'     => [
                'total'    => $totalTickets,
                'resolved' => $resolvedTickets,
                'pending'  => $pendingTickets,
            ]
        ]);
    }

    public function update()
    {
        $userId = session('user_id');
        $rules = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'phone' => 'permit_empty|max_length[20]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password']         = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->userModel->hashPassword($this->request->getPost('password'));
        }

        $this->userModel->update($userId, $data);

        // Update session
        $this->session->set([
            'user_name'  => $data['name'],
            'user_email' => $data['email'],
        ]);

        return redirect()->to('/user/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
