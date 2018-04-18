<?php



// kiểu dữ liệu cũ hoặc mới
$order_old_type = 0;



//
$sql = _eb_load_order( 1, array(
	'p' => $id,
) );
//print_r( $sql );

//
//if ( isset($sql[0]) ) {
if ( count($sql) > 0 ) {
	$sql = $sql[0];
	
	$sql->post_excerpt = '';
} else {
	// v1
	if ( isset( $_GET['order_old_type'] ) ) {
		$sql = _eb_load_order_v1( 1, array(
			'p' => $id,
		) );
	}
//	print_r( $sql );
	
	if ( count($sql) > 0 ) {
		$sql = $sql[0];
//		print_r( $sql );
		
		// chuyển định dạng sang kiểu đơn mới
		$sql->order_id = $sql->ID;
		
//		$sql->order_products = $sql->post_excerpt;
//		$sql->order_customer = $sql->post_excerpt;
		$sql->order_products = '';
		$sql->order_customer = '';
		
		$sql->tv_id = $sql->post_author;
		$sql->order_sku = $sql->post_title;
		$sql->order_time = strtotime( $sql->post_date );
//		$sql->order_status = get_post_meta( $sql->ID, '__eb_hd_trangthai', true );
		$sql->order_status = _eb_get_post_object( $sql->ID, '__eb_hd_trangthai' );
		$sql->order_ip = '';
//		print_r( $sql );
		
		//
		$order_old_type = $sql->post_author;
	}
	else {
		die('<h1>Order object not found</h1>');
	}
}

//if ( !isset($sql->post) || !isset($sql->post->ID) ) {
//if ( ! isset($sql->ID) ) {
if ( ! isset($sql->order_id) ) {
	die('<h1>Order details not found</h1>');
}

//
//$post = $sql[0]->post;
$post = $sql;
//print_r( $post );



// in dữ liệu TEST nếu là admin
if ( current_user_can('delete_posts') ) {
	include ECHBAY_PRI_CODE . 'order_details_test.php';
}



