<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/public
 * @author     WPRuby <info@wpruby.com>
 */
class Wpruby_Help_Desk_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpruby_Help_Desk_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpruby_Help_Desk_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpruby-help-desk-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpruby_Help_Desk_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpruby_Help_Desk_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpruby-help-desk-public.js', array( 'jquery' ), $this->version, false );

	}


	public function shortcode_submit_ticket(){
		ob_start();
		$products = $this->get_products();
		require_once plugin_dir_path( __FILE__ ) . 'partials/shortcodes/shortcode-submit-ticket.php';
		return ob_get_clean();
	}

	public function shortcode_my_tickets(){
		ob_start();
		$my_tickets = WPRuby_Ticket::get_my_tickets();
		require_once plugin_dir_path( __FILE__ ) . 'partials/shortcodes/shortcode-my-tickets.php';
		return ob_get_clean();
	}

	public function display_single_ticket( $content ){
		global $post;
		//info: if it is not a ticket, do not do any thing
		if($post->post_type != WPRUBY_TICKET) return $content;
		ob_start();
		$ticket = new WPRuby_Ticket(	$post->ID );
		$user = new WPRuby_User($post->post_author);
		$replies = $ticket->get_replies();
		$replies_count = count($replies);
		$editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
		require_once plugin_dir_path( __FILE__ ) . 'partials/single-ticket.php';
		return ob_get_clean();
	}


	public function get_products(){
		$products = get_terms( WPRUBY_TICKET_PRODUCT, array(	'hide_empty' => false		) );
		return $products;
	}

	public function process_ticket_submission(  ) {
			if(isset($_POST['action']) && $_POST['action'] == 'submit_ticket'){
				$ticket = array();
				$ticket['subject'] = sanitize_text_field(	$_POST['ticket_subject']	);
				$ticket['product'] = intval(	$_POST['ticket_product']	);
				$ticket['content'] = sanitize_text_field(	$_POST['ticket_reply']	);

				//info: if there is an attachment
				if(isset($_FILES['ticket_attachment'])){
					if ( ! function_exists( 'wp_handle_upload' ) ) {
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
					}
					$uploadedfile = $_FILES['ticket_attachment'];
					$upload_overrides = array( 'test_form' => false );
					$ticket_uploaded_file = wp_handle_upload( $uploadedfile, $upload_overrides );
					$ticket['attachment'] = $ticket_uploaded_file['file'];
				}


				WPRuby_Ticket::add($ticket);
				wp_redirect($this->get_page('submit_ticket'));
				exit;
			}
	}

	public function process_ticket_reply(  ) {
			if(isset($_POST['action']) && $_POST['action'] == 'submit_reply'){
				$ticket_id = intval($_POST['ticket_id']);
				$ticket_reply_args = array(
					'post_title'		=>	'Reply to ticket #' . $ticket_id,
					'post_content'	=>	$_POST['ticket_reply'],
					'post_status'		=>	'publish',
					'post_type'			=>	WPRUBY_TICKET_REPLY,
					'post_parent'		=>	intval($ticket_id),
				);
				wp_insert_post( $ticket_reply_args );
				wp_redirect(get_permalink($ticket_id));
				exit;
			}
	}
	//@TODO
	public function get_page($page){
		switch ($page) {
			case 'submit_ticket':
				return 'http://localhost:8888/wp/adding-tickets/';
				break;

			default:
				return 'http://localhost:8888/wp/adding-tickets/';
				break;
		}
	}
}
