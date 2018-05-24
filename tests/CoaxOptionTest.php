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

    public function testRequiredWithMessage() {
        $message = 'example param is required';
        $option = new CoaxOption('example');
        $option->demand('example param is required');
        $this->assertEquals(
            $message,
            $option->isRequired()
        );
    }

    public function testRequiredWithoutMessage() {
        $option = new CoaxOption('example');
        $option->demand();
        $this->assertTrue($option->isRequired());
    }

}
