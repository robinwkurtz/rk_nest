<?php

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}

function customPostTypes()
{

    /**
    * Custom Taxonomies - All Post types
    */

    $taxonomies = array(
        // Type Sample - Name
		array(
			'slug'         => 'cat-categories',
			'single_name'  => 'Recipe Category',
			'plural_name'  => 'Recipe Categories',
			'post_type'    => 'type-recipes',
			'rewrite'      => array( 'slug' => 'recipe-categories' ),
		)
	);

    foreach($taxonomies as $taxonomy ) {
        $labels = array(
            'name' => $taxonomy['plural_name'],
            'singular_name' => $taxonomy['single_name'],
            'search_items' =>  'Search ' . $taxonomy['plural_name'],
            'all_items' => 'All ' . $taxonomy['plural_name'],
            'parent_item' => 'Parent ' . $taxonomy['single_name'],
            'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
            'edit_item' => 'Edit ' . $taxonomy['single_name'],
            'update_item' => 'Update ' . $taxonomy['single_name'],
            'add_new_item' => 'Add New ' . $taxonomy['single_name'],
            'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
            'menu_name' => $taxonomy['plural_name']
        );

        $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
        $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

        register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
            'hierarchical' => $hierarchical,
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => $rewrite,
        ));
    }

	/**
	 * Custom Post Type - Recipes
	 */

    register_post_type('type-recipes', array(
        'labels' => array(
            'name' => _x('Recipes', 'Titles', theme_domain()),
            'singular_name' => _x('Recipe', 'Titles', theme_domain()),
            'menu_name' => _x('Recipes', 'Titles', theme_domain()),
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        'rewrite' => array('slug' => _x('recipe', 'URL Slug', theme_domain()), 'with_front' => false, 'page' => false),
        'capability_type' => 'page',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-carrot',
        'supports' => array('title', 'revisions', 'thumbnail', 'comments'),
    ));

}

add_action('init', 'customPostTypes');

/** Use this to deregister bad post types **/
if (!function_exists('unregister_post_type')) :
	function unregister_post_type($post_type)
	{
		global $wp_post_types;
		if (isset($wp_post_types[$post_type])) {
			unset($wp_post_types[$post_type]);
			return true;
		}
		return false;
	}
endif;
