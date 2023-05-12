<?php

namespace Brunammsa\Inputzvei;

use League\CLImate\CLImate;

abstract class Input
{
    public function __construct(protected readonly string $question)
    {
    }

    abstract protected function validate(string $answer): bool;

    protected function feedBackMessage(): string
    {
        return "Resposta inválida";
    }

    public function ask(): string
    {
        $climate = new CLImate;
        
        while(true) {
            $answer = trim(readline($this->question));

            if($this->validate($answer)) {
                return $answer;
            }
            $climate->red($this->feedBackMessage());
        }
    }
}