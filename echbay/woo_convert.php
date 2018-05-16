<?php

$convert_lnk = admin_link . 'admin.php?page=eb-coder&tab=woo_convert';

?>

<h2>Convert các dữ liệu trong post meta từ plugin này sang plugin khác (bấm chọn bên dưới):</h2>
<br>
<ol>
	<li><a href="<?php echo $convert_lnk; ?>&mt=woo">Woo-commerce to WebGiaRe</a></li>
	<li><a href="<?php echo $convert_lnk; ?>&mt=wgr">WebGiaRe to Woo-commerce</a></li>
	<li><a href="<?php echo $convert_lnk; ?>&mt=yoast">Yoast SEO to WebGiaRe</a></li>
	<li><a href="<?php echo $convert_lnk; ?>&mt=wgr_yoast">WebGiaRe to Yoast SEO</a></li>
	<li><a href="<?php echo $convert_lnk; ?>&mt=ultimatewgr">SEO Ultimate to WebGiaRe</a></li>
	<li><a href="<?php echo $convert_lnk; ?>&mt=wgr_ultimate">WebGiaRe to SEO Ultimate</a></li>
</ol>
<br>
<?php



// chuyển tên các key trong woo sang echbay
function WGR_woo_convert ( $old_key, $new_key ) {
	$sql = _eb_q("SELECT *
	FROM
		`" . wp_postmeta . "`
	WHERE
		meta_key = '" . $old_key . "'
		AND meta_value != ''
	ORDER BY
		post_id DESC
	LIMIT 0, 5000");
//	print_r( $sql );
	
	foreach ( $sql as $v ) {
		// copy sang giá trị mới
//		if ( $v->meta_value != 0 ) {
			WGR_update_meta_post( $v->post_id, $new_key, $v->meta_value );
//		}
		
		// xóa cái cũ
		delete_post_meta( $v->post_id, $old_key );
	}
	
	
	// xóa các cột dữ liệu trống
	_eb_q("DELETE
	FROM
		`" . wp_postmeta . "`
	WHERE
		meta_key = '" . $old_key . "'
		AND meta_value = ''", 0);
	
	
	//
	echo '<div class="medium18"><strong>' . count( $sql ) . ' ' . $old_key . '</strong> has been convert to: <strong>' . $new_key . '</strong></div><br>';
	
	//
	return true;
}



//
$mt = '';
if ( isset( $_GET['mt'] ) ) {
	$mt = trim( $_GET['mt'] );
}
//echo $mt . '<br>';

// từ wgr sang woo
if ( $mt == 'wgr' ) {
	WGR_woo_convert( '_eb_product_sku', '_sku' );
	WGR_woo_convert( '_eb_product_oldprice', '_regular_price' );
	WGR_woo_convert( '_eb_product_price', '_sale_price' );
}
// từ woo sang wgr
else if ( $mt == 'woo' ) {
	WGR_woo_convert( '_sku', '_eb_product_sku' );
	WGR_woo_convert( '_regular_price', '_eb_product_oldprice' );
	WGR_woo_convert( '_sale_price', '_eb_product_price' );
}




