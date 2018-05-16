<?php

namespace Coax;

use Coax\Util;
use Coax\CoaxOption;

class CoaxOptions {

    protected $_options = [];
    protected $_epilogueMessage = '';
    protected $_failureCallback = null;
    protected $_middlewares = [];
    protected $_showHelpOnFail = true;

    public function getOptions() {
        return $this->_options;
    }

    public function alias($tag, $aliases) {
        return $this->_set($tag, function(&$option) use ($aliases) {
            $option->alias($aliases);
        });
    }

    public function castToArray($tag) {
    }

    public function castToBoolean($tag) {
    }

    public function choices($tag, $choices) {
    }

    public function coerce($tag, $callback) {
    }

    public function conflicts() {
    }

    public function count($tag) {
    }

    public function defaultTo($tag, $value) {
    }

    public function demand($tag, $message = '') {
    }

    public function describe($tag, $message = '') {
    }

    public function hide($tag) {
    }

    public function epilogue($message) {
        $this->_epilogueMessage = $message;
        return $this;
    }

    public function example($tag, $message) {
    }

    public function fail($callback) {
        if (! is_callable($callback)) throw new Exception('fail expects callback');
        $this->_failureCallback = $callback;
        return $this;
    }

    public function group($tags, $groupName) {
    }

    public function help($tag, $message = '') {
    }

    public function implies($tag, $otherKey) {
    }

    public function middleware($middlewares) {
        if (! is_array($middlewares)) {
            $middlewares = [ $middlewares ];
        }
        foreach ($middlewares as $middleware) {
            if (! is_callable($middleware)) throw new \Exception('middleware expects callback to be callable');
            $this->_middlewares[] = $middleware;
        }
        return $this;
    }

    public function nargs($tag, $n) {
    }

    public function castToNumber($tag) {
    }

    public function showHelpOnFail($message = '') {
        if (strlen($message)) {
            $this->_showHelpOnFail = $message;
        } else {
            $this->_showHelpOnFail = true;
        }
        return $this;
    }

    public function castToString($tag) {
    }

    protected function _getTag($tag) {
        if (! isset($this->_options[$tag])) {
            return $this->_setTag($tag, new CoaxOption($tag));
        }
        return $this->_options[$tag];
    }

    protected function _setTag($tag, $value) {
        //if ($this->_isAlias($tag)) throw new Exception($tag . ' is an existing alias.');
        $this->_options[$tag] = $value;
        return $this;
    }

    protected function _set($tag, $callback) {
        if (! is_string($tag)) throw new Exception('_set expects tag to be string');
        if (! is_callable($callback)) throw new Exception('_set expects callback to be callable');
        $option = $this->_getTag($tag);
        $callback($option);
        $this->_setTag($tag, $option);
        return $this;
    }

    protected function _isAlias($tag) {
    }

}
