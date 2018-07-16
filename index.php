<?php


/*
* This is private plugin
* Not active
* Các function và giao diện dùng chung cho theme của EchBay sẽ được viết vào plugin này, trường hợp theme sử dụng giao diện riêng thì file html sẽ được viết trong theme -> code kiểm tra có file riêng sẽ sử dụng nó thay vì file chung
*/




//
//$all_sizes = get_intermediate_image_sizes();
//print_r( $all_sizes );






/*
* Các function hay được sử dụng nhất
// -> lấy url phân nhóm
get_category_link( $id ) -> dùng function riêng cũng được -> _eb_c_link( $id )
*/





//
//echo $wpdb->postmeta . '<br>';
define( 'wp_postmeta', $wpdb->postmeta );
//echo wp_postmeta;
define( 'wp_termmeta', $wpdb->termmeta );
//echo $wpdb->posts . '<br>';
define( 'wp_posts', $wpdb->posts );


//
if ( defined('EB_CHILD_THEME_URL') ) {
	define( 'using_child_wgr_theme', 1 );
}
else {
	define( 'using_child_wgr_theme', 0 );
}





// danh sách toàn bộ các theme được hỗ trợ
$eb_all_themes_support = array();

//
$arr_posts_structure = NULL;





// mảng dùng để truyền css tương ứng vào theme
/*
* Các file CSS nằm trong plugin tổng sẽ được add trước
* Sau đó là các css của theme -> nó sẽ replace các css được viết trước đó
*/
//$arr_for_add_js = array();
$arr_for_add_css = array();
//$arr_for_add_theme_css = array();


// Load các CSS ưu tiên mặc định
// loại css add thẳng vào html chỉ dành cho trang đầu tiên
$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/d.css' ] = 0;
// các css kém quan trọng hơn thì cho vào đây
$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/d2.css' ] = 1;
$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/m.css' ] = 0;
$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/g.css' ] = 1;

//
//$arr_for_add_theme_css[ EB_THEME_URL . 'css/style.css' ] = 1;
if ( using_child_wgr_theme == 1 ) {
	$arr_for_add_css[ EB_CHILD_THEME_URL . 'css/style.css' ] = 1;
	$arr_for_add_css[ EB_CHILD_THEME_URL . 'css/mobile.css' ] = 1;
}
else {
	$arr_for_add_css[ EB_THEME_URL . 'css/style.css' ] = 1;
	
	// cho phiên bản mobile
	//$arr_for_add_theme_css[ EB_THEME_URL . 'css/mobile.css' ] = 1;
	$arr_for_add_css[ EB_THEME_URL . 'css/mobile.css' ] = 1;
	
	// tối ưu cho màn hình đầu tiên
	//$arr_for_add_css[ EB_THEME_URL . 'css/first_screen.css' ] = 1;
}



// mảng dùng để thông báo các module HTML được load ra
$arr_for_show_html_file_load = array();



//
//echo EB_THEME_PLUGIN_INDEX . '<br>';




// thư mục public_html hoặc www của web
//define( 'ABSPATH', dirname( dirname( dirname( __FILE__ ) ) ) . '/' );
//define( 'ABSPATH', ABSPATH );
//echo 'ABSPATH: ' . ABSPATH . '<br>';



// nếu thư mục content đã được khai báo -> lấy thư mục theo thông số này
if ( defined('WP_CONTENT_DIR') ) {
	define( 'EB_DIR_CONTENT', basename( WP_CONTENT_DIR ) );
	define( 'EB_THEME_CONTENT', WP_CONTENT_DIR . '/' );
}
// Không thì khai báo mặc định
else {
	// tên thư mục chứa content
	define( 'EB_DIR_CONTENT', 'wp-content' );
	
	// thư mục đầy đủ của content
	define( 'WP_CONTENT_DIR', ABSPATH . EB_DIR_CONTENT );
	
//	define( 'EB_THEME_CONTENT', EB_WEB_PUBLIC_HTML . EB_DIR_CONTENT . '/' );
	define( 'EB_THEME_CONTENT', WP_CONTENT_DIR . '/' );
}
//echo 'WP_CONTENT_DIR: ' . WP_CONTENT_DIR . '<br>';
//echo 'EB_WEB_PUBLIC_HTML: ' . EB_WEB_PUBLIC_HTML . '<br>';
//echo 'EB_THEME_CONTENT: ' . EB_THEME_CONTENT . '<br>';
//echo 'WP_CONTENT_DIR: ' . WP_CONTENT_DIR . '<br>';
//echo basename( EB_THEME_CONTENT ) . '<br>' . "\n";



//
/*
if ( ! defined('EB_THEME_PLUGIN_INDEX') ) {
	define( 'EB_THEME_PLUGIN_INDEX', EB_THEME_CONTENT . 'echbaydotcom/' );
	echo 'EB_THEME_PLUGIN_INDEX: ' . EB_THEME_PLUGIN_INDEX . '<br>';
}
*/


//define( 'EB_THEME_OUTSOURCE', EB_THEME_URL . 'outsource/' );
define( 'EB_THEME_OUTSOURCE', EB_THEME_PLUGIN_INDEX . 'outsource/' );
//echo 'EB_THEME_OUTSOURCE: ' . EB_THEME_OUTSOURCE . '<br>';

//define( 'EB_THEME_CORE', EB_THEME_URL . 'plugin/class/' );
define( 'EB_THEME_CORE', EB_THEME_PLUGIN_INDEX . 'class/' );
//echo 'EB_THEME_CORE: ' . EB_THEME_CORE . '<br>';

// thư mục các file code riêng của Ếch Bay (thuộc lớp quản trị viên)
//define( 'ECHBAY_PRI_CODE', EB_THEME_URL . 'plugin/echbay/' );
define( 'ECHBAY_PRI_CODE', EB_THEME_PLUGIN_INDEX . 'echbay/' );
//echo ECHBAY_PRI_CODE . '<br>';



/*
* theme
*/
// thư mục lưu trữ các file template html
define( 'EB_THEME_THEME', EB_THEME_URL );
//echo EB_THEME_THEME . '<br>';

// thư mục lưu trữ các file template html
define( 'EB_THEME_HTML', EB_THEME_THEME . 'html/' );
//echo EB_THEME_HTML . '<br>';

// thư mục lưu trữ các file php để chạy các trang tương ứng
define( 'EB_THEME_PHP', EB_THEME_THEME . 'php/' );
//echo EB_THEME_PHP . '<br>';

// URL tương đối
define( 'EB_URL_TUONG_DOI', EB_DIR_CONTENT . '/echbaydotcom/' );

// thư mục lưu trữ cache
define( 'EB_THEME_CACHE', EB_THEME_CONTENT . 'uploads/ebcache/' );
//echo EB_THEME_CACHE . '<br>';

// Định dang riêng cho post type blog
define( 'EB_BLOG_POST_TYPE', 'blog' );
define( 'EB_BLOG_POST_LINK', EB_BLOG_POST_TYPE . 's' );




//
$arr_to_add_menu = array(
	'nav-for-mobile' => 'NAV for mobile',
	
	'top-menu-01' => 'Top menu 01',
	'top-menu-02' => 'Top menu 02',
	'top-menu-03' => 'Top menu 03',
	'top-menu-04' => 'Top menu 04',
	'top-menu-05' => 'Top menu 05',
	'top-menu-06' => 'Top menu 06',
	
	'footer-menu-01' => 'Footer menu 01',
	'footer-menu-02' => 'Footer menu 02',
	'footer-menu-03' => 'Footer menu 03',
	'footer-menu-04' => 'Footer menu 04',
	'footer-menu-05' => 'Footer menu 05',
	'footer-menu-06' => 'Footer menu 06',
	'footer-menu-07' => 'Footer menu 07',
	'footer-menu-08' => 'Footer menu 08',
	'footer-menu-09' => 'Footer menu 09',
	'footer-menu-10' => 'Footer menu 10'
);






// hệ thống ngôn ngữ mặc định -> các ngôn ngữ khác người dùng sẽ thay đổi trong cài đặt
include EB_THEME_CORE . 'lang.php';

// hệ thống function riêng
include EB_THEME_PLUGIN_INDEX . 'functions.php';

// hệ thống config riêng của Ếch Bay
include EB_THEME_CORE . 'database.php';

//
//include EB_THEME_PLUGIN_INDEX . 'jquery_load.php';







// thiết lập gửi email thông qua STMP
if ( $__cf_row ['cf_sys_email'] == 'smtp' || $__cf_row ['cf_sys_email'] == 'pepipost' ) {
	// v1
//	return _eb_send_mail_phpmailer ( $to_email, '', $title, $message, '', $bcc_email );
	
	// v2
	add_filter( 'phpmailer_init', 'EBE_configure_smtp' );
}

// Thiết lập gửi EMail với định dạng HTML
// https://developer.wordpress.org/reference/hooks/wp_mail_content_type/
/*
function WGR_set_html_mail_content_type() {
    return 'text/html';
}
add_filter( 'wp_mail_content_type', 'WGR_set_html_mail_content_type' );
*/






// mảng danh sách các định dạng quảng cáo
$arr_eb_ads_status = array(
	0 => '[ Không hiển thị ]',
	1 => EBE_get_lang('ads_status1'),
	4 => EBE_get_lang('ads_status4'),
	5 => EBE_get_lang('ads_status5'),
	6 => EBE_get_lang('ads_status6'),
	7 => EBE_get_lang('ads_status7'),
	8 => EBE_get_lang('ads_status8'),
	9 => EBE_get_lang('ads_status9'),
	10 => EBE_get_lang('ads_status10'),
	11 => EBE_get_lang('ads_status11'),
	12 => EBE_get_lang('ads_status12'),
	13 => EBE_get_lang('ads_status13'),
	14 => EBE_get_lang('ads_status14'),
	15 => EBE_get_lang('ads_status15')
);

$arr_eb_product_status = array(
	0 => EBE_get_lang('product_status0'),
	1 => EBE_get_lang('product_status1'),
	2 => EBE_get_lang('product_status2'),
	3 => EBE_get_lang('product_status3'),
	4 => EBE_get_lang('product_status4'),
	5 => EBE_get_lang('product_status5'),
	6 => EBE_get_lang('product_status6'),
	7 => EBE_get_lang('product_status7'),
	8 => EBE_get_lang('product_status8'),
	9 => EBE_get_lang('product_status9'),
	10 => EBE_get_lang('product_status10')
);

// nếu theme có hỗ trợ nhiều định dạng q.cáo khác -> add vào
if ( isset ( $arr_eb_ads_custom_status ) ) {
//	print_r( $arr_eb_ads_custom_status );
	
	foreach ( $arr_eb_ads_custom_status as $k => $v ) {
		$arr_eb_ads_status[$k] = $v;
	}
//	print_r( $arr_eb_ads_status );
}







// cáu trúc chính của trang sản phẩm
//define( '__eb_thread_template', file_get_contents( EB_THEME_HTML . 'threadnode.html', 1 ) );

// Nếu có chọn file thiết kế -> sử dụng nguyên mẫu
$load_config_temp = $__cf_row['cf_threadnode_include_file'];
$__eb_thread_template = '';
if ( $load_config_temp != '' ) {
	$__eb_thread_template = WGR_check_and_load_tmp_theme( $load_config_temp, 'threadnode' );
}
else {
	$__eb_thread_template = EBE_get_page_template(
		EBE_get_html_file_addon(
			'thread_node',
			$__cf_row['cf_cats_node_html']
		)
	);
}

// nếu chưa có cặp thẻ LI -> bổ sung cặp này vào -> tạo dữ liệu theo thẻ thống nhất
$__eb_thread_template = WGR_add_li_to_thread_node( $__eb_thread_template );

//
define( '__eb_thread_template', $__eb_thread_template );

// css phục vụ việc điều chỉnh kích thước LI -> load sau khi css của node được tải
//$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/thread_list.css' ] = 1;
$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/thread_list.css' ] = 1;






/*
* EchBay plugin recommend wp-config
* Các thuộc tính khuyên khích sử dụng trong wp-config.php.
* Nếu người dùng không thiết lập trong wp-config -> sử dụng thiết lập khuyên dùng bởi EchBay
*/

// Tắt chức năng auto update, web ít dùng thì cần quái gì update, hay dùng thì nên update thủ công
if ( ! defined('WP_AUTO_UPDATE_CORE') ) {
	if ( $__cf_row['cf_on_off_auto_update_wp'] == 1 ) {
		define( 'WP_AUTO_UPDATE_CORE', true );
	} else {
		define( 'WP_AUTO_UPDATE_CORE', false );
	}
}

// cấu hình URL dạng tĩnh -> khuyên dùng
if ( ! defined('WP_SITEURL') ) {
//	if ( eb_web_protocol == 'https' ) {
		define( 'WP_SITEURL', eb_web_protocol . '://' . $_SERVER['HTTP_HOST'] );
		/*
	}
	else {
//		define( 'WP_SITEURL', get_option ( 'siteurl' ) );
		define( 'WP_SITEURL', _eb_get_option ( 'siteurl' ) );
	}
	*/
}
//echo WP_SITEURL . '<br>';

if ( ! defined('WP_HOME') ) {
	define( 'WP_HOME', WP_SITEURL );
}
//echo WP_HOME . '<br>'; exit();

/*
* Host chỉ hỗ trợ up file qua FTP cho bảo mật hơn
*/
/*
if ( ! defined('FS_METHOD') ) {
	define( 'FS_METHOD', 'ftpext' );
}
*/
if ( ! defined('FTP_HOST') ) {
//	define( 'FTP_HOST', $_SERVER['HTTP_HOST'] );
	define( 'FTP_HOST', $_SERVER['SERVER_ADDR'] );
}

/*
* Mặc định là không cho edit theme, plugin nếu sử dụng bản miễn phí
* Kích hoạt bằng cách set thủ công trong wp-config.php
*/
if ( ! defined('DISALLOW_FILE_EDIT') ) {
	if ( $__cf_row['cf_alow_edit_plugin_theme'] != 1 ) {
		define( 'DISALLOW_FILE_EDIT', true );
	} else {
		define( 'DISALLOW_FILE_EDIT', false );
	}
}

/*
* Mặc định là không cho update, install theme, plugin nếu sử dụng bản miễn phí
* Kích hoạt bằng cách set thủ công trong wp-config.php
*/
if ( ! defined('DISALLOW_FILE_MODS') ) {
	if ( $__cf_row['cf_alow_edit_plugin_theme'] != 1 ) {
		define( 'DISALLOW_FILE_MODS', true );
	} else {
		define( 'DISALLOW_FILE_MODS', false );
	}
}

/*
* Giới hạn số lần tối đa để lưu các bản nháp của bài viết, tự động xóa khi có quá 3 bài
*/
if ( ! defined('WP_POST_REVISIONS') ) {
	define( 'WP_POST_REVISIONS', 3 );
}

/*
* Gán mặc định tham số cho thư mục của admin nếu chưa có
*/
if ( ! defined('WP_ADMIN_DIR') ) {
	define( 'WP_ADMIN_DIR', 'wp-admin' );
}

//
define( 'admin_link', web_link . WP_ADMIN_DIR . '/' );


/*
* Mặc định là ẩn các menu quan trọng với tài khoản administrator
*/
/*
if ( ! defined('webgiare_dot_org_install') ) {
	define( 'webgiare_dot_org_install', true );
}
*/



//
/*
if ( ! defined('WP_CACHE') ) {
	define( 'WP_CACHE', true );
}
*/




//
//$url_for_static_file = esc_url( get_template_directory_uri() ) . '/';
//echo $url_for_static_file . '<br>';
//define( 'THEME_OUTSOURCE_URI', $url_for_static_file );
//echo THEME_OUTSOURCE_URI . '<br>';

//
/*
if ( defined('WP_SITEURL') ) {
	$___eb_template_uri = WP_SITEURL . '/';
}
else if ( defined('WP_HOME') ) {
	$___eb_template_uri = WP_HOME . '/';
}
else {
//	$___eb_template_uri = get_template_directory_uri();
	$___eb_template_uri = '//' . $_SERVER['HTTP_HOST'] . '/';
}
*/
$___eb_template_uri = web_link;
//echo $___eb_template_uri . ' -> aaaaaaaaaaaaaaaaaaaaaaa<br>' . "\n";

//define( 'EB_URL_OF_THEME', $___eb_template_uri . '/' );
define( 'EB_URL_OF_THEME', $___eb_template_uri . EB_DIR_CONTENT . '/themes/' . basename ( EB_THEME_URL ) . '/' );
//echo EB_URL_OF_THEME . '<br>' . "\n";
//define( 'EB_URL_OF_PLUGIN', esc_url( plugins_url() ) . '/echbaydotcom/' );
//define( 'EB_URL_OF_PLUGIN', dirname( dirname( $___eb_template_uri ) ) . '/echbaydotcom/' );
define( 'EB_URL_OF_PLUGIN', $___eb_template_uri . EB_DIR_CONTENT . '/echbaydotcom/' );
//echo EB_URL_OF_PLUGIN . '<br>' . "\n";
//echo '../../plugins/' . basename( EB_URL_OF_PLUGIN ) . '<br>';






/*
* Thiết kế lại giao diện trang login
*/
if ( mtv_id == 0 ) {
	
	// Thay doi duong dan logo admin
	function EBE_wpc_url_login(){
		// duong dan vao website cua ban
		return '//echbay.com/?utm_source=ebe_wp_theme&utm_campaign=wp_login&utm_term=copyright';
	}
	add_filter('login_headerurl', 'EBE_wpc_url_login');
	
	
	
	
	// Thay doi logo admin wordpress
	function EBE_login_css() {
		
		/*
		* Chỉnh lại URL của database nếu vẫn là URL demo
		*/
		global $wpdb;
		
		//
		if ( function_exists('_eb_q') ) {
			/*
			$sql = _eb_q("SELECT *
			FROM
				`" . $wpdb->options . "`
			WHERE
				option_name = 'siteurl'
				OR option_name = 'home'
			ORDER BY
				option_id DESC");
//			print_r( $sql );
			
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
			
			//
			WGR_auto_update_link_for_demo ( $current_homeurl, $current_siteurl );
			
			//
//			echo $current_homeurl . '<br>' . "\n";
//			echo $current_siteurl . '<br>' . "\n";
		}
		
		
		// duong dan den file css moi
		$login_css = EB_URL_OF_PLUGIN . 'css/login.css?v=' . time();
		
//		wp_enqueue_style( 'login_css', $login_css );
		echo WGR_show_header_favicon( web_link . eb_default_vaficon ) . '
<link rel="stylesheet" href="' . $login_css . '" type="text/css" />
<script type="text/javascript">
setTimeout(function () {
	document.getElementsByTagName("a")[0].setAttribute("target", "_blank");
}, 1200);
</script>';
		
	}
	add_filter('login_head', 'EBE_login_css');
	
}




// đăng ký kiểu bài viết, admin menu và các tham số khác
// taxonomy phải được đăng ký trước custom post type
include EB_THEME_CORE . 'custom/taxonomy.php';
include EB_THEME_CORE . 'custom/post-type.php';
include EB_THEME_CORE . 'custom/meta-box.php';
include EB_THEME_CORE . 'custom/user-meta.php';




//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );




/*
* Nếu biến $content_width chưa có dữ liệu thì gán giá trị cho nó (full HD)
*/
if ( ! isset( $content_width ) ) {
	$content_width = 1366;
}
//echo $content_width . '<br>';




//
define( 'id_default_for_get_sidebar', 'main_sidebar' );




/**
@ Thiết lập các chức năng sẽ được theme hỗ trợ
**/
function echbay_theme_setup() {
	
	global $arr_to_add_menu;
	global $__cf_row;
	
	/*
	* Thiết lập theme có thể dịch được
	*/
//	$language_folder = EB_THEME_URL . '/languages';
//	load_theme_textdomain( 'echbay', $language_folder );
	
	
	/*
	* Tự chèn RSS Feed links trong <head>
	*/
	if ( $__cf_row['cf_on_off_feed'] == 1 ) {
		add_theme_support( 'automatic-feed-links' );
	}
	
	
	/*
	* Thêm chức năng post thumbnail
	*/
	add_theme_support( 'post-thumbnails' );
	
	// Kế đến là cho đoạn sau vào để thêm một size ảnh thumbnail phù hợp với trang bán hàng (không crop)
//	add_image_size( 'small', 160, 160, false );

	
	
	
	/*
	* Thêm chức năng title-tag để tự thêm <title>
	* Kích hoạt khi người dùng tắt chức năng SEO của EchBay
	*/
//	if ( $__cf_row['cf_on_off_echbay_seo'] != 1 && ! is_404() ) {
//		add_theme_support( 'title-tag' );
//	}
	
	
	
	/*
	* Thêm chức năng post format
	* https://codex.wordpress.org/Post_Formats
	*/
	add_theme_support( 'post-formats', array(
		'image',
		'video',
		'gallery',
		'quote',
		'link'
	) );
	 
	 
	 /*
	* Thêm chức năng custom background
	*/
	/*
	add_theme_support( 'custom-background', array(
	   'default-color' => '#fff',
	) );
	*/
	
	
	
	
	/*
	* Tạo menu cho theme, cứ dựa theo giao diện, thứ tự menu từ trái -> phải, trên -> dưới
	*/
	foreach ( $arr_to_add_menu as $k => $v ) {
		register_nav_menu ( $k, $v );
	}
	
	
	
	
	/*
	* Tạo sidebar cho theme
	*/
	$arr_to_add_sidebar = array(
		// main_sidebar
		id_default_for_get_sidebar => 'Sidebar chính của website (dùng cho nhiều trang). Mặc định khi các sidebar khác không có dữ liệu thì side này sẽ được gọi ra để lấp chỗ trống.',
		
		'home_sidebar' => 'Sidebar cho trang chủ (home)',
		'home_content_top_sidebar' => 'Sidebar cho phần top nội dung của trang chủ (home)',
		'home_content_sidebar' => 'Sidebar cho phần footer nội dung của trang chủ (home)',
		
		'category_sidebar' => 'Sidebar cho trang danh sách sản phẩm (category)',
		'category_top_content_sidebar' => 'Sidebar cho phần top của trang danh sách sản phẩm (category)',
		'category_content_sidebar' => 'Sidebar cho phần nội dung của trang danh sách sản phẩm (category)',
		
		'post_sidebar' => 'Sidebar cho trang chi tiết sản phẩm (post)',
		'post_top_content_sidebar' => 'Sidebar cho phần top của trang chi tiết sản phẩm (post)',
		'post_content_sidebar' => 'Sidebar cho phần nội dung của trang chi tiết sản phẩm (post)',
		
		'blog_sidebar' => 'Sidebar cho trang tin tức (blog)',
		'blog_content_sidebar' => 'Sidebar cho phần nội dung của trang tin tức (blog)',
		
		'blog_details_sidebar' => 'Sidebar cho trang chi tiết tin (blog details)',
		'blog_content_details_sidebar' => 'Sidebar cho phần nội dung của trang chi tiết tin (blog details)',
		
		'page_sidebar' => 'Sidebar cho trang tĩnh (page)',
		'page_content_sidebar' => 'Sidebar cho phần nội dung của trang tĩnh (page)',
		
		'search_product_options' => 'Options cho phần tìm kiếm nâng cao',
		
		'eb_top_global' => 'Sidebar cho phần TOP của website (* Sử dụng zEchBay Open/ zEchBay Close Tag Tag để tạo các bộ thẻ đóng mở cho từng khối HTML).',
		'eb_footer_global' => 'Sidebar cho phần FOOTER của website (* Sử dụng zEchBay Open Tag/ zEchBay Close Tag để tạo các bộ thẻ đóng mở cho từng khối HTML).',
		
		'eb_z1_custom_site' => 'Sidebar dự phòng cho một số site sử dụng module riêng',
//		'eb_z2_custom_site' => 'Sidebar dự phòng cho một số site sử dụng module riêng',
		'eb_z1_recycle_bin' => 'Sidebar này gần như không bao giờ được gọi, nó làm nơi lưu trữ các widget đã được tạo ra, không muốn sử dụng nữa nhưng cũng không muốn xóa hẳn.',
	);
	
	// chạy vòng lặp add sidebat
	foreach ( $arr_to_add_sidebar as $k => $v ) {
		register_sidebar( array(
			'name' => str_replace( '_', ' ', $k ),
			'id' => $k,
			'class' => $k,
			'description' => $v,
			
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget' => '</div>',
			
//			'before_title' => '<div-for-replace class="' . $k . '-title">',
//			'after_title' => '</div-for-replace>'
			'before_title' => $k . '-title',
		) );
	}
	
	
}

//
add_filter ( 'init', 'echbay_theme_setup');





/*
* Sắp xếp sản phẩm theo lựa chọn của người dùng
* https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
*/
function eb_change_product_query ( $query ) {
	
	global $__cf_row;
	
	
	//
	$current_order = isset ( $_GET ['orderby'] ) ? trim ( strtolower( $_GET ['orderby'] ) ) : '';
	
	
	//
//	print_r( $query );
	
	
	// các post_type mặc định chỉ có 1 dạng sắp xếp
	if( isset( $query->query_vars['post_type'] ) ) {
		if( $query->query_vars['post_type'] == 'nav_menu_item'
		|| $query->query_vars['post_type'] == EB_BLOG_POST_TYPE
		|| $query->query_vars['post_type'] == 'ads' ) {
			
			// đây là chỉ số sắp xếp riêng của wordpress
			/*
			if ( $current_order == 'title' || $current_order == 'date' ) {
			}
			// mặc định sắp xếp theo STT
			else {
				*/
			if ( $current_order == '' ) {
				if ( $query->query_vars['post_type'] == EB_BLOG_POST_TYPE ) {
//					$query->set( 'orderby', array(
//						'menu_order' => 'DESC',
//						'date' => 'DESC'
//					) );
					$query->set( 'orderby', 'menu_order ID' );
					
					//
//					if ( mtv_id == 1 ) print_r( $query );
				}
				else if ( $query->query_vars['post_type'] == 'ads' ) {
					$query->set( 'orderby', 'menu_order ID' );
//					$query->set( 'order', 'DESC' );
				}
//				$query->set( 'orderby', 'menu_order' );
				// v1
//				$query->set( 'orderby', 'menu_order' );
//				$query->set( 'order', 'DESC' );
//				$query->set( 'orderby', 'ID' );
//				$query->set( 'order', 'DESC' );
			}
			
			//
			return $query;
		}
	}
	else {
		
//		echo EB_BLOG_POST_LINK;
//		print_r( $query );
		
		// điều chỉnh số lượng post sẽ được hiển thị trên mỗi trang Blog
		if ( $__cf_row['cf_blogs_per_page'] > 0 && isset( $query->query_vars[ EB_BLOG_POST_LINK ] ) ) {
//			print_r( $query );
			$query->set( 'posts_per_page', $__cf_row['cf_blogs_per_page'] );
		}
		
	}
	
	
	
	
	
	/*
	* Tìm nâng cao
	*/
	if ( isset( $_GET['search_advanced'] ) ) {
		/*
		* Tìm theo khoảng giá
		*/
		$price_in = isset ( $_GET ['price_in'] ) ? trim ( strtolower( $_GET ['price_in'] ) ) : '';
		if ( $price_in != '' ) {
			$price_in = explode( '-', $price_in );
			
			// từ 0 đến min_price
			if ( count( $price_in ) == 1 ) {
				/*
				$price_in = array(
					'key' => '_eb_product_price',
					'value' => $price_in[0],
					'compare' => '<',
					'type' => 'INT'
				);
				*/
				$price_in = array(
					'key' => '_eb_product_price',
					// value should be array of (lower, higher) with BETWEEN
					'value' => array( 0, $price_in[0] ),
					'compare' => 'BETWEEN',
					'type' => 'NUMERIC'
				);
			}
			else if ( count( $price_in ) == 2 ) {
				// từ max_price trở lên
				if ( trim( $price_in[0] ) == '' ) {
					$price_in = array(
						'key' => '_eb_product_price',
						'value' => $price_in[1],
						'compare' => '>=',
						'type' => 'NUMERIC'
					);
				}
				// trong khoảng
				else {
					$price_in = array(
						'key' => '_eb_product_price',
						// value should be array of (lower, higher) with BETWEEN
						'value' => array( $price_in[0], $price_in[1] ),
						'compare' => 'BETWEEN',
						'type' => 'NUMERIC'
					);
				}
			}
			else {
				$price_in = NULL;
			}
			
			//
			if ( $price_in != NULL ) {
	//			print_r($price_in);
				$query->set( 'meta_query', array( $price_in ) );
			}
		}
		
		
		
		
		/*
		* Tìm theo phân nhóm
		*/
		/*
		$seach_advanced_by_cats = isset ( $_GET ['filter_cats'] ) ? trim ( strtolower( $_GET ['filter_cats'] ) ) : '';
		if ( $seach_advanced_by_cats != '' ) {
		}
		*/
		
		
		
		
		/*
		* Tìm kiếm nâng cao
		*/
		$tim_nang_cao = isset ( $_GET ['filter'] ) ? trim ( strtolower( $_GET ['filter'] ) ) : '';
		$in_nang_cao = isset ( $_GET ['filter_in'] ) ? trim ( strtolower( $_GET ['filter_in'] ) ) : '';
		
		if ( $tim_nang_cao != '' || $in_nang_cao != '' ) {
			$tim_nang_cao = explode( ',', $tim_nang_cao );
			$arr_ids = array();
			
			$in_nang_cao = explode( ',', $in_nang_cao );
			$arr_in_ids = array();
			
			//
			foreach ( $tim_nang_cao as $k => $v ) {
				$v = trim( $v );
				if ( $v != '' && is_numeric( $v ) ) {
					$arr_ids[] = $v;
				}
				/*
				if ( $v != '' && ! is_numeric( $v ) ) {
					unset( $tim_nang_cao[$k] );
				}
				*/
			}
			
			//
			foreach ( $in_nang_cao as $k => $v ) {
				$v = trim( $v );
				if ( $v != '' && is_numeric( $v ) ) {
					$arr_in_ids[] = $v;
				}
			}
			
			//
//			$tim_nang_cao = implode( ',', $tim_nang_cao );
			
			//
//			$tim_nang_cao = explode( ',', $tim_nang_cao );
			
			// AND
//			if ( count( $tim_nang_cao ) > 0 ) {
			if ( ! empty( $arr_ids ) ) {
				$arr_ids = array(
					'field' => 'term_id',
//					'terms' => $tim_nang_cao,
//					'terms' => $tim_nang_cao[0],
//					'terms' => $tim_nang_cao,
					'terms' => $arr_ids,
//					'operator' => 'IN',
					'operator' => 'AND',
					'taxonomy' => 'post_options'
				);
			}
			
			// IN
			if ( ! empty( $arr_in_ids ) ) {
				$arr_in_ids = array(
					'field' => 'term_id',
//					'terms' => $tim_nang_cao,
//					'terms' => $tim_nang_cao[0],
//					'terms' => $tim_nang_cao,
					'terms' => $arr_in_ids,
//					'operator' => 'IN',
//					'operator' => 'AND',
					'taxonomy' => 'post_options'
				);
			}
			
			//
			if ( ! empty( $arr_ids ) && ! empty( $arr_in_ids ) ) {
				$query->set( 'tax_query', array(
					$arr_ids,
					$arr_in_ids
				) );
			}
			else if ( ! empty( $arr_ids ) ) {
				$query->set( 'tax_query', array(
					$arr_ids
				) );
			}
			else if ( ! empty( $arr_in_ids ) ) {
				$query->set( 'tax_query', array(
					$arr_in_ids
				) );
			}
		}
	}
	
	
	
	
	/*
	* Sắp xếp sản phẩm
	* https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
	*/
	
	switch ( $current_order ) {
		// xem nhiều -> lượt xem giảm dần
		case "view":
			$query->set( 'meta_key', '_eb_product_views' );
			$query->set( 'orderby', 'meta_value_num' );
//			$query->set( 'order', 'DESC' );
			break;
		
		// giá tăng dần
		case "price_up":
			$query->set( 'meta_key', '_eb_product_price' );
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'ASC' );
			break;
		
		// giá giảm dần
		case "price_down":
			$query->set( 'meta_key', '_eb_product_price' );
			$query->set( 'orderby', 'meta_value_num' );
//			$query->set( 'order', 'DESC' );
			break;
		
		// tên sản phẩm từ A-Z
		case "az":
			$query->set( 'orderby', 'name' );
			$query->set( 'order', 'ASC' );
			break;
		
		// Tên sản phẩm từ Z-A
		case "za":
			$query->set( 'orderby', 'name' );
//			$query->set( 'order', 'DESC' );
			break;
		
		// đây là chỉ số sắp xếp riêng của wordpress
		case "title":
		case "date":
			break;
		
		// mặc định sắp xếp theo STT giảm dần
		default:
			$query->set( 'orderby', 'menu_order ID' );
//			$query->set( 'order', 'DESC' );
			break;
	}
	
	//
//	print_r( $query );
//	return $query;
	return;
}





/*
* Bổ sung 1 số trường cho admin
*/
//if ( mtv_id > 0 && strstr( $_SERVER['REQUEST_URI'], '/' . WP_ADMIN_DIR . '/' ) == true ) {
if ( mtv_id > 0 && is_admin () ) {
	
	// một số chức năng cho admin
	include EB_THEME_CORE . 'custom/admin-menu.php';
	
}
// các thiết lập chỉ dành cho trang khách hàng
else {
	
	// chức năng tìm kiếm nâng cao và custom cho phần get post
	//if ( isset ( $_GET ['filter'] ) || isset ( $_GET ['orderby'] ) ) {
		add_filter( 'pre_get_posts', 'eb_change_product_query');
	//}
	
	

	/*
	* Không cho đọc nội dung thông qua json
	*/
	if ( $__cf_row['cf_on_off_json'] != 1 ) {
		include EB_THEME_PLUGIN_INDEX . 'plugins/disable-json-api.php';
	}
	
	
	//
	if ( $__cf_row['cf_on_off_feed'] != 1 ) {
		include EB_THEME_PLUGIN_INDEX . 'plugins/disable-rss-feed.php';
	}
	
	
	/*
	* Không hiển thị menu admin ở theme
	*/
	add_filter('after_setup_theme', 'EB_remove_admin_bar_in_theme');
	
	// xóa các script không sử dụng đến
	add_filter( 'wp_footer', 'EBE_deregister_scripts' );
	
}

//
function EB_remove_admin_bar_in_theme() {
	show_admin_bar(false);
}

function EBE_deregister_scripts() {
	wp_deregister_script( 'wp-embed' );
}




/*
* Xóa bỏ product-category và toàn bộ slug của danh mục cha khỏi đường dẫn
*/
//	$__eb_category_base = get_option( 'category_base' );
//	if ( $__eb_category_base == '' || $__eb_category_base == '.' ) {
//if ( $__cf_row['cf_remove_category_base'] == 1 ) {
//	echo $__cf_row['cf_remove_category_base'];
	
	include EB_THEME_PLUGIN_INDEX . 'plugins/rewrite-no-term-parents.php';
//	include EB_THEME_PLUGIN_INDEX . 'plugins/category-description-editor.php';
//}




/*
* Tạo widget với một số mẫu HTML dựng sẵn dùng chung cho nhiều trang
*/
include EB_THEME_CORE . 'widget.php';




//
/*
add_filter( 'document_title_parts', function( $title ) {
    if ( is_home() || is_front_page() ) {
        // Return blog title on front page
        $title = get_bloginfo( 'blogname' );
    }
	$title = 'aaaaaa';

    return $title;
} );
*/





// top menu
$arr_tmp_top_menu = array();

// footer menu
$arr_tmp_footer_menu = array();

//
//echo using_child_wgr_theme;
$arr_for_add_js = array(
	// Đây là file JS có đọ ưu tiên cao nhất, sẽ chạy trước mọi file js
	using_child_wgr_theme == 1 ? EB_CHILD_THEME_URL . 'ui/_.js' : '',
	
	// Tiếp đến là các file JS thông thường
//	ABSPATH . EB_DIR_CONTENT . '/uploads/ebcache/cat.js',
	EB_THEME_PLUGIN_INDEX . 'javascript/eb.js',
	EB_THEME_PLUGIN_INDEX . 'javascript/slider.js',
	EB_THEME_PLUGIN_INDEX . 'javascript/functions.js',
	EB_THEME_PLUGIN_INDEX . 'javascript/d.js',
//	EB_THEME_THEME . 'javascript/display.js',
//	EB_THEME_PLUGIN_INDEX . 'javascript/footer.js',
);
//print_r( $arr_for_add_js );

// nạp js từ child theme (nếu có)
//if ( using_child_wgr_theme == 1 && file_exists( EB_CHILD_THEME_URL . 'javascript/display.js' ) ) {
if ( using_child_wgr_theme == 1 ) {
	$arr_for_add_js[] = EB_CHILD_THEME_URL . 'javascript/display.js';
}
// mặc định là nạp từ theme
else {
	$arr_for_add_js[] = EB_THEME_THEME . 'javascript/display.js';
}

// bổ sung js chân trang
$arr_for_add_js[] = EB_THEME_PLUGIN_INDEX . 'javascript/footer.js';


// thêm các JS khác dưới dạng URL
$arr_for_add_outsource_js = array();

// thêm các JS khác dưới dạng URL -> có thêm thuộc tính async
$arr_for_add_outsource_async_js = array();





