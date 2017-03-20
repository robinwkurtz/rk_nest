<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class rk_Admin {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'rk_options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'rk_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Site Content', be_domain());
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUT
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
	<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

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

		$site_information = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields

		$site_information->add_field( array(
			'name' => _x( 'Legal', 'Global Information', be_domain() ),
			'id'   => 'site_legal',
			'type' => 'wysiwyg'
		) );

		$social = $site_information->add_field( array(
			'name' => _x( 'Social Media', 'Global Information', be_domain() ),
		    'id'          => 'site_social',
		    'type'        => 'group',
		    'options'     => array(
		        'group_title'   => __( 'Link {#}', be_domain() ), // since version 1.1.4, {#} gets replaced by row number
		        'add_button'    => __( 'Add Another Link', be_domain() ),
		        'remove_button' => __( 'Remove Link', be_domain() ),
		        'sortable'      => true, // beta
		    ),
		) );

		$site_information->add_group_field( $social, array(
		    'name' => 'Title',
		    'id'   => 'title',
		    'type' => 'text',
		) );

		$site_information->add_group_field( $social, array(
		    'name' => 'URL',
		    'id'   => 'url',
		    'type' => 'text',
		) );

		$site_information->add_group_field( $social, array(
		    'name' => 'Icon',
		    'id'   => 'icon',
		    'type' => 'file',
			'description' => _x( 'Locate, save and upload icons (96px x 96px) for your outbound social links. <a href="http://iconmonstr.com/" target="_blank">Good resource</a>.', 'Global Information', be_domain() ),
		) );

	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

/**
 * Helper function to get/return the rk_Admin object
 * @since  0.1.0
 * @return rk_Admin object
 */
function rk_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new rk_Admin();
		$object->hooks();
	}

	return $object;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function rk_get_option( $key = '' ) {
	return cmb2_get_option( rk_admin()->key, $key );
}

// Get it started
rk_admin();
