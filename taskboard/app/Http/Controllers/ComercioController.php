<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Comercio;

class ComercioController extends Controller 
{ 
    public function index(Request $request): View
{ 
    $comercios = Comercio::when($request->buscar, 
    fn ($q) => $q->where('nombre_comercio', 
    'like', "%{$request->buscar}%"))    
    ->withCount('transacciones')
    ->orderBy('nombre_comercio')->get();
    return view('comercios.index', compact('comercios')); 
}

public function show(Comercio $comercio) 
{ 
    $comercio->load('transacciones'); 
  
    return view('comercios.show', [ 
        'comercio' => $comercio, 
    ]); 
}

} 