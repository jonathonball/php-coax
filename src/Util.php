<?php

namespace Coax;

class Util {

    public static function flatten($array) {
        return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array)), FALSE);
    }

    public static function array_push_unique(&$target, $key, $value) {
        if (! isset($target[$key])) {
            $target[$key] = [];
        }
        if (! in_array($value, $target[$key])) {
            $target[$key][] = $value;
        }
        return $target;
    }

    public static function array_key_if_exists(&$target, $key) {
        if (! isset($target[$key])) return null;
        return $target[$key];
    }
}
