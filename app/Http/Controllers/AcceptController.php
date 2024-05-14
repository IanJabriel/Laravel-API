<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcceptController extends Controller
{
    use HttpResponses;

    public function index(){
        return $this->success('Authorized',200);
    }

    public function store(){
        
    }
}
