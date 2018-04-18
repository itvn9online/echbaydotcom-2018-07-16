<?php


//print_r( $_POST ); exit();



//
$post_type = trim( $_POST['post_tai'] );
//_eb_alert($post_type);

$trv_source = trim( $_POST['t_source'] );
$trv_tieude = trim( stripslashes( $_POST['t_tieude'] ) );
$trv_seo = trim( $_POST['t_seo'] );
$trv_tags = str_replace( '-', ' ', $trv_seo );
$trv_img = trim( $_POST['t_img'] );
$youtube_url = trim( $_POST['t_youtube_url'] );
$post_date = trim( $_POST['t_ngaydang'] );

$post_excerpt = trim( stripslashes( $_POST['t_goithieu'] ) );
$trv_noidung = trim( stripslashes( $_POST['t_noidung'] ) );

// price
$trv_giaban = _eb_float_only( $_POST['t_giacu'] );
$trv_giamoi = _eb_float_only( $_POST['t_giamoi'] );

//
$ant_id = _eb_number_only( $_POST['t_ant'] );

if ( $ant_id == 0 ) {
	$ant_auto = trim( $_POST['t_new_category'] );
	if ( $ant_auto != '' ) {
		$slug = _eb_non_mark_seo( $ant_auto );
		
		$t_taxonomy = 'category';
		if ( $post_type == EB_BLOG_POST_TYPE ) {
			$t_taxonomy = EB_BLOG_POST_LINK;
		}
		
		// https://codex.wordpress.org/Function_Reference/term_exists
		$check_term_exist = term_exists( $slug, $t_taxonomy );
		if ( $check_term_exist == 0 && $check_term_exist == null ) {
			$done = wp_insert_term(
				// the term 
				$ant_auto,
				// the taxonomy
				$t_taxonomy,
				array(
					'slug' => $slug
				)
			);
			
			$check_term_exist = term_exists( $slug, $t_taxonomy );
			if ( $check_term_exist == 0 && $check_term_exist == null ) {
				$check_term_exist = array();
			}
		}
		
		if ( ! empty( $check_term_exist ) && isset( $check_term_exist['term_id'] ) ) {
			$ant_id = $check_term_exist['term_id'];
		}
		
		//
//		print_r( $check_term_exist ); exit();
	}
}
//_eb_alert($ant_id);



//
$m = '<span class=bluecolor>UPDATE</span>';

$trv_id = trim( $_POST['t_id'] );
//$trv_id = (int)$trv_id;
//echo $trv_id . '<br>';
$trv_sku = $trv_id;

// dùng để kiểm tra ID bài viết đa tồn tại, mà tồn tại dưới dạng bản nháp
$check_post_exist = array();

//
$import_id = 0;

// tìm theo name
//if ( $trv_id == 0 ) {
if ( $trv_id != '' && is_numeric( $trv_id ) && $trv_id > 0 ) {
	/*
	$import_id = $wpdb->get_var("SELECT ID
	FROM
		" . $wpdb->posts . "
	WHERE
		ID = '" . $trv_id . "'");
	*/
	
	//
	$check_post_exist = _eb_q("SELECT *
	FROM
		" . $wpdb->posts . "
	WHERE
		ID = " . $trv_id);
}
// nếu có ID -> tìm theo ID
else {
//	_eb_alert('Không xác định được ID dữ liệu');
	
	// tạo SKU nếu chưa có
	if ( $trv_sku == '' ) {
		$trv_sku = md5( $trv_source );
	}
	
	// tìm xem có bài POST nào như vậy không
	$sql = _eb_load_post_obj( 1, array(
		'post_type' => $post_type,
		'orderby' => 'ID',
		'meta_key' => '_eb_product_leech_sku',
		'meta_value' => $trv_sku,
		/*
		'meta_query' => array(
			'key' => '_eb_product_leech_sku',
			'value' => $trv_sku,
			array(
				'key' => '_eb_product_leech_sku',
				'value' => $trv_sku,
			),
		),
		*/
	) );
//	print_r($sql);
	
	if ( isset( $sql->post->ID ) ) {
		$import_id = $sql->post->ID;
		
		//
		$check_post_exist = _eb_q("SELECT *
		FROM
			" . $wpdb->posts . "
		WHERE
			ID = " . $import_id);
	}
	// tìm theo SEO
	else {
		/*
		$import_id = $wpdb->get_var("SELECT ID
		FROM
			" . $wpdb->posts . "
		WHERE
			post_name = '" . $trv_seo . "'");
		*/
		
		//
		$check_post_exist = _eb_q("SELECT *
		FROM
			`" . $wpdb->posts . "`
		WHERE
			post_name = '" . $trv_seo . "'");
	}
//	echo $import_id . '<br>'; exit();
	
	//
//	$trv_id = (int)$import_id;
}

//
//print_r($check_post_exist);
if ( isset( $check_post_exist[0] ) ) {
	$check_post_exist = $check_post_exist[0];
	
	//
	if ( isset( $check_post_exist->ID ) ) {
		$import_id = $check_post_exist->ID;
	}
}
//echo $import_id . '<br>' . "\r\n";
//print_r($check_post_exist);

//
$import_id = (int)$import_id;

//
//exit();

//
//_eb_alert($import_id);





// insert
if ( $import_id == 0 ) {
	$arr = array(
		'import_id' => $trv_id,
		
		'post_title' => $trv_tieude,
		'post_type' => $post_type,
		'post_parent' => 0,
		'post_author' => mtv_id,
		'post_status' => 'publish',
		'post_name' => $trv_seo,
	);
	
	//
	$import_id = wp_insert_post ( $arr, true );
	if ( is_wp_error($import_id) ) {
		$errors = $import_id->get_error_messages();
		foreach ($errors as $error) {
			echo $error . '<br>' . "\n";
		}
		
		//
		_eb_alert('Lỗi khi import sản phẩm');
	}
	
	//
	$m = '<span class=greencolor>INSERT</span>';
}
// nếu có rồi -> kiểm tra trạng thái
else {
	
	// nếu bài viết đã tồn tại và đang được public -> bỏ qua
	if ( isset( $check_post_exist->post_status ) ) {
		// nếu bài đang được hiển thị bình thường -> update một số thuộc tính có chọn lọc
		if ( $check_post_exist->post_status == 'publish' ) {
			
			//
			$arr_for_update = array();
			
			// cập nhật lại url -> hiện tại đang sai
			if ( $check_post_exist->post_name != $trv_seo ) {
				$arr_for_update['post_name'] = $trv_seo;
				
				/*
				$post_id = wp_update_post( array(
					'ID' => $check_post_exist->ID,
					'post_name' => $trv_seo,
					'post_excerpt' => $post_excerpt,
				), true );
				*/
			}
			
			// cập nhật lại STT
			if ( isset( $_POST['cap_nhat_stt_cho_bai_viet'] ) && $_POST['cap_nhat_stt_cho_bai_viet'] == 1 ) {
				$trv_stt = date( 'ymdh', date_time );
				// thêm số ngẫu nhiên trong khoảng 1 giờ
				if ( isset( $_POST['cap_nhat_stt_ngau_nhien'] ) && $_POST['cap_nhat_stt_ngau_nhien'] == 1 ) {
					$trv_stt += rand( 0, 7200 );
				}
				// thêm số ngẫu nhiên trong khoảng 1 phút
				else {
					$trv_stt += rand( 0, 3600 );
				}
				$arr_for_update['menu_order'] = $trv_stt;
			}
			
			// update meta
			$arr_meta_box = array();
			if ( $trv_giaban > 0 ) $arr_meta_box['_eb_product_oldprice'] = $trv_giaban;
			if ( $trv_giamoi > 0 ) $arr_meta_box['_eb_product_price'] = $trv_giamoi;
			if ( ! empty( $arr_meta_box ) ) {
				$arr_for_update['meta_input'] = $arr_meta_box;
			}
			
			
			//
			if ( ! empty( $arr_for_update ) ) {
				// gán ID cho post cần edit
				$arr_for_update['ID'] = $check_post_exist->ID;
				
				//
				$post_id = wp_update_post( $arr_for_update, true );
				
				if ( is_wp_error($post_id) ) {
				//	print_r( $post_id ) . '<br>';
					
					$errors = $post_id->get_error_messages();
					foreach ($errors as $error) {
						echo $error . '<br>' . "\n";
					}
					
					//
					_eb_alert('Lỗi khi cập nhật sản phẩm đã tồn tại');
				}
			}
			
			
			//
			$m = '<span class=redcolor>EXIST</span>';
			
			//
			$p_link = get_permalink( $import_id );
			//$p_link = web_link . '?p=' . $trv_id;
			
			//
			if ( $p_link == '' ) {
				_eb_alert( 'Permalink not found' );
			}
			
			die('<script type="text/javascript">
parent.ket_thuc_lay_du_lieu(' .$import_id. ', "' .$m. '", "' . $p_link . '");
</script>');
		}
		// nếu gặp phải bản phụ -> xóa luôn
		else if ( isset( $check_post_exist->post_type ) && $check_post_exist->post_type == 'revision' ) {
			wp_delete_post( $check_post_exist->ID, true );
			
			//
			$m = '<span class=orgcolor>DELETE: ' . $check_post_exist->post_type . ' (' . $check_post_exist->ID . ')</span>';
			
			die('<script type="text/javascript">
parent.ket_thuc_lay_du_lieu(' .$import_id. ', "' .$m. '", "javascript:;");
</script>');
		}
		// còn lại thì thôi, không update gì cả
		else {
			
			//
			$m = '<span class=orgcolor>STATUS: ' . $check_post_exist->post_status . ', TYPE: ' . $check_post_exist->post_type . '</span>';
			
			die('<script type="text/javascript">
parent.ket_thuc_lay_du_lieu(' .$import_id. ', "' .$m. '", "' . admin_link . 'post.php?post=' . $import_id . '&action=edit");
</script>');
		}
	}
}

//
$import_id = (int)$import_id;
//echo $import_id . '<br>';
//_eb_alert($import_id);

//
if ( $import_id == 0 ) {
	_eb_alert('ID bài viết không hợp lệ');
}
if ( $trv_id > 0 && $import_id != $trv_id ) {
	_eb_alert('ID bài viết không hợp lệ (' . $import_id . ' != ' . $trv_id . ')');
}

// gán lại ID bài viết -> có trường hợp ở trên không tìm theo ID
$trv_id = $import_id;




// update
$arr_meta_box = array(
	'_eb_product_status' => 0,
//	'_eb_product_color' => '',
//	'_eb_product_sku' => trim($_POST['t_masanpham']),
//	'_eb_product_oldprice' => $trv_giaban,
//	'_eb_product_price' => $trv_giamoi,
//	'_eb_product_buyer' => '',
//	'_eb_product_quantity' => '',
	'_eb_product_leech_source' => $trv_source,
	'_eb_product_leech_sku' => $trv_sku,
//	'_eb_product_avatar' => $trv_img,
//	'_eb_product_video_url' => $youtube_url,
//	'_eb_product_gallery' => trim( stripslashes($_POST['t_gallery']) ),
);

// để tiết kiệm metabox -> đoạn nào có dữ liệu mới vào dùng
if ( $trv_img != '' ) $arr_meta_box['_eb_product_avatar'] = $trv_img;

if ( $trv_giaban > 0 ) $arr_meta_box['_eb_product_oldprice'] = $trv_giaban;

if ( $trv_giamoi > 0 ) $arr_meta_box['_eb_product_price'] = $trv_giamoi;

$t_masanpham = trim($_POST['t_masanpham']);
if ( $t_masanpham != '' ) $arr_meta_box['_eb_product_sku'] = $t_masanpham;

$t_gallery = trim( stripslashes($_POST['t_gallery']) );
if ( $t_gallery != '' ) $arr_meta_box['_eb_product_gallery'] = $t_gallery;

$t_dieukien = trim( stripslashes($_POST['t_dieukien']) );
if ( $t_dieukien != '' ) $arr_meta_box['_eb_product_noibat'] = $t_dieukien;

$t_size_list = trim( stripslashes($_POST['t_size_list']) );
if ( $t_size_list != '' ) $arr_meta_box['_eb_product_size'] = $t_size_list;

if ( $youtube_url != '' ) $arr_meta_box['_eb_product_video_url'] = $youtube_url;


//
$arr = array(
	'ID' => $trv_id,
	/*
	'post_parent' => 0,
	// không cập nhật lại tác giả
	'post_author' => mtv_id,
	// không cập nhật lại status -> bài viết khóa rồi thì thôi
	'post_status' => 'publish',
	*/
	'post_type' => $post_type,
	'post_title' => $trv_tieude,
	'post_name' => $trv_seo,
	
	'post_category' => array( $ant_id ),
	'meta_input' => $arr_meta_box,
);

if ( $post_excerpt != '' ) $arr['post_excerpt'] = $post_excerpt;
if ( $trv_noidung != '' ) $arr['post_content'] = $trv_noidung;
if ( $post_date != '' ) {
	$post_date = strtotime( $post_date );
	if ( $post_date > date_time ) {
		$post_date = date_time;
	}
	$post_date = date( 'Y-m-d H:i:s', $post_date );
	
	$arr['post_date'] = $post_date;
	$arr['post_date_gmt'] = $post_date;
	$arr['post_modified'] = $post_date;
	$arr['post_modified_gmt'] = $post_date;
}

// Tạo STT
if ( isset( $_POST['cap_nhat_stt_cho_bai_viet'] ) && $_POST['cap_nhat_stt_cho_bai_viet'] == 1 ) {
	// thêm số ngẫu nhiên trong khoảng 1 phút
	$arr['menu_order'] = date( 'ymdh', date_time ) + rand( 0, 3600 );
}

//print_r($arr);

// không tạo nhóm nếu không phải là post
if ( $post_type != 'post' ) {
//if ( $post_type == EB_BLOG_POST_TYPE ) {
	$arr['post_category'] = array();
	
	// tạo nhóm theo cách khác
	$update_id = wp_set_post_terms( $trv_id, array( $ant_id ), EB_BLOG_POST_LINK );
//	_eb_alert('aaaa');
	
	//
//	print_r($update_id); exit();
}

//
$post_id = wp_update_post( $arr, true );
//echo $post_id . '<br>';
if ( is_wp_error($post_id) ) {
//	print_r( $post_id ) . '<br>';
	
	$errors = $post_id->get_error_messages();
	foreach ($errors as $error) {
		echo $error . '<br>' . "\n";
	}
	
	//
	_eb_alert('Lỗi khi cập nhật sản phẩm');
}

//
/*
foreach ( $arr_meta_box as $k => $v ) {
	WGR_update_meta_post( $trv_id, $k, $v );
}
*/

//
//echo $trv_id . "\n";




//
$p_link = get_permalink( $trv_id );
//$p_link = web_link . '?p=' . $trv_id;

//
if ( $p_link == '' ) {
	_eb_alert( 'Permalink not found' );
}




die('<script type="text/javascript">
parent.ket_thuc_lay_du_lieu(' .$trv_id. ', "' .$m. '", "' . $p_link . '");
</script>');




