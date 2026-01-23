<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $codigo_trabajador = '';

    public function register()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'codigo_trabajador' => 'required'
        ]);

        $rol_asignado = '';

        if ($this->codigo_trabajador === env('CODIGO_ADMIN')) {
            $rol_asignado = 'admin';
        } elseif ($this->codigo_trabajador === env('CODIGO_CAJERO')) {
            $rol_asignado = 'cajero';
        } else {
            $this->addError('codigo_trabajador', 'El código de trabajador es incorrecto.');
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $rol_asignado,
        ]);

        Auth::login($user);

        return $this->redirect(route('inventario'), navigate: true);
    }

    public function render()
    {
        return view('livewire.register');
    }
}
