<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SettingController extends BaseController
{
    public function index()
    {
        // For demonstration, settings are mocked as in the Vue app
        return view('admin/settings/index', [
            'title'     => 'Pengaturan Sistem — TickTrack Admin',
            'pageTitle' => 'Pengaturan Sistem',
        ]);
    }
}
