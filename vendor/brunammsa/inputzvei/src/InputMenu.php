<?php

namespace Brunammsa\Inputzvei;

class InputMenu extends Input
{
    protected function feedBackMessage(): string
    {
        return 'Opção inexistente';
    }

    protected function validate(string $answer): bool
    {
        $options = [
            'Insert',
            'Update',
            'Remove',
            'List',
            0
        ];
        return !(in_array(ucfirst($answer), $options) === false);
    }
}