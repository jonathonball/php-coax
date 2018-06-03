<?php

namespace Coax;

use Coax\Util;

class CoaxOption {

    protected $_data = [];
    protected $_tag = '';
    protected $_mutualExclusions = [];

    public function __construct($tag) {
        $this->_setTag($tag);
        return $this;
    }

    public function getData() {
        return $this->_data;
    }

    protected function _setTag($tag) {
        if (is_string($tag)) {
            $this->_tag = $tag;
            return $this;
        }
        if ($tag instanceof CoaxOption) {
            $this->_tag = $tag->getTag();
            $this->_data = $tag->getData();
            return $this;
        }
        throw new \Exception('CoaxOption expects tag to be string or CoaxOption');
    }

    public function getTag() {
        return $this->_tag;
    }

    public function getKey($key) {
        return Util::array_key_if_exists($this->_data, $key);
    }

    /**
     * API functions
     */

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
        $this->_checkMutualExclusionViolation('array');
        $this->_data['array'] = true;
        $this->_addMutuallyExclusiveFeatures(['boolean', 'number', 'string'], 'array');
        return $this;
    }

    public function castToBoolean() {
        $this->_checkMutualExclusionViolation('boolean');
        $this->_data['boolean'] = true;
        $this->_addMutuallyExclusiveFeatures(['array', 'number', 'string'], 'boolean');
        return $this;
    }

    public function castToNumber() {
        $this->_checkMutualExclusionViolation('number');
        $this->_data['number'] = true;
        $this->_addMutuallyExclusiveFeatures(['array', 'boolean', 'string'], 'number');
        return $this;
    }

    public function castToString() {
        $this->_checkMutualExclusionViolation('string');
        $this->_data['string'] = true;
        $this->_addMutuallyExclusiveFeatures(['array', 'boolean', 'number'], 'string');
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
        return $this->required($message);
    }

    public function required($message = '') {
        if (strlen($message)) {
            $this->_data['required'] = $message;
        } else {
            $this->_data['required'] = true;
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

    public function help() {
        $this->alias('h');
        $this->describe('An alias for -h');
        return $this;
    }

    /**
     * END api functions
     */

    public function isRequired() {
        if (array_key_exists('required', $this->_data)) {
            return $this->_data['required'];
        }
        return false;
    }

    protected function _addMutuallyExclusiveFeature($key, $conflictsWith) {
        if (! is_string($key)) throw new \Exception('Mutual exclusion key must be string');
        if (! is_string($conflictsWith)) throw new \Exception('Mutual exclusion conflict must be string');
        $this->_mutualExclusions[$key] = $conflictsWith;
        return $this;
    }

    protected function _addMutuallyExclusiveFeatures($keys, $conflictsWith) {
        foreach ($keys as $key) {
            $this->_addMutuallyExclusiveFeature($key, $conflictsWith);
        }
        return $this;
    }

    protected function _checkMutualExclusionViolation($key) {
         if (array_key_exists($key, $this->_mutualExclusions)) {
            throw new \Exception(
                'castTo' . ucfirst($key) . ' cannot be used with castTo' . ucfirst($this->_mutualExclusions[$key])
            );
        }
    }

}
