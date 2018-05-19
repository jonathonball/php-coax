<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Coax\Coax;
use Coax\CoaxOption;

/**
 * This is a single option with every possible method applied.
 * It will not parse. This is just a silly example.
 */
$test = new CoaxOption('--example');
$test->alias(['b', 'c'])
     ->castToArray()
     ->castToBoolean()
     ->choices(['test', 'test2'])
     ->coerce(function($value) {
         return ($value > 1); // force to boolean
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
//var_dump($test);

/**
 * This is the sames as..
 */
$coax = new Coax();
$coax->options()
     ->alias('a', ['b', 'c'])
     ->nargs('a', 5)
     ->demand('x')
     ->count('x');
//var_dump($coax);

/**
 * this, is the same as..
 */
$coax = new Coax();
$coax->option('a')
     ->alias(['b', 'c'])
     ->nargs(5);
$coax->option('x')
     ->demand()
     ->count();
//var_dump($coax);

/**
 * This
 */
$a = new CoaxOption('a');
$a->alias(['b', 'c'])
  ->nargs(5);
$x = new CoaxOption('x');
$x->demand()
  ->count();
$coax = new Coax();
$coax->option($a);
$coax->option($x);
//var_dump($coax);
