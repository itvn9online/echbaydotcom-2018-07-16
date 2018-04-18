<?php



//
$structured_data_detail = '';



//
$url_og_url = _eb_c_link( $__category->term_id );


//
$amp_str_go_to .= ' &raquo; <a href="' . $url_og_url . '">' . $__category->name . '</a>';



//
$amp_content .= $code_adsense_top;




//
$add_ads = 0;
if ( have_posts() ) {
	while ( have_posts() ) {
		
		//
		the_post();
//		print_r( $post );
		
		//
		$p_link = _eb_p_link ( $post->ID );
		
		//
		$trv_img = _eb_get_post_img( $post->ID, 'medium' );
		if ( $trv_img != '' ) {
			
			//
			$amp_avt_size = $eb_amp->img_size( $trv_img );
			
			//
			$amp_avt_width = $amp_avt_size[0];
			$amp_avt_height = $amp_avt_size[1];
			
			//
			$trv_img = '<div><a href="' . $p_link . '"><amp-img src="' . $trv_img . '" width="' . $amp_avt_width . '" height="' . $amp_avt_height . '" class="amp-wp-enforced-sizes" sizes="(min-width: 600px) 600px, 100vw"></amp-img></a></div>';
		}
		
		
		//
		$trv_giaban = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_oldprice' ) );
		if ( $trv_giaban > 0 ) {
			$trv_giaban = '<div class="amp-wp-blogs-giacu">' . WGR_money_format( $trv_giaban ) . '</div>';
		} else {
			$trv_giaban = '';
		}
		
		//
		$trv_giamoi = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_price' ) );
		if ( $trv_giamoi > 0 ) {
			$trv_giamoi = '<div class="amp-wp-blogs-giamoi">' . WGR_money_format( $trv_giamoi ) . '</div>';
		} else {
			$trv_giamoi = '';
		}
		
		
		//
		$amp_content .= '
<div class="amp-wp-blogs-list">
	<h2 class="amp-wp-blogs-title"><a href="' . $p_link . '">' . $post->post_title . '</a></h2>
	' . $trv_img . '
	<div class="amp-wp-blogs-padding">
		' . $trv_giaban . $trv_giamoi . '
		<div class="amp-wp-blogs-desc">' . nl2br( trim( strip_tags( $post->post_excerpt ) ) ) . '</div>
		<div class="amp-wp-blogs-date">' . date( 'd/m/Y H:i', strtotime( $post->post_modified ) ) . '</div>
	</div>
</div>';
		
		
		// ad qc vào vị trí thứ 3
		if ( $add_ads == 3 ) {
			$amp_content .= $code_adsense_content;
		}
		$add_ads++;
		
	}
	
	
	
	
	// nếu có hơn 6 bài viết -> add thêm qc vào cuối danh sách
	if ( $add_ads > 6 ) {
		$amp_content .= $code_adsense_top;
	}
	
	//
	if ( $str_page != '' ) {
		$amp_content .= '<div class="amp-wp-blogs-part">' . $str_page . '</div>';
	}
	
	
}





//
//exit();




