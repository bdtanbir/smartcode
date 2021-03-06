<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf9bebc2f658c0d353a5f2c9f77d652c
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tanbirahmed\\Smartcode\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tanbirahmed\\Smartcode\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitdf9bebc2f658c0d353a5f2c9f77d652c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdf9bebc2f658c0d353a5f2c9f77d652c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdf9bebc2f658c0d353a5f2c9f77d652c::$classMap;

        }, null, ClassLoader::class);
    }
}
