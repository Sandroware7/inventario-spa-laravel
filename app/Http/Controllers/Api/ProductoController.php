<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * GET /api/productos
     * Muestra la lista de productos en formato JSON.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return response()->json($productos, 200);
    }

    /**
     * POST /api/productos
     * Guarda un nuevo producto.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|string|min:3',
                'precio' => 'required|numeric|min:1',
                'stock'  => 'required|integer|min:1',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240'
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.min'      => 'El nombre debe tener al menos 3 caracteres.',
                'precio.required' => 'El precio es obligatorio.',
                'precio.numeric'  => 'El precio debe ser un número.',
                'stock.required'  => 'El stock es obligatorio.',
                'imagen.image'    => 'El archivo debe ser una imagen.',
                'imagen.max'      => 'La imagen no debe superar los 10MB.'
            ]
        );

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock'  => $request->stock,
            'imagen' => $rutaImagen
        ]);

        return response()->json([
            'mensaje' => 'Producto creado correctamente',
            'data'    => $producto
        ], 201);
    }

    /**
     * GET /api/productos/{id}
     * Muestra un producto específico (Necesario en API REST).
     */
    public function show($id)
    {
        $producto = Producto::with('categoria')->find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }

    /**
     * PUT /api/productos/{id}
     * Actualiza un producto existente.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string|min:3',
            'precio' => 'sometimes|required|numeric|min:1',
            'stock'  => 'sometimes|required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240'
        ]);

        $datos = $request->only(['nombre', 'precio', 'stock']);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($datos);

        return response()->json([
            'mensaje' => 'Producto actualizado correctamente',
            'data'    => $producto
        ], 200);
    }

    /**
     * DELETE /api/productos/{id}
     * Elimina un producto.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json([
            'mensaje' => 'Producto eliminado correctamente'
        ], 200);
    }
}
