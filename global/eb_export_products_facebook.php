<?php



/*
* Cấu trúc dữ liệu sản phẩm theo tiêu chuẩn của google
* https://support.google.com/merchants/topic/6324338?hl=vi&ref_topic=7294998
*/



// lấy nhóm cấp 1 của sản phẩm này
function WGR_rss_get_parent_cat ( $id ) {
	$cat = get_term( $id );
//	print_r( $cat );
	
	// xem nhóm có bị khóa bởi plugin EchBay không
	if ( _eb_get_cat_object( $id, '_eb_category_hidden', 0 ) != 1 ) {
		// nếu không có nhóm cha -> lấy luôn id nhóm
		if ( $cat->parent == 0 ) {
			return $id;
		}
		// có nhóm cha -> còn tiếp tục lấy
		else {
			return WGR_rss_get_parent_cat ( $cat->parent );
		}
	}
	
	// mặc định thì trả về 0
	return 0;
}




//
$rssCacheFilter = 'rss-fb';
$rss_content = _eb_get_static_html ( $rssCacheFilter, '', '', 3600 );
//$rss_content = false;
if ($rss_content == false) {
	
	
	
	//
$rss_content = '';

$rss_content .= '<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
	<channel>
		<title>' . web_name . '</title>
		<link>' . web_link . '</link>
		<description>' . $__cf_row['cf_description'] . '</description>
		<last_update>' . date( 'r', date_time ) . '</last_update>
		<code_copyright>Cache by EchBay.com - WebGiaRe.org</code_copyright>';


//
$rss_brand = explode( '.', $_SERVER['HTTP_HOST'] );
$rss_brand = $rss_brand[0];


//
$before_price = '';
$after_price = '';
if ( $__cf_row['cf_current_price_before'] == 1 ) {
	$before_price = $__cf_row['cf_current_sd_price'] . ' ';
}
else {
	$after_price = ' ' . $__cf_row['cf_current_sd_price'];
}



//
$cache_ant_id = array();


//
foreach ( $sql as $v ) {
	$p_link = _eb_p_link( $v->ID );
	
	
	// tìm ID của nhóm -> chỉ lấy nhóm cấp 1
	$ant_id = 0;
	$post_categories = wp_get_post_categories( $v->ID );
//	print_r( $post_categories );
	if ( ! empty( $post_categories ) ) {
		foreach($post_categories as $c){
			$ant_id = WGR_rss_get_parent_cat( $c );
			
			if ( $ant_id > 0 ) {
				break;
			}
		}
	}
	
	//
	$google_product_category = '';
	if ( $ant_id > 0 ) {
		if ( isset( $cache_ant_id[ $ant_id ] ) ) {
			$google_product_category = $cache_ant_id[ $ant_id ];
		}
		else {
			$google_product_category = _eb_get_cat_object( $ant_id, '_eb_category_google_product' );
			
			// lấy nhóm mặc định nếu chưa có
			if ( $google_product_category == '' ) {
				$google_product_category = $__cf_row['cf_google_product_category'];
			}
			$cache_ant_id[ $ant_id ] = $google_product_category;
		}
	}
	
	
	
	//
	$price = _eb_float_only( _eb_get_post_object( $v->ID, '_eb_product_oldprice', 0 ) );
	$sale_price = _eb_float_only( _eb_get_post_object( $v->ID, '_eb_product_price', 0 ) );
	
	// chỉnh lại giá về 1 thông số
	if ( $price == 0 && $sale_price > 0 ) {
		$price = $sale_price;
		$sale_price = 0;
	}
	
	
	//
	$for_google = '';
	if ( $export_type == 'google' ) {
		$for_google = '<g:google_product_category>' . $google_product_category . '</g:google_product_category>
	<g:item_group_id>' . $ant_id . '</g:item_group_id>';
	}
	
	
	
	//
$rss_content .= '<item>
	<g:id>' . $v->ID . '</g:id>
	<g:availability>' . ( _eb_get_post_object( $v->ID, '_eb_product_buyer', 0 ) < _eb_get_post_object( $v->ID, '_eb_product_quantity', 0 ) ? 'in stock' : 'out of stock' ) . '</g:availability>
	<g:condition>new</g:condition>
	<g:description><![CDATA[' . $v->post_excerpt . ']]></g:description>
	<g:image_link>' . _eb_get_post_img( $v->ID ) . '</g:image_link>
	<g:link>' . $p_link . '</g:link>
	<g:title><![CDATA[' . $v->post_title . ']]></g:title>
	<g:price>' . $before_price . $price . $after_price . '</g:price>
	<g:sale_price>' . $before_price . $sale_price . $after_price . '</g:sale_price>
	<g:brand>' . $rss_brand . '</g:brand>
	' . $for_google . '
</item>';

}



$rss_content .= '</channel>
</rss>';
	
	
	
	
	// ép lưu cache
	_eb_get_static_html ( $rssCacheFilter, $rss_content, '', 60 );
	
}


//
echo $rss_content;



