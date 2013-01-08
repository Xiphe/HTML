<?php

namespace Xiphe\HTML\core;

if (!function_exists('\__')) {
    function __($str) {
        return $str;
    }
}
if (!function_exists('\_e')) {
    function _e($str) {
        return $str;
    }
}