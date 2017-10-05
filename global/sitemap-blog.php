<?php


// thư viện dùng chung
include EB_THEME_PLUGIN_INDEX . 'global/sitemap_function.php';





/*
* Danh sách post (sản phẩm)
*/
$strCacheFilter = basename( __FILE__, '.php' );
$get_list_sitemap = _eb_get_static_html ( $strCacheFilter, '', '', 3 * 3600 );
if ( $get_list_sitemap == false || eb_code_tester == true ) {
	
	
	//
	$get_list_sitemap = '';
	
	
	
	
	
	/*
	* blog
	*/
	
	// v2
	$sql = WGR_get_sitemap_post( 'blog' );
	foreach ( $sql as $v ) {
		$get_list_sitemap .= WGR_echo_sitemap_url_node( _eb_p_link( $v->ID ), 0.3, date( $sitemap_date_format, strtotime( $v->post_modified ) ) );
	}
	
	/*
	// v1
	$sql = new WP_Query( array(
		'posts_per_page' => $limit_post_get,
//		'orderby' => 'menu_order',
		'orderby' => 'ID',
		'order' => 'DESC',
		'post_type' => 'blog',
		'post_status' => 'publish'
	));
	//print_r( $sql );
	while ( $sql->have_posts() ) : $sql->the_post();
//		print_r($sql->post);
		
		$get_list_sitemap .= WGR_echo_sitemap_url_node( _eb_p_link( $sql->post->ID ), 0.3, date( $sitemap_date_format, strtotime( $sql->post->post_modified ) ) );
	endwhile;
	*/
	
	
	
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




