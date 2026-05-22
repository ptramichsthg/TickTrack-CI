<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $userModel   = new UserModel();

        $stats = $ticketModel->getStatistics();
        $stats['total_users'] = $userModel->where('role', 'user')->countAllResults();

        $recentTickets = $ticketModel
            ->select('tickets.*, users.name as user_name, categories.name as category_name, categories.color as category_color')
            ->join('users', 'users.id = tickets.user_id', 'left')
            ->join('categories', 'categories.id = tickets.category_id', 'left')
            ->orderBy('tickets.created_at', 'DESC')
            ->findAll(5);

        return view('admin/dashboard', [
            'title'         => 'Admin Dashboard — TickTrack',
            'pageTitle'     => 'Dashboard',
            'stats'         => $stats,
            'recentTickets' => $recentTickets,
        ]);
    }
}
