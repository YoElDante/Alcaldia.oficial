<?php

namespace App\Controllers;

class DescargasController extends BaseController
{
    public function index(): string
    {
        return view('descargas/login', [
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function login()
    {
        $password = (string) $this->request->getPost('password');

        // Placeholder for Fase 1; in Fase 2 this must validate hashed temporary keys.
        $expected = env('DESCARGAS_PASSWORD', 'demo123');

        if ($password !== $expected) {
            session()->setFlashdata('error', 'Clave invalida.');
            return redirect()->to('/descargas');
        }

        session()->regenerate();
        session()->set('descargas_auth', true);

        return redirect()->to('/descargas/panel');
    }

    public function panel(): string
    {
        return view('descargas/panel');
    }

    public function logout()
    {
        session()->remove('descargas_auth');
        session()->regenerate();

        return redirect()->to('/descargas');
    }
}
