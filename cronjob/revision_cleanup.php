<?php



$strCacheFilter = 'revision_cleanup';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 6 * 3600 );
if ( $check_Cleanup_cache == false ) {
	// Nếu có số lượng cụ thể -> xóa theo số lượng này (tối thiểu là 1)
	if ( $__cf_row['cf_max_revision_cleanup'] > 1 ) {
		global $wpdb;
		
		// tính tổng số revision đang có
		$strsql = _eb_q("SELECT count(ID) as c
		FROM
			`" . wp_posts . "`
		WHERE
			post_type = 'revision'");
//		print_r( $strsql );
		
		// nếu lớn hơn số revision được lưu trữ thì mới tiếp tục
		if ( ! empty( $strsql ) && $strsql[0]->c > $__cf_row['cf_max_revision_cleanup'] + 100 ) {
			$strsql = _eb_q("SELECT ID, post_type
			FROM
				`" . wp_posts . "`
			WHERE
				post_type = 'revision'
			ORDER BY
				ID DESC
			LIMIT " . $__cf_row['cf_max_revision_cleanup'] . ", 1");
//			print_r( $strsql );
			
			//
			if ( ! empty( $strsql ) && isset( $strsql[0]->ID ) ) {
				// xóa
				WGR_remove_post_by_type( $strsql[0]->post_type, 0, ' and ID < ' . $strsql[0]->ID . ' ' );
				
				//
				_eb_log_user ( 'Revision cleanup (' . $strsql[0]->ID . '): ' . $_SERVER ['REQUEST_URI'] );
			}
		}
	}
	// Nếu <= 1 -> xóa hết -> không lưu revision
	else {
		WGR_remove_post_by_type();
		
		//
		_eb_log_user ( 'Revision cleanup (ALL): ' . $_SERVER ['REQUEST_URI'] );
	}
	
	// Lưu thời gian dọn log
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}



