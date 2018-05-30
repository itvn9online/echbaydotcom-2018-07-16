<?php


//
$__post = $post;

$pid = $__post->ID;

$url_og_url = _eb_p_link( $pid );
_eb_fix_url( $url_og_url );

$link_for_fb_comment = web_link . '?p=' . $pid;

$eb_wp_post_type = $__post->post_type;



// lưu các post meta dưới dạng object
//$arr_object_post_meta = _eb_get_object_post_meta( $pid );
//print_r( $arr_object_post_meta );




// SEO
if ( cf_on_off_echbay_seo == 1 ) {
	$__cf_row ['cf_title'] = _eb_get_post_object( $pid, '_eb_product_title', $__post->post_title );
//	if ( $__cf_row ['cf_title'] == '' ) $__cf_row ['cf_title'] = $__post->post_title;
	
	$__cf_row ['cf_keywords'] = _eb_get_post_object( $pid, '_eb_product_keywords', $__post->post_title );
//	if ( $__cf_row ['cf_keywords'] == '' ) $__cf_row ['cf_keywords'] = $__post->post_title;
	
	$__cf_row ['cf_description'] = _eb_get_post_object( $pid, '_eb_product_description', $__post->post_excerpt );
	if ( $__cf_row ['cf_description'] == '' ) {
		/*
		if ( $__post->post_excerpt != '' ) {
			$__cf_row ['cf_description'] = _eb_del_line( strip_tags( $__post->post_excerpt ), ' ' );
		} else {
			*/
			$__cf_row ['cf_description'] = $__post->post_title;
//		}
	}
//	$__cf_row['cf_description'] = esc_html( $__cf_row['cf_description'] );
	$__cf_row['cf_description'] = str_replace( '"', '&quot;', $__cf_row['cf_description'] );
}


// meta cho thẻ amp -> hiện chỉ hỗ trợ trang chi tiết dạng đơn giản
/*
if ( is_amp_endpoint() ) {
	$arr_dymanic_meta[] = '<link rel="amphtml" href="' . $url_og_url . '/amp" />';
}
*/




//
/*
$test_sql = _eb_q("SELECT *
FROM
	`" . wp_postmeta . "`
WHERE
	post_id = " . $__post->ID);
print_r( $test_sql );
/* */




//
$trv_img = _eb_get_post_img( $__post->ID );
if ( $trv_img != '' ) {
	$image_og_image = $trv_img;
}




