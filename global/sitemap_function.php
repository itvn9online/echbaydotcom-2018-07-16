<?php



//
function WGR_echo_sitemap_css () {
	echo '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="' . EB_URL_OF_PLUGIN . 'css/xml.css?v=' . date_time . '"?>
<!-- Sitemap content created by EchBay.com -->';
}


function WGR_echo_sitemap_node ( $loc, $lastmod ) {
	return '
<sitemap>
	<loc>' . $loc . '</loc>
	<lastmod>' . $lastmod . '</lastmod>
</sitemap>';
}


/*
* changefreq = hourly
*/
function WGR_echo_sitemap_url_node ( $loc, $priority, $lastmod, $changefreq = 'daily' ) {
	return '
<url>
	<loc>' . $loc . '</loc>
	<lastmod>' . $lastmod . '</lastmod>
	<changefreq>' . $changefreq . '</changefreq>
	<priority>' . $priority . '</priority>
</url>';
}


function WGR_echo_sitemap_image_node ( $loc, $img, $title ) {
	if ( $img == '' ) {
		return false;
	}
	
	//
	if ( substr( $img, 0, 2 ) == '//' ) {
		$img = eb_web_protocol . ':' . $img;
	}
	
	//
	return '
<url>
	<loc>' . $loc . '</loc>
	<image:image>
		<image:loc>' . $img . '</image:loc>
		<image:title><![CDATA[' . $title . ']]></image:title>
	</image:image>
</url>';
}


function WGR_get_sitemap_post ( $type = 'post', $limit = 1000 ) {
	global $wpdb;
//	echo $wpdb->posts;
	
	$sql = _eb_q("SELECT *
	FROM
		`" . $wpdb->posts . "`
	WHERE
		post_type = '" . $type . "'
		AND post_status = 'publish'
	ORDER BY
		ID DESC
	LIMIT 0, " . $limit);
//	print_r( $sql );
	
	return $sql;
}

function WGR_get_sitemap_taxonomy ( $taxx = 'category', $priority = 0.9, $cat_ids = 0 ) {
	global $wpdb;
	global $sitemap_current_time;
	
	// v1
	/*
	$categories = _eb_q("SELECT *
	FROM
		`" . $wpdb->terms . "`
	WHERE
		term_id IN ( select term_id
					from
						`" . $wpdb->term_taxonomy . "`
					where
						taxonomy = '" . $taxx . "' )
	ORDER BY
		name");
	*/
	
	// v2
	$categories = get_categories( array(
		'taxonomy' => $taxx,
		'parent' => $cat_ids
	) );
	
//	print_r( $categories );
	
	//
	$str = '';
	if ( count( $categories ) > 0 ) {
		foreach ( $categories as $cat ) {
			$str .= WGR_echo_sitemap_url_node( _eb_c_link( $cat->term_id, $taxx ), $priority, $sitemap_current_time, 'always' ) . WGR_get_sitemap_taxonomy ( $taxx, $priority, $cat->term_id );
		}
	}
	
	return $str;
}




// định dạng ngày tháng
$sitemap_date_format = 'c';
$sitemap_current_time = date( $sitemap_date_format, date_time );

// giới hạn số bài viết cho mỗi sitemap map
$limit_post_get = 1000;

// giới hạn tạo sitemap cho hình ảnh -> google nó limit 1000 ảnh nên chỉ lấy thế thôi
$limit_image_get = $limit_post_get;




//
header("Content-type: text/xml");




