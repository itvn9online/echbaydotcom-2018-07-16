<?php
/*
Description: Lấy các sản phẩm mới nhất hoặc được đặt trạng thái là "Sản phẩm MỚI".
Tags: home new
*/




//
$home_new = '';
if ( $__cf_row['cf_num_home_new'] > 0 ) {
	$home_new = _eb_load_post( $__cf_row['cf_num_home_new'], array(
		'meta_key' => '_eb_product_status',
		'meta_value' => 2
	) );
	
	// nếu không có -> lấy sản phẩm mới nhất hoặc xếp cao nhất
	if ( $home_new == '' ) {
		$home_new = _eb_load_post( $__cf_row['cf_num_home_new'] );
	}
	
	// nếu có dữ liệu trả về
	if ( $home_new != '' ) {
		// Lấy theo mẫu của widget #home_hot
//		echo EBE_html_template( EBE_get_page_template( 'home_hot' ), array(
		echo WGR_show_home_hot( array(
//			'tmp.max_width' => '',
//			'tmp.num_post_line' => '',
			'tmp.home_hot_title' => EBE_get_lang('home_new'),
//			'tmp.description' => '',
			'tmp.home_hot' => $home_new
		) );
	}
	else {
		echo '<!-- home_new == NULL -->';
	}
}
else {
	echo '<!-- cf_num_home_new == ZERO -->';
}




