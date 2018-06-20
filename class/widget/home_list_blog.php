<?php


//$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_list_blog extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_blog', 'EchBay home blog list', array (
				'description' => 'Danh sách Bài viết theo toàn bộ danh mục ở trang chủ' 
		) );
	}
	
	function form($instance) {
		$default = WGR_default_for_home_list_and_blog ();
		
		$this_value = array();
		foreach ( $default as $k => $v ) {
			$this_value[$k] = $this->get_field_name ( $k );
		}
		
		WGR_phom_for_home_list_and_blog( $instance, $default, $this_value, EB_BLOG_POST_LINK );
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
//		print_r($instance); exit();
		return $instance;
	}
	
	function widget($args, $instance) {
//		global $__cf_row;
		
		//
//		print_r( $instance );
		
		//
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 5;
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
//		$custom_style .= WGR_add_option_class_for_post_widget( $instance );
		
		$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
		if ( $post_cloumn != '' ) {
			$custom_style .= ' blogs_node_' . $post_cloumn;
		}
		
		//
		$widget_select_categories = array();
		$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : '';
		
		// lấy theo list ID có sẵn
		if ( $cat_ids != '' ) {
			$cat_ids = explode( ',', $cat_ids );
			
			foreach ( $cat_ids as $v ) {
				$t = get_term( $v, EB_BLOG_POST_LINK );
				if ( ! isset($t->errors) ) {
//					print_r( $t );
					$widget_select_categories[] = $t;
				}
			}
		}
		// hoặc lấy mặc định các nhóm cấp 1
		else {
			$widget_select_categories = get_categories( array(
				'hide_empty' => 0,
				'taxonomy' => EB_BLOG_POST_LINK,
				'parent' => 0
			) );
//			print_r( $categories );
		}
//		print_r( $widget_select_categories );
//		$widget_select_categories = array();
//		exit();
		
		echo '<div class="cf widget-echbay-blog-list">';
		
		//
		if ( empty( $widget_select_categories ) ) {
			echo '<!-- widget home_list_blog category not found! -->';
		}
		else {
			$widget_select_categories = WGR_order_and_hidden_taxonomy( $widget_select_categories );
			
			//
			foreach ( $widget_select_categories as $k => $v ) {
				$default_array = WGR_widget_arr_default_home_hot( array(
//					'title' => 'EchBay blog',
					'html_template' => 'widget_echbay_blog.html',
					'html_node' => 'blogs_node.html',
					'cat_type' => EB_BLOG_POST_LINK,
					'post_type' => EB_BLOG_POST_TYPE
				) );
//				print_r( $default_array );
				$default_array['title'] = '';
//				$default_array['hide_widget_title'] = 'off';
				$default_array['hide_widget_title'] = isset( $instance ['hide_widget_title'] ) ? $instance ['hide_widget_title'] : 'off';
				
				$default_array['num_line'] = $num_line;
				$default_array['post_number'] = $post_number;
				$default_array['post_cloumn'] = $post_cloumn;
				
				$default_array['cat_ids'] = $v->term_id;
				
				$default_array['hide_title'] = isset( $instance ['hide_title'] ) ? $instance ['hide_title'] : 'off';
				$default_array['hide_description'] = isset( $instance ['hide_description'] ) ? $instance ['hide_description'] : 'off';
				$default_array['hide_info'] = isset( $instance ['hide_info'] ) ? $instance ['hide_info'] : 'off';
				$default_array['run_slider'] = isset( $instance ['run_slider'] ) ? $instance ['run_slider'] : 'off';
				
				// off hết đống này đi
				$default_array['content_only'] = 'off';
				$default_array['get_childs'] = 'off';
				$default_array['open_youtube'] = 'off';
				$default_array['same_cat'] = 'off';
				$default_array['get_post_type'] = 'off';
				$default_array['open_target'] = 'off';
				$default_array['ads_eb_status'] = 'off';
				$default_array['post_eb_status'] = 'off';
				$default_array['post_eb_status'] = 'off';
//				print_r( $default_array );
				
				//
				echo '<div class="widget_random_blog">';
				echo '<div class="' . trim( $custom_style ) . '">';
				
				WGR_show_widget_blog( $args, $default_array, array (
					'this_name' => $this->name
				) );
				
				echo '</div>';
				echo '</div>';
				
				//
//				return false;
			}
		}
		
		echo '</div>';
		
	}
}




