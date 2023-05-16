<?php

namespace Brunammsa\Inputzvei;

use Stringable;

class MenuOption implements Stringable
{
    public function __construct(
        public readonly string $key,
        public readonly string $value
    ){
    }

    public function __toString(): string
    {
        return $this->key . ' - ' . $this->value;
    }
}