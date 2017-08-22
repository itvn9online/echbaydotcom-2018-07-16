<style type="text/css">
.click-order-thread[data-val="1"] { color: #F90; }
</style>
<?php






// Lấy toàn bộ danh sách category rồi hiển thị thành menu
function WGR_get_and_oders_taxonomy_category (
	// taxonomy mặc định
	$cat_type = 'category',
	// nhóm cha mặc định -> mặc định lấy nhóm cấp 1
	$cat_ids = 0,
	// có lấy nhóm con hay không -> mặc định là có
	$get_child = 1
) {
	
	//
	$arrs_cats = array(
		'taxonomy' => $cat_type,
		'hide_empty' => 0,
		'parent' => $cat_ids,
	);
	
	//
	$arrs_cats = get_categories( $arrs_cats );
//	print_r($arrs_cats);
//	exit();
	
	//
	if ( count($arrs_cats) == 0 ) {
		return '';
	}
	
	
	// Thử kiểm tra xem trong này có nhóm nào được set là nhóm chính không
	$post_primary_categories = array();
	
	// Nếu đang là lấy nhóm cấp 1
	if ( $cat_ids == 0 ) {
		foreach ( $arrs_cats as $v ) {
			$post_primary_categories[ $v->term_id ] = _eb_get_cat_object( $v->term_id, '_eb_category_primary', 0 );
		}
//		print_r( $post_primary_categories );
	}

	
	// sắp xếp mảng theo chủ đích của người dùng
	$oders = array();
	$options = array();
	
	//
	foreach ( $arrs_cats as $v ) {
		$oders[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
		$options[$v->term_id] = $v;
	}
	arsort( $oders );	
	
	
	//
	$str = '';
//	foreach ( $arrs_cats as $v ) {
	foreach ( $oders as $k => $cat_stt ) {
		$v = $options[$k];
		
		//
		$str_child = '';
		if ( $get_child == 1 ) {
			$str_child = WGR_get_and_oders_taxonomy_category (
				$v->taxonomy,
				$v->term_id
			);
		}
		
		//
		$strLinkAjaxl = '&term_id=' . $v->term_id . '&by_taxonomy=' . $v->taxonomy;
		$_eb_category_primary = _eb_get_cat_object( $v->term_id, '_eb_category_primary', 0 );
		
		//
		$c_link = _eb_c_link( $v->term_id );
		
		//
		$str .= '
		<div class="cf">
			<div class="lf">
				<div class="div-inline-block">
					<div><input type="number" value="' . $cat_stt . '" data-ajax="' . $strLinkAjaxl . '&t=up&stt=" class="s change-update-new-stt" /></div>
					
					<div><i title="Up to TOP" data-ajax="' . $strLinkAjaxl . '&t=auto&stt=' . $cat_stt . '" class="fa fa-refresh fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Up" data-ajax="' . $strLinkAjaxl . '&t=up&stt=' . $cat_stt . '" class="fa fa-arrow-circle-up fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Down" data-ajax="' . $strLinkAjaxl . '&t=down&stt=' . $cat_stt . '" class="fa fa-arrow-circle-down fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Set primary" data-val="' . $_eb_category_primary . '" data-ajax="' . $strLinkAjaxl . '&t=primary&current_primary=' . $_eb_category_primary . '" class="fa fa-star fa-icons cur click-order-thread"></i></div>
				</div>
			</div>
			<div class="lf"><a href="' . web_link . WP_ADMIN_DIR . '/term.php?taxonomy=' . $v->taxonomy . '&tag_ID=' . $v->term_id . '&post_type=' . ( $v->taxonomy == EB_BLOG_POST_LINK ? EB_BLOG_POST_TYPE : 'post' ) . '" target="_blank">' . $v->name . ' (' . $v->count . ') <i class="fa fa-edit"></i></a> - <a href="' . $c_link . '" target="_blank" class="small blackcolor">' . $c_link . ' <i class="fa fa-eye"></i></a></a></div>
		</div>' . $str_child;
	}
	
	return '<blockquote>' . $str . '</blockquote>';
}



//
echo WGR_get_and_oders_taxonomy_category( $by_taxonomy );




?>
<script type="text/javascript">

//
WGR_admin_quick_edit_select_menu();

//
function WGR_admin_quick_edit_taxonomy ( connect_to, url_request, parameter ) {
	
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
	WGR_admin_quick_edit_taxonomy( 'products', $(this).attr('data-ajax') || '' );
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
	WGR_admin_quick_edit_taxonomy( 'products', $(this).attr('data-ajax') || '', a );
});


</script>
