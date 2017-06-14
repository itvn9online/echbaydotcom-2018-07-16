<?php



//
print_r($_POST); exit();



//
$order_id = (int)$_POST['order_id'];
$order_excerpt = stripslashes( trim( $_POST['order_excerpt'] ) );
$hd_trangthai = (int)$_POST['t_trangthai'];



//
$arr = array(
	'ID' => $order_id,
	'post_excerpt' => $order_excerpt,
	'meta_input' => array(
		'__eb_hd_trangthai' => $hd_trangthai,
	),
);
//print_r($arr);
$post_id = wp_update_post( $arr, true );
//echo $post_id . '<br>';
if ( is_wp_error($post_id) ) {
	print_r( $post_id ) . '<br>';
	
	$errors = $post_id->get_error_messages();
	foreach ($errors as $error) {
		echo $error . '<br>' . "\n";
	}
	
	//
	_eb_alert('Lỗi cập nhật chi tiết đơn hàng');
}




//
_eb_log_admin( 'Cập nhật đơn hàng #' . $order_id );

//
_eb_alert('Cập nhật thông tin đơn hàng thành công');




