<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/admin
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Admin {

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
		 * defined in RHD_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The RHD_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ruby-help-desk-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-jquery-ui-theme', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.min.css', array(), $this->version, 'all' );

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
		 * defined in RHD_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The RHD_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 	$wc_sync_nonce 	= wp_create_nonce( 'wc_sync_nonce' );
		 	$edd_sync_nonce  = wp_create_nonce( 'edd_sync_nonce' );

			wp_enqueue_script( 'wp-color-picker');
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ruby-help-desk-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'rhd', array(
				'text_processed_products'			=>	__('Products have been successfully synced.', 'ruby-help-desk'),
				'text_no_processed_products'	=>	__('No new products were found.', 'ruby-help-desk'),
				'text_ticket_subject'					=>	__('Ticket Subject', 'ruby-help-desk'),
				'text_options'								=>	__('Options', 'ruby-help-desk'),
				'text_add_option'							=>	__('Add Option', 'ruby-help-desk'),
				'text_delete_confirmation'		=>	__('Are you sure that you want to delete this field? You can not Undo it if you save the changes.', 'ruby-help-desk'),

				'text_label'									=>	__('Label', 'ruby-help-desk'),
				'text_description'						=>	__('Description', 'ruby-help-desk'),
				'text_field_size'							=>	__('Field Size', 'ruby-help-desk'),
				'text_small'									=>	__('Small', 'ruby-help-desk'),
				'text_medium'									=>	__('Medium', 'ruby-help-desk'),
				'text_large'									=>	__('Large', 'ruby-help-desk'),
				'text_required'								=>	__('Required', 'ruby-help-desk'),

				'wc_sync_nonce'						=>	$wc_sync_nonce,
				'edd_sync_nonce'					=>	$edd_sync_nonce,
			) );
			/* @since 1.2.0 for Custom Fields */
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-accordion' );

	}
	/**
	 * The plugin use this method to register the main custom post type of the links.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types(){
		$labels = array(
			'name'               => _x( 'Tickets', 'post type general name', 'ruby-help-desk' ),
			'singular_name'      => _x( 'Create Ticket', 'post type singular name', 'ruby-help-desk' ),
			'menu_name'          => _x( 'Ruby Desk', 'admin menu', 'ruby-help-desk' ),
			'name_admin_bar'     => _x( 'Ticket', 'add new on admin bar', 'ruby-help-desk' ),
			'add_new'            => _x( 'Create Ticket', 'book', 'ruby-help-desk' ),
			'add_new_item'       => __( 'Create New Ticket', 'ruby-help-desk' ),
			'new_item'           => __( 'Create New Ticket', 'ruby-help-desk' ),
			'edit_item'          => __( 'Edit Ticket', 'ruby-help-desk' ),
			'view_item'          => __( 'View Ticket', 'ruby-help-desk' ),
			'all_items'          => __( 'All Tickets', 'ruby-help-desk' ),
			'search_items'       => __( 'Search Tickets', 'ruby-help-desk' ),
			'parent_item_colon'  => __( 'Parent Tickets:', 'ruby-help-desk' ),
			'not_found'          => __( 'No tickets found.', 'ruby-help-desk' ),
			'not_found_in_trash' => __( 'No tickets found in Trash.', 'ruby-help-desk' )
		);
		$supports = array('title');

		if( !isset( $_GET['post'] ) ) {
			$supports[] = 'editor';
		}

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => RHD_TICKET ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => $supports,
			'menu_icon'			 => 'dashicons-tickets',

		);

		register_post_type( RHD_TICKET, $args );


			//Knowledgebase Articles
			$labels = array(
				'name'               => _x( 'Knowledgebase', 'post type general name', 'ruby-help-desk' ),
				'singular_name'      => _x( 'New Document', 'post type singular name', 'ruby-help-desk' ),
				'menu_name'          => _x( 'Ruby Desk Knowledgebase', 'admin menu', 'ruby-help-desk' ),
				'name_admin_bar'     => _x( 'Knowledgebase', 'add new on admin bar', 'ruby-help-desk' ),
				'add_new'            => _x( 'New Document', 'book', 'ruby-help-desk' ),
				'add_new_item'       => __( 'Create New Document', 'ruby-help-desk' ),
				'new_item'           => __( 'Create New Document', 'ruby-help-desk' ),
				'edit_item'          => __( 'Edit Document', 'ruby-help-desk' ),
				'view_item'          => __( 'View Document', 'ruby-help-desk' ),
				'all_items'          => __( 'Knowledgebase', 'ruby-help-desk' ),
				'search_items'       => __( 'Search Documents', 'ruby-help-desk' ),
				'parent_item_colon'  => __( 'Parent Documents:', 'ruby-help-desk' ),
				'not_found'          => __( 'No documents found.', 'ruby-help-desk' ),
				'not_found_in_trash' => __( 'No documents found in Trash.', 'ruby-help-desk' )
			);


			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => 'edit.php?post_type='	.	RHD_TICKET,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => RHD_KNOWLEDGEBASE ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_icon'			 => 'dashicons-tickets',

			);
			register_post_type( RHD_KNOWLEDGEBASE, $args );

		// Replies Templates
		$labels = array(
			'name'               => _x( 'Replies Templates', 'post type general name', 'ruby-help-desk' ),
			'singular_name'      => _x( 'New Replies Template', 'post type singular name', 'ruby-help-desk' ),
			'menu_name'          => _x( 'Replies Templates', 'admin menu', 'ruby-help-desk' ),
			'name_admin_bar'     => _x( 'Replies Template', 'add new on admin bar', 'ruby-help-desk' ),
			'add_new'            => _x( 'New Replies Template', 'book', 'ruby-help-desk' ),
			'add_new_item'       => __( 'Create New Replies Template', 'ruby-help-desk' ),
			'new_item'           => __( 'Create New Replies Template', 'ruby-help-desk' ),
			'edit_item'          => __( 'Edit Replies Template', 'ruby-help-desk' ),
			'view_item'          => __( 'View Replies Template', 'ruby-help-desk' ),
			'all_items'          => __( 'Replies Templates', 'ruby-help-desk' ),
			'search_items'       => __( 'Search Replies Templates', 'ruby-help-desk' ),
			'parent_item_colon'  => __( 'Parent Replies Templates:', 'ruby-help-desk' ),
			'not_found'          => __( 'No Replies Template found.', 'ruby-help-desk' ),
			'not_found_in_trash' => __( 'No Replies Template found in Trash.', 'ruby-help-desk' )
		);


		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type='	.	RHD_TICKET,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => RHD_REPLIES_TEMPLATE ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_icon'			 => 'dashicons-admin-comments',

		);
		register_post_type( RHD_REPLIES_TEMPLATE, $args );


			//Tickets Reply
			$labels = array(
				'name'               => _x( 'Tickets Reply', 'post type general name', 'ruby-help-desk' ),
				'singular_name'      => _x( 'Create Ticket Reply', 'post type singular name', 'ruby-help-desk' ),
				'menu_name'          => _x( 'Ruby Desk', 'admin menu', 'ruby-help-desk' ),
				'name_admin_bar'     => _x( 'Ticket Reply', 'add new on admin bar', 'ruby-help-desk' ),
				'add_new'            => _x( 'Create Ticket Reply', 'book', 'ruby-help-desk' ),
				'add_new_item'       => __( 'Create New Ticket Reply', 'ruby-help-desk' ),
				'new_item'           => __( 'Create New Ticket Reply', 'ruby-help-desk' ),
				'edit_item'          => __( 'Edit Ticket Reply', 'ruby-help-desk' ),
				'view_item'          => __( 'View Ticket Reply', 'ruby-help-desk' ),
				'all_items'          => __( 'All Tickets Reply', 'ruby-help-desk' ),
				'search_items'       => __( 'Search Tickets Reply', 'ruby-help-desk' ),
				'parent_item_colon'  => __( 'Parent Tickets Reply:', 'ruby-help-desk' ),
				'not_found'          => __( 'No tickets found.', 'ruby-help-desk' ),
				'not_found_in_trash' => __( 'No tickets found in Trash.', 'ruby-help-desk' )
			);


			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => false,
				'show_ui'            => false,
				'show_in_menu'       => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => RHD_TICKET_REPLY ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
			);

			register_post_type( RHD_TICKET_REPLY, $args );
	}

		/**
		 * The plugin use this method to register the custom taxonomies of the links.
		 * @since    1.0.0
		 */
		public function register_taxonomies(){
			$labels = array(
				'name'                       => _x( 'Ticket Status', 'taxonomy general name' ),
				'singular_name'              => _x( 'Ticket Status', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Ticket Statuses', 'ruby-help-desk' ),
				'popular_items'              => __( 'Popular Ticket Statuses', 'ruby-help-desk' ),
				'all_items'                  => __( 'All Ticket Statuses','ruby-help-desk' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Ticket Status','ruby-help-desk' ),
				'update_item'                => __( 'Update Ticket Status','ruby-help-desk' ),
				'add_new_item'               => __( 'Add New Ticket Status','ruby-help-desk' ),
				'new_item_name'              => __( 'New Ticket Status','ruby-help-desk' ),
				'separate_items_with_commas' => __( 'Separate statuses with commas','ruby-help-desk' ),
				'add_or_remove_items'        => __( 'Add or remove ticket status','ruby-help-desk' ),
				'choose_from_most_used'      => __( 'Choose from the most used statuses','ruby-help-desk' ),
				'not_found'                  => __( 'No Tickets Statuses found.','ruby-help-desk' ),
				'menu_name'                  => __( 'Statuses','ruby-help-desk' ),
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

			register_taxonomy( RHD_TICKET_STATUS, RHD_TICKET, $args );
			//adding the products taxonomy
			$labels = array(
				'name'                       => _x( 'Product', 'taxonomy general name' ),
				'singular_name'              => _x( 'Product', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Products', 'ruby-help-desk' ),
				'popular_items'              => __( 'Popular Products', 'ruby-help-desk' ),
				'all_items'                  => __( 'All Products','ruby-help-desk' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Product','ruby-help-desk' ),
				'update_item'                => __( 'Update Product','ruby-help-desk' ),
				'add_new_item'               => __( 'Add New Product','ruby-help-desk' ),
				'new_item_name'              => __( 'New Product','ruby-help-desk' ),
				'separate_items_with_commas' => __( 'Separate statuses with commas','ruby-help-desk' ),
				'add_or_remove_items'        => __( 'Add or remove ticket status','ruby-help-desk' ),
				'choose_from_most_used'      => __( 'Choose from the most used statuses','ruby-help-desk' ),
				'not_found'                  => __( 'No Tickets Statuses found.','ruby-help-desk' ),
				'menu_name'                  => __( 'Products','ruby-help-desk' ),
			);

			$args = array(
				'hierarchical'          => true,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => RHD_TICKET_PRODUCT ),
			);

			register_taxonomy( RHD_TICKET_PRODUCT, array(RHD_KNOWLEDGEBASE, RHD_TICKET) , $args );
		}

		/**
		 * Ticket update messages.
		 * @param array $messages Existing post update messages.
		 * @return array Amended post update messages with new CPT update messages.
		 */
		public function ticket_updated_messages( $messages ) {
			$post             = get_post();
			$post_type        = get_post_type( $post );
			$post_type_object = get_post_type_object( $post_type );

			$messages[RHD_TICKET] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Ticket updated.', 'ruby-help-desk' ),
				2  => __( 'Custom field updated.', 'ruby-help-desk' ),
				3  => __( 'Custom field deleted.', 'ruby-help-desk' ),
				4  => __( 'Ticket updated.', 'ruby-help-desk' ),
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Ticket restored to revision from %s', 'ruby-help-desk' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => __( 'Ticket updated.', 'ruby-help-desk' ),
				7  => __( 'Ticket saved.', 'ruby-help-desk' ),
				8  => __( 'Ticket submitted.', 'ruby-help-desk' ),
				9  => sprintf(
					__( 'Ticket scheduled for: <strong>%1$s</strong>.', 'ruby-help-desk' ),
					date_i18n( __( 'M j, Y @ G:i', 'ruby-help-desk' ), strtotime( $post->post_date ) )
				),
				10 => __( 'Ticket draft updated.', 'ruby-help-desk' )
			);

			return $messages;
		}
		/**
		 * The plugin use this method to save ticket details, such as status, product ... etc.
		 * @since    1.0.0
		 */
		public function save_ticket_details( $post_id, $post, $update){
			if(isset($_POST) && !empty($_POST)){
					$post_type = get_post_type($post_id);
					if(RHD_TICKET == $post_type){
						$ticket = new RHD_Ticket(	$post_id	);
						if(isset( $_POST['publish'] )){
									$tickets_status = intval($_POST['ticket_status']);
									$tickets_product = intval($_POST['ticket_product']);
									$ticket_agent = intval($_POST['ticket_agent']);
									if(-1 != $tickets_status){
										wp_set_post_terms( $post_id, $tickets_status, RHD_TICKET_STATUS );
									}
									if(-1 != $tickets_product){
										wp_set_post_terms( $post_id, $tickets_product, RHD_TICKET_PRODUCT );
									}
									//info: check if the ticket was re-assigned.
									$old_assignee = get_post_meta( $post_id, 'ticket_agent_id', true );
									if($old_assignee != $ticket_agent){
										RHD_Email::ticket_reassigned(	$post_id, 	$old_assignee);
									}
									update_post_meta( $post_id, 'ticket_agent_id', $ticket_agent );
									//info: update custom fields
									$rhd_custom_fields = new RHD_Custom_Fields();
									foreach ($rhd_custom_fields->get_custom_fields_keys() as $key){
										if(isset($_POST[	$key 	])){
											$value = $rhd_custom_fields->sanitize($key,	$_POST[$key]);
											update_post_meta( intval($post_id), $key, $value);
										}
									}
						}elseif (isset( $_POST['reply'] ) || isset( $_POST['reply-close'] )	|| isset( $_POST['reply-reopen'] )) {
								if(isset($_POST['ticket_reply']) && "" != $_POST['ticket_reply']){
										$ticket_reply_args = array(
											'post_title'		=>	'Reply to ticket #' . $post_id,
											'post_content'	=>	sanitize_textarea_field($_POST['ticket_reply']),
											'post_status'		=>	'publish',
											'post_type'			=>	RHD_TICKET_REPLY,
											'post_parent'		=>	intval($post_id),
										);
										wp_insert_post( $ticket_reply_args );
								}
								if(isset($_POST['reply-close'])){
									//closing the ticket
									$ticket->close_ticket($post_id);
								}
								if(isset($_POST['reply-reopen'])){#
									$ticket->open_ticket($post_id);
								}
						}
					}
			}


		}

		/**
		 * This method is used to add/remove different meta boxes
		 * @since    1.0.0
		 */
		public function add_tickets_metaboxes(){
			//remove the publishing box
			remove_meta_box( 'submitdiv', RHD_TICKET, 'side' );
			remove_meta_box( 'tickets_productsdiv', RHD_TICKET, 'side' );
			remove_meta_box( 'tickets_statusdiv', RHD_TICKET, 'side' );

			// adding the reply box only when the ticket is already created
			add_meta_box('ticket_options', __( 'Ticket Options', 'ruby-help-desk' ), array($this, 'ticket_options_meta_box_callback'), RHD_TICKET, 'side', 'high');
			if(isset($_GET['post'])){
				$ticket = new RHD_Ticket(intval($_GET['post']));

				add_meta_box('ticket_information', __( 'Customer Details', 'ruby-help-desk' ), array($this, 'ticket_information_meta_box_callback'), RHD_TICKET, 'side', 'high');
				add_meta_box('custom_fields', __( 'Custom Fields', 'ruby-help-desk' ), array($this, 'custom_fields_meta_box_callback'), RHD_TICKET, 'normal', 'high');
				add_meta_box('ticket_message', __( 'Ticket Message', 'ruby-help-desk' ), array($this, 'ticket_message_meta_box_callback'), RHD_TICKET, 'normal', 'high');

				if($ticket->get_replies()){
					add_meta_box('ticket_replies', __( 'Replies', 'ruby-help-desk' ), array($this, 'replies_meta_box_callback'), RHD_TICKET, 'normal');
				}

				add_meta_box('reply_to_ticket', __( 'Reply', 'ruby-help-desk' ), array($this, 'reply_meta_box_callback'), RHD_TICKET, 'normal', 'high');

			}
		}
		/**
		 * This method is used to display the ticket_information meta box content
		 * @since    1.0.0
		 */
		public function ticket_information_meta_box_callback($ticket){
			$user = new RHD_User($ticket->post_author);
			$ticket_object = new RHD_Ticket($ticket->ID);
			$ticket_stats = $ticket_object->get_tickets_stats($ticket->post_author);
			require_once plugin_dir_path( __FILE__ ) . 'partials/ruby-help-desk-ticket-details-metabox.php';
		}
		/**
		 * This method is used to display the ticket_information meta box content
		 * @since    1.0.0
		 */
		public function custom_fields_meta_box_callback($ticket){
			$rhd_custom_fields = new RHD_Custom_Fields(true);
			require_once plugin_dir_path( __FILE__ ) . 'partials/ruby-help-desk-custom-fields-metabox.php';
		}
		/**
		 * This method is used to display the ticket_message meta box content
		 * @since    1.0.0
		 */
		public function ticket_message_meta_box_callback($ticket){
			$ticket_object = new RHD_Ticket($ticket->ID);
			$attachments = $ticket_object->get_attachments();
			require_once plugin_dir_path( __FILE__ ) . 'partials/ruby-help-desk-ticket-message-metabox.php';
		}
		/**
		 * This method is used to display the reply_to_ticket meta box content
		 * @since    1.0.0
		 */
		public function reply_meta_box_callback($post){
			$editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
			$ticket = new RHD_Ticket(	$post->ID	);
			$ticket_status = $ticket->get_status();
			$replies_templates = RHD_Replies_Templates::getTemplates($ticket);
			require_once plugin_dir_path( __FILE__ ) . 'partials/ruby-help-desk-ticket-reply-metabox.php';
		}
		/**
		 * This method is used to display the ticket publishing box
		 * @since    1.0.0
		 */
		public function ticket_options_meta_box_callback($post){
			$ticket = new RHD_Ticket(	$post->ID	);
			$ticket_status = $ticket->get_status();
			// get terms
			$statuses = get_terms( RHD_TICKET_STATUS, array(  'hide_empty' => false ) );
			$products = get_terms( RHD_TICKET_PRODUCT, array(  'hide_empty' => false ) );
			$ticket_agent = get_post_meta( $post->ID, 'ticket_agent_id', true );

			$agents = RHD_User::get_agents();
			$ticket_product = wp_get_object_terms($post->ID, RHD_TICKET_PRODUCT, array("fields" => "ids"));

			$ticket_product = (isset($ticket_product[0]))? $ticket_product[0]: -1;

			$publish_button_text = (isset($_GET['post']))? __('Update Ticket', 'ruby-help-desk'): __('Create Ticket','ruby-help-desk');
			require_once plugin_dir_path( __FILE__ ) . 'partials/ruby-help-desk-ticket-options-metabox.php';
		}


		/**
		 * This method is used to display the ticket replies box
		 * @since    1.0.0
		 */
		public function replies_meta_box_callback($ticket)
		{
			$ticket_object = new RHD_Ticket(	$ticket->ID	);
			$replies = $ticket_object->get_replies();
			require_once plugin_dir_path( __FILE__ ) . 'partials/ruby-help-desk-ticket-replies-metabox.php';
		}

		/**
		 * This method is used to display the ticket replies box
		 * @since    1.0.0
		 */
		public function add_color_field_to_ticket_status() {
				// this will add the color meta field to the add new status page
				?>
					<div class="form-field">
						<label for="ticket_status_color"><?php _e( 'Status Color', 'ruby-help-desk' ); ?></label>
						<input type="text" name="ticket_status_color" class="ticket-status-color-field" id="ticket_status_color" value="">
					</div>
				<?php
		}
		public function edit_color_field_to_ticket_status($term) {
				// put the term ID into a variable
				$term_id = intval($term->term_id);

				// retrieve the existing value(s) for this meta field. This returns an array
				$color = get_term_meta($term_id, 'ticket_status_color', true);
				 ?>

				 <tr class="form-field">
 				 		<th scope="row" valign="top"><label for="ticket_status_color"><?php _e( 'Status Color', 'ruby-help-desk' ); ?></label></th>
							<td>
								<input type="text" name="ticket_status_color" class="ticket-status-color-field" id="ticket_status_color" value="<?php echo $color; ?>">
							</td>
				</tr>
				<?php
		}
		/**
		 * Save Ticket Status Color
		 *
		 * @param number The status term ID.
		 * @since  1.0.0
		 */
		public function save_ticket_status_color_meta( $term_id ) {
			if ( isset( $_POST['ticket_status_color'] ) ) {
				$color = sanitize_text_field($_POST['ticket_status_color']);
				update_term_meta ($term_id, 'ticket_status_color', $color);
			}
		}
		/**
		 * Add ticket count in admin menu item.
		 *
		 * @return boolean True if the ticket count was added, false otherwise
		 * @since  1.0.0
		 */
		public function tickets_count() {

			global $menu, $current_user;
			$count = count(RHD_Ticket::get_open_tickets());
			foreach ( $menu as $key => $value ) {
				if ( $menu[ $key ][2] == 'edit.php?post_type=support_ticket' ) {
					$menu[ $key ][0] .= ' <span class="awaiting-mod count-' . $count . '"><span class="pending-count">' . $count . '</span></span>';
				}
			}

			return true;
		}

		/**
		 * Add ticket_status custom column
		 * @param		array The original columns
		 * @return array The altered columns
		 * @since  1.0.0
		 */
		public function set_custom_edit_support_ticket_columns($old_columns) {
				$new_columns = array();
				$new_columns['cb'] = $old_columns['cb'];
			    $new_columns['support_ticket_title'] = __('Ticket title', 'ruby-help-desk');
				$new_columns['support_ticket_id'] = __('Ticket #ID', 'ruby-help-desk');
				$new_columns['taxonomy-tickets_products'] = $old_columns['taxonomy-tickets_products'];
				$new_columns['support_ticket_assignee'] = __( 'Assignee', 'ruby-help-desk' );
				$new_columns['support_ticket_customer'] = __( 'Customer', 'ruby-help-desk' );
		        $new_columns['support_ticket_replies'] = __( 'Replies', 'ruby-help-desk' );
				$new_columns['date'] = $old_columns['date'];
			    $new_columns['support_ticket_status'] = __( 'Status', 'ruby-help-desk' );
			return $new_columns;
		}

		/**
		 * Add the ticket status HTML to the custom column
		 * @param		string The column ID
		 * @param		number The ticket ID
		 * @since  1.0.0
		 */
		public function custom_support_ticket_column( $column, $post_id ) {
		    switch ( $column ) {

		        case 'support_ticket_status' :
								$ticket = new RHD_Ticket(	$post_id	);
								$ticket_status = $ticket->get_status();
								if($ticket_status)
									echo '<span class="ticket_status_label" style="background:'.$ticket_status['color'].';">'. $ticket_status['name'] .'</span>';
								else
									_e( '-', 'ruby-help-desk' );
		            break;
						case 'support_ticket_assignee' :
							 	$ticket = new RHD_Ticket(	$post_id	);
							  echo '<a href="'. admin_url('user-edit.php?user_id=' . $ticket->get_assignee()->get_id()) .'">'	.	$ticket->get_assignee()->get_full_name()	.	'</a>';
								break;
						case 'support_ticket_customer' :
								$ticket = new RHD_Ticket(	$post_id	);
								echo '<a href="'. admin_url('user-edit.php?user_id=' . $ticket->get_author()->get_id()) .'">'	.	$ticket->get_author()->get_full_name()	.	'</a>';
								break;
						case 'support_ticket_replies' :
								$ticket = new RHD_Ticket(	$post_id	);
								$replies_count = count(	$ticket->get_replies()	);
								echo $replies_count;
								break;
						case 'support_ticket_id' :
								echo $post_id;
								break;
						case 'support_ticket_title' :
								echo '<a href="'. get_edit_post_link($post_id) .'">' .get_post_field( 'post_title', $post_id )  . '</a>';
								break;
		    }
		}


	/**
	 * Add the ticket status HTML to the custom column in the taxonomy page
	 * @param		array $columns original columns
	 * @return array The altered columns
	 * @since  1.0.0
	 */
	public function set_custom_ticket_status_columns_heads(	$columns	) {
			$columns['posts'] = __('Tickets', 'ruby-help-desk');
			unset($columns['description']);
			$columns['color'] = __('Color', 'ruby-help-desk');
	    return $columns;
	}


	/**
	 * Add the ticket status HTML to the custom column
	 * @param		string $out Original Content
	 * @param		string $column_name The column name
	 * @param		number $term_id The term (Status) ID
	 * @since  1.0.0
	 */
	public function set_custom_ticket_status_columns_data($out, $column_name, $term_id) {
			$color = get_term_meta($term_id, 'ticket_status_color', true);
	    switch ($column_name) {
	        case 'color':
							$out .= '<div class="ticket_status_label" style="background:'.$color.'; width:50px; height:20px;"></div>';
	            break;

	        default:
	            break;
	    }
	    echo $out;
	}
	/**
	 * Setup the Dashboard Widget
	 * @since  1.0.0
	 */
	public function helpdesk_status_dashboard_widget() {

		wp_add_dashboard_widget('ruby_helpdesk_status_dashboard_widget',	__('Ruby Help Desk Status',	'ruby-help-desk'),	array($this,	'helpdesk_status_dashboard_widget_content'));

		//info: Forcing the widget to the top
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

	 	$ruby_helpdesk_widget_backup = array( 'ruby_helpdesk_status_dashboard_widget' => $normal_dashboard['ruby_helpdesk_status_dashboard_widget'] );
	 	unset( $normal_dashboard['ruby_helpdesk_status_dashboard_widget'] );

	 	// Merge the two arrays together so our widget is at the beginning
	 	$sorted_dashboard = array_merge( $ruby_helpdesk_widget_backup, $normal_dashboard );

	 	// Save the sorted array back into the original metaboxes
	 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;

	}
	/**
	 * Output the contents of the Dashboard Status Widget.
	 * @since  1.0.0
	 */
	public function helpdesk_status_dashboard_widget_content() {
		$tickets_object = new RHD_Ticket();
		$tickets_stats = $tickets_object->get_tickets_stats();
		$recent_tickets = $tickets_object->get_tickets(array('posts_per_page'	=>	5));
		require_once plugin_dir_path( __FILE__ ) . 'partials/widgets/status.php';
	}
	/**
	 * add plugin links to the top admin menu
	 * @param		object The admin menu object
	 * @since  1.0.0
	 */
	public function add_quicklinks_to_admin_topbar(	$admin_bar	){
		//In case the user has no capabilities
		if(!current_user_can('manage_options')) return;
		$admin_bar->add_menu( array(
			'id'    => 'rhd_main_menu',
			'title' => __('Help Desk', 'ruby-help-desk'),
			'href'  => '#',
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_all_tickets',
			'title' => __('All Tickets','ruby-help-desk'),
			'href'  => admin_url('edit.php?post_type='. RHD_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_create_ticket',
			'title' => __('Create Ticket','ruby-help-desk'),
			'href'  => admin_url('post-new.php?post_type=' . RHD_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_statuses',
			'title' => __('Statuses','ruby-help-desk'),
			'href'  => admin_url('edit-tags.php?taxonomy='. RHD_TICKET_STATUS .'&post_type=' . RHD_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_products',
			'title' => __('Products','ruby-help-desk'),
			'href'  => admin_url('edit-tags.php?taxonomy='. RHD_TICKET_PRODUCT .'&post_type=' . RHD_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_knowledgebase',
			'title' => __('Knowledgebase','ruby-help-desk'),
			'href'  => admin_url('edit.php?post_type=' . RHD_KNOWLEDGEBASE),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_settings',
			'title' => __('Settings','ruby-help-desk'),
			'href'  => admin_url('edit.php?post_type='. RHD_TICKET .'&page=ruby-help-desk-settings'),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_custom_fields',
			'title' => __('Custom Fields','ruby-help-desk'),
			'href'  => admin_url('edit.php?post_type='. RHD_TICKET .'&page=ruby-help-desk-custom-fields'),
			'parent'=> 'rhd_main_menu'
		));
	}
	/**
	 * Perform upgrades, shall be used extensively in the future releases.
	 * @since  1.0.0
	 */
	public function perform_upgrades(){

		//add upgrades here (Use a different class)

		//after performing the upgrades, set the db version to the current files version
		update_option('rhd_db_version', RHD_VERSION);

	}


	/**
	 * Syncing WooCommerce Products
	 * @since  1.1.0
	 */
	public function sync_wc_products(){
		$nonce = $_POST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'wc_sync_nonce' ) ) {
			wp_die(__('Security validation failed', 'ruby-help-desk'));
		}
		$synced_products_count = 0;
		if(function_exists('wc_get_products')){
			$args = array(
				'status' => 'publish',
				'limit' => -1,
			);
			$wc_products = wc_get_products(	$args	);
			foreach ($wc_products as $key => $product) {
				if(!term_exists($product->get_name(), RHD_TICKET_PRODUCT)){
					$synced_product = wp_insert_term($product->get_name(), RHD_TICKET_PRODUCT);

					if(!is_wp_error($synced_product)){
						add_term_meta ($synced_product['term_id'], 'wc_product_id', $product->get_id(), true);
						$synced_products_count++;
					}
				}
			}
		}
		echo $synced_products_count;
		wp_die();
	}
	/**
	 * Syncing Easy Digital Downloads Products
	 * @since  1.1.0
	 */
	public function sync_edd_products(){
		$nonce = $_POST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'edd_sync_nonce' ) ) {
			wp_die(__('Security validation failed', 'ruby-help-desk'));
		}
		$synced_products_count = 0;
		if(class_exists('EDD_API')){
			$edd_api = new EDD_API();
			$args = array(
				'posts_per_page' => 9999999,
			);
			$edd_products = $edd_api->get_products(	$args	);
			foreach ($edd_products['products'] as $key => $product) {
				if(!term_exists($product['info']['title'], RHD_TICKET_PRODUCT)){
					$synced_product = wp_insert_term($product['info']['title'], RHD_TICKET_PRODUCT);

					if(!is_wp_error($synced_product)){
						add_term_meta ($synced_product['term_id'], 'edd_product_id', $product['info']['id'], true);
						$synced_products_count++;
					}
				}
			}
		}
		echo $synced_products_count;
		wp_die();
	}
	/**
	 * Adding subpages of the plugin's menu items
	 * @since  1.2.0
	 */
	public function add_subpages(){
		/*
		* @since 1.2.0 adding subpage for custom fields
		*/
		add_submenu_page('edit.php?post_type=support_ticket',	__( 'Custom Fields', 'ruby-help-desk' ),	__( 'Custom Fields', 'ruby-help-desk' ),	'manage_options',	'ruby-help-desk-custom-fields',	array($this, 'custom_fields_page_output'));
	}
	/**
	 * render Custom Fields page.
	 * @since  1.2.0
	 */
	public function custom_fields_page_output(){
		$rhd_custom_fields = new RHD_Custom_Fields();
		$core_fields = $rhd_custom_fields->get_core_fields();
		ob_start();
		require_once plugin_dir_path( __FILE__ ) . 'partials/pages/custom-fields.php';
		echo ob_get_clean();
	}
	/**
	 * Saving custom fields settings
	 * @since  1.2.0
	 */
	public function process_custom_fields(){
		if(isset($_POST['save_custom_fields'])){
			if(isset($_POST['rhd_custom_fields']) && is_array($_POST['rhd_custom_fields'])){
				$saved_cusom_fields = $_POST['rhd_custom_fields'];
				update_option('rhd_saved_cusom_fields', $saved_cusom_fields);
			}
		}

	}


} //class end
