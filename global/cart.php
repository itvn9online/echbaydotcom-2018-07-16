<?php

$__cf_row ['cf_title'] = EBE_get_lang('shopping_cart');
$group_go_to[] = ' <li><a href="./cart" rel="nofollow">' . $__cf_row ['cf_title'] . '</a></li>';


//
$__cf_row ['cf_title'] .= ': ' . web_name . ' - ' . $__cf_row ['cf_abstract'];
$__cf_row ['cf_keywords'] = $__cf_row ['cf_title'];
$__cf_row ['cf_description'] = $__cf_row ['cf_title'];



//
$cart_list_id = _eb_getCucki( 'eb_cookie_cart_list_id' );
//echo $cart_list_id . '<br>' . "\n";
$new_id = 0;
if ( isset($_GET['id']) && ( $new_id = (int)$_GET['id'] ) > 0 ) {
//	echo $new_id;
	$cart_list_id .= ',' . $new_id;
}
//echo $cart_list_id . '<br>' . "\n";

$cart_list = '';
$cart_total = 0;





if ( $cart_list_id != '' && substr( $cart_list_id, 0, 1 ) == ',' ) {
	
	// v1
	/*
	$sql = _eb_load_post_obj( 100, array(
		'post__in' => explode( ',', substr( $cart_list_id, 1 ) ),
	) );
	*/
	
	// v2 -> lấy theo lệnh mysql ví wordpres nó lấy cả sản phẩm sticky vào
	$sql = _eb_q("SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		ID IN (" . substr( $cart_list_id, 1 ) . ")
		AND post_status = 'publish'
		AND post_type = 'post'");
//	print_r( $sql );
	
	//
	$select_soluong = '';
	for ( $i = 1; $i < 11; $i++ ) {
		$select_soluong .= '<option value="' . $i . '">' . $i . '</option>';
	}
	$select_soluong = '<select name="t_soluong[{cart.post_id}]" data-name="{cart.post_id}" class="change-select-quanlity">' . $select_soluong . '</select>';
	
	// v1
	/*
	while ( $sql->have_posts() ) {
		
		$sql->the_post();
		
		$post = $sql->post;
		*/
	foreach ( $sql as $post ) {
		
		//
//		print_r($post);
		
		//
//		$p_link = get_the_permalink( $post->ID );
		$p_link = _eb_p_link( $post->ID );
		
		$trv_masanpham = _eb_get_post_object( $post->ID, '_eb_product_sku', $post->ID );
		
		/*
		$trv_img = wp_get_attachment_image_src ( get_post_thumbnail_id( $post->ID ), $__cf_row['cf_product_thumbnail_size'] );
		$trv_img = ! empty( $trv_img[0] ) ? esc_url( $trv_img[0] ) : _eb_get_post_meta( $post->ID, '_eb_product_avatar', true );
		*/
		$trv_img = _eb_get_post_img( $post->ID, 'medium' );
		
//		$trv_giamoi = (int) _eb_get_post_meta( $post->ID, '_eb_product_price', true );
		$trv_giaban = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_oldprice' ) );
		
		$trv_giamoi = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_price' ) );
		
		$soLuong = 1;
		$total_line = $trv_giamoi * $soLuong;
		$cart_total += $total_line;
		
		
		
		//
		$post_categories = wp_get_post_categories( $post->ID );
//		print_r($post_categories);
		
		//
	    $cat = get_term( $post_categories[0] );
//		print_r( $cat );
		
		//
		$c_link = _eb_c_link($cat->term_id);
		$c_name = $cat->name;
		
		
		
		//
		$animate_id = 'tr_cart_' . $post->ID;
		
		
		//
		$cart_list .= '
<tr data-id="' . $post->ID . '" data-old-price="' . $trv_giaban . '" data-price="' . $trv_giamoi . '" data-sku="' . $trv_masanpham . '" id="' . $animate_id . '" class="each-for-set-cart-value">
	<td class="cf">
		<div class="lf f30 fullsize-if-mobile">
			<div><a href="' . $p_link . '"><img src="' . $trv_img . '" height="90" /></a></div>
			<br>
		</div>
		<div class="lf f70 fullsize-if-mobile">
			<div><a href="' . $p_link . '" class="bold upper medium blackcolor get-product-name-for-cart">' . $post->post_title . '</a></div>
			<div data-id="' . $post->ID . '" class="show-list-color"></div>
			<div data-id="' . $post->ID . '" class="show-list-size"></div>
			<div class="bold big show-if-mobile">' . EBE_add_ebe_currency_class ( $trv_giamoi ) . '</div>
			<br>
			<div><a href="' . $c_link . '" class="upper blackcolor">' . $c_name . '</a></div>
			<div class="cart-table-remove"><i onClick="_global_js_eb.cart_remove_item(' . $post->ID . ', \'' . $animate_id . '\');" class="fa fa-remove cur"></i></div>
			<input type="hidden" name="t_muangay[]" value="' . $post->ID . '" />
		</div>
	</td>
	<td class="bold big hide-if-mobile">' . EBE_add_ebe_currency_class ( $trv_giamoi ) . '</td>
	<td>' . str_replace( '{cart.post_id}', $post->ID, $select_soluong ) . '</td>
	<td class="bold big hide-if-mobile cart-total-inline">' . EBE_add_ebe_currency_class ( $total_line ) . '</td>
</tr>';
		
		//
	}
	
	//
	wp_reset_postdata();
}



// kiểm tra nếu có file html riêng -> sử dụng html riêng
/*
$check_html_rieng = EB_THEME_HTML . 'cart.html';
$thu_muc_for_html = EB_THEME_HTML;
if ( ! file_exists($check_html_rieng) ) {
	$thu_muc_for_html = EB_THEME_PLUGIN_INDEX . 'html/';
}

//
$main_content = EBE_str_template ( 'cart.html', array (
	'tmp.js' => 'var new_cart_auto_add_id=' . $new_id . ';',
	
	'tmp.cart_list' => $cart_list,
	'tmp.cart_total' => EBE_add_ebe_currency_class ( $cart_total ),
), $thu_muc_for_html );
*/

//
$chinhsach = '';
if ( EBE_get_lang('url_chinhsach') != '#' ) {
	$chinhsach = str_replace( '{tmp.url_chinhsach}', EBE_get_lang('url_chinhsach'), EBE_get_lang('chinhsach') );
	
	$chinhsach = '
	<li>
		<p class="l19 small">
			<input type="checkbox" name="t_dongy" checked>
			' . $chinhsach . '
		</p>
	</li>';
}




//
$custom_lang_html = EBE_get_lang('cart_html');
// mặc định là lấy theo file HTML -> act
if ( trim( $custom_lang_html ) == $act ) {
	$custom_lang_html = EBE_get_page_template( $act );
}

//
$main_content = EBE_html_template( $custom_lang_html, array(
	'tmp.js' => 'var new_cart_auto_add_id=' . $new_id . ';',
	
	'tmp.cart_list' => $cart_list,
	'tmp.cart_total' => EBE_add_ebe_currency_class ( $cart_total ),
	
	'tmp.cart_hoten' => EBE_get_lang('cart_hoten'),
	'tmp.cart_pla_dienthoai' => EBE_get_lang('cart_pla_dienthoai'),
	'tmp.cart_diachi2' => EBE_get_lang('cart_diachi2'),
	'tmp.cart_vidu' => EBE_get_lang('cart_vidu'),
	
	'tmp.cf_required_name_cart' => ( $__cf_row['cf_required_name_cart'] == 1 ) ? ' aria-required="true" required' : '',
	'tmp.cf_required_email_cart' => ( $__cf_row['cf_required_email_cart'] == 1 ) ? ' aria-required="true" required' : '',
	'tmp.cf_required_address_cart' => ( $__cf_row['cf_required_address_cart'] == 1 ) ? ' aria-required="true" required' : '',
	
	'tmp.chinhsach' => $chinhsach
) );

