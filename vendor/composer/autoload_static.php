<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4c3db10d5e1da454f95eb50bd307d990
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'ProCore\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ProCore\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4c3db10d5e1da454f95eb50bd307d990::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4c3db10d5e1da454f95eb50bd307d990::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}