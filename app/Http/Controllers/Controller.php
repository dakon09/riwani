<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function validationErrorsToString($errArray)
    {
        $errStrFinal = '';
        $valArr = [];
        foreach ($errArray->toArray() as $key => $value) {
            $errStr = $value[0];
            array_push($valArr, $errStr);
        }
        if (!empty($valArr)) {
            $errStrFinal = implode('<br/> ', $valArr);
        }

        return $errStrFinal;
    }

    protected function remove_comma($val)
    {
        return str_replace(',', '', $val);
    }
}
