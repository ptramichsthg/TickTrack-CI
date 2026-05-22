<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter — memastikan user sudah login.
 * Redirect ke /auth/login jika belum.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');

        if (!$session->get('user_id')) {
            if ($request instanceof \CodeIgniter\HTTP\IncomingRequest && $request->isAJAX()) {
                return service('response')->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
            }
            $session->setFlashdata('error', 'Silakan login terlebih dahulu.');
            return redirect()->to('/auth/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}
