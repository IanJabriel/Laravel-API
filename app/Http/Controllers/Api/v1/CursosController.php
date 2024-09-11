<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CursosResource;
use Illuminate\Http\Request;
use App\Models\Cursos;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CursosResource::collection(Cursos::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'Nome' => 'string',
            'Duracao' => 'integer',
        ]);

        $curso = Cursos::create([
            'Nome' => $validated_data['Nome'],
            'Duracao' => $validated_data['Duracao'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new CursosResource(Cursos::where('id',$id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
