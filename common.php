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
	$arr_dns_prefetch = explode( "\n", $__cf_row['cf_dns_prefetch'] );
//	if ( mtv_id == 1 ) print_r( $arr_dns_prefetch );
	
	// trùng thì hủy bỏ truy cập này luôn
//	if ( $__cf_row['cf_dns_prefetch'] == $_SERVER['HTTP_HOST'] ) {
	foreach ( $arr_dns_prefetch as $v ) {
		if ( trim( $v ) == $_SERVER['HTTP_HOST'] ) {
			EBE_set_header(403);
//			$pcol = ( isset($_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
			//echo $pcol;
//			header( $pcol . ' 403 Forbidden' );
			
			echo file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/403.html', 1 );
			
			exit();
		}
		
		// không trùng -> tạo link cho DNS prefetch
		$dynamic_meta .= '<link rel="dns-prefetch" href="//' . $v . '" />';
	}
	
	//
	$__cf_row['cf_dns_prefetch'] = '//' . $arr_dns_prefetch[0] . '/';
} else {
//	$__cf_row['cf_dns_prefetch'] = strstr( web_link, '//' );
	$__cf_row['cf_dns_prefetch'] = '//' . $_SERVER['HTTP_HOST'] . '/';
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

$image_og_image = $__cf_row['cf_og_image'];
$arr_dymanic_meta = array();
// meta này sẽ không bị khống chế bởi option ON/ OFF EchBay SEO
$global_dymanic_meta = '';
$current_search_key = '';
$str_big_banner = '';
$current_category_menu = '';
// nhóm cấp 1 (sẽ xuất hiện trong trường hợp cid là con của nhóm này)
$parent_cid = 0;
$cid = 0;
$eb_wp_taxonomy = '';
$pid = 0;
$eb_product_price = 0;
$eb_wp_post_type = '';
//$eb_background_for_mobile_post = array();





//
//$str_fpr_license_echbay = '';
//if ( $__cf_row['cf_on_off_echbay_logo'] == 1 ) {
	$str_fpr_license_echbay = '<span class="powered-by-echbay">' . EBE_get_lang('poweredby') . ' <a href="#" title="Cung cấp bởi ẾchBay.com - Thiết kế web chuyên nghiệp" target="_blank" rel="nofollow">EchBay.com</a></span>';
//}



// Phiên bản license mới với thông tin dùng chung nhiều hơn

// lấy tên website -> ưu tiên tên ngắn trước
$str_footer_echbay_license = ( $__cf_row['cf_web_name'] == '' ) ? $web_name : $__cf_row['cf_web_name'];

// ghép thành chuỗi
$str_footer_echbay_license = '<div class="global-footer-copyright">' . EBE_get_lang('copyright') . ' &copy; ' . $year_curent . ' <span>' . $str_footer_echbay_license . '</span>' . EBE_get_lang('allrights') . ' <span class="powered-by-echbay">' . EBE_get_lang('poweredby') . ' <a href="#" title="Cung cấp bởi ẾchBay.com - Thiết kế web chuyên nghiệp" target="_blank" rel="nofollow">EchBay.com</a></span></div>';





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


//
$arr_for_add_link_css = array(
//	EB_THEME_THEME . 'css/style.css',
//	EB_THEME_PLUGIN_INDEX . 'outsource/fonts/font-awesome.css',
//	EB_THEME_PLUGIN_INDEX . 'css/d.css',
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
//echo $inc_file . '<br>' . "\n";
$inc_child_file = '';
if ( using_child_wgr_theme == 1 ) {
	$inc_child_file = EB_CHILD_THEME_URL . 'php/' . $inc_file . '.php';
//	echo $inc_child_file . '<br>' . "\n";
}
$inc_file = EB_THEME_PHP . $inc_file . '.php';
//echo $inc_file . '<br>' . "\n";

//
//echo EB_THEME_URL . 'templates/' . $act . '.php';




// sử dụng child theme (ưu tiên)
if ( $inc_child_file != '' && file_exists( $inc_child_file ) ) {
//	include $inc_child_file;
	$inc_file = $inc_child_file;
}
// sử dụng ở theme chính
/*
else {
	include $inc_file;
}
*/

// nếu có file -> include file vào
if ( file_exists( $inc_file ) ) {
//	echo '<!-- ' . $inc_file . ' -->' . "\n";
	
	
	// main mặc định để các file con sử dụng lại
	$main_content = '';
	
	//
	include $inc_file;


	//
	include EB_THEME_PLUGIN_INDEX . 'common_content.php';
	
}
// hoặc nếu đây là một page template -> code sẽ nằm trong file template kia
else if ( using_child_wgr_theme == 1 && file_exists( EB_CHILD_THEME_URL . 'templates/' . $act . '.php' ) ) {
	// Nạp lại header cho page ở mục này để làm SEO
	include EB_THEME_PLUGIN_INDEX . 'global/page_templates_header.php';
}
// page template cho theme
else if ( file_exists( EB_THEME_URL . 'templates/' . $act . '.php' ) ) {
	include EB_THEME_PLUGIN_INDEX . 'global/page_templates_header.php';
}
// nếu không -> hiển thị trang 404
else {
	echo '<!-- ' . $inc_file . ' -->' . "\n";
	include EB_THEME_PLUGIN_INDEX . 'global/null.php';
}







/*
* Tổng hợp lại thẻ META lần nữa
*/
// mặc định là giới thiệu về chủ sở hữu website
//if ( $schema_BreadcrumbList == '' ) {
if ( count( $schema_BreadcrumbList ) == 0 ) {
	
	$json_social_sameAs = '';
	
	if ( $__cf_row['cf_facebook_page'] != '' ) {
		$json_social_sameAs .= ',"' .$__cf_row ['cf_facebook_page']. '"';
	}
	
	if ( $__cf_row['cf_instagram_page'] != '' ) {
		$json_social_sameAs .= ',"' .$__cf_row ['cf_instagram_page']. '"';
	}
	
	if ( $__cf_row['cf_twitter_page'] != '' ) {
		$json_social_sameAs .= ',"' .$__cf_row ['cf_twitter_page']. '"';
	}
	
	if ( $__cf_row['cf_youtube_chanel'] != '' ) {
		$json_social_sameAs .= ',"' .$__cf_row ['cf_youtube_chanel']. '"';
	}
	
	if ( $__cf_row['cf_google_plus'] != '' ) {
		$json_social_sameAs .= ',"' .$__cf_row ['cf_google_plus']. '"';
	}
	
	
	$dynamic_meta .= _eb_del_line( '
<script type="application/ld+json">
{
    "@context": "http:\/\/schema.org",
    "@type": "Person",
    "url": "' .web_link. '",
    "sameAs": [' . substr( $json_social_sameAs, 1 ) . '],
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
	$str_big_banner = EBE_get_big_banner( EBE_get_lang('bigbanner_num') );
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
//	print_r( $arr_includes_top_file );
}

if ( $__cf_row['cf_using_footer_default'] == 1 ) {
//	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/footer_default.css' ] = 1;
	
	// Kiểm tra và load các file footer tương ứng
	$arr_includes_footer_file = WGR_load_module_name_css( 'footer' );
	
	//
	if ( count( $arr_includes_footer_file ) == 0 ) {
		include EB_THEME_PLUGIN_INDEX . 'footer_default.php';
	}
//	print_r( $arr_includes_footer_file );
}

// xong sẽ nạp CSS tổng của theme (trang nào cũng có mặt)
if ( $__cf_row[ 'cf_current_theme_using' ] != '' ) {
//	$arr_for_add_css[ EBE_get_css_for_config_design ( $__cf_row[ 'cf_current_theme_using' ] ) ] = 1;
//	$arr_for_add_theme_css[ EBE_get_css_for_config_design ( $__cf_row[ 'cf_current_theme_using' ] ) ] = 1;
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin ( $__cf_row[ 'cf_current_theme_using' ] ) ] = 1;
	// d.css
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin ( 'd' ) ] = 1;
}
//print_r( $arr_for_add_css );







//
include EB_THEME_PLUGIN_INDEX . 'header.php';




