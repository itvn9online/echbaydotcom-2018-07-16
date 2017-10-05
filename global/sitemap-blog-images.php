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
	* media
	*/
	
	// v2
	$sql = WGR_get_sitemap_post( 'blog' );
	foreach ( $sql as $v ) {
		$get_list_sitemap .= WGR_echo_sitemap_image_node( _eb_p_link( $v->ID ), _eb_get_post_img( $v->ID ), $v->post_title );
	}
	
	/*
	// v1
	$sql = new WP_Query( array(
		'posts_per_page' => $limit_image_get,
//		'orderby' => 'menu_order',
		'orderby' => 'ID',
		'order' => 'DESC',
		'post_type' => 'blog',
		'post_status' => 'publish'
	));
	//print_r( $sql );
	while ( $sql->have_posts() ) : $sql->the_post();
//		print_r($sql->post);
		
		$get_list_sitemap .= WGR_echo_sitemap_image_node( _eb_p_link( $sql->post->ID ), _eb_get_post_img( $sql->post->ID ), $sql->post->post_title );
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
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
' . $get_list_sitemap . '
</urlset>';



exit();




