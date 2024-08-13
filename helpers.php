<?php

if (!function_exists('generate_token')) {
    function generate_token($length = 32)
    {
        return bin2hex(random_bytes($length));
    }
}
