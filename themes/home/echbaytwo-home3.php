<?php
/*
Description: Tạo danh sách sản phẩm theo từng phân nhóm cho trang chủ.
Tags: list product by category
*/



//
if ( $__cf_row['cf_num_home_list'] > 0 ) {
	// chỉ lấy sản phẩm theo các nhóm cấp 1
	$args = array(
		'parent' => 0,
	);
	$categories = get_categories($args);
//	print_r( $categories );
	
	//
	$new_cat = array();
	// sắp xếp lại thứ tự của cat
	foreach ( $categories as $v ) {
		$new_cat[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
	}
//	print_r( $new_cat );
	
	// Sắp xếp mảng từ lớn đến bé
	arsort( $new_cat );
//	print_r( $new_cat );
	
	//
	$i = 0;
	$args = array();
	foreach ( $new_cat as $k => $v ) {
		$args['cat'] = $k;
		$cat_ids = $k;
		
		$home_detauls_categories = get_term_by('id', $k, 'category');
//		print_r( $home_detauls_categories );
		
		// nếu nhóm này có sản phẩm
		if ( $home_detauls_categories->count > 0 ) {
			$home_node_cat = _eb_load_post( $__cf_row['cf_num_home_list'], $args );
			
			//
			if ( $home_node_cat != '' ) {
				// danh sách nhóm cấp 2
				$arr_sub_cat = array(
					'parent' => $cat_ids,
				);
				$sub_cat = get_categories($arr_sub_cat);
//				print_r( $sub_cat );
				
				$str_sub_cat = '';
				foreach ( $sub_cat as $sub_v ) {
					$str_sub_cat .= ' <a href="' . _eb_c_link( $sub_v->term_id ) . '">' . $sub_v->name . ' <span class="home-count-subcat">(' . $sub_v->count . ')</span></a>';
				}
				
				
				
				// banner quảng cáo theo từng danh mục (cấp 1)
				$home_ads_by_cat = _eb_load_ads( 9, 5, '', array(
					'cat' => $cat_ids,
				), 0, str_replace( 'ti-le-global', '', EBE_get_page_template( 'ads_node' ) ) );
				
				
				
				// Lấy theo mẫu của widget #home_product
				echo EBE_html_template( EBE_get_page_template( 'home_node' ), array(
					'tmp.cat_id' => $k,
					'tmp.cat_link' => _eb_c_link( $k ),
					'tmp.cat_name' => $home_detauls_categories->name,
					'tmp.cat_count' => $home_detauls_categories->count,
					'tmp.description' => '',
					
					// danh sách nhóm cấp 2
					'tmp.str_sub_cat' => $str_sub_cat,
					
					// danh sách sản phẩm
					'tmp.home_node_cat' => $home_node_cat,
					
					// quảng cáo theo nhóm cấp 1
					'tmp.home_ads_by_cat' => $home_ads_by_cat,
					
					// bg chẵn lẻ
					'tmp.num_post_line' => '',
					'tmp.max_width' => '',
				) );
			}
		}
	}
}
else {
	echo '<!-- cf_num_home_list == ZERO -->';
}




