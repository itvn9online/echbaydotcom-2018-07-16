<?php



// các function cho phần quick search
function WGR_quick_search_get_js_post ( $type = 'post', $limit_post_get = 1000 ) {
	global $wpdb;
	
	//
	$sql = _eb_q("SELECT *
	FROM
		`" . $wpdb->posts . "`
	WHERE
		post_type = '" . $type . "'
		AND post_status = 'publish'
	ORDER BY
		menu_order DESC,
		ID DESC
	LIMIT 0, " . $limit_post_get);
	print_r( $sql );
}



// tạo file javascript
header("Content-Type: application/javascript");



/* lấy toàn bộ danh sách các category, tag để phục vụ cho module tìm kiếm nhanh */
echo 'var eb_site_group=[' . _eb_get_full_category_v2 () . '];' . "\n";

echo 'var eb_tags_group=[' . _eb_get_full_category_v2 ( 0, 'post_tag' ) . '];' . "\n";

echo 'var eb_options_group=[' . _eb_get_full_category_v2 ( 0, 'post_options' ) . '];' . "\n";

echo 'var eb_blog_group=[' . _eb_get_full_category_v2 ( 0, EB_BLOG_POST_LINK ) . '];' . "\n";

//
WGR_quick_search_get_js_post();





exit();




