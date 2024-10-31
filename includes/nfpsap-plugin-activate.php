<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//ACTIVATE

//plugin activate function
if(!function_exists('nfpsap_plugin_activate')){

	function nfpsap_plugin_activate() {
				
		//get NutsForPress setting
		global $nfproot_plugins_settings;
		
		//define plugin installaton type
		$nfproot_plugins_settings['nfpsap']['prefix'] = 'nfpsap';
		$nfproot_plugins_settings['nfpsap']['slug'] = 'nfpsap-settings';
		$nfproot_plugins_settings['nfpsap']['edition'] = 'repository';
		$nfproot_plugins_settings['nfpsap']['name'] = 'Sort Any Posts';
		
		//update NutsForPress setting
		update_option('_nfproot_plugins_settings', $nfproot_plugins_settings, false);
			
	}
		
}  else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_plugin_activate" already exists');
	
}