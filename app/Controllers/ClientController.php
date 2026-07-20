<?php

class ClientController extends BaseController
{
    public function index()
    {
        return view('client/dashbord');
    }

    public function register()
    {
        return view('client/register');
    }
}