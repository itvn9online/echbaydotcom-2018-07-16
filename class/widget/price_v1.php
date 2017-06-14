<?php



/*
* Widget lọc sản phẩm theo khoảng giá
*/
class ___echbay_widget_loc_san_pham_theo_gia extends WP_Widget {
	function __construct() {
		parent::__construct ( 'echbay_price', 'EchBay price', array (
			'description' => 'Chức năng tạo liên kết lọc sản phẩm theo khoảng giá' 
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay price',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '"/></p>';
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
		
		//
		echo '<ul class="echbay-product-price-between">';
		
		// lấy khoảng giá
		$sql = _eb_q("SELECT *
		FROM
			`" . wp_postmeta . "`
		WHERE
			meta_key = '_eb_category_status'
			AND meta_value = 8");
//		print_r($sql);
		foreach ( $sql as $v ) {
//			print_r($v);
			
			$term_id = $v->post_id;
			$taxonomy_name = 'post_options';
			$termchildren = get_term_children( $term_id, $taxonomy_name );
//			print_r($termchildren);
			
			foreach ( $termchildren as $child ) {
				$term = get_term_by( 'id', $child, $taxonomy_name );
//				print_r($term);
				
				echo '<li><a data-href="' . $term->slug . '" href="#">' . $term->name . '</a></li>';
			}
		}
		
		echo '</ul>';
		
		//
		echo $after_widget;
	}
}




