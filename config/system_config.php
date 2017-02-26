<?php
// time zone setting
date_default_timezone_set('Asia/Taipei');

// exceute time
set_time_limit(0);

// error handle
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

// Exception handler
function exception_handler($exception) {

    echo 'Uncaught exception:<br>'.$exception->getMessage().'<br>';
    echo '<pre>';
    $info = debug_backtrace()[0]['args'][0];
    echo 'Exception at: '.$info->getFile().'('.$info->getLine().')'.PHP_EOL.'History:'.PHP_EOL;
    print_r($info->getTrace());
    echo '</pre>';

}
set_exception_handler('exception_handler');

// site root
define(SITE_ROOT, $_SERVER['DOCUMENT_ROOT']);

// site map
define(ASSET_ROOT, SITE_ROOT.DIRECTORY_SEPARATOR.'asset');
    define(SQL_ROOT, ASSET_ROOT.DIRECTORY_SEPARATOR.'sql');
        define(DATA_SQL_ROOT, SQL_ROOT.DIRECTORY_SEPARATOR.'data');
        define(TABLE_SQL_ROOT, SQL_ROOT.DIRECTORY_SEPARATOR.'table');
    define(TEMPLATE_ROOT, ASSET_ROOT.DIRECTORY_SEPARATOR.'template');
define(CLASS_ROOT, SITE_ROOT.DIRECTORY_SEPARATOR.'class');
    define(CORE_ROOT, CLASS_ROOT.DIRECTORY_SEPARATOR.'core');
    define(DAO_ROOT, CLASS_ROOT.DIRECTORY_SEPARATOR.'dao');
    define(MODEL_ROOT, CLASS_ROOT.DIRECTORY_SEPARATOR.'model');
    define(SERVICE_ROOT, CLASS_ROOT.DIRECTORY_SEPARATOR.'service');
    define(UTIL_ROOT, CLASS_ROOT.DIRECTORY_SEPARATOR.'util');
    define(WEB_ROOT, CLASS_ROOT.DIRECTORY_SEPARATOR.'web');
define(CONFIG_ROOT, SITE_ROOT.DIRECTORY_SEPARATOR.'config');
define(LIB_ROOT, SITE_ROOT.DIRECTORY_SEPARATOR.'lib');
define(ROUTER_ROOT, SITE_ROOT.DIRECTORY_SEPARATOR.'router');
    define(ACTION_ROOT, ROUTER_ROOT.DIRECTORY_SEPARATOR.'action');
    define(API_ROOT, ROUTER_ROOT.DIRECTORY_SEPARATOR.'api');
    define(CONTROLLER_ROOT, ROUTER_ROOT.DIRECTORY_SEPARATOR.'controller');
define(STATIC_PATH, DIRECTORY_SEPARATOR.'static');
    define(CSS_PATH, STATIC_PATH.DIRECTORY_SEPARATOR.'css');
    define(IMG_PATH, STATIC_PATH.DIRECTORY_SEPARATOR.'img');
    define(JS_PATH, STATIC_PATH.DIRECTORY_SEPARATOR.'js');
define(VIEW_ROOT, SITE_ROOT.DIRECTORY_SEPARATOR.'view');
    define(COMPONENT_ROOT, VIEW_ROOT.DIRECTORY_SEPARATOR.'component');
    define(LAYOUT_ROOT, VIEW_ROOT.DIRECTORY_SEPARATOR.'layout');
    define(PAGE_ROOT, VIEW_ROOT.DIRECTORY_SEPARATOR.'page');

// dev template
define(ACTION_TEMPLATE_FILE, TEMPLATE_ROOT.DIRECTORY_SEPARATOR.'ActionTemplate.php');
define(API_TEMPLATE_FILE, TEMPLATE_ROOT.DIRECTORY_SEPARATOR.'APITemplate.php');
define(CONTROLLER_TEMPLATE_FILE, TEMPLATE_ROOT.DIRECTORY_SEPARATOR.'ControllerTemplate.php');
define(DAO_TEMPLATE_FILE, TEMPLATE_ROOT.DIRECTORY_SEPARATOR.'DaoTemplate.php');
define(MODEL_TEMPLATE_FILE, TEMPLATE_ROOT.DIRECTORY_SEPARATOR.'ModelTemplate.php');
define(TABLE_SQL_TEMPLATE_FILE, TEMPLATE_ROOT.DIRECTORY_SEPARATOR.'TableSQLTemplate.sql');

// config files path
define(CLASS_LOADER_FILE, CONFIG_ROOT.DIRECTORY_SEPARATOR.'class_loader.php');
define(DB_CONFIG_FILE, CONFIG_ROOT.DIRECTORY_SEPARATOR.'database_config.php');
define(GLOBAL_VARIABLES_FILE, CONFIG_ROOT.DIRECTORY_SEPARATOR.'global_variables.php');

// include config files
require_once GLOBAL_VARIABLES_FILE;
require_once CLASS_LOADER_FILE;

// define some global function
function in_array_r($needle, $haystack, $strict = false)
{

    foreach ($haystack as $item) {

        if (   ($strict ? $item === $needle : $item == $needle)
            || (is_array($item) && in_array_r($needle, $item, $strict))
        ) {

            return true;

        }

    }

    return false;

}
