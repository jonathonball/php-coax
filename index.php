<?php

class Coax {

    protected $_options = [];

    public function __construct($arguments = []) {
        $this->setArguments($arguments);
    }

    public function setArguments($arguments = []) {
        if (! is_array($arguments)) throw new Exception('Coax expects array');
        if (count($arguments)) {
            $this->argv = array_merge([basename(__FILE__)], $arguments);
        } else {
            $this->argv = $GLOBALS['argv'];
        }
        return $this;
    }

    public function getArguments() {
        return $this->argv;
    }

    protected function _getKey(string $key) {
        if (isset($this->_options[$key])) {
            return $this->_options[$key];
        }
        return $this->_setKey($key);
    }

    protected function _setKey(string $key, array $value = []) {
        if ($this->_isAlias($key)) throw new Exception($key . ' is an existing alias.');
        $this->_options[$key] = $value;
        return $value;
    }

    public function alias(string $key, $aliases) {
        if (is_array($aliases)) {
            foreach ($aliases as $alias) {
                $this->_alias($key, $alias);
            }
        } else {
            $this->_alias($key, $aliases);
        }
        return $this;
    }

    private function _alias(string $key, string $alias) {
        $value = $this->_getKey($key);
        $this->_arrayPushIfUnique($value, 'aliases', $alias);
        $this->_setKey($key, $value);
    }

    private function _isAlias(string $key) {
        foreach ($this->_options as $name => $option) {
            if (isset($option['aliases'])) {
                if (in_array($key, $option['aliases'])) {
                    return $name;
                }
            }
        }
        return false;
    }

    public function array(string $key) {
        $value = $this->_getKey($key);
        $value['array'] = true;
        $this->_setKey($key, $value);
        return $this;
    }

    public function boolean(string $key) {
        $value = $this->_geyKey($key);
        $value['boolean'] = true;
        $this->_setKey($key, $value);
        return $this;
    }

    public function choices(string $key, array $choices) {
        $value = $this->_getKey($key);
        foreach ($choices as $choice) {
            $this->_arrayPushIfUnique($value, 'choices', $choice);
        }
        $this->_setKey($key, $value);
        return $this;
    }

    private function _arrayPushIfUnique(array &$target, string $key, $value) {
        if (! isset($target[$key])) {
            $target[$key] = [];
        }
        if (! in_array($key, $target[$key])) {
            $target[$key][] = $value;
        }
        return $target;
    }

    public function conflicts() {
        $conflicts = $this->_flatten(func_get_args());
        if (count($conflicts) < 2) throw new Exception('conflicts expects at least two params');
        $key = array_shift($conflicts);
        $value = $this->_getKey($key);
        foreach ($conflicts as $conflict) {
            $this->_arrayPushIfUnique($value, 'conflicts', $conflict);
        }
        $this->_setKey($key, $value);
    }

    private function _flatten(Array $array) {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), FALSE);
    }

    public function count($key) {
        $value = $this->_getKey($key);
        $value['count'] = true;
        $this->_setKey($key, $value);
        return $this;
    }

    public function default($key, $value) {
        $data = $this->_getKey($key);
        $data['default'] = $value;
        $this->_setKey($key, $data);
        return $this;
    }

    public function demand($key, $msg = true) {
        $data = $this->_getKey($key);
        $data['demand'] = $msg;
        $this->_setKey($key, $data);
        return $this;
    }

}

/*
$test = new Coax();
$test->alias('a', ['b', 'c', 'tacos'])
     ->array('a')
     ->array('stuff')
     ->choices('brand', ['imh', 'hub'])
     ->conflicts('a', ['b', 'c'], 'd');
     //->debug();

var_dump($test);
*/
