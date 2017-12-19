<?php
/**
 * Link do tutorial
 * https://www.devmedia.com.br/criando-um-crud-com-zend-framework-2-e-doctrine-2/32100
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';

//desabilitar erros
ini_set('display_errors', 0);

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
