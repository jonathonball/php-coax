<?php

namespace Coax;

use Coax\Util;

class Requirement {

    private $_tag = '';
    private $_satisfied = false;

    public function __construct($tag) {
        $this->setTag($tag);
    }

    public function setTag($tag) {
        if (! is_string($tag)) throw new \Exception('Requirement expects tag to be string');
        $this->_tag = $tag;
        return $this;
    }

    public function getTag() {
        return $this->_tag;
    }

    public function satisfy() {
        $this->_satisfied = true;
        return $this;
    }

    public function isSatisfied() {
        return $this->_satisfied;
    }

    public function cancel() {
        $this->_satisfied = false;
        return $this;
    }

}
