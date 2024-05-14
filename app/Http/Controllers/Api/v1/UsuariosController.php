<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UsuariosResource;
use App\Models\Usuarios;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //return UsuariosResource::collection(Usuarios::all());
        return (new Usuarios())->filter($request);
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
            'name' => 'required|string',
            'id_curso' => 'nullable|integer',
            'CPF' => 'required|unique:usuarios',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|string',
            'Telefone' => 'required|string',
            'RA' => 'nullable|string'
        ]);

        $usuario = Usuarios::create([
            'name' => $validated_data['name'],
            'id_curso' => $validated_data['id_curso'],
            'CPF' => $validated_data['CPF'],
            'email' => $validated_data['email'],
            'password' => Hash::make($validated_data['password']),
            'Telefone' => $validated_data['Telefone'],
            'RA' => $validated_data['RA']
        ]);

        return new UsuariosResource($usuario);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new UsuariosResource(Usuarios::where('id',$id)->first());
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
