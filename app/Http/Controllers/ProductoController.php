<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }


    public function create()
    {
        return view('productos.create');
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|string|min:3',
                'precio' => 'required|numeric|min:1',
                'stock' => 'required|integer|min:1',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',

                'precio.required' => 'El precio es obligatorio.',
                'precio.numeric' => 'El precio debe ser un número.',
                'precio.min' => 'El precio debe ser mayor a 0.',

                'stock.required' => 'El stock es obligatorio.',
                'stock.integer' => 'El stock debe ser un número entero.',
                'stock.min' => 'El stock debe ser al menos 1.',

                'imagen.image' => 'El archivo debe ser una imagen.',
                'imagen.mimes' => 'La imagen debe ser JPG, PNG o WEBP.',
                'imagen.max' => 'La imagen no debe superar los 2MB.'
            ]
        );

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'imagen' => $rutaImagen
        ]);

        return redirect('/')
            ->with('success', 'Producto creado correctamente');
    }


    public function destroy($id)
    {
        $producto = Producto::find($id);

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect('/')
            ->with('success', 'Producto eliminado correctamente');
    }


    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nombre' => 'required|string|min:3',
                'precio' => 'required|numeric|min:1',
                'stock' => 'required|integer|min:1',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',

                'precio.required' => 'El precio es obligatorio.',
                'precio.numeric' => 'El precio debe ser un número.',
                'precio.min' => 'El precio debe ser mayor a 0.',

                'stock.required' => 'El stock es obligatorio.',
                'stock.integer' => 'El stock debe ser un número entero.',
                'stock.min' => 'El stock debe ser al menos 1.',

                'imagen.image' => 'El archivo debe ser una imagen.',
                'imagen.mimes' => 'La imagen debe ser JPG, PNG o WEBP.',
                'imagen.max' => 'La imagen no debe superar los 2MB.'
            ]
        );

        $producto = Producto::findOrFail($id);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock
        ]);

        return redirect('/')->with('success', 'Producto actualizado correctamente.');
    }


    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }


}
