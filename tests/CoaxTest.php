<?php

use PHPUnit\Framework\TestCase;
use Coax\Coax;
use Coax\CoaxOption;
require_once("CoaxProviders.php");

class CoaxTest extends TestCase {

    use CoaxProviders;

    public function testCreation() {
        $this->assertInstanceOf(
            'Coax\Coax',
            new Coax()
        );
    }

}
