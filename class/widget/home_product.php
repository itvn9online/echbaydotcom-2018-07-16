<?php




/*
* Widget lấy sản phẩm theo từng phân nhóm (thường dùng ở các trang chủ)
*/
//$echbay_widget_i_set_home_product_bg = 0;

class ___echbay_widget_home_category_content extends WP_Widget {
	function __construct() {
		parent::__construct ( 'random_home_post', 'EchBay home product', array (
				'description' => 'Danh sách sản phẩm theo từng phân nhóm ở trang chủ' 
		) );
	}
	
	function form($instance) {
		
		$default = WGR_widget_arr_default_home_hot( array (
			'title' => '',
			'html_template' => 'home_node.html'
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
//		print_r($instance); exit();
		return $instance;
	}
	
	function widget($args, $instance) {
		global $__cf_row;
//		global $func;
//		global $echbay_widget_i_set_home_product_bg;
		
		extract ( $args );
		
//		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
		$dynamic_tag = isset( $instance ['dynamic_tag'] ) ? $instance ['dynamic_tag'] : 'div';
		$description = isset( $instance ['description'] ) ? $instance ['description'] : '';
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
		
//		$html_node = isset( $instance ['html_node'] ) ? $instance ['html_node'] : '';
//		$html_node = str_replace( '.html', '', $html_node );
		
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$custom_size = isset( $instance ['custom_size'] ) ? $instance ['custom_size'] : '';
		
		// ẩn các thuộc tính theo option
		$custom_style .= WGR_add_option_class_for_post_widget( $instance );
		
		
		
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-home-cats-title', $before_title );
		
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
		
		
		//
		$cat_name = $title;
		$cat_link = '';
		$more_link = '';
		$cat_count = 0;
		
		$home_node_cat = '';
		$home_ads_by_cat = '';
		$str_sub_cat = '';
//		echo $cat_ids;
		
		// nếu có phân nhóm -> lấy theo phân nhóm
		if ( $cat_ids > 0 ) {
			$args['cat'] = $cat_ids;
			
			// lấy thông tin phân nhóm luôn
//			$categories = get_categories($cat_ids);
//			$categories = get_the_category_by_ID($cat_ids);
//			$categories = get_term($cat_ids, 'category');
			$categories = get_term_by('id', $cat_ids, 'category');
//			print_r( $categories );
//			echo 'aaaaaaaaaaa<br>';
			if ( $categories == false ) {
				echo '<!-- term not found in ' . strstr( __FILE__, 'echbaydotcom' ) . '! -->';
				return false;
			}
			
			//
			$cat_link = _eb_c_link( $cat_ids );
			$more_link = '<div class="widget-products-more"><a href="' . $cat_link . '">' . EBE_get_lang('widget_products_more') . '</a></div>';
			
			// wp nó trả ra cái objec hơi dị -> foreach lấy cho dễ
			$cat_count = $categories->count;
			$cat_name = $categories->name;
			
			
			
			//
			if ( $cat_count > 0 ) {
				
				// lấy danh sách nhóm con
				$str_sub_cat = WGR_get_home_node_sub_cat( $cat_ids, $__cf_row['cf_home_sub_cat_tag'] );
//				$str_sub_cat = WGR_get_home_node_sub_cat( $cat_ids, $dynamic_tag );
				
				
				
				// banner quảng cáo theo từng danh mục (cấp 1)
				$home_ads_by_cat = WGR_get_home_node_ads( $cat_ids );
				/*
				$home_ads_by_cat = _eb_load_ads( 9, 5, '', array(
					'cat' => $cat_ids,
				), 0, str_replace( 'ti-le-global', '', EBE_get_page_template( 'ads_node' ) ) );
				*/
				
				
				//
//				$home_node_cat = _eb_load_post( $post_number, $args );
			}
		}
		// gán tiêu đề mặc định nếu không có
		else if ( $cat_name == '' ) {
			$cat_name = EBE_get_lang('home_new');
		}
		
		//
		$home_node_cat = _eb_load_post( $post_number, $args );
		
		
		//
		if ( $home_node_cat == '' ) {
			$home_node_cat = '<li class="text-center"><em>post not found</em></li>';
		}
		
		
		
		//
		/*
		$class_for_chanle = 'home-node-le';
		if ( $echbay_widget_i_set_home_product_bg % 2 == 0 ) {
			$class_for_chanle = 'home-node-chan';
		}
		$echbay_widget_i_set_home_product_bg++;
		*/
		
		
		//
		$html_template = _eb_widget_create_html_template( $html_template, 'home_node' );
		
		
		
		//
		echo '<div class="' . $custom_style . '">';
		
		//
		echo WGR_show_home_node( array(
			'tmp.cat_id' => $cat_ids,
			'tmp.cat_link' => $cat_link != '' ? $cat_link : 'javascript:;',
			'tmp.cat_name' => $cat_name,
			'tmp.cat_count' => $cat_count,
			'tmp.description' => $description,
			'tmp.more_link' => $more_link,
			
			// danh sách nhóm cấp 2
			'tmp.str_sub_cat' => $str_sub_cat,
			
			// danh sách sản phẩm
			'tmp.home_node_cat' => $home_node_cat,
			
			// quảng cáo theo nhóm cấp 1
			'tmp.home_ads_by_cat' => $home_ads_by_cat,
			
			//
			'tmp.num_post_line' => $num_line
		), $__cf_row['cf_home_sub_cat_tag'], $html_template );
//		), $dynamic_tag, $html_template );
		
		/*
		echo EBE_html_template( EBE_get_page_template( $html_template ), array(
//			'tmp.cat_name' => $title != '' ? $title : $cat_name,
//			'tmp.title' => $title,
			
			// bg chẵn lẻ
//			'tmp.class_for_chanle' => $class_for_chanle,
//			'tmp.class_for_chanle' => 'each-to-bg-chanle',
			'tmp.max_width' => $max_width,
		) );
		*/
		
		//
		echo '</div>';
		
		
		//
		echo $after_widget;
	}
}




