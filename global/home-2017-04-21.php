<?php
/*
* Mọi code dùng chung cho trang chủ sản phẩm, lấy hay không sẽ dựa vào config của khách
*/



//
$dynamic_meta .= '<link rel="canonical" href="' . web_link . '" />';



//
$id_for_get_sidebar = 'home_sidebar';




// cache
/*
$strCacheFilter = 'home';
$main_content = _eb_get_static_html ( $strCacheFilter );
if ($main_content == false) {
	*/




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
}




/*
* sản phẩm theo từng phân nhóm
*/
$home_with_cat = '';
if ( $__cf_row['cf_num_home_list'] > 0 ) {
	$args = array(
		'parent' => 0,
	);
	$categories = get_categories($args);
//	print_r( $categories );
	
	//
	$new_cat = array();
	
	// lấy các nhóm theo trạng thái nhất định
	if ( isset( $eb_get_cat_by_status ) ) {
		
		// lấy chính xác
		if ( $eb_get_cat_by_status > 0 ) {
			foreach ( $categories as $v ) {
				if ( (int) _eb_get_post_meta( $v->term_id, '_eb_category_status', true, 0 ) == $eb_get_cat_by_status ) {
					$new_cat[ $v->term_id ] = (int) _eb_get_post_meta( $v->term_id, '_eb_category_order', true, 0 );
				}
			}
		}
		// lấy tương đối
		else {
			foreach ( $categories as $v ) {
				if ( (int) _eb_get_post_meta( $v->term_id, '_eb_category_status', true, 0 ) > 0 ) {
					$new_cat[ $v->term_id ] = (int) _eb_get_post_meta( $v->term_id, '_eb_category_order', true, 0 );
				}
			}
		}
		
	}
	// mặc định là lấy hết
	else {
		foreach ( $categories as $v ) {
			$new_cat[ $v->term_id ] = (int) _eb_get_post_meta( $v->term_id, '_eb_category_order', true, 0 );
		}
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
		
		$home_node_cat = _eb_load_post( $__cf_row['cf_num_home_list'], $args );
		
		//
		if ( $home_node_cat != '' ) {
			$cat_name = '';
			$cat_link = '';
			$cat_count = 0;
			foreach ( $categories as $k2 => $v2 ) {
				if ( $v2->term_id == $k ) {
					$cat_count = $v2->count;
					$cat_name = $v2->cat_name;
					$cat_link = _eb_c_link( $v2->term_id );
					break;
				}
			}
			
			
			
			// danh sách nhóm cấp 2
			$arr_sub_cat = array(
				'parent' => $k,
			);
			$sub_cat = get_categories($arr_sub_cat);
//			print_r( $sub_cat );
			
			$str_sub_cat = '';
			foreach ( $sub_cat as $sub_v ) {
				$str_sub_cat .= ' <a href="' . _eb_c_link( $sub_v->term_id ) . '">' . $sub_v->name . ' <span class="home-count-subcat">(' . $sub_v->count . ')</span></a>';
			}
			
			
			
			// banner quảng cáo theo từng danh mục (cấp 1)
			$home_ads_by_cat = _eb_load_ads( 9, 1, '', array(
				'cat' => $k,
			), 0, EBE_get_page_template( 'home_ads_by_cat' ) );
			
			
			
			//
			if ( $i % 2 == 0 ) {
				$class_for_chanle = 'home-node-chan';
			}
			else {
				$class_for_chanle = 'home-node-le';
			}
			
			
			
			
			// gắn HTML vào khung nội dung phụ -> vẫn ưu tiên HTML của theme trước
			$home_with_cat .= EBE_html_template( EBE_get_page_template( 'home_node' ), array(
				'tmp.cat_id' => $k,
				'tmp.cat_link' => $cat_link,
				'tmp.cat_name' => $cat_name,
				'tmp.cat_count' => $cat_count,
				
				// danh sách nhóm cấp 2
				'tmp.str_sub_cat' => $str_sub_cat,
				
				// danh sách sản phẩm
				'tmp.home_node_cat' => $home_node_cat,
				
				// quảng cáo theo nhóm cấp 1
				'tmp.home_ads_by_cat' => $home_ads_by_cat,
				
				// bg chẵn lẻ
				'tmp.class_for_chanle' => $class_for_chanle,
			) );
			/*
			$home_with_cat .= '
			<div data-id="' . $k . '" class="thread-home-c2"><a href="' . $cat_link . '">' . $cat_name . '</a></div>
			<ul class="thread-list cf">
				' . $home_node_cat . '
			</ul>';
			*/
			
			//
			$i++;
			
			//
			if ( $i >= $__cf_row['cf_num_limit_home_list'] ) {
				break;
			}
		}
	}
}
//echo $home_with_cat;
	
	
	
	
	
	//
	$arr_main_content = array(
		'tmp.home_cf_title' => $__cf_row ['cf_title'],
		'tmp.home_hot' => $home_hot,
		'tmp.home_new' => $home_new,
		'tmp.home_with_cat' => $home_with_cat,
	);
	
	// tìm và tạo sidebar luôn
//	$arr_main_content['tmp.str_sidebar'] = _eb_echbay_sidebar( $id_for_get_sidebar );
	
	
	// lấy HTML riêng của từng site
	if ( function_exists('eb_home_for_current_domain') ) {
		$arr_main_new_content = eb_home_for_current_domain();
		
		// -> chạy vòng lặp, ghi đè lên mảng cũ
		foreach ( $arr_main_new_content as $k => $v ) {
			$arr_main_content[$k] = $v;
		}
	}
	
	
	
	// lấy template theo từng trang
//	echo EB_THEME_PLUGIN_INDEX . 'html/<br>';
	
	//
//	$main_content = EBE_str_template( 'home.html', $arr_main_content );
	$main_content = EBE_html_template( EBE_get_page_template( $act ), $arr_main_content );
	
	
	
	// lưu cache
	/*
	_eb_get_static_html ( $strCacheFilter, $main_content );
	

} // end cache
*/




// loại bỏ chức năng bỏ qua sản phẩm đã lấy, để custom code còn hoạt động được
$___eb_post__not_in = '';





