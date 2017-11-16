<?php



/*
* Tạo các bảng riêng cho plugin của echbay
*/

$strCacheFilter = 'admin-clean-log';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 24 * 3600 );
if ($check_Cleanup_cache == false) {
	
	//
	_eb_clear_all_log();
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}




