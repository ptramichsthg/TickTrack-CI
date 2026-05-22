<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationAPIController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function fetch()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $unreadCount = $this->notificationModel->getUnreadCount($userId);
        $notifications = $this->notificationModel->getRecentNotifications($userId, 5);

        return $this->response->setJSON([
            'status' => 'success',
            'unread_count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead()
    {
        $userId = session('user_id');
        if (!$userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $this->notificationModel->markAsRead($userId);

        return $this->response->setJSON(['status' => 'success']);
    }
}
