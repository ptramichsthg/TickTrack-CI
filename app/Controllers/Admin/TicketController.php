<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\TicketReplyModel;
use App\Models\CategoryModel;
use App\Models\AttachmentModel;

class TicketController extends BaseController
{
    protected $ticketModel;
    protected $replyModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->ticketModel   = new TicketModel();
        $this->replyModel    = new TicketReplyModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $filters = [
            'status'      => $this->request->getGet('status'),
            'priority'    => $this->request->getGet('priority'),
            'category_id' => $this->request->getGet('category_id'),
            'search'      => $this->request->getGet('search'),
        ];

        $tickets    = $this->ticketModel->getTicketsWithRelations($filters, 15);
        $pager      = $this->ticketModel->pager;
        $categories = $this->categoryModel->getActiveCategories();

        return view('admin/tickets/index', [
            'title'      => 'Kelola Tiket — TickTrack',
            'pageTitle'  => 'Kelola Tiket',
            'tickets'    => $tickets,
            'pager'      => $pager,
            'filters'    => $filters,
            'categories' => $categories,
        ]);
    }

    public function show($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);
        if (!$ticket) return redirect()->to('/admin/tickets')->with('error', 'Tiket tidak ditemukan.');

        $replies     = $this->replyModel->getRepliesByTicket($ticket['id']);
        $attachments = model(AttachmentModel::class)->getByTicket($ticket['id']);

        return view('admin/tickets/show', [
            'title'       => '#' . $ticket['code'] . ' — Admin',
            'pageTitle'   => 'Detail Tiket',
            'ticket'      => $ticket,
            'replies'     => $replies,
            'attachments' => $attachments,
        ]);
    }

    public function updateStatus($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);
        if (!$ticket) return redirect()->to('/admin/tickets')->with('error', 'Tiket tidak ditemukan.');

        $newStatus = $this->request->getPost('status');
        if (!in_array($newStatus, ['open', 'in_progress', 'resolved', 'rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->ticketModel->update($ticket['id'], ['status' => $newStatus]);

        // Notify User
        if ($ticket['status'] !== $newStatus) {
            $notifModel = new \App\Models\NotificationModel();
            $notifModel->insert([
                'user_id' => $ticket['user_id'],
                'type' => $newStatus === 'resolved' ? 'ticket_resolved' : 'ticket_status',
                'title' => 'Status Tiket Diperbarui',
                'message' => 'Status tiket #' . $ticket['code'] . ' diubah menjadi ' . ucfirst(str_replace('_', ' ', $newStatus))
            ]);
        }

        return redirect()->to('/admin/tickets/' . $code)->with('success', 'Status tiket berhasil diubah.');
    }

    public function reply($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);
        if (!$ticket) return redirect()->to('/admin/tickets')->with('error', 'Tiket tidak ditemukan.');

        if (!$this->validate(['message' => 'required|min_length[3]'])) {
            return redirect()->back()->with('error', 'Pesan balasan minimal 3 karakter.');
        }

        $this->replyModel->insert([
            'ticket_id' => $ticket['id'],
            'user_id'   => session('user_id'),
            'message'   => $this->request->getPost('message'),
        ]);

        // Notify User
        $notifModel = new \App\Models\NotificationModel();
        $notifModel->insert([
            'user_id' => $ticket['user_id'],
            'type' => 'ticket_reply',
            'title' => 'Balasan Baru dari Admin',
            'message' => 'Admin telah membalas tiket #' . $ticket['code']
        ]);

        return redirect()->to('/admin/tickets/' . $code)->with('success', 'Balasan berhasil dikirim.');
    }

    public function delete($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);
        if (!$ticket) return redirect()->to('/admin/tickets')->with('error', 'Tiket tidak ditemukan.');

        $this->ticketModel->delete($ticket['id']);
        return redirect()->to('/admin/tickets')->with('success', 'Tiket berhasil dihapus.');
    }
}
