<?php

class mkDynamicWidget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'mklasens_dynamic_widget',
			'description' => 'Add specific widget content per page/post.',
		);

		parent::__construct( 'mklasens_dynamic_widget', 'MK Dynamic Widget', $widget_ops );
	}

	public function widget( $args, $instance ) {
    global $post;

    extract($args);

    $currentContent = get_post_meta($post->ID, 'mklasens-dynamic-text-content', true);

    if (isset($currentContent) && !empty($currentContent)) {
      echo $before_widget;
      	echo do_shortcode($currentContent);
      echo $after_widget;
    }
	}

	public function form( $instance ) {
		echo '<p>This widget can be configured on page/post level.</p>';
	}

	public function update( $new_instance, $old_instance ) {
		// No need to update
	}
}
