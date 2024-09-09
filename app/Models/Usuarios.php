<?php

namespace App\Models;

use App\Filters\UsuariosFilter;
use App\Http\Resources\v1\UsuariosResource;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuarios extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'CPF',
        'email',
        'password',
        'Telefone',
        'RA',
        'id_curso',
        'is_admin',
    ];

    public function usuario(){
        return $this->belongsTo(Usuarios::class);
    }

    public function curso(){
        return $this->belongsTo(Cursos::class, 'id_curso');
    }

    public function filter(Request $request){
        $queryFilter = (new UsuariosFilter)->filter($request);

        if(empty($queryFilter)){
            return UsuariosResource::collection(Usuarios::with('usuario')->get());
        }
        
        $data = Usuarios::with('usuario');

        $resource = $data->where($queryFilter['where'])->get();

        return UsuariosResource::collection($resource);
    }

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    public function isAdmin(){
        return $this->is_admin;
    }
}
