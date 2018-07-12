<?php



/*
* Link tham khảo:
* https://developers.google.com/analytics/devguides/collection/analyticsjs/enhanced-ecommerce
*/



$__cf_row ['cf_title'] = 'Đặt hàng thành công';
$group_go_to[] = ' <li><a href="./hoan-tat" rel="nofollow">' . $__cf_row ['cf_title'] . '</a></li>';





//
$__cf_row ['cf_title'] .= ', trân trọng cảm ơn bạn đã mua hàng tại ' . web_name;
$__cf_row ['cf_keywords'] = $__cf_row ['cf_title'];
$__cf_row ['cf_description'] = $__cf_row ['cf_title'];



//
$hd_id = _eb_getCucki( 'eb_cookie_order_id', 0 );
//echo $hd_id;

//$hd_mahoadon = _eb_getCucki( 'eb_cookie_order_sku' );
$hd_mahoadon = '';
//echo $hd_mahoadon;

//
$current_hd_object = '[]';

$ga_ecom_update = 0;


// facebook purchase track
//$fb_purchase_order = '';



//
$import_ecommerce_ga = "
if ( typeof ga != 'undefined' ) {
	ga('require', 'ec');
}";





if ( $hd_id > 0 ) {
	$tongtien = 0;
	
	
	
	//
	$sql = _eb_load_order( 1, array(
		'p' => $hd_id,
	) );
//	print_r( $sql );
	
	//
	/*
	if ( !isset($sql->post) || !isset($sql->post->ID) ) {
	} else {
		*/
	if ( isset($sql[0]) || isset($sql[0]->ID) ) {
//		$sql = $sql->post;
		$sql = $sql[0];
//		print_r( $sql );
		
		
		//
		$hd_mahoadon = $sql->order_sku;
		$current_hd_object = $sql->order_products;
		
		
		//
//		$fb_purchase_order = '
		$__cf_row ['cf_js_allpage'] .= '
		<script type="text/javascript">
		setTimeout(function () {
			___eb_add_convertsion_gg_fb ( ' . $hd_id . ', current_hd_object );
		}, 800);
		</script>';
	}
}





//
$__cf_row ['cf_js_allpage'] = $__cf_row ['cf_js_hoan_tat'] . "\r\n"
							. $__cf_row ['cf_js_allpage'];
//							. $__cf_row ['cf_js_allpage'] . "\r\n"
//							. $fb_purchase_order;



//
/*
$main_content = EBE_str_template ( 'hoan-tat.html', array (
	'tmp.hd_id' => $hd_id,
	'tmp.hd_mahoadon' => $hd_mahoadon,
	'tmp.cf_hotline' => $__cf_row['cf_hotline'],
), EB_THEME_PLUGIN_INDEX . 'html/' );
*/




//
$custom_lang_html = EBE_get_lang('booking_done');
// mặc định là lấy theo file HTML -> act
if ( trim( $custom_lang_html ) == 'booking_done' ) {
	$custom_lang_html = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/hoan-tat.html' );
}

//
//$main_content = EBE_html_template( EBE_get_page_template( $act ), array(
//$main_content = EBE_html_template( EBE_get_lang('booking_done'), array(
$main_content = EBE_html_template( $custom_lang_html, array(
//	'tmp.js' => '',
	'tmp.hd_id' => $hd_id,
	'tmp.hd_mahoadon' => $hd_mahoadon,
	'tmp.cf_hotline' => $__cf_row['cf_hotline'],
//	'tmp.echbay_plugin_url' => EB_URL_OF_PLUGIN,
//	'tmp.echbay_plugin_version' => date_time,
) );



// thêm mã JS vào luôn trong phần PHP, để HTML làm bản dịch
$main_content .= '<script type="text/javascript">
var current_hd_id = "' . $hd_id . '", current_hd_object = "' . $current_hd_object . '";
</script>';



