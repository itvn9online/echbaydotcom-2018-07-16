<?php



//print_r( $_POST );
//print_r( $_GET );
//exit();
$_POST = EBE_stripPostServerClient ();
//print_r( $_POST );



//
function ket_thuc_qua_trinh_dat_hang ( $hd_id, $hd_mahoadon, $m ) {
?>
<!-- INFO BOOKING -->
<script type="text/javascript">
var my_hd_id = '<?php echo $hd_id; ?>',
	my_hd_mahoadon = '<?php echo $hd_mahoadon; ?>',
	my_message = '<?php echo $m; ?>';

//
parent._global_js_eb.cpl_cart( my_hd_id, my_hd_mahoadon, my_message );
</script>
<?php
	
	
	//
	exit();
}




//
if ( ! isset ( $_POST ['t_muangay'] ) ) {
	_eb_alert( 'Đầu vào không hợp lệ' );
}



//
$strFilter = "";
$arr = $_POST['t_muangay'];
$arr_shop_cart = array();
$arr_shop_cart_size = array();
$arr_shop_cart_price = array();
foreach ( $arr as $k => $v ) {
	// nếu có số lượng
	if ( isset( $_POST['t_soluong'][$v] ) > 0 ) {
		$strFilter .= "," . $v;
		
		$arr_shop_cart[$v] = (int) $_POST['t_soluong'][$v];
		$arr_shop_cart_size[$v] = isset( $_POST['t_size'][$v] ) ? $_POST['t_size'][$v] : '';
		$arr_shop_cart_price[$v] = isset( $_POST['t_new_price'][$v] ) ? $_POST['t_new_price'][$v] : 0;
	}
}
//echo $strFilter . "\n";
//print_r( $arr_shop_cart );
//print_r( $arr_shop_cart_size );
//exit();


//
if ( $strFilter == "" ) {
	_eb_alert( 'Không tồn tại giỏ hàng cần thiết' );
}


//
$strFilter = substr ( $strFilter, 1 );
//echo $strFilter . "\n";
//exit();


//
$t_email = strtolower ( trim ( $_POST ['t_email'] ) );

if ( _eb_check_email_type ( $t_email ) != 1 ) {
	_eb_alert( 'Email không đúng định dạng' );
}


//
$t_ten = trim ( $_POST ['t_ten'] );
$t_dienthoai = trim ( $_POST ['t_dienthoai'] );
$t_diachi = trim ( $_POST ['t_diachi'] );
$t_ghichu = trim ( $_POST ['t_ghichu'] );


//echo $tv_id . "\n";
//exit();

//
//exit();



//
//echo date( 'r', date_time ) . "\n";


// nếu đang là tài khoản admin -> luôn luôn tạo tài khoản mới
if ( current_user_can('delete_posts') ) {
	
	$tv_id = _eb_create_account_auto ( array(
		'tv_matkhau' => '',
		'tv_hoten' => $t_ten,
		'tv_dienthoai' => $t_dienthoai,
		'user_name' => $t_dienthoai,
		'tv_diachi' => $t_diachi,
		'tv_email' => $t_email
	) );
	
	// kiểm tra lại việc tạo tài khoản
	if ( $tv_id <= 0 ) {
		_eb_alert('Không xác định được tài khoản khách hàng');
	}
	
}
// nếu tài khoản thông thường -> sẽ kiểm tra nhiều thứ hơn
else {
	
	//
	if ( mtv_id > 0 ) {
		$tv_id = mtv_id;
	} else {
		
		$tv_id = _eb_create_account_auto ( array(
			'tv_matkhau' => '',
			'tv_hoten' => $t_ten,
			'tv_dienthoai' => $t_dienthoai,
			'user_name' => $t_dienthoai,
			'tv_diachi' => $t_diachi,
			'tv_email' => $t_email
		) );
		
		// kiểm tra lại việc tạo tài khoản
		if ( $tv_id <= 0 ) {
			_eb_alert('Không xác định được tài khoản khách hàng');
		}
		
	}
	
	
	// kiểm tra lần gừi đơn trước đó, nếu mới gửi thì bỏ qua
	$strsql = _eb_q("SELECT *
	FROM
		`eb_in_con_voi`
	WHERE
		tv_id = " . $tv_id . "
	ORDER BY
		order_id DESC
	LIMIT 0, 1" );
//	print_r( $strsql );
//	echo count($strsql);
	if ( count($strsql) > 0 ) {
		$strsql = $strsql[0];
//		print_r( $strsql );
//		exit();
		
		// lấy thời gian gửi đơn hàng trước đó, mỗi đơn cách nhau tầm 5 phút
		$lan_gui_don_truoc = $strsql->order_time;
//		echo date( 'r', $lan_gui_don_truoc ) . "\n";
//		echo date_time - $lan_gui_don_truoc . "\n";
		
		// giãn cách gửi đơn là 5 phút
		if ( date_time - $lan_gui_don_truoc < 300 ) {
			ket_thuc_qua_trinh_dat_hang( $strsql->order_id, $strsql->order_sku, 'Cảm ơn bạn, chúng tôi đang tiếp nhận và xử lý đơn hàng của bạn.' );
		}
	}
}
//exit();




// Hủy đơn hàng nếu thiếu dữ liệu đầu vào
$hd_trangthai = 0;
if (! isset ( $_POST ['hd_products_info'] )) {
	$_POST ['hd_products_info'] = '';
	
	$hd_trangthai = -1;
}

if (! isset ( $_POST ['hd_customer_info'] )) {
	$_POST ['hd_customer_info'] = '';
	
	$hd_trangthai = -1;
}
//exit();



//
$product_js_list = trim ( $_POST ['hd_products_info'] );
$hd_mahoadon = date ( 'mdhis', $date_time ) . 'E' . $tv_id;





// thông tin đơn hàng
$arr = array(
	'order_sku' => $hd_mahoadon,
	'order_products' => $product_js_list,
	'order_customer' => trim( $_POST ['hd_customer_info'] ),
//	'order_agent' => trim( $_POST ['hd_customer_info'] ),
	'order_ip' => $client_ip,
	'order_time' => date_time,
	'order_status' => $hd_trangthai,
	'tv_id' => $tv_id,
);
//print_r( $arr ); exit();


$hd_id = EBE_set_order( $arr );
if ( $hd_id == 0 ) {
//	EBE_tao_bang_hoa_don_cho_echbay_wp();
	
	_eb_alert('Lỗi gửi chi tiết đơn hàng');
}
//echo $hd_id . "\n";


//exit();



// lấy danh sách sản phẩm để tạo email
$sql = _eb_load_post_obj( 100, array(
	/*
	'post__in' => array(
		249,
		99
	)
	*/
	'post__in' => explode( ',', $strFilter )
) );

//
$product_list = '';

//$product_js_list = '';

$tong_tien = 0;
while ( $sql->have_posts() ) {
	
	$sql->the_post();
	
	$chitiet = $sql->post;
//	print_r( $chitiet );
	
	//
	EBE_set_details_order( 'product_id', $chitiet->ID, $hd_id );
	
	//
//	$trv_giaban = _eb_float_only( _eb_get_post_meta( $chitiet->ID, '_eb_product_oldprice', true ) );
	$trv_giaban = _eb_float_only( _eb_get_post_object( $chitiet->ID, '_eb_product_oldprice' ) );
//	$trv_giamoi = _eb_float_only( _eb_get_post_meta( $chitiet->ID, '_eb_product_price', true ) );
	$trv_giamoi = _eb_float_only( _eb_get_post_object( $chitiet->ID, '_eb_product_price' ) );
	$cthd_soluong = $arr_shop_cart [$chitiet->ID];
	
	// nếu có giá riêng theo từng size hoặc màu
	$gia_rieng_theo_size = '';
	if ( $arr_shop_cart_price [$chitiet->ID] > 0 ) {
		$gia_rieng_theo_size = 'Giá riêng theo size: <strong>' . number_format( $arr_shop_cart_price [$chitiet->ID] ) . '</strong>đ<br>';
	}
	
	//
	$total_line = $trv_giamoi * $cthd_soluong;
	$tong_tien += $total_line;
	
	//
	$trv_tietkiem = $trv_giaban - $trv_giamoi;
	$trv_khuyenmai = 0;
	if ( $trv_giamoi > 0 && $trv_giaban > $trv_giamoi ) {
		$trv_khuyenmai = 100 - intval ( $trv_giamoi * 100 / $trv_giaban );
	}
	
	//
//	$masanpham = _eb_get_post_meta( $chitiet->ID, '_eb_product_sku', true );
	$masanpham = _eb_get_post_object( $chitiet->ID, '_eb_product_sku' );
	if ( $masanpham == '' ) {
		$masanpham = $chitiet->ID;
	}
//	$trv_color = _eb_get_post_meta( $chitiet->ID, '_eb_product_color', true );
	$trv_color = _eb_get_post_object( $chitiet->ID, '_eb_product_color' );
	
	//
	$product_list .= 'Mã sản phẩm: <strong>' . $masanpham . '</strong><br>
Tên sản phẩm: <a href="' . web_link . '?p=' . $chitiet->ID . '" target="_blank">' . $chitiet->post_title . '</a><br>
Size: ' . $arr_shop_cart_size [$chitiet->ID] . '<br>
Màu sắc: ' . $trv_color . '<br>
Giá cũ: ' . number_format ( $trv_giaban ) . 'đ<br>
Giá mới: <strong>' . number_format ( $trv_giamoi ) . '</strong>đ<br>
' . $gia_rieng_theo_size . '
GIẢM: ' . $trv_khuyenmai . '% (' . number_format ( $trv_tietkiem ) . 'đ)<br>
Số lượng: ' . $cthd_soluong . '<br>
Cộng: ' . number_format ( $total_line ) . 'đ<br>
--------------------------------------------<br>';
	
	//
	/*
	$product_js_list .= ',{
		"id" : "' . $chitiet->ID . '",
		"name" : "' . str_replace( '"', '&quot;', $chitiet->post_title ) . '",
		"size" : "' . str_replace( '"', '&quot;', $arr_shop_cart_size [$chitiet->ID] ) . '",
		"color" : "' . str_replace( '"', '&quot;', $trv_color ) . '",
		"old_price" : "' . $trv_giaban . '",
		"price" : "' . $trv_giamoi . '",
		"quan" : "' . $cthd_soluong . '",
		"sku" : "' . $masanpham . '"
	}';
	*/
}
//echo $product_list . "\n";
//exit();
$product_list = _eb_del_line( $product_list );
EBE_set_details_order( 'product_list', $product_list, $hd_id );
//echo $product_list . "\n";
//exit();

//echo $product_js_list . "\n";
//$product_js_list = substr( _eb_del_line( $product_js_list ), 1 );




$arr = array(
	'tv_email' => $t_email,
	'tv_hoten' => $t_ten,
	'tv_dienthoai' => $t_dienthoai,
	'tv_diachi' => $t_diachi
);
//print_r( $arr );
foreach ( $arr as $k => $v ) {
	$v = trim( $v );
	
	if ( $v != '' ) {
		EBE_set_details_order( $k, $v, $hd_id );
	}
}
//_eb_alert($str_for_custom_order);
//exit();





// Gửi email thông báo
$custom_lang_html = EBE_get_lang('booking_mail');
// mặc định là lấy theo file HTML -> act
if ( trim( $custom_lang_html ) == 'booking_mail' ) {
	$custom_lang_html = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/booking.html' );
}

//
//$message = EBE_str_template ( 'html/mail/booking.html', array (
$message = EBE_html_template( $custom_lang_html, array(
		'tmp.web_link' => web_link,
		'tmp.t_ten' => $t_ten == '' ? $t_email : $t_ten,
		
		'tmp.date_oder' => date ( 'd-m-Y', $date_time ),
		'tmp.hd_id' => $hd_id,
		'tmp.hd_mahoadon' => $hd_mahoadon,
		
		'tmp.t_diachi' => $t_diachi,
		'tmp.t_ghichu' => $t_ghichu,
		'tmp.t_dienthoai' => $t_dienthoai,
		'tmp.t_email' => $t_email,
		'tmp.t_amount' => number_format ( $tong_tien ),
		'tmp.web_name' => $web_name,
		'tmp.product_list' => $product_list 
//), EB_THEME_PLUGIN_INDEX );
) );
//echo $message . '<br>'; exit();

//
$mail_title = 'Gui ban thong tin don hang: ' . $hd_mahoadon;



// gửi email cho admin
$mail_to_admin = $__cf_row ['cf_email'];
if ($__cf_row ['cf_email_note'] != '') {
	$mail_to_admin = $__cf_row ['cf_email_note'];
}



$bcc_email = '';
if (strstr ( $t_email, '@gmail.com' ) == true
|| strstr ( $t_email, '@yahoo.' ) == true
|| strstr ( $t_email, '@hotmail.com' ) == true) {
//	if ( _eb_check_email_type( $t_email ) == 1 ) {
		$bcc_email = $t_email;
//		_eb_send_email( $t_email, $mail_title, $message, '', $mail_to_admin );
//	}
}




// -> ép buộc sử dụng hàm mail mặc định
//$__cf_row ['cf_sys_email'] = 0;

//_eb_send_email ( $mail_to_admin, $mail_title, $message, '', $bcc_email );

// lưu nội dung vào cache rồi thực hiện chức năng gửi mail sau
$content_for_cache_mail = '<mail_to_admin>' . $mail_to_admin . '</mail_to_admin>
<mail_title>' . $mail_title . '</mail_title>
<message>' . $message . '</message>
<bcc_email>' . $bcc_email . '</bcc_email>';

_eb_create_file( EB_THEME_CACHE . 'booking_mail/' . $hd_id . '.txt', $content_for_cache_mail );

if ( is_dir( EB_THEME_CACHE . 'booking_mail_cache' ) ) {
	_eb_create_file( EB_THEME_CACHE . 'booking_mail_cache/' . $hd_id . '.txt', $content_for_cache_mail );
}




//
$m = 'Cảm ơn bạn, thông tin đơn hàng của bạn đã được gửi đi.';




//
ket_thuc_qua_trinh_dat_hang( $hd_id, $hd_mahoadon, $m );




