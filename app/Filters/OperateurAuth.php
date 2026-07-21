<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class OperateurAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if (! session()->get('operateur_id')) {
        //     return redirect()->to('/operateur/login')->with('erreur', 'Veuillez vous connecter.');
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // rien à faire ici
    }
}