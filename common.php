<?php




/*
* file common với các tham số dùng chung cho mọi website
*/




//echo $act;
//echo get_language_attributes();
//echo wp_logout_url();
//echo current_user_can();





// nếu có tham số DNS prefetch -> kiểm tra domain hiện tại có trùng với DNS prefetch không
if ( $__cf_row['cf_dns_prefetch'] != '' ) {
	// trùng thì hủy bỏ truy cập này luôn
	if ( $__cf_row['cf_dns_prefetch'] == $_SERVER['HTTP_HOST'] ) {
		$pcol = ( isset($_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		//echo $pcol;
		header( $pcol . ' 403 Forbidden' );
		
		echo file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/403.html', 1 );
		
		exit();
	}
	// không trùng -> tạo link cho DNS prefetch
	else {
		$dynamic_meta .= '<link rel="dns-prefetch" href="//' . $__cf_row['cf_dns_prefetch'] . '" />';
	}
	
	//
	$__cf_row['cf_dns_prefetch'] = '//' . $__cf_row['cf_dns_prefetch'] . '/';
} else {
	$__cf_row['cf_dns_prefetch'] = strstr( web_link, '//' );
}
//echo $__cf_row['cf_dns_prefetch'];






//
$group_go_to = array();
$schema_BreadcrumbList = array();
$breadcrumb_position = 1;
$import_ecommerce_ga = '';
$url_og_url = '';

// các og:type được hỗ trợhttps://stackoverflow.com/questions/9275457/facebook-ogtype-meta-tags-should-i-just-make-up-my-own
$web_og_type = 'website';

$image_og_image = '';
$arr_dymanic_meta = array();
// meta này sẽ không bị khống chế bởi option ON/ OFF EchBay SEO
$global_dymanic_meta = '';
$current_search_key = '';
$str_big_banner = '';
$current_category_menu = '';
$cid = 0;
$pid = 0;
$eb_wp_post_type = 0;
//$eb_background_for_mobile_post = array();





//
//$str_fpr_license_echbay = '';
//if ( $__cf_row['cf_on_off_echbay_logo'] == 1 ) {
	$str_fpr_license_echbay = '<span class="powered-by-echbay">' . EBE_get_lang('poweredby') . ' <a href="#" title="Cung cấp bởi ẾchBay.com - Thiết kế web chuyên nghiệp" target="_blank" rel="nofollow">EchBay.com</a></span>';
//}





// sử dụng module nhúng file tĩnh riêng
/*
$arr_for_add_js = array(
//	'outsource/javascript/jquery.js',
//	'outsource/javascript/jcarousellite.js',
//	'outsource/javascript/lazyload.js',
	
//	'javascript/eb.js',
//	'javascript/d.js',
//	'javascript/details_wp.js',
	
//	'eb.js',
	'display.js',
);
*/





$arr_for_add_theme_css[ EB_THEME_THEME . 'css/style.css' ] = 1;
// css phục vụ việc điều chỉnh kích thước LI
$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/thread_list.css' ] = 1;
$arr_for_add_theme_css[ EB_THEME_THEME . 'css/mobile.css' ] = 1;
//$arr_for_add_css[ EB_THEME_THEME . 'css/first_screen.css' ] = 1;


//
$arr_for_add_link_css = array(
//	EB_THEME_THEME . 'css/style.css',
//	EB_THEME_PLUGIN_INDEX . 'outsource/fonts/font-awesome.css',
//	EB_THEME_PLUGIN_INDEX . 'css/default.css',
);




// menu dành cho bản mobile
$str_nav_mobile_top = _eb_echbay_menu( 'nav-for-mobile' );





/*
* content
*/

// ID của sidebar mặc định -> lấy sidebar khác -> thay đổi trong file archive, content... của từng theme
// Xem các ID sidebar được hỗ trợ trong phần plugin
$id_for_get_sidebar = id_default_for_get_sidebar;

if ( $act == '' ) {
	$inc_file = 'home';
} else {
	$inc_file = $act;
}
//echo $inc_file . '<br>';
$inc_file = EB_THEME_PHP . $inc_file . '.php';
//echo $inc_file . '<br>';

//
//echo EB_THEME_URL . 'templates/' . $act . '.php';



// nếu có file -> include file vào
if ( file_exists( $inc_file ) ) {
	
	
	// main mặc định để các file con sử dụng lại
	$main_content = '';
	
	
	//
	include $inc_file;


	//
	$arr_global_main = array(
		'tmp.cf_dienthoai' => $__cf_row['cf_dienthoai'],
		'tmp.cf_call_dienthoai' => $__cf_row['cf_call_dienthoai'],
		'tmp.cf_hotline' => $__cf_row['cf_hotline'],
		'tmp.cf_call_hotline' => $__cf_row['cf_call_hotline'],
		'tmp.cf_diachi' => $__cf_row['cf_diachi'],
		'tmp.cf_email' => $__cf_row['cf_email'],
		
		'tmp.cf_yahoo' => $__cf_row['cf_yahoo'],
//		'tmp.theme_static_url' => EB_URL_OF_THEME,
		'tmp.web_version' => $web_version,
		'tmp.web_name' => $web_name,
		
		// tìm và tạo sidebar luôn (nếu có)
		'tmp.str_sidebar' => $id_for_get_sidebar == '' ? '' : _eb_echbay_sidebar( $id_for_get_sidebar ),
		'tmp.search_advanced_sidebar' => _eb_echbay_sidebar( 'search_product_options', 'widget-search-advanced cf', 'div', 1, 0 ),
		
		// kích thước sản phẩm trên mobile, table
		'tmp.cf_product_mobile_size' => $__cf_row['cf_product_mobile_size'],
		'tmp.trv_mobile_img' => $__cf_row['cf_product_mobile_size'],
		
		'tmp.cf_product_table_size' => $__cf_row['cf_product_table_size'],
		'tmp.trv_table_img' => $__cf_row['cf_product_table_size'],
		
		// kích thước ảnh blog
		'tmp.cf_blog_size' => $__cf_row['cf_blog_size'],
		// css định dạng chiều rộng cho phần danh sách blog
		'tmp.custom_blog_css' => $__cf_row['cf_blog_class_style'],
	);
	
	// riêng với trang chủ -> nếu có set chiều rộng -> bỏ phần chiệu rọng bên trong các module con đi
	if ( $act == '' && $__cf_row['cf_home_class_style'] != '' ) {
//		$arr_global_main['tmp.custom_blog_css'] = $__cf_row['cf_home_class_style'];
		$arr_global_main['tmp.custom_blog_css'] = '';
	}
	/*
	else {
		$arr_global_main['tmp.custom_blog_css'] = $__cf_row['cf_blog_class_style'];
	}
	*/
	
	//
	foreach ( $arr_global_main as $k => $v ) {
		$main_content = str_replace ( '{' . $k . '}', $v, $main_content );
	}
	
	// chuyển sang dùng CDN (nếu có)
	$main_content = str_replace ( web_link . 'wp-content/uploads/', $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/', $main_content );
	$main_content = str_replace ( '"wp-content/uploads/', '"' . $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/', $main_content );
	
	// chuyển URL sang dạng SSL
	$main_content = _eb_ssl_template( $main_content );
	
	// chyển các thẻ title động sang thẻ theo config
	$main_content = EBE_dynamic_title_tag( $main_content );
	
}
// hoặc nếu đây là một page template -> không làm gì cả, vì code sẽ nằm trong file template kia
else if ( file_exists( EB_THEME_URL . 'templates/' . $act . '.php' ) ) {
	echo '<!-- custom page template -->';
}
// nếu không -> hiển thị trang 404
else {
	include EB_THEME_PLUGIN_INDEX . 'global/null.php';
}







/*
* Tổng hợp lại thẻ META lần nữa
*/
// mặc định là giới thiệu về chủ sở hữu website
//if ( $schema_BreadcrumbList == '' ) {
if ( count( $schema_BreadcrumbList ) == 0 ) {
	
	$dynamic_meta .= _eb_del_line( '
<script type="application/ld+json">
{
    "@context": "http:\/\/schema.org",
    "@type": "Person",
    "url": "' .web_link. '",
    "sameAs": ["' .$__cf_row ['cf_facebook_page']. '", "' .$__cf_row ['cf_google_plus']. '", "' .$__cf_row ['cf_youtube_chanel']. '", "' .$__cf_row ['cf_twitter_page']. '"],
    "name": "' ._eb_str_block_fix_content ( $web_name ). '"
}
</script>', "", "/\t/" );
	
}
// hoặc breadcrumb nếu có
else {
	
//	print_r( $schema_BreadcrumbList );
	
	$dynamic_meta .= _eb_del_line( '
<script type="application/ld+json">
{
	"@context": "http:\/\/schema.org",
	"@type": "BreadcrumbList",
	"itemListElement": [{
		"@type": "ListItem",
		"position": 1,
		"item": {
			"@id": "' .str_replace( '/', '\/', web_link). '",
			"name": "Trang chủ"
		}
	} ' . implode ( ' ', $schema_BreadcrumbList ) . ' ]
}
</script>', "", "/\t/" );
	
}

// các thể meta khác nếu có
if ( $url_og_url != '' ) {
	$arr_dymanic_meta[] = '<meta itemprop="url" content="' . $url_og_url . '" />';
	$arr_dymanic_meta[] = '<meta property="og:url" content="' . $url_og_url . '" />';
}

if ( $image_og_image != '' ) {
	$arr_dymanic_meta[] = '<meta itemprop="image" content="' . $image_og_image . '" />';
	$arr_dymanic_meta[] = '<meta property="og:image" content="' . $image_og_image . '" />';
}

//
/*
foreach ( $arr_dymanic_meta as $v ) {
	$dynamic_meta .= $v . "\n";
}
*/
$dynamic_meta .= implode( "\n", $arr_dymanic_meta );





//
if ( $__cf_row ['cf_title'] == '' ) {
	$__cf_row ['cf_title'] = web_name;
	/*
} else {
	$__cf_row ['cf_title'] .= ' | ' . web_name;
	*/
}






//get_header();




// thêm ID cho phần banner chính
/*
if ( $str_big_banner != '' ) {
	$str_big_banner = '<div id="oi_big_banner">' . $str_big_banner . '</div>';
}
*/

// nếu chế độ global banner được kích hoạt -> lấy banner theo file tổng
if ( $__cf_row['cf_global_big_banner'] == 1 ) {
	$str_big_banner = EBE_get_big_banner();
}



//
$group_go_to = implode( ' ', $group_go_to );



//
//print_r( $menu_cache_locations );







// Mảng list các file dùng để tạo top, footer
$arr_includes_top_file = array();
$arr_includes_footer_file = array();

// Nạp CSS mặc định cho top và footer
if ( $__cf_row['cf_using_top_default'] == 1 ) {
//	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/top_default.css' ] = 1;
	
	// Kiểm tra và load các file top tương ứng
	$arr_includes_top_file = WGR_load_module_name_css( 'top', 0 );
	
	//
	if ( count( $arr_includes_top_file ) == 0 ) {
		include EB_THEME_PLUGIN_INDEX . 'top_default.php';
	}
}

if ( $__cf_row['cf_using_footer_default'] == 1 ) {
//	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/footer_default.css' ] = 1;
	
	// Kiểm tra và load các file footer tương ứng
	$arr_includes_footer_file = WGR_load_module_name_css( 'footer' );
	
	//
	if ( count( $arr_includes_footer_file ) == 0 ) {
		include EB_THEME_PLUGIN_INDEX . 'footer_default.php';
	}
}







//
include EB_THEME_PLUGIN_INDEX . 'header.php';




