<?php


//$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_list_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_list', 'EchBay home list', array (
				'description' => 'Danh sách sản phẩm cho toàn bộ phân nhóm ở trang chủ' 
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
		global $__cf_row;
		
		//
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$custom_style .= WGR_add_option_class_for_post_widget( $instance );
		
		$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
		if ( $post_cloumn != '' ) {
			$custom_style .= ' blogs_node_' . $post_cloumn;
		}
		
		//
		$widget_select_categories = array();
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : '';
		if ( $cat_ids != '' ) {
			$cat_ids = explode( ',', $cat_ids );
			
			foreach ( $cat_ids as $v ) {
				$t = get_term( $v );
				if ( ! isset($t->errors) ) {
//					print_r( $t );
					$widget_select_categories[] = $t;
				}
			}
		}
//		print_r( $widget_select_categories );
//		$widget_select_categories = array();
		
		//
		$arr_for_add_css = array();
		
		echo '<div class="' . trim( 'widget-echbay-home-list ' . $custom_style ) . '">';
		
		// Số bài viết trên mỗi nhóm
		$luu_post_number = 0;
		if ( $post_number > 0 ) {
			// lưu giá trị cũ lại để tí còn reset
			$luu_post_number = $__cf_row['cf_num_home_list'];
			
			// gán giá trị mới
			$__cf_row['cf_num_home_list'] = $post_number;
		}
		
		// Số bài viết trên mỗi dòng
		$_GET['home_list_num_line'] = $num_line;
		
		
		//
		include EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home3.php';
		
		
		// xong thì trả lại giá trị của config
		if ( $luu_post_number > 0 ) {
			$__cf_row['cf_num_home_list'] = $luu_post_number;
		}
		
		//
		unset( $_GET['home_list_num_line'] );
		
		echo '</div>';
		
		//
//		$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/echbaytwo-home3.css' ] = 1;
		$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/echbaytwo-home3.css' ] = 1;
		
		_eb_add_compiler_css( $arr_for_add_css );
		
	}
}




