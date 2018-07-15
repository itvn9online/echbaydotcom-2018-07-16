<br>
<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Đơn hàng</a></div>
<ul class="cf eb-admin-tab eb-order-filter-tab">
	<li><a href="admin.php?page=eb-order">Tất cả</a></li>
	<?php
	global $arr_hd_trangthai;
	
	//
	foreach ( $arr_hd_trangthai as $k => $v ) {
		if ( $k >= 0 ) {
			echo '<li data-tab="' . $k . '"><a href="admin.php?page=eb-order&tab=' . $k . '">' . $v . ' <sup id="show_count_order_by' . $k . '" data-value="0">0</sup></a></li>';
		}
	}
	?>
</ul>
<script type="text/javascript" src="<?php echo EB_URL_OF_PLUGIN . 'echbay/js/order.js?v=' . date_time; ?>"></script>
<?php


//
//echo ECHBAY_PRI_CODE;



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


// đặt cookie riêng cho từng bộ lọc, nếu không có -> sẽ sử dụng cookie dùng chung
$str_for_order_cookie_name = 'get_order_by_time_line';

// lấy theo cookie nếu có
$order_by_time_line = _eb_getCucki( $str_for_order_cookie_name );
if( ! isset ( $_GET ['d'] ) && $order_by_time_line != '' ) {
	$_GET ['d'] = $order_by_time_line;
}



// tính tổng số đơn hàng theo từng tab
//print_r( $arr_hd_trangthai );
$strCountFilter = "";
if ( $order_by_time_line != '' ) {
	$strCountFilter .= WGR_cereate_order_filter ( $order_by_time_line );
}
//echo $strCountFilter . '<br>' . "\n";
foreach ( $arr_hd_trangthai as $k => $v ) {
	if ( $k >= 0 ) {
		$totalTabThread = _eb_c ( "SELECT COUNT(order_id) AS c
		FROM
			`eb_in_con_voi`
		WHERE
			tv_id > 0
			" . $strCountFilter . "
			AND order_status = " . $k );
		echo '<span data-id="' . $k . '" class="each-to-count-tab d-none">' . $totalTabThread . '</span>';
	}
}



//
if ( isset($_GET['id']) ) {
	$id = (int)$_GET['id'];
	if ( $id > 0 ) {
		include ECHBAY_PRI_CODE . 'order_details.php';
	}
} else {
	include ECHBAY_PRI_CODE . 'order_list.php';
}





