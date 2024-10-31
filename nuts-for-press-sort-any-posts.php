<?php
/*
Plugin Name: 	NutsForPress Sort Any Posts
Plugin URI:		https://www.nutsforpress.com/
Description: 	NutsForPress Sort Any Posts is a simple and lightweight plugin that allows you to sort any kind of posts and show them in the order you've decided.
Version:     	1.3
Author:			Christian Gatti
Author URI:		https://profiles.wordpress.org/christian-gatti/
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:	nutsforpress-sort-any-posts
*/

//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');


//DEFINITIONS

if(!defined('NFPROOT_BASE_RELATIVE')) {define('NFPROOT_BASE_RELATIVE', dirname(plugin_basename( __FILE__ )).'/root');}
define('NFPSAP_BASE_PATH', plugin_dir_path( __FILE__ ));
define('NFPSAP_BASE_URL', plugins_url().'/'.plugin_basename( __DIR__ ).'/');
define('NFPSAP_BASE_RELATIVE', dirname( plugin_basename( __FILE__ )));
define('NFPSAP_DEBUG', false);


//NUTSFORPRESS ROOT CONTENT
		
//add NutsForPress parent menu page
require_once NFPSAP_BASE_PATH.'root/nfproot-settings.php';
add_action('admin_menu', 'nfproot_settings');

//add NutsForPress save settings function and make it available through ajax
require_once NFPSAP_BASE_PATH.'root/nfproot-save-settings.php';
add_action('wp_ajax_nfproot_save_settings', 'nfproot_save_settings');

//add NutsForPress saved settings and make them available through the global varibales $nfproot_current_language_settings and $nfproot_options_name
require_once NFPSAP_BASE_PATH.'root/nfproot-saved-settings.php';
add_action('plugins_loaded', 'nfproot_saved_settings');

//register NutsForPress styles and scripts
require_once NFPSAP_BASE_PATH.'root/nfproot-styles-and-scripts.php';
add_action('admin_enqueue_scripts', 'nfproot_styles_and_scripts');
	
//add NutsForPress settings structure that contains nfproot_options_structure function invoked by plugin settings
require_once NFPSAP_BASE_PATH.'root/nfproot-settings-structure.php';


//PLUGIN INCLUDES

//add activate actions
require_once NFPSAP_BASE_PATH.'includes/nfpsap-plugin-activate.php';
register_activation_hook(__FILE__, 'nfpsap_plugin_activate');

//add deactivate actions
require_once NFPSAP_BASE_PATH.'includes/nfpsap-plugin-deactivate.php';
register_deactivation_hook(__FILE__, 'nfpsap_plugin_deactivate');

//add uninstall actions
require_once NFPSAP_BASE_PATH.'includes/nfpsap-plugin-uninstall.php';
register_uninstall_hook(__FILE__, 'nfpsap_plugin_uninstall');


//PLUGIN SETTINGS

//add plugin settings
require_once NFPSAP_BASE_PATH.'admin/nfpsap-settings.php';
add_action('admin_menu', 'nfpsap_settings');


//PUBLIC INCLUDES CONDITIONALLY

//load sort function into frontend
require_once NFPSAP_BASE_PATH.'public/includes/nfpsap-public-sort.php';
add_action('pre_get_posts', 'nfpsap_public_sort');


//ADMIN INCLUDES CONDITIONALLY

//load sort function into backend
require_once NFPSAP_BASE_PATH.'admin/includes/nfpsap-admin-sort.php';
add_action('admin_menu', 'nfpsap_admin_sort');