<?php



//
global $wpdb;
global $__cf_row_default;






function WGR_config_list_radio_option ( $arr, $key ) {
	global $__cf_row;
	
	$str = '';
	foreach ( $arr as $k => $v ) {
		$label_id = 'label_' . $key . $k;
		
		$sl = '';
		if ( $__cf_row[$key] == $k ) {
			$sl = ' checked="checked"';
		}
		
		$str .= '
<div>
	<input type="radio" name="' . $key . '" id="' .$label_id. '" value="' .$k. '"' . $sl . '>
	<label for="' .$label_id. '">' .$v. '</label>
</div>';
	}
	
	return $str;
}






//
//echo get_home_url() . '<br>' . "\n";
//echo get_site_url() . '<br>' . "\n";



// lấy siteurl và homeurl trong CSDL để fix lại nếu người dùng có nhu cầu
/*
$sql = _eb_q("SELECT *
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name = 'siteurl'
		OR option_name = 'home'
	ORDER BY
		option_id DESC");
//print_r( $sql );

//
$current_homeurl = '';
$current_siteurl = '';
foreach ( $sql as $v ) {
	if ( $v->option_name == 'home' ) {
		$current_homeurl = $v->option_value;
	}
	else if ( $v->option_name == 'siteurl' ) {
		$current_siteurl = $v->option_value;
	}
}
*/
$current_homeurl = _eb_get_option('home');
$current_siteurl = _eb_get_option('siteurl');


// tự động cập nhật lại URL cho bản SSL
if ( eb_web_protocol == 'https' ) {
	$new_current_homeurl = explode( '/', $current_homeurl );
	if ( $new_current_homeurl[0] != 'https:' ) {
		$new_current_homeurl[0] = 'https:';
		
		//
		echo implode( '/', $new_current_homeurl ) . '<br>' . "\n";
		_eb_update_option( 'home', implode( '/', $new_current_homeurl ) );
	}
	
	$new_current_siteurl = explode( '/', $current_siteurl );
	if ( $new_current_siteurl[0] != 'https:' ) {
		$new_current_siteurl[0] = 'https:';
		
		//
		echo implode( '/', $new_current_siteurl ) . '<br>' . "\n";
		_eb_update_option( 'siteurl', implode( '/', $new_current_siteurl ) );
	}
}


//
WGR_auto_update_link_for_demo ( $current_homeurl, $current_siteurl );




//
//print_r( $__cf_row_default );
$__cf_row = $__cf_row_default;
//print_r( $__cf_row );
_eb_get_config( true );
//print_r( $__cf_row );

// Các chức năng dùng chung với config của wp
$__cf_row['cf_title'] = _eb_get_option('blogname');
$__cf_row['cf_description'] = _eb_get_option('blogdescription');

//
if ( (int) $__cf_row['cf_reset_cache'] < 0 ) {
	$__cf_row['cf_reset_cache'] = 60;
}
//print_r( $__cf_row );



//
$arr_cf_reset_cache = array(
	0 => 'Không sử dụng',
	1 => 'Mỗi phút',
	2 => 'Mỗi 2 phút',
	5 => 'Mỗi 5 phút',
	10 => 'Mỗi 10 phút ( Khuyên dùng )',
	15 => 'Mỗi 15 phút',
	30 => 'Mỗi 30 phút'
);
//print_r($arr_cf_reset_cache);
$str_cf_reset_cache = '';
foreach ( $arr_cf_reset_cache as $k => $v ) {
	// Đơn vị tính là phút -> nhân với 60 giây
	$k = $k * 60;
	
	$label_id = 'config_label_id' .$k;
	
	$sl = '';
	if ( $__cf_row['cf_reset_cache'] == $k ) {
		$sl = ' checked="checked"';
	}
	
	$str_cf_reset_cache .= '
<div>
	<input type="radio" name="cf_reset_cache" id="' .$label_id. '" value="' .$k. '"' . $sl . '>
	<label for="' .$label_id. '">' .$v. '</label>
</div>';
}




/*
* Chung
*/
function __eb_create_select_checked_config ( $arr, $val, $key, $file_name = '' ) {
	$str = '';
	
	foreach ( $arr as $k => $v ) {
		
		$label_id = $key . '_id' . $k;
		
		// đánh dấu kiểm
		$sl = '';
		if ( $val == $k ) {
			$sl = ' selected="selected"';
		}
		
		// ví dụ cho code dễ hình dung
		$phai = $k;
		if ( $file_name != '' ) {
			$phai = $file_name;
			if ( $k != '' ) {
				$phai .= '_' . $k;
			}
		}
		
		// tạo HTML
		$str .= '<option value="' .$k. '"' . $sl . '>' .$v. ' (' . $phai . ')</option>';
	}
	
	return '<select name="' . $key . '" id="' .$label_id. '">' . $str . '</select>';
}



function __eb_create_radio_checked_config ( $arr, $val, $key, $file_name = '' ) {
	$str = '';
	
	foreach ( $arr as $k => $v ) {
		
		$label_id = $key . '_id' . $k;
		
		// đánh dấu kiểm
		$sl = '';
		if ( $val == $k ) {
			$sl = ' checked="checked"';
		}
		
		// ví dụ cho code dễ hình dung
		$phai = $k;
		if ( $file_name != '' ) {
			$phai = $file_name;
			if ( $k != '' ) {
				$phai .= '_' . $k;
			}
		}
		
		// tạo HTML
		$str .= '
<div class="ebdesign-table-for ebdesign-table-for-' . $phai . '">
	<input type="radio" name="' . $key . '" id="' .$label_id. '" value="' .$k. '"' . $sl . '>
	<label for="' .$label_id. '">' .$v. ' (' . $phai . ')</label>
</div>';
	}
	
	return trim( $str );
}




$arr_cf_blog_class_style = array(
	'' => 'Thiết lập chiều rộng riêng cho module',
	'w99' => 'Dạng thu gọn, rộng 999px',
	'w90' => 'Dạng tràn khung, rộng 90%, tối đa 1366px',
	'w100' => 'Dạng tràn khung, rộng tối đa theo BODY',
);

$str_cf_blog_class_style = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_blog_class_style'],
	'cf_blog_class_style'
);




/*
* Danh sách tin
*/
$arr_cf_blog_column_style = array(
	'' => 'Một cột, không có menu',
	'noidung_menu' => 'Hai cột, menu nằm bên phải',
	'menu_noidung' => 'Hai cột, menu nằm bên trái',
//	'menu_noidung_menu' => 'Ba cột, menu nằm hai bên',
);

$str_cf_blogs_column_style = __eb_create_select_checked_config(
	$arr_cf_blog_column_style,
	$__cf_row['cf_blogs_column_style'],
	'cf_blogs_column_style',
	'blogs'
);



//
$arr_cf_blog_node_html = array(
	'' => 'Hai cột, ảnh bên trái - chữ bên phải',
	'chu_anh' => 'Hai cột, chữ bên trái - ảnh bên phải',
	'anhtren_chuduoi' => 'Một cột, ảnh bên trên - chữ bên dưới',
	'chutren_anhduoi' => 'Một cột, chữ bên trên - ảnh bên dưới',
	'chi_chu' => 'Một cột, chỉ chữ',
);

$str_cf_blogs_node_html = __eb_create_select_checked_config(
	$arr_cf_blog_node_html,
	$__cf_row['cf_blogs_node_html'],
	'cf_blogs_node_html',
	'blog_details'
);



//
$arr_cf_blogs_num_line = array(
	'' => 'Theo thiết kế mặc định của tác giả',
	'echbay-blog100' => 'Một',
	'echbay-blog50' => 'Hai',
	'echbay-blog33' => 'Ba',
	'echbay-blog25' => 'Bốn',
	'echbay-blog20' => 'Năm',
);

$str_cf_blogs_num_line = __eb_create_select_checked_config(
	$arr_cf_blogs_num_line,
	$__cf_row['cf_blogs_num_line'],
	'cf_blogs_num_line'
);



/*
* Chi tiết tin
*/
$str_cf_blog_column_style = __eb_create_select_checked_config(
	$arr_cf_blog_column_style,
	$__cf_row['cf_blog_column_style'],
	'cf_blog_column_style',
	'blog_details'
);



//
$str_cf_blog_node_html = __eb_create_select_checked_config(
	$arr_cf_blog_node_html,
	$__cf_row['cf_blog_node_html'],
	'cf_blog_node_html',
	'blog_node'
);


/*
* Page
*/
$str_cf_page_class_style = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_page_class_style'],
	'cf_page_class_style'
);


//
$str_cf_page_column_style = __eb_create_select_checked_config(
	$arr_cf_blog_column_style,
	$__cf_row['cf_page_column_style'],
	'cf_page_column_style',
	'page'
);










//
$arr_cf_product_thumbnail_size = array(
	'medium' => 'Thu gọn (medium)',
	'medium_large' => 'Trung bình (medium_large)',
	'large' => 'Lớn (large)',
	'full' => 'Đầy đủ (bản gốc)',
);
//print_r($arr_cf_product_thumbnail_size);
$str_cf_product_thumbnail_size = '';
foreach ( $arr_cf_product_thumbnail_size as $k => $v ) {
	$sl = '';
	if ( $__cf_row['cf_product_thumbnail_size'] == $k ) {
		$sl = ' selected="selected"';
	}
	
	$str_cf_product_thumbnail_size .= '<option value="' . $k . '"' . $sl . '>' . $v . '</option>';
}


//
$arr_cf_product_thumbnail_table_size = $arr_cf_product_thumbnail_size;
//print_r($arr_cf_product_thumbnail_table_size);
$str_cf_product_thumbnail_table_size = '';
foreach ( $arr_cf_product_thumbnail_table_size as $k => $v ) {
	$sl = '';
	if ( $__cf_row['cf_product_thumbnail_table_size'] == $k ) {
		$sl = ' selected="selected"';
	}
	
	$str_cf_product_thumbnail_table_size .= '<option value="' . $k . '"' . $sl . '>' . $v . '</option>';
}


//
$arr_cf_product_thumbnail_mobile_size = array(
	'thumbnail' => 'Bản cắt gọn (thumbnail)',
	'ebmobile' => 'Tối ưu cho mobile (khuyên dùng)',
//	'medium' => 'Thu gọn (medium)',
//	'full' => 'Đầy đủ (bản gốc)',
) + $arr_cf_product_thumbnail_size;
//print_r($arr_cf_product_thumbnail_mobile_size);
$str_cf_product_thumbnail_mobile_size = '';
foreach ( $arr_cf_product_thumbnail_mobile_size as $k => $v ) {
	$sl = '';
	if ( $__cf_row['cf_product_thumbnail_mobile_size'] == $k ) {
		$sl = ' selected="selected"';
	}
	
	$str_cf_product_thumbnail_mobile_size .= '<option value="' . $k . '"' . $sl . '>' . $v . '</option>';
}




//
foreach ( $__cf_row as $k => $v ) {
	if ( trim( $v != '' ) && ! is_numeric($v) ) {
		$__cf_row[$k] = esc_html( $__cf_row[$k] );
	}
}
//print_r($__cf_row);



// list timezone
/**
 * Timezones list with GMT offset
 *
 * @return array
 * @link http://stackoverflow.com/a/9328760
 */
$timezone_wp_full = '';
/*
function get_timezone_list () {
	$zones_array = array();
	$timestamp = time();
	
	// lấy danh sách múi giờ được hỗ trợ bởi PHP
	foreach( timezone_identifiers_list() as $key => $zone ) {
		date_default_timezone_set($zone);
		
		// zone
		$zones_array[$key]['z'] = $zone;
		
		// diff_from_GMT
		$zones_array[$key]['d'] = date('P', $timestamp);
	}
//	print_r( $zones_array );
	
	return $zones_array;
}
foreach( get_timezone_list() as $t ) {
	$timezone_wp_full .= '<option value="' .$t['z']. '">' .$t['d']. ' - ' .$t['z']. '</option>';
}
$timezone_wp_full = '<select name="cf_timezone">' .$timezone_wp_full. '</select>';

// Set lại timezone do function ở trên làm sai giờ
date_default_timezone_set( $__cf_row['cf_timezone'] );
//echo date( 'r', $date_time );
*/

//$timezone_wp_full = file_get_contents( $dir_index . 'timezone.html', 1 );
//$timezone_wp_full = file_get_contents( $dir_index . 'timezone_gmt.html', 1 );




// Danh sách các ngôn ngữ được hỗ trợ
//echo EB_THEME_PLUGIN_INDEX . "\n";
//echo EB_URL_OF_PLUGIN . "\n";
//echo __FILE__ . "\n";
/*
$list_file_for_lang = '';

//
$arr_file_for_lang = glob ( EB_THEME_PLUGIN_INDEX . 'lang/*.{php}', GLOB_BRACE );
//print_r($arr_file_for_lang);
$arr_file_for_lang = array_filter ( $arr_file_for_lang, 'is_file' );
//print_r($arr_file_for_lang);
foreach ( $arr_file_for_lang as $v ) {
	$v = basename( $v );
	$v = explode( '.', $v );
	$v = $v[0];
	
	//
	$sl = '';
	if ( $v == $__cf_row['cf_content_language'] ) {
		$sl = ' selected="selected"';
	}
	
	//
	$list_file_for_lang .= '<option value="' . $v . '" ' . $sl . '>' . $v . '</option>';
}
*/






//
$main_content = EBE_str_template( 'html/' . $include_page . '.html', array(
	'tmp.js' => 'var cf_timezone="' . $__cf_row['cf_timezone'] . '",current_module_config="' . $include_page . '",cf_current_theme_using="' . $__cf_row['cf_current_theme_using'] . '";',
	
	'tmp.config_module_name' => $include_page == 'config_theme' ? 'Cài đặt giao diện' : 'Cấu hình Website',
	'tmp.include_page' => $include_page,
//	'tmp.js_version' => date( 'Ymd-His', filemtime( ECHBAY_PRI_CODE . 'js/config.js' ) ),
	'tmp.js_version' => time(),
	
	'tmp.cf_smtp_encryption' => WGR_config_list_radio_option( array(
		'' => 'Không sử dụng',
		'ssl' => 'Sử dụng mã hóa SSL',
		'tls' => 'Sử dụng mã hóa TLS',
	), 'cf_smtp_encryption' ),
	
	'tmp.cf_sys_email' => WGR_config_list_radio_option( array(
		'' => 'Sử dụng hàm mail() mặc định của server (nhanh, gọn, nhẹ nhưng hay vào spam)',
		'wpmail' => 'Sử dụng WordPress Mail (lâu hơn chút, nhưng ổn định hơn hàm mail() mặc định)',
		'smtp' => 'Sử dụng SMTP email (lâu hơn chút, tỉ lệ vào spam phụ thuộc vào server mail)',
		'pepipost' => 'Sử dụng Pepipost SMTP (miễn phí và khá tốt, ít vào spam, hay vào mục quảng cáo của Gmail)',
	), 'cf_sys_email' ),
	
//	'tmp.ex_dns_prefetch' => $_SERVER['HTTP_HOST'],
	'tmp.timezone_wp_full' => $timezone_wp_full,
	'tmp.cf_reset_cache' => $str_cf_reset_cache,
	
	'tmp.current_homeurl' => $current_homeurl,
	'tmp.current_siteurl' => $current_siteurl,
	
	
	// blog
	'tmp.cf_blog_class_style' => $str_cf_blog_class_style,
	
	'tmp.cf_blogs_column_style' => $str_cf_blogs_column_style,
	'tmp.cf_blogs_node_html' => $str_cf_blogs_node_html,
	'tmp.cf_blogs_num_line' => $str_cf_blogs_num_line,
	
	'tmp.cf_blog_column_style' => $str_cf_blog_column_style,
	'tmp.cf_blog_node_html' => $str_cf_blog_node_html,
	
	// page
	'tmp.cf_page_class_style' => $str_cf_page_class_style,
	'tmp.cf_page_column_style' => $str_cf_page_column_style,
	
	
	'tmp.cf_product_thumbnail_size' => '<select name="cf_product_thumbnail_size">' . $str_cf_product_thumbnail_size . '</select>',
	'tmp.cf_product_thumbnail_table_size' => '<select name="cf_product_thumbnail_table_size">' . $str_cf_product_thumbnail_table_size . '</select>',
	'tmp.cf_product_thumbnail_mobile_size' => '<select name="cf_product_thumbnail_mobile_size">' . $str_cf_product_thumbnail_mobile_size . '</select>',
	
//	'tmp.list_file_for_lang' => '<select name="cf_content_language">' . $list_file_for_lang . '</select>',
	'tmp.list_file_for_lang' => '',
	'tmp.web_admin_link' => admin_link,
), ECHBAY_PRI_CODE );



// cấu hình cho trang thiết kế html
$arr_for_set_template = array();



/*
* Tranh chủ
*/
$arr_for_set_template['cf_home_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_home_class_style'],
	'cf_home_class_style'
);

$arr_for_set_template['cf_home_column_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_column_style,
	$__cf_row['cf_home_column_style'],
	'cf_home_column_style',
	'home'
);



/*
* Tranh danh sách sản phẩm
*/
$arr_for_set_template['cf_cats_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_cats_class_style'],
	'cf_cats_class_style'
);

$arr_for_set_template['cf_cats_column_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_column_style,
	$__cf_row['cf_cats_column_style'],
	'cf_cats_column_style',
	'thread_list'
);

//
$arr_cf_cats_node_html = array(
	'' => 'Một cột, ảnh bên trên - chữ bên dưới',
	'chutren_anhduoi' => 'Một cột, chữ bên trên - ảnh bên dưới',
	'anh_chu' => 'Hai cột, ảnh bên trái - chữ bên phải',
	'chu_anh' => 'Hai cột, chữ bên trái - ảnh bên phải',
);

$arr_for_set_template['cf_cats_node_html'] = __eb_create_select_checked_config(
	$arr_cf_cats_node_html,
	$__cf_row['cf_cats_node_html'],
	'cf_cats_node_html',
	'thread_node'
);

//
$arr_cf_cats_num_line = array(
	'' => 'Theo thiết kế mặc định của tác giả',
	'thread-list100' => 'Một',
	'thread-list50' => 'Hai',
	'thread-list33' => 'Ba',
	'thread-list25' => 'Bốn',
	'thread-list20' => 'Năm',
);

$arr_for_set_template['cf_cats_num_line'] = __eb_create_select_checked_config(
	$arr_cf_cats_num_line,
	$__cf_row['cf_cats_num_line'],
	'cf_cats_num_line'
);



/*
* Trang chi tiết sản phẩm
*/
$arr_for_set_template['cf_post_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_post_class_style'],
	'cf_post_class_style'
);

$arr_for_set_template['cf_post_column_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_column_style,
	$__cf_row['cf_post_column_style'],
	'cf_post_column_style',
	'thread_details'
);

//
$arr_for_set_template['cf_post_node_html'] = __eb_create_select_checked_config(
	$arr_cf_blog_node_html,
	$__cf_row['cf_post_node_html'],
	'cf_post_node_html',
	'thread_details_node'
);



/*
* Trang danh sách blogs
*/
$arr_for_set_template['cf_blogs_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_blogs_class_style'],
	'cf_blogs_class_style'
);



/*
* Trang chi tiết blog
*/
$arr_for_set_template['cf_blogd_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_blogd_class_style'],
	'cf_blogd_class_style'
);

$arr_for_set_template['cf_blog_num_line'] = __eb_create_select_checked_config(
	$arr_cf_blogs_num_line,
	$__cf_row['cf_blog_num_line'],
	'cf_blog_num_line'
);



// top & footer
$arr_for_set_template['cf_top_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_top_class_style'],
	'cf_top_class_style'
);

$arr_for_set_template['cf_footer_class_style'] = __eb_create_select_checked_config(
	$arr_cf_blog_class_style,
	$__cf_row['cf_footer_class_style'],
	'cf_footer_class_style'
);





//
$arr_for_set_template['cf_current_price'] = __eb_create_select_checked_config(
	array(
		'' => 'đ',
		'vn/0111' => 'vnđ',
		'VN/00d0' => 'VNĐ',
		'VND' => 'VND',
		'/00A5' => '&yen;',
		'NT$' => 'NT$',
		'$' => '$',
		'USD' => 'USD',
	),
	$__cf_row['cf_current_price'],
	'cf_current_price'
);





//
if ( $include_page == 'config_theme' ) {
	include ECHBAY_PRI_CODE . 'config_theme_arr.php';
}



// -> HTML
$main_content = EBE_arr_tmp( $arr_for_set_template, $main_content );






// các cấu hình mặc định
$main_content = EBE_arr_tmp( $__cf_row, $main_content );

$main_content = EBE_arr_tmp( $__cf_row_default, $main_content, 'aaa.' );






// cập nhật lại rule cho wp
if ( $__cf_row['cf_remove_category_base'] == 1 ) {
	add_filter( 'shutdown', 'flush_rewrite_rules' );
}




