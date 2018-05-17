<?php

require_once(__DIR__ . '/vendor/autoload.php');

/*
use Coax\CoaxOption;
$test = new CoaxOption('--example');
$test->alias(['b', 'c'])
     ->castToArray()
     ->castToBoolean()
     ->choices(['test', 'test2'])
     ->coerce(function($value) {
         return $value > 1;
     })->conflicts('x', 'y', 'z')
     ->count()
     ->defaultTo('something')
     ->demand()
     ->describe('this tag works')
     ->example('--example [stuff]')
     ->group('examples')
     ->hide()
     ->implies(['d', 'e'])
     ->nargs(10)
     ->numberLike()
     ->stringLike();
var_dump($test);
*/

use Coax\Coax;
use Coax\CoaxOption;

$coax = new Coax();
$coax->options()->alias('a', ['b', 'c']);

$coax = new Coax();
$coax->options('a')->alias(['b', 'c']);

$coax = new Coax();
$a = new CoaxOption('a');
$a->alias(['b', 'c']);
$coax->options($a);
