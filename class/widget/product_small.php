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
		
		$default = WGR_widget_arr_default_home_hot( array (
			'title' => 'EchBay product small',
			'html_template' => 'product_small.html',
			'html_node' => 'thread_node_small.html'
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
//		global $func;
//		global $__cf_row;
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$dynamic_tag = isset( $instance ['dynamic_tag'] ) ? $instance ['dynamic_tag'] : '';
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : 'category';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		
		$html_template = isset( $instance ['html_template'] ) ? $instance ['html_template'] : '';
		
		$max_width = isset( $instance ['max_width'] ) ? $instance ['max_width'] : '';
		$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
		$post_type = isset( $instance ['post_type'] ) ? $instance ['post_type'] : '';
		
		$html_node = isset( $instance ['html_node'] ) ? $instance ['html_node'] : '';
		$html_node = _eb_widget_create_html_template( $html_node, 'thread_node_small' );
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$custom_size = isset( $instance ['custom_size'] ) ? $instance ['custom_size'] : '';
		
		// ẩn các thuộc tính theo option
		$custom_style .= WGR_add_option_class_for_post_widget( $instance );
		
		
		
		
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
			
			// lấy lại taxonomy dựa theo ID cho nó chuẩn xác
			$cat_type = WGR_get_taxonomy_name( $cat_ids );
			if ( $cat_type == '' ) {
				echo '<!-- taxonomy for #' . $cat_ids . ' not found! -->';
			}
			//
			else {
				// mặc định thì lấy theo category
				if ( $cat_type == 'category' ) {
					$args['cat'] = $cat_ids;
				}
				// với các taxonomy khác thì lấy theo cách khác
				else {
					$args['tax_query'] = array(
						array(
							'taxonomy' => $cat_type,
							'field' => 'term_id',
							'terms' => array( $cat_ids ),
							'operator' => 'IN'
						)
					);
				}
				
				if ( $title == '' ) {
					$categories = get_term_by('id', $cat_ids, $cat_type);
					$title = $categories->name;
				}
			}
			
		}
		// tự động lấy theo nhóm hiện tại
		/*
		else {
			$category = get_queried_object();
			print_r( $category );
		}
		*/
		
		//
//		$html_node = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/thread_node.html', 1 );
//		$html_node = EBE_get_page_template( 'thread_node_small' );
		$html_node = EBE_get_page_template( $html_node );
		if ( $custom_size != '' ) {
			$html_node = str_replace( '{tmp.cf_product_size}', $custom_size, $html_node );
			$html_node = str_replace( '{tmp.cf_blog_size}', $custom_size, $html_node );
		}
		
		$content = _eb_load_post( $post_number, $args, $html_node );
		
		// nếu không có dữ liệu -> in ra dữ liệu để test
		if ( $content == '' ) {
			echo '<!-- ';
			
			global $___eb_post__not_in;
			
			echo $___eb_post__not_in . '<br>' . "\n";
			
			print_r( $args );
			
			echo ' -->';
		}
		
//		echo '</ul>';
		
		
		//
		$html_template = _eb_widget_create_html_template( $html_template, 'product_small' );
		
		
		
		//
		if ( $post_cloumn != '' ) {
			$post_cloumn = ' blogs_node_' . $post_cloumn;
		}
		
		
		
		//
		echo '<div class="' . $custom_style . '">';
		
		echo EBE_html_template( EBE_get_page_template( $html_template ), array(
			'tmp.widget_title' => _eb_get_echo_widget_title( $title, 'echbay-widget-product-title', $before_title, $dynamic_tag ),
			'tmp.content' => $content,
			'tmp.num_line' => trim( $num_line . $post_cloumn ),
			'tmp.max_width' => $max_width,
//			'tmp.post_cloumn' => $post_cloumn,
		) );
		
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




