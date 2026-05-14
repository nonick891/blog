<?php

namespace Core;

class Request
{
    public function get(string $key, string $default = ''): string
    {
        if (!isset($_REQUEST[$key])) {
            return $default;
        }

        $value = $_REQUEST[$key];

        return self::sanitize(is_scalar($value) ? (string)$value : '');
    }

    private function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}
