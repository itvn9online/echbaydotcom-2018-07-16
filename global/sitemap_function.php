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

function WGR_sitemap_part_page ( $type = 'post', $file_name = 'sitemap-post', $file_2name = 'sitemap-images' ) {
	global $limit_post_get;
	global $sitemap_current_time;
	
	$count_post_post = WGR_get_sitemap_total_post( $type );
//	echo $count_post_post . '<br>' . "\n";
	
	$str = '';
	if ( $count_post_post > $limit_post_get ) {
		$j = 0;
		for ( $i = 2; $i < 100; $i++ ) {
			$j += $limit_post_get;
			
			if ( $j < $count_post_post ) {
				// cho phần bài viết
				$str .= WGR_echo_sitemap_node( web_link . $file_name . '?trang=' . $i, $sitemap_current_time );
				
				// cho phần ảnh
//				$str .= WGR_echo_sitemap_node( web_link . $file_2name . '?trang=' . $i, $sitemap_current_time );
			}
		}
	}
	
	return $str;
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

// tạo sitemap mặc định trong trường hợp không tìm thấy sitemap
function WGR_create_sitemap_default_node () {
	global $sitemap_date_format;
	
	return WGR_echo_sitemap_url_node( web_link, 1, date( $sitemap_date_format, date_time ) );
}


function WGR_echo_sitemap_image_node ( $loc, $img, $title ) {
	if ( $img == '' ) {
		return '';
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

// tạo sitemap mặc định trong trường hợp không tìm thấy sitemap
function WGR_create_sitemap_image_default_node () {
	global $__cf_row;
	
	if ( strstr( $__cf_row['cf_logo'], '//' ) == false ) {
		$__cf_row['cf_logo'] = web_link . $__cf_row['cf_logo'];
	}
	
	return WGR_echo_sitemap_image_node( web_link, $__cf_row['cf_logo'], web_name );
}


function WGR_get_sitemap_post ( $type = 'post' ) {
	global $wpdb;
	global $limit_post_get;
//	echo wp_posts;
	
	$status = 'publish';
	if ( $type == 'attachment' ) {
		$status = 'inherit';
	}
	
	// phân trang
	$trang = isset( $_GET['trang'] ) ? (int)$_GET['trang'] : 1;
	
	$totalThread = WGR_get_sitemap_total_post( $type );
	$threadInPage = $limit_post_get;
	
	$totalPage = ceil ( $totalThread / $threadInPage );
	if ( $totalPage < 1 ) {
		$totalPage = 1;
	}
	
	if ($trang > $totalPage) {
		$trang = $totalPage;
	}
	else if ( $trang < 1 ) {
		$trang = 1;
	}
	
	$offset = ($trang - 1) * $threadInPage;
	
	//
	$sql = _eb_q("SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = '" . $type . "'
		AND post_status = '" . $status . "'
	ORDER BY
		ID DESC
	LIMIT " . $offset . ", " . $threadInPage);
//	print_r( $sql );
	
	return $sql;
}

function WGR_get_sitemap_total_post ( $type = 'post' ) {
	global $wpdb;
//	echo wp_posts;
	
	$status = 'publish';
	if ( $type == 'attachment' ) {
		$status = 'inherit';
	}
	
	return _eb_c("SELECT COUNT(ID) as a
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = '" . $type . "'
		AND post_status = '" . $status . "'");
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
//	if ( count( $categories ) > 0 ) {
	if ( ! empty( $categories ) ) {
		foreach ( $categories as $cat ) {
			if ( _eb_get_cat_object( $cat->term_id, '_eb_category_hidden', 0 ) != 1 ) {
				$str .= WGR_echo_sitemap_url_node( _eb_c_link( $cat->term_id, $taxx ), $priority, $sitemap_current_time, 'always' ) . WGR_get_sitemap_taxonomy ( $taxx, $priority, $cat->term_id );
			}
		}
	}
	
	return $str;
}




// định dạng ngày tháng
$sitemap_date_format = 'c';
$sitemap_current_time = date( $sitemap_date_format, date_time );

// giới hạn số bài viết cho mỗi sitemap map
$limit_post_get = 1000;
//$limit_post_get = 10;

// giới hạn tạo sitemap cho hình ảnh -> google nó limit 1000 ảnh nên chỉ lấy thế thôi
$limit_image_get = $limit_post_get;




//
header("Content-type: text/xml");




