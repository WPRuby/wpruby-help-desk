<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/admin
 * @author     WPRuby <info@wpruby.com>
 */
class Wpruby_Help_Desk_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpruby_Help_Desk_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpruby_Help_Desk_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpruby-help-desk-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpruby_Help_Desk_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpruby_Help_Desk_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpruby-help-desk-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * The plugin use this method to register the main custom post type of the links.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types(){
		$labels = array(
			'name'               => _x( 'Tickets', 'post type general name', 'wpruby-help-desk' ),
			'singular_name'      => _x( 'Create Ticket', 'post type singular name', 'wpruby-help-desk' ),
			'menu_name'          => _x( 'Ruby Desk', 'admin menu', 'wpruby-help-desk' ),
			'name_admin_bar'     => _x( 'Ticket', 'add new on admin bar', 'wpruby-help-desk' ),
			'add_new'            => _x( 'Create Ticket', 'book', 'wpruby-help-desk' ),
			'add_new_item'       => __( 'Create New Ticket', 'wpruby-help-desk' ),
			'new_item'           => __( 'Create New Ticket', 'wpruby-help-desk' ),
			'edit_item'          => __( 'Edit Ticket', 'wpruby-help-desk' ),
			'view_item'          => __( 'View Ticket', 'wpruby-help-desk' ),
			'all_items'          => __( 'All Tickets', 'wpruby-help-desk' ),
			'search_items'       => __( 'Search Tickets', 'wpruby-help-desk' ),
			'parent_item_colon'  => __( 'Parent Tickets:', 'wpruby-help-desk' ),
			'not_found'          => __( 'No tickets found.', 'wpruby-help-desk' ),
			'not_found_in_trash' => __( 'No tickets found in Trash.', 'wpruby-help-desk' )
		);
		$supports = array('title');

		if( !isset( $_GET['post'] ) ) {
			$supports[] = 'editor';
		}

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => WPRUBY_TICKET ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => $supports,
			'menu_icon'			 => 'dashicons-tickets',

		);

		register_post_type( WPRUBY_TICKET, $args );


		//Tickets Reply
			$labels = array(
				'name'               => _x( 'Tickets Reply', 'post type general name', 'wpruby-help-desk' ),
				'singular_name'      => _x( 'Create Ticket Reply', 'post type singular name', 'wpruby-help-desk' ),
				'menu_name'          => _x( 'Ruby Desk', 'admin menu', 'wpruby-help-desk' ),
				'name_admin_bar'     => _x( 'Ticket Reply', 'add new on admin bar', 'wpruby-help-desk' ),
				'add_new'            => _x( 'Create Ticket Reply', 'book', 'wpruby-help-desk' ),
				'add_new_item'       => __( 'Create New Ticket Reply', 'wpruby-help-desk' ),
				'new_item'           => __( 'Create New Ticket Reply', 'wpruby-help-desk' ),
				'edit_item'          => __( 'Edit Ticket Reply', 'wpruby-help-desk' ),
				'view_item'          => __( 'View Ticket Reply', 'wpruby-help-desk' ),
				'all_items'          => __( 'All Tickets Reply', 'wpruby-help-desk' ),
				'search_items'       => __( 'Search Tickets Reply', 'wpruby-help-desk' ),
				'parent_item_colon'  => __( 'Parent Tickets Reply:', 'wpruby-help-desk' ),
				'not_found'          => __( 'No tickets found.', 'wpruby-help-desk' ),
				'not_found_in_trash' => __( 'No tickets found in Trash.', 'wpruby-help-desk' )
			);


			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => false,
				'show_ui'            => false,
				'show_in_menu'       => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => WPRUBY_TICKET_REPLY ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
			);

			register_post_type( WPRUBY_TICKET_REPLY, $args );
	}

		/**
		 * The plugin use this method to register the custom taxonomies of the links.
		 * @since    1.0.0
		 */
		public function register_taxonomies(){
			$labels = array(
				'name'                       => _x( 'Ticket Status', 'taxonomy general name' ),
				'singular_name'              => _x( 'Ticket Status', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Ticket Statuses', 'wpruby-help-desk' ),
				'popular_items'              => __( 'Popular Ticket Statuses', 'wpruby-help-desk' ),
				'all_items'                  => __( 'All Ticket Statuses','wpruby-help-desk' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Ticket Status','wpruby-help-desk' ),
				'update_item'                => __( 'Update Ticket Status','wpruby-help-desk' ),
				'add_new_item'               => __( 'Add New Ticket Status','wpruby-help-desk' ),
				'new_item_name'              => __( 'New Ticket Status','wpruby-help-desk' ),
				'separate_items_with_commas' => __( 'Separate statuses with commas','wpruby-help-desk' ),
				'add_or_remove_items'        => __( 'Add or remove ticket status','wpruby-help-desk' ),
				'choose_from_most_used'      => __( 'Choose from the most used statuses','wpruby-help-desk' ),
				'not_found'                  => __( 'No Tickets Statuses found.','wpruby-help-desk' ),
				'menu_name'                  => __( 'Statuses','wpruby-help-desk' ),
			);

			$args = array(
				'hierarchical'          => true,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'statuses' ),
			);

			register_taxonomy( WPRUBY_TICKET_STATUS, WPRUBY_TICKET, $args );
			//adding the products taxonomy
			$labels = array(
				'name'                       => _x( 'Product', 'taxonomy general name' ),
				'singular_name'              => _x( 'Product', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Products', 'wpruby-help-desk' ),
				'popular_items'              => __( 'Popular Products', 'wpruby-help-desk' ),
				'all_items'                  => __( 'All Products','wpruby-help-desk' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Product','wpruby-help-desk' ),
				'update_item'                => __( 'Update Product','wpruby-help-desk' ),
				'add_new_item'               => __( 'Add New Product','wpruby-help-desk' ),
				'new_item_name'              => __( 'New Product','wpruby-help-desk' ),
				'separate_items_with_commas' => __( 'Separate statuses with commas','wpruby-help-desk' ),
				'add_or_remove_items'        => __( 'Add or remove ticket status','wpruby-help-desk' ),
				'choose_from_most_used'      => __( 'Choose from the most used statuses','wpruby-help-desk' ),
				'not_found'                  => __( 'No Tickets Statuses found.','wpruby-help-desk' ),
				'menu_name'                  => __( 'Products','wpruby-help-desk' ),
			);

			$args = array(
				'hierarchical'          => true,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => WPRUBY_TICKET_PRODUCT ),
			);

			register_taxonomy( WPRUBY_TICKET_PRODUCT, WPRUBY_TICKET, $args );
		}

		/**
		 * The plugin use this method to save ticket details, such as status, product ... etc.
		 * @since    1.0.0
		 */
		public function save_ticket_details( $post_id, $post, $update){
			if(isset($_POST) && !empty($_POST)){
					$post_type = get_post_type($post_id);
					if(WPRUBY_TICKET == $post_type){
						if(isset( $_POST['publish'] )){
									$tickets_status = $_POST['ticket_status'];
									$tickets_product = $_POST['ticket_product'];
									if(-1 != $tickets_status){
										wp_set_post_terms( $post_id, intval($tickets_status), WPRUBY_TICKET_STATUS );
									}
									if(-1 != $tickets_product){
										wp_set_post_terms( $post_id, intval($tickets_product), WPRUBY_TICKET_PRODUCT );
									}
						}elseif (isset( $_POST['reply'] ) || isset( $_POST['reply-close'] )) {
								if(isset($_POST['ticket_reply']) && "" != $_POST['ticket_reply']){
										$ticket_reply_args = array(
											'post_title'		=>	'Reply to ticket #' . $post_id,
											'post_content'	=>	$_POST['ticket_reply'],
											'post_status'		=>	'publish',
											'post_type'			=>	WPRUBY_TICKET_REPLY,
											'post_parent'		=>	intval($post_id),
										);
										wp_insert_post( $ticket_reply_args );
								}
						}
					}
			}


		}

		/**
		 * The plugin use this method to add admin pages to the dashboard menu
		 * @since    1.0.0
		 */
		public function adding_admin_menus(){
			add_submenu_page('edit.php?post_type=support_ticket',	__( 'Settings', 'wpruby-help-desk' ),	__( 'Settings', 'wpruby-help-desk' ),	'manage_options',	'wpruby-help-desk-settings',	array($this, 'display_settings'));
		}
		/**
		 * The plugin use this method to display the settings page, called in adding_admin_menus()
		 * @since    1.0.0
		 */
		public function display_settings(){
				require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-settings.php';
		}
		/**
		 * This method is used to add/remove different meta boxes
		 * @since    1.0.0
		 */
		public function add_tickets_metaboxes(){
			//remove the publishing box
			remove_meta_box( 'submitdiv', WPRUBY_TICKET, 'side' );
			remove_meta_box( 'tickets_productsdiv', WPRUBY_TICKET, 'side' );
			remove_meta_box( 'tickets_statusdiv', WPRUBY_TICKET, 'side' );

			// adding the reply box only when the ticket is already created
			add_meta_box('ticket_options', __( 'Ticket Options', 'wpruby-help-desk' ), array($this, 'ticket_options_meta_box_callback'), WPRUBY_TICKET, 'side', 'high');
			if(isset($_GET['post'])){
				add_meta_box('ticket_information', __( 'Ticket Details', 'wpruby-help-desk' ), array($this, 'ticket_information_meta_box_callback'), WPRUBY_TICKET, 'side', 'high');

				add_meta_box('ticket_message', __( 'Ticket Message', 'wpruby-help-desk' ), array($this, 'ticket_message_meta_box_callback'), WPRUBY_TICKET, 'normal', 'high');

				if($this->get_replies($_GET['post'])){
					add_meta_box('ticket_replies', __( 'Replies', 'wpruby-help-desk' ), array($this, 'replies_meta_box_callback'), WPRUBY_TICKET, 'normal', 'high');
				}

				add_meta_box('reply_to_ticket', __( 'Reply', 'wpruby-help-desk' ), array($this, 'reply_meta_box_callback'), WPRUBY_TICKET, 'normal', 'high');

			}
		}
		/**
		 * This method is used to display the ticket_information meta box content
		 * @since    1.0.0
		 */
		public function ticket_information_meta_box_callback($ticket){
			$user = new WPRuby_User($ticket->post_author);
			$ticket_stats = $this->get_tickets_stats($ticket->post_author);
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-details-metabox.php';
		}
		/**
		 * This method is used to display the ticket_message meta box content
		 * @since    1.0.0
		 */
		public function ticket_message_meta_box_callback($ticket){
			if(isset($ticket->post_content)){
				echo '<p>' .  $ticket->post_content .  '</p>';
			}
		}
		/**
		 * This method is used to display the reply_to_ticket meta box content
		 * @since    1.0.0
		 */
		public function reply_meta_box_callback($ticket){
			$editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-reply-metabox.php';
		}
		/**
		 * This method is used to display the ticket publishing box
		 * @since    1.0.0
		 */
		public function ticket_options_meta_box_callback($ticket){
			// get terms
			$statuses = get_terms( WPRUBY_TICKET_STATUS, array(  'hide_empty' => false ) );
			$products = get_terms( WPRUBY_TICKET_PRODUCT, array(  'hide_empty' => false ) );
			// get ticket's terms
			$ticket_status = wp_get_post_terms($ticket->ID, WPRUBY_TICKET_STATUS, array("fields" => "ids"));
			$ticket_product = wp_get_post_terms($ticket->ID, WPRUBY_TICKET_PRODUCT, array("fields" => "ids"));

			$ticket_status = (isset($ticket_status[0]))? $ticket_status[0]: -1;
			$ticket_product = (isset($ticket_product[0]))? $ticket_product[0]: -1;

			$publish_button_text = (isset($_GET['post']))? __('Update Ticket', 'wpruby-help-desk'): __('Create Ticket','wpruby-help-desk');
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-options-metabox.php';
		}

		public function get_tickets_stats(	$user_id	){
	    $stats = array();
	    $stats['total'] = 0;
	    $stats['closed'] = 0;
	    $stats['open'] = 0;

	    //@TODO fill the real stats
			$args = array();
			$args['user_id'] = intval($user_id);
			$args['status'] = 'open';
			$stats['open'] = count($this->get_tickets(	$args	));
			$args['status'] = 'closed';
			$stats['closed'] = count($this->get_tickets(	$args	));
			$stats['total'] = $stats['open'] + $stats['closed'];
	    return $stats;
	  }

		public function replies_meta_box_callback($ticket)
		{
			$replies = $this->get_replies($ticket->ID);
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-replies-metabox.php';
		}

		public function get_tickets(	$args ){
			$status_operator =  'IN';

			if($args['status'] == 'open'){
					$args['status'] = 'closed';
					$status_operator =  'NOT IN';
			}

			$args = array(
			    'post_type' => WPRUBY_TICKET,
					'author'	   => (int)$args['user_id'],
					'posts_per_page' => -1,
			    'tax_query' => array(
			        array(
			            'taxonomy' => WPRUBY_TICKET_STATUS,
			            'field'    => 'slug',
			            'terms'    => $args['status'],
									'operator' => $status_operator,
			        ),
			    ),
			);
			$tickets = get_posts( $args );
			return $tickets;
		}

		public function get_replies(	$ticket_id ){

			$args = array(
			    'post_type' 		 => WPRUBY_TICKET_REPLY,
					'post_parent'	   => intval($ticket_id),
					'orderby'          => 'date',
					'order'            => 'ASC',
					'posts_per_page' => -1,
			);
			$replies = get_posts( $args );
			foreach ($replies as $key => $reply):
				$user = new WPRuby_User($reply->post_author);
				$replies[$key]->user = $user;
			endforeach;

			return $replies;
		}
}
