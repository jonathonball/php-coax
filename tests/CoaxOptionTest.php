<?php

use PHPUnit\Framework\TestCase;
use Coax\CoaxOption;
require_once("CoaxProviders.php");

class CoaxOptionTest extends TestCase {

    use CoaxProviders;

    public function testCanCreateFromString() {
        $option = new CoaxOption('example');
        $this->assertInstanceOf(
            'Coax\CoaxOption',
            $option
        );
        return $option;
    }

    /**
     * @depends testCanCreateFromString
     */
    public function testCanCreateFromCoxOption($option) {
        $this->assertInstanceOf(
            'Coax\CoaxOption',
            new CoaxOption($option)
        );
    }

}
