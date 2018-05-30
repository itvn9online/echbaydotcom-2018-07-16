<?php



$strCacheFilter = 'max_post_cleanup';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 6 * 3600 );
if ( $check_Cleanup_cache == false ) {
	// Nếu có số lượng cụ thể -> xóa theo số lượng này (tối thiểu là 1)
	if ( $__cf_row['cf_max_post_cleanup'] > 10 ) {
		global $wpdb;
		
		// tính tổng số post đang có
		$strsql = _eb_q("SELECT count(ID) as c
		FROM
			`" . wp_posts . "`
		WHERE
			post_type = 'post'
			OR post_type = '" . EB_BLOG_POST_TYPE . "'");
//		print_r( $strsql );
		
		// nếu lớn hơn số post được lưu trữ thì mới tiếp tục
		if ( ! empty( $strsql ) && $strsql[0]->c > $__cf_row['cf_max_post_cleanup'] + 100 ) {
			$strsql = _eb_q("SELECT ID
			FROM
				`" . wp_posts . "`
			WHERE
				post_type = 'post'
				OR post_type = '" . EB_BLOG_POST_TYPE . "'
			ORDER BY
				ID ASC
			LIMIT 0, 100");
			print_r( $strsql ); exit();
			
			//
			if ( ! empty( $strsql ) && isset( $strsql[0]->ID ) ) {
				// xóa
				WGR_remove_post_by_type( $strsql[0]->post_type, 0, ' and ID < ' . $strsql[0]->ID . ' ' );
				
				//
				_eb_log_user ( 'Max post cleanup (' . $strsql[0]->ID . '): ' . $_SERVER ['REQUEST_URI'] );
			}
		}
	}
	
	// Lưu thời gian dọn log
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}



