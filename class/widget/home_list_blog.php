<?php


//$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_list_blog extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_blog', 'EchBay home blog list', array (
				'description' => 'Danh sách Bài viết theo toàn bộ danh mục ở trang chủ' 
		) );
	}
	
	function form($instance) {
		$default = WGR_default_for_home_list_and_blog ();
		
		$this_value = array();
		foreach ( $default as $k => $v ) {
			$this_value[$k] = $this->get_field_name ( $k );
		}
		
		WGR_phom_for_home_list_and_blog( $instance, $default, $this_value );
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
//		print_r($instance); exit();
		return $instance;
	}
	
	function widget($args, $instance) {
	}
}




