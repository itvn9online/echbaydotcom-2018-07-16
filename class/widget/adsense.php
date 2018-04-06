<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_set_adsense_code extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_set_adsense_code', 'zEchBay GAdsense', array (
				'description' => 'Nhúng mã Google Adsense vào website' 
		) );
	}
	
	function form($instance) {
		global $arr_to_add_menu;
		
		$default = array (
			'title' => 'Note'
//			'code' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name('title'), $title );
		
		//
//		echo '<p><strong>Mã nhúng</strong>: <textarea class="widefat" name="' . $this->get_field_name('code') . '">' . $code . '</textarea></p>';
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		global $__cf_row;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		
//		$code = isset( $instance ['code'] ) ? $instance ['code'] : '';
		$code = $__cf_row['cf_js_gadsense'];
		
		//
		if ( $code == '' ) {
			echo '<!-- ' . $this->name . ' (CODE is NULL) -->';
			return false;
		}
		
		
		//
//		_eb_echo_widget_name( $this->name, $before_widget );
		echo '<!-- ' . $this->name . ' (' . $title . ') -->';
		
		//
		echo $code;
	}
}




