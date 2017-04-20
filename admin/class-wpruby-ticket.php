<?php

/**
 * The Ticket helper class of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    WPRuby_Ticket
 * @subpackage WPRuby_Ticket/admin
 */

/**
 * The User helper class of the plugin.
 *
 *
 * @package    WPRuby_Ticket
 * @subpackage WPRuby_Ticket/admin
 * @author     WPRuby <info@wpruby.com>
 */
class WPRuby_Ticket {

  protected $ticket_id = 0;

  /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      number    $ticket_id       The ID of the ticket.
	 */
  public function __construct($ticket_id){
    $this->ticket_id = $ticket_id;
  }

  /**
	 * Closing the ticket.
	 *
	 * @since    1.0.0
	 */
  public function close_ticket(){
    wp_set_object_terms( intval($this->ticket_id), 'closed', WPRUBY_TICKET_STATUS, false );
  }
  /**
	 * Opening the ticket.
	 *
	 * @since    1.0.0
	 */
  public function open_ticket(){
    wp_set_object_terms( intval($this->ticket_id), 'in-progress', WPRUBY_TICKET_STATUS, false );
  }
  /**
	 * Get the replies of the current ticket.
	 *
	 * @since    1.0.0
	 */
  public function get_replies( ){

    $args = array(
        'post_type' 		 => WPRUBY_TICKET_REPLY,
        'post_parent'	   => intval($this->ticket_id),
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

  /**
   * Get tickets based on several arguments.
   *
   * @since    1.0.0
   * @param      array    $args      The parameters of the tickets query.
   */
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

  /**
   * Get user stats of tickets
   *
   * @since    1.0.0
   * @param      number    $user_id     The User ID.
   */
  public function get_tickets_stats(	$user_id	){
    $stats = array();
    $stats['total'] = 0;
    $stats['closed'] = 0;
    $stats['open'] = 0;


    $args = array();
    $args['user_id'] = intval($user_id);
    $args['status'] = 'open';
    $stats['open'] = count($this->get_tickets(	$args	));
    $args['status'] = 'closed';
    $stats['closed'] = count($this->get_tickets(	$args	));
    $stats['total'] = $stats['open'] + $stats['closed'];
    return $stats;
  }
  /**
   * Get user stats of tickets
   *
   * @since    1.0.0
   * @param      number    $user_id     The User ID.
   */
   public function get_status(){
     $status = array();
     $ticket_status = wp_get_object_terms($this->ticket_id, WPRUBY_TICKET_STATUS, array("fields" => "all"));
     if(isset($ticket_status[0])){
       $status['id'] = $ticket_status[0]->term_id;
       $status['name'] = $ticket_status[0]->name;
       $status['slug'] = $ticket_status[0]->slug;
     }else{
       return false;
     }
     return $status;
   }
}
