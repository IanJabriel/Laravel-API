<?php 
namespace App\Filters;

use Illuminate\Http\Request;
use DeepCopy\Exception\PropertyException;
use Exception;

abstract class Filter{
    protected array $allowedOperatorsFields = [];
    
    protected array $translateOperatorsFields = [
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
        'eq' => '=',
        'ne' => '!=',
        'in' => 'in',
    ];

    public function filter(Request $request){
        $where = [];
        $wherein = [];

        if(empty($this->allowedOperatorsFields)){
        throw new PropertyException("Property allowedOperatorsFields is empty");
        }

        foreach($this->allowedOperatorsFields as $param => $operators){
            $queryOperator = $request->query($param);
            if($queryOperator){
                //var_dump($queryOperator);
                foreach($queryOperator as $operator => $value){
                    if(!in_array($operator,$operators)){
                        throw new Exception("{$param} does not have {$operator} operator");
                    }

                    if(str_contains($value,'[')){
                        $wherein[] = [
                            $param,
                            explode(',',str_replace(['[',']'], ["",""],$value)),
                        ];
                    }else{
                        $where[] = [
                            $param,
                            $this->translateOperatorsFields[$operator],
                            $value
                        ];
                    }
                }
            }
        }

        if(empty($where) && empty($wherein)){
            return [];
        }

        return [
            'where' => $where,
            'wherein' => $wherein
        ];
    }
}
?>