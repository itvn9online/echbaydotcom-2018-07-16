<?php

foreach ( $_POST as $k => $v ) {
	$_POST [$k] = trim ( strip_tags ( $v ) );
}


// url để hủy quá trình thanh toán
$url_for_payment_cancel = $web_link . 'members.php?act=billing';

// url hoàn tất quá trình thanh toán
$url_for_payment_success = $url_for_payment_cancel . '_success';



$email_payment_to = 'itvn9online@gmail.com';


$payment_method = '';
if (isset ( $_POST ['mt'] )) {
	$payment_method = $_POST ['mt'];
}



$currency_code = 'VND';
if (isset ( $_POST ['currency_code'] )) {
	$currency_code = $_POST ['currency_code'];
}


$hd_gia = $_POST ['price'];
if ( $hd_gia == 'khac' ) {
	$hd_gia = $func->number_only ($_POST['amountcustom'] );
}
$hd_gia = ( int ) $hd_gia;



$billing_amount = $hd_gia;
if ( strtolower ( $currency_code ) == 'usd' ) {
	$hd_gia = $hd_gia * $__cf_row ['cf_usd'];
}

//
if ( $hd_gia < 50000 ) {
	$func->alert('Số tiền tối thiểu cho mỗi lần nạp là 50,000đ');
}



$hd_mahoadon = $func->create_code_billing ();



//$billing_content = 'pay' . $mtv_id;
$billing_content = 'pay' . $hd_mahoadon;



$func->set_data ( array (
		'hd_mahoadon' => $hd_mahoadon,
		'hd_gia' => $hd_gia,
		'hd_content' => $billing_content,
		'hd_ngaygui' => $date_time,
		'hd_ngaythanhtoan' => $date_time,
		'hd_trangthai' => 0,
		'hd_payment' => $payment_method,
		'hd_ip' => $client_ip,
		'ht_id' => 0,
		'tv_id' => $mtv_id 
), 'tbl_in_con_voi' );



$arr_security_code = array (
		'ApiUser' => $mtv_id,
//		'ApiKey' => $func->mdnam ( $mtv_id ),
		'ApiKey' => $func->mdnam ( $hd_mahoadon ),
		'ApiCode' => $hd_mahoadon,
		'a' => '' 
);



foreach ( $arr_security_code as $k => $v ) {
	if ($v != '') {
		$url_for_payment_success .= '&' . $k . '=' . $v;
	}
}



//
$func->log_admin( 'URL success: ' . $url_for_payment_success );



//
$url_for_payment_cancel = urlencode ( $url_for_payment_cancel );
$url_for_payment_success = urlencode ( $url_for_payment_success );



$url_for_paypemt = '';
if ($payment_method == 'nl') {
	$url_for_paypemt = 'https://www.nganluong.vn/button_payment.php?';
	$arr_parameter = array (
			'receiver' => $email_payment_to,
			'product_name' => $hd_mahoadon,
			'price' => $billing_amount,
			'return_url' => $url_for_payment_success,
			'comments' => $billing_content 
	);
}
else if ($payment_method == 'bk') {
	$url_for_paypemt = 'https://www.baokim.vn/payment/product/version11?';
	
	$arr_parameter = array (
			'business' => 'itvn9online@yahoo.com',
			'product_name' => $hd_mahoadon,
			'product_price' => $billing_amount,
			'product_quantity' => 1,
			'total_amount' => $billing_amount,
			'url_detail' => $url_for_payment_cancel,
			'url_success' => $url_for_payment_success,
			'url_cancel' => $url_for_payment_cancel,
			'order_description' => $billing_content,
			'id' => '' 
	);
}
else if ($payment_method == 'pp') {
	$url_for_paypemt = 'https://www.paypal.com/cgi-bin/webscr?';
	
	$arr_parameter = array (
			'cmd' => '_xclick',
			'business' => 'itvn9online@yahoo.com',
			'item_name' => $billing_content,
			'item_number' => $hd_mahoadon,
			'amount' => $billing_amount . '.00',
			'currency_code' => 'USD',
			'return' => $url_for_payment_success,
			'cancel_return' => $url_for_payment_cancel 
	);
}
// nếu là nạp qua internet banking -> chỉ reset lại trang
else if ($payment_method == 'ib') {
//	HTAdd::domain_process_cpl ();
}
else {
	$func->alert ( 'Payment method not found' );
}



//
$str_add_to = '';
foreach ( $arr_parameter as $k => $v ) {
	$str_add_to .= '&' . $k . '=' . $v;
}
$str_add_to = substr ( $str_add_to, 1 );
$str_add_to = str_replace ( ' ', '', $str_add_to );
$url_for_paypemt .= $str_add_to;


die ( header ( 'Location:' . $url_for_paypemt ) );
exit ();



