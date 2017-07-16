<?php




/*
* sản phẩm nổi bật
*/
$home_hot = '';
if ( $__cf_row['cf_num_home_hot'] > 0 ) {
	$home_hot = _eb_load_post( $__cf_row['cf_num_home_hot'], array(
		'meta_key' => '_eb_product_status',
		'meta_value' => 1,
	) );
	
	// nếu không có -> lấy sản phẩm mới nhất hoặc xếp cao nhất
	if ( $home_hot == '' ) {
		$home_hot = _eb_load_post( $__cf_row['cf_num_home_hot'] );
	}
	
	// nếu có dữ liệu trả về
	if ( $home_hot != '' ) {
		$home_hot = EBE_html_template( EBE_get_page_template( 'home_hot' ), array(
			'tmp.home_hot_title' => '<i class="fa fa-dollar"></i> Sản phẩm HOT',
			'tmp.home_hot' => $home_hot,
		) );
	}
}


/*
* sản phẩm mới
*/
$home_new = '';
if ( $__cf_row['cf_num_home_new'] > 0 ) {
	$home_new = _eb_load_post( $__cf_row['cf_num_home_new'], array(
		'meta_key' => '_eb_product_status',
		'meta_value' => 2,
	) );
	
	// nếu không có -> lấy sản phẩm mới nhất hoặc xếp cao nhất
	if ( $home_new == '' ) {
		$home_new = _eb_load_post( $__cf_row['cf_num_home_new'] );
	}
	
	// nếu có dữ liệu trả về
	if ( $home_new != '' ) {
		$home_new = EBE_html_template( EBE_get_page_template( 'home_hot' ), array(
			'tmp.home_hot_title' => '<i class="fa fa-star"></i> Sản phẩm MỚI',
			'tmp.home_hot' => $home_new,
		) );
	}
}




/*
* sản phẩm theo từng phân nhóm
*/
$home_with_cat = '';
if ( $__cf_row['cf_num_home_list'] > 0 ) {
	// chỉ lấy sản phẩm theo các nhóm cấp 1
	$args = array(
		'parent' => 0,
	);
	$categories = get_categories($args);
	print_r( $categories );
	
	//
	$new_cat = array();
	// sắp xếp lại thứ tự của cat
	foreach ( $categories as $v ) {
		$new_cat[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
	}
	print_r( $new_cat );
	
	// Sắp xếp mảng từ lớn đến bé
	arsort( $new_cat );
	print_r( $new_cat );
	
	//
	$i = 0;
	$args = array();
	foreach ( $new_cat as $k => $v ) {
		$args['cat'] = $k;
		
		$home_detauls_categories = get_term_by('id', $cat_ids, 'category');
		
		// nếu nhóm này có sản phẩm
		if ( $home_detauls_categories->count > 0 ) {
			$home_node_cat = _eb_load_post( $__cf_row['cf_num_home_list'], $args );
			
			$home_with_cat .= EBE_html_template( EBE_get_page_template( 'home_node' ), array(
				'tmp.home_node_cat' => $home_node_cat,
			) );
		}
	}
}




