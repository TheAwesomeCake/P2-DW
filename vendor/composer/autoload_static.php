<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit981aa24c3e3848373bf70fee308894e5
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/backend',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit981aa24c3e3848373bf70fee308894e5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit981aa24c3e3848373bf70fee308894e5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit981aa24c3e3848373bf70fee308894e5::$classMap;

        }, null, ClassLoader::class);
    }
}