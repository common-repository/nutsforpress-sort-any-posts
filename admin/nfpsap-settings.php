<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//with this function we will create the NutsForPress menu page
if(!function_exists('nfpsap_settings')) {
	
	function nfpsap_settings() {	
		
		global $nfproot_plugins_settings;
		$nfpsap_pro = null;
		
		if(
		
			!empty($nfproot_plugins_settings) 
			&& !empty($nfproot_plugins_settings['installed_plugins']['nfpsap']['edition'])
			&& $nfproot_plugins_settings['installed_plugins']['nfpsap']['edition'] === 'registered'
			
		) {
			
			$nfpsap_pro = ' <span class="dashicons dashicons-saved"></span>';
			
		}
		
		add_submenu_page(
	
			'nfproot-settings',
			'Sort Any Posts',
			'Sort Any Posts'.$nfpsap_pro,
			'manage_options',
			'nfpsap-settings',
			'nfpsap_settings_callback'
		
		);
		
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_base_options" already exists');
	
}
	
//with this function we will define the NutsForPress menu page content
if(!function_exists('nfpsap_settings_callback')) {
	
	function nfpsap_settings_callback() {
		
		?>
		
		<div class="wrap nfproot-settings-wrap">
			
			<h1>Sort Any Posts settings</h1>
			
			<div class="nfproot-settings-main-container">
		
				<?php
				
				//include option content page
				require_once NFPSAP_BASE_PATH.'admin/nfpsap-settings-content.php';
				
				//define contents as result of the function nfpsap_settings_content
				$nfpsap_settings_content = nfpsap_settings_content();
				
				//invoke nfproot_options_structure functions included into /root/options/nfproot-options-structure.php
				nfproot_settings_structure($nfpsap_settings_content);
				
				?>
			
			</div>
		
		</div>
		
		<?php
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_settings" already exists');
	
}