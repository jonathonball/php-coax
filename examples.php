<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Coax\Coax;

$coax = new Coax();
$coax->parse();

var_dump($coax);
