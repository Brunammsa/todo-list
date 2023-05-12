<?php

namespace Brunammsa\Inputzvei;

class InputText extends Input
{
    protected function validate(string $answer): bool
    {
        return !($answer === "");
    }
}