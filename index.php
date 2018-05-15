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
        if (! isset($value['aliases'])) {
            $value['aliases'] = [];
        }
        if (! in_array($alias, $value['aliases'])) {
            $value['aliases'][] = $alias;
        }
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

    public function debug() {
        echo "DEBUG::::\n";
        var_dump($this->_options);
    }

}



$test = new Coax();
$test->alias('a', ['b', 'c', 'tacos'])
     ->alias('a', 'h')
     ->debug();

//var_dump($test);
