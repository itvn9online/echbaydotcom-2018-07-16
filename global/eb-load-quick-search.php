<?php



// các function cho phần quick search
function WGR_quick_search_get_js_post ( $type = 'post', $limit_post_get = 1000 ) {
	global $wpdb;
	
	//
	$sql = _eb_q("SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = '" . $type . "'
		AND post_status = 'publish'
	ORDER BY
		menu_order DESC,
		ID DESC
	LIMIT 0, " . $limit_post_get);
//	print_r( $sql );
	
	//
	$str = '';
	foreach ( $sql as $v ) {
		$str .= ',{id:' . $v->ID . ',ten:"' . _eb_str_block_fix_content( $v->post_title ) . '",seo:"' . $v->post_name . '",lnk:""}';
	}
	return substr( $str, 1 );
}


function WGR_quick_search_set_content ( $data ) {
	global $quick_search_in_cache;
	
	if ( ! file_put_contents( $quick_search_in_cache, $data . "\n", FILE_APPEND ) ) {
		_eb_remove_file( $quick_search_in_cache );
		die('ERROR: append quick_search cache file');
	}
}



// tạo file javascript
header("Content-Type: application/javascript");



//
$strCacheFilter = basename( __FILE__, '.php' );
$quick_search_in_cache = EB_THEME_CACHE . $strCacheFilter . '.txt';
$get_list_quick_search = _eb_get_static_html ( $strCacheFilter, '', '', 300 );
if ( $get_list_quick_search == false || eb_code_tester == true ) {
	
	// tạo file mới, với dòng comment đầu tiên -> đỡ lỗi cho JS
//	file_put_contents( $quick_search_in_cache, '/* */' ) or die('ERROR: write comment quick_search cache file');
	_eb_create_file( $quick_search_in_cache, '/* */' );
	
	
	
	// lấy toàn bộ danh sách các category, tag để phục vụ cho module tìm kiếm nhanh
	WGR_quick_search_set_content( 'var eb_site_group=[' . _eb_get_full_category_v2 ( 0, 'category', 0, array(
		'hide_empty' => 0
	) ) . '];' );
	
	WGR_quick_search_set_content( 'var eb_tags_group=[' . _eb_get_full_category_v2 ( 0, 'post_tag', 0, array(
		'hide_empty' => 0
	) ) . '];' );
	
	WGR_quick_search_set_content( 'var eb_options_group=[' . _eb_get_full_category_v2 ( 0, 'post_options', 0, array(
		'hide_empty' => 0
	) ) . '];' );
	
	WGR_quick_search_set_content( 'var eb_blog_group=[' . _eb_get_full_category_v2 ( 0, EB_BLOG_POST_LINK, 0, array(
		'hide_empty' => 0
	) ) . '];' );
	
	
	
	// danh sách post, page, blog
	WGR_quick_search_set_content( 'var eb_posts_list=[' . WGR_quick_search_get_js_post () . '];' );
	
	WGR_quick_search_set_content( 'var eb_blogs_list=[' . WGR_quick_search_get_js_post ( 'blog' ) . '];' );
	
	WGR_quick_search_set_content( 'var eb_pages_list=[' . WGR_quick_search_get_js_post ( 'page' ) . '];' );

}


//
echo file_get_contents( $quick_search_in_cache, 1 );




exit();




