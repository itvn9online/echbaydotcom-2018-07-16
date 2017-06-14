<!-- mobile menu -->
<?php

// kiểm tra NAV mobile theo theme, nếu không có -> dùng bản dùng chung
echo EBE_html_template( EBE_get_page_template( 'search_nav_mobile' ), array(
	'tmp.str_nav_mobile_top' => $str_nav_mobile_top,
	
	'tmp.cf_logo' => $__cf_row['cf_logo'],
	'tmp.cf_dienthoai' => $__cf_row['cf_dienthoai'],
	'tmp.cf_call_dienthoai' => $__cf_row['cf_call_dienthoai'],
	'tmp.cf_hotline' => $__cf_row['cf_hotline'],
	'tmp.cf_call_hotline' => $__cf_row['cf_call_hotline'],
) );


?>
<!-- end mobile menu -->
<!-- ajax post -->
<iframe id="target_eb_iframe" name="target_eb_iframe" src="about:blank" width="750" height="600">AJAX form</iframe>
<!-- quick view video -->
<div class="quick-video">
	<div class="quick-video-close big cf">
		<div class="lf f40 show-if-mobile"><i title="Close" class="fa fa-remove cur d-block"></i></div>
		<div class="text-right rf f20 hide-if-mobile"><i title="Close" class="fa fa-remove cur d-block"></i></div>
	</div>
	<div class="quick-video-padding">
		<div id="quick-video-content"></div>
	</div>
</div>
<!-- -->
<div id="oi_scroll_top" class="fa fa-chevron-up default-bg"></div>
<div id="fb-root"></div>
<div id="oi_popup"></div>
<?php



//
//echo $act;
if ( $act != 'cart' ) {
	include EB_THEME_PLUGIN_INDEX . 'quick_cart.php';
}


//get_footer();
echo '<link rel="stylesheet" href="./wp-content/echbaydotcom/outsource/fonts/font-awesome.css?v=' . web_version . '" type="text/css" media="all" />' . "\n";

// add css, js -> sử dụng hàm riêng để tối ưu file tĩnh trước khi in ra
//_eb_add_full_css( $arr_for_add_link_css, 'link' );
//_eb_add_compiler_link_css( $arr_for_add_link_css, 'link' );
foreach ( $arr_for_add_link_css as $v ) {
	echo '<link rel="stylesheet" href="' . $v . '" type="text/css" media="all" />' . "\n";
}

//
EBE_print_product_img_css_class( $eb_background_for_post, 'Footer' );





// add file danh sách nhóm
//_eb_add_full_js( array( web_link . 'wp-content/uploads/ebcache/cat.js' ) );

// các file add mà không cần compiler
/*
_eb_add_full_js( array(
//	$__cf_row['cf_dns_prefetch'] . 'wp-content/echbaydotcom/outsource/javascript/jquery.js',
//	$__cf_row['cf_dns_prefetch'] . 'wp-content/echbaydotcom/outsource/javascript/jcarousellite.js',
//	$__cf_row['cf_dns_prefetch'] . 'wp-content/echbaydotcom/outsource/javascript/lazyload.js',
	$__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/ebcache/cat.js',
//	$__cf_row['cf_dns_prefetch'] . 'wp-content/echbaydotcom/javascript/eb.js',
//	$__cf_row['cf_dns_prefetch'] . 'wp-content/echbaydotcom/javascript/d.js',
//	EB_URL_OF_THEME . 'javascript/display.js',
//	$__cf_row['cf_dns_prefetch'] . 'wp-content/echbaydotcom/javascript/footer.js',
) );
*/

echo '<script type="text/javascript" src="' . $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/ebcache/cat.js" async></script>';
/*
echo '<script type="text/javascript" src="' . EB_URL_OF_PLUGIN . 'outsource/javascript/jquery.js"></script>';
*/

// các file compiler trước khi xuất ra
EBE_add_js_compiler_in_cache( array(
	EB_THEME_PLUGIN_INDEX . 'outsource/javascript/jquery.js',
	EB_THEME_PLUGIN_INDEX . 'outsource/javascript/jcarousellite.js',
	EB_THEME_PLUGIN_INDEX . 'outsource/javascript/lazyload.js',
) );
EBE_add_js_compiler_in_cache( $arr_for_add_js, 'async', 1 );




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




//
get_footer();
wp_footer();




//
echo $__cf_row['cf_js_allpage'];






//print_r($arr_object_post_meta);




//
if ( eb_code_tester == true ) {
	echo implode( "\n", $arr_for_show_html_file_load );
}



