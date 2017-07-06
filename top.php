<?php

// top menu dưới dạng widget
//$eb_top_widget = _eb_echbay_sidebar( 'eb_top_global', 'eb-widget-top cf', 'div', 1, 0, 1 );

// nếu không có nội dung trong widget -> lấy theo thiết kế của file
//if ( $eb_top_widget == '' ) {
if ( $__cf_row['cf_using_top_default'] == 1 ) {
//if ( count( $arr_includes_top_file ) > 0 ) {
//	echo $eb_top_widget;
	
//	include EB_THEME_PLUGIN_INDEX . 'top_default.php';
	
	//
	foreach ( $arr_includes_top_file as $v ) {
		include $v;
	}
}
