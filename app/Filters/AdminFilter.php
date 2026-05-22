<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AdminFilter — memastikan user yang login adalah admin.
 * Redirect ke /user/dashboard jika bukan admin.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if ($session->get('user_role') !== 'admin') {
            $session->setFlashdata('error', 'Anda tidak memiliki akses ke halaman admin.');
            return redirect()->to('/user/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}
