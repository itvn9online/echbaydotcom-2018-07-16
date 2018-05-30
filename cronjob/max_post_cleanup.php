<?php



function WGR_save_max_post_to_xml ( $type ) {
	global $__cf_row;
	global $wpdb;
	
	// tính tổng số post đang có
	$strsql = _eb_q("SELECT count(ID) as c
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = '" . $type . "'");
//		print_r( $strsql );
	
	// nếu lớn hơn số post được lưu trữ thì mới tiếp tục
	if ( ! empty( $strsql ) && $strsql[0]->c > $__cf_row['cf_max_post_cleanup'] + 50 ) {
		//
		$count_post = $strsql[0]->c;
		
		//
		$strsql = _eb_q("SELECT *
		FROM
			`" . wp_posts . "`
		WHERE
			post_type = '" . $type . "'
		ORDER BY
			ID ASC
		LIMIT 0, 500");
//		print_r( $strsql );
//		exit();
		
		//
		foreach ( $strsql as $v ) {
			// lưu trữ bài viết
			WGR_save_post_xml( $v->ID, 'eb_post_xml' );
			
			// xóa bài viết này đi
			WGR_remove_post_by_type( $v->post_type, $v->ID );
		}
		
		//
		_eb_log_user ( 'Max post (' . $type . ') cleanup (' . $count_post . '): ' . $_SERVER ['REQUEST_URI'] );
	}
}



$strCacheFilter = 'max_post_cleanup';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 6 * 3600 );
//$check_Cleanup_cache = false;
//$check_Cleanup_cache = true;
if ( $check_Cleanup_cache == false ) {
	// Nếu có số lượng cụ thể -> xóa theo số lượng này (tối thiểu là 1)
	if ( $__cf_row['cf_max_post_cleanup'] > 10 ) {
		WGR_save_max_post_to_xml( 'post' );
		WGR_save_max_post_to_xml( EB_BLOG_POST_TYPE );
	}
	
	// Lưu thời gian dọn log
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}
//exit();



