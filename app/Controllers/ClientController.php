<?php

class ClientController extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $query = $db->query('SELECT * FROM clients');
        $clients = $query->getResult();

    
        return view('client/dashbord');
    }

    public function login()
    {
        return view('client/login');
    }
}