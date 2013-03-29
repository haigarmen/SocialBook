<?php
add_action('init', 'register_chapters', 1); // Set priority to avoid plugin conflicts

// a few more things to do
// remove the Posts and Pages to reduce confusion
// optional: create a custom content type for sub-chapter and associate them as parents of Chapters

function register_chapters() { // A unique name for our function
 	$labels_chapters = array( // Used in the WordPress admin
		'name'	   		  	=> 	_x('Chapters', 'post type general name'),
		'singular_name' 	=>	_x('Chapters', 'post type singular name'),
		'add_new' 			=>	_x('Add New', 'Chapter'),
		'add_new_item'		=>	__('Add New Chapter'),
		'edit_item'			=>	__('Edit Chapter'),
		'new_item'			=>	__('New Chapter'),
		'view_item'			=>	__('View Chapter'),
		'search_items'		=>	__('Search Chapters'),
		'not_found'			=>	__('Nothing found'),
		'not_found_in_trash' =>	__('Nothing found in Trash')
	);
	$args_chapters = array(
		'labels' => $labels_chapters, // Set above
		'public' => true, // Make it publicly accessible
		'hierarchical' => true, // has parents and children here
		'menu_position' => 5, // Appear right below "Posts"
		'has_archive' => 'chapters', // Activate the archive
		'supports' => array('title','editor','comments','thumbnail','page-attributes'),
		'can_export' => true,
	);
	
	register_post_type( 'chapters', $args_chapters ); // Create the post type, use options above
}

add_action('init', 'register_sections', 2);

function register_sections() { // A unique name for our function
 	$labels_sections = array( // Used in the WordPress admin
		'name'	   		  	=> 	_x('Sections', 'post type general name'),
		'singular_name' 	=>	_x('Section', 'post type singular name'),
		'add_new' 			=>	_x('Add New', 'Section'),
		'add_new_item'		=>	__('Add New Section'),
		'edit_item'			=>	__('Edit Section'),
		'new_item'			=>	__('New Section'),
		'view_item'			=>	__('View Section'),
		'search_items'		=>	__('Search Sections'),
		'not_found'			=>	__('Nothing found'),
		'not_found_in_trash' =>	__('Nothing found in Trash')
	);
	$args_sections = array(
		'labels' => $labels_sections, // Set above
		'public' => true, // Make it publicly accessible
		'hierarchical' => true, // has parents and children here
		'menu_position' => 5, // Appear right below "Posts"
		'has_archive' => 'sections', // Activate the archive
		'supports' => array('title','editor','comments','thumbnail','page-attributes'),
		'can_export' => true,
	);

	register_post_type( 'sections', $args_sections ); // Create the post type, use options above
}




	add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'chapters', 'normal');});
	add_action('add_meta_boxes', function() { add_meta_box('chapter-parent', 'Section', 'chapter_attributes_meta_box', 'chapters', 'side', 'high');});
	
function chapter_attributes_meta_box($post) {
  $post_type_object = get_post_type_object($post->post_type);
  if ( $post_type_object->hierarchical ) {
    $pages = wp_dropdown_pages(array('post_type' => 'sections', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 'sort_column'=> 'menu_order, post_title', 'echo' => 0));
    if ( ! empty($pages) ) {
      echo $pages;
    } // end empty pages check
  } // end hierarchical check.
}

?>