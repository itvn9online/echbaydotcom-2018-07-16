<?php



/*
* Dọn dẹp rác định kỳ, giúp cho website luôn nhanh và mượt
*/



// LOG
$strCacheFilter = 'auto-clean-log';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 3600 );
if ($check_Cleanup_cache == false) {
	
	//
	_eb_clear_all_log();
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}



// 404 MONITOR
$strCacheFilter = 'auto-clean-monitor';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 3600 );
if ($check_Cleanup_cache == false) {
	
	//
	$count_monitor = _eb_c("SELECT COUNT(meta_id) AS c
	FROM
		`" . wp_termmeta . "`
	WHERE
		term_id = " . eb_log_404_id_postmeta . "
		AND meta_value = 1");
//	print_r( $count_monitor );
	if ( $count_monitor > 500 ) {
		_eb_q("DELETE
		FROM
			`" . wp_termmeta . "`
		WHERE
			term_id = " . eb_log_404_id_postmeta . "
			AND meta_value = 1", 0);
	}
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}




