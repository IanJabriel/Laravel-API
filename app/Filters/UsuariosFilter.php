<?php 
namespace App\Filters;

class UsuariosFilter extends Filter{
    protected array $allowedOperatorsFields = [
        'id' => ['eq'],
        'id_curso' => ['eq'],
    ];
}
?>