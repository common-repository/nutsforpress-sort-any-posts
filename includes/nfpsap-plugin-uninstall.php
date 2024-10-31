<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//UNINSTALL

//plugin uninstall function
if(!function_exists('nfpsap_plugin_uninstall')){

	function nfpsap_plugin_uninstall() {
		
		require_once NFPSAP_BASE_PATH.'root/nfproot-saved-settings.php';
		nfproot_saved_settings();
				
		global $nfproot_root_settings;
		global $nfproot_root_settings_name;
		
		if(!empty($nfproot_root_settings['nfpsap'])) {
			
			//unset plugin installaton
			unset($nfproot_root_settings['nfpsap']);
			
		}

		//if, after cleaning nfpsap settings, base settings is empty, delete it (no more NutsForPress plugins are installed)
		if(empty($nfproot_root_settings)) {

			//delete base settings
			delete_option($nfproot_root_settings_name);			
			
		} else {
			
			//update base settings
			update_option($nfproot_root_settings_name, $nfproot_root_settings, false);
			
		}

		//get all WPML active languages
		$nfpsap_get_wpml_active_languages = apply_filters('wpml_active_languages', false);

		//if WPML has active languages
		if(!empty($nfpsap_get_wpml_active_languages)) {
		  
			//loop into languages
			foreach($nfpsap_get_wpml_active_languages as $nfpsap_wpml_language) {

				$nfpsap_wpml_language_code = $nfpsap_wpml_language['language_code'];

				$nfproot_current_language_settings_name = '_nfproot_settings_'.$nfpsap_wpml_language_code;
				$nfproot_current_language_settings = get_option($nfproot_current_language_settings_name, false);
				
				if(!empty($nfproot_current_language_settings['nfpsap'])) {
					
					//unset plugin installaton
					unset($nfproot_current_language_settings['nfpsap']);
					
				}	
				
				//if, after cleaning nfpsap settings, language settings is empty, delete it (no more NutsForPress plugins are installed)
				if(empty($nfproot_current_language_settings)) {

					//delete language settings
					delete_option($nfproot_current_language_settings_name);			
					
				} else {
					
					//update language settings
					update_option($nfproot_current_language_settings_name, $nfproot_current_language_settings, false);
					
				}
								
			}
			
		}	
		
		//delete post meta created by this plugin
		delete_post_meta_by_key('_nfpas_post_order');
		
		//delete settings from the old plugin structure
		delete_option('_nfp_root_settings');
		delete_option('_nfp_settings');

	}
		
}  else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_plugin_uninstall" already exists');
	
}