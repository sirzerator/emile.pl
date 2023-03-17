<?php

if (!function_exists('_c')) {
    function _c(...$args) {
        return trans_choice(...$args);
    }
}

if (!function_exists('strip_accents')) {
    function strip_accents($str) {
        return strtr(
            utf8_decode($str),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }
}
