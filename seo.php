<!-- EchBay SEO plugin - http://echbay.com/ -->
<?php

// trường hợp khách hàng không sử dụng plugin SEO khác thì mới dùng plugin SEO của EchBay
if ( $__cf_row['cf_on_off_echbay_seo'] == 1 ) {

// chế độ index website
if ( $__cf_row ["cf_blog_public"] == 0 ) {
//	wp_no_robots();
	echo '<meta name="robots" content="noindex,follow" />';
}


echo $dynamic_meta;



// cho phép google index
//echo get_option( 'blog_public' );
/*
if ( $__cf_row ["cf_blog_public"] == 1 ) {
	echo '<meta name="robots" content="noodp,noydir" />';
}
*/
// chặn index nếu chưa có
/*
else {
	if ( get_option( 'blog_public' ) == 0 ) {
		echo '<meta name="robots" content="noindex,follow" />';
	}
	*/
	
	/*
	$sql = _eb_q("SELECT option_value
	FROM
		" . $wpdb->options . "
	WHERE
		option_name = 'blog_public'
	ORDER BY
		option_id DESC
	LIMIT 0, 1");
//	print_r($sql);
	
	//
	if ( isset( $sql[0]->option_value ) && $sql[0]->option_value == 0 ) {
		echo '<meta name="robots" content="noindex,follow" />';
	}
	*/
//}

?>
<meta name="title" content="<?php echo $__cf_row ['cf_title']; ?>" />
<meta name="keywords" content="<?php echo $__cf_row ['cf_keywords']; ?>" />
<meta name="news_keywords" content="<?php echo $__cf_row ['cf_keywords']; ?>" />
<meta name="description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<meta name="abstract" content="<?php echo $__cf_row ['cf_abstract'] != '' ? $__cf_row ['cf_abstract'] : $__cf_row ['cf_description']; ?>" />
<meta name="RATING" content="GENERAL" />
<meta name="GENERATOR" content="EchBay.com eCommerce Software" />
<!-- -->
<meta itemprop="name" content="<?php echo $__cf_row ['cf_title']; ?>" />
<meta itemprop="description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<!-- -->
<meta property="og:title" content="<?php echo $__cf_row ['cf_title']; ?>" />
<meta property="og:description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<meta property="og:type" content="product" />
<meta property="og:site_name" content="<?php echo $web_name; ?>" />
<?php
}
else {
?>
<!-- // EchBay SEO plugin disable by custom -->
<?php
}


// google analytics
if ( $__cf_row['cf_ga_id'] != '' ) {
?>
<script type="text/javascript">
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', '<?php echo $__cf_row['cf_ga_id']; ?>', 'auto');
ga('require', 'displayfeatures');
<?php echo $import_ecommerce_ga; ?>
ga('send', 'pageview');
</script>
<?php
}


?>
<!-- // EchBay SEO plugin -->
