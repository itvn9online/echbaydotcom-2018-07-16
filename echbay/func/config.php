<?php



//
//$arr_for_update_eb_config = array();



//
//_eb_alert( $wpdb->postmeta );
//_eb_alert( $wpdb->options );



// xóa toàn bộ các config cũ đi
/*
_eb_q("DELETE
	FROM
		" . wp_postmeta . "
	WHERE
		post_id = " . eb_config_id_postmeta);
		*/



// kích hoạt chế độ gửi email qua SMTP nếu có
if ( ! isset( $_POST['cf_sys_email'] ) || $_POST['cf_sys_email'] == '' ) {
	$_POST['cf_sys_email'] = 0;
}

//
if ( $_POST ['cf_smtp_host'] != ''
&& $_POST ['cf_smtp_email'] != ''
&& $_POST ['cf_smtp_pass'] != '' ) {
	$_POST['cf_sys_email'] = 1;
}






//
if ( ! isset( $_POST['cf_tester_mode'] ) || $_POST['cf_tester_mode'] == '' ) {
	$_POST['cf_tester_mode'] = 0;
}

if ( ! isset( $_POST['cf_on_off_json'] ) || $_POST['cf_on_off_json'] == '' ) {
	$_POST['cf_on_off_json'] = 0;
}

if ( ! isset( $_POST['cf_remove_category_base'] ) || $_POST['cf_remove_category_base'] == '' ) {
	$_POST['cf_remove_category_base'] = 0;
}

if ( ! isset( $_POST['cf_on_off_echbay_seo'] ) || $_POST['cf_on_off_echbay_seo'] == '' ) {
	$_POST['cf_on_off_echbay_seo'] = 0;
}

if ( ! isset( $_POST['cf_on_off_echbay_logo'] ) || $_POST['cf_on_off_echbay_logo'] == '' ) {
	$_POST['cf_on_off_echbay_logo'] = 0;
}

if ( ! isset( $_POST['cf_on_off_amp_logo'] ) || $_POST['cf_on_off_amp_logo'] == '' ) {
	$_POST['cf_on_off_amp_logo'] = 0;
}

if ( ! isset( $_POST['cf_on_off_amp_category'] ) || $_POST['cf_on_off_amp_category'] == '' ) {
	$_POST['cf_on_off_amp_category'] = 0;
}

if ( ! isset( $_POST['cf_on_off_amp_product'] ) || $_POST['cf_on_off_amp_product'] == '' ) {
	$_POST['cf_on_off_amp_product'] = 0;
}

if ( ! isset( $_POST['cf_on_off_amp_blogs'] ) || $_POST['cf_on_off_amp_blogs'] == '' ) {
	$_POST['cf_on_off_amp_blogs'] = 0;
}

if ( ! isset( $_POST['cf_on_off_amp_blog'] ) || $_POST['cf_on_off_amp_blog'] == '' ) {
	$_POST['cf_on_off_amp_blog'] = 0;
}





//
if ( $_POST['cf_title'] == '' ) {
	$_POST['cf_title'] = web_name;
}

if ( $_POST['cf_description'] == '' ) {
	$_POST['cf_description'] = get_bloginfo('blogdescription');
}





//
$current_homeurl = trim( $_POST['current_homeurl'] );
if ( $current_homeurl == '' ) {
	$current_homeurl = web_link;
}
// xóa dấu / ở cuối
if ( substr( $current_homeurl, -1 ) == '/' ) {
	$current_homeurl = substr( $current_homeurl, 0, -1 );
}
//echo $current_homeurl . '<br>' . "\n";

//update_option( 'home', $current_homeurl );
_eb_update_option( 'home', $current_homeurl );
//echo $current_homeurl . '<br>' . "\n";



$current_siteurl = trim( $_POST['current_siteurl'] );
if ( $current_siteurl == '' ) {
	$current_siteurl = web_link;
}
// xóa dấu / ở cuối
if ( substr( $current_siteurl, -1 ) == '/' ) {
	$current_siteurl = substr( $current_siteurl, 0, -1 );
}
//echo $current_siteurl . '<br>' . "\n";

//update_option( 'siteurl', $current_siteurl );
_eb_update_option( 'siteurl', $current_siteurl );
//echo $current_siteurl . '<br>' . "\n";






//
if ( isset( $_POST['cf_dns_prefetch'] )
&& $_POST['cf_dns_prefetch'] != ''
&& strstr( $_POST['cf_dns_prefetch'], '/' ) == true ) {
	$a = explode( '//', $_POST['cf_dns_prefetch'] );
	if ( isset( $a[1] ) ) {
		$a = $a[1];
	} else {
		$a = $a[0];
	}
	
	$a = explode( '/', $a );
	$a = $a[0];
	
	$_POST['cf_dns_prefetch'] = $a;
}



// chạy vòng lặp rồi in các dữ liệu vào bảng lưu
foreach( $_POST as $k => $v ) {
//	echo $k . '<br>';
	
	// hải có chữ cf_ ở đầu tiền
	if ( substr( $k, 0, 3 ) == 'cf_' ) {
//		echo 'insert<br>';
//		echo $v . '<br>';
		
		//
		_eb_set_config( $k, $v );
		
//		$arr_for_update_eb_config[ $k ] = addslashes( stripslashes ( stripslashes ( stripslashes ( $v ) ) ) );
		
		//
//		$v = sanitize_text_field( $v );
//		$arr_for_update_eb_config[ $k ] = $v;
	}
}


// thời gian update cache
_eb_set_config( 'cf_ngay', date_time );
//$arr_for_update_eb_config[ 'cf_ngay' ] = date_time;

_eb_set_config( 'cf_web_version', date( 'y.md.Hi', date_time ) );
//$arr_for_update_eb_config[ 'cf_web_version' ] = date( 'y.md.Hi', date_time );

// xóa config cũ đi -> tránh cache lưu lại
//delete_option( eb_conf_obj_option );

// lưu mới
//add_option( eb_conf_obj_option, $arr_for_update_eb_config, '', 'no' );



// xóa các cấu hình cũ đi cho đỡ vướng
//foreach ( $arr_for_update_eb_config as $k => $v ) {
//	echo _eb_option_prefix . $k . '<br>' . "\n";
//	delete_option( _eb_option_prefix . $k );
//}



// với timezone thì cần cho vào file tĩnh, do time sẽ được set trước khi config được được
if ( isset( $_POST['cf_timezone'] ) ) {
	$cf_timezone = trim( $_POST['cf_timezone'] );
	if ( $cf_timezone != '' ) {
		// lưu file thì ko cần sử dụng chức năng bảo vệ chuỗi
		$_POST ['cf_timezone'] = stripslashes ( $_POST ['cf_timezone'] );
		
		//
		_eb_create_file( EB_THEME_CACHE . '___timezone.txt', trim( $_POST['cf_timezone'] ) );
	}
}




//
_eb_log_admin( 'Update config' );



//
_eb_alert('Cập nhật cấu hình website thành công');




