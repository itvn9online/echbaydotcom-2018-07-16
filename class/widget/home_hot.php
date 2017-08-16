<?php




/*
* Widget lấy sản phẩm MỚI/ HOT (thường dùng ở các trang chủ)
*/

class ___echbay_widget_home_hot_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'eb_random_home_hot', 'EchBay home HOT', array (
				'description' => 'Tạo danh sách sản phẩm MỚI/ HOT cho trang chủ' 
		) );
	}
	
	function form($instance) {
		
		$default = WGR_widget_arr_default_home_hot( array (
			'title' => 'EchBay home HOT',
			'html_template' => 'home_hot.html'
		) );
		$instance = wp_parse_args ( ( array ) $instance, $default );
		
		
		//
		$arr_field_name = array();
		foreach ( $default as $k => $v ) {
			$arr_field_name[ $k ] = $this->get_field_name ( $k );
		}
		
		_eb_product_form_for_widget( $instance, $arr_field_name );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		
		extract ( $args );
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		WGR_widget_home_hot( $instance );
		
		//
		echo $after_widget;
	}
}




