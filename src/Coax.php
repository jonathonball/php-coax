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

    /**
     * Finds or creates a new command line option
     * @param string|CoaxOption $option An option tag or object
     * @return Coax\CoaxOption
     */
    public function option($option) {
        return $this->_options->option($option);
    }

    /**
     * Finds or creates an array of tags or options
     * @param array $array Array of string or Coax\CoaxOption
     * @return Coax\CoaxOption
     */
    public function options($options = null) {
        if ($options === null) return $this->_options;
        if (! is_array($options)) {
            $options = [ $options ];
        }
        foreach ($options as $option) {
            $this->option($option);
        }
    }

    // single letter is always /^-[[:alphanum:]]{1}/
    // multi letter is always /^--[[:alphanum:]]{2,}/
    // everything else is either a param argument
    // or a positional param (_)
    public function parse() {
        $output = [];
        $arguments = $this->getArguments();
        $output['$0'] = array_shift($arguments);
    }

}
