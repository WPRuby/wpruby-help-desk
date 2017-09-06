<?php


/**
 * The Replies Templates Class
 *
 *
 * @package    RHD_Replies_Templates
 * @subpackage RHD_Replies_Templates/admin
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Replies_Templates{

	private $tags;

	public function __construct() {
		add_action( 'add_meta_boxes', array($this, 'template_tags_metabox'), 10, 2 );
		$this->tags = [
			'customer_full_name'    => __('Customer Full Name'),
			'customer_first_name'   => __('Customer First Name'),
			'customer_last_name'    => __('Customer Last Name'),
			'agent_full_name'       => __('Agent Full Name'),
			'agent_first_name'      => __('Agent First Name'),
			'agent_last_name'       => __('Agent Last Name'),
		];

	}

	public function template_tags_metabox( $post_type, $post ) {
		add_meta_box(
			'template_tags_metabox',
			__( 'Template Tags',  'ruby-help-desk'),
			array($this, 'render_template_tags_metabox'),
			RHD_REPLIES_TEMPLATE,
			'normal',
			'default'
		);
	}

	public function render_template_tags_metabox( $post_type, $post ) {
		require_once plugin_dir_path( __FILE__ ) . 'partials/replies_templates/metabox_tags.php';
	}


}

new RHD_Replies_Templates();