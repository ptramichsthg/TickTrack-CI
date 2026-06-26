<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TicketModel;

/**
 * REST API Controller untuk resource Tickets.
 *
 * Endpoint:
 *   GET    /api/tickets          → index()
 *   GET    /api/tickets/{id}     → show($id)
 *   POST   /api/tickets          → create()
 *   PUT    /api/tickets/{id}     → update($id)
 *   DELETE /api/tickets/{id}     → delete($id)
 */
class Tickets extends ResourceController
{
    protected $modelName = TicketModel::class;
    protected $format    = 'json';

    /**
     * GET /api/tickets
     * Menampilkan seluruh data tiket beserta relasi user dan kategori.
     * Mendukung query parameter: status, priority, category_id, search.
     */
    public function index()
    {
        $filters = [
            'status'      => $this->request->getGet('status'),
            'priority'    => $this->request->getGet('priority'),
            'category_id' => $this->request->getGet('category_id'),
            'search'      => $this->request->getGet('search'),
        ];

        // Gunakan method relasi yang sudah ada di model
        $builder = $this->model
            ->select('tickets.*, users.name as user_name, users.email as user_email, categories.name as category_name, categories.color as category_color')
            ->join('users', 'users.id = tickets.user_id', 'left')
            ->join('categories', 'categories.id = tickets.category_id', 'left');

        if (!empty($filters['status'])) {
            $builder->where('tickets.status', $filters['status']);
        }
        if (!empty($filters['priority'])) {
            $builder->where('tickets.priority', $filters['priority']);
        }
        if (!empty($filters['category_id'])) {
            $builder->where('tickets.category_id', $filters['category_id']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('tickets.title', $filters['search'])
                ->orLike('tickets.code', $filters['search'])
                ->orLike('tickets.description', $filters['search'])
                ->groupEnd();
        }

        $tickets = $builder->orderBy('tickets.created_at', 'DESC')->findAll();

        return $this->respond([
            'status'  => 'success',
            'message' => 'Data tiket berhasil diambil.',
            'total'   => count($tickets),
            'data'    => $tickets,
        ]);
    }

    /**
     * GET /api/tickets/{id}
     * Menampilkan detail tiket berdasarkan ID, termasuk relasi user dan kategori.
     */
    public function show($id = null)
    {
        $ticket = $this->model
            ->select('tickets.*, users.name as user_name, users.email as user_email, categories.name as category_name, categories.color as category_color')
            ->join('users', 'users.id = tickets.user_id', 'left')
            ->join('categories', 'categories.id = tickets.category_id', 'left')
            ->find($id);

        if (!$ticket) {
            return $this->failNotFound('Tiket dengan ID ' . $id . ' tidak ditemukan.');
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Detail tiket berhasil diambil.',
            'data'    => $ticket,
        ]);
    }

    /**
     * POST /api/tickets
     * Membuat tiket baru. Kode tiket di-generate otomatis.
     */
    public function create()
    {
        $rules = [
            'user_id'     => 'required|is_not_unique[users.id]',
            'category_id' => 'required|is_not_unique[categories.id]',
            'title'       => 'required|min_length[5]|max_length[255]',
            'description' => 'required|min_length[10]',
            'priority'    => 'required|in_list[low,medium,high,urgent]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'code'        => $this->model->generateCode(),
            'user_id'     => $this->request->getVar('user_id'),
            'category_id' => $this->request->getVar('category_id'),
            'title'       => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'priority'    => $this->request->getVar('priority'),
            'status'      => 'open',
        ];

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->failServerError('Gagal menyimpan data tiket.');
        }

        $ticket = $this->model->find($id);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Tiket berhasil dibuat dengan kode ' . $data['code'] . '.',
            'data'    => $ticket,
        ]);
    }

    /**
     * PUT /api/tickets/{id}
     * Memperbarui data tiket berdasarkan ID.
     */
    public function update($id = null)
    {
        $ticket = $this->model->find($id);
        if (!$ticket) {
            return $this->failNotFound('Tiket dengan ID ' . $id . ' tidak ditemukan.');
        }

        $rules = [
            'title'       => 'permit_empty|min_length[5]|max_length[255]',
            'description' => 'permit_empty|min_length[10]',
            'priority'    => 'permit_empty|in_list[low,medium,high,urgent]',
            'status'      => 'permit_empty|in_list[open,in_progress,resolved,rejected]',
            'category_id' => 'permit_empty|is_not_unique[categories.id]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [];
        $fields = ['title', 'description', 'priority', 'status', 'category_id'];
        foreach ($fields as $field) {
            $value = $this->request->getVar($field);
            if ($value !== null) {
                $data[$field] = $value;
            }
        }

        if (empty($data)) {
            return $this->fail('Tidak ada data yang dikirim untuk diperbarui.', 400);
        }

        $this->model->update($id, $data);

        $updatedTicket = $this->model->find($id);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Tiket berhasil diperbarui.',
            'data'    => $updatedTicket,
        ]);
    }

    /**
     * DELETE /api/tickets/{id}
     * Menghapus tiket berdasarkan ID.
     */
    public function delete($id = null)
    {
        $ticket = $this->model->find($id);
        if (!$ticket) {
            return $this->failNotFound('Tiket dengan ID ' . $id . ' tidak ditemukan.');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Tiket dengan ID ' . $id . ' (Kode: ' . $ticket['code'] . ') berhasil dihapus.',
        ]);
    }
}
