<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // ── Seed Admin User ──
        $this->db->table('users')->insert([
            'name'       => 'Administrator',
            'email'      => 'admin@ticktrack.com',
            'password'   => password_hash('password', PASSWORD_BCRYPT),
            'role'       => 'admin',
            'phone'      => '081234567890',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // ── Seed Demo User ──
        $this->db->table('users')->insert([
            'name'       => 'Demo User',
            'email'      => 'user@ticktrack.com',
            'password'   => password_hash('password', PASSWORD_BCRYPT),
            'role'       => 'user',
            'phone'      => '089876543210',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // ── Seed Categories ──
        $categories = [
            ['name' => 'Teknis',      'description' => 'Masalah teknis dan bug sistem',   'color' => '#EF4444'],
            ['name' => 'Akun',        'description' => 'Masalah terkait akun pengguna',   'color' => '#F59E0B'],
            ['name' => 'Pembayaran',  'description' => 'Masalah transaksi dan billing',   'color' => '#10B981'],
            ['name' => 'Fitur',       'description' => 'Permintaan fitur baru',           'color' => '#3B82F6'],
            ['name' => 'Lainnya',     'description' => 'Pertanyaan dan keluhan umum',     'color' => '#8B5CF6'],
        ];

        foreach ($categories as $cat) {
            $this->db->table('categories')->insert(array_merge($cat, [
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]));
        }

        // ── Seed Sample Tickets ──
        $tickets = [
            [
                'code'        => 'TK-' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'user_id'     => 2,
                'category_id' => 1,
                'title'       => 'Tidak bisa login ke aplikasi',
                'description' => 'Setelah update terakhir, saya tidak bisa login menggunakan email saya. Muncul error "Invalid credentials" padahal password sudah benar.',
                'status'      => 'open',
                'priority'    => 'high',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-3 days')),
            ],
            [
                'code'        => 'TK-' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'user_id'     => 2,
                'category_id' => 3,
                'title'       => 'Pembayaran gagal diproses',
                'description' => 'Saya sudah melakukan pembayaran tetapi status masih pending. Mohon dicek segera.',
                'status'      => 'in_progress',
                'priority'    => 'urgent',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'code'        => 'TK-' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'user_id'     => 2,
                'category_id' => 4,
                'title'       => 'Request fitur dark mode',
                'description' => 'Apakah bisa ditambahkan fitur dark mode pada dashboard? Sangat berguna untuk pengguna yang bekerja malam.',
                'status'      => 'resolved',
                'priority'    => 'low',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-7 days')),
                'updated_at'  => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
        ];

        foreach ($tickets as $ticket) {
            $this->db->table('tickets')->insert($ticket);
        }

        // ── Seed Sample Replies ──
        $replies = [
            [
                'ticket_id'  => 2,
                'user_id'    => 1,
                'message'    => 'Terima kasih atas laporannya. Kami sedang memeriksa status pembayaran Anda. Mohon menunggu 1x24 jam.',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            ],
            [
                'ticket_id'  => 3,
                'user_id'    => 1,
                'message'    => 'Fitur dark mode sudah masuk dalam roadmap development kami. Terima kasih atas sarannya!',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            ],
        ];

        foreach ($replies as $reply) {
            $this->db->table('ticket_replies')->insert($reply);
        }
    }
}
