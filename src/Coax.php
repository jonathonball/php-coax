<?php

namespace Coax;

use Coax\CoaxOptions;

class Coax {

    protected $_options = null;
    protected $_argv = null;

    public function __construct($arguments = []) {
        $this->setArguments($arguments);
        $this->_options = new CoaxOptions();
    }

    /**
     * Sets the values to use as argv[]
     * @param array $arguments
     * @return $this
     */
    public function setArguments($arguments = []) {
        if (! is_array($arguments)) throw new Exception('Coax expects array');
        if (count($arguments)) {
            $this->_argv = array_merge([basename(__FILE__)], $arguments);
        } else {
            $this->_argv = $GLOBALS['argv'];
        }
        return $this;
    }

    /**
     * Gets the values representing argv[]
     * @return array
     */
    public function getArguments() {
        return $this->_argv;
    }

    public function options() {
        return $this->_options;
    }

}
