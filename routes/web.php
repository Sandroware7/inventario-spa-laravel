<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Productos;
use App\Livewire\Ventas;
use App\Livewire\Historial;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;

/*
RUTAS PARA INVITADOS
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

/*
RUTAS PROTEGIDAS (Auth) solo accesibles si el CAJERO/ADMIN ha iniciado sesión.
*/
Route::middleware('auth')->group(function () {

    Route::get('/', Productos::class);
    Route::get('/ventas', Ventas::class)->name('ventas');
    Route::get('/inventario', Productos::class)->name('inventario');
    Route::get('/historial', Historial::class)->name('historial');

    Route::get('/venta/{id}/pdf', function ($id) {
        $venta = Venta::with('detalles')->find($id);

        if (!$venta) {
            return abort(404, 'Venta no encontrada');
        }

        $pdf = Pdf::loadView('pdf.boleta', compact('venta'));

        // Mostramos el PDF en el navegador
        return $pdf->stream('boleta-'.$venta->id.'.pdf');

    })->name('venta.pdf');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

});
