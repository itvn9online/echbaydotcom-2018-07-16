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
		$sql->order_status = get_post_meta( $sql->ID, '__eb_hd_trangthai', true );
		$sql->order_ip = '';
//		print_r( $sql );
		
		//
		$order_old_type = $sql->post_author;
	}
	else {
		die('<h1>Order object not found</h1>');
	}
}

// TEST
echo '<!--' . "\n";

print_r( $sql );

/*
$strsql = _eb_q("SELECT *
	FROM
		`" . $wpdb->posts . "`
	WHERE
		post_author = " . $sql->post_author . "
	ORDER BY
		ID DESC" );
if ( count($strsql) > 0 ) {
	$strsql = $strsql[0];
	print_r( $strsql );
	
	// lấy thời gian gửi đơn hàng trước đó, mỗi đơn cách nhau tầm 5 phút
	$lan_gui_don_truoc = strtotime( $strsql->post_date );
	echo date( 'r', $lan_gui_don_truoc ) . "\n";
	echo date_time - $lan_gui_don_truoc . "\n";
}
*/

echo "\n" . '-->';
// END TEST

//if ( !isset($sql->post) || !isset($sql->post->ID) ) {
//if ( ! isset($sql->ID) ) {
if ( ! isset($sql->order_id) ) {
	die('<h1>Order details not found</h1>');
}

//
//$post = $sql[0]->post;
$post = $sql;
//print_r( $post );


?>

<div class="wrap">
	<h1>Chi tiết đơn hàng</h1>
</div>
<br>
<form name="frm_invoice_details" method="post" action="<?php echo web_link; ?>process/?set_module=order_details" target="target_eb_iframe" onSubmit="return ___eb_admin_update_order_details();">
	<div class="d-none">
		<input type="number" name="order_id" value="<?php echo $post->order_id; ?>">
		<input type="number" name="order_old_type" id="order_old_type" value="<?php echo $order_old_type; ?>">
		<textarea name="order_products" id="order_products" style="width:99%;height:110px;"><?php echo $post->order_products; ?></textarea>
		<textarea name="order_customer" id="order_customer" style="width:99%;height:110px;"><?php echo $post->order_customer; ?></textarea>
	</div>
	<div class="medium18 redcolor">Thông tin khách hàng</div>
	<table cellpadding="6" cellspacing="0" width="100%" border="0" class="eb-public-table">
		<tr>
			<td class="t">Họ và tên</td>
			<td class="i"><input type="text" name="t_ten" id="oi_hd_ten" value="" class="m" /></td>
		</tr>
		<tr>
			<td class="t">Điện thoại</td>
			<td class="i"><input type="text" name="t_dienthoai" id="oi_hd_dienthoai" value="" class="n" /></td>
		</tr>
		<tr>
			<td class="t">Địa chỉ</td>
			<td class="i"><input type="text" name="t_diachi" id="oi_hd_diachi" value="" class="l" /></td>
		</tr>
		<tr>
			<td class="t">Email</td>
			<td class="i"><a href="<?php echo web_link . WP_ADMIN_DIR; ?>/user-edit.php?user_id=<?php echo $post->tv_id; ?>" target="_blank"><?php echo _eb_lay_email_tu_cache( $post->tv_id ); ?></a></td>
		</tr>
	</table>
	<br>
	<br>
	<div class="medium18 redcolor">Thông tin hóa đơn <strong>#<?php echo $post->order_sku; ?></strong></div>
	<table cellpadding="6" cellspacing="0" width="100%" border="0" class="order-danhsach-sanpham">
		<tr>
			<td>ID</td>
			<td>Sản phẩm</td>
			<td>Đơn giá</td>
			<td>Số lượng</td>
			<td>Cộng</td>
		</tr>
	</table>
	<br>
	<table cellpadding="6" cellspacing="0" width="100%" border="0" class="eb-public-table">
		<tr>
			<td class="t">Ghi chú của khách hàng</td>
			<td id="oi_ghi_chu_cua_khach" class="i">&nbsp;</td>
		</tr>
		<tr>
			<td class="t">Ngày gửi</td>
			<td data-time="<?php echo $post->order_time; ?>" class="i order-time-server"><?php echo date( 'd-m-Y H:i', $post->order_time ); ?></td>
		</tr>
		<tr>
			<td class="t">Ghi chú của CSKH <span class="d-block small">Ví dụ: lý do hủy đơn hàng.</span></td>
			<td class="i"><textarea id="hd_admin_ghichu"></textarea></td>
		</tr>
		<tr>
			<td class="t">Trạng thái</td>
			<td class="i"><select name="t_trangthai">
					<?php
					$hd_trangthai = $post->order_status;
					
					foreach ( $arr_hd_trangthai as $k => $v ) {
						if ( $k >= 0 ) {
							$sl = '';
							if ( $k == $hd_trangthai ) {
								$sl = ' selected="selected"';
							}
							
							//
							echo '<option value="' . $k . '"' . $sl . '>' . $v . '</option>';
						}
					}
					?>
				</select></td>
		</tr>
	</table>
	<br>
	<div style="position:fixed;bottom:25px;right:25px;">
		<input type="submit" id="eb_cart_submit" value="Lưu thay đổi" class="blue-button cur d-none" disabled />
		<input type="button" id="eb_cart_print" value="In phiếu thu" class="red-button cur d-none" disabled />
	</div>
</form>
<br>
<br>
<div class="medium18 redcolor">Dữ liệu tham khảo cho kiểm soát viên</div>
<table cellpadding="6" cellspacing="0" width="100%" border="0" class="eb-public-table dulieu-thamkhao">
	<tr>
		<td class="t">IP</td>
		<td class="i"><?php echo $post->order_ip; ?></td>
	</tr>
</table>
<br>
<br>
<script type="text/javascript">
// v1
var order_details_arr_cart_product_list_v1 = (function ( arr ) {
	if ( typeof arr == 'undefined' ) {
		arr = '';
	}
	return arr;
})( <?php echo $post->post_excerpt; ?> );

// v2
var order_details_arr_cart_product_list = "<?php echo $post->order_products; ?>",
	order_details_arr_cart_customer_info = "<?php echo $post->order_customer; ?>";
</script> 
<script type="text/javascript" src="<?php echo EB_URL_OF_PLUGIN . 'echbay/js/order_details.js?v=' . date_time; ?>"></script> 
