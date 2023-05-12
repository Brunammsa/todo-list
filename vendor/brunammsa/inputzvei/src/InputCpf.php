<?php

namespace Brunammsa\Inputzvei;

class InputCpf extends Input
{

    protected function feedBackMessage(): string
    {
        return "este CPF não é válido";
    }

    protected function validate(string $answer): bool
    {
        $cpf = preg_replace('/[^0-9]/', "", $answer);
        
        if(strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
            return false;
        }

        $cpf = preg_replace('/[^0-9]/', "", $answer);

        if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
            return false;
        }
        
        $sum = 0;
        $number_to_multiplicate = 10;

        for ($index = 0; $index < 9; $index++) {
            $sum += $cpf[$index] * ($number_to_multiplicate--); 
        }
        
        $firstVerify = (($sum * 10) % 11);
        $firstVerify = ($firstVerify == 10) ? 0 : $firstVerify;
        
        $sum = 0;
        $number_to_multiplicate = 11;

        for ($index = 0; $index < 10; $index++) {
            $sum += $cpf[$index] * ($number_to_multiplicate--); 
        }
        
        $secondVerify = (($sum * 10) % 11);
        $secondVerify = ($secondVerify == 10) ? 0 : $secondVerify;
        
        if ($cpf[9] != $firstVerify || $cpf[10] != $secondVerify) {
            return false;
        }
        
        return true;
    }
}