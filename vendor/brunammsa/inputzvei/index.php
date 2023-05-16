<?php

require_once 'vendor/autoload.php';

use Brunammsa\Inputzvei\InputMenu;

$input = new InputMenu('Quem é a mais teimosa: ');
$input->addOption('1', 'Bruna')
    ->addOption('2', 'Nathalia')
    ->addOption('3', 'Larissa');
$test = $input->askOption();
var_dump($test);