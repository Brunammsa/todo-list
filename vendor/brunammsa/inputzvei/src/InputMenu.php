<?php

namespace Brunammsa\Inputzvei;

use League\CLImate\CLImate;
use Brunammsa\Inputzvei\MenuOption;

class InputMenu extends Input
{
    /** @var MenuOption[] | array */
    private $options = [];

    protected function question(): string
    {
        $optionsAsString = "";
        foreach ($this->options as $option) {
            $optionsAsString .= (string) $option . PHP_EOL;
        }
        return $this->question . PHP_EOL . $optionsAsString;
    }

    protected function feedBackMessage(): string
    {
        return 'Opção inexistente';
    }

    protected function validate(string $answer): bool
    {
        foreach ($this->options as $option) {
            if ($answer == $option->key) {
                return true;
            }
        }
        return false;
    }

    private function getValueFromOptions(string $key): string
    {
        foreach($this->options as $option){
            if ($key == $option->key) {
                return $option->value;
            }
        }
    }

    public function askOption(?bool $returnKey = false): string
    {
        $climate = new CLImate;

        if ($returnKey) {
            return $this->ask();
        }

        while (true) {
            $key = trim(readline($this->question()));

            if ($this->validate($key)) {
                return $this->getValueFromOptions($key);
            }
            $climate->red($this->feedBackMessage());
        }
    }

    public function addOption(string $key, string $value): self
    {
        $option = new MenuOption($key, $value);
        $this->options[] = $option;
        return $this;
    }
}
