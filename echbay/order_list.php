<?php

function WGR_cereate_order_filter($o) {
	global $date_server;
//	echo $date_server . '<br>' . "\n";
	
	global $year_curent;
//	echo $year_curent . '<br>' . "\n";
	
	global $month_curent;
//	echo $month_curent . '<br>' . "\n";
	
	global $day_curent;
//	echo $day_curent . '<br>' . "\n";
	
	
	//
	if ($o == 'all') {
		return '';
	}
	
	
	//
	$return_filter = '';
	switch ($o) {
		case "between" :
			if (isset ( $_GET ['d1'] ) && ($d1 = trim ( $_GET ['d1'] )) != '') {
				if (isset ( $_GET ['d2'] ) && ($d2 = trim ( $_GET ['d2'] )) != '') {
				} else {
					$d2 = $d1;
				}
				$thang_trc = strtotime ( $d1 );
				$thang_sau = strtotime ( $d2 ) + (24 * 3600);
				$return_filter = "order_time > " . $thang_trc . " AND order_time < " . $thang_sau;
			}
			break;
		case "thismonth" :
			$thang_nay = strtotime ( $year_curent . "-" . $month_curent . "-01" );
			$return_filter = " order_time > " . $thang_nay;
			break;
		case "yesterday" :
			$str_date = strtotime ( $date_server );
			$return_filter = " (order_time > " . ($str_date - (24 * 3600)) . " AND order_time < " . $str_date . ") ";
			break;
		case "lastmonth" :
			$_month_curent = $month_curent - 1;
			$_year_curent = $year_curent;
			if ($_month_curent == 0) {
				$_month_curent = 12;
				$_year_curent -= 1;
			}
			$thang_truoc = strtotime ( $_year_curent . "-" . $_month_curent . "-01" );
			$thang_nay = strtotime ( $year_curent . "-" . $month_curent . "-01" );
			$return_filter = "(order_time > " . $thang_truoc . " AND order_time < " . $thang_nay . ")";
			break;
		case "last7days" :
			$return_filter = "order_time > " . (date_time - (24 * 3600 * 7));
			break;
		case "last30days" :
			$return_filter = "order_time > " . (date_time - (24 * 3600 * 30));
			break;
		case "today" :
			$return_filter = "order_time > " . strtotime ( $date_server );
			break;
		case "hrs24" :
			$return_filter = " order_time > " . (date_time - (24 * 3600));
			break;
		default :
			$return_filter = "order_time > " . (date_time - (24 * 3600 * 7));
//			$return_filter = " order_time > " . (date_time - (24 * 3600));
	}
	
	if ($return_filter != "") {
		return " AND " . $return_filter;
	}
	
	return '';
}





// tạo bảng hóa đơn nếu chưa có
/*
$strCacheFilter = 'update_order_table';
$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 6 * 3600 );
if ($check_Cleanup_cache == false) {
	
	EBE_tao_bang_hoa_don_cho_echbay_wp();
	
	// ép lưu cache
	_eb_get_static_html ( $strCacheFilter, date( 'r', date_time ), '', 60 );
	
}
*/
//exit();



//
$threadInPage = 68;
$strFilter = "";
$totalThread = 0;
$totalPage = 0;
$strLinkPager = admin_link . 'admin.php?page=eb-order';
$status_by = '';


//
$trang = isset( $_GET['trang'] ) ? (int)$_GET['trang'] : 1;
//echo $trang . '<br>' . "\n";



//
if ( isset( $_GET['tab'] ) ) {
	$status_by = (int) $_GET['tab'];
	
	$strFilter .= " AND order_status = " . $status_by;
	
	$strLinkPager .= '&tab=' . $status_by;
}
$jsLinkPager = $strLinkPager;


// đặt cookie riêng cho từng bộ lọc, nếu không có -> sẽ sử dụng cookie dùng chung
$str_for_order_cookie_name = 'get_order_by_time_line';

// lấy theo cookie nếu có
$order_by_time_line = _eb_getCucki( $str_for_order_cookie_name );
if( ! isset ( $_GET ['d'] ) && $order_by_time_line != '' ) {
	$_GET ['d'] = $order_by_time_line;
}

// lọc theo ngày tháng
$filterDay = isset( $_GET['d'] ) ? $_GET['d'] : '';

if ( $filterDay != '' ) {
	$strFilter .= WGR_cereate_order_filter ( $filterDay );
	
	$strLinkPager .= '&d=' . $filterDay;
}
//echo $strFilter . '<br>' . "\n";
//exit();





// tổng số đơn hàng
$totalThread = _eb_c ( "SELECT COUNT(order_id) AS c
	FROM
		`eb_in_con_voi`
	WHERE
		tv_id > 0
		" . $strFilter );
//echo $strFilter . '<br>' . "\n";
//echo $totalThread . '<br>' . "\n";



// phân trang bình thường
$totalPage = ceil ( $totalThread / $threadInPage );
if ( $totalPage < 1 ) {
	$totalPage = 1;
}
//echo $totalPage . '<br>' . "\n";
if ($trang > $totalPage) {
	$trang = $totalPage;
}
else if ( $trang < 1 ) {
	$trang = 1;
}
//echo $trang . '<br>' . "\n";
$offset = ($trang - 1) * $threadInPage;
//echo $offset . '<br>' . "\n";



?>
<style type="text/css">
.show-order-120size .eb-to-product,
.show-order-120size .eb-to-adress { width: 250px; }
.show-if-order-fullsize { display: none; }
.time-for-send-bill {
	font-weight: normal;
	font-size: 12px;
}
</style>
<div class="wrap">
	<div class="cf">
		<div class="lf f60">
			<h1>Danh sách đơn hàng - <span><?php echo number_format($totalThread); ?></span> đơn (Trang <?php echo number_format( $trang ) . '/ ' . number_format( $totalPage ); ?>)</h1>
		</div>
		<div class="lf f40 cf">
			<div id="oi_quick_connect" class="cf"></div>
		</div>
	</div>
</div>
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-list ip-invoice-alert">
	<tr class="table-list-title">
		<td width="12%">Mã HĐ<span>/ Ngày gửi</span></td>
		<td width="12%">Trạng thái</td>
		<td>S.Phẩm</td>
		<td>Thành viên<span>/ Điện thoại/ Địa chỉ</span></td>
		<td class="show-if-order-fullsize">Điện thoại</td>
		<td class="show-if-order-fullsize">Địa chỉ</td>
		<td class="show-if-order-fullsize">Ngày gửi</td>
	</tr>
	<?php
	
	//
//	wp_delete_post( 16018, true );
//	wp_delete_post( 16017, true );
	
	//
	$sql = _eb_load_order( $threadInPage, array(
//		'status_by' => $status_by,
		'filter_by' => $strFilter,
		'offset' => $offset
	) );
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
		$hd_trangthai = $o->order_status;
		
		//
		$ngay_gui_don = date_time - $o->order_time;
		if ( $ngay_gui_don < 10 * 60 ) {
			$ngay_gui_don = 'Vài phút trước';
		}
		else if ( $ngay_gui_don < 60 * 60 ) {
			$ngay_gui_don = ceil( $ngay_gui_don/ 60 ) . ' phút trước';
		}
		else if ( $ngay_gui_don < 24 * 3600 ) {
			$ngay_gui_don = ceil( $ngay_gui_don/ 3600 ) . ' giờ trước';
		}
		else if ( $ngay_gui_don < 24 * 3600 * 2 ) {
			$ngay_gui_don = date( 'h A', $o->order_time ) . ' hôm qua';
		}
		else {
			$ngay_gui_don = date( 'd-m-Y H:i', $o->order_time );
		}
		
		// Với các đơn hàng đang là tự động xác nhận
		// nếu trạng thái này nằm đây lâu quá rồi -> tự ghi nhận là chưa xác nhận
		/*
		if ( $hd_trangthai == 3 && isset( $o->order_update_time ) && date_time - $o->order_update_time > 600 ) {
			$hd_trangthai = 0;
		}
		*/
		
		//
		echo '
		<tr class="eb-set-order-list-info hd_status' . $hd_trangthai . '">
			<td class="text-center">
				<div><a href="' . admin_link . 'admin.php?page=eb-order&id=' . $o->order_id . '">
					' . $o->order_sku . ' <i class="fa fa-edit bluecolor"></i>
					<span class="time-for-send-bill d-block">(' . $ngay_gui_don . ')</span>
				</a></div>
			</td>
			<td>' . ( isset( $arr_hd_trangthai[ $hd_trangthai ] ) ? $arr_hd_trangthai[ $hd_trangthai ] : '<em>NULL</em>' ) . '</td>
			<td><div class="eb-to-product"></div></td>
			<td>
				<div><a href="user-edit.php?user_id=' . $o->tv_id . '" target="_blank"><i class="fa fa-user"></i> ' . _eb_lay_email_tu_cache( $o->tv_id ) . '</a></div>
				<div><i class="fa fa-phone"></i> <span class="eb-to-phone"></span></div>
				<div><i class="fa fa-home"></i> <span class="eb-to-adress"></span></div>
			</td>
			<td class="eb-to-phone show-if-order-fullsize">.</td>
			<td class="show-if-order-fullsize"><div class="eb-to-adress">.</div></td>
			<td class="show-if-order-fullsize">' . $ngay_gui_don . '</td>
		</tr>
		<script type="text/javascript">post_excerpt_to_prodcut_list("' . $o->order_products . '", "' . $o->order_customer . '");</script>';
		
	}
	
	
	
	// với các đơn hàng cũ
	$sql = _eb_load_order_v1();
	foreach ( $sql as $o ) {
		
//		print_r( $o );
		
		//
		$hd_trangthai = get_post_meta( $o->ID, '__eb_hd_trangthai', true );
		
		//
		echo '
		<tr class="hd_status' . $hd_trangthai . '">
			<td>
				<div><a href="' . admin_link . 'admin.php?page=eb-order&id=' . $o->ID . '&order_old_type=1" class="order-a-of-v1">' . $o->post_title . '</a></div>
				<div class="small">' . $o->post_date . '</div>
			</td>
			<td>' . ( isset( $arr_hd_trangthai[ $hd_trangthai ] ) ? $arr_hd_trangthai[ $hd_trangthai ] : '<em>NULL</em>' ) . '</td>
			<td><em>Chưa đồng bộ</em></td>
			<td><a href="user-edit.php?user_id=' . $o->post_author . '" target="_blank">' . _eb_lay_email_tu_cache( $o->post_author ) . '</a></td>
		</tr>';
		
	}
	
	
	?>
</table>
<br>
<div class="admin-part-page">
	<?php
if ($totalPage > 1) {
	echo EBE_part_page ( $trang, $totalPage, $strLinkPager . '&trang=' );
}
?>
</div>
<br>
<script type="text/javascript">
WGR_view_by_time_line( '<?php echo $jsLinkPager; ?>', '<?php echo $filterDay; ?>', '<?php echo $str_for_order_cookie_name; ?>' );
</script>
