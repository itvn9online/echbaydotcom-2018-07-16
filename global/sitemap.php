<?php


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
	
	
	
	//
	foreach ( $arr_active_for_404_page as $k => $v ) {
//		echo $k . '<br>' . "\n";
		
		//
//		if ( $k == 'sitemap' || strstr( $k, 'sitemap-' ) == true ) {
		if ( strstr( $k, 'sitemap-' ) == true ) {
			$get_list_sitemap .= WGR_echo_sitemap_node( web_link . $k, $sitemap_current_time );
		}
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




