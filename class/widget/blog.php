<?php



/*
* Widget blog ngẫu nhiên
*/
class ___echbay_widget_random_blog extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_blog', 'EchBay blog', array (
				'description' => 'Tạo danh sách Blog/ Tin tức/ Ads (custom post type) tại mục này' 
		) );
	}
	
	function form($instance) {
		$default = WGR_widget_arr_default_home_hot( array(
			'title' => 'EchBay blog',
			'html_template' => 'widget_echbay_blog.html',
			'html_node' => 'blogs_node.html',
			'cat_type' => EB_BLOG_POST_LINK,
			'post_type' => EB_BLOG_POST_TYPE
		) );
		$instance = wp_parse_args ( ( array ) $instance, $default );
		
		
		//
		$arr_field_name = array();
		foreach ( $default as $k => $v ) {
			$arr_field_name[ $k ] = $this->get_field_name ( $k );
		}
		
		_eb_product_form_for_widget( $instance, $arr_field_name );
		
		
		
		/*
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		*/
		/*
		$title = esc_attr ( $instance ['title'] );
		$post_number = esc_attr ( $instance ['post_number'] );
		$sortby = esc_attr ( $instance ['sortby'] );
		$cat_ids = esc_attr ( $instance ['cat_ids'] );
		*/
		
		
		//
		/*
		_eb_widget_echo_widget_input_title( $this->get_field_name ( 'title' ), $title );
		
		
		//
		_eb_widget_echo_number_of_posts_to_show( $this->get_field_name ( 'post_number' ), $post_number );
		
		
		//
		_eb_widget_set_sortby_field( $this->get_field_name ( 'sortby' ), $sortby );
		
		
		//
		__eb_widget_load_cat_select ( array(
			'cat_ids_name' => $this->get_field_name ( 'cat_ids' ),
			'cat_ids' => $cat_ids,
			'cat_type_name' => $this->get_field_name ( 'cat_type' ),
			'cat_type' => $cat_type,
		) );
		
		
		//
		_eb_widget_number_of_posts_inline( $this->get_field_name ( 'num_line' ), $num_line );
		
		
		//
		_eb_widget_style_for_post_cloumn( $this->get_field_name ( 'post_cloumn' ), $post_cloumn );
		
		
		//
		_eb_widget_max_width_for_module( $this->get_field_name ( 'max_width' ), $max_width );
		
		
		//
		_eb_widget_list_html_file_plugin_theme( $this->get_field_name ( 'html_template' ), $html_template );
		*/
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $__cf_row;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		$dynamic_tag = isset( $instance ['dynamic_tag'] ) ? $instance ['dynamic_tag'] : '';
		$description = isset( $instance ['description'] ) ? $instance ['description'] : '';
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
		if ( $post_number == 0 ) $post_number = 5;
		
		$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
		$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : EB_BLOG_POST_LINK;
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		$max_width = isset( $instance ['max_width'] ) ? $instance ['max_width'] : '';
		$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
		
		$html_template = isset( $instance ['html_template'] ) ? $instance ['html_template'] : '';
		
		$post_type = isset( $instance ['post_type'] ) ? $instance ['post_type'] : '';
		
		$html_node = isset( $instance ['html_node'] ) ? $instance ['html_node'] : '';
		$html_node = _eb_widget_create_html_template( $html_node, 'blogs_node' );
//		echo $html_node . '<br>' . "\n";
		
		$ads_eb_status = isset( $instance ['ads_eb_status'] ) ? $instance ['ads_eb_status'] : 0;
		$post_eb_status = isset( $instance ['post_eb_status'] ) ? $instance ['post_eb_status'] : 0;
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$custom_size = isset( $instance ['custom_size'] ) ? $instance ['custom_size'] : '';
		
		
		//
		$cat_link = '';
		if ( $post_type == EB_BLOG_POST_TYPE ) {
			$cat_type = EB_BLOG_POST_LINK;
		}
		else {
			$cat_type = 'category';
		}
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );
		
		//
		$terms_categories = array();
		$cat_name = '';
		$more_link = '';
		$str_sub_cat = '';
		
		// lấy theo nhóm tin đã được chỉ định
		if ( $cat_ids > 0 ) {
			$terms_categories[] = $cat_ids;
			$cat_link = _eb_c_link( $cat_ids, $cat_type );
			$more_link = '<div class="widget-blog-more"><a href="' . $cat_link . '">Xem thêm <span>&raquo;</span></a></div>';
			
			if ( $title == '' ) {
//				echo $cat_ids;
				$categories = get_term_by('id', $cat_ids, $cat_type);
//				print_r($categories);
				$title = $categories->name;
			}
			
			
			// danh sách nhóm cấp 2
			$arr_sub_cat = array(
				'parent' => $cat_ids,
				'taxonomy' => $cat_type,
			);
			$sub_cat = get_categories($arr_sub_cat);
//			print_r( $sub_cat );
			
			foreach ( $sub_cat as $sub_v ) {
				$str_sub_cat .= ' <a href="' . _eb_c_link( $sub_v->term_id, $cat_type ) . '">' . $sub_v->name . ' <span class="blog-count-subcat">(' . $sub_v->count . ')</span></a>';
			}
			$str_sub_cat = '<div class="widget-blog-subcat">' . $str_sub_cat . '</div>';
			
		}
		// lấy tất cả
		else {
			$args = array(
				'taxonomy' => $cat_type,
			);
			$categories = get_categories($args);
//			print_r( $categories );
			
			//
			foreach ( $categories as $v ) {
				$terms_categories[] = $v->term_id;
			}
		}
//		print_r( $terms_categories );
		
		//
		$___order = 'DESC';
		if ( $sortby == '' || $sortby == 'rand' ) {
			$___order = '';
		}
		
		
		//
		$arr_select_data = array(
			'orderby' => $sortby,
			'order' => $___order,
			'post_type' => $post_type,
		);
		
		// nếu là ads -> chỉ lấy theo trạng thái là đủ
		if ( $post_type == 'ads' ) {
			if ( $ads_eb_status > 0 ) {
				$arr_select_data['meta_key'] = '_eb_ads_status';
				$arr_select_data['meta_value'] = $ads_eb_status;
				
				// hiển thị trạng thái ads ra để chekc cho dễ
				global $arr_eb_ads_status;
				
				echo '<!-- ADS status: ' . $ads_eb_status . ' - ' . $arr_eb_ads_status[ $ads_eb_status ] . ' -->';
			}
		}
		// với blog, lấy đặc biệt hơn chút
		else if ( count( $terms_categories ) > 0 ) {
			$arr_select_data['tax_query'] = array(
				array(
					'taxonomy' => $cat_type,
					'field' => 'term_id',
					'terms' => $terms_categories,
					'operator' => 'IN'
				)
			);
		}
		
		// riêng với từng post type
		if ( $post_type == 'post' ) {
			if ( $post_eb_status > 0 ) {
				$arr_select_data['meta_key'] = '_eb_product_status';
				$arr_select_data['meta_value'] = $post_eb_status;
			}
		}
		
		//
//		print_r( $arr_select_data );
		
		
		
		// nếu là node của sản phẩm -> dùng bản mặc định luôn
		if ( $html_node == 'thread_node' ) {
			$html_node = __eb_thread_template;
			$html_template = 'widget_echbay_thread';
		} else {
			$html_node = EBE_get_page_template( $html_node );
			
			// chỉnh lại kích thước nếu có
			if ( $custom_size != '' ) {
				$html_node = str_replace( '{tmp.cf_blog_size}', $custom_size, $html_node );
				$html_node = str_replace( '{tmp.cf_product_size}', $custom_size, $html_node );
			}
		}
		
		// load riêng 1 kiểu đối với ads
		/*
		if ( $post_type == 'ads' ) {
			$content = _eb_load_post( $post_number, $arr_select_data,
			$html_node );
		}
		// mặc định thì load theo post
		else {
			*/
			$content = _eb_load_post( $post_number, $arr_select_data,
//			), file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/blog_node.html', 1 ) );
//			), EBE_get_page_template( 'blog_node' ) );
//			), EBE_get_page_template( $html_node ) );
			$html_node );
//		}
		
		
		
		//
		if ( $post_cloumn != '' ) {
			$post_cloumn = 'blogs_node_' . $post_cloumn;
		}
//		echo $cat_link;
		
		
		//
		$html_template = _eb_widget_create_html_template( $html_template, 'widget_echbay_blog' );
		echo '<!-- HTML widget file: ' . $html_template . ' - Widget title: ' . $title . ' -->';
		
		
		//
		$widget_title = _eb_get_echo_widget_title( $cat_link == '' ? $title : '<a href="' . $cat_link . '">' . $title . '</a>', 'echbay-widget-blogs-title', $before_title, $dynamic_tag );
		
		if ( $description != '' ) {
			$widget_title .= '<div class="echbay-widget-blogs-desc">' . $description . '</div>';
		}
//		echo $description;
		
		
		//
		echo '<div class="' . $custom_style . '">';
		
		echo EBE_dynamic_title_tag( EBE_html_template( EBE_get_page_template( $html_template ), array(
			'tmp.cat_link' => $cat_link == '' ? 'javascript:;' : $cat_link,
			'tmp.more_link' => $more_link,
			'tmp.num_line' => $num_line,
			'tmp.max_width' => $max_width,
			'tmp.blog_title' => $title,
			'tmp.post_cloumn' => $post_cloumn,
			'tmp.widget_title' => $widget_title . $str_sub_cat,
			'tmp.content' => $content
		) ) );
		
		echo '</div>';
		
		//
		echo $after_widget;
	}
}




