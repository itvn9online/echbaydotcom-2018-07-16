<?php
/*
* Mọi code dùng chung cho trang danh sách sản phẩm/ bài viết
*/



//print_r($_GET);





//
//$search = array($_SERVER['QUERY_STRING'], '?');
//$replace = array('', '');
//$currentUrl = str_replace($search, $replace, $_SERVER['REQUEST_URI']);
//echo $currentUrl;
//print_r($_GET);



//
$__category = get_queried_object();
//print_r( $__category );





//
$switch_taxonomy = isset( $__category->taxonomy ) ? $__category->taxonomy : '';



// Nếu config không tạo menu -> không load sidebar
if ( $__cf_row['cf_cats_column_style'] == '' ) {
	$id_for_get_sidebar = '';
} else {
	$id_for_get_sidebar = 'category_sidebar';
}



// Chỉ nhận bài viết với định dạng được hỗ trợ
if ( $switch_taxonomy != '' ) {
	
	
	//
	$cid = $__category->term_id;
	$eb_wp_taxonomy = $__category->taxonomy;
	
	
	
	//
//	echo _eb_get_cat_object( $cid, '_eb_category_hidden', 0 ) . '<br>' . "\n";
//	echo $cid . '<br>' . "\n";
	
	// nhóm bị ẩn thì ẩn luôn
	if ( _eb_get_cat_object( $cid, '_eb_category_hidden', 0 ) == 1 ) {
		
		// nếu có URL cũ -> chuyển tới đó
		$old_url_for_redirect = _eb_get_cat_object( $cid, '_eb_category_old_url', '' );
		if ( $old_url_for_redirect == '' ) {
			$old_url_for_redirect = _eb_get_cat_object( $cid, '_eb_category_leech_url', '' );
		}
		
		if ( $old_url_for_redirect != '' ) {
			wp_redirect( $old_url_for_redirect, 301 ); exit();
		}
		
		
		//
		$__cf_row ["cf_blog_public"] = 0;
		
		EBE_set_header(401);
		
		//
		$main_content = '<h4 class="text-center" style="padding:90px 0;">Dữ liệu đang được cập nhật hoặc đã bị xóa...</h4>';
		
		$current_order = '';
		$tim_nang_cao = '';
		$seach_advanced_by_cats = '';
		
	}
	// mặc định sẽ hiển thị danh sách bài viết
	else {
		include EB_THEME_PLUGIN_INDEX . 'global/list_default.php';
	}





// -> thêm đoạn JS dùng để xác định xem khách đang ở đâu trên web
$main_content .= '<script type="text/javascript">
var current_order="' . $current_order . '",
	seach_advanced_value="' . $tim_nang_cao . '",
	seach_advanced_by_cats="' . $seach_advanced_by_cats . '",
	cf_cats_description_viewmore=' . $__cf_row['cf_cats_description_viewmore'] . ',
	switch_taxonomy="' . $switch_taxonomy . '";
</script>';
	
	
	
}
// nếu người dùng sử dụng taxonomy riêng -> include taxonomy này vào
else if ( file_exists( EB_THEME_PHP . 'archive-' . $switch_taxonomy . '.php' ) ) {
	
	// nếu sử dụng giao diện riêng -> người dùng tự exist chứ mình mặc định là không exist
	include EB_THEME_PHP . 'archive-' . $switch_taxonomy . '.php';
	
}
else if ( $act == 'archive' ) {
	include EB_THEME_PHP . 'archive.php';
}
// không thì in ra file 404 thôi
else {
	echo '<!-- ' .$act . ' --> <br>' . "\n";
	
	include EB_THEME_PHP . '404.php';
}




// loại bỏ chức năng bỏ qua sản phẩm đã lấy, để custom code còn hoạt động được
$___eb_post__not_in = '';



