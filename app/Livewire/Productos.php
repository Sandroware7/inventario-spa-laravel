<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;
use App\Models\Categoria;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Productos extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $nombre, $precio, $stock, $producto_id, $imagen, $imagen_nueva;
    public $categoria_id;
    public $busqueda = '';
    public $isModalOpen = 0;

    public $filtroSinStock = false;
    public $filtroBajoStock = false;
    public $filtroCategoria = '';

    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function updatingFiltroCategoria()
    {
        $this->resetPage();
    }

    public function toggleFiltroSinStock()
    {
        $this->filtroSinStock = !$this->filtroSinStock;
        $this->filtroBajoStock = false;
        $this->resetPage();
    }

    public function toggleFiltroBajoStock()
    {
        $this->filtroBajoStock = !$this->filtroBajoStock;
        $this->filtroSinStock = false;
        $this->resetPage();
    }

    public function render()
    {
        $query = Producto::query();

        if ($this->busqueda) {
            $query->where(function($q) {
                $q->where('nombre', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('stock', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroCategoria) {
            $query->where('categoria_id', $this->filtroCategoria);
        }

        if ($this->filtroSinStock) {
            $query->where('stock', 0);
        } elseif ($this->filtroBajoStock) {
            $query->where('stock', '>', 0)->where('stock', '<', 5);
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(5);

        $categorias = Categoria::all();

        $todosLosProductos = Producto::all();
        $totalProductos = $todosLosProductos->count();
        $productosSinStock = $todosLosProductos->where('stock', 0)->count();
        $productosBajoStock = $todosLosProductos->where('stock', '>', 0)->where('stock', '<', 5)->count();

        $valorInventario = $todosLosProductos->sum(function ($prod) {
            return $prod->precio * $prod->stock;
        });

        return view('livewire.productos', compact(
            'productos',
            'categorias',
            'totalProductos',
            'productosSinStock',
            'productosBajoStock',
            'valorInventario'
        ));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetInputFields()
    {
        $this->nombre = '';
        $this->precio = '';
        $this->stock = '';
        $this->categoria_id = '';
        $this->producto_id = null;
        $this->imagen = null;
        $this->imagen_nueva = null;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required',
            'imagen' => 'nullable|image|max:10240',
        ]);

        $imagePath = null;
        if ($this->imagen) {
            $imagePath = $this->imagen->store('productos', 'public');
        }

        Producto::create([
            'nombre' => $this->nombre,
            'precio' => (float) $this->precio,
            'stock' => (int) $this->stock,
            'categoria_id' => $this->categoria_id,
            'imagen' => $imagePath
        ]);

        session()->flash('message', 'Producto creado exitosamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $this->producto_id = $id;
        $this->nombre = $producto->nombre;
        $this->precio = $producto->precio;
        $this->stock = $producto->stock;
        $this->categoria_id = $producto->categoria_id;
        $this->imagen = $producto->imagen;

        $this->openModal();
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required',
            'imagen_nueva' => 'nullable|image|max:10240',
        ]);

        $producto = Producto::find($this->producto_id);

        $data = [
            'nombre' => $this->nombre,
            'precio' => (float) $this->precio,
            'stock' => (int) $this->stock,
            'categoria_id' => $this->categoria_id
        ];

        if ($this->imagen_nueva) {
            $data['imagen'] = $this->imagen_nueva->store('productos', 'public');
        }

        $producto->update($data);

        session()->flash('message', 'Producto actualizado exitosamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Producto::find($id)->delete();
        session()->flash('message', 'Producto eliminado exitosamente.');
    }
}
