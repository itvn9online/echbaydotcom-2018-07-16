<?php

//
$file_jquery_js = 'jquery-3.2.1.min';
$dir_optimize_jquery_js = EB_THEME_PLUGIN_INDEX . 'outsource/javascript/';

// các file compiler trước khi xuất ra
//EBE_add_js_compiler_in_cache( array(
$file_optimize_jquery_js = array(
//	$dir_optimize_jquery_js . 'jquery.js',
	$dir_optimize_jquery_js . $file_jquery_js . '.js',
	
	// Bản hỗ trợ chuyển đổi từ jQuery thấp lên jQuery cao hơn
	$dir_optimize_jquery_js . 'jquery-migrate-1.4.1.min.js',
	$dir_optimize_jquery_js . 'jquery-migrate-3.0.0.min.js',
	
	// jquery cho bản mobile -> đang gây lỗi cho bản PC nên thôi
//	$dir_optimize_jquery_js . 'jquery.mobile-1.4.5.min.js',
//	ABSPATH . 'wp-includes/js/jquery/jquery.ui.touch-punch.js',
	
	// jQuery plugin
//	$dir_optimize_jquery_js . 'jcarousellite.js',
	$dir_optimize_jquery_js . 'lazyload.js',
//	$dir_optimize_jquery_js . 'swiper.min.js',
//	$dir_optimize_jquery_js . 'jquery.touchSwipe.min.js',
//) );
);

// tổng hợp các file jQuery cần thiết rồi cho hết vào 1 file để optimize
$str_optimize_jquery_js = '';
foreach ( $file_optimize_jquery_js as $v ) {
	$str_optimize_jquery_js .= basename( $v );
}
$str_optimize_jquery_js = implode( "", $file_optimize_jquery_js );
$str_optimize_jquery_js = str_replace( $dir_optimize_jquery_js, '', $str_optimize_jquery_js );
//$str_optimize_jquery_js = str_replace( '.js', '-', $str_optimize_jquery_js );
//$str_optimize_jquery_js = str_replace( '-jquery-', '-', $str_optimize_jquery_js );
//$str_optimize_jquery_js = str_replace( '.min-', '-', $str_optimize_jquery_js );
//$str_optimize_jquery_js = substr( $str_optimize_jquery_js, 0, -1 );
//$str_optimize_jquery_js = $dir_optimize_jquery_js . $str_optimize_jquery_js . '.js';
$str_optimize_jquery_js = $dir_optimize_jquery_js . $str_optimize_jquery_js;

// tạo file trên localhost hoặc nếu chưa có
if ( $localhost == 1 && ! file_exists( $str_optimize_jquery_js ) ) {
//	echo $localhost . '<br>' . "\n";
	
	//
	$content_optimize_jquery_js = '';
	foreach ( $file_optimize_jquery_js as $v ) {
		$content_optimize_jquery_js .= file_get_contents( $v, 1 );
	}
	_eb_create_file( $str_optimize_jquery_js, $content_optimize_jquery_js );
}

//
/*
echo basename( WP_CONTENT_DIR ) . '<br>' . "\n";
echo EB_THEME_PLUGIN_INDEX . '<br>' . "\n";
echo $str_optimize_jquery_js . '<br>' . "\n";
*/
/* */
echo '<script type="text/javascript" src="' . strstr( $str_optimize_jquery_js, basename( WP_CONTENT_DIR ) ) . '"></script>' . "\n";
/* */

// phiên bản include thông qua file phụ
/*
echo '<script>var jquery_mod_by_echbay_path="' . strstr( $str_optimize_jquery_js, basename( WP_CONTENT_DIR ) ) . '";' . trim( file_get_contents( EB_THEME_PLUGIN_INDEX . 'javascript/jquery.js', 1 ) ) . '</script>';
*/

// tạo file jQuery map nếu chưa có
$file_jquery_map = EB_THEME_CACHE . $file_jquery_js . '.map';
if ( ! file_exists( $file_jquery_map ) ) {
	copy( $dir_optimize_jquery_js . $file_jquery_js . '.map', $file_jquery_map );
	chmod( $file_jquery_map, 0777 );
}



/* *
function WGR_change_src_for_jquery () {
	global $str_optimize_jquery_js;
	
//	echo $str_optimize_jquery_js . "\n";
	
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', web_link . strstr( $str_optimize_jquery_js, basename( WP_CONTENT_DIR ) ), false, '3.2.1' );
	wp_enqueue_script( 'jquery' );
}
add_filter('wp_enqueue_scripts', 'WGR_change_src_for_jquery', 99);
/* */





