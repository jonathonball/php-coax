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

    public function testAlias() {
        $option = new CoaxOption('a');
        $option->alias('alpha');
        $this->assertEquals(
            $option->getKey('aliases'),
            ['alpha']
        );
    }

    public function testCastToArray() {
        $option = new CoaxOption('a');
        $option->castToArray();
        $this->assertEquals(
            $option->getKey('array'),
            true
        );
    }

    public function testCastToBoolean() {
        $option = new CoaxOption('a');
        $option->castToBoolean();
        $this->assertEquals(
            $option->getKey('boolean'),
            true
        );
    }

    public function testCastToNumber() {
        $option = new CoaxOption('a');
        $option->castToNumber();
        $this->assertEquals(
            $option->getKey('number'),
            true
        );
    }

    public function testCastToString() {
        $option = new CoaxOption('a');
        $option->castToString();
        $this->assertEquals(
            $option->getKey('string'),
            true
        );
    }

    /**
     * @dataProvider mutuallyExcludeFeaturesProvider
     */
    public function testCastsAreMutuallyExclusive($first, $second) {
        $option = new CoaxOption('test');
        $option = call_user_func(array($option, $first));
        $this->expectException('Exception');
        $option = call_user_func(array($option, $second));
    }

}
