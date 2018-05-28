<?php

namespace Coax;

use Coax\Util;
use Coax\CoaxOption;

class CoaxOptions extends CoaxOptionsIterable {

    protected $_options = [];
    protected $_epilogueMessage = '';
    protected $_failureCallback = null;
    protected $_middlewares = [];
    protected $_showHelpOnFail = true;

    public function getOptions() {
        return $this->_options;
    }

    public function getTag($tag) {
        return Util::array_key_if_exists($this->_options, $tag);
    }

    /**
     * API functions
     */

    public function alias($tag, $aliases) {
        return $this->_set($tag, function(&$option) use ($aliases) {
            $option->alias($aliases);
        });
    }

    public function castToArray($tag) {
        return $this->_set($tag, function(&$option) {
            $option->castToArray();
        });
    }

    public function castToBoolean($tag) {
        return $this->_set($tag, function(&$option) {
            $option->castToBoolean();
        });
    }

    public function castToNumber($tag) {
        return $this->_set($tag, function(&$option) {
            $option->castToNumber();
        });
    }

    public function castToString($tag) {
        return $this->_set($tag, function(&$option) {
            $option->castToString();
        });
    }

    public function choices($tag, $choices) {
        return $this->_set($tag, function(&$option) use ($choices) {
            $option->choices($choices);
        });
    }

    public function coerce($tag, $callback) {
        return $this->_set($tag, function(&$option) use ($callback) {
            $option->coerce($callback);
        });
    }

    public function conflicts() {
        $arguments = func_get_args();
        return $this->_set($tag, function(&$option) use ($arguments) {
            $option->conflicts($arguments);
        });
    }

    public function count($tag) {
        return $this->_set($tag, function(&$option) {
            $option->count();
        });
    }

    public function defaultTo($tag, $value) {
        return $this->_set($tag, function(&$option) use ($value) {
            $option->defaultTo($value);
        });
    }

    public function demand($tag, $message = '') {
        return $this->required($tag, $message = '');
    }

    public function required($tag, $message = '') {
        return $this->_set($tag, function(&$option) use ($message) {
            $option->demand($message);
        });
    }

    public function describe($tag, $message = '') {
        return $this->_set($tag, function(&$option) use ($message) {
            $option->describe($message);
        });
    }

    public function example($tag, $message) {
        return $this->_set($tag, function(&$option) use ($message) {
            $option->example($message);
        });
    }

    public function group($tags, $groupName) {
        return $this->_set($tag, function(&$option) use ($groupName) {
            $option->group($groupName);
        });
    }

    public function hide($tag, $value) {
        return $this->_set($tag, function(&$option) use ($value) {
            $option->hide($message);
        });
    }

    public function implies($tag, $otherKeys) {
        return $this->_set($tag, function(&$option) use ($otherKeys) {
            $option->implies($otherKeys);
        });
    }

    public function nargs($tag, $n) {
        return $this->_set($tag, function(&$option) use ($n) {
            $option->nargs($n);
        });
    }

    public function help($tag) {
        return $this->_set($tag, function(&$option) {
            $option->help();
        });
    }

    /**
     * END api functions
     */

    public function epilogue($message) {
        $this->_epilogueMessage = $message;
        return $this;
    }

    public function fail($callback) {
        if (! is_callable($callback)) throw new Exception('fail expects callback');
        $this->_failureCallback = $callback;
        return $this;
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

    public function option($tag) {
        $data = $this->_getTag($tag);
        $this->_setTag($tag, $data);
        return $data;
    }

    public function showHelpOnFail($message = '') {
        if (strlen($message)) {
            $this->_showHelpOnFail = $message;
        } else {
            $this->_showHelpOnFail = true;
        }
        return $this;
    }

    protected function _getTag($tag) {
        if (Util::is_coax_option($tag)) return $this->_getCoaxOption($tag);
        if (! isset($this->_options[$tag])) {
            return $this->_setTag($tag, new CoaxOption($tag));
        }
        return $this->_options[$tag];
    }

    protected function _getCoaxOption($option) {
        $tag = $option->getTag();
        if (! isset($this->_options[$tag])) {
            return $this->_setTag($tag, $option);
        }
    }

    protected function _setTag($tag, $value) {
        if ($this->_isAlias($tag)) throw new \Exception($tag . ' is an existing alias.');
        $tag = (Util::is_coax_option($tag)) ? $tag->getTag() : $tag;
        $this->_options[$tag] = $value;
        return $value;
    }

    protected function _set($tag, $callback) {
        if (! is_string($tag)) throw new \Exception('_set expects tag to be string');
        if (! is_callable($callback)) throw new \Exception('_set expects callback to be callable');
        $option = $this->_getTag($tag);
        $callback($option);
        $this->_setTag($tag, $option);
        return $this;
    }

    protected function _isAlias($tag) {
        foreach ($this->_options as $name => $option) {
            $aliases = $option->getKey('aliases');
            if ($aliases && in_array($tag, $aliases)) return $name;
        }
        return false;
    }

}
