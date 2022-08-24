<?php
// backend main handler, will act as dispatcher
// define some global as on real MVC frameworks
define('PROJECT_ROOT', dirname($_SERVER['SCRIPT_FILENAME']));
/**
 * Java like print line
 * @param string|null $sText
 */
function println($sText = null) { print ($sText === false ? 0 : $sText).PHP_EOL; }

/**
 * Source from https://pt.stackoverflow.com/questions/96983/fun%C3%A7%C3%A3o-de-convers%C3%A3o-camelcase
 */
function toCamelCase($string) {
    //Converte todas as '-' em espaço em branco para a função ucwords funcionar.
    $string = str_replace('-', ' ', $string);

    return str_replace(' ', '', lcfirst(ucwords($string)));
}
/**
 * php path directive
 */
ini_set(
    'include_path',
    ini_get('include_path')
        .PATH_SEPARATOR.PROJECT_ROOT.DIRECTORY_SEPARATOR.'backend'
        .PATH_SEPARATOR.PROJECT_ROOT.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'config'
);
//println(ini_get('include_path'));
// print_r($_SERVER);
/**
 * an autoloader for our namespace
 */
spl_autoload_register(function ($name) {
    $sPath = str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
    @include_once $sPath;
});
/** with the autoloader defines, load class by namespaces */
use Emercado\Service\Env;
/** load environment */
Env::setEnvDir(PROJECT_ROOT);
$aEnv = \Emercado\Service\Env::all();

/**
 * developer mode
 */
if (Env::isDevelopment()) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', true);
}

/**
 * route management
 */
if (! array_key_exists('PATH_INFO', $_SERVER)) {
    exit(1);
}
@list(, $sController, $sAction) = explode('/', $_SERVER['PATH_INFO']);
$sAction = toCamelCase($sAction);
$sController = 'Emercado\Controller\\'.ucfirst($sController);
if (! class_exists($sController) || !method_exists($sController, $sAction)) {
    header("HTTP/1.1 404 Not Found");
    exit(1);
}

(new $sController())->$sAction();
