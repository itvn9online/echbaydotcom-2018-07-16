<?php
/*
Description: Lấy các sản phẩm mới nhất hoặc được đặt trạng thái là "Sản phẩm HOT".
Tags: home hot
*/




//
if ( $__cf_row['cf_num_home_hot'] > 0 ) {
	$home_hot = _eb_load_post( $__cf_row['cf_num_home_hot'], array(
		'meta_key' => '_eb_product_status',
		'meta_value' => 1
	) );
	
	// nếu không có -> lấy sản phẩm mới nhất hoặc xếp cao nhất
	if ( $home_hot == '' ) {
		$home_hot = _eb_load_post( $__cf_row['cf_num_home_hot'] );
	}
	
	// nếu có dữ liệu trả về
	if ( $home_hot != '' ) {
		// Lấy theo mẫu của widget #home_hot
//		echo EBE_html_template( EBE_get_page_template( 'home_hot' ), array(
		echo WGR_show_home_hot( array(
//			'tmp.max_width' => '',
//			'tmp.num_post_line' => '',
			'tmp.home_hot_title' => EBE_get_lang('home_hot'),
//			'tmp.home_hot_more' => '',
//			'tmp.description' => '',
			'tmp.home_hot' => $home_hot
		) );
	}
	else {
		echo '<!-- home_hot == NULL -->';
	}
}
else {
	echo '<!-- cf_num_home_hot == ZERO -->';
}




