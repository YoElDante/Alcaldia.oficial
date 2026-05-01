<?php

namespace App\Controllers;

class TutorialesController extends BaseController
{
    public function index(): string
    {
        return view('tutoriales');
    }
}
