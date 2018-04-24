<?php



//
//print_r($_POST);
//exit();



//
$order_id = (int)$_POST['order_id'];
$order_products = stripslashes( trim( $_POST['order_products'] ) );
$order_customer = stripslashes( trim( $_POST['order_customer'] ) );
$order_status = (int)$_POST['t_trangthai'];
$order_old_type = (int)$_POST['order_old_type'];



// nếu đây là kiểu dữ liệu cũ -> chuyển đổi sang kiểu mới
if ( $order_old_type > 0 ) {
	
	//
	$hd_mahoadon = '';
	$order_ip = $client_ip;
	$order_time = date_time;
	
	//
	$sql = _eb_load_order_v1( 1, array(
		'p' => $order_id,
	) );
	if ( count($sql) > 0 ) {
		$sql = $sql[0];
//		print_r( $sql );
		
		//
		$hd_mahoadon = $sql->post_title;
		$order_time = strtotime( $sql->post_date );
	}
	else {
		_eb_alert('Order object not found');
	}
	
	
	
	// xóa đơn hàng ở định dạng cũ đi
	$sql = "UPDATE `" . wp_posts . "`
	SET
		post_type = 'shop_order_xoa'
	WHERE
		ID = " . $order_id;
//	echo $sql . "\n";
	_eb_q( $sql, 0 );
	
	
	
	
	// thông tin đơn hàng
	$arr = array(
		'order_id' => $order_id,
		'order_sku' => $hd_mahoadon,
		'order_products' => trim( $_POST ['order_products'] ),
		'order_customer' => trim( $_POST ['order_customer'] ),
		'order_ip' => $order_ip,
		'order_time' => $order_time,
		'order_status' => $order_status,
		'tv_id' => $order_old_type,
	);
//	print_r( $arr ); exit();
	
	
	$hd_id = EBE_set_order( $arr );
	if ( $hd_id == 0 ) {
		_eb_alert('Lỗi gửi chi tiết đơn hàng');
	}
//	echo $hd_id . "\n";
	
	
	//
	$arr = array(
		'tv_hoten' => trim( $_POST['t_ten'] ),
		'tv_dienthoai' => trim( $_POST['t_dienthoai'] ),
		'tv_diachi' => trim( $_POST['t_diachi'] )
	);
	//print_r( $arr );
	foreach ( $arr as $k => $v ) {
		$v = trim( $v );
		
		if ( $v != '' ) {
			EBE_set_details_order( $k, $v, $hd_id );
		}
	}
	
	// tải lại trang hóa đơn
	die ( '<script type="text/javascript">
	parent.window.location = parent.window.location.href.split("&order_old_type=")[0];
	</script>' );
	
	exit();
	
}





$sql = "UPDATE eb_in_con_voi
	SET
		order_products = '" . $order_products . "',
		order_customer = '" . $order_customer . "',
		order_update_time = " . date_time . ",
		order_status = " . $order_status . "
	WHERE
		order_id = " . $order_id;
//echo $sql . "\n";
_eb_q( $sql, 0 );
//exit();



//
$arr = array(
	'tv_hoten' => trim( $_POST['t_ten'] ),
	'tv_dienthoai' => trim( $_POST['t_dienthoai'] ),
	'tv_diachi' => trim( $_POST['t_diachi'] )
);
//print_r( $arr );
foreach ( $arr as $k => $v ) {
	EBE_update_details_order( $k, $order_id, trim( $v ) );
}




//
_eb_log_admin_order( 'Cập nhật đơn hàng #' . $order_id . ' (' . ( isset( $arr_hd_trangthai[ $order_status ] ) ? $arr_hd_trangthai[ $order_status ] : 'NULL' ) . ')', $order_id );

//
_eb_alert('Cập nhật thông tin đơn hàng thành công');




