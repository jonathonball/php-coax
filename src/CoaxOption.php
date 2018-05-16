<?php

namespace Coax;

use Coax\Util;

class CoaxOption {

    protected $_data = [];
    protected $_name = '';
    
    public function __construct($name) {
        $this->_setName($name);
    }

    public function getOptions() {
        return $this->_data;
    }

    protected function _setName($name) {
        if (! is_string($name)) throw new \Exception('CoaxOption expects name to be string');
        $this->_name = $name;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function alias($aliases) {
        if (! is_array($aliases)) {
            $aliases = [ $aliases ];
        }
        foreach ($aliases as $alias) {
            Util::array_push_unique($this->_data, 'aliases', $alias);
        }
        return $this;
    }

    public function castToArray() {
        $this->_data['array'] = true;
        return $this;
    }

    public function castToBoolean() {
        $this->_data['boolean'] = true;
        return $this;
    }

    public function choices($choices) {
        if (! is_array($choices)) {
            $choices = [ $choices ];
        }
        foreach ($choices as $choice) {
            if (! is_string($choice)) throw new \Exception('choices should be strings');
            Util::array_push_unique($this->_data, 'choices', $choice);
        }
        return $this;
    }

    public function coerce($callback) {
        if (! is_callable($callback)) throw new \Exception('coerce expects callback to be callable');
        $this->_data['coercionCallback'] = $callback;
        return $this;
    }

    public function conflicts() {
        $conflicts = Util::flatten(func_get_args());
        if (! count($conflicts)) throw new \Exception('conflicts expects at least two params');
        foreach ($conflicts as $conflict) {
            Util::array_push_unique($this->_data, 'conflicts', $conflict);
        }
        return $this;
    }

    public function count() {
        $this->_data['count'] = true;
        return $this;
    }

    public function defaultTo($value) {
        $this->_data['default'] = $value;
        return $this;
    }

    public function demand($message = '') {
        if (strlen($message)) {
            $this->_data['demand'] = $message;
        } else {
            $this->_data['demand'] = true;
        }
        return $this;
    }

    public function describe($message = '') {
        $this->_data['description'] = $message;
        return $this;
    }

    public function example($message) {
        $this->_data['example'] = $message;
        return $this;
    }

    public function group($groupName) {
        $this->_data['group'] = ucfirst($groupName);
        return $this;
    }

    public function help() {
        $this->alias('h');
        $this->describe('An alias for -h');
        return $this;
    }

    public function hide($value = true) {
        $this->_data['hidden'] = ($value === false) ? false : true;
        return $this;
    }

    public function implies($otherKeys) {
        if (! is_array($otherKeys)) {
            $otherKeys = [ $otherKeys ];
        }
        foreach ($otherKeys as $otherKey) {
            Util::array_push_unique($this->_data, 'requires', $otherKey);
        }
        return $this;
    }

    public function nargs($n) {
        if (! is_numeric($n)) throw new \Exception('nargs expects n to be numeric');
        $this->_data['nargs'] = $n;
        return $this;
    }

    public function numberLike() {
        $this->_data['number'] = true;
        return $this;
    }

    public function stringLike() {
        $this->_data['string'] = true;
        return $this;
    }

}
