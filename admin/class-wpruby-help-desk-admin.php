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
		wp_enqueue_style( 'wp-color-picker' );
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
		wp_enqueue_script( 'wp-color-picker');
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
			'publicly_queryable' => true,
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
						$ticket = new WPRuby_Ticket(	$post_id	);
						if(isset( $_POST['publish'] )){
									$tickets_status = $_POST['ticket_status'];
									$tickets_product = $_POST['ticket_product'];
									$ticket_agent = $_POST['ticket_agent'];
									if(-1 != $tickets_status){
										wp_set_post_terms( $post_id, intval($tickets_status), WPRUBY_TICKET_STATUS );
									}
									if(-1 != $tickets_product){
										wp_set_post_terms( $post_id, intval($tickets_product), WPRUBY_TICKET_PRODUCT );
									}
									update_post_meta( $post_id, 'ticket_agent_id', intval($ticket_agent) );
						}elseif (isset( $_POST['reply'] ) || isset( $_POST['reply-close'] )	|| isset( $_POST['reply-reopen'] )) {
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
			remove_meta_box( 'submitdiv', WPRUBY_TICKET, 'side' );
			remove_meta_box( 'tickets_productsdiv', WPRUBY_TICKET, 'side' );
			remove_meta_box( 'tickets_statusdiv', WPRUBY_TICKET, 'side' );

			// adding the reply box only when the ticket is already created
			add_meta_box('ticket_options', __( 'Ticket Options', 'wpruby-help-desk' ), array($this, 'ticket_options_meta_box_callback'), WPRUBY_TICKET, 'side', 'high');
			if(isset($_GET['post'])){
				$ticket = new WPRuby_Ticket($_GET['post']);

				add_meta_box('ticket_information', __( 'Ticket Details', 'wpruby-help-desk' ), array($this, 'ticket_information_meta_box_callback'), WPRUBY_TICKET, 'side', 'high');

				add_meta_box('ticket_message', __( 'Ticket Message', 'wpruby-help-desk' ), array($this, 'ticket_message_meta_box_callback'), WPRUBY_TICKET, 'normal', 'high');
				if($ticket->get_replies()){
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
			$ticket_object = new WPRuby_Ticket($ticket->ID);
			$ticket_stats = $ticket_object->get_tickets_stats($ticket->post_author);
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-details-metabox.php';
		}
		/**
		 * This method is used to display the ticket_message meta box content
		 * @since    1.0.0
		 */
		public function ticket_message_meta_box_callback($ticket){
			$ticket_object = new WPRuby_Ticket($ticket->ID);
			$attachments = $ticket_object->get_attachments();
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-message-metabox.php';
		}
		/**
		 * This method is used to display the reply_to_ticket meta box content
		 * @since    1.0.0
		 */
		public function reply_meta_box_callback($post){
			$editor_settings = array( 'media_buttons' => false, 'textarea_rows' => 7 );
			$ticket = new WPRuby_Ticket(	$post->ID	);
			$ticket_status = $ticket->get_status();
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-reply-metabox.php';
		}
		/**
		 * This method is used to display the ticket publishing box
		 * @since    1.0.0
		 */
		public function ticket_options_meta_box_callback($post){
			$ticket = new WPRuby_Ticket(	$post->ID	);
			$ticket_status = $ticket->get_status();
			// get terms
			$statuses = get_terms( WPRUBY_TICKET_STATUS, array(  'hide_empty' => false ) );
			$products = get_terms( WPRUBY_TICKET_PRODUCT, array(  'hide_empty' => false ) );
			$ticket_agent = get_post_meta( $post->ID, 'ticket_agent_id', true );

			$agents = WPRuby_User::get_agents();
			// get ticket's terms @TODO change ids to slugs
			$ticket_product = wp_get_object_terms($post->ID, WPRUBY_TICKET_PRODUCT, array("fields" => "ids"));

			$ticket_product = (isset($ticket_product[0]))? $ticket_product[0]: -1;

			$publish_button_text = (isset($_GET['post']))? __('Update Ticket', 'wpruby-help-desk'): __('Create Ticket','wpruby-help-desk');
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-options-metabox.php';
		}


		/**
		 * This method is used to display the ticket replies box
		 * @since    1.0.0
		 */
		public function replies_meta_box_callback($ticket)
		{
			$ticket_object = new WPRuby_Ticket(	$ticket->ID	);
			$replies = $ticket_object->get_replies();
			require_once plugin_dir_path( __FILE__ ) . 'partials/wpruby-help-desk-ticket-replies-metabox.php';
		}

		/**
		 * This method is used to display the ticket replies box
		 * @since    1.0.0
		 */
		public function add_color_field_to_ticket_status() {
				// this will add the color meta field to the add new status page
				?>
					<div class="form-field">
						<label for="ticket_status_color"><?php _e( 'Status Color', 'wpruby-help-desk' ); ?></label>
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
 				 		<th scope="row" valign="top"><label for="ticket_status_color"><?php _e( 'Status Color', 'wpruby-help-desk' ); ?></label></th>
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
				$color = $_POST['ticket_status_color'];
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
			$count = count(WPRuby_Ticket::get_open_tickets());
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
		public function set_custom_edit_support_ticket_columns($columns) {
		    unset( $columns['taxonomy-tickets_status'] );
		    $columns['support_ticket_status'] = __( 'Status', 'wpruby-help-desk' );
		    return $columns;
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
								$ticket = new WPRuby_Ticket(	$post_id	);
								$ticket_status = $ticket->get_status();
								if($ticket_status)
									echo '<span class="ticket_status_label" style="background:'.$ticket_status['color'].';">'. $ticket_status['name'] .'</span>';
								else
									_e( '-', 'wpruby-help-desk' );
		            break;
		    }
		}


	/**
	 * Add the ticket status HTML to the custom column in the taxonomy page
	 * @param		array The original columns
	 * @return array The altered columns
	 * @since  1.0.0
	 */
	public function set_custom_ticket_status_columns_heads(	$columns	) {
			$columns['posts'] = __('Tickets', 'wpruby-help-desk');
			unset($columns['description']);
			$columns['color'] = __('Color', 'wpruby-help-desk');
	    return $columns;
	}


	/**
	 * Add the ticket status HTML to the custom column
	 * @param		string Original Content
	 * @param		string The column name
	 * @param		number The term (Status) ID
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

		wp_add_dashboard_widget('ruby_helpdesk_status_dashboard_widget',	__('Ruby Help Desk Status',	'wpruby-help-desk'),	array($this,	'helpdesk_status_dashboard_widget_content'));

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
		$tickets_object = new WPRuby_Ticket();
		$tickets_stats = $tickets_object->get_tickets_stats();
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
			'title' => __('Help Desk', 'wpruby-help-desk'),
			'href'  => '#',
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_all_tickets',
			'title' => __('All Tickets','wpruby-help-desk'),
			'href'  => admin_url('edit.php?post_type='. WPRUBY_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_create_ticket',
			'title' => __('Create Ticket','wpruby-help-desk'),
			'href'  => admin_url('post-new.php?post_type=' . WPRUBY_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_statuses',
			'title' => __('Statuses','wpruby-help-desk'),
			'href'  => admin_url('edit-tags.php?taxonomy='. WPRUBY_TICKET_STATUS .'&post_type=' . WPRUBY_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_products',
			'title' => __('Products','wpruby-help-desk'),
			'href'  => admin_url('edit-tags.php?taxonomy='. WPRUBY_TICKET_PRODUCT .'&post_type=' . WPRUBY_TICKET),
			'parent'=> 'rhd_main_menu'
		));
		$admin_bar->add_menu( array(
			'id'    => 'rhd_settings',
			'title' => __('Settings','wpruby-help-desk'),
			'href'  => admin_url('edit.php?post_type='. WPRUBY_TICKET .'&page=wpruby-help-desk-settings'),
			'parent'=> 'rhd_main_menu'
		));
	}

} //class end
