<?php



/*
* Các tham số mặc định, khai báo trước khi cche được gọi
*/


//print_r( $___eb_lang );




$__eb_cache_time = 0;

$__eb_cache_conf = EB_THEME_CACHE . '___all.php';
//echo $__eb_cache_conf . '<br>';

//$file_last_update = str_replace ( '.php', '.txt', $__eb_cache_conf );
$file_last_update = EB_THEME_CACHE . '___all.txt';
//echo $file_last_update . '<br>';


//
/*
if (file_exists ( $__eb_cache_conf )) {
	include_once $__eb_cache_conf;
}
*/
// chấp nhận lần đầu truy cập sẽ lỗi
@include $__eb_cache_conf;

// lấy config theo thời gian thực nếu tài khoản đang đăng nhập
if ( mtv_id > 0 ) {
	// không reset mảng này -> do 1 số config sẽ được tạo theo config của wp
//	$__cf_row = $__cf_row_default;
	
	// nạp lại config riêng
	_eb_get_config( true );
	EBE_get_lang_list();
}




// kiểm tra thời gian tạo cache
$__eb_cache_time = $date_time - $__eb_cache_time + rand ( 0, 20 );
//$__eb_cache_time += rand ( 0, 60 );

//$time_for_update_cache = $cf_reset_cache;
$time_for_update_cache = $__cf_row['cf_reset_cache'];
//echo $time_for_update_cache . '<br>';


//
if ($__eb_cache_time > $time_for_update_cache) {
	// nếu thời gian update cache nhỏ quá -> bỏ qua
	if ( file_exists ( $file_last_update ) ) {
		$last_update = filemtime ( $file_last_update );
//		$last_update = file_get_contents ( $file_last_update );
		
		//
		if ( $date_time - $last_update < $time_for_update_cache / 2 ) {
			$__eb_cache_time = 0;
			include_once $__eb_cache_conf;
		}
	}
	
	
	//
	if ( $__eb_cache_time > $time_for_update_cache ) {
		
		
		
		
		// Kiểm tra và tạo thư mục cache nếu chưa có
		if( ! is_dir( EB_THEME_CACHE ) ) {
//			echo EB_THEME_CACHE . '<br>' . "\n";
			
			// tự động tạo thư mục uploads nếu chưa có
			$dir_wp_uploads = dirname(EB_THEME_CACHE);
//			echo $dir_wp_uploads . '<br>' . "\n";
			if( !is_dir( $dir_wp_uploads ) ) {
				mkdir( $dir_wp_uploads, 0777 ) or die("ERROR create uploads directory: " . $dir_wp_uploads);
				// server window ko cần chmod
				chmod( $dir_wp_uploads, 0777 ) or die('chmod ERROR');
			}
			
			mkdir( EB_THEME_CACHE, 0777 ) or die("ERROR create cache directory");
			// server window ko cần chmod
			chmod( EB_THEME_CACHE, 0777 ) or die('chmod ERROR');
		}
		
		
		
		
		
		// dọn cache định kỳ -> chỉ dọn khi không phải tháo tác thủ công
		if ( mtv_id > 0
//		&& strstr( $_SERVER['REQUEST_URI'], '/' . WP_ADMIN_DIR . '/' ) == true
		&& is_admin ()
		&& ! isset( $_GET['tab'] ) ) {
			$_GET['time_auto_cleanup_cache'] = 6 * 3600;
			
			include_once ECHBAY_PRI_CODE . 'cleanup_cache.php';
		}
		
		
		
		// không cho tạo cache liên tục
		_eb_create_file ( $file_last_update, $date_time );
		
		
		
		
		/*
		* Tự tạo các thư mục phục vụ cho cache nếu chưa có
		*/
		
		// các thư mục con của cache
		$arr_create_dir_cache = array(
			'all',
			'admin_invoice_product',
			'tv_mail',
			'post_meta',
			'post_img',
			'details'
		);
		foreach ( $arr_create_dir_cache as $v ) {
			$v = EB_THEME_CACHE . $v;
//			echo $v . '<br>';
			
			//
			if ( ! is_dir( $v ) ) {
				mkdir($v, 0777) or die('mkdir error');
				// server window ko cần chmod
				chmod($v, 0777) or die('chmod ERROR');
			}
		}
		
		
		
		
		function convert_arr_cache_to_parameter($arr) {
			$str = '';
			foreach ( $arr as $k => $v ) {
				$_get_type = gettype ( $v );
				if ($_get_type == 'array') {
					$_content = '';
					foreach ( $v as $k2 => $v2 ) {
						$_content .= ',"' . $k2 . '"=>"' . str_replace( '"', '\"', $v2 ) . '"';
					}
					$str .= '$' . $k . '=array(' . substr ( $_content, 1 ) . ');';
				} else if ($_get_type == 'integer' || $_get_type == 'double') {
					$str .= '$' . $k . '=' . $v . ';';
				} else {
					$v = str_replace ( '$', '\$', $v );
					$v = str_replace ( '"', '\"', $v );
					$str .= '$' . $k . '="' . $v . '";';
				}
				$str .= "\n";
			}
			
			return $str;
		}
		
		
		
		
		
		// tham số để lưu cache
		$__eb_cache_content = '$__eb_cache_time=' . $date_time . ';';
		
		
		
		
		/*
		* Một số thông số khác
		*/
		
		
		
		
		
		/*
		* lấy các dữ liệu được tạo riêng cho config -> $post_id = -1;
		*/
		// reset lại cache
		$__cf_row = $__cf_row_default;
		
		//
		_eb_get_config();
		
		
		//
		if ( $__cf_row['cf_web_name'] == '' ) {
//			$web_name = get_bloginfo ( 'name' );
			$web_name = get_bloginfo ( 'blogname' );
//			$web_name = get_bloginfo ( 'sitename' );
		} else {
			$web_name = $__cf_row['cf_web_name'];
		}
		
		//
//		$__eb_cache_content .= '$web_name="' . str_replace( '"', '\"', $web_name ) . '";$web_link="' . str_replace( '"', '\"', $web_link ) . '";';
		$__eb_cache_content .= '$web_name="' . str_replace( '"', '\"', $web_name ) . '";';
			
		
		// chỉnh lại số điện thoại sang dạng html -> do safari lỗi hiển thị
		if ( $__cf_row['cf_call_dienthoai'] == '' && $__cf_row['cf_dienthoai'] != '' ) {
			$__cf_row['cf_call_dienthoai'] = '<a href="tel:' . $__cf_row['cf_dienthoai'] . '" rel="nofollow">' . $__cf_row['cf_dienthoai'] . '</a>';
		}
		
		if ( $__cf_row['cf_call_hotline'] == '' && $__cf_row['cf_hotline'] != '' ) {
			$__cf_row['cf_call_hotline'] = '<a href="tel:' . $__cf_row['cf_hotline'] . '" rel="nofollow">' . $__cf_row['cf_hotline'] . '</a>';
		}
		
		
		//
		$__cf_row['cf_reset_cache'] = (int)$__cf_row['cf_reset_cache'];
		
		// nếu thời gian update config lâu rồi, cache chưa set -> để cache mặc định
		// lần cập nhật config cuối là hơn 3 tiếng trước -> để mặc định
		if ( $localhost != 1
		&& $__cf_row ["cf_reset_cache"] <= 0 ) {
			// cho cache 120s mặc định
			if ( $__cf_row['cf_ngay'] < $date_time - 3 * 3600 ) {
				$__cf_row ["cf_reset_cache"] = 120;
			}
			// hoặc tối thiểu 10s để còn test cache
			else {
				$__cf_row ["cf_reset_cache"] = 10;
			}
		}
//		print_r( $__cf_row );
		
		//
		/*
		$sql = _eb_q("SELECT option_value
		FROM
			" . $wpdb->options . "
		WHERE
			option_name = 'blog_public'
		ORDER BY
			option_id DESC
		LIMIT 0, 1");
//		print_r($sql);
//		$cf_blog_public = 1;
		if ( isset( $sql[0]->option_value ) ) {
//			$cf_blog_public = $sql[0]->option_value;
			$__cf_row ["cf_blog_public"] = $sql[0]->option_value;
		}
		*/
		$__cf_row ["cf_blog_public"] = get_option( 'blog_public' );
		
		// định dạng ngày giờ
		$__cf_row ["cf_date_format"] = get_option( 'date_format' );
		$__cf_row ["cf_time_format"] = get_option( 'time_format' );
		
		// tên thư mục chứa theme theo tiêu chuẩn của echbay
		$__cf_row ["cf_theme_dir"] = basename( dirname( dirname( EB_THEME_HTML ) ) );
		
		// -> tạo chuỗi để lưu cache
		foreach ( $__cf_row as $k => $v ) {
			$__eb_cache_content .= '$__cf_row[\'' . $k . '\']="' . str_replace ( '"', '\"', str_replace ( '$', '\$', $v ) ) . '";';
		}
		
		
		
		// tạo file timezone nếu chưa có
		// chỉ với các website có ngôn ngữ không phải tiếng Việt
		if ( $__cf_row['cf_content_language'] != 'vi'
		// timezone phải tồn tại
		&& $__cf_row['cf_timezone'] != ''
		// file chưa được tạo
		&& ! file_exists ( EB_THEME_CACHE . '___timezone.txt' ) ) {
			_eb_create_file( EB_THEME_CACHE . '___timezone.txt', $__cf_row['cf_timezone'] );
		}
		
		
		
		
		/*
		* Danh sách bản dịch
		*/
		EBE_get_lang_list();
//		print_r( $___eb_lang );
		
		// -> tạo chuỗi để lưu cache
		foreach ( $___eb_lang as $k => $v ) {
			$__eb_cache_content .= '$___eb_lang[\'' . $k . '\']="' . str_replace ( '"', '\"', str_replace ( '$', '\$', $v ) ) . '";';
		}
		
		
		
		
		
		/*
		* Tối ưu thẻ META với mạng xã hội
		*/
		$arr_meta = array();
		
		// social
		if ( $__cf_row ['cf_google_plus'] != '' ) {
			$arr_meta[] = '<meta itemprop="author" content="' .$__cf_row ['cf_google_plus']. '?rel=author" />';
			$arr_meta[] = '<link rel="author" href="' .$__cf_row ['cf_google_plus']. '" />';
			$arr_meta[] = '<link rel="publisher" href="' .$__cf_row ['cf_google_plus']. '" />';
		}
		
		if ( $__cf_row ['cf_facebook_id'] != '' ) {
			$arr_meta[] = '<meta property="fb:app_id" content="' .$__cf_row ['cf_facebook_id']. '" />';
		}
		
		if ( $__cf_row ['cf_facebook_admin_id'] != '' ) {
			$arr_meta[] = '<meta property="fb:admins" content="' .$__cf_row ['cf_facebook_admin_id']. '" />';
		}
		
		if ( $__cf_row ['cf_facebook_page'] != '' ) {
			$arr_meta[] = '<meta property="article:publisher" content="' .$__cf_row ['cf_facebook_page']. '" />';
			$arr_meta[] = '<meta property="article:author" content="' .$__cf_row ['cf_facebook_page']. '" />';
		}
		
		// seo local
		if ( $__cf_row ['cf_region'] != '' ) {
			$arr_meta[] = '<meta name="geo.region" content="' .$__cf_row ['cf_region']. '" />';
		}
		
		if ( $__cf_row ['cf_placename'] != '' ) {
			$arr_meta[] = '<meta name="geo.placename" content="' .$__cf_row ['cf_placename']. '" />';
		}
		
		if ( $__cf_row ['cf_position'] != '' ) {
			$arr_meta[] = '<meta name="geo.position" content="' .$__cf_row ['cf_position']. '" />';
			$arr_meta[] = '<meta name="ICBM" content="' .$__cf_row ['cf_position']. '" />';
		}
		
		//
//		print_r( $arr_meta );
		$dynamic_meta = '';
		/*
		foreach ( $arr_meta as $v ) {
			$dynamic_meta .= $v . "\n";
		}
		*/
		$dynamic_meta .= implode( "\n", $arr_meta );
		
		// save
		$__eb_cache_content .= '$dynamic_meta="' . str_replace( '"', '\"', $dynamic_meta ) . '";';
		
		
		
		
		/*
		* ID và tài khoản MXH
		*/
		$add_data_id = array (
//			'web_name' => '\'' . $__cf_row ['web_name'] . '\'',
//			'service_name' => '\'' . $service_name . '\'',
			
			'eb_disable_auto_get_thumb' => (int) $__cf_row ['cf_disable_auto_get_thumb'],
			
			'cf_facebook_page' => '\'' . $__cf_row ['cf_facebook_page'] . '\'',
			'__global_facebook_id' => '\'' . $__cf_row ['cf_facebook_id'] . '\'',
			'cf_google_plus' => '\'' . $__cf_row ['cf_google_plus'] . '\'',
			'cf_youtube_chanel' => '\'' . $__cf_row ['cf_youtube_chanel'] . '\'',
			'cf_twitter_page' => '\'' . $__cf_row ['cf_twitter_page'] . '\'' 
		);
		$cache_data_id = '';
		foreach ( $add_data_id as $k => $v ) {
			$cache_data_id .= ',' . $k . '=' . $v;
		}
		$cache_data_id = substr ( $cache_data_id, 1 );
		$__eb_cache_content .= '$cache_data_id="' . $cache_data_id . '";';
		
		
		
		
		
		// danh sách menu đã được đăng ký
		$menu_locations = get_nav_menu_locations();
//		print_r($menu_locations);
		foreach ( $menu_locations as $k => $v ) {
			$__eb_cache_content .= '$menu_cache_locations[\'' . $k . '\']="' . $v . '";';
		}
		
		
		
		
		
		/*
		* lưu cache
		*/
		_eb_create_file ( $__eb_cache_conf, '<?php ' . str_replace( '\\\"', '\"', $__eb_cache_content ) );
		
		
		
		//
		_eb_log_user ( 'Update common_cache: ' . $_SERVER ['REQUEST_URI'] );
		
		
		
		
		
		
		/*
		* Tạo cat dưới dạng JS
		*/
		$strCacheFilter = 'cat_js';
		$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter );
		if ($check_Cleanup_cache == false) {
	//		$site_group = get_full_category_v2 ();
	//		echo $site_group;
			
			//
	//		echo EB_THEME_CACHE;EB_BLOG_POST_LINK
			$cat_js_file_name = 'cat.js';
//			$cat_js_file_name = 'cat-' . date( 'H.i', $date_time ) . '.js';
			
			_eb_create_file ( EB_THEME_CACHE . $cat_js_file_name, 'var eb_site_group=[' . _eb_get_full_category_v2 () . '],eb_blog_group=[' . _eb_get_full_category_v2 ( 0, EB_BLOG_POST_LINK ) . '];' );
			
			//
			/*
			$args = array(
				'taxonomy' => EB_BLOG_POST_LINK,
			);
			$categories = get_categories($args);
			print_r( $categories );
			*/
			
			// ép lưu cache
			_eb_get_static_html ( $strCacheFilter, date( 'r', $date_time ), '', 60 );
		}
		
		
		
		
		
		
		/*
		* tạo các page tự động nếu chưa có
		*/
		/*
		$strCacheFilter = 'auto_create_page';
		$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 3600 );
		if ($check_Cleanup_cache == false) {
//			_eb_create_page( 'cart', 'Giỏ hàng' );
			
//			_eb_create_page( 'contact', 'Liên hệ' );
			
//			_eb_create_page( 'landing-page', 'Landing page', 'templates/full-width.php' );
			
//			_eb_create_page( 'process', 'Process...' );
			
//			_eb_create_page( 'hoan-tat', 'Đặt hàng thành công' );
			
//			_eb_create_page( 'profile', 'Trang cá nhân' );
			
//			_eb_create_page( 'sitemap', 'Sitemap' );
			
			// ép lưu cache
			_eb_get_static_html ( $strCacheFilter, date( 'r', $date_time ), '', 60 );
		}
		*/
		
		
		
		
		
		
		/*
		* Tự động dọn dẹp log sau một khoảng thời gian
		*/
		$strCacheFilter = 'auto_clean_up_log';
		$check_Cleanup_cache = _eb_get_static_html ( $strCacheFilter, '', '', 24 * 3600 );
		if ($check_Cleanup_cache == false) {
			/*
			* user log
			*/
			$a = _eb_get_log_user( " LIMIT 2000, 1 " );
//			print_r($a);
//			echo count($a);
			
			//
			if ( count($a) > 0 ) {
				$sql = "DELETE FROM
						" . wp_postmeta . "
					WHERE
						post_id = " . eb_log_user_id_postmeta . "
						AND meta_key = '__eb_log_user'
						AND meta_id < " . $a[0]->meta_id;
//				echo $sql . '<br>';
				
				//
				_eb_q($sql);
			}
			
			
			
			
			/*
			* admin log
			*/
			$a = _eb_get_log_admin( " LIMIT 2000, 1 " );
//			print_r($a);
//			echo count($a);
			
			//
			if ( count($a) > 0 ) {
				$sql = "DELETE FROM
						" . wp_postmeta . "
					WHERE
						post_id = " . eb_log_user_id_postmeta . "
						AND meta_key = '__eb_log_admin'
						AND meta_id < " . $a[0]->meta_id;
//				echo $sql . '<br>';
				
				//
				_eb_q($sql);
			}
			
			
			
			
			// Lưu thời gian dọn log
			_eb_get_static_html ( $strCacheFilter, date( 'r', $date_time ), '', 60 );
		}
		
		
		
		
	}
}




// lấy URL trong config wp
if ( defined('WP_SITEURL') ) {
	$web_link = WP_SITEURL;
}
else if ( defined('WP_HOME') ) {
	$web_link = WP_HOME;
}
else {
//	$web_link = get_bloginfo ( 'url' );
//	$web_link = get_option ( 'siteurl' );
	$web_link = eb_web_protocol . '://' . $_SERVER['HTTP_HOST'];
}

// thêm dấu chéo vào cuối nếu chưa có
if ( substr( $web_link, -1 ) != '/' ) {
	$web_link .= '/';
}

//
/*
if ( $localhost == 1 ) {
	$web_link = get_bloginfo ( 'url' ) . '/';
} else {
	$web_link = eb_web_protocol . '://' . $_SERVER['HTTP_HOST'] . '/';
}
*/




/*
* chỉnh lại đường dẫn tĩnh nếu sai thông số
*/
if ( strstr( $web_link, $_SERVER['HTTP_HOST'] ) == false ) {
	// tách mảng để tạo URL cố định
	$web_link = explode('/', $web_link);
//	print_r($web_link);
	
	// thay bằng giá trị mới
	$web_link[2] = $_SERVER['HTTP_HOST'];
	
	// gán lại
	$web_link = implode( '/', $web_link );
//	echo $web_link;
}





// chuyển đơn vị tiền tệ từ sau ra trước
if ( $__cf_row['cf_current_price_before'] != 0 ) {
	
	//
	$__cf_row['cf_default_css'] .= '.ebe-currency:after{display:none}.ebe-currency:before{display:inline-block}';
	
	
	// đổi đơn vị tiền tệ
	if ( $__cf_row['cf_current_price'] != '' ) {
		$__cf_row['cf_default_css'] .= '.ebe-currency:before{content:"' . str_replace( '/', '\\', $__cf_row['cf_current_price'] ) . '"}';
	}
}
// đổi đơn vị tiền tệ
else if ( $__cf_row['cf_current_price'] != '' ) {
	$__cf_row['cf_default_css'] .= '.ebe-currency:after{content:"' . str_replace( '/', '\\', $__cf_row['cf_current_price'] ) . '"}';
}




//print_r( $__cf_row );
//print_r( $___eb_lang );



