<?php



//get_footer();





// font awesome version 4
echo '<link rel="stylesheet" href="' . EB_DIR_CONTENT . '/echbaydotcom/outsource/fonts/font-awesome.css?v=' . web_version . '" type="text/css" media="all" />' . "\n";



// font awesome version 5
//echo '<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">' . "\n";
/*
echo '<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" async></script>' . "\n";
*/

//
//echo '<link rel="stylesheet" href="' . EB_DIR_CONTENT . '/echbaydotcom/outsource/fontawesome-free-5.0.6/css/fontawesome.css?v=' . web_version . '" type="text/css" media="all" />' . "\n";
echo '<link rel="stylesheet" href="' . EB_DIR_CONTENT . '/echbaydotcom/outsource/fontawesome-free-5.0.13/web-fonts-with-css/css/fa.css?v=' . web_version . '" type="text/css" media="all" />' . "\n";




// add css, js -> sử dụng hàm riêng để tối ưu file tĩnh trước khi in ra
//_eb_add_full_css( $arr_for_add_link_css, 'link' );
//_eb_add_compiler_link_css( $arr_for_add_link_css, 'link' );
foreach ( $arr_for_add_link_css as $v ) {
	echo '<link rel="stylesheet" href="' . $v . '" type="text/css" media="all" />' . "\n";
}

//
EBE_print_product_img_css_class( $eb_background_for_post, 'Footer' );





// add file danh sách nhóm
//_eb_add_full_js( array( web_link . EB_DIR_CONTENT . '/uploads/ebcache/cat.js' ) );

// các file add mà không cần compiler
/*
_eb_add_full_js( array(
//	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/echbaydotcom/outsource/javascript/jquery.js',
//	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/echbaydotcom/outsource/javascript/jcarousellite.js',
//	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/echbaydotcom/outsource/javascript/lazyload.js',
	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/uploads/ebcache/cat.js',
//	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/echbaydotcom/javascript/eb.js',
//	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/echbaydotcom/javascript/d.js',
//	EB_URL_OF_THEME . 'javascript/display.js',
//	$__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/echbaydotcom/javascript/footer.js',
) );
*/
		
		
		
		
		
		
/*
* Tạo cat dưới dạng JS
*/

// TEST
/*
echo '<script>';
echo 'console.log(' . _eb_get_full_category_v2 ( 0, 'category', 1 ) . ');';
echo '</script>';
*/
//echo _eb_get_full_category_v2 ( 0, 'category', 1 );
//exit();

// file time
//echo date( 'r', $date_time ) . "\n";
$cat_js_file_name = (int) substr( date( 'i', date_time ), 0, 1 );

// nếu phút hiện tại là 0
if ( $cat_js_file_name == 0 ) {
	$using_js_file_name = 5;
}
else {
	$using_js_file_name = $cat_js_file_name - 1;
}

// file name
$cat_js_file_name = 'cat-' . $cat_js_file_name . '.js';
$using_js_file_name = 'cat-' . $using_js_file_name . '.js';


//
if ( ! file_exists( EB_THEME_CACHE . $cat_js_file_name ) || date_time - filemtime ( EB_THEME_CACHE . $cat_js_file_name ) > 1800 ) {
	_eb_create_file ( EB_THEME_CACHE . $cat_js_file_name, 'var eb_site_group=[' . _eb_get_full_category_v2 ( 0, 'category', 1 ) . '],eb_blog_group=[' . _eb_get_full_category_v2 ( 0, EB_BLOG_POST_LINK, 1 ) . '];' );
	
	//
	if ( ! file_exists( EB_THEME_CACHE . $using_js_file_name ) ) {
		copy( EB_THEME_CACHE . $cat_js_file_name, EB_THEME_CACHE . $using_js_file_name );
		chmod( EB_THEME_CACHE . $using_js_file_name, 0777 );
	}
}


echo '<script type="text/javascript" src="' . EB_DIR_CONTENT . '/uploads/ebcache/' . $using_js_file_name . '?v=' . date( 'ymd-Hi', date_time ) . '" async></script>';

/*
echo '<script type="text/javascript" src="' . web_link . 'eb-load-quick-search" async></script>';
*/
/*
echo '<script type="text/javascript" src="' . EB_URL_OF_PLUGIN . 'outsource/javascript/jquery.js"></script>';
*/


//
include EB_THEME_PLUGIN_INDEX . 'jquery_load.php';





// JS ngoài
foreach ( $arr_for_add_outsource_js as $v ) {
	echo '<script type="text/javascript" src="' . $v . '"></script>' . "\n";
}



// thêm JS đồng bộ URL từ code EchBay cũ sang code WebGiaRe (nếu có)
/* -> chuyển sang sử dụng phiên bản php
if ( $__cf_row['cf_echbay_migrate_version'] == 1 ) {
	$arr_for_add_js[] = EB_THEME_PLUGIN_INDEX . 'javascript/eb_migrate_version.js';
}
*/

// file js riêng của từng theme
if ( using_child_wgr_theme == 1 ) {
	$arr_for_add_js[] = EB_CHILD_THEME_URL . 'ui/d.js';
}
else {
	$arr_for_add_js[] = EB_THEME_URL . 'ui/d.js';
}
//print_r( $arr_for_add_js );

//
EBE_add_js_compiler_in_cache( $arr_for_add_js, 'async', 1 );



// JS ngoài
foreach ( $arr_for_add_outsource_async_js as $v ) {
	echo '<script type="text/javascript" src="' . $v . '" async></script>' . "\n";
}




/*
* JS cho hết xuống cuối trang
*/
/*
_eb_add_css_js_file( array(
	'jquery-1.11.0.min.js',
	'jcarousellite_1.0.1.min.js',
	'jquery.lazyload.pack.js',
), '.js', 1, EB_URL_OF_PLUGIN . 'outsource/' );
*/

// các file js ở chân trang
//$arr_for_add_js[] = 'javascript/display_wp.js';
//$arr_for_add_js[] = 'display.js';
//$arr_for_add_js[] = 'javascript/social.js';

//
//_eb_add_js( $arr_for_add_js );



