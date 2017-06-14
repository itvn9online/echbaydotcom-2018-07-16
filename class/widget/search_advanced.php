<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_search_advanced extends WP_Widget {
	function __construct() {
		parent::__construct ( 'search_advanced', 'EchBay search advanced', array (
				'description' => 'Chức năng tìm kiếm nâng cao, tìm theo options của sản phẩm' 
		) );
	}
	
	function form($instance) {
		$default = array (
				'title' => 'EchBay search advanced',
				/*
				'sortby' => 'menu_order',
				'post_number' => 5,
				'cat_ids' => 0,
				'num_line' => '',
				'post_cloumn' => '',
				'html_template' => '',
				'max_width' => ''
				*/
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		//
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title );
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $func;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		$max_width = isset( $instance ['max_width'] ) ? $instance ['max_width'] : '';
		$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
		$html_template = isset( $instance ['html_template'] ) ? $instance ['html_template'] : '';
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
		
		
		
		
		// category
		$arrs = get_categories( array(
	//		'taxonomy' => 'post_options',
	//		'hide_empty' => 0,
			'parent' => 0,
		) );
		print_r($arrs);
		
		
		
		
		
		//
		$terms_categories = array();
		
		// lấy theo nhóm tin đã được chỉ định
		if ( $cat_ids > 0 ) {
			$terms_categories[] = $cat_ids;
		}
		// lấy tất cả
		else {
			$args = array(
				'taxonomy' => EB_BLOG_POST_LINK,
			);
			$categories = get_categories($args);
//			print_r( $categories );
			
			//
			foreach ( $categories as $v ) {
				$terms_categories[] = $v->term_id;
			}
		}
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		//
		$content = _eb_load_post( $post_number, array(
			'orderby' => $sortby,
			'order' => $___order,
			'post_type' => EB_BLOG_POST_TYPE,
			'tax_query' => array(
				array(
					'taxonomy' => EB_BLOG_POST_LINK,
					'field' => 'term_id',
					'terms' => $terms_categories,
					'operator' => 'IN',
				)
			),
//		), file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/blog_node.html', 1 ) );
//		), EBE_get_page_template( 'blog_node' ) );
		), EBE_get_page_template( 'blogs_node' ) );
		
		
		
		//
		if ( $post_cloumn != '' ) {
			$post_cloumn = 'blogs_node_' . $post_cloumn;
		}
		
		
		//
		$html_template = _eb_widget_create_html_template( $html_template, 'widget_echbay_blog' );
		
		
		//
		echo EBE_html_template( EBE_get_page_template( $html_template ), array(
			'tmp.num_line' => $num_line,
			'tmp.max_width' => $max_width,
			'tmp.blog_title' => $title,
			'tmp.post_cloumn' => $post_cloumn,
			'tmp.widget_title' => _eb_get_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title ),
			'tmp.content' => $content,
		) );
		
		//
		echo $after_widget;
	}
}




