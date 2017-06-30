<?php



include EB_THEME_CORE . 'config.php';
//print_r($d);

//include EB_THEME_OUTSOURCE . 'phpmailer/PHPMailerAutoload.php';

include EB_THEME_CORE . 'curl.php';
include EB_THEME_CORE . 'email_via_echbay.php';


/*
* class riêng của echbay -> chuyển qua dùng function hết cho tiện, đỡ phải global
*/
include EB_THEME_CORE . 'func.php';




//
//$connect_mysqli = mysqli_connect( $dbhost, $d[1], $d[2], $d[0] ) or die ( 'c1' );
//mysqli_query($connect_mysqli, "SET NAMES 'UTF8'");



//
//$default_all_timezone = 'Asia/Saigon';
$default_all_timezone = 'Asia/Ho_Chi_Minh';
//echo current_time( 'timestamp' );
date_default_timezone_set ( $default_all_timezone );
/*
echo get_option('gmt_offset');
echo get_option('timezone_string');
$get_timezone_file = EB_THEME_CACHE . '___timezone.txt';
//echo $get_timezone_file;
if ( file_exists ( $get_timezone_file ) ) {
	$default_all_timezone = file_get_contents( $get_timezone_file );
}
//date_default_timezone_set ( $default_all_timezone );
date_default_timezone_set ( get_option('gmt_offset') );
*/

//
$date_time = time ();
//$date_time = current_time( 'timestamp' );
$date_server = date ( 'Y-m-d', $date_time );
$time_server = date ( 'H:i:s', $date_time );
$year_curent = substr ( $date_server, 0, 4 );
$month_curent = substr ( $date_server, 5, 2 );
$day_curent = substr ( $date_server, 8, 2 );

//
define( 'date_time', $date_time );
//echo date( 'r', date_time ) . '<br>';

//
define( 'date_server', $date_server );
//echo date( 'r', date_time ) . '<br>';



//
$eb_background_for_post = array();




if ( isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ) ) {
	$client_ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
}
else if ( isset ( $_SERVER ['HTTP_X_REAL_IP'] ) ) {
	$client_ip = $_SERVER ['HTTP_X_REAL_IP'];
}
else if ( isset ( $_SERVER ['HTTP_CLIENT_IP'] ) ) {
	$client_ip = $_SERVER ['HTTP_CLIENT_IP'];
}
else {
	$client_ip = $_SERVER ['REMOTE_ADDR'];
}







/*
* Để đỡ phải tạo thêm bảng -> sử dụng post ID để phân biệt giữa các dữ liệu mới
* Tạo số thật lớn, những số mà với website bình thường chả bao giwof đạt được post ID như vậy
*/

/*
* sử dụng bảng wp_postmeta
*/
// cấu hình website
define( 'eb_config_id_postmeta', 100000000 );

// log click
define( 'eb_log_click_id_postmeta', 100000010 );

// log user và log admin phân biệt bởi tên
define( 'eb_log_user_id_postmeta', 100000020 );

// log tìm kiếm
define( 'eb_log_search_id_postmeta', 100000030 );

// chức năng thay đổi ngôn ngữ trên website
define( 'eb_languages_id_postmeta', 100000099 );

// 404 monitor
define( 'eb_log_404_id_postmeta', 100000404 );

/*
* sử dụng bảng wp_comments
*/
// đơn hàng
define( 'eb_order_id_comments', 200000000 );

// cho chức năng liên hệ
define( 'eb_contact_id_comments', 200000090 );


// thuộc tính dùng để lưu và lấy thông tin khác của post
define( 'eb_post_obj_data', '_eb_post_obj_data' );
define( 'eb_cat_obj_data', '_eb_cat_obj_data' );


//
define( 'eb_conf_obj_option', '_eb_cf_obj' );





// thời gian mặc định cho cache
define( 'eb_default_cache_time', 120 );

//
define( 'eb_default_vaficon', EB_URL_TUONG_DOI . 'favicon.png' );
$default_all_site_lang = 'vi';

// mảng các tham số dành cho cấu hình website, cần thêm thuộc tính gì thì cứ thế add vào mảng này là được
$__cf_row_default = array(
	'cf_chu_de_chinh' => '',
	
	'cf_smtp_email' => '',
	'cf_smtp_pass' => '',
	'cf_smtp_host' => '',
	'cf_smtp_port' => 25,
	
	'cf_title' => 'Một website sử dụng plugin thương mại điện tử của EchBay.com',
	'cf_meta_title' => 'Một website sử dụng plugin thương mại điện tử của EchBay.com',
	'cf_keywords' => 'wordpress e-commerce plugin, echbay.com, thiet ke web chuyen nghiep',
	'cf_news_keywords' => 'wordpress e-commerce plugin, echbay.com, thiet ke web chuyen nghiep',
	'cf_description' => 'Một website sử dụng plugin thương mại điện tử của EchBay.com',
	'cf_abstract' => '',
	
	'cf_gse' => '',
	'cf_ga_id' => '',
	
	'cf_sys_email' => 0,
	
	'cf_logo' => EB_URL_TUONG_DOI . 'logo.png',
	'cf_favicon' => eb_default_vaficon,
	
	'cf_ten_cty' => '',
//	'web_name' => '',
	
	'cf_email' => 'lienhe@echbay.com',
	'cf_email_note' => '',
	
	'cf_dienthoai' => '0984 533 228',
	'cf_call_dienthoai' => '',
	'cf_hotline' => '0984 533 228',
	'cf_call_hotline' => '',
	
	'cf_diachi' => 'Văn Khê, Hà Đông, Hà Nội, Việt Nam',
	
	'cf_bank' => '',
	
	'cf_facebook_page' => '',
	'cf_facebook_id' => '',
	'cf_facebook_admin_id' => '',
	'cf_google_plus' => '',
	'cf_youtube_chanel' => '',
	'cf_twitter_page' => '',
	'cf_yahoo' => '',
	'cf_skype' => '',
	
	'cf_js_allpage' => '',
	'cf_js_allpage_full' => '',
	'cf_js_hoan_tat' => '',
	'cf_js_hoan_tat_full' => '',
	'cf_js_head' => '',
	'cf_js_head_full' => '',
	'cf_js_details' => '',
	'cf_js_details_full' => '',
	
	// màu cơ bản
	'cf_default_css' => '',
	
	'cf_default_body_bg' => '#ffffff',
	'cf_default_color' => '#000000',
	'cf_default_link_color' => '#1264aa',
	
	'cf_default_bg' => '#ff4400',
	'cf_default_2bg' => '#555555',
	'cf_default_bg_color' => '#ffffff',
	'cf_default_amp_bg' => '#0a89c0',
	
	
	'cf_product_size' => '1',
	'cf_product_mobile_size' => '140',
	'cf_product_table_size' => '200',
	'cf_product_details_size' => '1',
	'cf_blog_size' => '2/3',
	'cf_top_banner_size' => '400/1366',
	'cf_other_banner_size' => '2/3',
	
	'cf_num_home_hot' => 0,
	'cf_num_home_new' => 0,
//	'cf_num_home_view' => 0,
	'cf_num_home_list' => 0,
	'cf_num_limit_home_list' => 100,
//	'cf_num_thread_list' => 10,
	'cf_num_details_list' => 10,
	'cf_num_details_blog_list' => 10,
	
	// kích thước mặc định của ảnh đại diện
	'cf_product_thumbnail_size' => 'medium',
	'cf_product_thumbnail_table_size' => 'medium',
	'cf_product_thumbnail_mobile_size' => 'ebmobile',
	'cf_ads_thumbnail_size' => 'full',
	
	'cf_region' => '',
	'cf_placename' => 'Ha Noi',
	'cf_position' => '',
	'cf_content_language' => $default_all_site_lang,
	'cf_gg_api_key' => '',
	'cf_timezone' => $default_all_timezone,
	
	'cf_reset_cache' => eb_default_cache_time,
	'cf_dns_prefetch' => '',
	'cf_blog_public' => 1,
	'cf_tester_mode' => 1,
	'cf_theme_dir' => '',
	
	// cài đặt cho bản AMP
	'cf_blog_amp' => 1,
	'cf_blog_details_amp' => 1,
	'cf_product_amp' => 1,
	'cf_product_details_amp' => 0,
	'cf_product_buy_amp' => 0,
	
	
	// bật/ tắt JSON
	'cf_on_off_json' => 1,
	
	// xóa URL cha của phân nhóm
	'cf_remove_category_base' => 0,
	
	// plugin SEO của EchBay
	'cf_on_off_echbay_seo' => 1,
	
	// logo thiết kế bởi echbay
	'cf_on_off_echbay_logo' => 1,
	
	// on/ off AMP
	'cf_on_off_amp_logo' => 0,
	'cf_on_off_amp_category' => 1,
	'cf_on_off_amp_product' => 0,
	'cf_on_off_amp_blogs' => 1,
	'cf_on_off_amp_blog' => 1,
	
	// tự động cập nhật mã nguồn wordpress
	'cf_on_off_auto_update_wp' => 0,
	
	
	/*
	* giao diện HTML mặc định
	*/
	// class bao viền (w99, w90)
	'cf_blog_class_style' => '',
	
	'cf_using_top_default' => 1,
	'cf_top_class_style' => '',
	
	'cf_using_footer_default' => 1,
	'cf_footer_class_style' => '',
	
	
	// danh sách tin -> tổng quan
	'cf_home_class_style' => '',
	'cf_home_column_style' => '',
	
	
	// danh sách tin -> tổng quan
	'cf_cats_class_style' => '',
	'cf_cats_column_style' => '',
	// danh sách tin -> html cho phần node
	'cf_cats_node_html' => '',
	// danh sách tin -> số tin trên mỗi dòng
	'cf_cats_num_line' => '',
	
	// chi tiết -> tổng quan
	'cf_post_class_style' => '',
	'cf_post_column_style' => '',
	// chi tiết -> html cho phần node
	'cf_post_node_html' => '',
	
	
	// danh sách tin -> tổng quan
	'cf_blogs_class_style' => '',
	'cf_blogs_column_style' => '',
	// danh sách tin -> html cho phần node
	'cf_blogs_node_html' => '',
	// danh sách tin -> số tin trên mỗi dòng
	'cf_blogs_num_line' => '',
	
	// chi tiết -> tổng quan
	'cf_blogd_class_style' => '',
	'cf_blog_column_style' => '',
	// chi tiết -> html cho phần node
	'cf_blog_node_html' => '',
	'cf_blog_num_line' => '',
	
	
	// class bao viền (w99, w90)
	'cf_page_class_style' => '',
	// chi tiết -> tổng quan
	'cf_page_column_style' => '',
	
	
	'cf_web_version' => 1.0,
	'cf_ngay' => date_time,
);

//
$__cf_row = $__cf_row_default;




/*
* Kiểm tra người dùng đăng nhập chưa
*/
$mtv_id = 0;
$mtv_email = '';

//
//echo is_user_logged_in();
if ( is_user_logged_in() ) {
	$eb_user_info = wp_get_current_user();
//	print_r( $eb_user_info );
	
	//
	$mtv_id = $eb_user_info->ID;
	//echo $mtv_id;
	
	$mtv_email = $eb_user_info->user_email;
	//echo $mtv_email;
}
define( 'mtv_id', $mtv_id );
define( 'mtv_email', $mtv_email );





// thời gian lưu cache
//$cf_reset_cache = 120;
//echo $localhost . '<br>' . "\n";
//echo WP_DEBUG . '<br>';
if ( $localhost == 1 ) {
//if ( WP_DEBUG == true || $localhost == 1 ) {
//if ( eb_code_tester == true || $localhost == 1 ) {
//	$cf_reset_cache = 5;
	$__cf_row['cf_reset_cache'] = 10;
	/*
}
else {
	$cf_reset_cache = $__cf_row['cf_reset_cache'];
	*/
}





//
$web_name = '';
$web_link = '';




//
//print_r( $__cf_row );
include EB_THEME_CORE . 'cache.php';
//print_r( $__cf_row );



//
if ( $__cf_row['cf_tester_mode'] == 1 ) {
	define( 'eb_code_tester', true );
} else {
	define( 'eb_code_tester', false );
}



//
//echo $__cf_row['cf_reset_cache'] . '<br>';





// ngôn ngữ trên website
include EB_THEME_PLUGIN_INDEX . 'lang/' . $default_all_site_lang . '.php';
if ( $__cf_row['cf_content_language'] != $default_all_site_lang && $__cf_row['cf_content_language'] != '' ) {
	include EB_THEME_PLUGIN_INDEX . 'lang/' . $__cf_row['cf_content_language'] . '.php';
}

// cập nhật lang vào file js
$strCacheFilter = 'lang';
$check_update_lang = _eb_get_static_html ( $strCacheFilter, '', '', 3600 );
if ($check_update_lang == false) {
//	print_r($___eb_lang);
	
	//
	$str_js_lang = 'var ___eb_lang = [];' . "\n";
	foreach ( $___eb_lang as $k => $v ) {
		$str_js_lang .= '___eb_lang["' . $k . '"] = "' . _eb_str_block_fix_content( $v ) . '";' . "\n";
	}
	
	//
	_eb_create_file ( EB_THEME_CACHE . 'lang.js', $str_js_lang );
	
	//
	_eb_get_static_html ( $strCacheFilter, date( 'r', time() ), '', 60 );
}
$url_for_js_lang = 'wp-content/uploads/ebcache/lang.js';





// trạng thái đơn
$arr_hd_trangthai = array (
		-1 => '[ XÓA ]',
		0 => 'Chưa xác nhận',
		1 => 'Xác nhận, chờ giao',
		2 => 'Đơn giờ vàng',
		3 => 'Đang xác nhận',
		4 => '[ Đã hủy ]',
		5 => 'Xác nhận, chờ hàng',
		6 => 'Không liên lạc được',
		7 => 'Liên hệ lại',
		8 => 'Đặt trước, đã thanh toán',
		9 => 'Hoàn tất' 
);


//
$arr_eb_category_status = array(
	0 => '[ Mặc định ]',
	1 => 'Ưu tiên cấp 1',
	2 => 'Ưu tiên cấp 2',
	3 => 'Ưu tiên cấp 3',
	4 => 'Ưu tiên cấp 4',
	5 => 'Ưu tiên cấp 5',
	6 => 'Định dạng cho kích cỡ',
	7 => 'Định dạng cho màu sắc',
	8 => 'Định dạng cho khoảng giá',
);




/*
* Global setting
*/
$act = '';

//
define( 'web_name', $web_name );
//echo web_name;

define( 'web_link', $web_link );
//echo web_link;




// bật tắt EchBay SEO plugin
define( 'cf_on_off_echbay_seo', $__cf_row['cf_on_off_echbay_seo'] );





//
$___eb_post__not_in = '';
$___eb_ads__not_in = '';






// phiên bản
$web_version = $__cf_row['cf_web_version'];
if ( $localhost == 1 ) $web_version = $date_time;
define( 'web_version', $web_version );
//echo $web_version;





