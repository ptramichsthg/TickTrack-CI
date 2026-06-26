<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingController extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $settings = $this->settingModel->getAllSettings();

        return view('admin/settings/index', [
            'title'     => 'Pengaturan Sistem — TickTrack Admin',
            'pageTitle' => 'Pengaturan Sistem',
            'settings'  => $settings,
        ]);
    }

    public function save()
    {
        // Validasi minimal
        $rules = [
            'app_name'      => 'required|min_length[3]|max_length[100]',
            'support_email' => 'required|valid_email',
            'ticket_prefix' => 'required|max_length[10]',
            'auto_close_days' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->settingModel->saveMany([
            'app_name'         => $this->request->getPost('app_name'),
            'support_email'    => $this->request->getPost('support_email'),
            'ticket_prefix'    => strtoupper($this->request->getPost('ticket_prefix')),
            'default_priority' => $this->request->getPost('default_priority'),
            'auto_close_days'  => $this->request->getPost('auto_close_days'),
            'auto_assign'      => $this->request->getPost('auto_assign') ? '1' : '0',
            'email_notif'      => $this->request->getPost('email_notif') ? '1' : '0',
            'slack_notif'      => $this->request->getPost('slack_notif') ? '1' : '0',
            'maintenance_mode' => $this->request->getPost('maintenance_mode') ? '1' : '0',
        ]);

        return redirect()->to('/admin/settings')->with('success', 'Pengaturan berhasil disimpan!');
    }
}
