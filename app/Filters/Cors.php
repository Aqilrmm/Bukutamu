<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Daftar origin yang diizinkan
        $allowedOrigins = [
            'http://dpmptsp.tail8af30b.ts.net',
            'https://dpmptsp.tail8af30b.ts.net',
            'http://localhost',
            'http://localhost:8080',
            'http://127.0.0.1',
            'http://127.0.0.1:8080'
        ];
        
        $origin = $request->getHeaderLine('Origin');
        
        // Jika origin ada dalam daftar yang diizinkan
        if (in_array($origin, $allowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
        } else {
            // Atau izinkan semua origin (hanya untuk development)
            header('Access-Control-Allow-Origin: *');
        }
        
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        
        // Handle preflight request
        if ($request->getMethod() === 'options') {
            exit(0);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}
