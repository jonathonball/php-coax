<?php

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

}
