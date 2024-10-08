<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuariosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'name' => $this->name,
            'curso' => $this->id_curso,
            'email' => $this->email,
            'tel' => $this->Telefone,
            'RA' => $this->RA
        ];
    }
}
