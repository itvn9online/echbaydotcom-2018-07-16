<?php



// chỉ tiếp tục khi tài khoản có quyền admin
if ( ! current_user_can('delete_posts') ) {
	die('Permission ERROR!');
}



//
$id = ( isset ( $_GET['order_id'] ) ) ? (int) $_GET['order_id'] : 0;
if ( $id <= 0 ) {
	die('order_id not set zero!');
}


// sử dụng file này để load chi tiết đơn hàng -> dùng chung
include ECHBAY_PRI_CODE . 'order_details_load.php';




//
_eb_log_admin_order( 'In đơn hàng', $post->order_id );



//
$str_ngay = date ( 'd-m-Y', date_time );
$str_ngay = explode ( '-', $str_ngay );

//
$str_ngaygui = date ( 'd-m-Y', $post->order_time );
$str_ngaygui = explode ( '-', $str_ngaygui );

//
/*
$eb_user_info = wp_get_current_user();
print_r( $eb_user_info );

//
echo get_the_author_meta( 'first_name', mtv_id );
*/




//
$print_type = 'print_a5_order';
if ( isset( $_GET['f'] ) && $_GET['f'] != '' ) {
	$print_type = trim( $_GET['f'] );
}



//
$main_content = str_replace( '{tmp.print_content}', EBE_get_page_template( $print_type ), EBE_get_page_template( 'print_order' ) );




// tham số theo hóa đơn
//$main_content = EBE_html_template( EBE_get_page_template( $print_type ), array(
$main_content = EBE_html_template( $main_content, array(
	'tmp.js' => trim( '
var order_details_arr_cart_product_list = "' . $post->order_products . '",
	order_details_arr_cart_customer_info = "' . $post->order_customer . '",
	order_id = "' . $id . '",
	print_type = "' . $print_type . '";
	' ),
	
	'tmp.head' => WGR_show_header_favicon( web_link . eb_default_vaficon . '?v=' . date_time ) . trim( '
<link rel="stylesheet" href="' . EB_URL_OF_PLUGIN . 'css/d.css?v=' . date_time . '" type="text/css">
<link rel="stylesheet" href="' . EB_URL_OF_PLUGIN . 'css/d2.css?v=' . date_time . '" type="text/css">
<script type="text/javascript" src="' . EB_URL_OF_PLUGIN . 'javascript/eb.js?v=' . date_time . '"></script>
<script type="text/javascript" src="' . EB_URL_OF_PLUGIN . 'outsource/javascript/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="' . EB_URL_OF_PLUGIN . 'outsource/javascript/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="' . EB_URL_OF_PLUGIN . 'outsource/javascript/jquery-migrate-3.0.0.min.js"></script>
	' ),
	'tmp.id' => $id,
	
	// thông tin đơn
	'tmp.hd_mahoadon' => $post->order_sku,
	
	// ngày hiện tại
	'tmp.dd' => $str_ngay [0],
	'tmp.mm' => $str_ngay [1],
	'tmp.yy' => $str_ngay [2],
	
	// ngày gửi đơn
	'tmp.ngaygui' => $str_ngaygui [0],
	'tmp.thanggui' => $str_ngaygui [1],
	'tmp.namgui' => $str_ngaygui [2],
	
	// dữ liệu khác
	'tmp.str_email' => $__cf_row['cf_email'] . ' <span style="margin:0 12px">-</span> Website: ' . str_replace ( '/', '', str_replace ( 'www.', '', $_SERVER['HTTP_HOST'] ) ),
	'tmp.captcha' => _eb_mdnam( $id ),
	'tmp.echbaydotcom_url' => EB_URL_OF_PLUGIN,
	'tmp.billing_custom_style' => '<style>' . EBE_get_lang('billing_custom_style') . '</style>',
	
	//
//	'tmp.tv_hoten' => get_the_author_meta( 'first_name', mtv_id ) . ' ' . get_the_author_meta( 'last_name', mtv_id ),
	'tmp.tv_hoten' => get_the_author_meta( 'first_name', mtv_id ),
) );



// các tham số trong config
foreach ( $__cf_row as $k => $v ) {
	$main_content = str_replace( '{tmp.' . $k . '}', $v, $main_content );
}



//
echo $main_content;





//
exit();


