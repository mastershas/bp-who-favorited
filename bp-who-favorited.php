<?php
/**
 * @wordpress-plugin
 * Plugin Name:       BP Who Favorited
 * Plugin URI:        www.faveteacher.com/shashi_kumar
 * Description:       A plugin to show who favorited the buddypress activity
 * Version:           1.0.0
 * Author:            Shashi Kumar
 * Author URI:        www.faveteacher.com/shashi_kumar
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp-who-favorited
 * Domain Path:       /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Autoload Classes
define('BWF_PATH', dirname(__FILE__));

function bwf_autoloadclass($class)
{
    $c = explode('_', $class);
    if ($c === false || count($c) != 3 || ($c[0] !== 'BPWF') ) {
        return;
    }
    switch ($c[1]) {
        case 'View':
            $dir = 'view';
            break;
        case 'Model':
            $dir = 'model';
            break;
        case 'Helper':
            $dir = 'helper';
            break;
        case 'Controller':
            $dir = 'controller';
            break;
        case 'Plugin':
            $dir = 'plugin';
            break;
        default:
            return;
    }

    $classPath = BWF_PATH . '/lib/' . $dir . '/' . $class . '.php';
    
    if (file_exists($classPath)) 
    {
        /** @noinspection PhpIncludeInspection */
        include_once $classPath;
    }
}

spl_autoload_register('bwf_autoloadclass');

new BPWF_Helper_Init();

register_activation_hook( __FILE__, array('BPWF_Helper_Init','init') );

