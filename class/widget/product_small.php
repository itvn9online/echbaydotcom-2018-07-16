<?php




/*
* Widget sản phẩm ngẫu nhiên
*/
class ___echbay_widget_random_product extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_post', 'EchBay product small', array (
				'description' => 'Tạo danh sách sản phẩm dưới dạng thiết kế thu gọn' 
		) );
	}
	
	function form($instance) {
		
		$default = array (
			'title' => 'EchBay product small',
			'description' => '',
			'sortby' => 'menu_order',
			'num_line' => '',
			'html_template' => 'product_small.html',
			'html_node' => '',
			'max_width' => '',
			'post_number' => 5,
			'cat_ids' => 0,
			'cat_type' => 'category',
			'post_cloumn' => '',
			'post_type' => 'post',
			'ads_eb_status' => 0,
			'post_eb_status' => 0,
			'custom_style' => ''
		);
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
//		global $func;
//		global $__cf_row;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : 'category';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		$html_template = isset( $instance ['html_template'] ) ? $instance ['html_template'] : '';
		$html_template = str_replace( '.html', '', $html_template );
		$max_width = isset( $instance ['max_width'] ) ? $instance ['max_width'] : '';
		$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
		$post_type = isset( $instance ['post_type'] ) ? $instance ['post_type'] : '';
		
		$html_node = isset( $instance ['html_node'] ) ? $instance ['html_node'] : '';
		$html_node = str_replace( '.html', '', $html_node );
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-product-title', $before_title );
		
		//
//		echo '';
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		//
		$args = array(
			'orderby' => $sortby,
			'order' => $___order,
		);
		
		if ( $cat_ids > 0 ) {
			$args['cat'] = $cat_ids;
			
			if ( $title == '' ) {
				$categories = get_term_by('id', $cat_ids, 'category');
				$title = $categories->name;
			}
		}
		// tự động lấy theo nhóm hiện tại
		/*
		else {
			$category = get_queried_object();
			print_r( $category );
		}
		*/
		
		$content = _eb_load_post( $post_number, $args,
//		file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/thread_node.html', 1 ) );
		EBE_get_page_template( 'thread_node_small' ) );
		
//		echo '</ul>';
		
		
		//
		$html_template = _eb_widget_create_html_template( $html_template, 'product_small' );
		
		
		
		//
		echo '<div class="' . $custom_style . '">';
		echo EBE_html_template( EBE_get_page_template( $html_template ), array(
			'tmp.widget_title' => _eb_get_echo_widget_title( $title, 'echbay-widget-product-title', $before_title ),
			'tmp.content' => $content,
			'tmp.num_line' => $num_line,
			'tmp.max_width' => $max_width,
		) );
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




