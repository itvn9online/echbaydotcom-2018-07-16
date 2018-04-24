<h3><a href="admin.php?page=eb-coder&tab=install_demo">Cài đặt dữ liệu demo</a> | <a href="admin.php?page=eb-coder&tab=install_demo&delete_demo=1">XÓA dữ liệu demo</a></h3>
<?php




// chỉ coder mới tạo dữ liệu demo kiểu này được
if ( mtv_id != 1 ) {
	exit();
}





// nếu đã có dữ liệu sẵn rồi -> không khởi tạo demo nữa
if ( ! isset($_GET['delete_demo']) ) {
	$tinh_so_luong_bai = wp_count_posts();
	// nếu có nhiều bài rồi thì bỏ qua
	if ( $tinh_so_luong_bai->publish > 10 ) {
		die('Dữ liệu demo đã có sẵn hoặc số bài viết đang nhiều hơn 10 bài');
		exit();
	}
}
//exit();






function __eb_instal_demo_data ( $title, $type = 'post', $data = array(), $post_meta = array() ) {
	global $wpdb;
//	global $func;
	
	//
	$uri = _eb_non_mark_seo( $title );
//	echo $uri; exit();
	
	// kiểm tra nếu chưa có mới cài đặt
	$post_id = $wpdb->get_var("SELECT ID
	FROM
		" . wp_posts . "
	WHERE
		post_name = '" . $uri . "'");
	
	//
	echo $post_id . '<br>';
	
	// nếu có tham số xóa -> xóa luôn
	if ( isset($_GET['delete_demo']) ) {
		if ( (int) $post_id > 0 ) {
			// trash
//			wp_trash_post( $post_id );
//			echo 'Trash post ' . $title . ' - OK<br>';
			
			// delete
			wp_delete_post( $post_id, true );
			echo 'DELETE ' . $title . ' - OK<br>';
		} else {
			echo 'post_id of "' . $uri . '" zero<br>';
		}
	}
	//
	else if ( (int) $post_id == 0 ) {
		$data['post_title'] = $title;
		$data['post_name'] = $uri;
		$data['post_type'] = $type;
		$data['post_parent'] = 0;
		$data['post_author'] = mtv_id;
		$data['post_status'] = 'publish';
		
		//
		$pageid = WGR_insert_post ($data);
		
		// post meta
		foreach ( $post_meta as $k => $v ) {
			WGR_update_meta_post( $pageid, $k, $v, true );
		}
		
		//
		WGR_update_meta_post( $pageid, eb_post_obj_data, $post_meta );
		
		//
//		echo _eb_get_post_object( $pageid, '_eb_product_avatar' );
		
		//
		echo 'Install ' . $title . ' - OK<br>';
	}
	// mặc định chỉ thông báo đã tồn tại
	else {
		echo 'Skip ' . $title . ' - Exist<br>';
	}
}




/*
* Demo cat
*/
$arr_product_cat = "";
//if ( ! isset($_GET['delete_demo']) ) {
	
	// category
	for ( $i = 1; $i < 10; $i++ ) {
		$k = 'Category ' . $i;
		
		$term = term_exists($k, 'category');
//		print_r( $term );
//		if ($term !== 0 && $term !== null) {
		if ( isset( $term['term_id'] ) && $term['term_id'] > 0 ) {
			if ( isset($_GET['delete_demo']) ) {
				wp_delete_category( $term['term_id'] );
				echo "DELETE category '" . $k . "'!<br>";
				
				//
				for ( $j = 1; $j < 11; $j++ ) {
					$k2 = 'Category ' . $i . '.' . $j;
					
					$term2 = term_exists($k2, 'category');
					if ( isset( $term2['term_id'] ) && $term2['term_id'] > 0 ) {
						wp_delete_category( $term2['term_id'] );
						echo "DELETE category '" . $k2 . "'!<br>";
					}
				}
			} else {
				echo "'" . $k . "' category exists!<br>";
			}
		} else if ( ! isset($_GET['delete_demo']) ) {
			$cat_parent = wp_create_category($k);
			echo 'Insert cat ' . $k . '<br>';
			$arr_product_cat .= "," . $cat_parent;
			
			// Sub category
			$ran = rand( 0, 10 );
			for ( $j = 1; $j < $ran; $j++ ) {
				$k2 = 'Category ' . $i . '.' . $j;
				
				$term2 = term_exists($k2, 'category');
//				print_r( $term2 );
//				if ($term2 !== 0 && $term2 !== null) {
				if ( isset( $term2['term_id'] ) && $term2['term_id'] > 0 ) {
					echo "'" . $k2 . "' category exists!<br>";
				} else {
					$cat_parent2 = wp_create_category($k2, $cat_parent);
					echo 'Insert cat ' . $k2 . '<br>';
					$arr_product_cat .= "," . $cat_parent2;
				}
			}
		}
	}
	
	// post_options
	$taxonomy = 'post_options';
	for ( $i = 1; $i < 10; $i++ ) {
		$k = 'Post options ' . $i;
		
		$term = term_exists($k, $taxonomy);
//		print_r( $term );
		if ( isset( $term['term_id'] ) && $term['term_id'] > 0 ) {
			if ( isset($_GET['delete_demo']) ) {
				wp_delete_term( $term['term_id'], $taxonomy );
				echo "DELETE options '" . $k . "'!<br>";
				
				//
				for ( $j = 1; $j < 11; $j++ ) {
					$k2 = 'Sub options ' . $j . ' of ' . $k;
					
					$term2 = term_exists($k2, 'post_options');
					if ( isset( $term2['term_id'] ) && $term2['term_id'] > 0 ) {
						wp_delete_term( $term2['term_id'], $taxonomy );
						echo "DELETE post options '" . $k2 . "'!<br>";
					}
				}
			} else {
				echo "'" . $k . "' options exists!<br>";
			}
		} else if ( ! isset($_GET['delete_demo']) ) {
			$term_parent = wp_insert_term($k, $taxonomy, array(
				'description' => 'Description of ' . $k,
			));
//			print_r($term_parent);
			echo 'Insert ' . $k . '<br>';
			
			// Sub category
			$ran = rand( 0, 10 );
			for ( $j = 1; $j < $ran; $j++ ) {
				$k2 = 'Sub options ' . $j . ' of ' . $k;
				
				$term2 = term_exists($k2, $taxonomy);
//				print_r( $term2 );
				if ( isset( $term2['term_id'] ) && $term2['term_id'] > 0 ) {
					echo "'" . $k2 . "' options exists!<br>";
				} else {
					wp_insert_term($k2, $taxonomy, array(
						'description' => 'Description of ' . $k2,
						'parent' => $term_parent['term_id'],
					));
					echo 'Insert ' . $k2 . '<br>';
				}
			}
		}
	}
//}

//
if ( $arr_product_cat != '' ) {
	$arr_product_cat = explode( ',', substr( $arr_product_cat, 1 ) );
}

//echo 'aaaaaa';




/*
* demo sản phẩm
*/
$arr = array(
	'https://thegioidoda.vn/upload/18660/2016-11-02/3.jpg',
	'http://thegioidoda.vn/upload/2016-11-01/111-thumb2.jpg',
	'http://thegioidoda.vn/upload/2015-11-10/2413185183_159682140467978.jpg',
	'http://thegioidoda.vn/upload/2016-09-27/ava_bag02_29-8-2016--2-.jpg',
	'http://thegioidoda.vn/upload/2016-09-22/ava_tuixach02_10-9-2016-02-.jpg',
	'http://thegioidoda.vn/upload/2016-08-16/2924020063_1370935767.jpg',
);
for ( $i = 1; $i < 50; $i++ ) {
	$k = 'Product demo ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	__eb_instal_demo_data ( $k, '', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => 'Excerpt of ' . $k,
	), array(
		'_eb_product_avatar' => $v,
		'_eb_product_oldprice' => rand( 50, 100 ) * 1000,
		'_eb_product_price' => rand( 1, 50 ) * 1000,
		'_eb_product_buyer' => rand( 1, 50 ),
		'_eb_product_quantity' => 1000,
		
		'_eb_product_status' => rand( 0, 2 ),
	) );
}



/*
* demo banner top
*/
$arr = array(
	'https://xwatchluxury.vn/upload/6/2016-07-12/xwlxr.png',
	'https://xwatchluxury.vn/upload/9/2016-11-03/banner-trangchu-1400x430.png',
	'https://xwatchluxury.vn/upload/9/2016-10-14/banner-tongket.png',
	'https://elsa.vn/upload/1111/2016-11-07/banner-web-elsa-1.jpg',
);
for ( $i = 1; $i < 5; $i++ ) {
	$k = 'Banner top ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'ads', array(
		'post_content' => 'Content of ' . $k,
	), array(
		'_eb_ads_url' => 'http://echbay.com/',
		'_eb_product_avatar' => $v,
		'_eb_ads_status' => 1,
	) );
	
}



/*
* demo banner review
*/
$arr = array(
	'https://cdn.pasgo.vn/images/KhachHang/Ho%C3%A0ng-Thu-Th%E1%BB%A7y.png',
	'https://cdn.pasgo.vn/images/KhachHang/Nguyen-Van-Minh.png',
	'https://cdn.pasgo.vn/images/KhachHang/NGUY%E1%BB%84N-T%C3%80I-TU%E1%BB%86.png',
	'https://cdn.pasgo.vn/images/KhachHang/Hoang-Van-%C4%90oan.png',
	'https://cdn.pasgo.vn/images/KhachHang/NGUY%E1%BB%84N-TH%E1%BB%8A-H%E1%BA%A0NH-LOAN.png',
	'https://cdn.pasgo.vn/images/KhachHang/V%C3%B5-Linh-Ph%C6%B0%C6%A1ng.png',
);
for ( $i = 1; $i < 10; $i++ ) {
	$k = 'Banner review ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'ads', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => 'Excerpt of ' . $k,
	), array(
		'_eb_ads_url' => 'http://echbay.com/',
		'_eb_product_avatar' => $v,
		'_eb_ads_video_url' => 'https://www.youtube.com/watch?v=ycGfvA1vkR8',
		'_eb_ads_status' => 4,
	) );
}



/*
* demo banner quảng cáo (chân trang)
*/
$arr = array(
	'https://xwatchluxury.vn/upload/6/2016-06-03/logo3.png',
	'https://xwatchluxury.vn/upload/6/2016-06-08/ts_2.png',
	'https://xwatchluxury.vn/upload/6/2016-06-03/logo1.png',
	'https://xwatchluxury.vn/upload/6/2016-06-08/ck_1.png',
);
for ( $i = 1; $i < 15; $i++ ) {
	$k = 'Banner chân trang ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'ads', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => 'Excerpt of ' . $k,
	), array(
		'_eb_ads_url' => 'http://echbay.com/',
		'_eb_product_avatar' => $v,
		'_eb_ads_status' => 5,
	) );
}



/*
* demo banner quảng cáo (chân trang)
*/
$arr = array(
	'https://xwatchluxury.vn/upload/9/2016-11-26/3d28eb87faaf918b70fb2f359b070a57.jpg',
	'https://xwatchluxury.vn/upload/9/2016-11-25/a6bff782fae0e869abb434a1dec355a6.jpg',
	'https://xwatchluxury.vn/upload/9/2016-11-23/img0092.jpg',
	'https://xwatchluxury.vn/upload/9/2016-11-23/6417954b38b5a816d4c7b860a8ee09ab.jpg',
	'https://xwatchluxury.vn/upload/9/2016-11-22/4a26b7de669267d1566b4bd0c9d30f27.jpg',
);
for ( $i = 0; $i < 5; $i++ ) {
	$k = 'Bộ sưu tập ' . ( $i + 1 );
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'ads', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => 'Excerpt of ' . $k,
	), array(
		'_eb_ads_url' => 'http://echbay.com/',
		'_eb_product_avatar' => $v,
		'_eb_ads_status' => 7,
	) );
}



/*
* demo banner Bản đồ vị trí
*/
$arr = array(
	'https://xwatchluxury.vn/upload/6/2016-06-22/untitled-2.png',
);
for ( $i = 1; $i < 10; $i++ ) {
	$k = 'Bản đồ vị trí ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'ads', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => '0984533228',
	), array(
		'_eb_ads_url' => 'http://echbay.com/',
		'_eb_product_avatar' => $v,
		'_eb_ads_status' => 8,
	) );
}



/*
* demo video HOT
*/
$arr = array(
	'https://xwatchluxury.vn/upload/9/2016-09-29/dong-ho-tissot-thuy-sy-chinh-hang-02.png',
	'https://xwatchluxury.vn/upload/9/2016-11-22/frederique-constant-slimline-002.jpg',
	'https://xwatchluxury.vn/upload/9/2016-07-29/top-5-dong-ho-ogival-14.jpg',
);
for ( $i = 1; $i < 5; $i++ ) {
	$k = 'Video HOT ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'ads', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => 'Excerpt of ' . $k,
	), array(
		'_eb_ads_url' => 'http://echbay.com/',
		'_eb_product_avatar' => $v,
		'_eb_ads_video_url' => 'https://www.youtube.com/watch?v=hoO0oXw2ue0',
		'_eb_ads_status' => 6,
	) );
}



/*
* demo blog
*/
$arr = array(
	'https://cdn.pasgo.vn/anh-blog-resize/400/top-20-nha-hang-buffet-ngon-noi-tieng-nhat-o-ha-noi-1051059-7.jpg',
	'https://cdn.pasgo.vn/anh-blog/cac-cach-tri-mun-boc-hieu-qua-tai-gia-nhanh-chong-1045360-1.jpg',
	'https://cdn.pasgo.vn/anh-blog-resize/400/top-20-nha-hang-lau-nuong-ngon-noi-tieng-nhat-o-ha-noi-1040701-1385.jpg',
	'https://cdn.pasgo.vn/anh-blog/di-san-mon-an-phuong-nam-noi-dat-bac-ky-su-1038795-2.jpg',
	'https://cdn.pasgo.vn/anh-blog/ngo-ngang-khong-gian-doc-3-trong-1-voi-cu-ky-garden-1038797-4.jpg',
	'https://cdn.pasgo.vn/anh-blog/cach-tri-ho-cho-be-tai-nha-an-toan-hieu-qua-1052332-5.jpg',
);
for ( $i = 1; $i < 20; $i++ ) {
	$k = 'Blog demo ' . $i;
	
	if ( isset( $arr[ $i ] ) ) {
		$v = $arr[ $i ];
	} else {
		$v = $arr[ rand( 0, count($arr) - 1 ) ];
	}
	
	//
	__eb_instal_demo_data ( $k, 'blog', array(
		'post_content' => 'Content of ' . $k,
		'post_excerpt' => 'Excerpt of ' . $k,
	), array(
		'_eb_product_avatar' => $v,
	) );
}




