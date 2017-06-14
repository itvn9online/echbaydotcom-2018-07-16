<?php
/*
* Mọi code dùng chung cho trang chi tiết sản phẩm/ bài viết
*/



//
//print_r($post);


//
$pid = $post->ID;

$url_og_url = _eb_p_link( $pid );

_eb_fix_url( $url_og_url );

$eb_wp_post_type = $post->post_type;



// lưu các post meta dưới dạng object
/*
$arr_object_post_meta = array(
	'aaaaaa' => 1,
);
update_post_meta($pid, eb_post_obj_data, $arr_boj_eb_postmeta);
*/
//$arr_object_post_meta = _eb_get_object_post_meta( $pid );
//print_r( $arr_object_post_meta );

// nếu không tồn tại mảng tiêu đề -> vẫn là kiểu dữ liệu cũ -> chuyển sang dữ liệu mới luôn và ngay
/*
if ( ! isset( $arr_object_post_meta['_eb_product_title'] ) ) {
	
	$key_post_object_poddata = '_eb_product_';
	
	$old_post_meta = _eb_q("SELECT *
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . $pid . "
		AND meta_key LIKE '{$key_post_object_poddata}%'
	ORDER BY
		meta_id DESC");
//	print_r($old_post_meta);
	
	//
	foreach ( $old_post_meta as $v ) {
		$arr_object_post_meta[ $v->meta_key ] = $v->meta_value;
	}
//	print_r($arr_object_post_meta);
	
	//
	if ( ! isset( $arr_object_post_meta['_eb_product_title'] ) ) {
		$arr_object_post_meta['_eb_product_title'] = $post->post_title;
	}
//	print_r($arr_object_post_meta);
	
	// cập nhật theo chức năng mới luôn
	update_post_meta( $pid, eb_post_obj_data, $arr_object_post_meta );
	
}
*/




// SEO
$__cf_row ['cf_title'] = _eb_get_post_meta( $pid, '_eb_product_title', true, $post->post_title );
//if ( $__cf_row ['cf_title'] == '' ) $__cf_row ['cf_title'] = $post->post_title;

$__cf_row ['cf_keywords'] = _eb_get_post_meta( $pid, '_eb_product_keywords', true, $post->post_title );
//if ( $__cf_row ['cf_keywords'] == '' ) $__cf_row ['cf_keywords'] = $post->post_title;

$__cf_row ['cf_description'] = _eb_get_post_meta( $pid, '_eb_product_description', true, $post->post_title );
//if ( $__cf_row ['cf_description'] == '' ) $__cf_row ['cf_description'] = $post->post_title;


// meta cho thẻ amp -> hiện chỉ hỗ trợ trang chi tiết dạng đơn giản
/*
if ( is_amp_endpoint() ) {
	$arr_dymanic_meta[] = '<link rel="amphtml" href="' . $url_og_url . '/amp" />';
}
*/




//
$trv_giaban = (int) _eb_get_post_meta( $pid, '_eb_product_oldprice', true, 0 );
$trv_giamoi = (int) _eb_get_post_meta( $pid, '_eb_product_price', true, 0 );








/*
* bổ sung 1 số kiểu dữ liệu mới (nếu chưa có)
*/

// chuyển kiểu dữ liệu sang array để kiểm tra cho dễ
/*
$arr_post_for_check_mysql = (array) $post;

// nếu chưa có cột giá mới -> add thêm cột giá mới
if ( ! isset( $arr_post_for_check_mysql['_eb_product_price'] ) ) {
	$eb_install_sql = "ALTER TABLE `" . $wpdb->posts . "`
	ADD
		`_eb_product_price` INT(11) NOT NULL
	AFTER
		`menu_order`";
//	echo $eb_install_sql . '<br>' . "\n";
	_eb_q($eb_install_sql);
}
// nếu có giá mới, mà cột giá mới chưa có update -> update cột giá
else if ( $arr_post_for_check_mysql['_eb_product_price'] != $trv_giamoi ) {
	_eb_q("UPDATE `" . $wpdb->posts . "`
	SET
		_eb_product_price = " . $trv_giamoi . "
	WHERE
		ID = " . $post->ID);
}
*/
/*
else {
	echo 'no update<br>';
}
*/









//
/*
$trv_img = wp_get_attachment_image_src ( get_post_thumbnail_id( $pid ), 'large' );
$trv_img = ! empty( $trv_img[0] ) ? esc_url( $trv_img[0] ) : _eb_get_post_meta( $pid, '_eb_product_avatar', true );
*/
$trv_img = _eb_get_post_img( $post->ID );
if ( $trv_img != '' ) {
	$image_og_image = $trv_img;
}


//
$arr_product_js = array (
	'tieude' => '\'' . _eb_str_block_fix_content ( $post->post_title ) . '\'',
	'gia' => $trv_giaban,
	'gm' => $trv_giamoi,
);
$product_js = '';
foreach ( $arr_product_js as $k => $v ) {
	$product_js .= ',' . $k . ':' . $v;
}





//
$id_for_get_sidebar = 'post_sidebar';


// blog
if ( $post->post_type == EB_BLOG_POST_TYPE ) {
	$post_categories = get_the_terms( $pid, EB_BLOG_POST_LINK );
	
	//
	$dynamic_meta .= '<link rel="amphtml" href="' . $url_og_url . '?amp" />';
	
	$id_for_get_sidebar = 'blog_sidebar';
}
// post, page
else {
	$post_categories = wp_get_post_categories( $pid );
}
//print_r( $post_categories );


//
$cats = array();

//
if ( isset( $post_categories[0] ) ) {
	foreach($post_categories as $c){
		$cat = get_term( $c );
	//	print_r( $cat );
	//	$cat = get_category( $c );
	//	print_r( $cat );
		
		//
		$cats[] = $cat;
		
		//
		$ant_link = _eb_c_link($cat->term_id);
//		echo $ant_link . '<br>';
		
		//
		$schema_BreadcrumbList .= _eb_create_breadcrumb( $ant_link, $cat->name );
		
		$group_go_to .= ' <li><a href="' . $ant_link . '">' . $cat->name . '</a></li>';
	}
}
//print_r( $cats );

//
$ant_ten = '';
$ant_id = 0;
if ( isset( $cats[0] ) ) {
	$ant_ten = $cats[0]->name;
	$ant_id = $cats[0]->term_id;
	
	// tìm nhóm cha (nếu có)
	_eb_create_html_breadcrumb( $cats[0] );
}




// Hết hoặc Còn hàng
$trv_mua = _eb_get_post_meta( $pid, '_eb_product_buyer', true, 0 );
$trv_max_mua = _eb_get_post_meta( $pid, '_eb_product_quantity', true, 0 );
$str_tinh_trang = '<span class="greencolor">Sẵn hàng</span>';

$con_hay_het = 1;

//
$trv_trangthai = _eb_get_post_meta( $pid, '_eb_product_status', true, 0 );
$schema_availability = 'http://schema.org/InStock';
if ( $trv_trangthai == 7 || $trv_mua > $trv_max_mua ) {
	$schema_availability = 'http://schema.org/SoldOut';
	
	$str_tinh_trang = '<span class="redcolor">Hết hàng</span>';
	
	$con_hay_het = 0;
	
	// thêm class ẩn nút mua hàng
	$css_m_css .= ' details-hideif-hethang';
}



//
$arr_product_color = '';



//
$post_modified = strtotime( $post->post_modified );
$schema_priceValidUntil = $post_modified + 24 * 3600 * 365;





//
$trv_rating_value = _eb_get_post_meta( $pid, '_eb_product_rating_value', true, 0 );
if ( $trv_rating_value == '' ) {
	$trv_rating_value = 0;
}
//echo $trv_rating_value . "\n";

$trv_rating_count = _eb_get_post_meta( $pid, '_eb_product_rating_count', true, 0 );
if ( $trv_rating_count == '' ) {
	$trv_rating_count = 0;
}
//echo $trv_rating_count . "\n";

// Tạo rate ngẫu nhiên
if ($trv_rating_value < 6 || $trv_rating_count == 0) {
	$trv_rating_value = rand ( 6, 10 );
	$trv_rating_count = rand ( 1, 5 );
	
	// dùng update_post_meta thay cho add_post_meta
	update_post_meta( $pid, '_eb_product_rating_value', $trv_rating_value );
	update_post_meta( $pid, '_eb_product_rating_count', $trv_rating_count );
}

$rating_value_img = $trv_rating_value / 2;
if (strlen ( $rating_value_img ) == 1) {
	$rating_value_img = $rating_value_img . '.0';
}
	
	
	
	
// dữ liệu có cấu trúc
$structured_data_detail = '';
$structured_data_post_title = str_replace( '"', '&quot;', $post->post_title );

if ( $trv_giamoi > 0 ) {
	
	$structured_data_detail = '
<script type="application/ld+json">
{
	"@context": "http:\/\/schema.org\/",
	"@type": "Product",
	"name": "' . $structured_data_post_title . '",
	"image": "' . str_replace( '/', '\/', $trv_img ) . '",
	"description": "' . str_replace( '"', '&quot;', $__cf_row ['cf_description'] ) . '",
//	"mpn": "' .$pid. '"
	"url": "' . str_replace( '/', '\/', $url_og_url ) . '",
	
	//
	/*
	"aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "' .$rating_value_img. '",
		"reviewCount": "' .$trv_rating_count. '"
	},
	*/
	"offers": {
		"@type": "Offer",
		"priceCurrency": "VND",
		"price": "' .$trv_giamoi. '",
		"priceValidUntil": "' .date( 'Y-m-d', $schema_priceValidUntil ). '",
		/*
		"seller": {
			"@type": "Organization",
			"name": "Executive Objects"
		},
		*/
//		"itemCondition": "http:\/\/schema.org\/UsedCondition",
		"availability": "' .$schema_availability. '"
	},
	
	"brand": {
		"@type": "Thing",
		"name": "' . str_replace( '"', '&quot;', $ant_ten ) . '"
	},
	
	//
	"productID": "' .$pid. '"
}
</script>';
	
}
else {
	
	//
	$blog_img_logo = $__cf_row['cf_logo'];
	if ( strstr( $blog_img_logo, '//' ) == false ) {
		if ( substr( $blog_img_logo, 0, 1 ) == '/' ) {
			$blog_img_logo = substr( $blog_img_logo, 1 );
		}
		
		//
		$blog_img_logo = web_link . $blog_img_logo;
	}
	
	//
	$structured_data_detail = '
<script type="application/ld+json">
{
	"@context": "http:\/\/schema.org",
	"@type": "BlogPosting",
	"publisher": {
		"@type": "Organization",
		"name": "' . str_replace( '"', '&quot;', web_name ) . '",
		"logo": {
			"@type": "ImageObject",
			"url": "' . str_replace( '/', '\/', $blog_img_logo ) . '"
		}
	},
	"mainEntityOfPage": "' . str_replace( '/', '\/', $url_og_url ) . '",
	"headline": "' . $structured_data_post_title . '",
	"datePublished": "' . $post->post_date . '",
	"dateModified": "' . $post->post_modified . '",
	"author": {
		"@type": "Person",
		"name": "itvn9online"
	},
	"description": "' . str_replace( '"', '&quot;', $__cf_row ['cf_description'] ) . '",
	"image": {
		"@type": "ImageObject",
		"width": "400",
		"height": "400",
		"url": "' . str_replace( '/', '\/', $trv_img ) . '"
	}
}
</script>';
	
}

//
if ( $structured_data_detail != '' ) {
	$structured_data_detail = preg_replace( "/\t/", "", trim( $structured_data_detail ) );
	
	$dynamic_meta .= $structured_data_detail;
}






//
$group_go_to .= ' <li>' . $post->post_title . '</li>';
//echo $group_go_to;

//
$schema_BreadcrumbList .= _eb_create_breadcrumb( $url_og_url, $post->post_title );







// tự làm amp cho khách hàng
if ( $post->post_type == EB_BLOG_POST_TYPE && isset($_GET['amp']) ) {
	include EB_THEME_PLUGIN_INDEX . 'amp.php';
}







/*
* cho những thứ không cần real vào cache
*/
/*
$strCacheFilter = 'details/' . $pid;
$main_content = _eb_get_static_html ( $strCacheFilter );
if ($main_content == false) {
	*/
	
	
	
	
//
//$thu_muc_for_html = EB_THEME_HTML;



//
$pt = 0;
if ($trv_giaban > $trv_giamoi) {
	$pt = 100 - ( int ) ($trv_giamoi * 100 / $trv_giaban);
}




// Mặc định là cho vào sản phẩm
$html_v2_file = 'thread_details';
$html_file = 'thread_details.html';

$arr_list_tag = array();
$blog_list_medium = '';
$product_list_medium = '';
$other_post_right = '';

// với blog -> sử dụng giao diện khác post
if ( $post->post_type == EB_BLOG_POST_TYPE ) {
	
	// tag of blog
	$arr_list_tag = wp_get_object_terms( $pid, 'blog_tag' );
	
	
	// bài xem nhiều
	$args = array(
		'post_type' => EB_BLOG_POST_TYPE,
		'offset' => 0,
		'tax_query' => array(
			array(
				'taxonomy' => EB_BLOG_POST_LINK,
				'terms' => $ant_id,
			)
		),
	);
	
	
	//
	$html_v2_file = 'blog_details';
	$html_file = $html_v2_file . '.html';
	
	// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
	if ( ! file_exists( EB_THEME_HTML . $html_file ) ) {
		if ( $__cf_row['cf_blog_column_style'] != '' ) {
			$html_v2_file = $html_v2_file . '_' . $__cf_row['cf_blog_column_style'];
		}
	}
//	echo $__cf_row['cf_blog_column_style'] . '<br>' . "\n";
//	echo $html_v2_file . '<br>' . "\n";
	
	
	// kiểm tra nếu có file html riêng -> sử dụng html riêng
//	$check_html_rieng = _eb_get_private_html( $html_file, 'blog_node.html' );
	
//	$thu_muc_for_html = $check_html_rieng['dir'];
//	$blog_html_small_node = $check_html_rieng['html'];
	
	//
	$blog_list_medium = _eb_load_post( 10, $args, _eb_get_html_for_module( 'blog_node.html' ) );
}
else if ( $post->post_type == 'page' ) {
	$html_v2_file = 'page';
	$html_file = $html_v2_file . '.html';
	
	// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
	if ( ! file_exists( EB_THEME_HTML . $html_file ) ) {
		if ( $__cf_row['cf_page_column_style'] != '' ) {
			$html_v2_file = $html_v2_file . '_' . $__cf_row['cf_page_column_style'];
		}
	}
//	echo $__cf_row['cf_page_column_style'] . '<br>' . "\n";
//	echo $html_v2_file . '<br>' . "\n";
	
	// kiểm tra nếu có file html riêng -> sử dụng html riêng
//	$check_html_rieng = _eb_get_private_html( $html_file, 'blog_node.html' );
//	$thu_muc_for_html = $check_html_rieng['dir'];
}
else {
	
	//
//	$check_html_rieng = _eb_get_private_html( 'blog_details.html', 'blog_node.html' );
	
//	$product_list_medium = _eb_load_post( 10, array(), $check_html_rieng['html'] );
	
	
	
	// lấy màu sắc sản phẩm
	$sql = _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		meta_key = '_eb_category_status'
		AND meta_value = 7");
//	print_r($sql);
	
	//
	$arr_post_options = wp_get_object_terms( $pid, 'post_options' );
//	print_r($arr_post_options);
	
	foreach ( $sql as $v ) {
//		print_r($v);
		
		foreach ( $arr_post_options as $v2 ) {
//			print_r($v2);
			
			//
			if ( $v->post_id == $v2->parent ) {
				$arr_product_color .= ',{ten:"' . $v2->name . '",val:"' . _eb_get_post_meta( $v2->term_id, '_eb_category_title', true, '#fff' ) . '"}';
			}
		}
	}
	
	
	
	
	// tag of post
	$arr_list_tag = get_the_tags( $pid );
	
	
	//
	$limit_other_post = $__cf_row['cf_num_details_list'];
	
	/*
	* other post
	*/
	if ( $limit_other_post > 0 ) {
		
		//
		$prev_post = get_previous_post();
	//	print_r($prev_post);
		if ( isset($prev_post->ID) ) {
			$limit_other_post--;
			
			$other_post_right .= _eb_load_post( 1, array(
				'post__in' => array(
					$prev_post->ID
				),
			) );
		}
		
		//
		$next_post = get_next_post();
	//	print_r($next_post);
		if ( isset($next_post->ID) ) {
			$limit_other_post--;
			
			$other_post_right .= _eb_load_post( 1, array(
				'post__in' => array(
					$next_post->ID
				),
			) );
		}
		
		// nếu không có giới hạn bài viết cho phần other post -> lấy mặc định 10 bài
//		if ( ! isset($limit_other_post) ) {
//			$limit_other_post = $__cf_row['cf_num_details_list'];
//		}
		
		//
		$other_post_right .= _eb_load_post( $limit_other_post, array(
			'category__in' => wp_get_post_categories( $post->ID ),
			/*
			'post__not_in' => array(
				$post->ID
			),
			*/
		) );
		
	}
	
	
	
	
	// xem định dạng bài viết có được hỗ trợ theo theme không
	$post_format = get_post_format( $pid );
//	echo $post_format . '<br>' . "\n";
	if ( $post_format != '' ) {
		$check_new_format = 'thread_details-' . $post_format . '.html';
//		echo $check_new_format . '<br>' . "\n";
		
		//
		if ( file_exists( EB_THEME_HTML . $check_new_format ) ) {
			$html_file = $check_new_format;
//			echo $html_file . '<br>' . "\n";
			$html_v2_file = 'thread_details-' . $post_format;
//			echo $html_v2_file . '<br>' . "\n";
			
//			$thu_muc_for_html = EB_THEME_HTML;
		}
	}
	
	
	
}

//
$str_tags = '';
//print_r( $arr_list_tag );
if ( !empty ( $arr_list_tag ) ) {
	foreach ( $arr_list_tag as $v ) {
		$str_tags .= ', <a href="' . get_tag_link( $v->term_id ) . '">' . $v->name . '</a>';
	}
}



// the_content -> chỉ chạy khi gọi the_post -> dùng hàm the_content để tạo nội dung theo chuẩn wp
the_post();

// dùng ob để lấy nội dung đã được echo thay vì echo trực tiếp
ob_start();

the_content();
$trv_noidung = ob_get_contents();

//ob_clean();
//ob_end_flush();
ob_end_clean();

//echo $trv_noidung;





// tạo mảng để khởi tạo nội dung
$arr_main_content = array(
	'tmp.trv_id' => $pid,
	'tmp.trv_masanpham' => _eb_get_post_meta( $pid, '_eb_product_sku', true, $pid ),
	'tmp.link_for_fb_comment' => $web_link . '?p=' . $pid,
	
	'tmp.trv_tieude' => str_replace( '<', '&lt;', str_replace( '>', '&gt;', $post->post_title ) ),
	'tmp.trv_goithieu' => $post->post_excerpt,
	'tmp.trv_noidung' => $trv_noidung,
	'tmp.trv_img' => $trv_img,
	
	'tmp.ant_link' => _eb_c_link($ant_id),
	'tmp.ant_ten' => $ant_ten,
	
	'tmp.trv_galerry' => str_replace( '<img ', '<eb-img ', _eb_get_post_meta( $pid, '_eb_product_gallery', true ) ),
	'tmp.trv_dieukien' => _eb_get_post_meta( $pid, '_eb_product_dieukien', true ),
	'tmp.trv_tomtat' => _eb_get_post_meta( $pid, '_eb_product_noibat', true ),
	
	'tmp.trv_mua' => $trv_mua,
	'tmp.trv_max_mua' => $trv_max_mua,
	'tmp.str_tinh_trang' => $str_tinh_trang,
	
	'tmp.blog_list_medium' => $blog_list_medium,
	'tmp.product_list_medium' => $product_list_medium,
	'tmp.other_post_right' => $other_post_right,
	'tmp.other_option_list' => '',
	
	'tmp.rating_value_img' => $rating_value_img,
	'tmp.str_tags' => substr( $str_tags, 1 ),
	
	'tmp.bl_ngaygui' => date( 'd/m/Y H:i T', $post_modified ),
	
	'tmp.pt' => $pt,
	'tmp.trv_giaban' => number_format( $trv_giaban ),
	'tmp.trv_giamoi' => number_format( $trv_giamoi ),
	'tmp.trv_tietkiem' => number_format( $trv_giaban - $trv_giamoi ),
	
	'tmp.trv_num_giamoi' => $trv_giamoi,
	
	'tmp.cf_product_details_size' => $__cf_row['cf_product_details_size'],
	
	'tmp.p_link' => $url_og_url,
	
	// chèn class tính chiều rộng cho khung
//	'tmp.custom_blog_css' => $__cf_row['cf_blog_class_style'],
	'tmp.custom_page_css' => $__cf_row['cf_page_class_style'],
	
	// tìm và tạo sidebar luôn
//	'tmp.str_sidebar' => _eb_echbay_sidebar( $id_for_get_sidebar ),
);


// gọi đến function riêng của từng site
if ( function_exists('eb_details_for_current_domain') ) {
	$arr_main_new_content = eb_details_for_current_domain();
	
	// -> chạy vòng lặp, ghi đè lên mảng cũ
	foreach ( $arr_main_new_content as $k => $v ) {
		$arr_main_content[$k] = $v;
	}
}


// tạo nội dung - v1
//$main_content = EBE_str_template( $html_file, $arr_main_content, $thu_muc_for_html );

// v2
$main_content = EBE_html_template( EBE_get_page_template( $html_v2_file ), $arr_main_content );




// product size
$product_size = _eb_get_post_meta( $pid, '_eb_product_size', true );
if ( $product_size != '' ) {
	if ( substr( $product_size, 0, 1 ) == ',' ) {
		$product_size = substr( $product_size, 1 );
	}
	$product_size = str_replace( '"', '\"', $product_size );
}




// If comments are open or we have at least one comment, load up the comment template.
// load comment bằng ajax -> vì theme mình viết toàn có cache
$eb_site_comment_open = 0;
if ( comments_open() || get_comments_number() ) {
//	comments_template();
	
	$eb_site_comment_open = 1;
}




// -> thêm đoạn JS dùng để xác định xem khách đang ở đâu trên web
$main_content .= '<script type="text/javascript">
var switch_taxonomy="' . $post->post_type . '",
	pid=' . $pid . ',
	eb_site_comment_open=' . $eb_site_comment_open . ',
	con_hay_het=' . $con_hay_het . ',
	product_js={' . substr ( $product_js, 1 ) . '},
	arr_product_size="' . $product_size . '",
	arr_product_color=[' . substr( $arr_product_color, 1 ) . '],
	_eb_product_video_url="' . _eb_get_post_meta( $pid, '_eb_product_video_url', true ) . '";
</script>';






//
/*
_eb_get_static_html ( $strCacheFilter, $main_content );

} // end cache
*/





// một số file gắn riêng cho post
/*
if ( $post->post_type == 'post' ) {
	// gọi file js dùng chung trước
	$arr_for_add_js[] = 'javascript/details_wp.js';
	
	// sau đó gọi file js riêng của từng domain
	$arr_for_add_js[] = 'details.js';
}
*/





// thêm link sửa bài cho admin
$admin_edit = get_edit_post_link( $post->ID );
if ( $admin_edit != '' ) {
	$admin_edit = '<a title="Edit" href="' . $admin_edit . '"><i class="fa fa-edit"></i></a>';
}

/*
$admin_edit = '';
if ( current_user_can('editor') || current_user_can('administrator') ) {
	$admin_edit = '<a title="Edit" href="' . WP_ADMIN_DIR . '/post.php?post=' . $pid . '&action=edit" class="fa fa-edit"></a>';
}
*/
$main_content = str_replace ( '{tmp.admin_edit}', $admin_edit, $main_content );




// thêm thanh công cụ mua trên mobile
$main_content .= EBE_html_template( EBE_get_page_template( 'details_mobilemua' ) );



//
//print_r( $_COOKIE );




// loại bỏ chức năng bỏ qua sản phẩm đã lấy, để custom code còn hoạt động được
$___eb_post__not_in = '';





