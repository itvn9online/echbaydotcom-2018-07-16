<?php


// sử dụng file này để load chi tiết đơn hàng -> dùng chung
include ECHBAY_PRI_CODE . 'order_details_load.php';



?>

<div class="wrap">
	<h1>Chi tiết đơn hàng</h1>
</div>
<br>
<?php

// tự chuyển lại trạng thái là chưa xác nhận nếu bấm vào xem mà không làm gì cả
$auto_reset_status_after_view = 0;



//
$list_log_for_order = _eb_get_log_admin_order( $post->order_id );
//	print_r( $list_log_for_order );

// xem có update log xem cho đơn này hay không
$show_dang_xac_nhan = '';
$update_log_view_order = 1;
$str_log_view_order = '';
$i = 0;

// chỉ hiện thị log với tài khoản admin
$show_log_for_supper_admin = 0;
if ( current_user_can('manage_options') )  {
	$show_log_for_supper_admin = 1;
}

//
/*
if ( empty( $list_log_for_order ) ) {
	$update_log_view_order = 1;
}
else {
	*/
	foreach ( $list_log_for_order as $v ) {
		//
//		if ( $update_log_view_order == 0 && $v->tv_id == mtv_id ) {
		if ( $update_log_view_order == 1 && $v->tv_id == mtv_id ) {
//			echo date_time - $v->l_ngay . '<br>' . "\n";
//			if ( $i == 0 && date_time - $v->l_ngay > 600 ) {
//				$update_log_view_order = 1;
			if ( $i == 0 && date_time - $v->l_ngay < 600 ) {
				$update_log_view_order = 0;
			}
			$i++;
		}
		
		// với đơn hàng mới hoặc đơn hàng đang xác nhận
		if ( $post->order_status == 0 || $post->order_status == 3 ) {
			// kiểm tra thời gian xác nhận lần cuối để thông báo tới người dùng
			if ( $show_dang_xac_nhan == '' && date_time - $v->l_ngay < 300 ) {
				$show_dang_xac_nhan = '<a href="' . admin_link . 'user-edit.php?user_id=' . $v->tv_id . '" target="_blank">' . WGR_get_user_email( $v->tv_id ) . '</a>';
			}
		}
		
		//
		if ( $show_log_for_supper_admin == 1 ) {
			$str_log_view_order .= '
<tr>
<td><a href="' . admin_link . 'user-edit.php?user_id=' . $v->tv_id . '" target="_blank">' . WGR_get_user_email( $v->tv_id ) . '</a></td>
<td>' . date ( 'd/m/Y (H:i)', $v->l_ngay ) . '</td>
<td>' . $v->l_ip . '</td>
<td>' . $v->l_noidung . '</td>
</tr>';
		}
	}
//}


// tự động cập nhật trạng thái đơn mới để người sau nắm được
if ( $update_log_view_order == 1 ) {
	// lưu log mỗi khi có người xem đơn hàng
	_eb_log_admin_order( 'Xem đơn hàng', $post->order_id );
}




//
//if ( $post->order_status == 3 ) {
if ( $show_dang_xac_nhan != '' ) {
	// nếu mới cập nhật -> hiển thị thông báo cho người sau được biết
//	if ( date_time - $post->l_ngay < 300 ) {
		echo '<div class="dang-xac-nhan">Hóa đơn đang được kiểm duyệt bởi ' . $show_dang_xac_nhan . '</div>';
	/*
	}
	// Nếu không -> reset trạng thái mới
	else {
	}
	*/
}

?>
<form name="frm_invoice_details" method="post" action="<?php echo web_link; ?>process/?set_module=order_details" target="target_eb_iframe" onSubmit="return ___eb_admin_update_order_details();">
	<div class="d-none">
		<input type="number" name="order_id" value="<?php echo $post->order_id; ?>">
		<input type="number" name="order_old_type" id="order_old_type" value="<?php echo $order_old_type; ?>">
		<textarea name="order_products" id="order_products" style="width:99%;height:110px;"><?php echo $post->order_products; ?></textarea>
		<textarea name="order_customer" id="order_customer" style="width:99%;height:110px;"><?php echo $post->order_customer; ?></textarea>
	</div>
	<div class="medium18 redcolor l30">Thông tin khách hàng</div>
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
			<td class="i"><a href="<?php echo admin_link; ?>user-edit.php?user_id=<?php echo $post->tv_id; ?>" target="_blank"><?php echo _eb_lay_email_tu_cache( $post->tv_id ); ?></a></td>
		</tr>
	</table>
	<br>
	<br>
	<div class="medium18 redcolor l30">Thông tin hóa đơn <strong>#<?php echo $post->order_sku; ?></strong></div>
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
			<td class="t">Cập nhật cuối</td>
			<td class="i"><?php
			if ( isset( $post->order_update_time ) ) {
				echo date( 'd-m-Y H:i', $post->order_update_time );
			}
			// nếu chưa có -> có thể bảng hóa đơn đang thiếu -> bổ sung lại
			else {
				EBE_tao_bang_hoa_don_cho_echbay_wp();
			}
			?></td>
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
					
					//
					if ( $hd_trangthai == 0 && isset( $post->order_update_time ) ) {
						$sql = "UPDATE eb_in_con_voi
						SET
							order_update_time = " . date_time . "
						WHERE
							order_id = " . $post->order_id;
//						echo $sql . "\n";
						_eb_q( $sql, 0 );
						
						//
//						$auto_reset_status_after_view = 0;
					}
					
					//
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
	<div class="show-if-js-enable d-none" style="position:fixed;bottom:25px;right:25px;">
		<button type="submit" id="eb_cart_submit" class="blue-button cur"><i class="fa fa-save"></i> Lưu thay đổi</button>
		<button type="button" id="eb_cart_print" class="red-button cur"><i class="fa fa-print"></i> In Phiếu thu</button>
		<button type="button" id="eb_vandon_print" class="org-button cur"><i class="fa fa-truck"></i> In Vận đơn</button>
	</div>
</form>
<br>
<br>
<div class="medium18 redcolor l30">Lịch sử xem và thay đổi dữ liệu</div>
<table border="0" cellpadding="6" cellspacing="0" width="100%" class="table-list">
	<tr class="table-list-title">
		<td>Thành viên</td>
		<td>Thời gian</td>
		<td>IP</td>
		<td>Nội dung</td>
	</tr>
	<?php echo $str_log_view_order; ?>
</table>
<br />
<div class="medium18 redcolor l30">Dữ liệu tham khảo cho kiểm soát viên</div>
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
	order_details_arr_cart_customer_info = "<?php echo $post->order_customer; ?>",
	order_id = "<?php echo $id; ?>";

</script> 
<script type="text/javascript" src="<?php echo EB_URL_OF_PLUGIN . 'echbay/js/order_details.js?v=' . date_time; ?>"></script> 
