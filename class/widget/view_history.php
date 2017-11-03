<?php




/*
* Widget lấy sản phẩm cùng mức giá (thường dùng trong trang chi tiết sản phẩm)
*/

class ___echbay_widget_product_view_history extends WP_Widget {
	function __construct() {
		parent::__construct ( 'eb_product_view_history', 'EchBay View History', array (
				'description' => 'Lấy các sản phẩm đã xem trong trang chi tiết sản phẩm! Module này có thể hiển thị ở bất kỳ đâu trên website.' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay view history',
			'post_number' => 5,
			'custom_style' => '',
			'num_line' => '',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		
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
		$str_history = _eb_getCucki('wgr_product_id_view_history');
		
		//
		if ( $str_history == '' ) {
			echo '<p>Widget view history has been active, but IDs not found!</p>';
			return false;
		}
		echo $str_history; exit();
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 5;
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
//		echo $num_line;
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
		
		//
		$str_view_history = _eb_load_post( $post_number, array(
			'post__in' => $str_history
		) );
		if ( $str_view_history != '' ) {
			echo '<div class="' . $custom_style . '">';
			
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




