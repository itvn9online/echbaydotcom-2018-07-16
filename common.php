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
$main_content = '';
$schema_BreadcrumbList = array();
$breadcrumb_position = 1;
$import_ecommerce_ga = '';
$url_og_url = '';
$image_og_image = '';
$arr_dymanic_meta = array();
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
	$str_fpr_license_echbay = '<span class="powered-by-echbay">Cung cấp bởi <a href="//echbay.com" title="Cung cấp bởi ẾchBay.com - Thiết kế web chuyên nghiệp" target="_blank" rel="nofollow">EchBay.com</a></span>';
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




// Mảng list các file dùng để tạo top, footer
$arr_includes_top_file = array();
$arr_includes_footer_file = array();

// Nạp CSS mặc định cho top và footer
if ( $__cf_row['cf_using_top_default'] == 1 ) {
//	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/top_default.css' ] = 1;
	
	// Kiểm tra và load các file top tương ứng
	for ( $i = 1; $i < 10; $i++ ) {
		$j = 'cf_top' . $i . '_include_file';
		
		if ( isset( $__cf_row_default[ $j ] ) ) {
			if ( $__cf_row[ $j ] != '' ) {
				$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'top/' . $__cf_row[ $j ];
				
				$arr_for_add_css[ EBE_get_css_for_config_design ( $__cf_row[ $j ] ) ] = 1;
			}
		} else {
			break;
		}
	}
	
	//
	if ( count( $arr_includes_top_file ) == 0 ) {
		include EB_THEME_PLUGIN_INDEX . 'top_default.php';
		
		//
		foreach ( $arr_includes_top_file as $v ) {
			$arr_for_add_css[ EBE_get_css_for_config_design( basename( $v ) ) ] = 1;
		}
	}
}

if ( $__cf_row['cf_using_footer_default'] == 1 ) {
//	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/footer_default.css' ] = 1;
	
	// Kiểm tra và load các file top tương ứng
	for ( $i = 1; $i < 10; $i++ ) {
		$j = 'cf_footer' . $i . '_include_file';
		
		if ( isset( $__cf_row_default[ $j ] ) ) {
			if ( $__cf_row[ $j ] != '' ) {
				$arr_includes_top_file[] = EB_THEME_PLUGIN_INDEX . 'footer/' . $__cf_row[ $j ];
				
				$arr_for_add_css[ EBE_get_css_for_config_design ( $__cf_row[ $j ] ) ] = 1;
			}
		} else {
			break;
		}
	}
	
	//
	if ( count( $arr_includes_footer_file ) == 0 ) {
		include EB_THEME_PLUGIN_INDEX . 'footer_default.php';
		
		//
		foreach ( $arr_includes_footer_file as $v ) {
			$arr_for_add_css[ EBE_get_css_for_config_design( basename( $v ) ) ] = 1;
		}
	}
}





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

// nếu có file -> include file vào
if ( file_exists( $inc_file ) ) {
	include $inc_file;


	//
	$arr_global_main = array(
		'tmp.cf_dienthoai' => $__cf_row['cf_dienthoai'],
		'tmp.cf_call_dienthoai' => $__cf_row['cf_call_dienthoai'],
		'tmp.cf_hotline' => $__cf_row['cf_hotline'],
		'tmp.cf_call_hotline' => $__cf_row['cf_call_hotline'],
		
		'tmp.cf_yahoo' => $__cf_row['cf_yahoo'],
//		'tmp.theme_static_url' => EB_URL_OF_THEME,
		'tmp.web_version' => $web_version,
		'tmp.web_name' => $web_name,
		
		// tìm và tạo sidebar luôn
		'tmp.str_sidebar' => _eb_echbay_sidebar( $id_for_get_sidebar ),
		'tmp.search_advanced_sidebar' => _eb_echbay_sidebar( 'search_product_options', 'widget-search-advanced cf', 'div', 1, 0 ),
		
		// kích thước sản phẩm trên mobile
		'tmp.cf_product_mobile_size' => $__cf_row['cf_product_mobile_size'],
		'tmp.cf_product_table_size' => $__cf_row['cf_product_table_size'],
		
		// kích thước ảnh blog
		'tmp.cf_blog_size' => $__cf_row['cf_blog_size'],
		// css định dạng chiều rộng cho phần danh sách blog
		'tmp.custom_blog_css' => $__cf_row['cf_blog_class_style'],
	);
	
	foreach ( $arr_global_main as $k => $v ) {
		$main_content = str_replace ( '{' . $k . '}', $v, $main_content );
	}
	
	// chuyển sang dùng CDN (nếu có)
	$main_content = str_replace ( web_link . 'wp-content/uploads/', $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/', $main_content );
	$main_content = str_replace ( '"wp-content/uploads/', '"' . $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/', $main_content );
	
	// chuyển URL sang dạng SSL
	$main_content = _eb_ssl_template( $main_content );
	
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



//
$group_go_to = implode( ' ', $group_go_to );



//
//print_r( $menu_cache_locations );



