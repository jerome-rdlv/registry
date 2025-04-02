<?php

namespace Rdlv\WordPress\Registry;

class Registry
{
    private static $services = [];
    private static $lazies = [];

    /**
     * @param  object|callable  $object  to store, or a callable factory that will be called just in time.
     * @param  string|null  $key
     * @param  bool  $lazy  If true, first argument will be called on first retreive and resulting object will be stored as real service
     * @return void
     */
    public static function set(object $object, ?string $key = null, bool $lazy = false): void
    {
        if ($lazy) {
            if (!is_callable($object)) {
                throw new \Exception('In lazy mode, first argument must be callable.');
            }
            if ($key === null) {
                throw new \Exception('Can not use lazy mode without a key.');
            }
            self::$lazies[$key] = $object;
            return;
        }
        self::$services[$key ?? get_class($object)] = $object;
    }

    /**
     * @param  string  $key
     * @return object|null
     */
    public static function get(string $key): ?object
    {
        if (array_key_exists($key, self::$lazies)) {
            self::$services[$key] = call_user_func(self::$lazies[$key]);
            unset(self::$lazies[$key]);
        }
        return self::$services[$key] ?? null;
    }
}
