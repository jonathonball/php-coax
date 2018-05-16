<?php

class Coax {

    protected $_options = [];

    public function __construct($arguments = []) {
        $this->setArguments($arguments);
    }

    /**
     * Sets the values to use as argv[]
     * @param array $arguments
     * @return $this
     */
    public function setArguments($arguments = []) {
        if (! is_array($arguments)) throw new Exception('Coax expects array');
        if (count($arguments)) {
            $this->argv = array_merge([basename(__FILE__)], $arguments);
        } else {
            $this->argv = $GLOBALS['argv'];
        }
        return $this;
    }

    /**
     * Gets the values representing argv[]
     * @return array
     */
    public function getArguments() {
        return $this->argv;
    }

    protected function _getKey($key) {
        if (isset($this->_options[$key])) {
            return $this->_options[$key];
        }
        return $this->_setKey($key);
    }

    protected function _setKey($key, $value = []) {
        if ($this->_isAlias($key)) throw new Exception($key . ' is an existing alias.');
        $this->_options[$key] = $value;
        return $value;
    }

    protected function _set($key, $callback) {
        if (! is_string($key)) throw new Exception('_set expects key to be string');
        if (! is_callable($callback)) throw new Exception('_set expects function callback');
        $data = $this->_getKey($key);
        $callback($data);
        $this->_setKey($key, $data);
        return $this;
    }

    public function alias($key, $aliases) {
        if (is_array($aliases)) {
            foreach ($aliases as $alias) {
                $this->_alias($key, $alias);
            }
        } else {
            $this->_alias($key, $aliases);
        }
        return $this;
    }

    private function _alias($key, $alias) {
        $this->_set($key, function(&$data) use ($alias) {
            $this->_arrayPushIfUnique($data, 'aliases', $alias);
        });
    }

    private function _isAlias($key) {
        foreach ($this->_options as $name => $option) {
            if (isset($option['aliases'])) {
                if (in_array($key, $option['aliases'])) {
                    return $name;
                }
            }
        }
        return false;
    }

    public function array($key) {
        return $this->_set($key, function(&$data) {
            $data['array'] = true;
        });
    }

    public function boolean($key) {
        return $this->_set($key, function(&$data) {
            $data['boolean'] = true;
        });
    }

    public function choices($key, $choices) {
        return $this->_set($key, function(&$data) use ($choices) {
            foreach ($choices as $choice) {
                if (! is_string($choice)) throw new Exception('choices should be strings');
                $this->_arrayPushIfUnique($value, 'choices', $choice);
            }
        });
    }

    private function _arrayPushIfUnique(&$target, $key, $value) {
        if (! isset($target[$key])) {
            $target[$key] = [];
        }
        if (! in_array($value, $target[$key])) {
            $target[$key][] = $value;
        }
        return $target;
    }

    public function conflicts() {
        $conflicts = $this->_flatten(func_get_args());
        if (count($conflicts) < 2) throw new Exception('conflicts expects at least two params');
        $key = array_shift($conflicts);
        return $this->_set($key, function(&$data) use ($conflicts) {
            foreach ($conflicts as $conflict) {
                $this->_arrayPushIfUnique($data, 'conflicts', $conflict);
            }
        });
    }

    protected function _flatten(Array $array) {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), FALSE);
    }

    public function count($key) {
        return $this->_set($key, function(&$data) {
            $data['count'] = true;
        });
    }

    public function default($key, $value) {
        return $this->_set($key, function(&$data) use ($value) {
            $data['default'] = $value;
        });
    }

    public function demand($key, $message = '') {
        return $this->_set($key, function(&$data) use ($message) {
            $data['demand'] = $message;
        });
    }

    public function describe($key, $message = '') {
        return $this->_set($key, function(&$data) use ($message) {
            $data['description'] = $message;
        });
    }

    public function hide($key) {
        return $this->_set($key, function(&$data) {
            $data['hidden'] = true;
        });
    }

}
