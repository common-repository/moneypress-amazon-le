<?php
/*
Plugin Name: MoneyPress Amazon Edition
Plugin URI: http://www.charlestonsw.com/product/moneypress-amazon/
Description: Put Amazon product listings on your posts and pages using a simple short code.  Great for earning affiliate revenue or adding content.     
Version: 0.6
Author: Charleston Software Associates
Author URI: http://www.charlestonsw.com
License: GPL3

Copyright 2013 CSA (info@charlestonsw.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**/

// Drive Path Defines 
//
if (defined('MP_AMZ_PLUGINDIR') === false) {
    define('MP_AMZ_PLUGINDIR', plugin_dir_path(__FILE__));
}
if (defined('MP_AMZ_ICONDIR') === false) {
    define('MP_AMZ_ICONDIR', MP_AMZ_COREDIR . 'images/icons/');
}

// URL Defines
//
if (defined('MP_AMZ_PLUGINURL') === false) {
    define('MP_AMZ_PLUGINURL', plugins_url('',__FILE__));
}
if (defined('MP_AMZ_ICONURL') === false) {
    define('MP_AMZ_ICONURL', MP_AMZ_COREURL . 'images/icons/');
}

// The relative path from the plugins directory
//
if (defined('MP_AMZ_BASENAME') === false) {
    define('MP_AMZ_BASENAME', plugin_basename(__FILE__));
}


// Our product prefix
//
if (defined('MP_AMZ_PREFIX') === false) {
    define('MP_AMZ_PREFIX', 'mpamz');
}


// Include our needed files
//
include_once(MP_AMZ_PLUGINDIR.'/config.php');
include_once(MP_AMZ_PLUGINDIR . 'plus.php'   );
include_once(MP_AMZ_PLUGINDIR   . 'csl_helpers.php'       );
if (class_exists('PanhandlerProduct') === false) {
    try {
        require_once('Panhandler/Panhandler.php');
    }
    catch (PanhandlerMissingRequirement $exception) {
        add_action('admin_notices', array($exception, 'getMessage'));
        exit(1);
    }
}
if (class_exists('CafePressPanhandler') === false) {
    try {
        require_once('Panhandler/Drivers/Amazon.php');
    }
    catch (PanhandlerMissingRequirement $exception) {
        add_action('admin_notices', array($exception, 'getMessage'));
        exit(1);
    }
}

register_activation_hook( __FILE__, 'csl_mpamz_activate');

add_action('wp_footer', 'csl_mpamz_user_stylesheet');
add_action('admin_print_styles','csl_mpamz_admin_stylesheet');
add_action('admin_init','csl_mpamz_setup_admin_interface',10);
