<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit214c8db2e805f9abe87f1bd1ed35e37a
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit214c8db2e805f9abe87f1bd1ed35e37a', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit214c8db2e805f9abe87f1bd1ed35e37a', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit214c8db2e805f9abe87f1bd1ed35e37a::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}