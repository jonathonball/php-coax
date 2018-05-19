# php-coax
Replacement for getopts in PHP.  

Parses `$GLOBALS['argv']` or an array using an API similar to [Yargs](https://www.npmjs.com/package/yargs) in Node JS.

# Examples
This..
```
$coax = new Coax();
$coax->options()
     ->alias('a', ['b', 'c'])
     ->nargs('a', 5)
     ->demand('x')
     ->count('x');
```

is the same as this...
```
$coax = new Coax();
$coax->option('a')
     ->alias(['b', 'c'])
     ->nargs(5);
$coax->option('x')
     ->demand()
     ->count();
```

is this same as this
```
$a = new CoaxOption('a');
$a->alias(['b', 'c'])
  ->nargs(5);
$x = new CoaxOption('x');
$x->demand()
  ->count();
$coax = new Coax();
$coax->option($a);
$coax->option($x);
```
