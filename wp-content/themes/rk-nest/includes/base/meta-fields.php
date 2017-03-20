<?php

/**
* Gets a number of terms and displays them as options
* @param  string $taxonomy Taxonomy terms to retrieve. Default is category.
* @param  string|array $args Optional. get_terms optional arguments
* @return array                  An array of options that matches the CMB2 options array
*/


//function cmb2_get_term_options_posts($taxonomy = 'category', $args = array())
//{
//	$args['taxonomy'] = $taxonomy;
//	// $defaults = array( 'taxonomy' => 'category' );
//	$args = wp_parse_args($args, array('taxonomy' => 'category'));
//	$taxonomy = $args['taxonomy'];
//	$terms = (array)get_terms($taxonomy, $args);
//	// Initate an empty array
//	$term_options = array();
//	if (!empty($terms)) {
//		foreach ($terms as $term) {
//			$term_options[$term->term_id] = $term->name;
//		}
//	}
//	return $term_options;
//}

add_action('cmb2_init', 'cust_meta_fields');
function cust_meta_fields()
{
	$prefix = get_the_prefix();
	$wysiwygOptions = array(
		'wpautop' => true, // use wpautop?
		'media_buttons' => true, // show insert/upload button(s)
		//'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
		'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
		'tabindex' => '',
		'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
		'editor_class' => '', // add extra class(es) to the editor textarea
		'teeny' => false, // output the minimal editor config used in Press This
		'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
		'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
		'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
	);
	$wysiwygSmallNoMediaOptions = array(
		'wpautop' => true, // use wpautop?
		'media_buttons' => false, // show insert/upload button(s)
		//'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
		'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
		'tabindex' => '',
		'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
		'editor_class' => '', // add extra class(es) to the editor textarea
		'teeny' => false, // output the minimal editor config used in Press This
		'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
		'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
		'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
	);
	$homeWhitelist = array(get_id('home'));

	$author_array = array();
	$authors = get_users( array('who' => 'authors') );
	foreach($authors as $author) :
		$author_array[$author->ID] = (!empty($author->display_name)) ? $author->display_name : $author->user_nicename;
	endforeach;
	$author_array[0] = 'Non Author';

	/**
	* Feed Template
	* @var  $template_feed
	*/

	$post_type_array = array();
	$post_type_excludes = array(
		'page', 'attachment', 'nav_menu_item', 'revision'
	);
	$post_types = array_diff(get_post_types(), $post_type_excludes);

	foreach($post_types as $type) :
		if (
			strpos(get_post_type_object($type)->name, 'type') !== false ||
			strpos(get_post_type_object($type)->name, 'post') !== false
		) :
			$post_type_array[$type] = get_post_type_object($type)->label;
		endif;
	endforeach;

	$template_feed = new_cmb2_box(array(
		'id' => 'template_feed',
		'title' => __('Feed\'s Information', be_domain()),
		'object_types' => array('page'), // Post type
		'show_on'      => array( 'key' => 'page-template', 'value' => array('tpl-feed-accordion.php', 'tpl-feed-grid.php', 'tpl-feed-list.php') ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true
	));
	$template_feed->add_field(array(
		'name' => __('Featured Post Type', be_domain()),
		'id' => $prefix . 'template_feed_type',
		'type' => 'select',
		'options' => $post_type_array
	));
	$template_feed->add_field(array(
		'name' => __('Posts Per Page (Numeric Only)', be_domain()),
		'id' => $prefix . 'template_feed_limit',
		'type' => 'text',
		'attributes' => array(
			'type' => 'number',
		),
	));

	/**
	 * Recipe Item
	 * @var $post_recipes
	 */

	 $post_recipes = new_cmb2_box(array(
 		'id' => 'post_recipes',
 		'title' => __('Recipe Item\'s Information', be_domain()),
 		'object_types' => array('type-recipes'), // Post type
 		'context' => 'normal',
 		'priority' => 'high',
 		'show_names' => true
 	));
	$post_recipes->add_field(array(
 		'name' => __('Credit An Author', be_domain()),
 		'id' => $prefix . 'post_recipes_author',
 		'type' => 'select',
		'options' => $author_array
	));
	$post_recipes->add_field(array(
 		'name' => __('Credit A Non-Author', be_domain()),
 		'id' => $prefix . 'post_recipes_nonauthor',
 		'type' => 'text',
		'attributes' => array(
	         'data-conditional-id' => $prefix . 'post_recipes_author'
		 )
	));
	$post_recipes->add_field(array(
 		'name' => __('Featured Image', be_domain()),
 		'id' => $prefix . 'post_recipes_featured',
 		'type' => 'file'
	));
 	$post_recipes->add_field(array(
 		'name' => __('Ingredients', be_domain()),
 		'id' => $prefix . 'post_recipes_ingredients',
 		'type' => 'wysiwyg',
		'options' => $wysiwygOptions
 	));
	$post_recipes->add_field(array(
 		'name' => __('Method', be_domain()),
 		'id' => $prefix . 'post_recipes_method',
 		'type' => 'wysiwyg',
		'options' => $wysiwygOptions
 	));

}


/**
* Excludes a PostID array
*    'show_on'    => array('key' => 'exclude_id', 'value' => array('id'),
* @param $display
* @param $meta_box
* @return bool
*/
function be_metabox_exclude_for_id( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'], $meta_box['show_on']['value'] ) ) {
		return $display;
	}

	if ( 'exclude_id' !== $meta_box['show_on']['key'] ) {
		return $display;
	}

	$post_id = 0;

	// If we're showing it based on ID, get the current ID
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}

	if ( ! $post_id ) {
		return $display;
	}

	// If current page id is in the included array, do not display the metabox
	$icust_to_exclude = ! is_array( $meta_box['show_on']['value'] )
	? array( $meta_box['show_on']['value'] )
	: $meta_box['show_on']['value'];

	return ! in_array( $post_id, $icust_to_exclude );
}
add_filter( 'cmb2_show_on', 'be_metabox_exclude_for_id', 10, 2 );

/**
* Usage: 'show_on' => array( 'key' => 'page-template', 'value' => @array || @string ),
* @param $display
* @param $meta_box
* @return bool
*/
function metabox_hide_on_template($display, $meta_box)
{

	if ('hide_on' !== $meta_box['show_on']['key'])
	return $display;

	// Get the current ID
	if (isset($_GET['post'])) $post_id = $_GET['post'];
	elseif (isset($_POST['post_ID'])) $post_id = $_POST['post_ID'];
	if (!isset($post_id)) return false;

	$template_name = get_page_template_slug($post_id);

	$return = true;
	if (is_array($meta_box['show_on']['value'])):
		$return = (in_array($template_name, $meta_box['show_on']['value']) ? false : true);
	else:
		$return = ($template_name == $meta_box['show_on']['value'] ? false : true);
	endif;
	return $return;
}

add_filter('cmb_show_on', 'metabox_hide_on_template', 10, 2);

function templateFilter()
{
	if (isset($_GET['post'])) {
		$id = $_GET['post'];
		$template = get_post_meta($id, '_wp_page_template', true);

		$dontShowEditor = array(
			''
		);

		if (in_array($template, $dontShowEditor) || in_array($id, $dontShowEditor)) {
			remove_post_type_support('page', 'editor');
		}

	}
}

add_action('init', 'templateFilter');
