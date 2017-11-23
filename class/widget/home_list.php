<?php


//$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_list_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_list', 'EchBay home list', array (
				'description' => 'Danh sách sản phẩm cho toàn bộ phân nhóm ở trang chủ' 
		) );
	}
	
	function form($instance) {
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
//		print_r($instance); exit();
		return $instance;
	}
	
	function widget($args, $instance) {
		global $__cf_row;
		
		include EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home3.php';
//		$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/echbaytwo-home3.css' ] = 1;
		$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/echbaytwo-home3.css' ] = 1;
	}
}




