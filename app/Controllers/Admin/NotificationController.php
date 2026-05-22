<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        $userId = session('user_id');

        // Mark all as read when admin opens the notification page
        $this->notificationModel->markAsRead($userId);

        // Fetch notifications
        $notifications = $this->notificationModel->where('user_id', $userId)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll();

        return view('admin/notifications', [
            'title'         => 'Notifikasi — TickTrack Admin',
            'pageTitle'     => 'Notifikasi',
            'notifications' => $notifications,
        ]);
    }
}
