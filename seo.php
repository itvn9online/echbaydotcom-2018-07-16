<!-- EchBay SEO plugin - http://echbay.com/ -->
<?php


// chế độ index website
// đối với các trang riêng của plugin
if ( $act != '' && isset( $arr_active_for_404_page[ $act ] ) ) {
	if ( $__cf_row ["cf_blog_public"] == 0 ) {
		echo '<meta name="robots" content="noindex,follow" />';
	}
}
else if ( $__cf_row ["cf_blog_public"] == 0 ) {
	// chỉ áp dụng khi giá trị của cf_blog_public khác với option blog_public
	if ( get_option( 'blog_public' ) != $__cf_row ["cf_blog_public"] ) {
//		wp_no_robots();
		echo '<meta name="robots" content="noindex,follow" />';
	}
}

// các thẻ META không bị không chế bởi option cf_on_off_echbay_seo
echo $global_dymanic_meta;



// trường hợp khách hàng không sử dụng plugin SEO khác thì mới dùng plugin SEO của EchBay
if ( cf_on_off_echbay_seo == 1 ) {


//
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


//
$__cf_row ['cf_description'] = str_replace( '"', '&quot;', $__cf_row ['cf_description'] );



?>
<meta name="revisit-after" content="1 days" />
<meta name="title" content="<?php echo $__cf_row ['cf_title']; ?>" />
<meta name="keywords" content="<?php echo $__cf_row ['cf_keywords']; ?>" />
<meta name="news_keywords" content="<?php echo $__cf_row ['cf_keywords']; ?>" />
<meta name="description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<meta name="abstract" content="<?php echo $__cf_row ['cf_abstract'] != '' ? $__cf_row ['cf_abstract'] : $__cf_row ['cf_description']; ?>" />
<meta name="RATING" content="GENERAL" />
<meta name="GENERATOR" content="EchBay.com eCommerce Software" />
<meta itemprop="name" content="<?php echo $__cf_row ['cf_title']; ?>" />
<meta itemprop="description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<meta property="og:title" content="<?php echo $__cf_row ['cf_title']; ?>" />
<meta property="og:description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<meta property="og:type" content="<?php echo $web_og_type; ?>" />
<meta property="og:site_name" content="<?php echo $web_name; ?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo $__cf_row ['cf_description']; ?>" />
<meta name="twitter:title" content="<?php echo $__cf_row ['cf_title']; ?>" />
<?php
}
else {
?>
<!-- // EchBay SEO plugin disable by customer -->
<?php
}


// google analytics
if ( $__cf_row['cf_ga_id'] != '' ) {
	// gtag
	if ( $__cf_row['cf_gtag_id'] == 1 ) {
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $__cf_row['cf_ga_id']; ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo $__cf_row['cf_ga_id']; ?>');
</script>
<?php
	}
	// analytic
	else {
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
}

?>
<!-- // EchBay SEO plugin -->
