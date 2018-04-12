<?php




$arr_global_main = array(
	'tmp.cf_dienthoai' => $__cf_row['cf_dienthoai'],
	'tmp.cf_call_dienthoai' => $__cf_row['cf_call_dienthoai'],
	'tmp.cf_hotline' => $__cf_row['cf_hotline'],
	'tmp.cf_call_hotline' => $__cf_row['cf_call_hotline'],
	'tmp.cf_diachi' => $__cf_row['cf_diachi'],
	'tmp.cf_email' => $__cf_row['cf_email'],
	
	'tmp.cf_yahoo' => $__cf_row['cf_yahoo'],
//	'tmp.theme_static_url' => EB_URL_OF_THEME,
	'tmp.web_version' => $web_version,
	'tmp.web_name' => $web_name,
	'tmp.web_link' => web_link,
	
	// tìm và tạo sidebar luôn (nếu có)
	'tmp.str_sidebar' => $id_for_get_sidebar == '' ? '' : _eb_echbay_sidebar( $id_for_get_sidebar ),
	'tmp.search_advanced_sidebar' => _eb_echbay_sidebar( 'search_product_options', 'widget-search-advanced cf', 'div', 1, 0 ),
	
	// kích thước sản phẩm trên mobile, table
	'tmp.cf_product_mobile_size' => $__cf_row['cf_product_mobile_size'],
	'tmp.trv_mobile_img' => $__cf_row['cf_product_mobile_size'],
	
	'tmp.cf_product_table_size' => $__cf_row['cf_product_table_size'],
	'tmp.trv_table_img' => $__cf_row['cf_product_table_size'],
	
	// kích thước ảnh blog
	'tmp.cf_blog_size' => $__cf_row['cf_blog_size'],
	// css định dạng chiều rộng cho phần danh sách blog
	'tmp.custom_blog_css' => $__cf_row['cf_blog_class_style'],
	
	//
	'tmp.fb_num_comments' => EBE_get_lang('fb_comments'),
	
	// phần option cho link của mục blog
	'tmp.blog_link_option' => '',
	'tmp.post_zero' => EBE_get_lang('post_zero'),
);

// riêng với trang chủ -> nếu có set chiều rộng -> bỏ phần chiệu rọng bên trong các module con đi
if ( $act == '' && $__cf_row['cf_home_class_style'] != '' ) {
//		$arr_global_main['tmp.custom_blog_css'] = $__cf_row['cf_home_class_style'];
	$arr_global_main['tmp.custom_blog_css'] = '';
}
/*
else {
	$arr_global_main['tmp.custom_blog_css'] = $__cf_row['cf_blog_class_style'];
}
*/

//
foreach ( $arr_global_main as $k => $v ) {
	$main_content = str_replace ( '{' . $k . '}', $v, $main_content );
}


// chuyển sang dùng CDN (nếu có)
// URL tương đối
$main_content = str_replace ( web_link . EB_DIR_CONTENT . '/', EB_DIR_CONTENT . '/', $main_content );
// URL từ thư mục wp-content
//	$main_content = str_replace ( web_link . EB_DIR_CONTENT . '/', $__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/', $main_content );
// URL từ thư mục uploads
//	$main_content = str_replace ( web_link . EB_DIR_CONTENT . '/uploads/', $__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/uploads/', $main_content );
//	$main_content = str_replace ( '"' . EB_DIR_CONTENT . '/uploads/', '"' . $__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/uploads/', $main_content );


//
if ( $__cf_row['cf_replace_content'] != '' ) {
	$main_content = WGR_replace_for_all_content( $__cf_row['cf_replace_content'], $main_content );
}
// nếu tồn tại tham số URL cũ -> thay nội dung cũ sang mới
if ( $__cf_row['cf_old_domain'] != '' ) {
//	$main_content = str_replace ( '/' . $__cf_row['cf_old_domain'] . '/', '/' . $_SERVER['HTTP_HOST'] . '/', $main_content );
	$main_content = WGR_sync_old_url_in_content( $__cf_row['cf_old_domain'], $main_content );
}



// chuyển URL sang dạng SSL
$main_content = _eb_ssl_template( $main_content );


// chyển các thẻ title động sang thẻ theo config
$main_content = EBE_dynamic_title_tag( $main_content );



