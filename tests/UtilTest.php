<?php 

use PHPUnit\Framework\TestCase;

use Coax\Util;
use Coax\CoaxOption;

class UtilTest extends TestCase {

    protected $exampleOption;

    protected function setUp() {
        $this->exampleOption = new CoaxOption('e');
    }

    public function testIsCoaxOption() {
        $this->assertTrue(Util::is_coax_option($this->exampleOption));
    }

}
