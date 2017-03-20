<?php

function get_id($name, $lang = false)
{
	$pageID = '';
	switch ($name) {
		case 'home':
			$pageID = get_translated_id(2);
			break;
		case '':
			$pageID = get_translated_id(10);
			break;
	}
	$searchLang = ($lang ? $lang : get_lang_active());
	return get_default_id($pageID, 'page', $searchLang);
};

require_once 'includes/base-theme.php';

function theme_domain()
{
	return 'Robin\'s Nest';
}

function get_the_prefix()
{
	$return = "_";
	$return .= 'rknest';
	$return .= "_";
	return $return;
}

function wp_head_action()
{
	echo "<script>window.jQuery || document.write('<script src=\"" . get_template_directory_uri() . "/scripts/vendor/jquery-3.1.1.min.js\"><\\/script>')</script>";
}
add_action('wp_head', 'wp_head_action');

function load_my_scripts()
{
	$cssPath = get_template_directory_uri() . '/css';
	$jsPath = get_template_directory_uri() . '/scripts';

	if (!is_admin()) { //If the page is admin page, don't load//
		wp_enqueue_script('modernizr', "$jsPath/vendor/modernizr.min.js", false, '1.0', false);
		wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js", false, '1.11.0');
		wp_enqueue_script('jquery');

		// wp_enqueue_script('validate', "$jsPath/vendor/validate/jquery.validation.js", array('jquery'), '1.0', false);
		// wp_enqueue_script('placeHolders', "$jsPath/vendor/jquery.placeholders.min.js", array('jquery'), '1.0', false);

		wp_enqueue_script('scripts', "$jsPath/scripts.min.js", array('jquery'), '1.0', true);

		wp_enqueue_style('g-fonts', '//fonts.googleapis.com/css?family=Raleway:400,400i,600,600i,700,700i,900,900i', false, '1', 'all');
		wp_enqueue_style('style', "$cssPath/styles.min.css", false, '1');

	}
}
add_action('wp_enqueue_scripts', 'load_my_scripts');
