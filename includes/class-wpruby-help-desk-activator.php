<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpruby_Help_Desk
 * @subpackage Wpruby_Help_Desk/includes
 * @author     WPRuby <info@wpruby.com>
 */
class Wpruby_Help_Desk_Activator {

	private $is_seeded = 'no';



	public function __construct(){}
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
			$this->set_seeded('no');
			//@TODO Seed Data on Activation
			$this->is_seeded = get_option('wpruby_help_desk_seeded');

			if($this->is_seeded !== 'yes'){
				$this->seed_pages();
				$this->seed_statuses();
				//set the seeded flag.
				$this->set_seeded('yes');
		 	}

	}

	private function set_seeded( $value ){
		update_option( 'wpruby_help_desk_seeded', $value);
		$this->is_seeded = $value;
	}


	private function seed_pages(){
				// insert Default Pages
				$main_page = array(
							'post_content'	=>	'',
							'post_title'	=>	__('Help Desk', 'wpruby-help-desk'),
							'post_type'		=>	'page',
							'post_status'	=>	'publish',
							'post_parent' => null,
				);
				$main_page_id = wp_insert_post(	$main_page	);

				$pages =	array(
					array(
								'post_content'	=>	'[submit_ticket]',
								'post_title'	=>	__('Submit Ticket', 'wpruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
					array(
								'post_content'	=>	'[my_tickets]',
								'post_title'	=>	__('My Tickets', 'wpruby-help-desk'),
								'post_type'		=>	'page',
								'post_status'	=>	'publish',
								'post_parent' => $main_page_id,
					),
				);
				foreach ($pages as $key => $page_args) {
					$page_id = wp_insert_post(	$page_args );
					update_option( 'wpruby_' . $page_args['post_content'], $page_id);
				}
	}


	private function seed_statuses(){
				// insert default Ticket Statuses
				$statuses = array(
					array(
						'term'	=>	'Closed',
						'color'	=>	'#ff0000',
					),
					array(
						'term'	=>	'In Progress',
						'color'	=>	'#679469',
					),
					array(
						'term'	=>	'New',
						'color'	=>	'#b491ce',
					),
				);
				
				foreach($statuses as $key => $status){
					if(! term_exists($status['term'],	WPRUBY_TICKET_STATUS)){
							$term = wp_insert_term($status['term'], WPRUBY_TICKET_STATUS);
							if(isset($term['term_id'])){
								update_term_meta ($term['term_id'], 'ticket_status_color', $status['color']);
							}
					}
				}
	}
}
