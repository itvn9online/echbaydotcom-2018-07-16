<?php
/*
Description: Tạo danh sách sản phẩm theo từng phân nhóm cho trang chủ, nếu có các nhóm được đặt làm nhóm chính (primary) thì chỉ hiển thị các nhóm này.
Tags: list product by category
*/




//
if ( $__cf_row['cf_num_home_list'] > 0 ) {
	
	//
//	print_r($widget_select_categories);
//	$widget_select_categories = array();
	
	// nếu có nhóm này từ widget home_list -> sử dụng luôn
	if ( isset( $widget_select_categories ) && count( $widget_select_categories ) > 0 ) {
		$categories = $widget_select_categories;
	}
	else {
		// chỉ lấy sản phẩm theo các nhóm cấp 1
		$args = array(
			'parent' => 0,
		);
		$categories = get_categories($args);
//		print_r( $categories );
		
		
		// Thử kiểm tra xem trong này có nhóm nào được set là nhóm chính không
		$post_primary_categories = array();
//		print_r( $post_categories );
		foreach ( $categories as $v ) {
			if ( _eb_get_cat_object( $v->term_id, '_eb_category_primary', 0 ) > 0 ) {
				$post_primary_categories[] = $v;
			}
		}
//		print_r( $post_primary_categories );
		
		
		// nếu có nhóm chính -> tiếp theo chỉ lấy các nhóm chính
		if ( count( $post_primary_categories ) > 0 ) {
			$categories = $post_primary_categories;
		}
	}
//	print_r($categories);
	
	
	//
	$new_cat = WGR_order_and_hidden_taxonomy( $categories );
	/*
	$new_cat = array();
	$new_name_cat = array();
	// sắp xếp lại thứ tự của cat
	foreach ( $categories as $v ) {
		$new_cat[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
		$new_name_cat[ $v->term_id ] = $v;
	}
//	print_r( $new_cat );
	
	// Sắp xếp mảng từ lớn đến bé
	arsort( $new_cat );
//	print_r( $new_cat );
	*/
	
	//
	$i = 0;
	$args = array();
	foreach ( $new_cat as $k => $v ) {
		// không lấy nhóm cấp 1 mặc định của wp
//		if ( $k != 1 ) {
		// ko lấy các nhóm ẩn
//		if ( _eb_get_cat_object( $k, '_eb_category_hidden', 0 ) != 1 ) {
			$args['cat'] = $k;
			$cat_ids = $k;
			
			//
//			$home_detauls_categories = get_term_by('id', $k, 'category');
//			print_r( $home_detauls_categories );
//			$home_detauls_categories = get_term($k);
//			print_r( $home_detauls_categories );
//			$home_detauls_categories = $new_name_cat[ $k ];
			$home_detauls_categories = $v;
//			print_r( $home_detauls_categories );
			
			// nếu nhóm này có sản phẩm
//			if ( $home_detauls_categories->count > 0 ) {
				
				//
				$home_node_cat = _eb_load_post( $__cf_row['cf_num_home_list'], $args );
				
				//
				if ( $home_node_cat != '' ) {
					
					// lấy danh sách nhóm con
					$str_sub_cat = WGR_get_home_node_sub_cat( $cat_ids, $__cf_row['cf_home_sub_cat_tag'] );
					
					
					
					// banner quảng cáo theo từng danh mục (cấp 1)
					$home_ads_by_cat = WGR_get_home_node_ads( $cat_ids );
					/*
					$home_ads_by_cat = _eb_load_ads( 9, _eb_number_only( EBE_get_lang('homelist_num') ), EBE_get_lang('homelist_size'), array(
						'cat' => $cat_ids,
					), 0, EBE_get_page_template( 'ads_node' ) );
//					), 0, str_replace( 'ti-le-global', '', EBE_get_page_template( 'ads_node' ) ) );
					*/
					
					
					//
					$cat_link = _eb_c_link( $k );
					$more_link = '<div class="widget-products-more"><a href="' . $cat_link . '">' . EBE_get_lang('widget_products_more') . '</a></div>';
					
					
					// Lấy theo mẫu của widget #home_product
					echo WGR_show_home_node( array(
						'tmp.cat_id' => $k,
						'tmp.cat_link' => $cat_link,
						'tmp.cat_name' => $home_detauls_categories->name,
						'tmp.cat_count' => $home_detauls_categories->count,
						'tmp.description' => '',
						
						// danh sách nhóm cấp 2
						'tmp.str_sub_cat' => $str_sub_cat,
						
						// danh sách sản phẩm
						'tmp.home_node_cat' => $home_node_cat,
						
						// quảng cáo theo nhóm cấp 1
						'tmp.home_ads_by_cat' => $home_ads_by_cat,
						
						//
						'tmp.more_link' => $more_link,
						
						//
						'tmp.num_post_line' => isset( $_GET['home_list_num_line'] ) ? $_GET['home_list_num_line'] : '',
					), $__cf_row['cf_home_sub_cat_tag'] );
					
					/*
					echo EBE_html_template( EBE_get_page_template( 'home_node' ), array(
						
						// bg chẵn lẻ
						'tmp.num_post_line' => '',
						'tmp.max_width' => '',
					) );
					*/
					
				}
				else {
					echo '<!-- ';
					print_r( $args );
					echo ' -->';
				}
//			}
//		}
	}
}
else {
	echo '<!-- cf_num_home_list == ZERO -->';
}




