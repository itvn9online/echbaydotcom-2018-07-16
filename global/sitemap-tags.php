<?php


// thư viện dùng chung
include EB_THEME_PLUGIN_INDEX . 'global/sitemap_function.php';





/*
* Danh sách category, tags, options....
*/
$strCacheFilter = basename( __FILE__, '.php' );
$get_list_sitemap = _eb_get_static_html ( $strCacheFilter, '', '', 3 * 3600 );
if ( $get_list_sitemap == false || eb_code_tester == true ) {
	
	
	//
	$get_list_sitemap = '';
	
	
	
	/*
	* home
	*/
	$get_list_sitemap .= WGR_echo_sitemap_url_node( web_link, 1.0, $sitemap_current_time );
	
	
	
	
	/*
	* catagory
	*/
	$get_list_sitemap .= WGR_get_sitemap_taxonomy();
	
	
	// post_tag
	$get_list_sitemap .= WGR_get_sitemap_taxonomy( 'post_tag', 0.8 );
	
	
	// post_options
	if ( $__cf_row['cf_alow_post_option_index'] == 1 ) {
		$get_list_sitemap .= WGR_get_sitemap_taxonomy( 'post_options', 0.7 );
	}
	
	
	// blog
	$get_list_sitemap .= WGR_get_sitemap_taxonomy( 'blogs', 0.6 );
	
	
	
	//
	$get_list_sitemap = trim($get_list_sitemap);
	
	// lưu cache
	_eb_get_static_html ( $strCacheFilter, $get_list_sitemap, '', 1 );
	
	
}






//
WGR_echo_sitemap_css();

echo '
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
' . $get_list_sitemap . '
</urlset>';



exit();




