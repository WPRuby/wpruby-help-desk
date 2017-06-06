<?php

/**
 * The Email helper class of the plugin.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    RHD_Email
 * @subpackage RHD_Email/admin
 */

/**
 * The User helper class of the plugin.
 *
 *
 * @package    RHD_Email
 * @subpackage RHD_Email/admin
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Email {

  /**
  * Send notification when a ticket is opened
  *
  * @since    1.0.0
  */
  public static function ticket_opened( $ticket_id = '' ){
    $ticket         =  new RHD_Ticket( $ticket_id  );
    $assignee       =  $ticket->get_assignee();
    $ticket_author  =  $ticket->get_author();
    //info: 1. email to assignee
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . 'partials/emails/ticket_opened_assignee.php';
    $email_content   =  ob_get_clean();
    $email_title     =  sprintf(__('You have a new ticket( #%s ) assigned', 'ruby-help-desk'), $ticket_id);
    $headers         =  array('Content-Type: text/html; charset=UTF-8');
    wp_mail($assignee->get_email(),  $email_title, $email_content, $headers);

    //info: 1. email to author
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . 'partials/emails/ticket_opened_author.php';
    $email_content   =  ob_get_clean();
    $email_title     =  sprintf(__('We recieved your ticket #%s', 'ruby-help-desk'), $ticket_id);
    $headers         =  array('Content-Type: text/html; charset=UTF-8');
    wp_mail($ticket_author->get_email(),  $email_title, $email_content, $headers);


  }

  /**
  * Send notification when a ticket is re-assigned to another agent
  * @since    1.0.0
  */
  public static function ticket_reassigned( $ticket_id = '', $old_assignee = '' ){
    $ticket         =  new RHD_Ticket( $ticket_id  );
    $assignee       =  $ticket->get_assignee();
    $old_assignee  =   new RHD_User( intval($old_assignee)  );
    //info: 1. email to assignee
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . 'partials/emails/ticket_reassigned.php';
    $email_content   =  ob_get_clean();
    $email_title     =  sprintf(__('You have a new ticket( #%s ) assigned', 'ruby-help-desk'), $ticket_id);
    $headers         =  array('Content-Type: text/html; charset=UTF-8');
    wp_mail($assignee->get_email(),  $email_title, $email_content, $headers);

  }

    /**
    * Send notification when a ticket reply is added
    *
    * @since    1.0.0
    */
    public static function reply_added( $ticket_id = '', $reply_id = '' ){
      $ticket         =  new RHD_Ticket( $ticket_id  );
      $assignee       =  $ticket->get_assignee();
      $ticket_author  =  $ticket->get_author();
      $reply_author   =  new RHD_User( get_current_user_id() );
      if($reply_author->get_id()  == $assignee->get_id()){
        //send notification to ticket author
        ob_start();
        require_once plugin_dir_path( __FILE__ ) . 'partials/emails/reply_added_author.php';
        $email_content   =  ob_get_clean();
        $email_title     =  sprintf(__('New Reply on your ticket #%s', 'ruby-help-desk'), $ticket_id);
        $headers         =  array('Content-Type: text/html; charset=UTF-8');
        wp_mail($ticket_author->get_email(),  $email_title, $email_content, $headers);
      }elseif($reply_author->get_id()  == $ticket_author->get_id()){
        //send notification to ticket assignee
        ob_start();
        require_once plugin_dir_path( __FILE__ ) . 'partials/emails/reply_added_assignee.php';
        $email_content   =  ob_get_clean();
        $email_title     =  sprintf(__('New Reply on your assigned ticket #%s', 'ruby-help-desk'), $ticket_id);
        $headers         =  array('Content-Type: text/html; charset=UTF-8');
        wp_mail($assignee->get_email(),  $email_title, $email_content, $headers);
      }

    }

  /**
  * Send the ticket email transcript
  *
  * @since    1.0.0
  */
  public static function ticket_closed(  $ticket_id  ){
    $ticket = new RHD_Ticket(  $ticket_id  );
    $author = $ticket->get_author();
    $current_user = wp_get_current_user();
    //preparing the email body
    ob_start();
    require_once plugin_dir_path( __FILE__ ) . 'partials/emails/ticket_closed.php';
    $email_content   =  ob_get_clean();
    $email_title     =  sprintf(__('Your ticket #%s is closed', 'ruby-help-desk'), $ticket_id);
    $headers         =  array('Content-Type: text/html; charset=UTF-8');

    $attachments = array();
    $general_options = get_option('rhd_general');
    if(isset($general_options['enable_email_transcript']) && $general_options['enable_email_transcript'] == 'on'){
      $temp_text       =  plugin_dir_path( __FILE__ ) . 'partials/emails/temp/ticket_transcript_'. $ticket_id . '.txt';
      $temp_text_file  =  fopen($temp_text, 'w');
      fwrite($temp_text_file, self::get_transcript_text($ticket_id));
      fclose($f);
      $attachments = array($temp_text);
    }

    wp_mail($author->get_email(),  $email_title, $email_content, $headers, $attachments);

    if(isset($general_options['enable_email_transcript']) && $general_options['enable_email_transcript'] == 'on'){
      //info: delete the temp text attachment.
      unlink($temp_text);
    }

  }

  /**
  * get_transcript_text()
  * Get the text file content of the transcript email.
  * @return   string   ticket transcript
  * @since    1.0.0
  */
  public static function get_transcript_text(  $ticket_id  ){
    $ticket = new RHD_Ticket(  $ticket_id  );
    $ticket_title    =     get_post_field( 'post_title', $ticket_id );
    $ticket_content  =     strip_tags( get_post_field( 'post_content', $ticket_id ) );
    $ticket_date     =     get_post_field( 'post_date', $ticket_id );
    $replies = $ticket->get_replies();

    $final_transcript = '';
    $final_transcript .= $ticket_title .  PHP_EOL . PHP_EOL;
    $final_transcript .= '========='.  __('Ticket Content', 'ruby-help-desk')  .' ('.  $ticket_date  .')===========' .  PHP_EOL;
    $final_transcript .= $ticket_content .  PHP_EOL;
    $final_transcript .= PHP_EOL. '=========='.  __('Ticket Replies', 'ruby-help-desk') .'==========' .  PHP_EOL . PHP_EOL . PHP_EOL;
    $reply_number = 1;
    foreach ($replies as $key => $reply) {
      $final_transcript .= '========== #'. $reply_number .' ( '.  $reply->post_date .' by '. get_the_author_meta('nicename', $reply->post_author) .' )==========' .  PHP_EOL . PHP_EOL;
      $final_transcript .= $reply->post_content .  PHP_EOL;
      $reply_number++;
    }
    return $final_transcript;
  }
}
