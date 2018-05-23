<?php

use PHPUnit\Framework\TestCase;
use Coax\CoaxOption;
require_once("CoaxProviders.php");

class CoaxOptionTest extends TestCase {

    use CoaxProviders;

    /**
     * @dataProvider goodTagProvider
     */
    public function testCanCreateFromString($tag) {
        $this->assertInstanceOf(
            'Coax\CoaxOption',
            new CoaxOption($tag)
        );
    }

}
