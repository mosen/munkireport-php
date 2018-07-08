<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../system/kissmvc.php');

// Below are functions defined in index.php that are needed to run isolated controller tests.

!defined('KISS') && define( 'KISS', 1 );

// Front controller
!defined('FC') && define('FC', realpath(__DIR__ .'/../public/index.php') );

!defined('PUBLIC_ROOT') && define('PUBLIC_ROOT', __DIR__ . '/../public' );
!defined('APP_ROOT') && define('APP_ROOT', dirname(PUBLIC_ROOT) . '/' );

// Load config
require APP_ROOT.'app/helpers/config_helper.php';
initDotEnv();
load_conf();

// Load conf (keeps variables out of global space)
function load_conf()
{
    $conf = array();

    $GLOBALS['conf'] =& $conf;

    // Load default configuration
    require_once(APP_ROOT . "config_default.php");

    if ((include_once "test_config.php") !== 1)
    {
        throw new \Exception('test_config missing');
    }

    // Convert auth_config to config item
    if(isset($auth_config))
    {
        $conf['auth']['auth_config'] = $auth_config;
    }

}


/**
 * Get config item
 * @param string config item
 * @param string default value (optional)
 * @author AvB
 **/
function conf($cf_item, $default = '')
{
    return array_key_exists($cf_item, $GLOBALS['conf']) ? $GLOBALS['conf'][$cf_item] : $default;
}

/**
 * Get session item
 * @param string session item
 * @param string default value (optional)
 * @author AvB
 **/
function sess_get($sess_item, $default = '')
{
    if (! isset($_SESSION))
    {
        return $default;
    }

    return array_key_exists($sess_item, $_SESSION) ? $_SESSION[$sess_item] : $default;
}

/**
 * Set session item
 * @param string session item
 * @param string value
 * @author AvB
 **/
function sess_set($sess_item, $value)
{
    if (! isset($_SESSION))
    {
        return false;
    }

    $_SESSION[$sess_item] = $value;

    return true;
}

//===============================================
// Defines
//===============================================
!defined('INDEX_PAGE') && define('INDEX_PAGE', conf('index_page'));
!defined('SYS_PATH') && define('SYS_PATH', conf('system_path') );
!defined('APP_PATH') && define('APP_PATH', conf('application_path') );
!defined('VIEW_PATH') && define('VIEW_PATH', conf('view_path'));
!defined('MODULE_PATH') && define('MODULE_PATH', conf('module_path'));
!defined('CONTROLLER_PATH') && define('CONTROLLER_PATH', conf('controller_path'));
!defined('EXT') && define('EXT', '.php'); // Default extension

require( APP_PATH.'helpers/site_helper'.EXT );

spl_autoload_register('munkireport_autoload');