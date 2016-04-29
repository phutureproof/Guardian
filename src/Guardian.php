<?php
/**
 * PhutureProof/Guardian
 * Simple dependency injection container
 *
 * Dale Paget <dale@phutureproof.com>
 */

namespace PhutureProof;

use PhutureProof\Guardian\Exceptions\ResolverMissingException;

class Guardian
{
    protected static $dependencies = [];

    public static function register($name, $dependency)
    {
        static::$dependencies[$name] = $dependency;
    }

    public static function make($name, $params = [])
    {
        if (isset(static::$dependencies[$name])) {
            $resolver = static::$dependencies[$name];
            return call_user_func_array($resolver, [$params]);
        }

        throw new ResolverMissingException("Guardian Error::No dependency found for {$name}");
    }

    public static function getDependencies()
    {
        return static::$dependencies;
    }
}