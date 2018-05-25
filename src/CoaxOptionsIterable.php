<?php

namespace Coax;

abstract class CoaxOptionsIterable implements \Iterator {

    private $_index = 0;
    private $_tags = [];

    public function current() {
        return $this->option($this->key());
    }

    public function key() {
        return $this->_tags[$this->_index];
    }

    public function next() {
        $this->_index++;
    }

    public function rewind() {
        $this->_index = 0;
        $this->_tags = $this->getTags();
    }

    public function valid() {
        return array_key_exists($this->_index, $this->_tags);
    }

    public function getTags() {
        return array_keys($this->_options);
    }

}
