<?php



function WGR_widget_arr_default_home_hot ( $new_arr = array() ) {
	// Giá trị mặc định
	$arr = array (
		'title' => 'EchBay Widget for product',
		'hide_widget_title' => 0,
		'dynamic_tag' => 'div',
		'description' => '',
		'content_only' => 0,
		'sortby' => 'menu_order',
		'num_line' => '',
		'html_template' => 'home_hot.html',
		'html_node' => '',
		'max_width' => '',
		'post_number' => 5,
		'cat_ids' => 0,
		'cat_type' => 'category',
		'get_childs' => 0,
		'post_cloumn' => '',
		'hide_title' => 0,
		'hide_description' => 0,
		'hide_info' => 0,
		'post_type' => 'post',
		// dành cho mục quảng cáo -> mở dưới dạng video youtube
		'open_youtube' => 0,
		// lấy các bài viết cùng nhóm
		'same_cat' => 0,
		// tự động lấy post type mới khi chức năng same_cat được kích hoạt
		'get_post_type' => 0,
		
		// Quan hệ liên kết (XFN) -> rel="nofollow"
		'rel_xfn' => '',
		// Mở liên kết trong 1 thẻ mới
		'open_target' => 0,
		
		'ads_eb_status' => 0,
		'post_eb_status' => 0,
		'custom_style' => '',
		'custom_size' => '',
		'page_id' => 0
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
	
	$max_width = isset( $instance ['max_width'] ) ? $instance ['max_width'] : '';
	$post_cloumn = isset( $instance ['post_cloumn'] ) ? $instance ['post_cloumn'] : '';
	$post_type = isset( $instance ['post_type'] ) ? $instance ['post_type'] : '';
	
//	$html_node = isset( $instance ['html_node'] ) ? $instance ['html_node'] : '';
//	$html_node = str_replace( '.html', '', $html_node );
	
	$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
	$custom_size = isset( $instance ['custom_size'] ) ? $instance ['custom_size'] : '';
	
	// ẩn các thuộc tính theo option
	$custom_style .= WGR_add_option_class_for_post_widget( $instance );
	
	
	
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
		
		// các sản phẩm trong nhóm con
		/*
		$arr_in = array();
		
		$sub_cat = get_categories( array(
			'parent' => $cat_ids
		) );
//		print_r( $sub_cat );
		if ( ! empty( $sub_cat ) ) {
			foreach ( $sub_cat as $k => $v ) {
				$arr_in[] = $v->term_id;
			}
		}
		
		if ( ! empty( $arr_in ) ) {
			$arr_in[] = $cat_ids;
			
			$args['category__in'] = $arr_in;
		}
		else {
			*/
			$args['cat'] = $cat_ids;
//		}
		
		//
		$home_hot_lnk = _eb_c_link( $cat_ids, $cat_type );
		
		// lấy thông tin phân nhóm luôn
		if ( $title == '' ) {
			$categories = get_term_by('id', $cat_ids, $cat_type);
			$title = $categories->name;
		}
		
		//
		$title = '<a href="' . $home_hot_lnk . '">' . $title . '</a>';
//		$home_hot_more = '<' . $dynamic_tag . ' class="home-hot-more"><a href="' . $home_hot_lnk . '">Xem thêm <span>&raquo;</span></a></' . $dynamic_tag . '>';
		$home_hot_more = '<div class="home-hot-more"><a href="' . $home_hot_lnk . '">Xem thêm <span>&raquo;</span></a></div>';
	}
	else if ( $title == '' ) {
		$title = EBE_get_lang('home_hot');
	}
	else {
		global $___eb_lang;
		
		//
		if ( isset( $___eb_lang[eb_key_for_site_lang . $title] ) ) {
			$title = $___eb_lang[eb_key_for_site_lang . $title];
		}
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
		echo '<!-- ';
		print_r( $args );
		echo ' -->';
		
		$str_home_hot = '<li class="text-center"><em>post not found</em></li>';
	}
	
	
	//
	$html_template = _eb_widget_create_html_template( $html_template, 'home_hot' );
	
	
	
	//
	echo '<div class="' . $custom_style . '">';
	
	$arr_for_template = array(
		'tmp.dynamic_widget_tag' => $dynamic_tag,
		'tmp.max_width' => $max_width,
		'tmp.num_post_line' => $num_line,
		'tmp.home_hot_title' => $title,
		'tmp.home_hot_more' => $home_hot_more,
		'tmp.description' => $description,
		'tmp.home_hot' => $str_home_hot,
//	) );
	);
	
	/*
	if ( $max_width != '' ) {
		$arr_for_template['custom_blog_css'] = $max_width;
	}
	*/
//	print_r($arr_for_template);
	
	
//	echo EBE_html_template( EBE_get_page_template( $html_template ), array(
	echo WGR_show_home_hot( $arr_for_template, $html_template );
	
	echo '</div>';
	
}


// hiển thị phần home hot theo chuẩn nhất định
function WGR_show_home_hot ( $arr, $tmp = 'home_hot' ) {
	global $__cf_row;
	
	// nạp html được truyền vào
	$html = EBE_html_template( EBE_get_page_template( $tmp ), $arr );
	
	// các đoạn HTML mặc định cho về trống nếu chưa có
	$html = EBE_html_template( $html, array(
		'tmp.max_width' => '',
		'tmp.num_post_line' => '',
		'tmp.home_hot_title' => '',
		'tmp.home_hot_more' => '',
		'tmp.description' => '',
		'tmp.home_hot' => '',
	) );
	
	//
	/*
	if ( $__cf_row['cf_replace_content'] != '' ) {
		$html = WGR_replace_for_all_content( $__cf_row['cf_replace_content'], $html );
	}
	*/
	
	//
	return $html;
}


// hiển thị phần home node theo chuẩn nhất định
function WGR_show_home_node ( $arr, $custom_tag = '', $tmp = 'home_node' ) {
	
	// kiểm tra xem có custom tag không -> do bản cũ với mới khác nhau nên phải có đoạn này
	$custom_end_tag = '';
	if ( $custom_tag != '' ) {
		$custom_end_tag = '</' . $custom_tag . '>';
		$custom_tag = '<' . $custom_tag . '>';
	}
	
	// nạp html được truyền vào
	$html = EBE_html_template( EBE_get_page_template( $tmp ), $arr );
	
	// các đoạn HTML mặc định cho về trống nếu chưa có
	return EBE_html_template( $html, array(
		// thẻ H2, H3... cho phần tên danh mục
		'tmp.custom_tag' => $custom_tag,
		'tmp.custom_end_tag' => $custom_end_tag,
		
		// các thông số khác
		'tmp.num_post_line' => '',
	) );
}

// lấy danh sách nhóm con
function WGR_get_home_node_sub_cat ( $cat_ids, $custom_tag = '' ) {
	// danh sách nhóm cấp 2
	$arr_sub_cat = array(
		'parent' => $cat_ids,
	);
	$sub_cat = get_categories($arr_sub_cat);
//	print_r( $sub_cat );
	
	// kiểm tra xem có custom tag không -> do bản cũ với mới khác nhau nên phải có đoạn này
	$custom_end_tag = '';
	if ( $custom_tag != '' ) {
		$custom_end_tag = '</' . $custom_tag . '>';
		$custom_tag = '<' . $custom_tag . '>';
	}
	
	//
	$str_sub_cat = '';
	foreach ( $sub_cat as $sub_v ) {
		$str_sub_cat .= $custom_tag . '<a href="' . _eb_c_link( $sub_v->term_id ) . '">' . $sub_v->name . ' <span class="home-count-subcat">(' . $sub_v->count . ')</span></a>' . $custom_end_tag;
	}
	
	return $str_sub_cat;
}

// lấy danh sách các quảng cáo đi kèm cho từng nhóm
function WGR_get_home_node_ads ( $cat_ids, $tmp = 'ads_node' ) {
	return _eb_load_ads( 9, _eb_number_only( EBE_get_lang('homelist_num') ), EBE_get_lang('homelist_size'), array(
		'cat' => $cat_ids,
	), 0, EBE_get_page_template( $tmp ) );
//	), 0, str_replace( 'ti-le-global', '', EBE_get_page_template( 'ads_node' ) ) );
}

//
function WGR_add_option_class_for_post_widget ( $a ) {
	$s = '';
	
	//
	if ( isset( $a ['hide_widget_title'] ) && $a ['hide_widget_title'] == 'on' ) {
		$s .= ' hide-widget-title';
	}
	
	if ( isset( $a ['hide_title'] ) && $a ['hide_title'] == 'on' ) {
		$s .= ' hide-blogs-title';
	}
	
	if ( isset( $a ['hide_description'] ) && $a ['hide_description'] == 'on' ) {
		$s .= ' hide-blogs-description';
	}
	
	if ( isset( $a ['hide_info'] ) && $a ['hide_info'] == 'on' ) {
		$s .= ' hide-blogs-info';
	}
	
	if ( isset( $a ['open_youtube'] ) && $a ['open_youtube'] == 'on' ) {
		$s .= ' youtube-quick-view';
	}
	
	//
	return $s;
}



