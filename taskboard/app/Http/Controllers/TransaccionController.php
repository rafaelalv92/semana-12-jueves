<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\Comercio;
use Illuminate\View\View;
use App\Http\Requests\GuardarTransaccionRequest;

class TransaccionController extends Controller
{
    public function index() 
    { 
    return Transaccion::with('comercio')->get(); 
    }

    public function create(Comercio $comercio): View 
{ 
    return view('transacciones.create', compact('comercio')); 
}  
  
public function store(GuardarTransaccionRequest $request)  
{ 
       $request->validate([
    'comercio_id' => 'required|exists:comercios,id', 
    'cliente_nombre' => 'required|string|max:255', 
    'monto' => 'required|numeric|min:0.01', 
], [ 
    'cliente_nombre.required' => 'Debes indicar el nombre del cliente.', 
    'monto.required' => 'Debes indicar un monto.', 
    'monto.numeric' => 'El monto debe ser un número.', 
    'monto.min' => 'El monto debe ser mayor a cero.', 
]);  

        $transaccion = Transaccion::create($request->only([ 
        'comercio_id', 'cliente_nombre', 'monto', 
        ])); 
  
        return redirect() 
        ->route('comercios.show', $transaccion->comercio_id) 
        ->with('mensaje', 'Transacción registrada con éxito.');
} 
public function show(Transaccion $transaccion) 
    { 
    return $transaccion->load('comercios'); 
    }
}
