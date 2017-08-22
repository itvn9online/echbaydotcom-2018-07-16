<style type="text/css">
/*
.click-order-thread.fa-comments,
.click-order-thread.fa-link,
*/
.click-order-thread.fa-star[data-val="1"] { color: #F90; }
.click-order-thread.fa-comments[data-val="closed"],
.click-order-thread.fa-link[data-val="closed"],
.click-order-thread.fa-star { color: #333; }
.quick-show-if-post { display: none !important; }
.class-for-post .quick-show-if-post { display: inline-block !important; }
.admin-products_post-category { margin-bottom: 15px; }
.admin-products_post-category li {
	float: left;
	margin: 5px 20px 5px 0;
}
.admin-products_post-category a:before { content: "- "; }
</style>
<?php



//
$by_cat_id = isset( $_GET['by_cat_id'] ) ? (int) $_GET['by_cat_id'] : 0;


// tham khảo custom query: https://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query

//
$strFilter = " post_type = '" . $by_post_type . "'
	AND ( `" . $wpdb->posts . "`.post_status = 'publish' OR `" . $wpdb->posts . "`.post_status = 'pending' OR `" . $wpdb->posts . "`.post_status = 'draft' ) ";
	
$joinFilter = "";

$strLinkPager .= '&by_post_type=' . $by_post_type;

$cats_type = ( $by_post_type == 'blog' ) ? 'blogs' : 'category';


//
if ( $by_cat_id > 0 ) {
	
	$strLinkPager .= '&by_cat_id=' . $by_cat_id;
	
	//
	$arrs_cats = array(
		'taxonomy' => $cats_type,
		'hide_empty' => 0,
		'parent' => $by_cat_id,
	);
	
	$arrs_cats = get_categories( $arrs_cats );
//	print_r( $arrs_cats );
	
	$by_child_cat_id = '';
	foreach ( $arrs_cats as $v ) {
		$by_child_cat_id .= ',' . $v->term_id;
	}
	
	
	//
	$strFilter .= " AND `" . $wpdb->term_taxonomy . "`.taxonomy = '" . $cats_type . "'
		AND `" . $wpdb->term_taxonomy . "`.term_id IN (" . $by_cat_id . $by_child_cat_id . ") ";
	
	$joinFilter = " LEFT JOIN `" . $wpdb->term_relationships . "` ON ( `" . $wpdb->posts . "`.ID = `" . $wpdb->term_relationships . "`.object_id)
		LEFT JOIN `" . $wpdb->term_taxonomy . "` ON ( `" . $wpdb->term_relationships . "`.term_taxonomy_id = `" . $wpdb->term_taxonomy . "`.term_taxonomy_id ) ";
//	$joinFilter = ", `" . $wpdb->term_taxonomy . "`, `" . $wpdb->term_relationships . "` ";
	
}
//echo $strFilter . '<br>' . "\n";
//echo $joinFilter . '<br>' . "\n";






//
$arrs_cats = array(
	'taxonomy' => $cats_type,
	'hide_empty' => 0,
	'parent' => 0,
);

//
$arrs_cats = get_categories( $arrs_cats );
//print_r( $arrs_cats );

echo '<ul class="cf admin-products_post-category">';
foreach ( $arrs_cats as $v ) {
	$sl = '';
	if ( $v->term_id == $by_cat_id ) {
		$sl = 'bold';
	}
	
	//
	echo '<li><a href="' . web_link . WP_ADMIN_DIR . '/admin.php?page=eb-products&by_post_type=' . $by_post_type . '&by_cat_id=' . $v->term_id . '" class="' . $sl . '">' . $v->name . '</a></li>';
}
echo '</ul>';





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
		" . $joinFilter . "
	WHERE
		" . $strFilter );
//echo $strFilter . '<br>' . "\n";
$totalThread = 0;
//print_r( $sql );
if ( count( $sql ) > 0 ) {
	$sql = $sql[0];
//	print_r( $sql );
	foreach ( $sql as $v ) {
		$totalThread = $v;
	}
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
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-list class-for-<?php echo $by_post_type; ?>">
	<tr class="table-list-title">
		<td width="5%">&nbsp;</td>
		<td width="10%">ID</td>
		<td width="8%">Ảnh</td>
		<td>Sản phẩm/ Giá cũ/ Giá mới</td>
		<td width="10%">STT</td>
		<td width="16%">Công cụ</td>
		<td width="14%">Ngày Đăng/ Cập nhật</td>
	</tr>
	<?php

if ( $totalThread > 0 ) {

	//
	$sql = _eb_q ( "SELECT *
	FROM
		`" . $wpdb->posts . "`
		" . $joinFilter . "
	WHERE
		" . $strFilter . "
	ORDER BY
		menu_order DESC
	LIMIT " . $offset . ", " . $threadInPage );
//	print_r( $sql ); exit();
	
	//
	foreach ( $sql as $o ) {
		
//		print_r( $o ); exit();
		
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
		$current_sticky = 0;
		if ( is_sticky( $o->ID ) ) {
			$current_sticky = 1;
		}
		$comment_status = $o->comment_status;
		$ping_status = $o->ping_status;
		
		//
		echo '
<tr>
	<td class="text-center"><input type="checkbox" name="thread-checkbox" value="' . $trv_id . '" class="eb-uix-thread-checkbox thread-multi-checkbox" /></td>
	<td><a href="' . $trv_link . '" target="_blank">' . $trv_id . ' <i class="fa fa-eye"></i></a></td>
	<td><a href="' . $trv_link . '" target="_blank" class="d-block admin-thread-avt" style="background-image:url(\'' . $trv_img . '\');">&nbsp;</a></td>
	<td>
		<div><a title="' . $trv_tieude . '" href="' . web_link . WP_ADMIN_DIR . '/post.php?post=' . $trv_id . '&action=edit" target="_blank"><strong>' . $trv_tieude . '</strong> <i title="Sửa" class="fa fa-edit greencolor"></i></a></div>
		<div>' . number_format ( $trv_giaban ) . '/ <strong>' . number_format ( $trv_giamoi ) . '</strong></div>
		<div>' . $view_by_group . '</div>
	</td>
	<td><input type="number" value="' . $trv_stt . '" data-ajax="' . $strLinkAjaxl . '&t=up&stt=" class="s change-update-new-stt" /></td>
	<td>
		<div class="div-inline-block text-center">
			<div><i title="Up to TOP" data-ajax="' . $strLinkAjaxl . '&t=auto&stt=' . $trv_stt . '" class="fa fa-refresh fa-icons cur click-order-thread"></i></div>
			
			<div><i title="Up" data-ajax="' . $strLinkAjaxl . '&t=up&stt=' . $trv_stt . '" class="fa fa-arrow-circle-up fa-icons cur click-order-thread"></i></div>
			
			<div><i title="Down" data-ajax="' . $strLinkAjaxl . '&t=down&stt=' . $trv_stt . '" class="fa fa-arrow-circle-down fa-icons cur click-order-thread"></i></div>
			
			<div class="quick-show-if-post"><i title="Set sticky" data-val="' . $current_sticky . '" data-ajax="' . $strLinkAjaxl . '&t=sticky&current_sticky=' . $current_sticky . '" class="fa fa-star fa-icons cur click-order-thread"></i></div>
			
			<div class="quick-show-if-post"><i title="Toggle comment status" data-val="' . $comment_status . '" data-ajax="' . $strLinkAjaxl . '&t=comment_status&comment_status=' . $comment_status . '" class="fa fa-comments fa-icons cur click-order-thread"></i></div>
			
			<div class="quick-show-if-post"><i title="Toggle ping status" data-val="' . $ping_status . '" data-ajax="' . $strLinkAjaxl . '&t=ping_status&ping_status=' . $ping_status . '" class="fa fa-link fa-icons cur click-order-thread"></i></div>
			
			<div><i title="Toggle status" data-ajax="' . $strLinkAjaxl . '&t=status&toggle_status=' . $trv_trangthai . '" class="fa fa-icons cur click-order-thread ' . ( ($trv_trangthai > 0) ? 'fa-unlock' : 'fa-lock blackcolor' ) . '"></i></div>
		</div>
	</td>
	<td class="text-center">' . date( $__cf_row['cf_date_format'] . ' ' . $__cf_row['cf_time_format'], strtotime( $o->post_date ) ) . '<br>' . date( $__cf_row['cf_date_format'] . ' ' . $__cf_row['cf_time_format'], strtotime( $o->post_modified ) ) . '</td>
</tr>';
		
	}
	
}

	?>
</table>
<script type="text/javascript">

//
WGR_admin_quick_edit_select_menu();

//
function WGR_admin_quick_edit_products ( connect_to, url_request, parameter ) {
	
	// kiểm tra dữ liệu đầu vào
	if ( typeof connect_to == 'undefined' || connect_to == '' ) {
		console.log('not set connect to');
		return false;
	}
	if ( typeof url_request == 'undefined' || url_request == '' ) {
		console.log('URL for request is NULL');
		return false;
	}
	
	// các tham số khác
	if ( typeof parameter == 'undefined' ) {
		parameter = '';
	}
	
	// không cho bấm liên tiếp
	if ( waiting_for_ajax_running == true ) {
		console.log('waiting_for_ajax_running');
		return false;
	}
	waiting_for_ajax_running = true;
	
	//
	$('#rAdminME').css({
		opacity: 0.2
	});
	
	ajaxl( connect_to + url_request + parameter, 'rAdminME', 9, function () {
		$('#rAdminME').css({
			opacity: 1
		});
		
		waiting_for_ajax_running = false;
	});
}

//
$('.click-order-thread').off('click').click(function () {
	WGR_admin_quick_edit_products( 'products', $(this).attr('data-ajax') || '' );
});



//
$('.change-update-new-stt').off('change').change(function () {
	var a = $(this).val() || 0;
	a = g_func.number_only(a);
	if ( a < 0 ) {
		a = 0;
	}
//	console.log( a );
	
	// giảm đi 1 đơn vị -> vì sử dụng lệnh của chức năng UP
	a--;
//	console.log( a );
	
	//
	WGR_admin_quick_edit_products( 'products', $(this).attr('data-ajax') || '', a );
});


</script> 
