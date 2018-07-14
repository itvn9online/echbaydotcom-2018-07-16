<?php



//
//print_r( $_POST );
//$arr_for_update_eb_config = array();



//
//_eb_alert( $wpdb->postmeta );
//_eb_alert( $wpdb->options );

$_POST['cf_using_top_default'] = WGR_default_config('cf_using_top_default');

$_POST['cf_using_footer_default'] = WGR_default_config('cf_using_footer_default');

$_POST['cf_using_home_default'] = WGR_default_config('cf_using_home_default');

$_POST['cf_using_footer_default'] = WGR_default_config('cf_using_footer_default');

$_POST['cf_details_show_list_next'] = WGR_default_config('cf_details_show_list_next');

$_POST['cf_details_show_list_thumb'] = WGR_default_config('cf_details_show_list_thumb');

$_POST['cf_details_right_thumbnail'] = WGR_default_config('cf_details_right_thumbnail');

$_POST['cf_details_left_thumbnail'] = WGR_default_config('cf_details_left_thumbnail');

$_POST['cf_details_show_quick_cart'] = WGR_default_config('cf_details_show_quick_cart');

$_POST['cf_required_name_cart'] = WGR_default_config('cf_required_name_cart');

$_POST['cf_required_email_cart'] = WGR_default_config('cf_required_email_cart');

$_POST['cf_required_address_cart'] = WGR_default_config('cf_required_address_cart');

$_POST['cf_details_excerpt'] = WGR_default_config('cf_details_excerpt');

$_POST['cf_details_bold_excerpt'] = WGR_default_config('cf_details_bold_excerpt');

$_POST['cf_options_excerpt'] = WGR_default_config('cf_options_excerpt');

$_POST['cf_details_ul_options'] = WGR_default_config('cf_details_ul_options');

$_POST['cf_post_big_banner'] = WGR_default_config('cf_post_big_banner');

$_POST['cf_post_rm_img_width'] = WGR_default_config('cf_post_rm_img_width');

$_POST['cf_blog_rm_img_width'] = WGR_default_config('cf_blog_rm_img_width');

$_POST['cf_blogs_content_bottom'] = WGR_default_config('cf_blogs_content_bottom');


//
$_POST['posts_per_page'] = (int)$_POST['posts_per_page'];
if ( $_POST['posts_per_page'] < 0 ) {
	$_POST['posts_per_page'] = 0;
}
_eb_update_option( 'posts_per_page', $_POST['posts_per_page'] );







// tạo css cho từng module nếu có
function WGR_config_tao_css_chia_cot (
	// thuộc tính của module được kiểm tra
	$column,
	// chiều rộng sidebar
	$width,
	// class css sẽ được điều khiển
	$css1,
	$css2
) {
	
	if ( trim( $column ) != '' && $width > 0 ) {
		$str = '
.' . $css1 . ' .col-sidebar-content,
.' . $css2 . ' .col-sidebar-content {
	width: ' . $width . '%;
}
.' . $css1 . ' .col-main-content,
.' . $css2 . ' .col-main-content {
	width: ' . ( 100 - $width ) . '%;
}'
		;
		
		//
//		$str = _eb_supper_del_line( trim( $str ) );
		
		//
		return $str;
		
	}
	
	//
	return '';
	
}


// Tính toán chiều rộng cho từng module
// chiều rộng mặc định
$cf_global_width_sidebar = (int) $_POST['cf_global_width_sidebar'];

// chiều rộng riêng lẻ
$cf_home_width_sidebar = (int) $_POST['cf_home_width_sidebar'];
$cf_cats_width_sidebar = (int) $_POST['cf_cats_width_sidebar'];
$cf_post_width_sidebar = (int) $_POST['cf_post_width_sidebar'];
$cf_blogs_width_sidebar = (int) $_POST['cf_blogs_width_sidebar'];
$cf_blog_width_sidebar = (int) $_POST['cf_blog_width_sidebar'];

// nếu có chiều rộng chung -> set lại các chiều có kích thước là 0
if ( $cf_global_width_sidebar > 0 ) {
	$cf_home_width_sidebar = ( $cf_home_width_sidebar == 0 ) ? $cf_global_width_sidebar : $cf_home_width_sidebar;
	$cf_cats_width_sidebar = ( $cf_cats_width_sidebar == 0 ) ? $cf_global_width_sidebar : $cf_cats_width_sidebar;
	$cf_post_width_sidebar = ( $cf_post_width_sidebar == 0 ) ? $cf_global_width_sidebar : $cf_post_width_sidebar;
	$cf_blogs_width_sidebar = ( $cf_blogs_width_sidebar == 0 ) ? $cf_global_width_sidebar : $cf_blogs_width_sidebar;
	$cf_blog_width_sidebar = ( $cf_blog_width_sidebar == 0 ) ? $cf_global_width_sidebar : $cf_blog_width_sidebar;
}
$_POST['cf_default_themes_css'] = '';

//
$_POST['cf_default_themes_css'] .= WGR_config_tao_css_chia_cot( $_POST['cf_home_column_style'], $cf_home_width_sidebar, 'home_noidung_menu', 'home_menu_noidung' );

//
$_POST['cf_default_themes_css'] .= WGR_config_tao_css_chia_cot( $_POST['cf_cats_column_style'], $cf_cats_width_sidebar, 'thread_list_noidung_menu', 'thread_list_menu_noidung' );

//
$_POST['cf_default_themes_css'] .= WGR_config_tao_css_chia_cot( $_POST['cf_post_column_style'], $cf_post_width_sidebar, 'thread_details_noidung_menu', 'thread_details_menu_noidung' );

//
$_POST['cf_default_themes_css'] .= WGR_config_tao_css_chia_cot( $_POST['cf_blogs_column_style'], $cf_blogs_width_sidebar, 'blogs_noidung_menu', 'blogs_menu_noidung' );

//
$_POST['cf_default_themes_css'] .= WGR_config_tao_css_chia_cot( $_POST['cf_blog_column_style'], $cf_blog_width_sidebar, 'blog_details_noidung_menu', 'blog_details_menu_noidung' );


// rút gọn css lại
$_POST['cf_default_themes_css'] = WGR_remove_css_multi_comment( $_POST['cf_default_themes_css'] );





// chạy vòng lặp rồi in các dữ liệu vào bảng lưu
foreach( $_POST as $k => $v ) {
//	echo $k . '<br>';
	
	// hải có chữ cf_ ở đầu tiền
	if ( substr( $k, 0, 3 ) == 'cf_' ) {
		if ( isset( $__cf_row_default[ $k ] ) ) {
//			echo 'insert<br>';
//			echo $v . '<br>';
			
			//
			_eb_set_config( $k, $v );
			
//			$arr_for_update_eb_config[ $k ] = addslashes( WGR_stripslashes ( $v ) );
			
			//
//			$v = sanitize_text_field( $v );
//			$arr_for_update_eb_config[ $k ] = $v;
		}
		else {
			echo 'Update __cf_row_default only<br>' . "\n";
		}
	}
	else {
		echo 'Update cf_ only (' . $k . ')<br>' . "\n";
	}
}




//
_eb_log_admin( 'Update config theme' );




//
include ECHBAY_PRI_CODE . 'func/config_reset_cache.php';



//
_eb_alert('Cập nhật Giao diện website thành công');




