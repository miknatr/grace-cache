<?php

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

$namespaces = array(
    'Grace\\Cache'        => __DIR__ . '/lib',
    'Grace\\Tests\\Cache' => __DIR__ . '/lib',
);

spl_autoload_register(function($className) use ($namespaces)
{
    $className = ltrim($className, '\\');

    foreach ($namespaces as $prefix => $dir) {
        if (strpos($className, $prefix) === 0) {
            $fileName  = $dir . DIRECTORY_SEPARATOR;

            if ($lastNsPos = strrpos($className, '\\')) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }

            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

            require $fileName;
        }
    }
});