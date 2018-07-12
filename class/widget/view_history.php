<?php




/*
* Widget lấy sản phẩm cùng mức giá (thường dùng trong trang chi tiết sản phẩm)
*/

class ___echbay_widget_product_view_history extends WP_Widget {
	function __construct() {
		parent::__construct ( 'eb_product_view_history', 'EchBay Other Products', array (
				'description' => 'Lấy các sản phẩm ĐÃ XEM hoặc sản phẩm ĐÃ THÍCH trong trang chi tiết sản phẩm! Module này có thể hiển thị ở bất kỳ đâu trên website. Hoặc sản phẩm CÙNG NHÓM với sản phẩm đang xem (Mobule này chỉ hoạt động trong trang chi tiết sản phẩm)' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay Other Products',
			// mặc định là lịch sử xem
			'cookie_name' => 'wgr_product_id_view_history',
			'post_number' => 10,
			'custom_style' => '',
			'num_line' => 'thread-list20',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		
		//
		echo '<p>Phân loại: <select name="' . $this->get_field_name ( 'cookie_name' ) . '" class="widefat">';
		
		echo '<option value="wgr_product_id_view_history"' . _eb_selected( 'wgr_product_id_view_history', $cookie_name ) . '>Sản phẩm Đã xem</option>';
		
		echo '<option value="wgr_product_id_user_favorite"' . _eb_selected( 'wgr_product_id_user_favorite', $cookie_name ) . '>Sản phẩm Yêu thích</option>';
		
		echo '<option value="wgr_product_same_category"' . _eb_selected( 'wgr_product_same_category', $cookie_name ) . '>Sản phẩm Cùng nhóm</option>';
		
		echo '</select>';
		
		
		_eb_widget_echo_number_of_posts_to_show( $this->get_field_name ( 'post_number' ), $post_number );
		
		
		_eb_widget_number_of_posts_inline( $this->get_field_name('num_line'), $num_line );
		
		
		echo '<p>Custom CSS: <input type="text" class="widefat" name="' . $this->get_field_name('custom_style') . '" value="' . $custom_style . '"/> * Tạo class CSS để custom riêng.</p>';
		
		
		echo '<p class="orgcolor">* Hệ thống hỗ trợ tối đa 25 sản phẩm trong bộ nhớ đệm, khi bộ nhớ đạt đến con số này, sản phẩm đã xem trước nhất sẽ bị loại bỏ.</p>';
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		
		global $pid;
		
		//
		extract ( $args );
		
		
		//
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 5;
		$cookie_name = isset( $instance ['cookie_name'] ) ? $instance ['cookie_name'] : 'wgr_product_id_view_history';
		
		
		//
		if ( $cookie_name == 'wgr_product_same_category' ) {
			
			if ( $pid == 0 ) {
				echo '<!-- Widget Same category has been active, but run only post details -->';
				return false;
			}
			
			//
//			$post_categories = get_the_terms( $pid, EB_BLOG_POST_LINK );
			$post_categories = wp_get_post_categories( $pid );
			
			// Thử kiểm tra xem trong này có nhóm nào được set là nhóm chính không
			$post_primary_categories = array();
			foreach ( $post_categories as $v ) {
				if ( _eb_get_cat_object( $v, '_eb_category_primary', 0 ) > 0 ) {
					$post_primary_categories[] = $v;
				}
			}
			
			// nếu không tìm được -> lấy tất
			if ( empty( $post_primary_categories ) ) {
				$post_primary_categories = $post_categories;
			}
			
			//
			$str_view_history = _eb_load_post( $post_number, array(
				'post__not_in' => array( $pid ),
				'category__in' => $post_primary_categories
			) );
			
			//
			$str_css_class = 'eb-same-category';
			
		}
		else {
			
			//
//			$str_history = _eb_getCucki('wgr_product_id_view_history');
			$str_history = _eb_getCucki($cookie_name);
			
			//
			if ( $str_history == '' ) {
				echo '<!-- Widget view history has been active, but IDs not found! Check cookie: ' . $cookie_name . ' -->';
				return false;
			}
//			echo $str_history;
			
			// chuyển đổi sang dấu khác để còn tạo mảng giá trị
			$str_history = str_replace('][', ',', $str_history);
			$str_history = str_replace(']', '', $str_history);
			$str_history = str_replace('[', '', $str_history);
//			echo $str_history;
			
			// -> tạo mảng
			$str_history = explode(',', $str_history);
//			print_r($str_history);
//			exit();
			
			
			// limit số lượng bài viết -> ưu tiên bài mới xem nhất trước
			$arr_history = array();
			foreach ( $str_history as $k => $v ) {
				if ( $v != $pid ) {
					if ( $k >= $post_number ) {
						break;
					}
					
					$arr_history[] = $v;
				}
			}
//			print_r( $arr_history );
			
			//
			$str_view_history = _eb_load_post(
				$post_number,
				array(
//					'post__not_in' => array( $pid ),
					'post__in' => $arr_history
				),
				__eb_thread_template,
				// lấy hết, bỏ qua bộ lọc post__not_in
				1
			);
			
			//
			$str_css_class = 'eb-view-history';
			
		}
		
		
		
		//
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		if ( $title == '' ) {
			if ( $cookie_name == 'wgr_product_id_user_favorite' ) {
				$title = 'Sản phẩm Yêu thích';
			}
			else if ( $cookie_name == 'wgr_product_same_category' ) {
				$title = EBE_get_lang('post_other');
			}
			else {
				$title = 'Sản phẩm Đã xem';
			}
		}
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
//		echo $num_line;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
		
		
		//
		if ( $str_view_history != '' ) {
			echo '<div class="' . trim( $str_css_class . ' hide-if-quickview ' . $custom_style ) . '">';
			
			echo WGR_show_home_hot( array(
				'tmp.num_post_line' => $num_line,
				'tmp.home_hot_title' => $title,
				'tmp.home_hot' => $str_view_history
			) );
			
			echo '</div>';
		}
		else {
			echo '<!-- view_history == NULL -->';
		}
		
		//
		echo $after_widget;
	}
}




