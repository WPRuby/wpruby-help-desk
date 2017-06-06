<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ruby_Help_Desk
 * @subpackage Ruby_Help_Desk/includes
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Activator {

	public function __construct(){}
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

			if(!$this->is_seeded()){
					$this->add_roles();
					$this->seed_pages();
					$this->seed_statuses();
					$this->seed_products();
					$this->seed_settings();
					//info: flush rewrite rules for the new Post Types.
					flush_rewrite_rules();
					//info: set the seeded flag.
					$this->set_seeded('yes');
			}
	}
	/**
	 * Set the "already seeded" flag. It's used so the plugin does not seed on every activation.
	 * @param		 string		'on' or 'off'
	 * @since    1.0.0
	 */
	private function set_seeded( $value ){
		update_option( 'rhd_seeded'	, $value);
	}
	/**
	 * Get if the plugin is seeded based.
	 * @param		 string		'on' or 'off'
	 * @since    1.0.0
	 */
	private function is_seeded( ){
		return (get_option( 'rhd_seeded', 'no') === 'yes');
	}
	/**
	 * Seeding the plugin frontend pages.
	 * @since    1.0.0
	 */
	private function seed_pages(){
				// insert Default Pages
				$main_page = array(
							'post_content'	=>	'',
							'post_title'	=>	__('Help Desk', 'ruby-help-desk'),
							'post_type'		=>	'page',
							'post_status'	=>	'publish',
							'post_parent' => null,
				);
				$main_page_id = wp_insert_post(	$main_page	);

				$pages =	array(
					array(
								'post_content'	=>	'[submit_ticket]',
								'post_title'	=>	__('Submit Ticket', 'ruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[my_tickets]',
								'post_title'	=>	__('My Tickets', 'ruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[ruby_help_desk_login]',
								'post_title'	=>	__('Login', 'ruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[ruby_help_desk_signup]',
								'post_title'	=>	__('Sign Up', 'ruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[knowledgebase]',
								'post_title'	=>	__('Knowledgebase', 'ruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
				);
				foreach ($pages as $key => $page_args) {
					$page_id = wp_insert_post(	$page_args );
					update_option( 'rhd_' . $page_args['post_content'], $page_id);
				}
	}

	/**
	 * Seeding the plugin tickets default statuses
	 * @since    1.0.0
	 */
	private function seed_statuses(){
				// insert default Ticket Statuses
				$statuses = array(
					array(
						'term'	=>	'Closed',
						'color'	=>	'#ff0000',
						'slug'	=>	'closed',
					),
					array(
						'term'	=>	'In Progress',
						'color'	=>	'#679469',
						'slug'	=>	'in-progress',
					),
					array(
						'term'	=>	'New',
						'color'	=>	'#b491ce',
						'slug'	=>	'new',
					),
				);

				foreach($statuses as $key => $status){
					if(! term_exists($status['term'],	RHD_TICKET_STATUS)){
							$term = wp_insert_term($status['term'], RHD_TICKET_STATUS, array('slug' => $status['slug']));
							if(isset($term['term_id'])){
								update_term_meta ($term['term_id'], 'ticket_status_color', $status['color']);
								update_option( 'rhd_ticket_status_' . $status['slug'], $term['term_id']);
							}
					}
				}
	}

	/**
	 * Seeding the plugin tickets default product.
	 * @since    1.0.0
	 */
	private function seed_products(){
			// insert default Ticket Statuses
			$products = array(
					array(
						'term'	=>	__('Sample Product', 'ruby-help-desk'),
					)
			);
			foreach($products as $key => $product){
				if(! term_exists($product['term'],	RHD_TICKET_PRODUCT)){
						$term = wp_insert_term($product['term'], RHD_TICKET_PRODUCT);
				}
			}
	}

	/**
	 * Adding the help desk custom roles, and adding the Agent role to all of the admins.
	 *
	 * @since    1.0.0
	 */
	public function add_roles(){
		//info: add the help desk custom roles
		$author     = get_role( 'author' );
		$subscriber = get_role( 'subscriber' );
		add_role( RHD_AGENT, __('Help Desk Agent', 'ruby-help-desk'), $author->capabilities );
		add_role( RHD_CUSTOMER, __('Help Desk Customer', 'ruby-help-desk'), $subscriber->capabilities );

		//add the Agent role to all of the admin
		$administrators = get_users(
			array(
				'role'		=>	'administrator',
				'fields'  =>	array('ID', 'user_login')
			)
		);
		foreach($administrators as $admin){
			$admin_user = new WP_User($admin->ID);
			$admin_user->add_role(RHD_AGENT);
		}

	}

	/**
	 * Seeding the default plugin's settings.
	 *
	 * @since    1.0.0
	 */
	public function seed_settings(){
		$default_options = array(
				'rhd_general'	=>	array(
					'default_agent_assignee'	=>	get_current_user_id(),
					'enable_email_transcript'	=>	'off',
				),
				'rhd_attachments'	=>	array(
					'enable_attachments'	=>	'on',
					'max_size_attachments'	=>	'2',
					'allowed_extensions_attachments'	=>	'pdf,jpg,png,zip',
				)
		);

		foreach($default_options as $key => $option){
				add_option($key,	$option) OR update_option($key,	$option);
		}
	}

}
