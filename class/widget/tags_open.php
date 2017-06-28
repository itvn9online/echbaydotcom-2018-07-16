<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_menu_open_tag extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_menu_open_tag', 'zEchBay Open Tag', array (
				'description' => 'Mở một thẻ để tạo khối HTML' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'EchBay Open Tag',
			'tag' => 'div',
			'width' => '',
			'custom_style' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title, 'Ghi chú:' );
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'tag' ), $tag, 'div' );
		
		
		//
		_eb_menu_width_form_for_widget( $this->get_field_name ( 'width' ), $width );
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'custom_style' ), $custom_style, 'Custom CSS:' );
		
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
		$width = isset( $instance ['width'] ) ? $instance ['width'] : '';
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' (' . $title . ') -->';
		
		//
		echo '<' . $tag . ' class="lf ' . $width . ' ' . $custom_style . '">';
		
		//
//		echo $after_widget;
	}
}




