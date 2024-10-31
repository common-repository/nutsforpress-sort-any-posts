<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');
	
//with this function we will define the NutsForPress menu page content
if(!function_exists('nfpsap_settings_content')) {
	
	function nfpsap_settings_content() {
		
		//get builtin post types
		$nfpsap_builtin_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => true,
			'_builtin' => true,
			'publicly_queryable' => true
			
		);
			
		$nfpsap_builtin_post_types = get_post_types($nfpsap_builtin_post_types_args, 'objects');

		//get public post types
		$nfpsap_public_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => true,
			'_builtin' => false
			
		);
			
		$nfpsap_public_post_types = get_post_types($nfpsap_public_post_types_args, 'objects');
		
		//get private post types
		$nfpsap_private_post_types_args = array(
		
			'exclude_from_search' => false,
			'public'   => false,
			'_builtin' => false
			
		);
			
		$nfpsap_private_post_types = get_post_types($nfpsap_private_post_types_args, 'objects');
		
		//define child elements
		$nfpsap_settings_content_childs = array();

		//define post types to exclude
		$nfpsap_builtin_post_type_name_to_exclude = array('attachment');

		//loop into builtin post types
		foreach($nfpsap_builtin_post_types as $nfpsap_builtin_post_type){
			
			$nfpsap_builtin_post_type_name = $nfpsap_builtin_post_type->name;
			$nfpsap_builtin_post_type_label = $nfpsap_builtin_post_type->labels->name;
			
			if(in_array($nfpsap_builtin_post_type_name, $nfpsap_builtin_post_type_name_to_exclude)){
				
				continue;
				
			}
			
			$nfpsap_settings_content_childs[] = array(
			
				'container-title'	=> $nfpsap_builtin_post_type_label,
			
				'container-id'		=> 'nfpsap_post_type_container',
				'container-class' 	=> 'nfpsap-post-type-container',					
				'input-name' 		=> 'nfproot_post_type_'.$nfpsap_builtin_post_type_name,
				'add-to-settings'	=> 'global',
				'data-save'			=> 'nfpsap',
				'input-id' 			=> 'nfpsap_post_type_'.$nfpsap_builtin_post_type_name,
				'input-class'		=> 'nfpsap-post-type',
				'input-description' => __('Add','nutsforpress-sort-any-posts').' "'.$nfpsap_builtin_post_type_label.'" '.__('to the post types to order','nutsforpress-sort-any-posts'),
				'arrow-before'		=> false,
				'after-input'		=> '',
				'input-type' 		=> 'switch',
				'input-value'		=> 1,			
			
			
			);
			
		}
		
		//loop into public post types
		foreach($nfpsap_public_post_types as $nfpsap_public_post_type){
			
			$nfpsap_public_post_type_name = $nfpsap_public_post_type->name;
			$nfpsap_public_post_type_label = $nfpsap_public_post_type->labels->name;
			
			$nfpsap_settings_content_childs[] = array(
			
				'container-title'	=> $nfpsap_public_post_type_label,
			
				'container-id'		=> 'nfpsap_post_type_container',
				'container-class' 	=> 'nfpsap-post-type-container',					
				'input-name' 		=> 'nfproot_post_type_'.$nfpsap_public_post_type_name,
				'add-to-settings'	=> 'global',
				'data-save'			=> 'nfpsap',
				'input-id' 			=> 'nfpsap_post_type_'.$nfpsap_public_post_type_name,
				'input-class'		=> 'nfpsap-post-type',
				'input-description' => __('Add','nutsforpress-sort-any-posts').' "'.$nfpsap_public_post_type_label.'" '.__('to the post types to order','nutsforpress-sort-any-posts'),
				'arrow-before'		=> false,
				'after-input'		=> '',
				'input-type' 		=> 'switch',
				'input-value'		=> 1,			
			
			
			);
			
		}
		
		//loop into private post types
		foreach($nfpsap_private_post_types as $nfpsap_private_post_type){
			
			$nfpsap_private_post_type_name = $nfpsap_private_post_type->name;
			$nfpsap_private_post_type_label = $nfpsap_private_post_type->labels->name;
			
			$nfpsap_settings_content_childs[] = array(
			
				'container-title'	=> $nfpsap_private_post_type_label,
			
				'container-id'		=> 'nfpsap_post_type_container',
				'container-class' 	=> 'nfpsap-post-type-container',					
				'input-name' 		=> 'nfproot_post_type_'.$nfpsap_private_post_type_name,
				'add-to-settings'	=> 'global',
				'data-save'			=> 'nfpsap',
				'input-id' 			=> 'nfpsap_post_type_'.$nfpsap_private_post_type_name,
				'input-class'		=> 'nfpsap-post-type',
				'input-description' => __('Add','nutsforpress-sort-any-posts').' "'.$nfpsap_private_post_type_label.'" '.__('to the post types to order','nutsforpress-sort-any-posts'),
				'arrow-before'		=> false,
				'after-input'		=> '',
				'input-type' 		=> 'switch',
				'input-value'		=> 1,			
			
			
			);
			
		}
		
		//options content
		$nfpsap_settings_content = array(
		
			array(
			
				'container-title'	=> __('Enable the sort function','nutsforpress-sort-any-posts'),
				
				'container-id'		=> 'nfpsap_sort_posts_container',
				'container-class' 	=> 'nfpsap-sort-posts-container',
				'input-name'		=> 'nfproot_sort_posts',
				'add-to-settings'	=> 'global',
				'data-save'			=> 'nfpsap',
				'input-id'			=> 'nfpsap_sort_posts',
				'input-class'		=> 'nfpsap-sort-posts',
				'input-description'	=> __('If switched on, to the post types selected below will be added a menu link to open a page to order them','nutsforpress-sort-any-posts'),
				'arrow-before'		=> true,
				'after-input'		=> '',
				'input-type' 		=> 'switch',
				'input-value'		=> '1',
				
				'childs'			=> $nfpsap_settings_content_childs,
				
			),
				
		);
						
		return $nfpsap_settings_content;
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_settings_content" already exists');
	
}