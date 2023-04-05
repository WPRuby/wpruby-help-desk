<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/public
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The errors array for frontend submission validation.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $errors    The errors array.
	 */
	private $errors = array();

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * The plugin settings Object.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object    $version    The plugin settings Object.
	 */
	 protected $settings;
	 /**
		* The plugin Custom Fields Object.
		*
		* @since    1.2.0
		* @access   protected
		* @var      object    $custom_fields    The plugin Custom Fields Object.
		*/
		protected $custom_fields;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	 protected $error = '';

	public function __construct( $plugin_name, $version, $settings ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $settings;
		$this->custom_fields = new RHD_Custom_Fields();

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
		 * defined in RHD_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The RHD_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ruby-help-desk-public.css', array(), $this->version, 'all' );

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
		 * defined in RHD_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The RHD_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


	}

	/**
	 * Display the output of the [submit_ticket] shortcode.
	 * @return	 string  the shortcode output
	 * @since    1.0.0
	 */
	public function shortcode_submit_ticket(){
		ob_start();
		$products = $this->get_products();
		$attachments_settings = get_option('rhd_attachments');
		$custom_fields = $this->custom_fields;
		require_once plugin_dir_path( __FILE__ ) . 'partials/shortcodes/shortcode-submit-ticket.php';
		return ob_get_clean();
	}
	/**
	 * Display the output of the [my_tickets] shortcode.
	 * @return	 string  the shortcode output
	 * @since    1.0.0
	 */
	public function shortcode_my_tickets(){
		ob_start();
		$my_tickets = RHD_Ticket::get_my_tickets();
		require_once plugin_dir_path( __FILE__ ) . 'partials/shortcodes/shortcode-my-tickets.php';
		return ob_get_clean();
	}
	/**
	 * Display the output of the [knowledgebase] shortcode.
	 * @return	 string  the shortcode output
	 * @since    1.0.0
	 */
	public function shortcode_knowledgebase(){
		$products = $this->get_products(	true	);
		if(!is_wp_error($products)){
			foreach ($products as $key => $product) {
				$products[$key]->documents = get_posts(
					array(
							'posts_per_page' => -1,
							'post_type' => RHD_KNOWLEDGEBASE,
							'tax_query' => array(
									array(
											'taxonomy' => RHD_TICKET_PRODUCT,
											'field' => 'term_id',
											'terms' => $product->term_id,
									)
							)
					)
				);
			}
		}
		ob_start();
		require_once plugin_dir_path( __FILE__ ) . 'partials/shortcodes/shortcode-knowledgebase.php';
		return ob_get_clean();
	}
	/**
	 * Display the output of the [ruby_help_desk_login] shortcode.
	 * @return	 string  the shortcode output
	 * @since    1.0.0
	 */
	public function shortcode_login_form(){
		ob_start();
		$my_ticket_page = get_option('rhd_[my_tickets]');
		$login_form_args = array(
			'redirect'	=> get_permalink($my_ticket_page),
		);
		wp_login_form($login_form_args);
		return ob_get_clean();
	}
	/**
	 * Display the output of the [ruby_help_desk_signup] shortcode.
	 * @return	 string  the shortcode output
	 * @since    1.0.0
	 */
	public function shortcode_signup_form(){
		ob_start();
		require_once plugin_dir_path( __FILE__ ) . 'partials/signup.php';
		return ob_get_clean();
	}
	/**
	 * Overwrite the default view of the ticket custom post type.
	 * @param	 string  the default content of the ticket.
	 * @return	 string  the single ticket html output
	 * @since    1.0.0
	 */
	public function display_single_ticket( $content ){
		global $post;
		//info: if it is not a ticket, do not do any thing
		if($post->post_type != RHD_TICKET) return $content;
		ob_start();
		$ticket = new RHD_Ticket(	$post->ID );
		$status = $ticket->get_status();
		$user = new RHD_User($post->post_author);
		$attachments = $ticket->get_attachments();
		$replies = $ticket->get_replies();
		$replies_count = count($replies);
		$editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
		$attachments_settings = get_option('rhd_attachments');
		require_once plugin_dir_path( __FILE__ ) . 'partials/single-ticket.php';
		return ob_get_clean();
	}

	/**
	 * Get all the tickets products
	 * @return	 string  array of products' objects
	 * @since    1.0.0
	 */
	public function get_products($hide_empty = false){
		$products = get_terms( RHD_TICKET_PRODUCT, array(	'hide_empty' => $hide_empty		) );
		return $products;
	}
	/**
	 * Processing frontend ticket submission form.
	 * @since    1.0.0
	 */
	public function process_ticket_submission() {
			if(isset($_POST['action']) && $_POST['action'] == 'submit_ticket'){
				$ticket = array();
				//info: 1st. process core fields first
				$ticket['subject'] = sanitize_text_field(	$_POST['rhd_ticket_subject']	);
				$ticket['product'] = intval(	$_POST['rhd_ticket_product']	);
				$ticket['content'] = sanitize_text_field(	$_POST['rhd_ticket_reply']	);
				//info: validation start
				$errors = array();
				if(trim($ticket['subject']) == ''){
					$errors[] = __('Ticket Subject should not be empty', 'ruby-help-desk');
				}
				if(trim($ticket['content']) == ''){
					$errors[] = __('Ticket Description should not be empty', 'ruby-help-desk');
				}
				//info: if there is an attachment
				if(isset($_FILES['rhd_ticket_attachment']) && $_FILES['rhd_ticket_attachment']['name'] != ''){
					if ( ! function_exists( 'wp_handle_upload' ) ) {
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
					}
					$uploadedfile = $_FILES['rhd_ticket_attachment'];
					$upload_overrides = array( 'test_form' => false );
					$ticket_uploaded_file = wp_handle_upload( $uploadedfile, $upload_overrides );
					if(isset($ticket_uploaded_file['error'])){
						$errors[] = $ticket_uploaded_file['error'];
					}
					$ticket['attachment'] = $ticket_uploaded_file['file'];
				}
				//info: validate the posted Custom Fields values
				if($cf_errors = $this->custom_fields->validate_post()){
					$errors = array_merge($errors, $cf_errors);
				}

				if(empty($errors)){
					$ticket_id =  RHD_Ticket::add($ticket);
					//info: 2nd process custom fields
					foreach ($this->custom_fields->get_custom_fields_keys() as $key){
						if(isset($_POST[	$key 	])){
							$value = $this->custom_fields->sanitize($key,	$_POST[$key]);

							update_post_meta( intval($ticket_id), $key, $value);
						}
					}
					wp_redirect(get_permalink($ticket_id));
					exit;
				}else{
					$this->errors = $errors;
				}
			}
	}
	/**
	 * Processing frontend ticket reply submission form.
	 * @since    1.0.0
	 */
	public function process_ticket_reply() {
			if(isset($_POST['ticket_id'])){
				$ticket_id = intval($_POST['ticket_id']);
			}

			$ticket = new RHD_Ticket(	$ticket_id	);

			if (isset($_POST['ticket_id']) && $ticket->get_author()->get_id() !== wp_get_current_user()->ID) {
				$this->error = __('You are not allowed to add a reply to this ticket', 'ruby-help-desk');
			}

			//if closing the ticket
			if(isset($_POST['close_ticket'])){
				$ticket = new RHD_Ticket(	$ticket_id	);
				//closing the ticket
				$ticket->close_ticket();
				wp_redirect(get_permalink($ticket_id));
				exit;
			}

			if(isset($_POST['action']) && $_POST['action'] == 'submit_reply'){

				$reply = RHD_Ticket::add_reply($ticket_id);

				if(!isset($reply['error'])){
					wp_redirect(get_permalink($ticket_id));
					exit;
				}else{
					$this->error = $reply['error'];
				}

			}
	}
	/**
	 * Helper method to get the HelpDesk fronend pages permalinks.
	 * @param    string			page name
	 * @return   string			page permalink
	 * @since    1.0.0
	 */
	public function get_page($page){
		$page_id = get_option( "rhd_[{$page}]");
		return get_permalink($page_id);
	}
	/**
	 * Helper method to get the HelpDesk fronend pages permalinks.
	 * @param    array 		The file HTTP array.
	 * @return   array    The file array for the uploaded file information.
	 * @since    1.0.0
	 */
	public function validate_attachment_file(	$file	){

		//info: only applied when a ticket or a reply is submittied
		if(! (isset($_POST['action']) && in_array($_POST['action'], array('submit_ticket', 'submit_reply'))) ) return $file;

		$attachments_settings = get_option('rhd_attachments');

		if($attachments_settings['enable_attachments'] === 'off')	return $file;


		$filetypes      = explode( ',', $attachments_settings['allowed_extensions_attachments'] );
		$ext            = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
		$max_file_size       = $attachments_settings['max_size_attachments'];
		$max_file_size_bytes = $max_file_size * 1024 * 1024;

		if ( ! in_array( $ext, $filetypes ) ) {
			$file['error'] = sprintf( __( 'This file type (%s) is not allowed', 'ruby-help-desk' ), $ext );
		}

		if ( $file['size'] > $max_file_size_bytes ) {
			$file['error'] = sprintf( __( 'The file is too big. The maximum allowed file size is %s', 'ruby-help-desk' ), "$max_file_size Mb" );
		}

		return $file;
	}

	/**
	 * Adding restriction on the fronend pages.
	 * @since    1.0.0
	 */
	public function restrict_tickets_pages(){
		global $post;
		if(is_object($post) && !is_admin()){
					$login_page_id = get_option('rhd_[ruby_help_desk_login]');
					$signup_page_id = get_option('rhd_[ruby_help_desk_signup]');
					$my_tickets_page_id = get_option('rhd_[my_tickets]');

					//info: 1. restrict single tickets
					if(isset($post->post_type) && $post->post_type == RHD_TICKET){
						$current_user_id = get_current_user_id();
						$ticket_author_id = get_post_field( 'post_author', $post->ID);
						if($current_user_id != $ticket_author_id){
							wp_redirect(get_permalink(	$login_page_id	));
							exit;
						}
					}
					//info: 2. restrict my_tickets page
					if($post->ID == $my_tickets_page_id){
						if(get_current_user_id() === 0){
							wp_redirect(get_permalink(	$login_page_id	));
							exit;
						}
					}

					//info: 2. restrict submit_ticket page
					$submit_ticket_page_id = get_option('rhd_[submit_ticket]');
					if($post->ID == $submit_ticket_page_id){
						if(get_current_user_id() === 0){
							wp_redirect(get_permalink(	$login_page_id	));
							exit;
						}
					}
					//info: 3. if user is logged in, he should not access Sign Up and Login pages.
					if(is_user_logged_in()){
						if(in_array($post->ID, array($login_page_id,	$signup_page_id))){
							wp_redirect(get_permalink(	$my_tickets_page_id	));
							exit;
						}
					}


		}
	}
	/**
	 * Processing frontend signup form.
 	 * @since    1.0.0
 	 */
	public function process_signup(){
		if(isset($_POST['action']) && $_POST['action'] == 'helpdesk_signup'){
			$this->errors = array();
			$user = array();
			//info: validate username
			$user['user_login'] = sanitize_user( $_POST['user_login']	);
			if(username_exists($user['user_login'])){
				$this->errors[] = __('The usrename already exists', 'ruby-help-desk');
			}
			//info: validate email
			$user['user_email'] = sanitize_email( $_POST['user_email']	);
			if($user['user_email'] == ''){
				$this->errors[] = __('Please provide a valid email', 'ruby-help-desk');
			}
			if ( email_exists( $user['user_email'] ) ) {
				$this->errors[] = __('The email is already exist', 'ruby-help-desk');
			}
			//info: validate password
			$user['user_pass'] = sanitize_text_field( $_POST['user_pass'] );
			if(strlen(trim($user['user_pass'])) < 7 ){
				$this->errors[] = __('Please provide a password longer than 7 charachters', 'ruby-help-desk');
			}
			if(trim($user['user_pass']) != trim(sanitize_text_field($_POST['user_pass_repeated']))){
				$this->errors[] = __('The passwords do not match', 'ruby-help-desk');
			}

			if(empty($this->errors)){
				$new_user_id = wp_insert_user(	$user	);
				if(is_wp_error(	$new_user_id	)){
					$this->errors[] = $new_user_id->get_error_message();
				}else{
					//info: on success auto-login and redirect to my_tickets page.
					wp_set_current_user($new_user_id, $user['user_login']);
        	wp_set_auth_cookie($new_user_id);
					do_action('wp_login', $user['user_login']);
					$my_ticket_page = get_option('rhd_[my_tickets]');
        	wp_redirect(get_permalink($my_ticket_page));
					exit;
				}
			}

		}
	}
}
