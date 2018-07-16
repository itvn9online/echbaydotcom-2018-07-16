<?php



//
//print_r( $_POST );
//$arr_for_update_eb_config = array();



//
//_eb_alert( $wpdb->postmeta );
//_eb_alert( $wpdb->options );



// xóa toàn bộ các config cũ đi
/*
_eb_q("DELETE
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . eb_config_id_postmeta, 0);
		*/



// kích hoạt chế độ gửi email qua SMTP nếu có
/*
//if ( ! isset( $_POST['cf_sys_email'] ) || $_POST['cf_sys_email'] == '' ) {
	$_POST['cf_sys_email'] = 0;
//}

//
if ( $_POST ['cf_smtp_host'] != ''
&& $_POST ['cf_smtp_email'] != ''
&& $_POST ['cf_smtp_pass'] != '' ) {
	$_POST['cf_sys_email'] = 1;
}
*/



// Nếu chưa có thì cũng set mặc định
if ( ! isset( $_POST['cf_sys_email'] )
|| $_POST['cf_sys_email'] == '0' ) {
	$_POST['cf_sys_email'] = $__cf_row_default['cf_sys_email'];
}
else if ( $_POST['cf_sys_email'] != '' && $_POST['cf_sys_email'] != 'wpmail' ) {
	// tắt chế độ gửi email qua SMTP nếu 1 trong các thông số này bị thiếu
	if ( $_POST ['cf_smtp_host'] == ''
	|| $_POST ['cf_smtp_email'] == ''
	|| $_POST ['cf_smtp_pass'] == '' ) {
		$_POST['cf_sys_email'] = $__cf_row_default['cf_sys_email'];
	}
}






//
$_POST['cf_tester_mode'] = WGR_default_config('cf_tester_mode');

$_POST['cf_debug_mode'] = WGR_default_config('cf_debug_mode');

$_POST['cf_gtag_id'] = WGR_default_config('cf_gtag_id');

$_POST['cf_on_off_json'] = WGR_default_config('cf_on_off_json');

$_POST['cf_on_off_xmlrpc'] = WGR_default_config('cf_on_off_xmlrpc');
WGR_deny_or_accept_vist_php_file( ABSPATH . 'xmlrpc.php', $_POST['cf_on_off_xmlrpc'], 'XML-RPC' );

$_POST['cf_on_off_wpcron'] = WGR_default_config('cf_on_off_wpcron');
WGR_deny_or_accept_vist_php_file( ABSPATH . 'wp-cron.php', $_POST['cf_on_off_wpcron'], 'WP Cron' );

$_POST['cf_on_off_feed'] = WGR_default_config('cf_on_off_feed');

$_POST['cf_remove_category_base'] = WGR_default_config('cf_remove_category_base');

$_POST['cf_remove_post_option_base'] = WGR_default_config('cf_remove_post_option_base');

$_POST['cf_alow_post_option_index'] = WGR_default_config('cf_alow_post_option_index');

$_POST['cf_on_off_echbay_seo'] = WGR_default_config('cf_on_off_echbay_seo');

$_POST['cf_on_off_echbay_logo'] = WGR_default_config('cf_on_off_echbay_logo');

$_POST['cf_on_off_amp_logo'] = WGR_default_config('cf_on_off_amp_logo');

$_POST['cf_on_off_amp_category'] = WGR_default_config('cf_on_off_amp_category');

$_POST['cf_on_off_amp_product'] = WGR_default_config('cf_on_off_amp_product');

$_POST['cf_on_off_amp_blogs'] = WGR_default_config('cf_on_off_amp_blogs');

$_POST['cf_on_off_amp_blog'] = WGR_default_config('cf_on_off_amp_blog');

$_POST['cf_on_off_auto_update_wp'] = WGR_default_config('cf_on_off_auto_update_wp');

$_POST['cf_disable_auto_get_thumb'] = WGR_default_config('cf_disable_auto_get_thumb');

$_POST['cf_set_link_for_h1'] = WGR_default_config('cf_set_link_for_h1');

$_POST['cf_h1_logo'] = WGR_default_config('cf_h1_logo');

$_POST['cf_set_mask_for_details'] = WGR_default_config('cf_set_mask_for_details');

$_POST['cf_current_price_before'] = WGR_default_config('cf_current_price_before');

$_POST['cf_hide_supper_admin_menu'] = WGR_default_config('cf_hide_supper_admin_menu');

$_POST['cf_alow_edit_theme_plugin'] = WGR_default_config('cf_alow_edit_theme_plugin');

$_POST['cf_alow_edit_plugin_theme'] = WGR_default_config('cf_alow_edit_plugin_theme');

$_POST['cf_set_news_version'] = WGR_default_config('cf_set_news_version');

$_POST['cf_set_raovat_version'] = WGR_default_config('cf_set_raovat_version');

$_POST['cf_remove_raovat_meta'] = WGR_default_config('cf_remove_raovat_meta');

$_POST['cf_echbay_migrate_version'] = WGR_default_config('cf_echbay_migrate_version');

$_POST['cf_search_advanced_auto_submit'] = WGR_default_config('cf_search_advanced_auto_submit');

$_POST['cf_search_by_echbay'] = WGR_default_config('cf_search_by_echbay');

$_POST['cf_global_big_banner'] = WGR_default_config('cf_global_big_banner');

$_POST['cf_arrow_big_banner'] = WGR_default_config('cf_arrow_big_banner');

$_POST['cf_auto_get_ads_size'] = WGR_default_config('cf_auto_get_ads_size');





//
if ( $_POST['cf_title'] == '' ) {
//	$_POST['cf_title'] = web_name;
	$_POST['cf_title'] = $__cf_row_default['cf_title'];
}
_eb_update_option( 'blogname', $_POST['cf_title'] );

if ( $_POST['cf_description'] == '' ) {
//	$_POST['cf_description'] = get_bloginfo('blogdescription');
	$_POST['cf_description'] = $__cf_row_default['cf_description'];
}
_eb_update_option( 'blogdescription', $_POST['cf_description'] );

// cập nhật email chính cho website
$for_update_site_email = '';
if ( $_POST['cf_email_note'] != '' ) {
	$for_update_site_email = trim( $_POST['cf_email_note'] );
}
else if ( $_POST['cf_email'] ) {
	$for_update_site_email = trim( $_POST['cf_email'] );
}
if ( _eb_check_email_type( $for_update_site_email ) == 1 ) {
	_eb_update_option( 'admin_email', $for_update_site_email );
}


if ( $_POST['cf_content_language'] == '' ) {
	$a = get_language_attributes();
	$a = trim( $a );
	$a = str_replace( 'lang="', '', $a );
	$a = str_replace( '"', '', $a );
	
	$_POST['cf_content_language'] = $a;
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






// nếu thuộc tính xá URL phân nhóm cha được kích hoạt -> đặt luôn category_base về .
if ( $_POST['cf_remove_category_base'] == 1 ) {
	_eb_update_option( 'category_base', '.' );
}






//
function WGR_config_doman_only ( $v ) {
	$v = explode( '//', $v );
	if ( isset( $v[1] ) ) {
		$v = $v[1];
	} else {
		$v = $v[0];
	}
	
	$v = explode( '/', $v );
	
	//
	return $v[0];
}

//
if ( isset( $_POST['cf_dns_prefetch'] )
	&& $_POST['cf_dns_prefetch'] != '' ) {
//	&& strstr( $_POST['cf_dns_prefetch'], '/' ) == true ) {
	
	$arr = explode( "\n", trim( $_POST['cf_dns_prefetch'] ) );
	$new_a = array();
	foreach ( $arr as $v ) {
		$v = trim( $v );
		if ( $v != '' ) {
			$new_a[] = WGR_config_doman_only( $v );
		}
	}
	
	//
	if ( empty( $new_a ) ) {
		$_POST['cf_dns_prefetch'] = '';
	}
	else {
		$_POST['cf_dns_prefetch'] = implode( "\n", $new_a );
	}
}


//
if ( isset( $_POST['cf_old_domain'] )
//	&& strstr( $_POST['cf_old_domain'], '/' ) == true
	&& $_POST['cf_old_domain'] != '' ) {
	
	$arr = explode( ',', $_POST['cf_old_domain'] );
	$new_a = array();
	foreach ( $arr as $v ) {
		$v = trim( $v );
		if ( $v != '' ) {
			$new_a[] = WGR_config_doman_only( $v );
		}
	}
	
	//
	if ( empty( $new_a ) ) {
		$_POST['cf_old_domain'] = '';
	}
	else {
		$_POST['cf_old_domain'] = implode( ',', $new_a );
	}
}


//
if ( isset( $_POST['cf_replace_content_full'] )
	&& $_POST['cf_replace_content_full'] != '' ) {
	
	//
	$_POST['cf_replace_content_full'] = trim( $_POST['cf_replace_content_full'] );
	
	//
	$arr = explode( "\n", $_POST['cf_replace_content_full'] );
	$new_a = array();
	foreach ( $arr as $v ) {
		$v = trim( $v );
		
		// dữ liệu chuẩn phải không trống
		// không có dấu # ở đầu
		// có dấu | để chia tách 2 phần dữ liệu
		if ( $v != '' && substr( $v, 0, 1 ) != '#' && strstr( $v, '|' ) == true ) {
			$new_a[] = $v;
		}
	}
	
	//
	if ( empty( $new_a ) ) {
		$_POST['cf_replace_content'] = '';
	}
	else {
		$_POST['cf_replace_content'] = implode( "\n", $new_a );
	}
}




// chỉnh kích thước cho logo theo chuẩn
if ( $_POST['cf_logo'] != '' ) {
	$file_name = $_POST['cf_logo'];
	
	// nếu ảnh là 1 URL hoặc không tồn tại trên host
	if ( strstr( $file_name, '//' ) == true || ! file_exists( $file_name ) ) {
		// chuyển sang up vào cache để check
		$file_name = explode( '/', $_POST['cf_logo'] );
		$file_name = $file_name[ count( $file_name ) - 1 ];
		$file_name = EB_THEME_CACHE . $file_name;
		
		//
		/*
		$url_copy_logo = $_POST['cf_logo'];
		if ( strstr( $url_copy_logo, 'http:' ) == true || strstr( $url_copy_logo, 'https:' ) == true ) {
		}
		else {
			$url_copy_logo = 'http:' . $url_copy_logo;
		}
		*/
		
		// nếu có trong cache rồi thì thôi
		if ( file_exists( $file_name ) ) {
		}
		// nếu ko -> copy về
		else if ( ! copy( $_POST['cf_logo'], $file_name ) ) {
			// nếu lỗi thì trả về file trống
			$file_name = '';
		}
	}
}
// lấy size của logo mặc định
else {
	$file_name = $__cf_row_default['cf_logo'];
}
echo $file_name . '<br>' . "\n";

//
if ( $file_name != '' && file_exists( $file_name ) ) {
	$file_name = getimagesize($file_name);
//	print_r($file_name);
	
	$_POST['cf_size_logo'] = $file_name[1] . '/' . $file_name[0];
	
	//
	if ( $file_name[0] > 400 || $file_name[1] > 400 ) {
		echo '<script type="text/javascript">console.log("Lưu ý! tối ưu kích thước cho logo trước khi up lên");</script>';
	}
	
	//
	if ( (int) $_POST['cf_height_logo'] < 10 ) {
		$_POST['cf_height_logo'] = $file_name[1];
	}
}


// Fixed lại chiều cao logo cho chuẩn
if ( (int) $_POST['cf_height_logo'] < 10 ) {
	$_POST['cf_height_logo'] = $__cf_row_default['cf_height_logo'];
}

// Thêm chiều cao cố định cho logo vào CSS
$_POST['cf_default_css'] .= '.web-logo{height:' . $_POST['cf_height_logo'] . 'px;line-height:' . $_POST['cf_height_logo'] . 'px;}';


// rút gọn css lại
$_POST['cf_default_css'] = WGR_remove_css_multi_comment( $_POST['cf_default_css'] );




// chuyển đơn vị tiền tệ từ sau ra trước
/*
if ( $_POST['cf_current_price_before'] == 1 ) {
	
	//
	$_POST['cf_default_css'] .= '.ebe-currency:after { display:none; } .ebe-currency:before { display: inline-block; }';
	
	
	// đổi đơn vị tiền tệ
	if ( $_POST['cf_current_price'] != '' ) {
		$_POST['cf_default_css'] .= '.ebe-currency:before { content: "' . $_POST['cf_current_price'] . '"; }';
	}
}
// đổi đơn vị tiền tệ
else if ( $_POST['cf_current_price'] != '' ) {
	$_POST['cf_default_css'] .= '.ebe-currency:after { content: "' . $_POST['cf_current_price'] . '"; }';
}
*/
//echo $_POST['cf_default_css'];




// chạy vòng lặp rồi in các dữ liệu vào bảng lưu
foreach( $_POST as $k => $v ) {
//	echo $k . '<br>';
	
	// hải có chữ cf_ ở đầu tiền
//	if ( substr( $k, 0, 3 ) == 'cf_' ) {
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



// FTP root dir
_eb_set_config( 'cf_ftp_root_dir', EBE_get_ftp_root_dir() );



// thời gian update cache
_eb_set_config( 'cf_ngay', date_time );
//$arr_for_update_eb_config[ 'cf_ngay' ] = date_time;

//_eb_set_config( 'cf_web_version', date( 'y.md.Hi', date_time ) );
_eb_set_config( 'cf_web_version', date( 'md.Hi', date_time ) );
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



// với timezone thì cần cho vào file tĩnh, do time sẽ được set trước khi config được
$_POST['cf_timezone'] = get_option( 'timezone_string' );
//echo 'Timezone: ' . $_POST['cf_timezone'] . '<br>' . "\n";

if ( isset( $_POST['cf_timezone'] ) ) {
	$cf_timezone = trim( $_POST['cf_timezone'] );
	
	if ( $cf_timezone != '' && ! is_numeric( $cf_timezone ) ) {
		_eb_set_config( 'cf_timezone', $cf_timezone );
		
		// lưu file thì ko cần sử dụng chức năng bảo vệ chuỗi
		$_POST ['cf_timezone'] = stripslashes ( $_POST ['cf_timezone'] );
		
		//
		_eb_create_file( EB_THEME_CACHE . '___timezone.txt', trim( $_POST['cf_timezone'] ) );
	}
}





// cập nhật lại config cơ bản cho file wp-config.php
$arr_cac_thay_doi = array();

// thêm config mặc định nếu chưa có
function add_default_value_to_wp_config ( $arr, $key, $default_value = 'false' ) {
	global $content_of_new_wp_config;
	
	if ( ! isset( $arr[$key] ) ) {
		$content_of_new_wp_config[0] .= "\n" . "define('" . $key . "', " . $default_value . "); // auto add by Echbaydotcom" . "\n";
	}
}

// lấy nội dung cũ
$content_of_wp_config = trim( file_get_contents( ABSPATH . 'wp-config.php' ) );
//echo nl2br( $content_of_wp_config ) . '<br>' . "\n";

// chỉ thay đổi khi file config theo chuẩn mặc định
$content_of_new_wp_config = explode( "\n", $content_of_wp_config );
if ( trim( $content_of_new_wp_config[0] ) == '<?php' ) {
	
	//
	foreach ( $content_of_new_wp_config as $k => $v ) {
		$v = trim( $v );
		if ( $v != '' && substr( $v, 0, 6 ) == 'define' ) {
			
			// chức năng debug
			if ( strstr( $v, "'WP_DEBUG'" ) == true || strstr( $v, '"WP_DEBUG"' ) == true ) {
//				echo $v . '<br>' . "\n";
				
				//
//				if ( $_POST['cf_tester_mode'] == 1 ) {
				if ( $_POST['cf_debug_mode'] == 1 ) {
					$content_of_new_wp_config[$k] = "define('WP_DEBUG', true);";
				}
				else {
					$content_of_new_wp_config[$k] = "define('WP_DEBUG', false);";
				}
				
				$arr_cac_thay_doi['WP_DEBUG'] = 1;
			}
			// chức năng tự động cập nhật mã nguồn wp
			else if ( strstr( $v, "'WP_AUTO_UPDATE_CORE'" ) == true || strstr( $v, '"WP_AUTO_UPDATE_CORE"' ) == true ) {
//				echo $v . '<br>' . "\n";
				
				if ( $_POST['cf_on_off_auto_update_wp'] != 1 ) {
					$content_of_new_wp_config[$k] = "define('WP_AUTO_UPDATE_CORE', false);";
				}
				else {
					$content_of_new_wp_config[$k] = "define('WP_AUTO_UPDATE_CORE', true);";
				}
				
				$arr_cac_thay_doi['WP_AUTO_UPDATE_CORE'] = 1;
			}
			// cho phép chính sửa theme, plugin
			else if ( strstr( $v, "'DISALLOW_FILE_EDIT'" ) == true || strstr( $v, '"DISALLOW_FILE_EDIT"' ) == true
			|| strstr( $v, "'DISALLOW_FILE_MODS'" ) == true || strstr( $v, '"DISALLOW_FILE_MODS"' ) == true
			// định nghĩa cứng cho URL website -> xóa đi để add lại vào phần đầu trang
			|| strstr( $v, "'WP_SITEURL'" ) == true || strstr( $v, '"WP_SITEURL"' ) == true
			|| strstr( $v, "'WP_HOME'" ) == true || strstr( $v, '"WP_HOME"' ) == true ) {
				$content_of_new_wp_config[$k] = '';
//				unset( $content_of_new_wp_config[$k] );
			}
			
		}
	}
	
	// kiểm tra các cấu hình chưa được thiết lập
	add_default_value_to_wp_config( $arr_cac_thay_doi, 'WP_DEBUG' );
	add_default_value_to_wp_config( $arr_cac_thay_doi, 'WP_AUTO_UPDATE_CORE' );
	
//	add_default_value_to_wp_config( $arr_cac_thay_doi, 'DISALLOW_FILE_EDIT' );
//	add_default_value_to_wp_config( $arr_cac_thay_doi, 'DISALLOW_FILE_MODS' );
	
	
	// tạo URL động cho site dựa vào URL cố định trước đó
	$dynamic_siteurl = explode( '/', $current_siteurl );
	
	// nếu web chạy trong thư mục con -> thêm dấu ' ở cuối
	if ( count( $dynamic_siteurl ) > 3 ) {
		$dynamic_siteurl[2] = '\' . $_SERVER[\'HTTP_HOST\'] . \'';
		$dynamic_siteurl = '\'' . implode( '/', $dynamic_siteurl ) . '\'';
	}
	// nếu không, có thể chốt luôn chính là HOST hiện tại
	else {
		$dynamic_siteurl[2] = '\' . $_SERVER[\'HTTP_HOST\']';
		$dynamic_siteurl = '\'' . implode( '/', $dynamic_siteurl );
	}
	echo '<strong>WP_SITEURL</strong>: ' . $dynamic_siteurl . '<br>' . "\n";
//	exit();
	
	add_default_value_to_wp_config( $arr_cac_thay_doi, 'WP_SITEURL', $dynamic_siteurl );
	add_default_value_to_wp_config( $arr_cac_thay_doi, 'WP_HOME', 'WP_SITEURL' );
	
	
	
	// nếu vẫn đang là salt mặc định -> cập nhật salt mới
	if ( AUTH_KEY == 'put your unique phrase here' ) {
	}
	
	
	//
	$content_of_new_wp_config = implode( "\n", $content_of_new_wp_config );
	//echo nl2br( $content_of_new_wp_config ) . '<br>' . "\n";
	
	
	// tối ưu lại toàn bộ nội dung file wp-config
	$a = explode( "\n", $content_of_new_wp_config );
	$content_of_new_wp_config = '';
	foreach ( $a as $v ) {
		$v = trim( $v );
		if ( $v != '' ) {
			$content_of_new_wp_config .= $v . "\n";
		}
	}
	
	
	// cập nhật lại file wp-config nếu có sự thay đổi
	if ( $content_of_wp_config != $content_of_new_wp_config ) {
		_eb_create_file( ABSPATH . 'wp-config.php', $content_of_new_wp_config );
	}
	
}





//
_eb_log_admin( 'Update config' );




//
include ECHBAY_PRI_CODE . 'func/config_reset_cache.php';



//
_eb_alert('Cập nhật cấu hình website thành công');




