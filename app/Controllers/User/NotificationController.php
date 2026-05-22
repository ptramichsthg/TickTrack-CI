<?php

namespace App\Controllers\User;

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

        // Mark all as read when user opens the notification page
        $this->notificationModel->markAsRead($userId);

        // Fetch notifications
        $notifications = $this->notificationModel->where('user_id', $userId)
                                                 ->orderBy('created_at', 'DESC')
                                                 ->findAll();

        return view('user/notifications', [
            'title' => 'Notifikasi — TickTrack',
            'pageTitle' => 'Pusat Notifikasi',
            'notifications' => $notifications
        ]);
    }
}
