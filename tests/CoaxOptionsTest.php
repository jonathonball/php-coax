<?php

use PHPUnit\Framework\TestCase;
use Coax\CoaxOptions;
require_once("CoaxProviders.php");

class CoaxOptionsTest extends TestCase {

    use CoaxProviders;

    public function testCreation() {
        $options = new CoaxOptions();
        $this->assertInstanceOf(
            'Coax\CoaxOptions',
            $options
        );
        return $options;
    }

    /**
     * @depends testCreation
     * @dataProvider coaxOptionProvider
     */
    public function testCanAddOption($option, $tag, $options) {
        $options->option($option);
        $this->assertEquals(
            $options->getOptions()[$tag]->getTag(),
            $tag
        );
    }

    public function testOptionsAreIterable() {
        $options = new CoaxOptions();
        $tags = ['a' => 'a', 'b' => 'b', 'example' => 'example'];
        foreach ($tags as $tag) {
            $options->option($tag);
        }
        $count = 0;
        foreach ($options as $key => $value) {
            $this->assertEquals($tags[$key], $value->getTag());
            $count++;
        }
        $this->assertEquals(count($tags), $count);
    }

}
