<?php


$sql = _eb_load_order( 1, array(
	'p' => $id,
) );
//print_r( $sql );

//
//if ( isset($sql[0]) ) {
if ( count($sql) > 0 ) {
	$sql = $sql[0];
} else {
	die('<h1>Order object not found</h1>');
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
if ( !isset($sql->ID) ) {
	die('<h1>Order details not found</h1>');
}

//
//$post = $sql[0]->post;
$post = $sql;
//print_r( $post );


?>

<form name="frm_invoice_details" method="post" action="<?php echo web_link; ?>process/?set_module=order_details" target="target_eb_iframe" onSubmit="return ___eb_admin_update_order_details();">
	<div class="d-none">
		<input type="number" name="order_id" value="<?php echo $post->ID; ?>">
		<textarea name="order_excerpt" id="oi_post_excerpt" style="width:99%;height:200px;"><?php echo $post->post_excerpt; ?></textarea>
	</div>
	<div class="medium18 redcolor">Thông tin khách hàng</div>
	<table cellpadding="6" cellspacing="0" width="100%" border="0" class="public-table">
		<tr>
			<td>Họ và tên</td>
			<td><input type="text" id="oi_hd_ten" value="" /></td>
		</tr>
		<tr>
			<td>Điện thoại</td>
			<td><input type="text" id="oi_hd_dienthoai" value="" /></td>
		</tr>
		<tr>
			<td>Địa chỉ</td>
			<td><input type="text" id="oi_hd_diachi" value="" /></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?php echo _eb_lay_email_tu_cache( $post->post_author ); ?></td>
		</tr>
	</table>
	<br>
	<br>
	<div class="medium18 redcolor">Thông tin hóa đơn <strong>#<?php echo $post->post_title; ?></strong></div>
	<table cellpadding="6" cellspacing="0" width="100%" border="0" class="order-danhsach-sanpham">
		<tr style="font-weight:bold;background:#ccc">
			<td>ID</td>
			<td>Sản phẩm</td>
			<td>Đơn giá</td>
			<td>Số lượng</td>
			<td>Cộng</td>
		</tr>
	</table>
	<br>
	<table cellpadding="6" cellspacing="0" width="100%" border="0" class="public-table">
		<tr>
			<td>Ghi chú của khách hàng</td>
			<td id="oi_ghi_chu_cua_khach"></td>
		</tr>
		<tr>
			<td>Ngày gửi</td>
			<td><?php echo date( 'd-m-Y H:i', strtotime( $post->post_date ) ); ?></td>
		</tr>
		<tr>
			<td>Ghi chú của CSKH <span class="d-block small">Ví dụ: lý do hủy đơn hàng.</span></td>
			<td></td>
		</tr>
		<tr>
			<td>Trạng thái</td>
			<td><select name="t_trangthai">
					<?php
					$hd_trangthai = get_post_meta( $post->ID, '__eb_hd_trangthai', true );
					
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
	<div>
		<input type="submit" value="Lưu thay đổi" />
		<input type="button" value="In phiếu thu" />
	</div>
</form>
<br>
<br>
<div class="medium18 redcolor">Dữ liệu tham khảo cho kiểm soát viên</div>
<table cellpadding="6" cellspacing="0" width="100%" border="0" class="public-table dulieu-thamkhao">
</table>
<br>
<br>
<script type="text/javascript">
var order_details_arr_cart_product_list = (function ( arr ) {
	return arr;
})( <?php echo $post->post_excerpt; ?> );
</script> 
<script type="text/javascript" src="<?php echo EB_URL_OF_PLUGIN . 'echbay/js/order_details.js?v=' . date_time; ?>"></script>
