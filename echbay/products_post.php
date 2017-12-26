<style type="text/css">
/* mặc định là ẩn hết các nút quick action */
.class-for-post-type .fa-icons { display: none; }
/* hiển thị các nút mà post type nào cũng sẽ dùng */
.class-for-post-type .fa-refresh,
.class-for-post-type .fa-arrow-circle-up,
.class-for-post-type .fa-arrow-circle-down,
.class-for-post-type .fa-unlock,
.class-for-post-type .fa-lock { display: inline-block; }
/*
.click-order-thread.fa-comments,
.click-order-thread.fa-link,
*/
.click-order-thread.fa-star[data-val="1"] { color: #F90; }
.click-order-thread.fa-comments[data-val="closed"],
.click-order-thread.fa-link[data-val="closed"],
.click-order-thread.fa-paw[data-val="1"],
.click-order-thread.fa-diamond[data-val="0"],
.click-order-thread.fa-star { color: #333; }
.click-order-thread.fa-diamond[data-val="1"] { color: #F90; }
.quick-show-if-post { display: none !important; }
/* một số nút chỉ hiển thị với post type cụ thể */
.class-for-post .quick-show-if-post,
.class-for-blog .fa-comments,
.class-for-blog .fa-link,
.class-for-blog .fa-paw,
.class-for-post .fa-star,
.class-for-post .fa-comments,
.class-for-post .fa-link,
.class-for-post .fa-paw,
.class-for-post .fa-diamond { display: inline-block !important; }
.class-for-post .quick-show2-if-post { display: block !important; }
/*
.class-for-post .quick-show-if-paw,
.class-for-blog .quick-show-if-paw { display: inline-block !important; }
*/
.admin-products_post-category { margin-bottom: 15px; }
.admin-products_post-category li {
	float: left;
	margin: 5px 20px 5px 0;
}
.admin-products_post-category a:before { content: "- "; }
.table-list input[type="number"].s { width: 70px; }
/* multi edit tool */

.thread-edit-tools { padding: 0 0 15px 6px; }
.thread-edit-tools button {
	border: #d3d3d3 1px solid;
	background: #f8f8f8;
	color: #333;
	display: inline-block;
	height: 28px;
	padding: 0 10px;
	margin-left: 10px;
	outline: 0;
	font-weight: 500;
	font-size: 11px;
	text-decoration: none;
	white-space: nowrap;
	word-wrap: normal;
	line-height: normal;
	vertical-align: middle;
	cursor: pointer;
	border-radius: 2px;
	box-shadow: 0 1px 0 rgba(0,0,0,0.05);
}
.thread-multi-checkbox { cursor: pointer; }
.thread-multi-edit { padding: 20px 0; }
.thread-multi-input input[type=text] {
	padding: 6px;
	width: 250px;
}
.thread-multi-edit button:hover { background-color: #f2f2f2; }
</style>
<?php



//
$by_cat_id = isset( $_GET['by_cat_id'] ) ? (int) $_GET['by_cat_id'] : 0;


// tham khảo custom query: https://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query

//
$strFilter = " `" . $wpdb->posts . "`.post_type = '" . $by_post_type . "'
	AND ( `" . $wpdb->posts . "`.post_status = 'publish' OR `" . $wpdb->posts . "`.post_status = 'pending' OR `" . $wpdb->posts . "`.post_status = 'draft' ) ";
	
$joinFilter = "";
$strAjaxLink = '';

$strLinkPager .= '&by_post_type=' . $by_post_type;
$strAjaxLink .= '&by_post_type=' . $by_post_type;

$cats_type = ( $by_post_type == 'blog' ) ? 'blogs' : 'category';


//
if ( $by_cat_id > 0 ) {
	
	$strLinkPager .= '&by_cat_id=' . $by_cat_id;
	$strAjaxLink .= '&by_cat_id=' . $by_cat_id;
	
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
	echo '<li><a href="' . admin_link . 'admin.php?page=eb-products&by_post_type=' . $by_post_type . '&by_cat_id=' . $v->term_id . '" class="' . $sl . '">' . $v->name . '</a></li>';
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
$totalThread = _eb_c ( "SELECT COUNT(ID) AS c
	FROM
		`" . $wpdb->posts . "`
		" . $joinFilter . "
	WHERE
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
$strAjaxLink .= '&trang=' . $trang;



?>
<div class="class-for-<?php echo $by_post_type; ?>">
	<div class="quick-show2-if-post">
		<div class="thread-edit-tools">
			<div class="cf">
				<div class="lf f50">
					<input type="checkbox" id="thread-all-checkbox" value="0" class="thread-multi-checkbox" />
					<button type="button" class="small bold click-show-tools">Hành động <i class="fa fa-caret-down"></i></button>
				</div>
				<div align="right" class="lf f50"> Số sản phẩm trên mỗi trang
					<select id="change_set_thread_show_in_page" style="padding:3px;">
					</select>
				</div>
			</div>
			<div class="show-if-click-tools thread-multi-edit d-none">
				<form name="frm_admin_edit_content" method="post" action="ds34t53gt.php?act=process&module_id=thread_multi_edit" target="target_eb_iframe">
					<div class="d-none">
						<textarea name="t_list_id"></textarea>
						<input type="text" name="actions_for" value="" />
						<input type="text" name="actions_id_for" value="0" />
						<input type="submit" value="SB" />
					</div>
					<div class="titleCSS bold bborder">Chỉnh sửa nhiều sản phẩm</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Trạng thái</div>
							<div class="lf f60">{tmp.trv_str_trangthai}</div>
							<div class="lf f20">
								<button type="button" data-for="status" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Phân nhóm</div>
							<div class="lf f60 cf">
								<div class="lf f50">
									<div id="oiAnt"></div>
								</div>
							</div>
							<div class="lf f20">
								<button type="button" data-for="category" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Ngày hết hạn</div>
							<div class="lf f60 thread-multi-input">
								<input type="text" name="t_ngayhethan" value="" placeholder="Năm/Tháng/Ngày" maxlength="10" class="thread-list-ngayhethan" />
							</div>
							<div class="lf f20">
								<button type="button" data-for="enddate" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Số thứ tự</div>
							<div class="lf f60 thread-multi-input">
								<input type="text" name="t_stt" value="0" placeholder="Số thứ tự" maxlength="5" />
							</div>
							<div class="lf f20">
								<button type="button" data-for="stt" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="thread_list_edit_options"></div>
				</form>
			</div>
		</div>
	</div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-list class-for-post-type class-for-<?php echo $by_post_type; ?>">
	<tr class="table-list-title">
		<td width="5%">&nbsp;</td>
		<td width="10%">ID</td>
		<td width="8%">Ảnh</td>
		<td>Sản phẩm/ Giá cũ/ Giá mới</td>
		<td width="8%">STT</td>
		<td width="10%">Công cụ</td>
		<td width="14%">Ngày Đăng/ Cập nhật</td>
	</tr>
	<?php

if ( $totalThread > 0 ) {

	//
	$sql = "SELECT *
	FROM
		`" . $wpdb->posts . "`
		" . $joinFilter . "
	WHERE
		" . $strFilter . "
	ORDER BY
		`" . $wpdb->posts . "`.menu_order DESC
	LIMIT " . $offset . ", " . $threadInPage;
//	echo $sql; 
	$sql = _eb_q ( $sql );
//	print_r( $sql ); exit();
	
	//
	$arr_all_stick = get_option( 'sticky_posts' );
	
	//
	foreach ( $sql as $o ) {
		
//		print_r( $o ); exit();
		
		$trv_id = $o->ID;
		$trv_link = web_link . '?p=' . $trv_id;
		$trv_tieude = $o->post_title;
		
		$trv_img = _eb_get_post_img( $o->ID, 'thumbnail' );
		$view_by_group = '';
		$trv_stt = $o->menu_order;
		$trv_trangthai = $o->post_status == 'publish' ? 1 : 0;
//		$strLinkAjaxl = '&post_id=' . $trv_id . '&by_post_type=' . $by_post_type;
		$strLinkAjaxl = '&post_id=' . $trv_id . $strAjaxLink;
		
		//
		$current_sticky = 0;
		$comment_status = $o->comment_status;
		$ping_status = $o->ping_status;
		
		//
		$set_noindex = 0;
		$chinh_hang = 0;
		
		//
		$trv_giaban = 0;
		$trv_giamoi = 0;
		
		// các tính năng chỉ có ở post
		if ( $o->post_type == 'post' ) {
			if ( in_array( $o->ID, $arr_all_stick ) ) {
//			if ( is_sticky( $o->ID ) ) {
				$current_sticky = 1;
			}
			$chinh_hang = _eb_get_post_object( $o->ID, '_eb_product_chinhhang', 0 );
			
			// với phần giá cả -> sẽ lấy giá của woo nếu có
			$trv_giaban = _eb_float_only( _eb_get_post_object( $o->ID, '_eb_product_oldprice', 0 ) );
			/*
			if ( $trv_giaban == 0 ) {
				$trv_giaban = _eb_float_only( _eb_get_post_object( $o->ID, '_regular_price', 0 ) );
			}
			*/
			$trv_giamoi = _eb_float_only( _eb_get_post_object( $o->ID, '_eb_product_price', 0 ) );
			if ( $trv_giamoi == 0 ) {
				$trv_giamoi = _eb_float_only( _eb_get_post_object( $o->ID, '_price', 0 ) );
				
				// cập nhật giá mới từ giá của woo
				if ( $trv_giamoi > 0 ) {
					update_post_meta( $o->ID, '_eb_product_price', $trv_giamoi );
				}
			}
		}
		
		// các tính năng chỉ có ở post hoặc blog
		if ( $o->post_type == 'post' || $o->post_type == 'blog' ) {
			$set_noindex = _eb_get_post_object( $o->ID, '_eb_product_noindex', 0 );
		}
		
		//
		echo '
<tr>
	<td class="text-center"><input type="checkbox" name="thread-checkbox" value="' . $trv_id . '" class="eb-uix-thread-checkbox thread-multi-checkbox" /></td>
	<td><a href="' . $trv_link . '" target="_blank">' . $trv_id . ' <i class="fa fa-eye"></i></a></td>
	<td><a href="' . $trv_link . '" target="_blank" class="d-block admin-thread-avt" style="background-image:url(\'' . $trv_img . '\');">&nbsp;</a></td>
	<td>
		<div><a title="' . $trv_tieude . '" href="' . admin_link . 'post.php?post=' . $trv_id . '&action=edit" target="_blank"><strong>' . $trv_tieude . '</strong> <i title="Sửa" class="fa fa-edit greencolor"></i></a></div>
		<div class="quick-show-if-post">' . number_format ( $trv_giaban ) . '/ <strong>' . number_format ( $trv_giamoi ) . '</strong></div>
		<div>' . $view_by_group . '</div>
	</td>
	<td><input type="number" value="' . $trv_stt . '" data-ajax="' . $strLinkAjaxl . '&t=up&stt=" class="s change-update-new-stt" /></td>
	<td>
		<div class="text-center">
			<i title="Up to TOP" data-ajax="' . $strLinkAjaxl . '&t=auto&stt=' . $trv_stt . '" class="fa fa-refresh fa-icons cur click-order-thread"></i>
			
			<i title="Up" data-ajax="' . $strLinkAjaxl . '&t=up&stt=' . $trv_stt . '" class="fa fa-arrow-circle-up fa-icons cur click-order-thread"></i>
			
			<i title="Down" data-ajax="' . $strLinkAjaxl . '&t=down&stt=' . $trv_stt . '" class="fa fa-arrow-circle-down fa-icons cur click-order-thread"></i>
			
			<i title="Set sticky" data-val="' . $current_sticky . '" data-ajax="' . $strLinkAjaxl . '&t=sticky&current_sticky=' . $current_sticky . '" class="fa fa-star fa-icons cur click-order-thread"></i>
			
			<i title="Toggle comment status" data-val="' . $comment_status . '" data-ajax="' . $strLinkAjaxl . '&t=comment_status&comment_status=' . $comment_status . '" class="fa fa-comments fa-icons cur click-order-thread"></i>
			
			<i title="Toggle ping status" data-val="' . $ping_status . '" data-ajax="' . $strLinkAjaxl . '&t=ping_status&ping_status=' . $ping_status . '" class="fa fa-link fa-icons cur click-order-thread"></i>
			
			<i title="Toggle status" data-ajax="' . $strLinkAjaxl . '&t=status&toggle_status=' . $trv_trangthai . '" class="fa fa-icons cur click-order-thread ' . ( ($trv_trangthai > 0) ? 'fa-unlock' : 'fa-lock blackcolor' ) . '"></i>
			
			<i title="Set noindex" data-val="' . $set_noindex . '" data-ajax="' . $strLinkAjaxl . '&t=set_noindex&set_noindex=' . $set_noindex . '" class="fa fa-paw fa-icons cur click-order-thread"></i>
			
			<i title="Hàng chính hãng" data-val="' . $chinh_hang . '" data-ajax="' . $strLinkAjaxl . '&t=chinh_hang&chinh_hang=' . $chinh_hang . '" class="fa fa-diamond fa-icons cur click-order-thread"></i>
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
