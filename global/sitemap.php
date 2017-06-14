<?php





function echo_sitemap_node ( $loc, $priority ) {
	global $get_list_sitemap;
	
	$get_list_sitemap .= '
<url>
	<loc>' . $loc . '</loc>
	<lastmod>' . date_server . '</lastmod>
	<changefreq>hourly</changefreq>
	<priority>' . $priority . '</priority>
</url>';
}






$strCacheFilter = 'sitemap';
$get_list_sitemap = _eb_get_static_html ( $strCacheFilter, '', '', 3600 );
if ($get_list_sitemap == false) {
	
	
	
	/*
	* home
	*/
	echo_sitemap_node( web_link, 1.0 );
	
	
	
	
	/*
	* cat
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
	//print_r( $categories );
	foreach ( $categories as $cat ) {
		echo_sitemap_node( _eb_c_link( $cat->term_id ), 0.9 );
	}
	
	
	
	
	
	/*
	* details
	*/
	$sql = new WP_Query( array(
		'posts_per_page' => 1500,
		'orderby' => 'menu_order',
		'order' => 'DESC',
		'post_type' => 'post',
	));
	//print_r( $sitemap_post );
	while ( $sql->have_posts() ) : $sql->the_post();
		echo_sitemap_node( get_the_permalink( $sql->post->ID ), 0.6 );
	endwhile;
	
	
	
	
	
	/*
	* blog
	*/
	$sql = new WP_Query( array(
		'posts_per_page' => 1500,
		'orderby' => 'menu_order',
		'order' => 'DESC',
		'post_type' => 'blog',
	));
	//print_r( $sql );
	while ( $sql->have_posts() ) : $sql->the_post();
		echo_sitemap_node( get_the_permalink( $sql->post->ID ), 0.3 );
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
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
' . $get_list_sitemap . '
</urlset>';



exit();




