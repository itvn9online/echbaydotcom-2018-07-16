<?php




// lấy lượt xem sản phẩm
$trv_luotxem = _eb_number_only( _eb_get_post_object( $pid, '_eb_product_views', 0 ) );

// kiểm tra trong cookie xem có chưa
$str_history = _eb_getCucki('wgr_product_id_view_history');
if ( $str_history == '' || strstr( $str_history, '[' . $pid . ']' ) == false ) {
	// tăng lượt view lên -> do lượt view sử dụng cookie lưu trong 7 ngày, nên lượt view cũng tăng nhiều lên 1 chút -> tính theo dạng 6 tiếng 1 view -> ngày 4 view
	$trv_luotxem += rand( 15, 30 );
	
	// cập nhật lượt view mới
	WGR_update_meta_post( $pid, '_eb_product_views', $trv_luotxem );
}


// set trạng thái trang là sản phẩm
$web_og_type = 'product';

//
//	$check_html_rieng = _eb_get_private_html( 'blog_details.html', 'blog_node.html' );

//	$product_list_medium = _eb_load_post( 10, array(), $check_html_rieng['html'] );



// lấy màu sắc sản phẩm
/*
$sql = _eb_q("SELECT *
FROM
	`" . wp_termmeta . "`
WHERE
	meta_key = '_eb_category_status'
	AND meta_value = 7");
*/
/*
$sql = _eb_q("SELECT *
FROM
	" . wp_postmeta . "
WHERE
	meta_key = '_eb_category_status'
	AND meta_value = 7");
//print_r($sql);

//
$arr_post_options = wp_get_object_terms( $pid, 'post_options' );
//	print_r($arr_post_options);

foreach ( $sql as $v ) {
//		print_r($v);
	
	foreach ( $arr_post_options as $v2 ) {
//			print_r($v2);
		
		//
//		if ( $v->post_id == $v2->parent ) {
		if ( $v->term_id == $v2->parent ) {
			$arr_product_color .= ',{ten:"' . $v2->name . '",val:"' . _eb_get_cat_object( $v2->term_id, '_eb_category_title', '#fff' ) . '"}';
		}
	}
}
*/




// Tạo menu cho post option
$arr_post_options = wp_get_object_terms( $pid, 'post_options' );
//if ( mtv_id == 1 ) print_r($arr_post_options);

// sắp xếp theo STT
//$sort_post_options = WGR_order_and_hidden_taxonomy( $arr_post_options );
$sort_post_options = array();
$new_post_options = array();
foreach ( $arr_post_options as $v ) {
//	echo $v->term_id . '<br>' . "\n";
	
	// chỉ lấy các nhóm được xác minh là hiển thị
	if ( _eb_get_cat_object( $v->term_id, '_eb_category_hidden', 0 ) != 1 ) {
		// đoạn này sẽ order theo nhóm cha của taxonomy
		$sort_post_options[ $v->term_id ] = (int) _eb_get_cat_object( $v->parent, '_eb_category_order', 0 );
	}
	$new_post_options[ $v->term_id ] = $v;
}
arsort( $sort_post_options );
//if ( mtv_id == 1 ) print_r( $sort_post_options );
//print_r( $new_post_options );

//
//foreach ( $arr_post_options as $v ) {
foreach ( $sort_post_options as $k=> $v ) {
	$v = $new_post_options[ $k ];
	
	//
	if ( $v->parent > 0 ) {
//		$parent_name = get_term_by( 'id', $v->parent, $v->taxonomy );
		$parent_name = WGR_get_taxonomy_parent( $v );
//		if ( mtv_id == 1 ) print_r( $parent_name );
		
		//
		$other_option_list .= '
<tr>
	<td><div>' . $parent_name->name . '</div></td>
	<td><div><a href="' . _eb_c_link( $v->term_id, $v->taxonomy ) . '" target="_blank">' . $v->name . '</a></div></td>
</tr>';
	}
}




// tag of post
$arr_list_tag = get_the_tags( $pid );


//
$limit_other_post = $__cf_row['cf_num_details_list'];

/*
* other post
*/

// Thử kiểm tra xem trong này có nhóm nào được set là nhóm chính không
$post_primary_categories = array();
//print_r( $post_categories );
foreach ( $post_categories as $v ) {
	if ( _eb_get_cat_object( $v, '_eb_category_primary', 0 ) > 0 ) {
		$post_primary_categories[] = $v;
	}
}
//print_r( $post_primary_categories );

// nếu không tìm được -> lấy tất
//if ( count( $post_primary_categories ) == 0 ) {
if ( empty( $post_primary_categories ) ) {
	$post_primary_categories = $post_categories;
}
//	print_r( $post_primary_categories );


//
if ( $limit_other_post > 0 ) {
	
	//
//	$arr_post_not_in = array();
	
	//
	$prev_post = get_previous_post();
//	print_r($prev_post);
	if ( isset($prev_post->ID) ) {
		$limit_other_post--;
//		$arr_post_not_in[] = $prev_post->ID;
		
		$other_post_right .= _eb_load_post( 1, array(
			'p' => $prev_post->ID
			/*
			'post__in' => array(
				$prev_post->ID
			)
			*/
		) );
	}
	
	//
	$next_post = get_next_post();
//	print_r($next_post);
	if ( isset($next_post->ID) ) {
		$limit_other_post--;
//		$arr_post_not_in[] = $next_post->ID;
		
		$other_post_right .= _eb_load_post( 1, array(
			'p' => $next_post->ID
			/*
			'post__in' => array(
				$next_post->ID
			)
			*/
		) );
	}
	
	// nếu không có giới hạn bài viết cho phần other post -> lấy mặc định 10 bài
//		if ( ! isset($limit_other_post) ) {
//			$limit_other_post = $__cf_row['cf_num_details_list'];
//		}
	
	
	//
//	echo $limit_other_post;
	
	//
//	$arr_post_not_in[] = $__post->ID;
	
	//
	$other_post_right .= _eb_load_post( $limit_other_post, array(
//		'post__not_in' => $arr_post_not_in,
		'post__not_in' => array( $pid ),
//		'category__in' => wp_get_post_categories( $__post->ID )
		'category__in' => $post_primary_categories
	) );
	
}



// lấy thêm loạt bài tiếp theo, 1 số giao diện sẽ sử dụng
if ( $__cf_row['cf_num_details2_list'] > 0 ) {
	$other_post_2right .= _eb_load_post( $__cf_row['cf_num_details2_list'], array(
		/*
		'post__not_in' => array(
			$__post->ID
		),
		*/
		'category__in' => $post_primary_categories
	) );
}



// lấy thêm loạt bài tiếp theo, 1 số giao diện sẽ sử dụng
if ( $__cf_row['cf_num_details3_list'] > 0 ) {
	$other_post_3right .= _eb_load_post( $__cf_row['cf_num_details3_list'], array(
		/*
		'post__not_in' => array(
			$__post->ID
		),
		*/
		'category__in' => $post_primary_categories
	) );
}



//
if ( $__cf_row['cf_post_column_style'] != '' ) {
	$custom_product_flex_css = EBE_get_html_file_addon( $html_v2_file, $__cf_row['cf_post_column_style'] );
}



//
$str_for_details_sidebar = _eb_echbay_get_sidebar( 'post_content_sidebar' );
$str_for_details_top_sidebar = _eb_echbay_get_sidebar( 'post_top_content_sidebar' );




// thêm mã nhúng cho trang chi tiết sản phẩm
$__cf_row['cf_js_head'] .= EBE_get_lang('cc_head_product');
$__cf_row['cf_js_allpage'] .= EBE_get_lang('cc_body_product');


