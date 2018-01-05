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
		$__cf_row ["cf_blog_public"] = 0;
		
		//
		$main_content = '<h4 class="text-center" style="padding:90px 0;">Dữ liệu đang được cập nhật hoặc đã bị xóa...</h4>';
	}
	// mặc định sẽ hiển thị danh sách bài viết
	else {
		include EB_THEME_PLUGIN_INDEX . 'global/list_default.php';
	}
	
	
	
}
// nếu người dùng sử dụng taxonomy riêng -> include taxonomy này vào
else if ( file_exists( EB_THEME_PHP . 'archive-' . $switch_taxonomy . '.php' ) ) {
	
	// nếu sử dụng giao diện riêng -> người dùng tự exist chứ mình mặc định là không exist
	include EB_THEME_PHP . 'archive-' . $switch_taxonomy . '.php';
	
}
// không thì in ra file 404 thôi
else {
	include EB_THEME_PHP . '404.php';
}




// loại bỏ chức năng bỏ qua sản phẩm đã lấy, để custom code còn hoạt động được
$___eb_post__not_in = '';



