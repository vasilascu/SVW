<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit662aedcc6781129fa81bbdd533343456
{
    public static $files = array (
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fakerphp/faker/src/Faker',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit662aedcc6781129fa81bbdd533343456::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit662aedcc6781129fa81bbdd533343456::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit662aedcc6781129fa81bbdd533343456::$classMap;

        }, null, ClassLoader::class);
    }
}
