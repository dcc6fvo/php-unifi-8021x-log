<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3a6ee0c8dd10e409fab07a1e841a8386
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UniFi_API\\' => 10,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UniFi_API\\' => 
        array (
            0 => __DIR__ . '/..' . '/art-of-wifi/unifi-api-client/src',
        ),
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit3a6ee0c8dd10e409fab07a1e841a8386::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3a6ee0c8dd10e409fab07a1e841a8386::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3a6ee0c8dd10e409fab07a1e841a8386::$classMap;

        }, null, ClassLoader::class);
    }
}