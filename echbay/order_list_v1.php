<?php





// tạo bảng hóa đơn nếu chưa có
$strCacheFilter = 'update_order_table';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 6 * 3600 );
if ($check_Cleanup_cache == false) {
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
	//
	EBE_create_in_con_voi_table( 'eb_in_con_voi', 'order_id', array(
		'order_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'pri',
			'default' => '',
			'extra' => 'auto_increment',
		),
		'order_sku' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'order_products' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_customer' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_agent' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_ip' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'order_time' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_status' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'tv_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
	) );
	
	EBE_create_in_con_voi_table( 'eb_details_in_con_voi', 'dorder_id', array(
		'dorder_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'pri',
			'default' => '',
			'extra' => 'auto_increment',
		),
		'dorder_key' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'dorder_name' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
	) );
}

//exit();



?>
<table border="0" cellpadding="6" cellspacing="0" width="120%" class="table-list ip-invoice-alert">
	<tr class="table-list-title">
		<td>Mã HĐ</td>
		<td>Trạng thái</td>
		<td>S.Phẩm</td>
		<td>Thành viên</td>
		<td>Điện thoại</td>
		<td>Địa chỉ</td>
		<td>Ngày gửi</td>
	</tr>
	<?php
	
	//
//	wp_delete_post( 16018, true );
//	wp_delete_post( 16017, true );
	
	//
	$sql = _eb_load_order();
//	print_r( $sql ); exit();
	
	//
	/*
	while ( $sql->have_posts() ) {
		
		$sql->the_post();
		
		$o = $sql->post;
		*/
//		print_r( $o );
	
	foreach ( $sql as $o ) {
		
		//
		$hd_trangthai = get_post_meta( $o->ID, '__eb_hd_trangthai', true );
		
		//
		echo '
		<tr class="eb-set-order-list-info hd_status' . $hd_trangthai . '">
			<td><a href="admin.php?page=eb-order&id=' . $o->ID . '">' . $o->post_title . '</a></td>
			<td>' . ( isset( $arr_hd_trangthai[ $hd_trangthai ] ) ? $arr_hd_trangthai[ $hd_trangthai ] : '<em>NULL</em>' ) . '</td>
			<td class="eb-to-product">.</td>
			<td><a href="user-edit.php?user_id=' . $o->post_author . '" target="_blank">' . _eb_lay_email_tu_cache( $o->post_author ) . '</a></td>
			<td class="eb-to-phone">.</td>
			<td class="eb-to-adress">.</td>
			<td>' . $o->post_date . '</td>
		</tr>
		<script type="text/javascript">post_excerpt_to_prodcut_list(' . $o->post_excerpt . ');</script>';
		
	}
	
	?>
</table>
