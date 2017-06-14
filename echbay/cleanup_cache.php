<?php

// set giãn cách xóa cache nếu chưa có
if ( ! isset( $_GET['time_auto_cleanup_cache'] ) ) {
	$_GET['time_auto_cleanup_cache'] = 120;
}



$strCacheFilter = 'cleanup_cache';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', $_GET['time_auto_cleanup_cache'] );
if ($check_Cleanup_cache == false) {
	_eb_remove_ebcache_content ();
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
}



// in thông báo nếu là xóa cache thủ công
if ( isset( $_GET['tab'] ) ) {
//	echo '<p>Xóa bộ nhớ tạm thành công!</p>';
	
	_eb_alert('Xóa bộ nhớ tạm thành công!');
}



