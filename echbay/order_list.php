<?php





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

$type_search = '';
$invoice_key = '';
if( isset ( $_GET ['invoice_key'] ) ) {
	$invoice_key = $_GET['invoice_key'];
	
	if ( $invoice_key != '' ) {
		if( isset ( $_GET ['type_search'] ) ) {
			$type_search = $_GET['type_search'];
		}
		else {
			$type_search = _eb_getCucki('eb_admin_order_type_search');
		}
//		$invoice_key = urlencode( str_replace( '+', ' ', $invoice_key ) );
		
		// cấu trúc thẻ tìm kiếm theo từng hạng mục
		if ( $type_search == 'sp' ) {
			$strFilter .= " AND order_products LIKE '%{$invoice_key}%' ";
		}
		else if ( $type_search == 'id' ) {
			$strFilter .= " AND order_sku LIKE '%{$invoice_key}%' OR order_id LIKE '%{$invoice_key}%' ";
		}
		else {
			$strFilter .= " AND order_customer LIKE '%{$invoice_key}%' ";
		}
	}
}


//
$trang = isset( $_GET['trang'] ) ? (int)$_GET['trang'] : 1;
//echo $trang . '<br>' . "\n";



//
$status_by = '';
if ( isset( $_GET['tab'] ) ) {
	$status_by = $_GET['tab'];
	
	if ( $status_by != '' ) {
		$status_by = (int) $status_by;
		
		$strFilter .= " AND order_status = " . $status_by;
		
		$strLinkPager .= '&tab=' . $status_by;
	}
}
$jsLinkPager = $strLinkPager;



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

//
$str_hom_nay = date( 'md', date_time );



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
<div class="cf">
	<div class="lf f20">&nbsp;</div>
	<div class="lf f60 cf">
		<form name="frm_search_invoice" id="frm_search_invoice" method="get" action="<?php echo admin_link; ?>admin.php" onsubmit="return invoice_func_check_search();">
			<input type="hidden" name="page" value="eb-order">
			<!-- <input type="hidden" name="ost" value="search"> -->
			<input type="hidden" name="tab" value="<?php echo $status_by; ?>">
			<input type="hidden" name="type_search" value="<?php echo $type_search; ?>">
			<input type="text" name="invoice_key" id="oi_invoice_key" title="Tìm kiếm" value="<?php echo $invoice_key; ?>" placeholder="Mã đơn hàng, Số điện thoại, Email" maxlength="20" />
			<input type="submit" value="Tìm" class="cur oi_invoice_submit" />
		</form>
		<div class="click-search-by-type"><a data-type="dt" href="javascript:;">Số điện thoại</a> | <a data-type="sp" href="javascript:;">Tên sản phẩm</a> | <a data-type="id" href="javascript:;">Mã hóa đơn</a> <span class="redcolor small">* Lưu ý: từ khóa tìm kiếm có phân biệt chữ HOA, chữ thường, có dấu và không dấu.</span></div>
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
	
	//
	foreach ( $sql as $o ) {
		
		//
		$hd_trangthai = $o->order_status;
		
		//
		/*
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
		*/
		
		// nếu là ngày hoome nay -> chỉ hiển thị giờ
		$check_hom_nay = date( 'md', $o->order_time );
		if ( $check_hom_nay == $str_hom_nay ) {
			$ngay_gui_don = date( 'H:i', $o->order_time );
		}
		else {
			$ngay_gui_don = date( 'd-m-Y H:i', $o->order_time );
		}
		
		// Với các đơn hàng đang là tự động xác nhận
		// nếu trạng thái này nằm đây lâu quá rồi -> tự ghi nhận là chưa xác nhận
//		if ( $hd_trangthai == 3 && isset( $o->order_update_time ) && date_time - $o->order_update_time > 600 ) {
		if ( $hd_trangthai == 0 && isset( $o->order_update_time ) && $o->order_update_time > 0 && date_time - $o->order_update_time < 300 ) {
			$hd_trangthai = 3;
		}
		
		//
		echo '
		<tr class="eb-set-order-list-info check_hom_nay' . $check_hom_nay . ' hd_status' . $hd_trangthai . '">
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
//		$hd_trangthai = get_post_meta( $o->ID, '__eb_hd_trangthai', true );
		$hd_trangthai = _eb_get_post_object( $o->ID, '__eb_hd_trangthai' );
		
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

var str_hom_nay = "<?php echo $str_hom_nay; ?>";
$('.check_hom_nay' + str_hom_nay + ':last').after('<tr><td colspan="' + $('.check_hom_nay' + str_hom_nay + ' td').length + '">&nbsp;</td></tr>');

// ẩn bớt menu khi người dùng xem danh sách đơn
$('body').addClass('folded');


WGR_view_by_time_line( '<?php echo $jsLinkPager; ?>', '<?php echo $filterDay; ?>', '<?php echo $str_for_order_cookie_name; ?>' );

click_set_search_order_by_type();

</script>
