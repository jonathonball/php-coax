<?php

namespace Coax;

use Coax\CoaxOptions;

class Coax {

    protected $_options = null;
    protected $_argv = null;
    protected $_parsed = [];

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

    public function parse() {
        try {
            return $this->_parse();
        } catch(\Exception $e) {
            echo $e->getMessage() . "\n";
            die(1);
        }
    }

    // TODO parser needs to set an "inspected" setting on each options
    protected function _parse() {
        $arguments = $this->getArguments();
        $this->_parsed['$0'] = array_shift($arguments);
        $this->_parsed['_'] = [];
        $this->_parsed['failures'] = [];
        // read in first argument
        $currentArgument = $this->extractArgument($arguments);
        while ($currentArgument !== null) {
            $currentTag = $this->isTag($currentArgument);
            $currentData = $this->options()->getTag($currentTag);
            if ($currentTag && ! $currentData) {
                $this->_parsed['failures'][] = new \Exception('Unrecognized argument: ' . $currentTag);
            } elseif ($currentTag && $currentData) {
                $this->_parsed[$currentTag] = [];
                // TODO do inspection of argument
                // TODO if argument has params attempt reaad them in
            } else {
                $this->_parsed['_'][] = $currentArgument;
            }
            // read in next argument
            $currentArgument = $this->extractArgument($arguments);
        }
        // TODO check that each requirement is "inspected"
        return $this->_parsed;
    }

    protected function extractArgument(&$arguments) {
        if (! is_array($arguments)) throw new \Exception('extractArgument expects array as first argument.');
        if (! count($arguments)) return null;
        return array_shift($arguments);
    }

    /**
     * Determines if an argument is a tag
     * @param string $argument
     * @return string|boolean The tag without hyphens or false
     */
    protected function isTag($argument) {
        if (preg_match('/^-{1,2}[a-zA-Z0-9]\w*/', $argument)) {
            return str_replace('-', '', $argument);
        }
        return false;
    }

}
