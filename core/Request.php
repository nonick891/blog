<?php

namespace Core;

class Request
{
    /**
     * @param array<int, string> $allowed
     */
    public function get(string $key, string $default = '', array $allowed = []): string
    {
        if (!isset($_REQUEST[$key])) {
            return $default;
        }

        $value = self::sanitize(is_scalar($_REQUEST[$key]) ? (string)$_REQUEST[$key] : '');

        return $allowed ? (in_array($value, $allowed, true) ? $value : $default) : $value;
    }

    private function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}
