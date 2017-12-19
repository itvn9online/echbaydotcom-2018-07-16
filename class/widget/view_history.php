<?php




/*
* Widget lấy sản phẩm cùng mức giá (thường dùng trong trang chi tiết sản phẩm)
*/

class ___echbay_widget_product_view_history extends WP_Widget {
	function __construct() {
		parent::__construct ( 'eb_product_view_history', 'EchBay View History', array (
				'description' => 'Lấy các sản phẩm ĐÃ XEM hoặc sản phẩm ĐÃ THÍCH trong trang chi tiết sản phẩm! Module này có thể hiển thị ở bất kỳ đâu trên website.' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay view history',
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
		
		//
		$cookie_name = isset( $instance ['cookie_name'] ) ? $instance ['cookie_name'] : '';
		
		//
//		$str_history = _eb_getCucki('wgr_product_id_view_history');
		$str_history = _eb_getCucki($cookie_name);
		
		//
		if ( $str_history == '' ) {
			echo '<!-- Widget view history has been active, but IDs not found! -->';
			return false;
		}
//		echo $str_history;
		
		// chuyển đổi sang dấu khác để còn tạo mảng giá trị
		$str_history = str_replace('][', ',', $str_history);
		$str_history = str_replace(']', '', $str_history);
		$str_history = str_replace('[', '', $str_history);
//		echo $str_history;
		
		// -> tạo mảng
		$str_history = explode(',', $str_history);
//		print_r($str_history);
//		exit();
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		if ( $title == '' ) {
			if ( $cookie_name == 'wgr_product_id_user_favorite' ) {
				$title = 'Sản phẩm Yêu thích';
			}
			else {
				$title = 'Sản phẩm Đã xem';
			}
		}
		
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 5;
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
//		echo $num_line;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
		
		// limit số lượng bài viết -> ưu tiên bài mới xem nhất trước
		$arr_history = array();
		foreach ( $str_history as $k => $v ) {
			if ( $k >= $post_number ) {
				break;
			}
			
			$arr_history[] = $v;
		}
//		print_r( $arr_history );
		
		//
		$str_view_history = _eb_load_post( $post_number, array(
			'post__in' => $arr_history
		) );
		if ( $str_view_history != '' ) {
			echo '<div class="' . trim( 'eb-view-history ' . $custom_style ) . '">';
			
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




