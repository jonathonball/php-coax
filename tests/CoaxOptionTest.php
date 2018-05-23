<?php

use PHPUnit\Framework\TestCase;
use Coax\CoaxOption;

class CoaxOptionTest extends TestCase {

    protected $goodTags = ['e', 'example'];
    protected $badTags = [1];

    protected function setUp() {
        array_push($this->badTags, new stdClass);
    }
    
    public function testCanCreateFromString() {
        foreach ($this->goodTags as $tag) {
            $this->assertInstanceOf(
                'Coax\CoaxOption',
                new CoaxOption($tag)
            );
        }
    }

    public function testCanCreateFromCoaxOption() {
        foreach ($this->goodTags as $tag) {
            $coaxOption = new CoaxOption($tag);
            $this->assertInstanceOf(
                'Coax\CoaxOption',
                $coaxOption
            );
        }
    }

}
