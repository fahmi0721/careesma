<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd19281b3e7fada78cc14a1ba93344355
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd19281b3e7fada78cc14a1ba93344355::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd19281b3e7fada78cc14a1ba93344355::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd19281b3e7fada78cc14a1ba93344355::$classMap;

        }, null, ClassLoader::class);
    }
}