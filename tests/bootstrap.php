<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../system/kissmvc.php');

// Below are functions defined in index.php that are needed to run isolated controller tests.

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
