<?php



/*
* Mọi trang trong này đều mặc định có trạng thái là 404 -> sẽ không được google index
*/




// chuyển cấu trúc DB sang kiểu mới
if ( isset($_GET['update_db_struct']) ) {
	
	// đây là trang rao vặt thì mới tiếp tục lệnh này
	if ( cf_set_raovat_version != 1 ) {
		die('cf_set_raovat_version OFF');
	}
	
	//
	$old_key = '_eb_product_';
	$old_key2 = '_eb_blog_';
	$old_key3 = '_ads_';
	
	$sql = _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		meta_key LIKE '{$old_key}%' OR meta_key LIKE '{$old_key2}%' OR meta_key LIKE '{$old_key3}%'
	ORDER BY
		post_id DESC
	LIMIT 0, 500");
//	print_r( $sql );
	
	//
	if ( empty( $sql ) ) {
		die('empty');
	}
	
	//
	foreach ( $sql as $v ) {
		$v->meta_value = trim($v->meta_value);
		
		WGR_update_meta_post( $v->post_id, $v->meta_key, $v->meta_value );
		
		echo $v->post_id . ' | ' . $v->meta_key . ' | ' . strip_tags( $v->meta_value ) . '<br>' . "\n";
	}
	
	//
	die( '<script>
setTimeout(function () {
	window.location = window.location.href;
}, 5000);
</script>' );
	
}




//
//print_r( $_GET ); exit();

// Nếu có ID của cat -> có thể là blog
if ( isset( $_GET['cat'] ) && $_GET['cat'] > 0 ) {
	
	// tìm kiếm URL gốc
	$url_og_url = _eb_c_link( (int)$_GET['cat'], isset($_GET['taxonomy']) ? $_GET['taxonomy'] : '' );
	
	// nếu không tìm thấy -> bỏ qua -> để đến trang báo lỗi
	if ( $url_og_url == '' || $url_og_url == '#' ) {
	}
	// nếu có -> chuyển tới trang chính
	else {
		wp_redirect( $url_og_url, 301 );
		exit();
	}
//	echo $url_og_url;
//	exit();
	
}




//
//print_r( $_GET );
$act = '';
/*
if ( isset( $_GET['ebaction'] ) ) {
	$act = $_GET['ebaction'];
}
else */ if ( isset( $_SERVER['REQUEST_URI'] ) ) {
	$act = $_SERVER['REQUEST_URI'];
	
	if ( $act != '' ) {
		$act = _eb_begin( explode( '?', $act ) );
		$act = _eb_begin( explode( '&', $act ) );
	}
	//echo $act . '<br>';
	
	$act = basename( $act );
	//echo $act . '<br>';
}
//echo $act . '<br>';

// 404 thì không thể không có trường này được
if ( $act == '' || $act == '/' ) {
	die('Template not found');
}

// lưu lại URL thật trước khi bị chuyển đổi sang thành 404
$global_404_act = $act;


//
//echo ECHBAY_PRI_CODE . '<br>';
//echo EB_THEME_URL . '<br>';
//echo EB_THEME_HTML . '<br>';
//echo EB_THEME_PLUGIN_INDEX . '<br>';
//exit();




// không index các trang module riêng của EB
$__cf_row ["cf_blog_public"] = 0;




// URL trang admin cũ -> sử dụng plugin mới cho tiện
/*
if ( $act == '9999' ) {
	if ( mtv_id > 0 ) {
		wp_redirect( admin_link, 301 );
	} else {
		wp_redirect( web_link . 'wp-login.php', 301 );
	}
	exit();
}
*/




// một số act trùng nhau
switch ( $act ) {
	
	// gờ vàng
	case "gio-vang":
	case "giovang":
		$act = 'golden_time';
		break;
	
	// contact
	case "lien-he":
	case "lienhe":
		$act = 'contact';
		break;
	
	// sitemap của yoast seo -> mặc định là sử dụng sitemap riêng của echbay
	case "sitemap.xml":
		wp_redirect( web_link . 'sitemap', 301 );
		break;
}


// danh sách các template được hỗ trợ -> làm theo kiểu này cho chắc chắn, tránh bị tạo url ảo
/*
switch ( $act ) {
	
	// kiểm tra nếu link có tồn tại function tương ứng -> gán vào và chạy
	case "cart":
	case "contact":
	case "hoan-tat":
	case "sitemap":
	case "temp":
	
	case "profile":
	case "process":
	
	case "eb-login":
	case "eb-register":
	case "eb-fogotpassword":
	
	case "eb-ajaxservice":
	
	case "php_info":
	*/
if ( isset( $arr_active_for_404_page[ $act ] ) ) {
		
		// Chuyển header sang 200
		EBE_set_header();
		
		// kiểm tra HTML riêng của theme
		$private_html_template = EB_THEME_HTML . $act . '.html';
		
		// nếu không có -> sử dụng html mặc định
		if ( ! file_exists( $private_html_template ) ) {
			$private_html_template = EB_THEME_PLUGIN_INDEX . 'html/' . $act . '.html';
		}
//		echo $private_html_template . '<br>';
		
		
		//
		include EB_THEME_PLUGIN_INDEX . 'global/' . $act . '.php';
		
		//
		$css_m_css .= ' eb-' . $act;
		
		
}
else {
	/*
		
		break;
	
	// 404 thật
	default:
	*/
		
		
		//
		$redirect_301_link = '';
		
		// lưu log 404 vào CSDL để tiện tra cứu
		$current_404_uri = $_SERVER['REQUEST_URI'];
//		echo $current_404_uri . '<br>' . "\n";
//		echo web_link . substr( $current_404_uri, 1 ) . '<br>' . "\n";
		
		
		
		
		// fiexd lỗi ở ra từ short URL ở bản AMP
		$check_2blog_in_url = explode( '/blog/', $current_404_uri );
		if ( count( $check_2blog_in_url ) == 3 ) {
			$check_2blog_in_url = web_link . substr( $check_2blog_in_url[0], 1 ) . '/blog/' . $check_2blog_in_url[1];
//			echo $check_2blog_in_url . '<br>' . "\n"; exit();
			wp_redirect( $check_2blog_in_url, 301 ); exit();
		}
		
		
		
		
		//
		$current_small_404_uri = explode( '?', $current_404_uri );
		$current_small_404_uri = $current_small_404_uri[0];
//		echo $current_small_404_uri . '<br>' . "\n";
//		echo web_link . substr( $current_small_404_uri, 1 ) . '<br>' . "\n";
//		exit();
		
		// kiểm tra xem URL 404 này đã được EchBay lưu chưa
		$sql = _eb_q("SELECT meta_value
		FROM
			`" . wp_termmeta . "`
		WHERE
			term_id = " . eb_log_404_id_postmeta . "
			AND meta_value != 1
			AND (
				meta_key = '" . $current_404_uri . "'
				OR meta_key = '" . $current_small_404_uri . "'
				)
		ORDER BY
			meta_id DESC
		LIMIT 0, 1");
//		print_r( $sql ); exit();
		
		
		
		
		// nếu ko tìm thấy -> thử tìm trong post meta -> bản cũ
//		if ( count($sql) == 0 && strlen( $sql[0]->meta_value ) < 10 ) {
		if ( empty($sql) || strlen( $sql[0]->meta_value ) < 10 ) {
			$sql = _eb_q("SELECT meta_value
			FROM
				`" . wp_postmeta . "`
			WHERE
				post_id = " . eb_log_404_id_postmeta . "
				AND meta_value != 1
				AND (
					meta_key = '" . $current_404_uri . "'
					OR meta_key = '" . $current_small_404_uri . "'
				)
			ORDER BY
				meta_id DESC
			LIMIT 0, 1");
//			print_r( $sql );
		}
		
		// nếu có trong module 404 monitor -> lấy luôn
//		if ( isset( $sql[0]->meta_value ) && strlen( $sql[0]->meta_value ) > 10 ) {
//		if ( count($sql) > 0 && strlen( $sql[0]->meta_value ) > 10 ) {
		if ( ! empty($sql) && strlen( $sql[0]->meta_value ) > 10 ) {
			
			$redirect_301_link = $sql[0]->meta_value;
			
		}
		// nếu không -> thử kiểm tra URL cũ xem có không
		else {
			
			/*
			* Thử mọi phien bản, SSL, www.
			*/
			$strFilter = "";
			
			//
			$domain_non_www = str_replace( 'www.', '', $_SERVER['HTTP_HOST'] );
			$domain_uri = substr( $current_404_uri, 1 );
			
			//
			$old_404_url = 'http://' . $domain_non_www . '/' . $domain_uri;
//			echo $old_404_url . '<br>' . "\n";
			
//			$old_small_404_url = web_link . substr( $current_small_404_uri, 1 );
			$old_small_404_url = 'http://www.' . $domain_non_www . '/' . $domain_uri;
//			echo $old_small_404_url . '<br>' . "\n";
//			exit();
			
//			$old_ssl_www_404_url = 'https://www.' . str_replace( 'www.', '', $_SERVER['HTTP_HOST'] ) . substr( $current_small_404_uri, 1 );
			$old_ssl_www_404_url = 'https://www.' . $domain_non_www . '/' . $domain_uri;
//			echo $old_ssl_www_404_url . '<br>' . "\n";
			
//			$old_ssl_404_url = 'https://' . str_replace( 'www.', '', $_SERVER['HTTP_HOST'] ) . substr( $current_small_404_uri, 1 );
			$old_ssl_404_url = 'https://' . $domain_non_www . '/' . $domain_uri;
//			echo $old_ssl_404_url . '<br>' . "\n";
			
			//
			$strFilter = " meta_value = '" . $old_404_url . "'
					OR meta_value = '" . $old_small_404_url . "'
					OR meta_value = '" . $old_ssl_www_404_url . "'
					OR meta_value = '" . $old_ssl_404_url . "'
					OR meta_value = '" . $current_404_uri . "'
					OR meta_value = '" . $domain_uri . "'";
			
			// cắt bỏ dấu ? nếu có
			if ( strstr( $domain_uri, '?' ) == true ) {
				$domain_hoicham_uri = explode('?', $domain_uri);
				$domain_hoicham_uri = $domain_hoicham_uri[0];
				
				//
				$old_hoicham_404_url = 'http://' . $domain_non_www . '/' . $domain_hoicham_uri;
//				echo $old_hoicham_404_url . '<br>' . "\n";
				
				$old_hoicham_small_404_url = 'http://www.' . $domain_non_www . '/' . $domain_hoicham_uri;
//				echo $old_hoicham_small_404_url . '<br>' . "\n";
//				exit();
				
				$old_hoicham_ssl_www_404_url = 'https://www.' . $domain_non_www . '/' . $domain_hoicham_uri;
//				echo $old_hoicham_ssl_www_404_url . '<br>' . "\n";
				
				$old_hoicham_ssl_404_url = 'https://' . $domain_non_www . '/' . $domain_hoicham_uri;
//				echo $old_hoicham_ssl_404_url . '<br>' . "\n";
				
				//
				$strFilter .= " OR meta_value = '" . $old_hoicham_404_url . "'
					OR meta_value = '" . $old_hoicham_small_404_url . "'
					OR meta_value = '" . $old_hoicham_ssl_www_404_url . "'
					OR meta_value = '" . $old_hoicham_ssl_404_url . "'
					OR meta_value = '" . $domain_hoicham_uri . "' ";
			}
			
			//
			$sql = _eb_q("SELECT post_id, meta_key
			FROM
				`" . wp_postmeta . "`
			WHERE
				(
				meta_key = '_eb_product_leech_source'
				OR meta_key = '_eb_product_old_url'
				)
				AND (
					" . $strFilter . "
				)
			ORDER BY
				meta_id DESC
			LIMIT 0, 1");
//			print_r( $sql ); exit();
			
			// nếu tìm được -> xác định URL cũ luôn
//			if ( count($sql) > 0 ) {
			if ( ! empty($sql) ) {
				$v = $sql[0];
				
				// category
				/*
				if ( $v->meta_key == '_eb_category_leech_url' || $v->meta_key == '_eb_category_old_url' ) {
					$redirect_301_link = _eb_c_link( $v->post_id );
				}
				// product
				else if ( $v->meta_key == '_eb_product_leech_source' || $v->meta_key == '_eb_product_old_url' ) {
					*/
					$redirect_301_link = _eb_p_link( $v->post_id );
//				}
			}
			else {
				$sql = _eb_q("SELECT term_id, meta_key
				FROM
					`" . wp_termmeta . "`
				WHERE
					(
					meta_key = '_eb_category_leech_url'
					OR meta_key = '_eb_category_old_url'
					)
					AND (
						" . $strFilter . "
					)
				ORDER BY
					meta_id DESC
				LIMIT 0, 1");
				if ( count($sql) > 0 ) {
					$v = $sql[0];
					
					// category
//					if ( $v->meta_key == '_eb_category_leech_url' || $v->meta_key == '_eb_category_old_url' ) {
						$redirect_301_link = _eb_c_link( $v->term_id );
//					}
				}
				// thử đồng bộ từ version cũ sang version wordpress
				else if ( $__cf_row['cf_echbay_migrate_version'] == 1 ) {
					include EB_THEME_PLUGIN_INDEX . 'global/404_convert_echbay_v1.php';
				}
			}
		}
		
		// -> nếu tìm được URL mới -> chuyển tới luôn
		if ( $redirect_301_link != '' ) {
			
			// v1
			/*
			$pcol = ( isset($_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
			
			header( $pcol . ' 301 Moved Permanently' );
			header ( 'Location:' . $redirect_301_link );
			*/
			
			//
			wp_redirect( $redirect_301_link, 301 );
			
			exit();
			
		}
		
		
		
		
		// nếu tồn tại function riêng của domain -> chạy luôn
		if ( function_exists('page_404_for_this_domain') ) {
			page_404_for_this_domain();
		}
		
		
		// nếu không -> add vào monitor để add thủ công
		if ( $redirect_301_link == '' ) {
//			WGR_update_meta_post( eb_log_404_id_postmeta, $current_404_uri, 1, true );
			add_term_meta( eb_log_404_id_postmeta, $current_404_uri, 1, true );
		}
		
		
		//
		$act = '404';
		$url_og_url = web_link . $act;
		$dynamic_meta .= '<link rel="canonical" href="' . $url_og_url . '" />';
		
		// không thì chuyển ra trang 4040
		$__cf_row ['cf_title'] = '404 Not Found';
		$__cf_row ['cf_keywords'] = $__cf_row ['cf_title'];
		$__cf_row ['cf_description'] = $__cf_row ['cf_title'];
		
		$group_go_to[] = ' <li>' . $__cf_row ['cf_title'] . '</li>';
		
		
		// kiểm tra nếu có file html riêng -> sử dụng html riêng
		/*
		$check_html_rieng = EB_THEME_HTML . '404.html';
		$thu_muc_for_html = EB_THEME_HTML;
		if ( ! file_exists($check_html_rieng) ) {
			$thu_muc_for_html = EB_THEME_PLUGIN_INDEX . 'html/';
		}
		
		//
		$main_content = EBE_str_template ( '404.html', array(), $thu_muc_for_html );
		*/
		
		//
		$main_content = EBE_html_template( EBE_get_page_template( $act ) );
		
}




// css định dạng chiều rộng cho phần danh sách blog
//$main_content = str_replace( '{tmp.custom_blog_css}', $__cf_row['cf_blog_class_style'], $main_content );



