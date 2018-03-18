<?php



/*
* Widget tạo list video youtube
*/
class ___echbay_widget_youtube_video extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_youtube', 'EchBay Youtube', array (
				'description' => 'Tạo danh sách phát Video Youtube' 
		) );
	}
	
	function form($instance) {
		$default = array (
				'title' => 'EchBay Youtube',
				'url_video' => '',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		/*
		$title = esc_attr ( $instance ['title'] );
		$url_video = esc_attr ( $instance ['url_video'] );
		*/
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		echo '<p>URL youtube: <textarea class="widefat" name="' . $this->get_field_name ( 'url_video' ) . '" placeholder="//www.youtube.com/embed/FoxruhmPLs4">' . $url_video . '</textarea></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$url_video = isset( $instance ['url_video'] ) ? $instance ['url_video'] : '';
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		echo '<div class="echbay-widget-youtube-padding">';
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-youtube-title', $before_title );
		
		//
		echo '<div class="img-max-width d-none">' . $url_video . '</div>';
		
		//
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




