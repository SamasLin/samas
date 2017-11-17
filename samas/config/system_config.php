<?php
// time zone setting
date_default_timezone_set('Asia/Taipei');

// exceute time
set_time_limit(0);

// error handle
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

// Exception handler
function exception_handler($exception)
{

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
$site_map = [
    'asset' => [
        'sql' => [
            'data'  => '',
            'table' => ''
        ],
        'template' => ''
    ],
    'class' => [
        'core' => [
            'dao' => ''
        ],
        'lister'  => '',
        'model'   => '',
        'service' => '',
        'trait'   => '',
        'util'    => '',
        'web'     => ''
    ],
    'config' => '',
    'lib' => '',
    'router' => [
        'action'     => '',
        'api'        => '',
        'controller' => ''
    ],
    'static' => [
        'css'   => '',
        'image' => '',
        'js'    => ''
    ],
    'view' => [
        'component' => '',
        'layout'    => '',
        'page'      => ''
    ]
];
function define_path_constant($parent, $child)
{

    foreach ($child as $key => $value) {
        $constant_key = strtoupper($key).'_ROOT';
        define($constant_key, $parent.DIRECTORY_SEPARATOR.$key);
        if (is_array($child)) {
            define_path_constant(constant($constant_key), $value);
        }
    }
}
define_path_constant(SITE_ROOT, $site_map);

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

// include config files
require_once CLASS_LOADER_FILE;