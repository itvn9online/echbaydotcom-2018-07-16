<?php





function echo_sitemap_node ( $loc, $priority, $lastmod ) {
//	global $get_list_sitemap;
	
	return '
<url>
	<loc>' . $loc . '</loc>
	<lastmod>' . $lastmod . '</lastmod>
	<changefreq>hourly</changefreq>
	<priority>' . $priority . '</priority>
</url>';
}






$strCacheFilter = 'sitemap';
$get_list_sitemap = _eb_get_static_html ( $strCacheFilter, '', '', 3 * 3600 );
//$get_list_sitemap = false;
if ($get_list_sitemap == false) {
	
	
	//
	$get_list_sitemap = '';
//	$sitemap_date_format = 'Y-m-d';
	$sitemap_date_format = 'c';
	$limit_post_get = 1500;
//	$limit_post_get = 10;
	$sitemap_current_time = date( $sitemap_date_format, date_time );
	
	
	
	/*
	* home
	*/
	$get_list_sitemap .= echo_sitemap_node( web_link, 1.0, $sitemap_current_time );
	
	
	
	
	/*
	* catagory
	*/
	$categories = _eb_q("SELECT *
		FROM
			" . $wpdb->terms . "
		WHERE
			term_id IN ( select term_id
						from
							" . $wpdb->term_taxonomy . "
						where
							taxonomy = 'category' )
		ORDER BY
			name");
//	print_r( $categories );
	foreach ( $categories as $cat ) {
		$get_list_sitemap .= echo_sitemap_node( _eb_c_link( $cat->term_id ), 0.9, $sitemap_current_time );
	}
	
	
	// blog
	$categories = _eb_q("SELECT *
		FROM
			" . $wpdb->terms . "
		WHERE
			term_id IN ( select term_id
						from
							" . $wpdb->term_taxonomy . "
						where
							taxonomy = 'blogs' )
		ORDER BY
			name");
//	print_r( $categories );
	foreach ( $categories as $cat ) {
		$get_list_sitemap .= echo_sitemap_node( _eb_c_link( $cat->term_id ), 0.7, $sitemap_current_time );
	}
	
	
	
	
	
	/*
	* details
	*/
	$sql = new WP_Query( array(
		'posts_per_page' => $limit_post_get,
		'orderby' => 'menu_order',
		'order' => 'DESC',
		'post_type' => 'post',
	));
	//print_r( $sitemap_post );
	while ( $sql->have_posts() ) : $sql->the_post();
//		print_r($sql->post);
		
		$get_list_sitemap .= echo_sitemap_node( get_the_permalink( $sql->post->ID ), 0.6, date( $sitemap_date_format, strtotime( $sql->post->post_modified ) ) );
	endwhile;
	
	
	
	
	
	/*
	* blog
	*/
	$sql = new WP_Query( array(
		'posts_per_page' => $limit_post_get,
		'orderby' => 'menu_order',
		'order' => 'DESC',
		'post_type' => 'blog',
	));
	//print_r( $sql );
	while ( $sql->have_posts() ) : $sql->the_post();
		$get_list_sitemap .= echo_sitemap_node( get_the_permalink( $sql->post->ID ), 0.3, date( $sitemap_date_format, strtotime( $sql->post->post_modified ) ) );
	endwhile;
	
	
	
	//
	$get_list_sitemap = trim($get_list_sitemap);
	
	// lưu cache
	_eb_get_static_html ( $strCacheFilter, $get_list_sitemap, '', 1 );
	
	
}






/*
* set XML type
*/
header("Content-type: text/xml");



// print
/*
// v1
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
' . $get_list_sitemap . '
</urlset>
<!-- Sitemap content by EchBay.com -->';
*/



// v2
echo '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="' . EB_URL_OF_PLUGIN . 'css/xml.css?v=' . date_time . '"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
' . $get_list_sitemap . '
</urlset>
<!-- Sitemap content by EchBay.com -->';



exit();




