<?php
/**
 * Created by PhpStorm.
 * User: Dale
 * Date: 12/04/2016
 * Time: 18:35
 */

namespace PhutureProof;

class Guardian
{
    protected static $resolvers = [];

    public static function register($name, $resolver)
    {
        static::$resolvers[$name] = $resolver;
    }

    public static function make($name, $params = [])
    {
        if (isset(static::$resolvers[$name])) {
            $resolver = static::$resolvers[$name];
            return call_user_func_array($resolver, $params);
        }

        throw new \Exception("Guardian Error::No resolver found for {$name}");
    }

    public static function getResolvers()
    {
        return static::$resolvers;
    }
}