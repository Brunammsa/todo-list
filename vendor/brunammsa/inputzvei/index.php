<?php

require_once 'vendor/autoload.php';

use Brunammsa\Inputzvei\InputText;
use Brunammsa\Inputzvei\InputCpf;
use Brunammsa\Inputzvei\InputNumber;
use Brunammsa\Inputzvei\InputMenu;

$input = new InputMenu('Digite a opção desejada: ');
ucfirst($answer = $input->ask());

echo "você escolheu a opção $answer" . PHP_EOL;

$input = new InputText("Qual o seu nome? ");
$answer = $input->ask();
var_dump($answer);
exit;

echo "Seu nome é: {$answer}". PHP_EOL;

$input = new InputCpf("Qual o seu CPF? ");
$answer = $input->ask();

echo "Seu cpf é o : {$answer}". PHP_EOL;

$input = new InputNumber("Qual sua idade? ");
$answer = $input->ask();

echo "sua idade é: {$answer}". PHP_EOL;