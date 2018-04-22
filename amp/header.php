<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<?php

echo _eb_tieu_de_chuan_seo( $__cf_row ['cf_title'] );


$url_for_amp_favicon = $__cf_row ['cf_favicon'];
if ( strstr( $url_for_amp_favicon, '//' ) == false ) {
	if ( substr( $url_for_amp_favicon, 0, 1 ) == '/' ) {
		$url_for_amp_favicon = substr( $url_for_amp_favicon, 1 );
	}
	$url_for_amp_favicon = web_link . $url_for_amp_favicon;
}
echo '<meta name="theme-color" content="' . $__cf_row['cf_default_bg'] . '">
<meta name="msapplication-navbutton-color" content="' . $__cf_row['cf_default_bg'] . '">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="' . $__cf_row['cf_default_bg'] . '">
<link href="' . $url_for_amp_favicon . '" rel="shortcut icon" type="image/png" />';

// có một số lệnh không hợp với amp
//echo WGR_show_header_favicon();

?>
<link rel="canonical" href="<?php echo $url_og_url; ?>" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,400italic,700,700italic">
<script src="https://cdn.ampproject.org/v0.js" async></script>
<?php
if ( $__cf_row['cf_ga_id'] != '' ) {
?>
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<?php
}

//
if ( isset( $other_amp_cdn['youtube'] ) ) {
	$other_amp_cdn['youtube'] = '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>';
}

foreach ( $other_amp_cdn as $v ) {
	echo $v . "\n";
}


//echo $eb_amp->add_css( array(  'css/amp-boilerplate.html', ) );
echo '<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>';



$f_content = '<script type="application/ld+json">
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
	} ' . implode( ' ', $schema_BreadcrumbList ) . ' ]
}
</script>';

$f_content = preg_replace( "/\t/", "", trim( $f_content ) );

echo $f_content;

//
echo $structured_data_detail;


$str_for_amp_logo = web_name;
$url_for_amp_logo = '';
$css_for_amp_logo = '';
if ( $__cf_row['cf_on_off_amp_logo'] == 1 ) {
	$url_for_amp_logo = $__cf_row['cf_logo'];
	if ( strstr( $url_for_amp_logo, '//' ) == false ) {
		if ( substr( $url_for_amp_logo, 0, 1 ) == '/' ) {
			$url_for_amp_logo = substr( $url_for_amp_logo, 1 );
		}
		$url_for_amp_logo = web_link . $url_for_amp_logo;
	}
	$css_for_amp_logo = '.amp-wp-header .amp-wp-logo {background-image:url(' . $url_for_amp_logo . ');}';
	
	$str_for_amp_logo = '<span class="amp-wp-logo">' . web_name . '</span>';
}



//
if ( $__cf_row['cf_default_amp_bg'] == '' ) {
	$__cf_row['cf_default_amp_bg'] = $__cf_row['cf_default_bg'];
}
echo $code_adsense_script;

?>
<style amp-custom>
<?php

echo WGR_remove_css_multi_comment( $eb_amp->add_css ( array(
	'css/amp-custom.css'
) ) ) . $css_for_amp_logo . '.amp-wp-header{background-color:' . $__cf_row['cf_default_amp_bg'] . '}';

// thêm phần chỉnh đơn vị tiền tệ
echo str_replace( '.ebe-currency:', '.amp-wp-blogs-giamoi:', $custom_css_for_price );

?>
</style>
</head>
