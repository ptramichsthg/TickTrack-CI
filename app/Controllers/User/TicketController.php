<?php

namespace App\Controllers\User;

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
    protected $attachmentModel;

    public function __construct()
    {
        $this->ticketModel     = new TicketModel();
        $this->replyModel      = new TicketReplyModel();
        $this->categoryModel   = new CategoryModel();
        $this->attachmentModel = new AttachmentModel();
    }

    // ── Daftar tiket milik user ──
    public function index()
    {
        $userId  = session('user_id');
        $filters = [
            'user_id'  => $userId,
            'status'   => $this->request->getGet('status'),
            'priority' => $this->request->getGet('priority'),
            'search'   => $this->request->getGet('search'),
        ];

        $tickets = $this->ticketModel->getTicketsWithRelations($filters, 10);
        $pager   = $this->ticketModel->pager;

        return view('user/tickets/index', [
            'title'     => 'Tiket Saya — TickTrack',
            'pageTitle' => 'Tiket Saya',
            'tickets'   => $tickets,
            'pager'     => $pager,
            'filters'   => $filters,
        ]);
    }

    // ── Form buat tiket ──
    public function create()
    {
        $categories = $this->categoryModel->getActiveCategories();

        return view('user/tickets/create', [
            'title'      => 'Buat Tiket — TickTrack',
            'pageTitle'  => 'Buat Tiket Baru',
            'categories' => $categories,
        ]);
    }

    // ── Simpan tiket baru ──
    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[5]|max_length[255]',
            'description' => 'required|min_length[10]',
            'priority'    => 'required|in_list[low,medium,high,urgent]',
            'category_id' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $ticketData = [
            'code'        => $this->ticketModel->generateCode(),
            'user_id'     => session('user_id'),
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority'    => $this->request->getPost('priority'),
            'status'      => 'open',
        ];

        $this->ticketModel->insert($ticketData);
        $ticketId = $this->ticketModel->getInsertID();

        // Handle file upload
        $file = $this->request->getFile('attachment');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // ✅ VALIDASI FILE: tipe & ukuran
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'txt'];
            $maxSizeMB    = 2;

            if (!in_array(strtolower($file->getClientExtension()), $allowedTypes)) {
                return redirect()->back()->withInput()
                    ->with('errors', ['attachment' => 'Tipe file tidak diizinkan. Hanya: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, ZIP, TXT.']);
            }

            if ($file->getSize() > ($maxSizeMB * 1024 * 1024)) {
                return redirect()->back()->withInput()
                    ->with('errors', ['attachment' => "Ukuran file terlalu besar. Maksimal {$maxSizeMB}MB."]);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/tickets', $newName);

            $this->attachmentModel->insert([
                'ticket_id'   => $ticketId,
                'file_name'   => $file->getClientName(),
                'file_path'   => 'uploads/tickets/' . $newName,
                'file_type'   => $file->getClientMimeType(),
                'file_size'   => $file->getSize(),
                'uploaded_by' => session('user_id'),
            ]);
        }


        // Notify Admins
        $userModel = new \App\Models\UserModel();
        $admins = $userModel->where('role', 'admin')->findAll();
        $notifModel = new \App\Models\NotificationModel();
        foreach ($admins as $admin) {
            $notifModel->insert([
                'user_id' => $admin['id'],
                'type' => 'ticket_created',
                'title' => 'Tiket Baru: #' . $ticketData['code'],
                'message' => session('user_name') . ' membuat tiket baru: ' . $ticketData['title']
            ]);
        }

        return redirect()->to('/user/tickets/' . $ticketData['code'])
            ->with('success', 'Tiket berhasil dibuat dengan kode: ' . $ticketData['code']);
    }

    // ── Detail tiket ──
    public function show($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);

        if (!$ticket || $ticket['user_id'] != session('user_id')) {
            return redirect()->to('/user/tickets')->with('error', 'Tiket tidak ditemukan.');
        }

        $replies     = $this->replyModel->getRepliesByTicket($ticket['id']);
        $attachments = $this->attachmentModel->getByTicket($ticket['id']);

        return view('user/tickets/show', [
            'title'       => '#' . $ticket['code'] . ' — TickTrack',
            'pageTitle'   => 'Detail Tiket',
            'ticket'      => $ticket,
            'replies'     => $replies,
            'attachments' => $attachments,
        ]);
    }

    // ── Kirim reply ──
    public function reply($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);

        if (!$ticket || $ticket['user_id'] != session('user_id')) {
            return redirect()->to('/user/tickets')->with('error', 'Tiket tidak ditemukan.');
        }

        if (!$this->validate(['message' => 'required|min_length[3]'])) {
            return redirect()->back()->with('error', 'Pesan balasan minimal 3 karakter.');
        }

        $this->replyModel->insert([
            'ticket_id' => $ticket['id'],
            'user_id'   => session('user_id'),
            'message'   => $this->request->getPost('message'),
        ]);

        // Handle attachment on reply
        $file = $this->request->getFile('attachment');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // ✅ VALIDASI FILE: tipe & ukuran
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'txt'];
            $maxSizeMB    = 2;

            if (!in_array(strtolower($file->getClientExtension()), $allowedTypes)) {
                return redirect()->back()
                    ->with('error', 'Tipe file tidak diizinkan. Hanya: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, ZIP, TXT.');
            }

            if ($file->getSize() > ($maxSizeMB * 1024 * 1024)) {
                return redirect()->back()
                    ->with('error', "Ukuran file terlalu besar. Maksimal {$maxSizeMB}MB.");
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/tickets', $newName);

            $this->attachmentModel->insert([
                'ticket_id'   => $ticket['id'],
                'reply_id'    => $this->replyModel->getInsertID(),
                'file_name'   => $file->getClientName(),
                'file_path'   => 'uploads/tickets/' . $newName,
                'file_type'   => $file->getClientMimeType(),
                'file_size'   => $file->getSize(),
                'uploaded_by' => session('user_id'),
            ]);
        }

        return redirect()->to('/user/tickets/' . $code)->with('success', 'Balasan berhasil dikirim.');
    }

    // ── Update Status (Self-Service Close Ticket) ──
    public function updateStatus($code)
    {
        $ticket = $this->ticketModel->getTicketByCode($code);

        // Hanya tiket milik user ini yang bisa diubah
        if (!$ticket || $ticket['user_id'] != session('user_id')) {
            return redirect()->to('/user/tickets')->with('error', 'Tiket tidak ditemukan.');
        }

        // Klien hanya diperbolehkan mengubah status menjadi 'resolved' (menyelesaikan tiket)
        $newStatus = $this->request->getPost('status');
        if ($newStatus !== 'resolved') {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        // Jangan lakukan update jika sudah diselesaikan
        if ($ticket['status'] === 'resolved') {
            return redirect()->back()->with('error', 'Tiket ini sudah diselesaikan.');
        }

        $this->ticketModel->update($ticket['id'], ['status' => 'resolved']);

        // Notify Admins
        $userModel = new \App\Models\UserModel();
        $admins = $userModel->where('role', 'admin')->findAll();
        $notifModel = new \App\Models\NotificationModel();
        foreach ($admins as $admin) {
            $notifModel->insert([
                'user_id' => $admin['id'],
                'type' => 'ticket_resolved',
                'title' => 'Tiket Diselesaikan Klien',
                'message' => session('user_name') . ' telah menyelesaikan tiket #' . $ticket['code'] . ' secara mandiri.'
            ]);
        }

        return redirect()->to('/user/tickets/' . $code)->with('success', 'Terima kasih, tiket telah ditandai sebagai selesai.');
    }
}

