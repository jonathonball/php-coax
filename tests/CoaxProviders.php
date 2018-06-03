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

    public function mutuallyExcludeFeaturesProvider() {
        return [
            ['castToArray', 'castToBoolean'],
            ['castToArray', 'castToNumber'],
            ['castToArray', 'castToString'],
            ['castToBoolean', 'castToArray'],
            ['castToBoolean', 'castToNumber'],
            ['castToBoolean', 'castToString'],
            ['castToString', 'castToArray'],
            ['castToString', 'castToBoolean'],
            ['castToString', 'castToNumber'],
            ['castToNumber', 'castToArray'],
            ['castToNumber', 'castToBoolean'],
            ['castToNumber', 'castToString']
        ];
    }

}
