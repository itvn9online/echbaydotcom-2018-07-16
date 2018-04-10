<?php



// tham khảo
// https://support.google.com/webmasters/answer/178636?hl=vi




// thư viện dùng chung
include EB_THEME_PLUGIN_INDEX . 'global/sitemap_function.php';




/*
* Tạo danh sách sitemap cho toàn bộ website
*/
$strCacheFilter = basename( __FILE__, '.php' );
$get_list_sitemap = _eb_get_static_html ( $strCacheFilter, '', '', 3 * 3600 );
if ( $get_list_sitemap == false || eb_code_tester == true ) {
	
	
	//
	$get_list_sitemap = '';
	
	
	
	// auto
	/*
	foreach ( $arr_active_for_404_page as $k => $v ) {
//		echo $k . '<br>' . "\n";
		
		//
//		if ( $k == 'sitemap' || strstr( $k, 'sitemap-' ) == true ) {
		if ( strstr( $k, 'sitemap-' ) == true ) {
			$get_list_sitemap .= WGR_echo_sitemap_node( web_link . $k, $sitemap_current_time );
		}
	}
	*/
	
	// manual -> chuẩn hơn trong trường hợp không có bài viết tương ứng thì sitemap không được kích hoạt
	$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-tags', $sitemap_current_time );
	
	if ( WGR_get_sitemap_total_post() > 0 ) {
		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-post', $sitemap_current_time );
//		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-images', $sitemap_current_time );
		
		// phân trang cho sitemap (lấy từ trang 2 trở đi)
		$get_list_sitemap .= WGR_sitemap_part_page();
	}
	
	if ( WGR_get_sitemap_total_post( 'blog' ) > 0 ) {
		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-blog', $sitemap_current_time );
//		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-blog-images', $sitemap_current_time );
		
		// phân trang cho sitemap (lấy từ trang 2 trở đi)
		$get_list_sitemap .= WGR_sitemap_part_page( 'blog', 'sitemap-blog', 'sitemap-blog-images' );
	}
	
	if ( WGR_get_sitemap_total_post( 'page' ) > 0 ) {
		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-page', $sitemap_current_time );
//		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-page-images', $sitemap_current_time );
		
		// phân trang cho sitemap (lấy từ trang 2 trở đi)
		$get_list_sitemap .= WGR_sitemap_part_page( 'page', 'sitemap-page', 'sitemap-page-images' );
	}
	
	if ( WGR_get_sitemap_total_post( 'attachment' ) > 0 ) {
		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-images', $sitemap_current_time );
//		$get_list_sitemap .= WGR_echo_sitemap_node( web_link . 'sitemap-page-images', $sitemap_current_time );
		
		// phân trang cho sitemap (lấy từ trang 2 trở đi)
		$get_list_sitemap .= WGR_sitemap_part_page( 'attachment', 'sitemap-images', 'sitemap-images-images' );
	}
	
	
	
	//
	$get_list_sitemap = trim($get_list_sitemap);
	
	// lưu cache
	_eb_get_static_html ( $strCacheFilter, $get_list_sitemap, '', 1 );
	
	
}



// print
WGR_echo_sitemap_css();

echo '
<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
' . $get_list_sitemap . '
</sitemapindex>';



exit();




