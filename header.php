<!-- Plugin by EchBay.com - Theme by WebGiaRe.org -->
<!DOCTYPE html>
<html lang="<?php echo $__cf_row['cf_content_language']; ?>" class="no-js no-svg" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<head>
<!-- header -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmgp.org/xfn/11" />
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php

echo _eb_tieu_de_chuan_seo( $__cf_row ['cf_title'] );
echo WGR_show_header_favicon();

?>
<meta http-equiv="x-dns-prefetch-control" content="on">
<link rel="dns-prefetch" href="//www.google-analytics.com" />
<link rel="dns-prefetch" href="//connect.facebook.net" />
<!-- META for design by EchBay - http://echbay.com/ -->
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<meta name="RESOURCE-TYPE" content="DOCUMENT" />
<meta name="DISTRIBUTION" content="GLOBAL" />
<meta name="CODE AUTHOR" content="EchBay.Com" />
<meta name="COPYRIGHT" content="Copyright (c) 2011 by EchBay.com - lienhe@echbay.com" />
<!-- <meta name="format-detection" content="telephone=no"> -->
<!-- // META for design by EchBay -->
<?php
include EB_THEME_PLUGIN_INDEX . 'seo.php';
?>
<!-- Global site format by EchBay -->
<base href="<?php echo web_link; ?>" />
<?php

// thêm 1 số dns-prefetch cần thiết
/*
if ( $__cf_row['cf_ga_id'] != '' ) {
	echo '<link rel="dns-prefetch" href="//www.google-analytics.com" />';
}

if ( $__cf_row['cf_facebook_id'] != '' ) {
	echo '<link rel="dns-prefetch" href="//connect.facebook.net" />';
}
*/




// một số css liên quan tới việc hiển thị màn hình đầu tiên, giúp tăng điểm trên google page speed
//_eb_add_css( $arr_for_add_css );
//_eb_add_compiler_css( $arr_for_add_css + $arr_for_add_theme_css );
_eb_add_compiler_css( $arr_for_add_css );
//print_r( $arr_for_add_css );


// các css ít quan trọng hơn sẽ được add về phía sau, dưới dạng link
//_eb_add_compiler_link_css( $arr_for_add_link_css, 'link' );
//_eb_add_compiler_css( $arr_for_add_theme_css );


// phần style này phải đặt ở cuối cùng, để nó replace tất cả các style tĩnh trước đó
?>
<style type="text/css">
/* EchBay custom CSS for replace default CSS by plugin or theme */
<?php

echo $__cf_row['cf_default_css'] . $__cf_row['cf_default_themes_css'];

?>
</style>
<script type="text/javascript">
/* data_id */
<?php include EB_THEME_PLUGIN_INDEX . 'data_id.php'; ?>
var web_link = '<?php echo web_link; ?>';
/*
if ( document.domain != 'localhost' ) {
	web_link = window.location.protocol + '//' + document.domain + '/';
	if ( web_link != base_url_href ) {
		document.getElementsByTagName("base")[0].setAttribute("href", web_link);
	}
}
*/
</script>
<?php echo $__cf_row['cf_js_head']; ?>
<!-- // Global site format by EchBay -->
<?php

wp_head();



//
EBE_print_product_img_css_class( $eb_background_for_post );

// reset lại mục này, để còn insert CSS xuống footer nếu có
$eb_background_for_post = array();

?>
</head>
<!--Thêm class tượng trưng cho mỗi trang lên BODY để tùy biến-->
<body class="<?php echo $css_m_css; ?>">
