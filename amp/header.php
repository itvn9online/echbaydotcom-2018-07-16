<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
<?php echo _eb_tieu_de_chuan_seo( $__cf_row ['cf_title'] ); ?>
<link rel="canonical" href="<?php echo $url_og_url; ?>" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,400italic,700,700italic">
<script src="https://cdn.ampproject.org/v0.js" async></script>
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<?php

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


?>
<style amp-custom>
<?php echo $eb_amp->add_css ( array( 'css/amp-custom.css', ) );
?>
</style>
</head>
