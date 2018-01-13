<?php



/*
* Mọi code dùng chung cho trang chi tiết sản phẩm/ bài viết
*/



//
//print_r($post);
$__post = $post;



// nếu đây là một page, và page này có URL thuốc nhóm ưu tiên -> không hiển thị page theo kiểu thông thường
if ( $__post->post_type == 'page' && isset( $arr_active_for_404_page[ $__post->post_name ] ) ) {
	echo '<!-- Custom page by EchBay: ' . $__post->post_name . ' -->' . "\n";
	
	$act = $__post->post_name;

	// không index các trang module riêng của EB
	$__cf_row ["cf_blog_public"] = 0;
	
	include EB_THEME_PLUGIN_INDEX . 'global/' . $__post->post_name . '.php';
}
// mặc định thì hiển thị trang chi tiết luôn
else {
	include EB_THEME_PLUGIN_INDEX . 'global/details_default.php';
}



