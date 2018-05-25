<?php

use Coax\CoaxOption;

trait CoaxProviders {

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

    public function coaxOptionProvider() {
        return [
            [new CoaxOption('a'), 'a'],
            [new CoaxOption('b'), 'b']
        ];
    }

}
