<?php



//
//print_r( $_POST );
//$arr_for_update_eb_config = array();



//
//_eb_alert( $wpdb->postmeta );
//_eb_alert( $wpdb->options );

if ( ! isset( $_POST['cf_using_top_default'] ) || (int) $_POST['cf_using_top_default'] != 1 ) {
	$_POST['cf_using_top_default'] = 0;
}

if ( ! isset( $_POST['cf_using_footer_default'] ) || (int) $_POST['cf_using_footer_default'] != 1 ) {
	$_POST['cf_using_footer_default'] = 0;
}

if ( ! isset( $_POST['cf_using_home_default'] ) || (int) $_POST['cf_using_home_default'] != 1 ) {
	$_POST['cf_using_home_default'] = 0;
}

if ( ! isset( $_POST['cf_using_cats_default'] ) || (int) $_POST['cf_using_footer_default'] != 1 ) {
	$_POST['cf_using_cats_default'] = 0;
}

if ( ! isset( $_POST['cf_details_show_list_next'] ) || (int) $_POST['cf_details_show_list_next'] != 1 ) {
	$_POST['cf_details_show_list_next'] = 0;
}

if ( ! isset( $_POST['cf_details_show_list_thumb'] ) || (int) $_POST['cf_details_show_list_thumb'] != 1 ) {
	$_POST['cf_details_show_list_thumb'] = 0;
}


//
$_POST['posts_per_page'] = (int)$_POST['posts_per_page'];
if ( $_POST['posts_per_page'] < 0 ) {
	$_POST['posts_per_page'] = 0;
}
_eb_update_option( 'posts_per_page', $_POST['posts_per_page'] );





// Fixed lại chiều cao logo cho chuẩn
$cats_width_sidebar = (int) $_POST['cf_cats_width_sidebar'];

if ( trim( $_POST['cf_cats_column_style'] ) != '' && $cats_width_sidebar > 0 ) {
	$_POST['cf_default_css'] .= _eb_supper_del_line( '.thread_list_noidung_menu .custom-width-cats-sidebar,
.thread_list_menu_noidung .custom-width-cats-sidebar {
	width: ' . $cats_width_sidebar . '%;
}
.thread_list_noidung_menu .custom-width-cats-main,
.thread_list_menu_noidung .custom-width-cats-main {
	width: ' . ( 100 - $cats_width_sidebar ) . '%;
}' );
}





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
			
//			$arr_for_update_eb_config[ $k ] = addslashes( stripslashes ( stripslashes ( stripslashes ( $v ) ) ) );
			
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




