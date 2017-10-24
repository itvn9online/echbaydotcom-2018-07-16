<?php



function WGR_widget_arr_default_home_hot ( $new_arr = array() ) {
	// Giá trị mặc định
	$arr = array (
		'title' => 'EchBay Widget for product',
		'dynamic_tag' => 'div',
		'description' => '',
		'sortby' => 'menu_order',
		'num_line' => '',
		'html_template' => 'home_hot.html',
		'html_node' => '',
		'max_width' => '',
		'post_number' => 5,
		'cat_ids' => 0,
		'cat_type' => 'category',
		'post_cloumn' => '',
		'post_type' => 'post',
		'ads_eb_status' => 0,
		'post_eb_status' => 0,
		'custom_style' => '',
		'custom_size' => ''
	);
	
	// thay thế các giá trị mặc định
	foreach ( $new_arr as $k => $v ) {
		$arr[$k] = $v;
	}
	
	// Trả về kết quả
	return $arr;
}

function WGR_widget_home_hot ( $instance ) {
//	global $func;
	global $echbay_widget_i_set_home_product_bg;
	
	
	//
//	$title = apply_filters ( 'widget_title', $instance ['title'] );
	$title = isset( $instance ['title'] ) ? $instance ['title'] : '';
	$dynamic_tag = isset( $instance ['dynamic_tag'] ) ? $instance ['dynamic_tag'] : 'div';
	$description = isset( $instance ['description'] ) ? $instance ['description'] : '';
	$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 0;
	if ( $post_number == 0 ) $post_number = 5;
	
	$sortby = isset( $instance ['sortby'] ) ? $instance ['sortby'] : '';
	$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
	$cat_ids = isset( $instance ['cat_ids'] ) ? $instance ['cat_ids'] : 0;
	$cat_type = isset( $instance ['cat_type'] ) ? $instance ['cat_type'] : 'category';
	$post_eb_status = isset( $instance ['post_eb_status'] ) ? $instance ['post_eb_status'] : 0;
	$html_template = isset( $instance ['html_template'] ) ? $instance ['html_template'] : '';
	$html_template = str_replace( '.html', '', $html_template );
	$max_width = isset( $instance ['max_width'] ) ? $instance ['max_width'] : '';
	$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
	$post_type = isset( $instance ['post_type'] ) ? $instance ['post_type'] : '';
	
	$html_node = isset( $instance ['html_node'] ) ? $instance ['html_node'] : '';
	$html_node = str_replace( '.html', '', $html_node );
	
	$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
	$custom_size = isset( $instance ['custom_size'] ) ? $instance ['custom_size'] : '';
	
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
	$str_home_hot = '';
	$home_hot_lnk = '';
	$home_hot_more = '';
	
	// nếu có phân nhóm -> lấy theo phân nhóm
	if ( $cat_ids > 0 ) {
		$args['cat'] = $cat_ids;
		$home_hot_lnk = _eb_c_link( $cat_ids, $cat_type );
		
		// lấy thông tin phân nhóm luôn
		if ( $title == '' ) {
			$categories = get_term_by('id', $cat_ids, $cat_type);
			$title = $categories->name;
		}
		
		//
		$title = '<a href="' . $home_hot_lnk . '">' . $title . '</a>';
		$home_hot_more = '<' . $dynamic_tag . ' class="home-hot-more"><a href="' . $home_hot_lnk . '">Xem thêm <span>&raquo;</span></a></' . $dynamic_tag . '>';
	}
	else if ( $title == '' ) {
		$title = EBE_get_lang('home_hot');
	}
	
	// tìm theo trạng thái
	if ( $post_eb_status > 0 ) {
		$args['meta_key'] = '_eb_product_status';
		$args['meta_value'] = $post_eb_status;
	}
	
	//
	$str_home_hot = _eb_load_post( $post_number, $args );
	
	
	//
	if ( $str_home_hot == '' ) {
		$str_home_hot = '<li class="text-center"><em>post not found</em></li>';
	}
	
	
	//
	$html_template = _eb_widget_create_html_template( $html_template, 'home_hot' );
	
	
	
	//
	echo '<div class="' . $custom_style . '">';
	
//	echo EBE_html_template( EBE_get_page_template( $html_template ), array(
	echo WGR_show_home_hot( array(
		'tmp.max_width' => $max_width,
		'tmp.num_post_line' => $num_line,
		'tmp.home_hot_title' => $title,
		'tmp.home_hot_more' => $home_hot_more,
		'tmp.description' => $description,
		'tmp.home_hot' => $str_home_hot,
//	) );
	), $html_template );
	
	echo '</div>';
	
}


// hiển thị phần home hot theo chuẩn nhất định
function WGR_show_home_hot ( $arr, $tmp = 'home_hot' ) {
	// nạp html được truyền vào
	$html = EBE_html_template( EBE_get_page_template( $tmp ), $arr );
	
	// các đoạn HTML mặc định cho về trống nếu chưa có
	return EBE_html_template( $html, array(
		'tmp.max_width' => '',
		'tmp.num_post_line' => '',
		'tmp.home_hot_title' => '',
		'tmp.home_hot_more' => '',
		'tmp.description' => '',
		'tmp.home_hot' => '',
	) );
}



