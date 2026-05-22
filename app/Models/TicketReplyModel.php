<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketReplyModel extends Model
{
    protected $table            = 'ticket_replies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'ticket_id', 'user_id', 'message',
    ];

    protected $validationRules = [
        'message' => 'required|min_length[3]',
    ];

    // ── Ambil semua reply + info user ──
    public function getRepliesByTicket(int $ticketId): array
    {
        return $this->select('ticket_replies.*, users.name as user_name, users.role as user_role, users.avatar as user_avatar')
            ->join('users', 'users.id = ticket_replies.user_id', 'left')
            ->where('ticket_replies.ticket_id', $ticketId)
            ->orderBy('ticket_replies.created_at', 'ASC')
            ->findAll();
    }
}
