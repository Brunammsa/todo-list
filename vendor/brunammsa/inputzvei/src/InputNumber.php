<?php

namespace Brunammsa\Inputzvei;

class InputNumber extends Input
{
    protected function feedBackMessage():string
    {
        return "Digite apenas números";
    }
    protected function validate(string $answer): bool
    {
        return !(is_numeric($answer) === false);
    }
}