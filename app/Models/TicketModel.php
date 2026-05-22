<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'code', 'user_id', 'category_id', 'title', 'description',
        'status', 'priority',
    ];

    protected $validationRules = [
        'title'       => 'required|min_length[5]|max_length[255]',
        'description' => 'required|min_length[10]',
        'priority'    => 'required|in_list[low,medium,high,urgent]',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'Judul tiket wajib diisi.',
            'min_length' => 'Judul minimal 5 karakter.',
        ],
        'description' => [
            'required'   => 'Deskripsi wajib diisi.',
            'min_length' => 'Deskripsi minimal 10 karakter.',
        ],
    ];

    // ── Generate kode tiket unik ──
    public function generateCode(): string
    {
        $last = $this->orderBy('id', 'DESC')->first();
        $nextId = $last ? ($last['id'] + 1) : 1;
        return 'TK-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    // ── Ambil tiket + relasi user & kategori ──
    public function getTicketsWithRelations(array $filters = [], int $perPage = 10)
    {
        $builder = $this->select('tickets.*, users.name as user_name, users.email as user_email, categories.name as category_name, categories.color as category_color')
            ->join('users', 'users.id = tickets.user_id', 'left')
            ->join('categories', 'categories.id = tickets.category_id', 'left');

        // Filter: status
        if (!empty($filters['status'])) {
            $builder->where('tickets.status', $filters['status']);
        }

        // Filter: priority
        if (!empty($filters['priority'])) {
            $builder->where('tickets.priority', $filters['priority']);
        }

        // Filter: category
        if (!empty($filters['category_id'])) {
            $builder->where('tickets.category_id', $filters['category_id']);
        }

        // Filter: user (untuk user biasa)
        if (!empty($filters['user_id'])) {
            $builder->where('tickets.user_id', $filters['user_id']);
        }

        // Filter: search
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('tickets.title', $filters['search'])
                ->orLike('tickets.code', $filters['search'])
                ->orLike('tickets.description', $filters['search'])
                ->groupEnd();
        }

        return $builder->orderBy('tickets.created_at', 'DESC')->paginate($perPage);
    }

    // ── Ambil detail tiket tunggal + relasi ──
    public function getTicketByCode(string $code): ?array
    {
        return $this->select('tickets.*, users.name as user_name, users.email as user_email, categories.name as category_name, categories.color as category_color')
            ->join('users', 'users.id = tickets.user_id', 'left')
            ->join('categories', 'categories.id = tickets.category_id', 'left')
            ->where('tickets.code', $code)
            ->first();
    }

    // ── Statistik untuk dashboard admin ──
    public function getStatistics(): array
    {
        return [
            'total'       => $this->countAllResults(),
            'open'        => $this->where('status', 'open')->countAllResults(),
            'in_progress' => $this->where('status', 'in_progress')->countAllResults(),
            'resolved'    => $this->where('status', 'resolved')->countAllResults(),
            'rejected'    => $this->where('status', 'rejected')->countAllResults(),
        ];
    }

    // ── Statistik untuk user ──
    public function getUserStatistics(int $userId): array
    {
        return [
            'total'       => $this->where('user_id', $userId)->countAllResults(),
            'open'        => $this->where(['user_id' => $userId, 'status' => 'open'])->countAllResults(),
            'in_progress' => $this->where(['user_id' => $userId, 'status' => 'in_progress'])->countAllResults(),
            'resolved'    => $this->where(['user_id' => $userId, 'status' => 'resolved'])->countAllResults(),
            'rejected'    => $this->where(['user_id' => $userId, 'status' => 'rejected'])->countAllResults(),
        ];
    }
}
