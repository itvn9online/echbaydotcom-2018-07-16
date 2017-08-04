<?php



global $wpdb;



//
$threadInPage = 68;
$by_post_type = isset( $_GET['by_post_type'] ) ? trim( $_GET['by_post_type'] ) : 'post';

$strFilter = " post_type = '" . $by_post_type . "'
	AND ( post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft' ) ";
$totalThread = 0;
$totalPage = 0;

$strLinkPager = web_link . WP_ADMIN_DIR . '/admin.php?page=eb-products&by_post_type=' . $by_post_type;

$status_by = '';
$strLinkAjaxl = '';


//
$trang = isset( $_GET['trang'] ) ? (int)$_GET['trang'] : 1;
//echo $trang . '<br>' . "\n";


//
/*
if ( isset( $_GET['tab'] ) ) {
	$status_by = (int)$_GET['tab'];
	
	$strFilter .= " AND order_status = " . $status_by;
	
	$strLinkPager .= '&tab=' . $status_by;
}
*/

// tổng số đơn hàng
$sql = _eb_q ( "SELECT COUNT(ID)
	FROM
		`" . $wpdb->posts . "`
	WHERE
		" . $strFilter );
//echo $strFilter . '<br>' . "\n";
//print_r( $sql );
$sql = $sql[0];
//print_r( $sql );
foreach ( $sql as $v ) {
	$totalThread = $v;
}
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
<div class="wrap">
	<h1>Danh sách <?php echo $by_post_type == EB_BLOG_POST_TYPE ? 'Blog/ Tin tức' : 'Sản phẩm'; ?> (Trang <?php echo number_format( $trang ) . '/ ' . number_format( $totalPage ); ?>)</h1>
	<div><a data-type="post" href="#" class="set-url-post-post-type">Sản phẩm</a> | <a data-type="<?php echo EB_BLOG_POST_TYPE; ?>" href="#" class="set-url-post-post-type">Blog/ Tin tức</a> | <a data-type="ads" href="#" class="set-url-post-post-type">Banner Quảng cáo</a></div>
</div>
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-list">
	<tr class="table-list-title">
		<td>&nbsp;</td>
		<td>Mã S.Phẩm</td>
		<td>Ảnh</td>
		<td>Tên Sản phẩm/ Giá cũ/ Giá mới</td>
		<td>STT</td>
		<td>Công cụ</td>
		<td>Cập nhật cuối</td>
	</tr>
	<?php
	
	//
	$sql = _eb_q ( "SELECT *
	FROM
		`" . $wpdb->posts . "`
	WHERE
		" . $strFilter . "
	ORDER BY
		menu_order DESC
	LIMIT " . $offset . ", " . $threadInPage );
//	print_r( $sql ); exit();
	
	//
	foreach ( $sql as $o ) {
		
		$trv_id = $o->ID;
		$trv_link = web_link . '?p=' . $trv_id;
		$trv_tieude = $o->post_title;
		$trv_giaban = _eb_float_only( _eb_get_post_object( $o->ID, '_eb_product_oldprice', 0 ) );
		$trv_giamoi = _eb_float_only( _eb_get_post_object( $o->ID, '_eb_product_price', 0 ) );
		$trv_img = _eb_get_post_img( $o->ID, 'thumbnail' );
		$view_by_group = '';
		$trv_stt = $o->menu_order;
		$trv_trangthai = $o->post_status == 'publish' ? 1 : 0;
		$strLinkAjaxl = '&post_id=' . $trv_id . '&by_post_type=' . $by_post_type;
		
		//
		echo '
<tr>
	<td><input type="checkbox" name="thread-checkbox" value="' . $trv_id . '" class="eb-uix-thread-checkbox thread-multi-checkbox" /></td>
	<td><a href="' . $trv_link . '" target="_blank">' . $trv_id . ' <i class="fa fa-eye"></i></a></td>
	<td><a href="' . $trv_link . '" target="_blank" class="d-block admin-thread-avt" style="background-image:url(\'' . $trv_img . '\');">&nbsp;</a></td>
	<td>
		<div><a title="' . $trv_tieude . '" href="' . web_link . WP_ADMIN_DIR . '/post.php?post=' . $trv_id . '&action=edit" target="_blank"><strong>' . $trv_tieude . '</strong> <i title="Sửa" class="fa fa-edit greencolor"></i></a></div>
		<div>' . number_format ( $trv_giaban ) . '/ <strong>' . number_format ( $trv_giamoi ) . '</strong></div>
		<div>' . $view_by_group . '</div>
	</td>
	<td>' . $trv_stt . '</td>
	<td>
		<div class="div-inline-block">
			<div><i title="Up to TOP" data-ajax="' . $strLinkAjaxl . '&t=auto&stt=' . $trv_stt . '" class="fa fa-refresh fa-icons cur click-order-thread"></i></div>
			
			<div><i title="Up" data-ajax="' . $strLinkAjaxl . '&t=up&stt=' . $trv_stt . '" class="fa fa-arrow-circle-up fa-icons cur click-order-thread"></i></div>
			
			<div><i title="Down" data-ajax="' . $strLinkAjaxl . '&t=down&stt=' . $trv_stt . '" class="fa fa-arrow-circle-down fa-icons cur click-order-thread"></i></div>
			
			<div><i title="Toggle status" data-ajax="' . $strLinkAjaxl . '&t=status&toggle_status=' . $trv_trangthai . '" class="fa fa-thumbs-up fa-icons cur click-order-thread ' . ( ($trv_trangthai > 0) ? '' : 'redcolor' ) . '"></i></div>
		</div>
	</td>
	<td>' . $o->post_modified . '</td>
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
<p>* Số thứ tự (STT) càng lớn thì độ ưu tiên càng cao, sản phẩm sẽ được sắp xếp theo STT từ cao đến thấp.</p>
<br>
<script type="text/javascript">
var waiting_for_ajax_running = false,
	by_post_type = '<?php echo $by_post_type; ?>';

$('.click-order-thread').off('click').click(function () {
	if ( waiting_for_ajax_running == true ) {
		console.log('waiting_for_ajax_running');
		return false;
	}
	waiting_for_ajax_running = true;
	
	var a = $(this).attr('data-ajax') || '';
	
	if ( a != '' ) {
		$('#rAdminME').css({
			opacity: 0.2
		});
		
		ajaxl('products' + a, 'rAdminME', 9, function () {
			$('#rAdminME').css({
				opacity: 1
			});
			
			waiting_for_ajax_running = false;
		});
	}
});


//
$('.set-url-post-post-type').each(function(index, element) {
	var a = $(this).attr('data-type') || 'post';
	
	$(this).attr({
		href: window.location.href.split('&by_post_type=')[0] + '&by_post_type=' + a
	});
});

$('.set-url-post-post-type[data-type="' + by_post_type + '"]').addClass('bold');

</script>
