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
			$replies[$key]->attachments = $this->get_attachments($reply->ID);
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
   * Get ticket status
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
       $status['color'] = get_term_meta( $ticket_status[0]->term_id, 'ticket_status_color', true);
     }else{
       return false;
     }
     return $status;
   }

   /**
    * Get ticket product
    *
    * @since    1.0.0
    * @param      number    $user_id     The User ID.
    */
    public function get_product(){
      $product = array();
      $ticket_product = wp_get_object_terms($this->ticket_id, WPRUBY_TICKET_PRODUCT, array("fields" => "all"));
      if(isset($ticket_product[0])){
        $product['id'] = $ticket_product[0]->term_id;
        $product['name'] = $ticket_product[0]->name;
        $product['slug'] = $ticket_product[0]->slug;
      }else{
        return false;
      }
      return $product;
    }

     /**
      * Get open tickets.
      *
      * @since    1.0.0
      * @return      array    $tickets      The array of tickets.
      */
     public static function get_open_tickets(){

       $args = array(
           'post_type' => WPRUBY_TICKET,
           'posts_per_page' => -1,
           'tax_query' => array(
               array(
                   'taxonomy' => WPRUBY_TICKET_STATUS,
                   'field'    => 'slug',
                   'terms'    => 'closed',
                   'operator' => 'NOT IN',
               ),
           ),
       );
       $tickets = get_posts( $args );
       return $tickets;
     }

     /**
      * Add new Ticket.
      *
      * @since    1.0.0
      * @param      array    $tickets      The array of ticket data.
      * @return      number    $ticket_id      The ID of the new ticket.
      */
     public static function add(  $ticket  ){
       $new_status = get_option('wpruby_ticket_status_new');
       $new_status = ($new_status === FALSE)?-1:$new_status;

       $postattr = array(
                    'post_title'    =>  $ticket['subject'],
                    'post_content'  =>  $ticket['content'],
                    'post_type'     =>  WPRUBY_TICKET,
                    'tax_input'     =>  array(
                                              WPRUBY_TICKET_STATUS => intval($new_status),
                                              WPRUBY_TICKET_PRODUCT => $ticket['product'],
                    ),
                    'post_status'   =>  'publish',

       );
       $ticket_id = wp_insert_post($postattr);
       if(isset($ticket['attachment'])){
         self::add_attachment($ticket_id, $ticket['attachment']);
       }

       return $ticket_id;
     }

     public static function add_reply( $ticket_id = '' ){
       //info: if there is an attachment
       if(isset($_FILES['reply_attachment'])){
         if ( ! function_exists( 'wp_handle_upload' ) ) {
             require_once( ABSPATH . 'wp-admin/includes/file.php' );
         }
         $uploadedfile = $_FILES['reply_attachment'];
         $upload_overrides = array( 'test_form' => false );
         $reply_uploaded_file = wp_handle_upload( $uploadedfile, $upload_overrides );
         $reply_file = $reply_uploaded_file['file'];
       }
       $ticket_reply_args = array(
         'post_title'		=>	'Reply to ticket #' . $ticket_id,
         'post_content'	=>	$_POST['ticket_reply'],
         'post_status'		=>	'publish',
         'post_type'			=>	WPRUBY_TICKET_REPLY,
         'post_parent'		=>	intval($ticket_id),
       );
       $reply_id = wp_insert_post( $ticket_reply_args );

       if(isset($reply_file) && $reply_id){
         self::add_attachment($reply_id, $reply_file);
       }

       return $reply_id;
     }
     /**
     * Get the tickets of the current user.
     *
     * @since    1.0.0
     */
     public static function get_my_tickets( ){

       $args = array(
           'post_type' 		      => WPRUBY_TICKET,
           'orderby'            => 'date',
           'order'              => 'DESC',
           'posts_per_page'     => -1,
           'author'             => get_current_user_id(),
           'post_status'      => 'publish',
       );
       $tickets = get_posts( $args );
       foreach ($tickets as $key => $ticket):
         $user = new WPRuby_User($ticket->post_author);
         $tickets[$key]->user = $user;
         $tickets[$key]->post_title = ($ticket->post_title == '')?__('(No Subject)', 'wpruby-help-desk'):$ticket->post_title;
         $tick = new WPRuby_Ticket($ticket->ID);
         $tickets[$key]->product = $tick->get_product();
         $tickets[$key]->status = $tick->get_status();
         $tickets[$key]->replies_count = count($tick->get_replies());

       endforeach;
       return $tickets;
     }

     /**
     * Handle Ticket Attachments
     *
     * @since    1.0.0
     */
     public static function add_attachment( $object_id, $filename ){

       	// Check the type of file. We'll use this as the 'post_mime_type'.
       	$filetype = wp_check_filetype( basename( $filename ), null );
       	// Get the path to the upload directory.
       	$wp_upload_dir = wp_upload_dir();

       	// Prepare an array of post data for the attachment.
       	$attachment = array(
       		'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
       		'post_mime_type' => $filetype['type'],
       		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
       		'post_content'   => '',
       		'post_status'    => 'inherit'
       	);

       	// Insert the attachment.
       	$attach_id = wp_insert_attachment( $attachment, $filename, $object_id );

        return $attach_id;

     }

     /**
     * Get ticket attachments
     *
     * @since    1.0.0
     */
     public function get_attachments($object_id = null){
         $object_id = ($object_id == null)?$this->ticket_id:$object_id;
         $args = array(
   				'post_type' => 'attachment',
   				'numberposts' => null,
   				'post_status' => null,
   				'post_parent' => $object_id,
   			);
   			$attachments = get_posts($args);
        return $attachments;
     }
}
