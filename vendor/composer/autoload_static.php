<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5cb3c893949de20e7a428ee6640eb8a1
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Webwarrd\\Core\\' => 14,
        ),
        'A' => 
        array (
            'App\\Account\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Webwarrd\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/system',
        ),
        'App\\Account\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5cb3c893949de20e7a428ee6640eb8a1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5cb3c893949de20e7a428ee6640eb8a1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5cb3c893949de20e7a428ee6640eb8a1::$classMap;

        }, null, ClassLoader::class);
    }
}
