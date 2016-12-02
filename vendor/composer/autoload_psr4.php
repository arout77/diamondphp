<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Web\\Model\\' => array($baseDir . '/public/models'),
    'Web\\Controller\\' => array($baseDir . '/public/controllers'),
    'Symfony\\Component\\EventDispatcher\\' => array($vendorDir . '/symfony/event-dispatcher'),
    'Hal\\Module\\' => array($baseDir . '/app/code/module'),
    'Hal\\Model\\' => array($baseDir . '/app/code/core/models'),
    'Hal\\ModelOverride\\' => array($baseDir . '/public/override/models'),
    'Hal\\Core\\' => array($baseDir . '/app/code/core/system'),
    'Hal\\CoreModelOverride\\' => array($baseDir . '/app/code/override/models'),
    'Hal\\CoreControllerOverride\\' => array($baseDir . '/app/code/override/controllers'),
    'Hal\\Controller\\' => array($baseDir . '/app/code/core/controllers'),
    'Hal\\ControllerOverride\\' => array($baseDir . '/public/override/controllers'),
    'Hal\\Config\\' => array($baseDir . '/app/code/core/config'),
    'Hal\\Block\\' => array($baseDir . '/app/code/core/blocks'),
    'Database\\Orm\\R\\' => array($vendorDir . '/redbean'),
);
