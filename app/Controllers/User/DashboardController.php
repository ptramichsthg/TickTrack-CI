<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\TicketModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $userId = $this->session->get('user_id');

        $stats = $ticketModel->getUserStatistics($userId);

        // Tiket terbaru (5 terakhir)
        $recentTickets = $ticketModel
            ->select('tickets.*, categories.name as category_name, categories.color as category_color')
            ->join('categories', 'categories.id = tickets.category_id', 'left')
            ->where('tickets.user_id', $userId)
            ->orderBy('tickets.created_at', 'DESC')
            ->findAll(5);

        return view('user/dashboard', [
            'title'         => 'Dashboard — TickTrack',
            'pageTitle'     => 'Dashboard',
            'stats'         => $stats,
            'recentTickets' => $recentTickets,
        ]);
    }
}
