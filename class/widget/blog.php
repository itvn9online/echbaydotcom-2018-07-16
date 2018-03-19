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
		WGR_show_widget_blog ( $args, $instance, array(
			'this_name' => $this->name
		) );
	}
}




