<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return $this->redirect(route('inventario'), navigate: true);        }

        $this->addError('email', 'Las credenciales no coinciden con nuestros registros.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
