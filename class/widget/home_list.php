<?php


//$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_list_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_list', 'EchBay home list', array (
				'description' => 'Danh sách sản phẩm cho toàn bộ phân nhóm ở trang chủ' 
		) );
	}
	
	function form($instance) {
		
		//
		$default = array (
			'num_line' => '',
			'post_number' => 0,
			'cat_ids' => '',
			'post_cloumn' => '',
			'hide_title' => '',
			'hide_description' => '',
			'hide_info' => '',
			'custom_style' => ''
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		
		echo '<p>Mặc định sẽ hiển thị toàn bộ danh sách sản phẩm theo nhóm cấp 1. Nếu muốn chủ động hiển thị nhóm theo ý muốn, hãy chọn ở dưới:</p>';

		$categories = get_categories( array(
			'hide_empty' => 0,
			'parent' => 0
		) );
//		print_r( $categories );
		
		$id_for = '_' . md5( rand( 0, 10000 ) );
		
		echo '<div id="' . $id_for . '" class="div-widget-home_list">';
		
		
		echo '<p class="d-none"><input type="text" class="widefat" data-name="' . $id_for . '" name="' . $this->get_field_name ( 'cat_ids' ) . '" value="' . $cat_ids . '" /></p>';
		
		
		//
		echo '<ul class="ul-widget-home_list">';
		foreach ( $categories as $v ) {
			echo '<li style="order:' . (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 ) . '">';
			
			echo '<label for="' . $id_for . $v->term_id . '" class="category-for-home_list"><input type="checkbox" id="' . $id_for . $v->term_id . '" data-id="' . $v->term_id . '" data-class="' . $id_for . '" class="click-get-category-id-home_list" /> <strong>' . $v->name . ' (' . $v->count . ')</strong></label>';
			
			// lấy nhóm con (nếu có)
			$sub_cat = get_categories( array(
				'hide_empty' => 0,
				'taxonomy' => $v->taxonomy,
				'parent' => $v->term_id
			) );
//			print_r( $sub_cat );
			foreach ( $sub_cat as $v2 ) {
				echo '<label for="' . $id_for . $v2->term_id . '" class="category-for-home_list"><input type="checkbox" id="' . $id_for . $v2->term_id . '" data-id="' . $v2->term_id . '" data-class="' . $id_for . '" class="click-get-category-id-home_list" /> <span>' . $v2->name . ' (' . $v2->count . ')</span></label>';
				
				//
				$sub3_cat = get_categories( array(
					'hide_empty' => 0,
					'taxonomy' => $v2->taxonomy,
					'parent' => $v2->term_id
				) );
//				print_r( $sub3_cat );
				foreach ( $sub3_cat as $v3 ) {
					echo '<label for="' . $id_for . $v3->term_id . '" class="category-for-home_list"><input type="checkbox" id="' . $id_for . $v3->term_id . '" data-id="' . $v3->term_id . '" data-class="' . $id_for . '" class="click-get-category-id-home_list" /> <em>' . $v3->name . ' (' . $v3->count . ')</em></label>';
				}
			}
			
			echo '</li>';
		}
		echo '</ul>';
		
		echo '</div>';
		
		echo '<script>WGR_category_for_home_list("' . $id_for . '", 1);</script>';
		
		
		//
		_eb_widget_echo_number_of_posts_to_show( $this->get_field_name('post_number'), $post_number );
		
		
		//
		_eb_widget_number_of_posts_inline( $this->get_field_name('num_line'), $num_line );
		
		
		//
		_eb_widget_style_for_post_cloumn( $this->get_field_name( 'post_cloumn' ), $post_cloumn );
		
		
		//
		$input_name = $this->get_field_name( 'hide_title' );
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $hide_title, 'Ẩn tiêu đề của bài viết.' );
		
		//
		$input_name = $this->get_field_name( 'hide_description' );
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $hide_description, 'Ẩn tóm tắt của bài viết.' );
		
		//
		$input_name = $this->get_field_name( 'hide_info' );
		
		_eb_widget_echo_widget_input_checkbox( $input_name, $hide_info, 'Ẩn ngày tháng, danh mục của bài viết.' );
		
		
		//
		echo '<p><strong>Tùy chỉnh CSS</strong>: <input type="text" class="widefat" name="' . $this->get_field_name('custom_style') . '" value="' . $custom_style . '" /> * Tạo class CSS để custom riêng.</p>';
		
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




