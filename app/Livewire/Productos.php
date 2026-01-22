<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;

class Productos extends Component
{
    use WithFileUploads;

    public $productos;

    public $nombre = '';
    public $precio = '';
    public $stock = '';

    public $imagen;

    public $imagen_actual;

    public $productoId = null;
    public $modoEdicion = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|min:3',
            'precio' => 'required|numeric|min:1',
            'stock'  => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ];
    }

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'precio.required' => 'El precio es obligatorio.',
        'stock.required' => 'El stock es obligatorio.',
        'imagen.image' => 'El archivo debe ser una imagen válida.',
        'imagen.max' => 'La imagen es muy pesada (Máximo 10MB).',
    ];

    public function mount()
    {
        $this->cargarProductos();
    }

    public function cargarProductos()
    {
        $this->productos = Producto::orderBy('created_at', 'desc')->get();
    }


    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|min:3',
            'precio' => 'required|numeric|min:1',
            'stock'  => 'required|integer|min:1',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $rutaImagen = $this->imagen->store('productos', 'public');

            Producto::create([
                'nombre' => $this->nombre,
                'precio' => $this->precio,
                'stock'  => $this->stock,
                'imagen' => $rutaImagen,
            ]);

            $this->resetFormulario();
            $this->cargarProductos();
            session()->flash('success', 'Producto creado exitosamente.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al subir la imagen: ' . $e->getMessage());
        }
    }


    public function editar($id)
    {
        $producto = Producto::findOrFail($id);

        $this->productoId = $producto->id;
        $this->nombre = $producto->nombre;
        $this->precio = $producto->precio;
        $this->stock = $producto->stock;
        $this->imagen_actual = $producto->imagen;
        $this->imagen = null;

        $this->modoEdicion = true;
    }


    public function actualizar()
    {
        $this->validate([
            'nombre' => 'required|string|min:3',
            'nombre.min' => 'El nombre es muy corto (mínimo 3 caracteres).',
            'precio' => 'required|numeric|min:1',
            'stock'  => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $producto = Producto::findOrFail($this->productoId);

        $datos = [
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'stock'  => $this->stock,
        ];

        if ($this->imagen) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $datos['imagen'] = $this->imagen->store('productos', 'public');
        }

        $producto->update($datos);

        $this->resetFormulario();
        $this->cargarProductos();
        session()->flash('success', 'Producto actualizado correctamente.');
    }


    public function eliminar($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        $this->cargarProductos();
        session()->flash('success', 'Producto eliminado.');
    }

    public function resetFormulario()
    {
        $this->reset(['nombre', 'precio', 'stock', 'imagen', 'productoId', 'modoEdicion', 'imagen_actual']);
        $this->dispatch('limpiar-input-file');
    }

    public function render()
    {
        return view('livewire.productos')->layout('layouts.app');
    }
}
