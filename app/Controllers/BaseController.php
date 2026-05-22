<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController — induk semua controller TickTrack.
 * Menyediakan session, helpers, dan method umum.
 */
abstract class BaseController extends Controller
{
    protected $session;
    protected $helpers = ['form', 'url', 'text', 'ticktrack'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = service('session');
    }

    // ── Data user yang sedang login ──
    protected function currentUser(): ?array
    {
        $userId = $this->session->get('user_id');
        if (!$userId) return null;

        return model(\App\Models\UserModel::class)->find($userId);
    }

    // ── Cek apakah user adalah admin ──
    protected function isAdmin(): bool
    {
        return $this->session->get('user_role') === 'admin';
    }

    // ── Format waktu relatif (misal: "2 jam yang lalu") ──
    protected function timeAgo(string $datetime): string
    {
        $now  = time();
        $time = strtotime($datetime);
        $diff = $now - $time;

        if ($diff < 60) return 'Baru saja';
        if ($diff < 3600) return floor($diff / 60) . ' menit lalu';
        if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
        if ($diff < 604800) return floor($diff / 86400) . ' hari lalu';
        if ($diff < 2592000) return floor($diff / 604800) . ' minggu lalu';

        return date('d M Y', $time);
    }
}
