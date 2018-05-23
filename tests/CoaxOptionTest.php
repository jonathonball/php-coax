<?php

use PHPUnit\Framework\TestCase;
use Coax\CoaxOption;

class CoaxOptionTest extends TestCase {

    public function goodTagProvider() {
        return [
            ['e'],
            ['example']
        ];
    }

    public function badTagProvider() {
        return [
            [1],
            [new stdClass]
        ];
    }

    /**
     * @dataProvider goodTagProvider
     */
    public function testCanCreateFromString($tag) {
        $this->assertInstanceOf(
            'Coax\CoaxOption',
            new CoaxOption($tag)
        );
    }

    /**
     * @dataProvider goodTagProvider
     */
    public function testCanCreateFromCoaxOption($tag) {
        $this->assertInstanceOf(
            'Coax\CoaxOption',
            new CoaxOption($tag)
        );
    }

}
