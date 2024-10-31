<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//sort posts
if(!function_exists('nfpsap_public_sort')) {
	
	function nfpsap_public_sort($nfpsap_current_query) {
		
		//get options 
		global $nfproot_current_language_settings;

		//if sort post is enabled
		if(

			!empty($nfproot_current_language_settings['nfpsap']['nfproot_sort_posts'])
			&& $nfproot_current_language_settings['nfpsap']['nfproot_sort_posts'] === '1'
								
		){

			//get options to deal with post types
			$nfpsap_options_array = $nfproot_current_language_settings['nfpsap'];
			
			$nfpsap_post_types_to_order = array();
			
			//loop into post options
			foreach($nfpsap_options_array as $nfpsap_option_key => $nfpsap_option_value){
				
				//check if option is releted to a post type and if it is switched on
				if(
				
					substr($nfpsap_option_key, 0, 18 ) === 'nfproot_post_type_'
					&& $nfpsap_option_value === '1'
					
				){
					
					//get the involved post type
					$nfpsap_option_key_exploded = explode('nfproot_post_type_', $nfpsap_option_key);
					$nfpsap_post_type = $nfpsap_option_key_exploded[1];
					
					//check if post type exists
					if(post_type_exists($nfpsap_post_type)){

						$nfpsap_post_types_to_order[] = $nfpsap_post_type;
						
					}
					
				}
				
			}

			//if at least a post type is found and if the current query is related to that post type
			if(
			
				/*!empty($nfpsap_post_types_to_order)
				&& in_array($nfpsap_current_query->get('post_type'), $nfpsap_post_types_to_order) 
				&& !is_admin()*/
				
				!empty($nfpsap_post_types_to_order)
				&& (
					in_array($nfpsap_current_query->get('post_type'), $nfpsap_post_types_to_order) 
					|| empty($nfpsap_current_query->get('post_type'))
				)
				&& !is_admin()
			
			){
				
				//set order by post meta
				$nfpsap_meta_key_args = array(
					'relation' => 'OR',
					  array(
						 'key' => '_nfpas_post_order',
						 'compare' => 'NOT EXISTS',
						 'type' => 'NUMERIC',
					  ),
					  array(
						 'key' => '_nfpas_post_order',
						 'compare' => 'EXISTS',
						 'type' => 'NUMERIC',
					  ),
				);
							
				$nfpsap_current_query->set('meta_query', $nfpsap_meta_key_args);
				$nfpsap_current_query->set('orderby', '_nfpas_post_order date');  
				$nfpsap_current_query->set('order', 'ASC');
 
			}
			
		}

	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_public_sort" already exists');
	
}