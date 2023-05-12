<?php

require_once 'vendor/autoload.php';

use Brunammsa\Inputzvei\InputText;
use Brunammsa\Inputzvei\InputCpf;
use Brunammsa\Inputzvei\InputNumber;

$input = new InputText("Qual o seu nome? ");
$answer = $input->ask();

echo "Seu nome é: {$answer}". PHP_EOL;

$input = new InputCpf("Qual o seu CPF? ");
$answer = $input->ask();

echo "Seu cpf é o : {$answer}". PHP_EOL;

$input = new InputNumber("Qual sua idade? ");
$answer = $input->ask();

echo "sua idade é: {$answer}". PHP_EOL;