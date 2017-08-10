<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_menu_close_tag extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_menu_close_tag', 'zEchBay Close Tag', array (
				'description' => 'Đóng một thẻ để tạo khối HTML' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'EchBay Close Tag',
			'tag' => 'div'
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title, 'Ghi chú:' );
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'tag' ), $tag, 'div', '', '' );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		
		$tag = isset( $instance ['tag'] ) ? $instance ['tag'] : '';
		$tag = str_replace( '<', '', $tag );
		$tag = str_replace( '>', '', $tag );
		if ( $tag == '' ) $tag = 'div';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' (' . $title . ') -->';
		
		//
		echo '</' . $tag . '>';
		
		//
//		echo $after_widget;
	}
}




