<?php


/**
 * The Replies Templates Class
 *
 * @since 1.3.0
 * @package    RHD_Replies_Templates
 * @subpackage RHD_Replies_Templates/admin
 * @author     WPRuby <info@wpruby.com>
 */
class RHD_Replies_Templates{

	private $tags;

	/**
	 * RHD_Replies_Templates constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array($this, 'template_tags_metabox'), 10, 2 );
		$this->tags = [
			'customer_full_name'    => __('Customer Full Name'),
			'customer_first_name'   => __('Customer First Name'),
			'customer_last_name'    => __('Customer Last Name'),
			'agent_full_name'       => __('Agent Full Name'),
			'agent_first_name'      => __('Agent First Name'),
			'agent_last_name'       => __('Agent Last Name'),
			'date'                  => __('Current Date'),
			'ticket_id'             => __('Ticket ID'),
			'ticket_title'          => __('Ticket Title'),
			'site_name'             => __('Site Title'),
		];

	}

	/**
	 * @param $post_type
	 * @param $post
	 */
	public function template_tags_metabox( $post_type, $post ) {
		add_meta_box(
			'template_tags_metabox',
			__( 'Template Tags',  'ruby-help-desk'),
			array($this, 'render_template_tags_metabox'),
			RHD_REPLIES_TEMPLATE,
			'normal',
			'default'
		);
	}

	/**
	 * @param $post_type
	 * @param $post
	 */
	public function render_template_tags_metabox( $post_type, $post ) {
		require_once plugin_dir_path( __FILE__ ) . 'partials/replies_templates/metabox_tags.php';
	}

	/**
	 * @param RHD_Ticket $ticket
	 *
	 * @return array
	 */
	public static function getTemplates($ticket){
		$final_templates = [];
		$templates = get_posts(
			[
				'post_type' =>  RHD_REPLIES_TEMPLATE
			]
		);
		foreach ($templates as $template){
			$final_templates[] = [
				'title' => $template->post_title,
				'content' => htmlentities( wpautop( str_replace( '\'', '&apos;', self::process_tags( $template->post_content, $ticket) ) ) )
			];
		}
		return $final_templates;
	}

	/**
	 * @param string $content
	 * @param RHD_Ticket $ticket
	 *
	 * @return mixed
	 */
	private static function process_tags($content, $ticket){
		$tags = self::get_tags_values($ticket);

		foreach ( $tags as $tag ) {
			$id       = $tag['tag'];
			$value    = isset( $tag['value'] ) ? $tag['value'] : '';
			$content = str_replace( $id, $value, $content );

		}
		return $content;
	}

	/**
	 * @param RHD_Ticket $ticket
	 *
	 * @return array
	 */
	private static function get_tags_values($ticket) {
		/** @var RHD_Ticket $ticket */
		/** @var RHD_User $assignee */
		$author = $ticket->get_author();
		$assignee = $ticket->get_assignee();
		$tags = array();
		$tags[] =['tag' => '{agent_full_name}', 'value' => $author->get_full_name()];
		$tags[] =['tag' => '{agent_first_name}', 'value' => $author->get_first_name()];
		$tags[] =['tag' => '{agent_last_name}', 'value' => $author->get_last_name()];
		$tags[] =['tag' => '{customer_full_name}', 'value' => $assignee->get_full_name()];
		$tags[] =['tag' => '{customer_first_name}', 'value' => $assignee->get_first_name()];
		$tags[] =['tag' => '{customer_last_name}', 'value' => $assignee->get_last_name()];
		$tags[] =['tag' => '{date}', 'value' => date('d-m-Y')];
		$tags[] =['tag' => '{ticket_id}', 'value' => $ticket->get_id()];
		$tags[] =['tag' => '{ticket_title}', 'value' => $ticket->get_title()];
		$tags[] =['tag' => '{site_name}', 'value' => get_bloginfo('name')];

		return $tags;

	}


}

new RHD_Replies_Templates();