<?php

namespace Rdlv\WordPress\Registry;

class Registry
{
    private static $services = [];

    /**
     * @param object $object
     * @param string|null $key
     * @return void
     */
    public static function set(object $object, string $key = null): void
    {
        self::$services[$key ?? get_class($object)] = $object;
    }

    /**
     * @param string $key
     * @return object|null
     */
    public static function get(string $key): ?object
    {
        return self::$services[$key] ?? null;
    }
}
