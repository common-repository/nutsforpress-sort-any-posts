<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//add a link to the post type menu to sort posts
if(!function_exists('nfpsap_admin_sort')) {
	
	function nfpsap_admin_sort() {
		
		//get options 
		global $nfproot_current_language_settings;

		//if sort post is enabled
		if(

			!empty($nfproot_current_language_settings['nfpsap']['nfproot_sort_posts'])
			&& $nfproot_current_language_settings['nfpsap']['nfproot_sort_posts'] === '1'
								
		) {
			
			//get options to deal with post types
			$nfpsap_options_array = $nfproot_current_language_settings['nfpsap'];
			
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
															
					//if post type exists, add the submenu page
					if(post_type_exists($nfpsap_post_type)){
						
						if($nfpsap_post_type === 'post'){
							
							add_submenu_page(

								'edit.php',
								__('Sort','nutsforpress-sort-any-posts'),
								__('Sort','nutsforpress-sort-any-posts'),
								'manage_options',
								'nfpsap-sort-page-'.$nfpsap_post_type,
								function() use ($nfpsap_post_type){
									
									nfpsap_sort_page_callback($nfpsap_post_type);
									
								},
								100
				
							);	
							
						} else {

							add_submenu_page(

								'edit.php?post_type='.$nfpsap_post_type,
								__('Sort','nutsforpress-sort-any-posts'),
								__('Sort','nutsforpress-sort-any-posts'),
								'manage_options',
								'nfpsap-sort-page-'.$nfpsap_post_type,
								function() use ($nfpsap_post_type){
									
									nfpsap_sort_page_callback($nfpsap_post_type);
									
								},
								100
				
							);								
							
						}				
						
					}
					
				}
				
			}

		}			
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_admin_sort" already exists');
	
}


//add a link to the post type menu to sort posts
if(!function_exists('nfpsap_sort_page_callback')) {

	function nfpsap_sort_page_callback($nfpsap_post_type){	
	
		//if submit is pressed
		if(isset($_POST['nfpsap-save-order'])){
			
			$nfpas_new_post_order = 1;
			
			//get the array containing all the post ids
			if(!empty($nfpas_submitted_post_ids_array = $_POST['nfpas-entry-order'])){
			
				//loop into post ids
				foreach($nfpas_submitted_post_ids_array as $nfpas_submitted_post_id){
					
					//clean post id
					$nfpas_submitted_post_id = absint($nfpas_submitted_post_id);
					
					if(!empty($nfpas_submitted_post_id)){
						
						update_post_meta(
						
							$nfpas_submitted_post_id,
							'_nfpas_post_order',
							$nfpas_new_post_order
						
						);	

						$nfpas_new_post_order++;					
						
					}
					
				}
				
			}
			
		}
	
		?>

		<script>	
		jQuery(document).ready(function(){
			jQuery('.nfpas-sortable-list').sortable({cursor: 'move'});

		});
		</script>

		<div class="wrap nfpsap-sort-page-wrap">
			
			<h1 style="margin-bottom:5px;"><?php echo __('Manage Sort','nutsforpress-sort-any-posts'); ?></h1>
			
			<h3><?php echo __('Drag and drop the post entries','nutsforpress-sort-any-posts'); ?></h3>
			
			<form method="post"> 
			
				<ul class="nfpas-sortable-list" style="margin:25px 25px">
			
				<?php
				
				//set order by post meta
				$nfpsap_get_posts_args = array(

					'post_type' => $nfpsap_post_type,
					'posts_per_page' => -1,
					'meta_query' => array(
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
					),
					'orderby' => '_nfpas_post_order date',
					
					'order' => 'ASC'

				);
				
				//get all the posts ordered by postmeta
				$nfpsap_get_posts = new WP_Query($nfpsap_get_posts_args);	

				//loop into posts
				while($nfpsap_get_posts->have_posts()){
					
					$nfpsap_get_posts->the_post();
					
					//the list entry
					echo '<li>';
					echo '<label>';
					echo '<span class="dashicons dashicons-move nfpas-move" style="margin-right:15px;"></span>';
					echo wp_strip_all_tags(get_the_title());
					echo '</label>';
					echo '<input type="hidden" name="nfpas-entry-order[]" value="'.get_the_ID().'">';
					echo '</li>';
					
				}

				wp_reset_query();
				wp_reset_postdata();		
				
				?>
			
				</ul>
				
				<div style="margin-top:50px;">
			
					<button name="nfpsap-save-order" class="button-primary"><?php echo __('Save Order', 'nutsforpress-sort-any-posts') ?></button>
				
				</div>
			
			</form>
		
		</div>
		
		<?php
			
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpsap_sort_page_callback" already exists');
	
}