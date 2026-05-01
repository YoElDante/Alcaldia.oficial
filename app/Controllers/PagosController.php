<?php

namespace App\Controllers;

class PagosController extends BaseController
{
    public function index(): string
    {
        return view('pagos');
    }
}
