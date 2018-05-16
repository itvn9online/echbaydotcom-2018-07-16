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
		WGR_update_meta_post( $v->post_id, $new_key, $v->meta_value );
	}
}

//
WGR_woo_convert( '_sku', '_eb_product_sku' );
WGR_woo_convert( '_regular_price', '_eb_product_oldprice' );
WGR_woo_convert( '_sale_price', '_eb_product_price' );


