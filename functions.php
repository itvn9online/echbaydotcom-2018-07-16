<?php




// lấy sản phẩm theo mẫu chung
function EBE_select_thread_list_all ( $post, $html = __eb_thread_template, $pot_tai = 'category' ) {
	global $__cf_row;
	global $eb_background_for_post;
//	global $eb_background_for_mobile_post;
	
	//
//		print_r( $post );
	
	// truyền các giá trị cho HTML cũ có thể chạy được
	
	// với quảng cáo thì lấy link theo kiểu quảng cáo
	if ( $post->post_type == 'ads' ) {
		$post->p_link = _eb_get_post_meta( $post->ID, '_eb_ads_url', true, 'javascript:;' );
	} else {
//		if ( $post->post_type == 'blog' && $post->post_excerpt == '' ) {
			$post->post_excerpt = _eb_short_string( strip_tags ( $post->post_content ), 130 );
//		}
		
		//
		$post->p_link = _eb_p_link( $post->ID );
	}
	
//	$post->p_link = $post->guid;
	$post->trv_tieude = $post->post_title;
	$post->trv_id = $post->ID;
	$post->trv_masanpham = _eb_get_post_object( $post->ID, '_eb_product_sku', $post->ID );
	$post->trv_gioithieu = $post->post_excerpt;
//	$post->ngaycapnhat = date( 'd/m/Y', strtotime( $post->post_modified ) );
	$post->ngaycapnhat = date( 'd/m/Y', strtotime( $post->post_date ) );
	
	$post->trv_mua = (int) _eb_get_post_object( $post->ID, '_eb_product_buyer', 0 );
	
	//
	$post->trv_giaban = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_oldprice', 0 ) );
	
	$post->trv_giamoi = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_price', 0 ) );
	$post->trv_num_giamoi = $post->trv_giamoi;
	
	//
	$post->trv_color_count = 1;
	
	$post->cf_product_size = $__cf_row['cf_product_size'];
	$post->cf_blog_size = $__cf_row['cf_blog_size'];
	
	$post->trv_trangthai = 1;
	$post->trv_ngayhethan = date_time;
	
	//
//	$ant = get_the_category( $post->ID );
	$ant = get_the_terms( $post->ID, $pot_tai );
//	print_r( $ant );
	$post->ant_ten = isset ($ant[0]->name ) ? '<a href="' . _eb_c_link( $ant[0]->term_id ) . '">' . $ant[0]->name . '</a>' : '';
	
	//
	$post->pt = 0;
	if ( $post->trv_giaban > $post->trv_giamoi ) {
		$post->pt = 100 - ( int ) ( $post->trv_giamoi * 100 / $post->trv_giaban );
	}
	
	//
	$post->trv_giaban = EBE_add_ebe_currency_class( $post->trv_giaban, 1 );
	
	$post->trv_giamoi = EBE_add_ebe_currency_class( $post->trv_giamoi );
	
	
	// lấy ảnh đại diện kích thước medium ( chỉnh trong wp-admin/options-media.php )
	$post->trv_img = _eb_get_post_img( $post->ID, $__cf_row['cf_product_thumbnail_size'] );
	if ( $__cf_row['cf_product_thumbnail_table_size'] == $__cf_row['cf_product_thumbnail_size'] ) {
		$post->trv_table_img = $post->trv_img;
	} else {
		$post->trv_table_img = _eb_get_post_img( $post->ID, $__cf_row['cf_product_thumbnail_table_size'] );
	}
	if ( $__cf_row['cf_product_thumbnail_mobile_size'] == $__cf_row['cf_product_thumbnail_table_size'] ) {
		$post->trv_mobile_img = $post->trv_table_img;
	} else {
		$post->trv_mobile_img = _eb_get_post_img( $post->ID, $__cf_row['cf_product_thumbnail_mobile_size'] );
	}
	
	//
	$html = str_replace( '<dynamic_title_tag', '<' . $__cf_row['cf_threadnode_title_tag'], $html );
	$html = str_replace( 'dynamic_title_tag>', $__cf_row['cf_threadnode_title_tag'] . '>', $html );
	
	//
	/*
	if ( $post->trv_mobile_img != '' ) {
		$post->trv_mobile_img = 'background-image:url(' . $post->trv_mobile_img . ')!important';
	}
	if ( $post->trv_img != '' ) {
		$post->trv_img = 'background-image:url(' . $post->trv_img . ')!important';
	}
	$eb_background_for_post['p' . $post->ID] = '.ebp' . $post->ID . 'm{' . $post->trv_mobile_img . '}.ebp' . $post->ID . '{' . $post->trv_img . '}';
	$post->trv_img = 'speed';
	$post->trv_mobile_img = 'ebp' . $post->ID;
	*/
	
	//
	return EBE_arr_tmp( $post, $html );
}


function EBE_add_ebe_currency_class ( $gia, $gia_cu = 0 ) {
	if ( $gia_cu == 0 ) {
		$class = 'global-details-giamoi';
		$zero = '<em>Liên hệ</em>';
	} else {
		$class = 'global-details-giacu old-price';
		$zero = '&nbsp;';
	}
	
	return $gia > 0 ? '<strong class="' . $class . ' ebe-currency">' . number_format( $gia ) . '</strong>' : $zero;
}


function EBE_arr_tmp ($row = array(), $str = '', $tmp = 'tmp.') {
//	print_r($row);
	foreach ($row as $k => $v) {
		$str = str_replace('{' .$tmp . $k. '}', $v, $str);
	}
	return $str;
}

function EBE_str_template( $f, $arr = array(), $dir = EB_THEME_HTML ) {
	$f = $dir . $f;
	
	if (file_exists($f)) {
		$f = file_get_contents($f, 1);
		
		//
		return EBE_html_template( $f, $arr );
	}
	
	//
	return 'File "' .$template. '" not found.';
}

// thay thế các văn bản trong html tìm được
function EBE_html_template ( $html, $arr = array() ) {
	foreach ($arr as $k => $v) {
		$html = str_replace('{' .$k. '}', $v, $html);
	}
	
	return $html;
}

function EBE_get_html_file_addon ( $page_name, $addon = '' ) {
	global $arr_for_show_html_file_load;
	
	if ( $addon != '' ) {
		$page_name .= '_' . $addon;
	}
	$arr_for_show_html_file_load[] = '<!-- addon: ' . $page_name . ' -->';
	
	return $page_name;
}

function EBE_get_page_custom_options ( $page_name ) {
	
	// lấy page trong CSDL xem có không? chỉ lấy page dưới dạng Private
	$sql = _eb_q("SELECT ID, post_title, post_excerpt
	FROM
		`" . $wpdb->posts . "`
	WHERE
		post_name = '" . $page_name . "'
		AND post_type = 'eb_page'
		AND post_status = 'private'");
//		print_r($sql);
	
	// nếu tồn tại page này -> sử dụng page để làm html
	if ( isset( $sql[0] ) && isset($sql[0]->ID) ) {
		return trim( $sql[0]->post_excerpt );
	}
	return '';
}

function EBE_get_page_template ( $page_name = '', $dir = EB_THEME_HTML ) {
	global $wpdb;
	global $__cf_row;
	global $arr_for_add_css;
	global $arr_for_add_theme_css;
	global $arr_for_show_html_file_load;
	
	//
	if ( $page_name == '' ) {
		$page_name = 'home';
//		$page_name = 'test-page';
	}
	
	//
	$html = '';
	
	// thử lấy trong CSDL xem có không
	/*
	$html = EBE_get_page_custom_options( $__cf_row['cf_theme_dir'] . '-' . $page_name );
	if ( $html != '' ) {
		$arr_for_show_html_file_load[] = '<!-- custom HTML: ' . $page_name . ' -->';
		
		return $html;
	}
	*/
	
	// không có HTML động -> lấy file tĩnh theo theme
	$f = $dir . $page_name . '.html';
//	echo $f . '<br>';
	
	// tìm trong thư mục theme riêng (ưu tiên)
	if ( file_exists($f) ) {
		$arr_for_show_html_file_load[] = '<!-- theme HTML: ' . $page_name . ' -->';
		
		$html = file_get_contents($f, 1);
		
		// dùng chung thì gán CSS dùng chung luôn (nếu có)
		$css = EB_THEME_THEME . 'css/' . $page_name . '.css';
//		echo $css;
		if ( file_exists( $css ) ) {
			$arr_for_add_theme_css[ $css ] = 1;
			
			$arr_for_show_html_file_load[] = '<!-- theme CSS: ' . $page_name . ' -->';
		}
	}
	// tìm trong thư mục theme chung
	else {
		$f = EB_THEME_PLUGIN_INDEX . 'html/' . $page_name . '.html';
		
		// nếu không -> báo lỗi
		if ( ! file_exists($f) ) {
			return 'File HTML "' .$page_name. '" not found.';
		}
		
		// nếu có -> dùng
		$arr_for_show_html_file_load[] = '<!-- global HTML: ' . $page_name . ' -->';
		
		$html = file_get_contents($f, 1);
		
		// dùng chung thì gán CSS dùng chung luôn (nếu có)
		$css = EB_THEME_PLUGIN_INDEX . 'css/default/' . $page_name . '.css';
		if ( file_exists( $css ) ) {
			$arr_for_add_css[ $css ] = 1;
			
			$arr_for_show_html_file_load[] = '<!-- global CSS: ' . $page_name . ' -->';
		}
	}
	
	//
	return $html;
}



/*
* Chức năng tạo head riêng của Echbay
* Các file tĩnh như css, js sẽ được cho vào vòng lặp để chạy 1 phát cho tiện
*/
function _eb_add_css ( $arr = array(), $include_now = 0 ) {
	_eb_add_css_js_file( $arr, '.css', $include_now );
}

function _eb_add_full_css ( $arr = array(), $type_add = 'import' ) {
	if ( $type_add == 'import' ) {
		foreach ( $arr as $v ) {
			echo '<style>@import url(' . $v . ');</style>';
		}
	} else {
		foreach ( $arr as $v ) {
			echo '<link rel="stylesheet" href="' . $v . '" type="text/css" media="all" />';
		}
	}
}

function _eb_add_js ( $arr = array(), $include_now = 0 ) {
	_eb_add_css_js_file( $arr, '.js', $include_now );
}

function _eb_add_full_js ( $arr = array(), $type_add = 'import' ) {
	/*
	if ( $type_add == 'import' ) {
		foreach ( $arr as $v ) {
			// v2
			echo _eb_import_js( $v . '?v=' . web_version );
		}
	}
	else {
		*/
		foreach ( $arr as $v ) {
			echo '<script type="text/javascript" src="' . $v . '?v=' . web_version . '"></script>' . "\n";
		}
//	}
	
	//
	/*
	echo '<script type="text/javascript" src="';
	echo implode( '?v=' . web_version . '"></script>' . "\n" . '<script type="text/javascript" src="', $arr );
	echo '"></script>';
	*/
	
}

function EBE_add_js_compiler_in_cache ( $arr_eb_add_full_js, $async = '', $optimize = 0 ) {
	global $__cf_row;
	
	//
//	print_r( $arr_eb_add_full_js );
	
	
	//
	if ( eb_code_tester == true ) {
		$content_dir = basename( WP_CONTENT_DIR );
//		echo $content_dir . "\n";
		
		foreach ( $arr_eb_add_full_js as $v ) {
			if ( file_exists( $v ) ) {
				$ver = filemtime( $v );
				
//				echo ABSPATH . "\n";
//				$v = str_replace( ABSPATH, '', $v );
				$v = str_replace( '\\', '/', strstr( $v, $content_dir ) );
				
				echo '<script type="text/javascript" src="' . $v . '?ver=' . $ver . '"></script>' . "\n";
			}
		}
		return true;
	}
	
	
	
	//
	$file_name_cache = '';
	foreach ( $arr_eb_add_full_js as $v ) {
		if ( file_exists( $v ) ) {
			$file_name_cache .= basename( $v ) . filemtime( $v );
		}
	}
	$file_name_cache .= '.js';
	
	//
//	$file_in_cache = ABSPATH . 'wp-content/uploads/ebcache/' . $file_name_cache;
	$file_in_cache = EB_THEME_CACHE . $file_name_cache;
	if ( file_exists( $file_in_cache ) ) {
		echo '<script type="text/javascript" src="' . $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/ebcache/' . $file_name_cache . '" ' . $async . '></script>' . "\n";
		
		return true;
	}
	
	
	//
	$new_content = '';
	foreach ( $arr_eb_add_full_js as $v ) {
		// xem file có tồn tại không
		if ( file_exists( $v ) ) {
//			echo $v . "\n";
			
			// xem trong cache có chưa
//			$file_name_cache = basename( $v ) . filemtime( $v ) . '.js';
//			$file_in_cache = ABSPATH . 'wp-content/uploads/ebcache/' . $file_name_cache;
			
			// nếu chưa có -> tạo cache
//			if ( ! file_exists( $file_in_cache ) ) {
//				echo $file_in_cache . "\n";
				
				//
				$file_content = file_get_contents( $v, 1 );
				$file_content = explode( "\n", $file_content );
				foreach ( $file_content as $v ) {
					$v = trim( $v );
					
					if ( $v == '' || substr( $v, 0, 2 ) == '//' ) {
					}
					else if ( $optimize == 1 ) {
						if ( strstr( $v, '//' ) == true ) {
							$v .= "\n";
						}
						$new_content .= $v;
					}
					else {
						$new_content .= $v . "\n";
					}
				}
//			}
		}
	}
	
	//
	_eb_create_file( $file_in_cache, $new_content );
	
	//
	echo '<script type="text/javascript" src="' . $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/ebcache/' . $file_name_cache . '"></script>' . "\n";
}

// một số host không dùng được hàm end
function _eb_end ( $arr ) {
	return $arr[ count($arr) - 1 ];
}
function _eb_last ( $arr ) {
	return _eb_end($arr);
}
function _eb_begin ( $arr ) {
	return $arr[0];
}
function _eb_first ( $arr ) {
	return _eb_begin($arr);
}

function _eb_add_css_js_file ( $arr, $file_type = '.css', $include_now = 0, $include_url = EB_URL_OF_THEME ) {
	global $localhost;
	global $__cf_row;
	
	//
//		$include_now = 1;
	
	//
//		echo basename( get_template_directory() ) . '<br>';
	
	
	
	
	//
	$check_time = 120;
	if ( eb_code_tester == true && $include_now == 0 ) {
		$check_time = 5;
	}
	else if ( $include_now == 1 || $localhost == 1 ) {
//		else if ( eb_code_tester == true ) {
//			print_r($arr);
//			echo EB_THEME_THEME . "\n";
		
		// add trực tiếp file JS nếu làm việc trên lcoalhost -> để còn debug
		if ( $file_type == '.js' ) {
			foreach ( $arr as $v ) {
				$f = EB_THEME_THEME . 'javascript/' . $v;
//					echo $f . "\n";
				
				// nếu file không tồn tại -> kiểm tra trong plugin
				if ( ! file_exists( $f ) ) {
					$v = EB_URL_OF_PLUGIN . $v;
				} else {
					$v = EB_URL_OF_THEME . 'javascript/' . $v;
				}
				
				//
				echo '<script type="text/javascript" src="' . $v . '?v=' . web_version . '"></script>' . "\n";
				
				// v2
//					echo _eb_import_js( $v . '?v=' . web_version );
			}
		} else {
			foreach ( $arr as $v ) {
				$f = EB_THEME_THEME . 'css/' . $v;
//					echo $f . "\n";
				
				// nếu file không tồn tại -> kiểm tra trong plugin
				if ( ! file_exists( $f ) ) {
					$v = EB_URL_OF_PLUGIN . $v;
				} else {
					$v = EB_URL_OF_THEME . 'css/' . $v;
				}
				
				//
				echo '<link rel="stylesheet" href="' . $v . '?v=' . web_version . '" type="text/css" />' . "\n";
			}
		}
		
		//
		return false;
	}
	
	
	
	
//		$strCacheFilter = implode( '-', $arr );
	$strCacheFilter = '';
//		print_r($arr);
	foreach ( $arr as $v ) {
		$strCacheFilter .= _eb_end ( explode( '/', $v ) );
	}
	$strCacheFilter = preg_replace ( '/[^a-zA-Z0-9]+/', '-', $strCacheFilter );
//		echo 'Cache: ' . $strCacheFilter . '<br>'; exit();
	
	//
	$f_content = _eb_get_static_html ( $strCacheFilter, '', '', $check_time );
	if ($f_content == false) {
		$f_content = '';
		
		//
		$f_dir = 'javascript/';
		if ( $file_type == '.css' ) {
			$f_dir = 'css/';
		}
		
		//
		$f_filename = '';
		foreach ( $arr as $v ) {
//				$f_filename .= $v;
			$f_filename .= _eb_end( explode( '/', $v ) );
			
			//
			$v0 = $v;
			$v = EB_THEME_THEME . $f_dir . $v;
			
			// nếu file không tồn tại -> kiểm tra trong plugin
			if ( ! file_exists( $v ) ) {
				$v = EB_THEME_PLUGIN_INDEX . $v0;
			}
//				echo $v . '<br>';
			
			// thêm cả thời gian chỉnh sửa file, nếu có thay đổi -> tên file sẽ thay đổi
			if ( file_exists( $v ) ) {
//					echo date( 'r', filemtime ( $v ) ) . '<br>';
				$f_filename .= filemtime ( $v );
				
				//
//					$f_content .= file_get_contents( $v, 1 );
				$f_content .= '/* //' . $v0 . '// */' . "\n" . file_get_contents( $v, 1 ) . "\n";
			}
		}
		$f_filename = str_replace( '.js', '', $f_filename );
		$f_filename = str_replace( '.css', '', $f_filename );
		$f_filename = preg_replace ( '/[^a-zA-Z0-9]+/', '-', $f_filename );
		$f_filename .= $file_type;
//			echo 'Filename: ' . $f_filename . '<br>';
		
		//
		$f_save = EB_THEME_CACHE . $f_filename;
//			echo 'Save: ' . $f_save . '<br>';
		
		//
		$new_content = '';
		
		// chỉ lưu file khi chưa tồn tại -> có chỉnh sửa mới cần phải lưu
		if ( eb_code_tester == true || ! file_exists( $f_save ) ) {
			
			// thu gọn dữ liệu file css (nếu có)
//				if ( $compiler == 1 ) {
				
				//
				if ( $file_type == '.js' ) {
					// lưu lại nội dung cũ trước khi xử lý
					$old_content = $f_content;
					
					// Xử lý nội dung
					$f_content = explode( "\n", $f_content );
					
					// Nội dung đủ nhiều thì mới ghép dòng
					if ( count( $f_content ) > 10 ) {
						foreach ( $f_content as $v ) {
							$v = trim( $v );
							
							//
							if ( substr( $v, 0, 2 ) != '//' ) {
								if ( strstr( $v, '//' ) == true ) {
									$v .= "\n";
								}
								
								//
								$new_content .= $v;
							}
						}
					}
					// Không thì cứ thế dùng thôi
					else {
						$new_content = $old_content . "\n";
					}
				}
				// css
				else {
					/*
					foreach ( $f_content as $v ) {
						$new_content .= trim( $v );
					}
					*/
					
					// loại các ký tự không cần thiết, căn chỉnh về 1 dòng
//						$new_content = preg_replace( "/\r\n|\n\r|\n|\r|\t/", "", $f_content );
					$new_content = $f_content;
					
					// chỉnh lại đường dẫn trong file css
					$arr_css_new_content = array(
						'../images/' => './wp-content/themes/' . basename( get_template_directory() ) . '/theme/images/',
//							'../../../../plugins/' => '../../plugins/',
						
						// các css ngoài -> trong outsource -> vd: font awesome
//							'../../../../plugins/' => 'wp-content/plugins/',
//							'../outsource/' => 'wp-content/plugins/echbaydotcom/outsource/',
						'../outsource/' => 'wp-content/echbaydotcom/outsource/',
						
						'../fonts/' => 'wp-content/echbaydotcom/outsource/fonts/',
						
						// làm đẹp css
//							'}.' => '}' . "\n" . '.',
						
						// rút gọn các phần khác
//							', .' => ',' . "\n" . '.',
//							' {' => '{',
//							', ' => ',',
						' { ' => '{',
						
						'; }.' => ';}.',
						'; }#' => ';}#',
						
						';}.' => '}.',
						';}#' => '}#',
					);
					
					// google khuyến khích không nên để inline cho CSS
//						$new_content = str_replace( '}', '}' . "\n", $new_content );
//						$new_content = str_replace( '}.', '}' . "\n" . '.', $new_content );
					
					//
					$split_content = explode( "\n", $new_content );
					$new_content = '';
					$str_new = '';
					foreach ( $split_content as $v ) {
						$v = trim( $v );
						$str_new .= $v;
						
						if ( strlen( $str_new ) > 1200 ) {
							$new_content .= $str_new . "\n";
							
							$str_new = '';
						}
					}
					// kết thúc chuỗi, nếu vẫn còn dữ liệu thì phải add thêm vào
					$new_content .= $str_new;
					
					//
					foreach ( $arr_css_new_content as $k => $v ) {
						$new_content = str_replace( $k, $v, $new_content );
					}
					
					// nội dung in trực tiếp vào html
					$new_content = '<style type="text/css">/* ' . date( 'r', date_time ) . ' */' . $new_content . '</style>';
				}
				/*
			}
			else {
				$new_content = $f_content . "\n";
			}
			*/
			
			//
//				echo gettype( $new_content ) . '<br>';
			
			// Tạo nội dung file css
			_eb_create_file ( $f_save, $new_content );
			
			//
			_eb_log_admin( 'Create static file: ' . $strCacheFilter );
		}
//			exit();
		
		//
//			$none_http_url = str_replace( 'http://', '//', content_url() );
		$none_http_url = 'wp-content';
		
		//
		if ( $file_type == '.js' ) {
			
			// tạo nội dung nhúng file css
			$f_url = $__cf_row['cf_dns_prefetch'] . $none_http_url . '/uploads/ebcache/' . $f_filename;
//				echo 'URL: ' . $f_url . '<br>';
			
			/*
			$f_content = '<script type="text/javascript" src="' . $f_url . '"></script>';
			*/
			
			// thử add js theo cách mới xem sao
			$f_content = _eb_import_js( $f_url );
			
		} else {
			
			if ( $new_content == '' ) {
				$f_content = file_get_contents( $f_save, 1 );
			} else {
				// in css ra cùng với html luôn
				$f_content = $new_content;
				
				// trỏ link tới css
//				$c = '<link rel="stylesheet" href="' . $f_url . '?v=' . web_version . '" type="text/css" />';
			}
			
		}
		
		// lưu nội dung nhúng file
		_eb_get_static_html ( $strCacheFilter, $f_content, '', $check_time );
	}
	
	echo $f_content;
}

function _eb_import_js ( $js ) {
	/* async */
	return '<script type="text/javascript" src="' . $js . '"></script>' . "\n";
	/* */
	
	/* 
	return '<script type="text/javascript">
	(function(d, a) {
		var s = d.createElement(a);
		s.type = "text/javascript";
		s.async = 1;
		s.src = "' . $js . '";
		var m = d.getElementsByTagName(a)[0];
		m.parentNode.insertBefore(s, m);
	}( document, "script" ));
	</script>';
	/* */
}

//
function _eb_replace_css_space ( $str, $new_array = array() ) {
	$arr = array(
		' { ' => '{',
		
		'; }.' => ';}.',
		'; }#' => ';}#',
		
		';}.' => '}.',
		';}#' => '}#',
	);
	
	//
//		print_r( $arr );
	$arr = array_merge( $arr, $new_array );
//		print_r( $arr );
	
	foreach ( $arr as $k => $v ) {
		$str = str_replace( $k, $v, $str );
	}
	
	return $str;
}

function EBE_replace_link_in_cache_css ( $c ) {
	return _eb_replace_css_space ( $c, array(
		'../images/' => '../../themes/' . basename( get_template_directory() ) . '/theme/images/',
		
		// các css ngoài -> trong outsource -> vd: font awesome
		'../outsource/' => '../../echbaydotcom/outsource/',
		'../fonts/' => '../../echbaydotcom/outsource/fonts/',
	) );
}

function EBE_replace_link_in_css ( $c ) {
	return _eb_replace_css_space ( $c, array(
//		'../images/' => './wp-content/themes/' . basename( get_template_directory() ) . '/theme/images/',
		'../images/' => './wp-content/themes/' . basename( EB_THEME_URL ) . '/theme/images/',
		'../../images-global/' => EB_URL_OF_PLUGIN . 'images-global/',
		'../images-global/' => EB_URL_OF_PLUGIN . 'images-global/',
		
		// các css ngoài -> trong outsource -> vd: font awesome
		'../outsource/' => './wp-content/echbaydotcom/outsource/',
		
		'../fonts/' => './wp-content/echbaydotcom/outsource/fonts/',
	) );
}

// add css thẳng vào HTML
function _eb_add_compiler_css ( $arr ) {
//	print_r( $arr );
	
	// nếu là dạng tester -> chỉ có 1 kiểu add thôi
	if ( eb_code_tester == true ) {
		_eb_add_compiler_css_v2( $arr );
	}
	// sử dụng thật thì có 2 kiểu add: inline và add link
	else {
		$new_arr1 = array();
		$new_arr2 = array();
		
		//
		foreach ( $arr as $k => $v ) {
			if ( $v == 1 ) {
				$new_arr2[$k] = 1;
			}
			else {
				$new_arr1[$k] = 1;
			}
		}
//		print_r( $new_arr1 );
//		print_r( $new_arr2 );
		
		// inline
		_eb_add_compiler_css_v2( $new_arr1 );
		
		// add link
		_eb_add_compiler_css_v2( $new_arr2, 0 );
	}
}

function _eb_add_compiler_css_v2 ( $arr, $css_inline = 1 ) {
	
	// nhúng link
	if ( eb_code_tester == true ) {
		$content_dir = basename( WP_CONTENT_DIR );
//		echo $content_dir . "\n";
		
		foreach ( $arr as $v => $k ) {
			// chỉ add file có trong host
			if ( file_exists( $v ) ) {
				$ver = filemtime( $v );
				
//				echo ABSPATH . "\n";
//				$v = str_replace( ABSPATH, '', $v );
				$v = str_replace( '\\', '/', strstr( $v, $content_dir ) );
				
				echo '<link rel="stylesheet" href="' . $v . '?v=' . $ver . '" type="text/css" media="all" />' . "\n";
			}
		}
		
		//
		return true;
	}
	
	
	// add link
	if ( $css_inline != 1 ) {
		$file_cache = '';
		$new_arr = array();
		foreach ( $arr as $v => $k ) {
			// chỉ add file có trong host
			if ( file_exists( $v ) ) {
				// lấy tên file
				$file_name = basename($v, '.css');
//				echo $file_name . '<br>' . "\n";
				
				// thời gian cập nhật file
				$file_time = filemtime ( $v );
				
				$file_cache .= $file_name . $file_time;
				
				$new_arr[$v] = 1;
			}
		}
		$file_cache .= '.css';
//		echo $file_cache . "\n";
		
		$file_save = EB_THEME_CACHE . $file_cache;
//		echo $file_save . "\n";
		
		// nếu chưa -> tạo file cache
		if ( ! file_exists( $file_save ) ) {
			$cache_content = '';
			foreach ( $new_arr as $v => $k ) {
				$file_content = explode( "\n", file_get_contents( $v, 1 ) );
				
				foreach ( $file_content as $v2 ) {
					$v2 = trim( $v2 );
					$cache_content .= $v2;
				}
			}
			
			//
			_eb_create_file ( $file_save, EBE_replace_link_in_cache_css ( $cache_content ) );
		}
		
		// -> done
		echo '<link rel="stylesheet" href="' . web_link . 'wp-content/uploads/ebcache/' . $file_cache . '" type="text/css" media="all" />';
		
		//
		return true;
	}
	
	
	
	
	// nhúng nội dung file
	echo '<style type="text/css">';
	
	//
	foreach ( $arr as $v => $k ) {
		// chỉ add file có trong host
		if ( file_exists( $v ) ) {
			// lấy tên file
			$file_name = basename($v, '.css');
//			echo $file_name . '<br>' . "\n";
			
			// thời gian cập nhật file
			$file_time = filemtime ( $v );
//			$file_time = date( 'Ymd-Hi', filemtime ( $v ) );
//			echo $file_time . '<br>' . "\n";
			
			// -> tên file trong cache
			$file_cache = $file_name . $file_time . '.css';
//			echo $file_cache . '<br>' . "\n";
			
			// nơi lưu file cache
			$file_save = EB_THEME_CACHE . $file_cache;
//			echo $file_save . '<br>' . "\n";
			
			// nếu chưa -> tạo file cache
			if ( ! file_exists( $file_save ) ) {
				$file_content = explode( "\n", file_get_contents( $v, 1 ) );
				$cache_content = '/* ' . $file_cache . ' - ' . date( 'r', date_time ) . ' ============== */' . "\n";
				
				foreach ( $file_content as $v2 ) {
					$v2 = trim( $v2 );
					$cache_content .= $v2;
				}
				
				//
				_eb_create_file ( $file_save, EBE_replace_link_in_css($cache_content) );
			}
			
			// 
//			echo '/* ' . $file_cache . ' */' . "\n";
			// inline
			echo file_get_contents( $file_save, 1 ) . "\n";
		}
	}
	
	//
	echo '</style>';
	
}

// add css dưới dạng <link>
function _eb_add_compiler_link_css ( $arr ) {
	global $__cf_row;
	
	//
	foreach ( $arr as $v ) {
		// nếu có file -> compiler lại và cho vào cache
		if ( file_exists( $v ) ) {
			// lấy tên file
			$file_name = basename($v, '.css');
//				echo $file_name . '<br>' . "\n";
			
			// thời gian cập nhật file
			$file_time = date( 'Ymd-Hi', filemtime ( $v ) );
//				echo $file_time . '<br>' . "\n";
			
			// -> tên file trong cache
			$file_cache = $file_name . $file_time . '.css';
//				echo $file_cache . '<br>' . "\n";
			
			// nơi lưu file cache
			$file_save = EB_THEME_CACHE . $file_cache;
//				echo $file_save . '<br>' . "\n";
			
			// nếu chưa -> tạo file cache
			if ( ! file_exists( $file_save ) ) {
				$file_content = explode( "\n", file_get_contents( $v, 1 ) );
				$cache_content = '/* ' . date( 'r', date_time ) . ' */' . "\n";
				
				foreach ( $file_content as $v2 ) {
					$v2 = trim( $v2 );
					$cache_content .= $v2;
				}
				
				//
				_eb_create_file ( $file_save, EBE_replace_link_in_cache_css($cache_content) );
			}
			
			//
//				$file_link = $__cf_row['cf_dns_prefetch'] . 'wp-content/uploads/ebcache/' . $file_cache;
			$file_link = web_link . 'wp-content/uploads/ebcache/' . $file_cache;
			
			// -> done
			echo '<link rel="stylesheet" href="' . $file_link . '" type="text/css" media="all" />' . "\n";
		}
		// nếu không -> include trực tiếp
		else {
			echo '<link rel="stylesheet" href="' . $v . '" type="text/css" media="all" />';
		}
	}
}


// Thiết lập hàm hiển thị logo
function _eb_echbay_logo() {
	echo '<p><a href="' . web_link . '" title="' . get_bloginfo ( 'description' ) . '">' . web_name . '</a></p>';
}


/*
* Thiết lập hàm hiển thị menu
* https://developer.wordpress.org/reference/functions/wp_nav_menu/
* tag_menu_name: nếu muốn lấy cả tên menu thì gán thêm hàm này vào
* tag_close_menu_name: thẻ đóng html của tên menu
*/
function _eb_echbay_menu( $slug, $menu = array(), $in_cache = 1, $tag_menu_name = '', $tag_close_menu_name = '</div>' ) {
//	global $wpdb;
	global $menu_cache_locations;
	
	/*
	$strCacheFilter = 'menu-' . $slug;
	
	//
	if ( $in_cache == 0 ) {
		$a = false;
	} else {
		$a = _eb_get_static_html ( $strCacheFilter );
	}
	
	//
	if ( $a == false ) {
		*/
		
		// mặc định mọi menu đều dùng UL và class cf
		$menu['container'] = 'ul';
		
		//
		$menu['theme_location'] = $slug;
		$menu['container_class'] = $slug;
		$menu['echo'] = false;
//		$menu['show_home'] = true;
		
		// mặc định là thêm cf vào để có thể float cho menu
		if ( ! isset ( $menu['menu_class'] ) ) {
			$menu['menu_class'] = 'cf';
		}
		$menu['menu_class'] .= ' eb-set-menu-selected ' . $slug;
		
		// lấy tên menu nếu có yêu cầu
		$menu_name = '';
		if ( $tag_menu_name != '' ) {
//			$menu_cache_locations = get_nav_menu_locations();
//			print_r($menu_cache_locations);
			
			if ( isset($menu_cache_locations[ $slug ]) ) {
				$menu_obj = wp_get_nav_menu_object( $menu_cache_locations[ $slug ] );
//				print_r($menu_obj);
				
				if ( isset( $menu_obj->name ) ) {
					$menu_name = $tag_menu_name . $menu_obj->name . $tag_close_menu_name;
				}
			}
		}
		
		$a = $menu_name . wp_nav_menu( $menu );
		
		// xóa các ID và class trong menu
		$a = preg_replace('/ id=\"menu-item-(.*)\"/iU', '', $a );
		$a = preg_replace('/ class=\"menu-item (.*)\"/iU', '', $a );
		
		// xóa ký tự đặc biệt khi rút link category
		$a = str_replace( '/./', '/', $a );
//		$a = str_replace( '/category/', '/', $a );
		$a = str_replace( 'xwatch.echbay.com/', 'xwatch.vn/', $a );
		
		/*
		_eb_get_static_html ( $strCacheFilter, $a );
	}
	*/
	
	return '<!-- menu slug: ' . $slug . ' -->' . $a;
}

// load menu theo số thứ tự tăng dần
$i_echbay_top_menu = 0;
function EBE_echbay_top_menu ( $menu = array(), $in_cache = 1, $tag_menu_name = '', $tag_close_menu_name = '</div>' ) {
	global $i_echbay_top_menu;
	
	$i_echbay_top_menu++;
	if ( $i_echbay_top_menu > 6 ) {
		$i_echbay_top_menu = 6;
	}
	
	return _eb_echbay_menu(
		'top-menu-0' . $i_echbay_top_menu,
		$menu,
		$in_cache,
		$tag_menu_name,
		$tag_close_menu_name
	);
}

$i_echbay_footer_menu = 0;
function EBE_echbay_footer_menu ( $menu = array(), $in_cache = 1, $tag_menu_name = '', $tag_close_menu_name = '</div>' ) {
	global $i_echbay_footer_menu;
	
	$i_echbay_footer_menu++;
	if ( $i_echbay_footer_menu > 6 ) {
		$i_echbay_footer_menu = 6;
	}
	
	return _eb_echbay_menu(
		'footer-menu-0' . $i_echbay_footer_menu,
		$menu,
		$in_cache,
		$tag_menu_name,
		$tag_close_menu_name
	);
}


/*
* https://codex.wordpress.org/Function_Reference/dynamic_sidebar
*/
function _eb_echbay_get_sidebar( $slug ) {
	global $arr_for_show_html_file_load;
	
	$arr_for_show_html_file_load[] = '<!-- sidebar: ' . $slug . ' -->';
	
	ob_start();
	
	dynamic_sidebar($slug);
	
	$a = ob_get_contents();
	
	/*
	ob_clean();
	ob_end_flush();
	*/
	ob_end_clean();
	
	return trim( $a );
	
}

function _eb_echbay_sidebar( $slug, $css = '', $div = 'div', $in_cache = 1, $load_main_sidebar = 1, $return_null = 0 ) {
	global $arr_for_show_html_file_load;
	
	/*
	$strCacheFilter = 'sidebar-' . $slug;
	
	//
	if ( $in_cache == 0 ) {
		$a = false;
	} else {
		$a = _eb_get_static_html ( $strCacheFilter );
	}
	
	//
	if ( $a == false ) {
		*/
		
		//
		$a = _eb_echbay_get_sidebar( $slug );
		
		// xóa ký tự đặc biệt khi rút link category
		if ( $a == '' ) {
			$a = '<!-- Sidebar ' . $slug . ' is NULL -->';
			$arr_for_show_html_file_load[] = $a;
			
			// cho phép load từ main sidebar nếu không có kết quả
			if ( $load_main_sidebar == 1
			// nếu không phải sidebar mặc định -> lấy sidebar mặc định luôn
			&& $slug != id_default_for_get_sidebar ) {
				$a = _eb_echbay_sidebar( id_default_for_get_sidebar, $css, $div, $in_cache );
			}
			else if ( $return_null == 1 ) {
				$a = '';
			}
		} else {
			$a = str_replace( '/./', '/', $a );
//			$a = str_replace( 'div-for-replace', $div, $a );
//			$a = str_replace( 'class-sidebar-replace', $css, $a );
			
			//
//			$a = '<ul class="sidebar-' . $slug . ' eb-sidebar-global-css ' . $css . '">' . $a . '</ul>';
			$a = '<div class="sidebar-' . $slug . ' eb-sidebar-global-css ' . $css . '">' . $a . '</div>';
		}
		
		/*
		_eb_get_static_html ( $strCacheFilter, $a );
	}
	*/
	
	return $a;
}


function _eb_q ($str) {
	global $wpdb;
	
//	echo $str . '<br>' . "\n";
	
	return $wpdb->get_results( $str, OBJECT );
}

function _eb_full_url () {
	return '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}


// Lưu log error vào file
function _eb_log_file ($str) {
	$_file = EB_THEME_CACHE . 'error_log';
	
	// Nếu file ko tồn tại -> thử cho ra thư mục gốc
	if ( !file_exists($_file) ) {
		_eb_create_file( $_file, 1 );
//			$_file = '../' .$_file;
	}
	
	// Nếu vẫn không tồn tại -> hủy
	if ( !file_exists($_file) ) {
		die( 'error_log not found' );
	}
	
	// Đưa nội dung log về 1 dòng
	$str = _eb_del_line( $str );
//		echo $str . '<br />';
	
	// lưu log
	error_log( date( '[d-m-Y H:i:s]', date_time ). '; IP: ' ._eb_i(). '. MYSQL Warning: ' .$str. " --------------------> URL: " ._eb_full_url(). "\n", 3, $_file );
	
	echo '<p>#44 error.</p>';
}


//
function _eb_sd($arr, $tbl) {
	$str0 = '';
	$str1 = '';
	
	foreach ( $arr as $k => $v ) {
		$str0 .= ',' . $k;
		$str1 .= ',';
		$str1 .= "'" . $v . "'";
	}
	
	$str0 = substr ( $str0, 1 );
	$str1 = substr ( $str1, 1 );
	
	_eb_q ( "INSERT INTO
	" . $tbl . "
	( " . $str0 . " )
	VALUES
	( " . $str1 . " )" );
}
function _eb_set_data($arr, $tbl) {
	return _eb_sd ( $arr, $tbl );
}




/*
* Chức năng lấy dữ liệu trong cache
*/
// https://www.smashingmagazine.com/2012/06/diy-caching-methods-wordpress/
function _eb_get_static_html($f, $c = '', $file_type = '', $cache_time = 0, $dir_cache = EB_THEME_CACHE) {
	global $__cf_row;
	
	if ($cache_time == 0) {
		$cache_time = $__cf_row['cf_reset_cache'];
	}
//	echo $cache_time . '<br>';
	
	
	if ($cache_time == 0 || $f == '') {
		return false;
	}
	
	
	if (strlen ( $f ) > 155) {
		$f = md5 ( $f );
	}
	
	
	if ( $file_type == '' ) {
		$file_type = '.txt';
	}
	$f = $dir_cache . $f . $file_type;
//	echo $f . '<br>';
	
	
	// lưu nội dung file nếu có
	if ($c != '') {
		_eb_create_file ( $f, $c );
	} else if (file_exists ( $f )) {
		$time_file = filemtime ( $f );
		
		if ( $time_file + $cache_time + rand ( 0, 20 ) > date_time ) {
			return file_get_contents ( $f, 1 );
		}
	}
	
	return false;
}

// xóa file cache đã được tạo ra
function _eb_remove_static_html($f, $file_type = '.txt') {
	$f = EB_THEME_CACHE . $f . $file_type;
	
	if ( file_exists( $f ) ) {
		unlink( $f );
	}
}



function _eb_check_email_type($e_mail = '') {
	if ( $e_mail == '' || ! is_email($e_mail) ) {
		return 0;
	}
	return 1;
	
	//
	/*
	$r = 0;
	if ($e_mail != '') {
		$arr = explode ( '@', $e_mail );
		if (count ( $arr ) == 2) {
			$arr2 = explode ( '.', $arr [1] );
			if (count ( $arr2 ) > 1) {
				$r = 1;
			}
		}
		if ($r == 0) {
			if (preg_match ( '/^([a-z]|[0-9]|\.|-|_){2,32}@([a-z]|[0-9]|\.|-|_)+\.([a-z]|[0-9]){2,4}(\.+\w+)?$/i', $e_mail )) {
				$r = 1;
			}
		}
	}
	return $r;
	*/
}


function _eb_mdnam($str) {
	$str = md5($str);
	$str = substr($str, 2, 6);
	return md5($str);
}

// function tạo chuỗi vô định bất kỳ cho riêng mềnh
function _eb_code64 ($str, $code) {
	// chuỗi để tọa ra một chuỗi vô định bất kỳ ^^! chả để làm gì
	$hoc_code = str_split('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM');
	// bắt đầu tạo chuỗi
	if ($code == 1) {
		// cắt chuỗi thành từng ký tự 1
		$arr = str_split($str);
		$str = '';
		// chạy vòng lặp để nhúng ký tự linh ta linh tinh vào chơi chơi
		foreach ($arr as $v) {
			$str .= $v . $hoc_code[rand(0, count($hoc_code) - 1)];
		}
		// mã hóa chuỗi trc khi trả về
		return base64_encode($str);
	}
	// lật chuỗi
	else {
		// bỏ mã hóa chuỗi
		$str = base64_decode($str);
		// cắt chuỗi thành từng ký tự
		$arr = str_split($str);
		$str = '';
		// chạy vòng lặp và lấy chuỗi theo vị trí xác định
		foreach ($arr as $k => $v) {
			if ($k % 2 == 0) {
				$str .= $v;
			}
		}
		return $str;
	}
}



function _eb_postmeta ( $id, $key, $val ) {
//		echo $id . "<br>\n";
//		echo $key . "<br>\n";
//		echo $val . "<br>\n";
	
	// kiểm tra trùng lặp
//		add_post_meta( $id, $key, $val, true );
	
	// bỏ qua kiểm tra
	add_post_meta( $id, $key, $val );
}




// cấu trúc để phân định option của EchBay với các mã khác (sợ trùng)
define( '_eb_option_prefix', '_eb_' );

//
function _eb_set_config($key, $val) {
	
//	global $wpdb;
	
//	_eb_postmeta( eb_config_id_postmeta, $key, $val );
//	update_post_meta( eb_config_id_postmeta, $key, $val );
	
	// sử dụng option thay cho meta_post -> load nhanh hơn nhiều
	$key = _eb_option_prefix . $key;
	
	// xóa option cũ đi cho đỡ lằng nhằng
	delete_option( $key );
	
	//
	$val = stripslashes( stripslashes( stripslashes( $val ) ) );
	
	// thêm option mới
//	if ( get_option( $key ) == false ) {
		/*
		$sql = "INSERT INTO `" . $wpdb->options . "`
		( option_name, option_name, option_name )
		VALUES
		()";
		*/
		add_option( $key, $val, '', 'no' );
//		add_option( $key, $val );
	/*
	}
	else {
		update_option( $key, $val, 'no' );
//		update_option( $key, $val );
	}
	*/
	
}

//function _eb_get_config( $real_time = false ) {
//}

function _eb_get_config_v3( $real_time = false ) {
	
	global $wpdb;
	global $__cf_row;
	global $__cf_row_default;
//	print_r( $__cf_row );
//	print_r( $__cf_row_default );
//	echo count( $__cf_row_default ) . '<br>' . "\n";
	
	
	//
	$row = _eb_q("SELECT option_value
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name = '" . eb_conf_obj_option . "'
	LIMIT 1");
//	print_r( $row );
	
	// nếu có dữ liệu trả về -> database đã lên bản mới nhất
	if ( isset( $row[0] ) && isset( $row[0]->option_value ) ) {
		
		// chuyển từ dạng chuỗi sang dạng mảng
		$row = maybe_unserialize( $row[0]->option_value );
//		print_r( $row );
		
//		$row = get_option( eb_conf_obj_option );
//		print_r( $row );
		
//		wp_parse_str( $row[0]->option_value, $row );
//		print_r( $row );
		
		//
		foreach ( $row as $k => $v ) {
			if ( isset( $__cf_row_default[ $k ] ) ) {
				if ( $v == '' ) {
					$v = $__cf_row_default[ $k ];
				}
				$__cf_row[ $k ] = stripslashes( stripslashes( stripslashes( $v ) ) );
			}
		}
//		print_r( $__cf_row );
	}
	// nếu chưa có -> load theo v2 và đồng bộ cho v3 luôn
	/*
	else {
		_eb_get_config_v2();
	}
	*/
}



function _eb_get_config( $real_time = false ) {
	
	global $wpdb;
	global $__cf_row;
	global $__cf_row_default;
//	print_r( $__cf_row );
//	print_r( $__cf_row_default );
//	echo count( $__cf_row_default ) . '<br>' . "\n";
	
		
	
	/*
	* đồng bộ phiên bản code cũ với code mới -> 1 thời gian sẽ bỏ chức năng này đi
	*/
	if ( get_option( _eb_option_prefix . 'cf_web_version' ) == false ) {
//		echo 1;
		
		$row = _eb_q("SELECT *
		FROM
			`" . wp_postmeta . "`
		WHERE
			post_id = " . eb_config_id_postmeta);
//		print_r( $row );
		foreach ( $row as $k => $a ) {
			_eb_set_config( $a->meta_key, $a->meta_value );
		}
		
		// xóa cấu hình cũ
		_eb_q("DELETE
			FROM
				`" . wp_postmeta . "`
			WHERE
				post_id = " . eb_config_id_postmeta);
	}
//	exit();
	
	
	//
	$option_conf_name = _eb_option_prefix . 'cf_';
	
	$row = _eb_q("SELECT option_name, option_value
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name LIKE '{$option_conf_name}%'");
//	print_r( $row ); exit();
	
	//
	if ( count( $row ) == 0 ) {
		_eb_get_config_v3();
		
		foreach ( $__cf_row as $k => $a ) {
			_eb_set_config( $k, $a );
		}
		
		return true;
	}
	
	
	// chuyển sang kiểu dữ liệu còn mới hơn nữa
//	$arr_for_update_eb_config = array();
	
	//
	foreach ( $row as $k => $a ) {
		$a->option_name = str_replace( _eb_option_prefix, '', $a->option_name );
//		echo $a->option_name . '<br>' . "\n";
		
//		if ( isset( $__cf_row_default[ $a->option_name ] ) && $a->option_value == '' ) {
		if ( isset( $__cf_row_default[ $a->option_name ] ) ) {
			if ( $a->option_value == '' ) {
				$a->option_value = $__cf_row_default[ $a->option_name ];
			}
			$__cf_row[ $a->option_name ] = stripslashes( stripslashes( stripslashes( $a->option_value ) ) );
//			$__cf_row[ $a->option_name ] = $a->option_value;
			
			//
//			$arr_for_update_eb_config[ $a->option_name ] = addslashes( $__cf_row[ $a->option_name ] );
		}
//		$__cf_row[ $a->option_name ] = stripslashes( $a->option_value );
	}
//	print_r( $__cf_row );
	
	// xóa config cũ đi -> tránh cache lưu lại
//	delete_option( eb_conf_obj_option );
	
	// lưu cấu hình mới dưới dạng object
//	add_option( eb_conf_obj_option, $arr_for_update_eb_config, '', 'no' );
	
	
	// mọi option đều phải dựa vào mảng cấu hình mặc định -> lệch phát bỏ qua luôn
	/*
	foreach ( $__cf_row_default as $k => $v ) {
		$a = get_option( _eb_option_prefix . $k );
		
		//
		if ( $a == false ) {
			$__cf_row[ $k ] = $__cf_row[ $k ];
		}
		else {
			$__cf_row[ $k ] = stripslashes( $a );
		}
	}
	*/
	
}

function _eb_get_config_v1 ( $real_time = false ) {
	
	global $__cf_row;
	global $__cf_row_default;
//	print_r( $__cf_row );
//	print_r( $__cf_row_default );
	
	//
	$row = _eb_q("SELECT *
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . eb_config_id_postmeta);
//	print_r( $row );
	
	// gán lại giá trị cho bảng config (nếu có, không thì sử dụng giá trị mặc định)
//	if ( $real_time == false ) {
		foreach ( $row as $k => $a ) {
			if ( isset( $__cf_row_default[ $a->meta_key ] ) && $a->meta_value == '' ) {
				$a->meta_value = $__cf_row_default[ $a->meta_key ];
			}
			$__cf_row[ $a->meta_key ] = stripslashes( $a->meta_value );
		}
		/*
	}
	else {
		foreach ( $row as $k => $a ) {
			if ( isset( $__cf_row[ $a->meta_key ] ) ) {
				$__cf_row[ $a->meta_key ] = stripslashes( $a->meta_value );
			}
		}
	}
	*/
//	print_r( $__cf_row );
	
}




function _eb_log_click($m) {
	return false;
	
	_eb_postmeta( eb_log_click_id_postmeta, '__eb_log_click', $m );
}
function _eb_get_log_click( $limit = '' ) {
	return _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		post_id = " . eb_log_click_id_postmeta . "
		AND meta_key = '__eb_log_click'
	ORDER BY
		meta_id DESC
	" . $limit);
}

function _eb_log_user($m) {
	return false;
	
	$m .= ' (at ' . date( 'r', date_time ) . ')';
	
	_eb_postmeta( eb_log_user_id_postmeta, '__eb_log_user', $m );
}
function _eb_get_log_user( $limit = '' ) {
	return _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		post_id = " . eb_log_user_id_postmeta . "
		AND meta_key = '__eb_log_user'
	ORDER BY
		meta_id DESC
	" . $limit);
}

function _eb_log_admin($m) {
	return false;
	
	$m .= ' (by ' . mtv_email . ' at ' . date( 'r', date_time ) . ')';
//		echo $m . "\n";
	
	_eb_postmeta( eb_log_user_id_postmeta, '__eb_log_admin', $m );
}
function _eb_get_log_admin( $limit = '' ) {
	return _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		post_id = " . eb_log_user_id_postmeta . "
		AND meta_key = '__eb_log_admin'
	ORDER BY
		meta_id DESC
	" . $limit);
}

function _eb_log_admin_order($m, $order_id) {
	return false;
	
	_eb_postmeta( eb_log_user_id_postmeta, '__eb_log_invoice' . $order_id, $m );
}
function _eb_get_log_admin_order( $order_id, $limit = '' ) {
	return _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		post_id = " . eb_log_user_id_postmeta . "
		AND meta_key = '__eb_log_invoice" . $order_id . "'
	ORDER BY
		meta_id DESC
	" . $limit);
}

function _eb_log_search($m) {
	return false;
	
	_eb_postmeta( eb_log_search_id_postmeta, '__eb_log_search', $m );
}
function _eb_get_log_search( $limit = '' ) {
	return _eb_q("SELECT *
	FROM
		" . wp_postmeta . "
	WHERE
		post_id = " . eb_log_search_id_postmeta . "
		AND meta_key = '__eb_log_search'
	ORDER BY
		meta_id DESC
	" . $limit);
}







function _eb_non_mark_seo($str) {
	
	/*
	$unicode = array(
		'a' => array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ','Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),
		'd' => array('đ','Đ'),
		'e' => array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ','É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),
		'i' => array('í','ì','ỉ','ĩ','ị', 'Í','Ì','Ỉ','Ĩ','Ị'),
		'o' => array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),
		'u' => array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự','Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),
		'y' => array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'-' => array(' ','~','`','!','@','#','$','%','^','&','*','(',')','=','[',']','{','}','\\','|',';',':','\'','"',',','<','>','/','?')
	);
	foreach ($unicode as $nonUnicode=>$uni) {
		foreach ($uni as $v) {
			$str = str_replace($v,$nonUnicode,$str);
		}
	}
	*/
	
	//
	$str = _eb_non_mark ( $str );
	
//	$str = urlencode($str);
	// thay thế 2- thành 1-  
	$str = preg_replace( '/-+-/', "-", $str );
	
	// cắt bỏ ký tự - ở đầu và cuối chuỗi
	$str = preg_replace( '/^\-+|\-+$/', "", $str );
	
	//
	$str = _eb_text_only( $str );
	
	//
	return strtolower($str);
	
}

function _eb_non_mark($str) {
	
	$unicode = array(
		'a' => array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ'),
		'A' => array('Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),
		'd' => array('đ'),
		'D' => array('Đ'),
		'e' => array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ'),
		'E' => array('É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),
		'i' => array('í','ì','ỉ','ĩ','ị'),
		'I' => array('Í','Ì','Ỉ','Ĩ','Ị'),
		'o' => array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ'),
		'O' => array('Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),
		'u' => array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự'),
		'U' => array('Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),
		'y' => array('ý','ỳ','ỷ','ỹ','ỵ'),
		'Y' => array('Ý','Ỳ','Ỷ','Ỹ','Ỵ')
	 );
	 foreach ($unicode as $nonUnicode=>$uni) {
		foreach ($uni as $v)
			$str = str_replace($v,$nonUnicode,$str);
	 }
	 return $str;
	 
}




function _eb_build_mail_header($from_email) {
	$headers = array();
	
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
//	$headers[] = 'Date: ' . gmdate('d M Y H:i:s Z', NOW);
	$headers[] = 'From: ' . web_name .' <'. $from_email . '>';
	$headers[] = 'Reply-To: <'. $from_email . '>';
	$headers[] = 'Auto-Submitted: auto-generated';
	$headers[] = 'Return-Path: <'. $from_email . '>';
	$headers[] = 'X-Sender: <'. $from_email . '>'; 
	$headers[] = 'X-Priority: 3';
	$headers[] = 'X-MSMail-Priority: Normal';
	$headers[] = 'X-MimeOLE: Produced By xtreMedia';
	$headers[] = 'X-Mailer: PHP/ '. phpversion();
	
	return implode ( "\r\n", $headers );
}

function _eb_lnk_block_email ($em) {
	return web_link . 'block_email&e=' .base64_encode( $em ). '&c=' . _eb_mdnam( $em );
}

function _eb_send_email($to_email, $title, $message, $headers = '', $bcc_email = '', $add_domain = 1) {
	global $year_curent;
	global $__cf_row;
	
	
	//
	$chost = str_replace( ':', '.', str_replace( 'www.', '',  $_SERVER['HTTP_HOST'] ) );
	
	
	//
	if ( $add_domain == 1 ) {
		$title = '[' . $chost . '] ' . $title;
	}

	
	//
	if ($__cf_row ['cf_sys_email'] == 1) {
		return _eb_send_mail_phpmailer ( $to_email, '', $title, $message, '', $bcc_email );
	}
	
	
	//
	if ($headers == '') {
		/*
		if ( $__cf_row['cf_email_note'] != '' ) {
			$headers = _eb_build_mail_header ( $__cf_row['cf_email_note'] );
		} else if ( $__cf_row['cf_email'] != '' ) {
			$headers = _eb_build_mail_header ( $__cf_row['cf_email'] );
		} else {
			*/
			$headers = _eb_build_mail_header ( 'noreply@' . $chost );
			/*
		}
		*/
	}
	
	
	//
	$message = _eb_del_line( EBE_str_template ( 'html/mail/mail.html', array (
			'tmp.message' => $message,
			
			'tmp.web_name' => web_name,
			'tmp.web_link' => web_link,
			'tmp.web_host' => $_SERVER['HTTP_HOST'],
			
			'tmp.block_email' => _eb_lnk_block_email( $to_email ),
			
			'tmp.year_curent' => $year_curent,
			'tmp.cf_ten_cty' => $__cf_row['cf_ten_cty'],
			'tmp.to_email' => $to_email,
			'tmp.captcha' => _eb_mdnam ( $to_email ) 
	), EB_THEME_PLUGIN_INDEX ) );
//	echo $to_email.'<hr>'; echo $message; exit();
	
	
	// sử dụng hame mail mặc định
	/*
	if ( mail ( $to_email, $title, $message, $headers )) {
		if ( $bcc_email != '' ) {
			mail ( $bcc_email, $title, $message, $headers );
		}
		
		return true;
	}
	*/
	
	
	//
	if ($bcc_email != '') {
		$bcc_email = explode( ',', $bcc_email );
		foreach ( $bcc_email as $v ) {
			$v = trim( $v );
			
			if ( $v != '' && _eb_check_email_type( $v ) == 1 ) {
				$headers .= "\r\n" . 'BCC: ' . $v;
			}
		}
	}
	
	
	// sử dụng wordpress mail
	$mail = wp_mail( $to_email, $title, $message, $headers );
	if( $mail ) {
		return true;
	}
	
	//
	return false;
}

function _eb_send_mail_phpmailer($to, $to_name = '', $subject, $message, $from_reply = '', $bcc_email = '') {
//	global $dir_index;
	global $__cf_row;
	
	//
//	set_time_limit( 10 );
	
	//
//	$mail = new PHPMailer ();
	
	//
	$cf_email = $__cf_row ['cf_email'];
	if ( $cf_email == '' ) {
		$cf_email = 'root@' . str_replace( 'www.', '', $_SERVER ['HTTP_HOST'] );
	}
	
	if ($to == '' || _eb_check_email_type ( $to ) == false) {
		return false;
	}
	if ($to_name == '') {
		$to_name = explode ( '@', $to );
		$to_name = $to_name [0];
	}
	
	/*
	* Send email version3
	*/
	$mail_via_eb = new mailViaEchBay ();
	
	//
	$a = $mail_via_eb->send( array(
		'to' => $to,
		'to_name' => $to_name,
		'bcc' => $bcc_email,
		
		'subject' => $subject,
		'content' => $message,
		
		'host' => $_SERVER['HTTP_HOST'],
		
		// gửi qua smpt riêng (nếu có)
		'smtp_host' => $__cf_row ['cf_smtp_host'],
		'smtp_email' => $__cf_row ['cf_smtp_email'],
		'smtp_pass' => $__cf_row ['cf_smtp_pass'],
		'smtp_port' => $__cf_row ['cf_smtp_port'],
		
		'from' => $cf_email,
		'from_name' => web_name,
		'from_reply' => $from_reply == '' ? $cf_email : $from_reply,
	) );
	
	// nếu có lỗi
	if ( $a != 1 ) {
		// gửi lại bằng hàm mail thông thường
		$__cf_row ['cf_sys_email'] = 0;
		
		_eb_send_email($to, $subject, $message, '', $bcc_email, 0 );
		
		// trả về lỗi
		return $a;
	}
	return true;
}



function _eb_ssl_template ($c) {
	if ( eb_web_protocol != 'https' ) {
		return $c;
	}
	
	//
	$host = str_replace( 'www.', '', $_SERVER ['HTTP_HOST'] ) . '/';
	
	// Không replace thẻ A
	$c = str_replace( ' href="http://' . $host, ' href="//' . $host, $c );
	$c = str_replace( ' href="http://www.' . $host, ' href="//www.' . $host, $c );
	
	// -> chuyển các url khác về dạng tương đối
	$c = str_replace( 'http://' . $host, '', $c );
	$c = str_replace( 'http://www.' . $host, '', $c );
	
	//
	return $c;
	
}






/*
* https://codex.wordpress.org/Class_Reference/WP_Query
* https://gist.github.com/thachpham92/d57b18cf02e3550acdb5
*/
function _eb_load_ads_v2 ( $type = 0, $posts_per_page = 20, $_eb_query = array(), $op = array() ) {
	if ( ! isset( $op['offset'] ) ) {
		$op['offset'] = 0;
	}
	if ( ! isset( $op['html'] ) ) {
		$op['html'] = '';
	}
	if ( ! isset( $op['data_size'] ) ) {
		$op['data_size'] = 1;
	}
	
	return _eb_load_ads( $type, $posts_per_page, $op['data_size'], $_eb_query, $op['offset'], $op['html'] );
}

function _eb_load_ads ( $type = 0, $posts_per_page = 20, $data_size = 1, $_eb_query = array(), $offset = 0, $html = '' ) {
	global $__cf_row;
	global $arr_eb_ads_status;
	global $eb_background_for_post;
//		global $___eb_ads__not_in;
//		echo 'ADS NOT IN: ' . $___eb_ads__not_in . '<br>' . "\n";
	
	//
//		print_r($_eb_query);
//		$strCacheFilter = '';
	/* v1
	foreach ( $_eb_query as $k => $v ) {
		$strCacheFilter .= '-' . $k;
		
		if ( gettype($v) == 'array' ) {
//				print_r($v);
			
			//
			foreach ( $v as $k2 => $v2 ) {
				if ( gettype($v2) == 'array' ) {
					$strCacheFilter .= implode ( '-', $v2 );
				} else {
					$strCacheFilter .= '-' . $k2;
				}
			}
		}
	}
	*/
	// v2
	/*
	if ( $___eb_ads__not_in != '' ) {
		$strCacheFilter .= $___eb_ads__not_in;
	}
	*/
	
	
	// nếu có thuộc tính in_cat, mà giá trị trống -> lấy các q.cáo trong nhóm hiện tại
	if ( isset($_eb_query['category__in']) && $_eb_query['category__in'] == '' ) {
		$_eb_query['category__in'] = array();
		
		$categories = get_the_category();
//			print_r($categories);
		
		foreach ( $categories as $k => $v ) {
			$_eb_query['category__in'][] = $v->term_id;
//				$strCacheFilter .= $v->term_id;
		}
	}
	
	// nếu có thuộc tính not_in_cat, mà giá trị trống -> chỉ lấy các q.cáo không có nhóm
	if ( isset($_eb_query['category__not_in']) && $_eb_query['category__not_in'] == '' ) {
		$_eb_query['category__not_in'] = array();
		
//			$categories = get_the_category();
//			print_r($categories);
		
		$categories = get_categories( array(
//				'hide_empty' => 0,
		) );
//			print_r($categories);
		
		foreach ( $categories as $k => $v ) {
			$_eb_query['category__not_in'][] = $v->term_id;
//				$strCacheFilter .= $v->term_id;
		}
	}
	
	
	/*
	if ( $strCacheFilter != '' ) {
		$strCacheFilter = md5($strCacheFilter);
	}
	
	
//		$strCacheFilter = 'ads' . $type . implode ( '-', $_eb_query );
	$strCacheFilter = 'ads' . $type . $strCacheFilter;
//		echo $strCacheFilter . '<br>' . "\n";
	$str = _eb_get_static_html ( $strCacheFilter );
	if ($str == false) {
		*/
		
		// lọc các sản phẩm trùng nhau
		/*
		if ( $___eb_ads__not_in != '' ) {
			$_eb_query['post__not_in'] = explode( ',', substr( $___eb_ads__not_in, 1 ) );
		}
		*/
		
		//
		$arr['post_type'] = 'ads';
		
		//
		$arr['meta_key'] = '_eb_ads_status';
		$arr['meta_value'] = $type;
		
		$arr['offset'] = $offset;
//			$arr['offset'] = 0;
		$arr['posts_per_page'] = $posts_per_page;
		
		$arr['orderby'] = 'menu_order ID';
		$arr['order'] = 'DESC';
		
		$arr['post_status'] = 'publish';
		
		//
		foreach ( $_eb_query as $k => $v ) {
			$arr[$k] = $v;
		}
//			print_r( $_eb_query );
//			print_r( $arr );
		
		//
		$sql = new WP_Query( $arr );
		
		//
		/*
		if ( $result_type == 'obj' ) {
			return $sql;
		}
		*/
		
		//
		if ( $html == '' ) {
			$html = EBE_get_page_template( 'ads_node' );
		}
		
		//
		$str = '';
		
		//
		while ( $sql->have_posts() ) {
			
			$sql->the_post();
//				print_r( $sql );
			
			$post = $sql->post;
//				print_r( $post );
			
			//
//				$___eb_ads__not_in .= ',' . $post->ID;
			
			//
			$p_link = _eb_get_post_meta( $post->ID, '_eb_ads_url', true, 'javascript:;' );
//			$p_link = _eb_get_ads_object( $post->ID, '_eb_ads_url', 'javascript:;' );
//			echo $p_link . '<br>';
			
			// lấy ảnh từ bài viết
			$trv_img = _eb_get_post_img( $post->ID, $__cf_row['cf_ads_thumbnail_size'] );
			if ( $__cf_row['cf_product_thumbnail_table_size'] == $__cf_row['cf_product_thumbnail_size'] ) {
				$trv_table_img = $trv_img;
			} else {
				$trv_table_img = _eb_get_post_img( $post->ID, $__cf_row['cf_product_thumbnail_table_size'] );
			}
			if ( $__cf_row['cf_product_thumbnail_mobile_size'] == $__cf_row['cf_product_thumbnail_table_size'] ) {
				$trv_mobile_img = $trv_table_img;
			} else {
				$trv_mobile_img = _eb_get_post_img( $post->ID, $__cf_row['cf_product_thumbnail_mobile_size'] );
			}
			
			//
			$youtube_id = _eb_get_youtube_id( _eb_get_post_meta( $post->ID, '_eb_ads_video_url' ) );
//			$youtube_id = _eb_get_youtube_id( _eb_get_ads_object( $post->ID, '_eb_ads_video_url' ) );
			$youtube_url = '';
			$youtube_avt = '';
			if ( $youtube_id != '' ) {
//				$youtube_url = '//www.youtube.com/watch?v=' . $youtube_id;
				$youtube_url = '//www.youtube.com/embed/' . $youtube_id;
				$youtube_avt = '//i.ytimg.com/vi/' . $youtube_id . '/0.jpg';
			}
			
			
			/*
			//
			$str .=  EBE_arr_tmp( array(
				'post_title' => $post->post_title,
				
				'youtube_id' => $youtube_id,
				'youtube_url' => $youtube_url,
				'youtube_avt' => $youtube_avt,
				
				'p_link' => $p_link,
				'data_size' => $data_size,
				'trv_img' => $trv_img,
				'post_content' => $post->post_content,
				'post_excerpt' => $post->post_excerpt,
				
				//
				'trv_tieude' => $post->post_title,
				'trv_gioithieu' => $post->post_excerpt,
			), $html );
			*/
			
			//
			$post->youtube_id = $youtube_id;
			$post->youtube_url = $youtube_url;
			$post->youtube_avt = $youtube_avt;
			$post->p_link = $p_link;
			$post->data_size = $data_size;
			
			//
			$post->trv_img = $trv_img;
			$post->trv_mobile_img = $trv_mobile_img;
			$post->trv_table_img = $trv_table_img;
			
			//
			/*
			if ( $post->trv_mobile_img != '' ) {
				$post->trv_mobile_img = 'background-image:url(' . $post->trv_mobile_img . ')!important';
			}
			if ( $post->trv_img != '' ) {
				$post->trv_img = 'background-image:url(' . $post->trv_img . ')!important';
			}
			$eb_background_for_post['p' . $post->ID] = '.ebp' . $post->ID . 'm{' . $post->trv_mobile_img . '}.ebp' . $post->ID . '{' . $post->trv_img . '}';
			$post->trv_img = 'speed';
			$post->trv_mobile_img = 'ebp' . $post->ID;
			*/
			
			//
			$post->trv_tieude = $post->post_title;
			$post->trv_gioithieu = $post->post_excerpt;
			
			//
			$str .=  EBE_arr_tmp( $post, $html );
		
		}
		
		//
		wp_reset_postdata();
		
		//
		if ( $str != '' ) {
			$str = '<!-- Banner ads status: ' . $type . ' - ' . $arr_eb_ads_status[ $type ] . ' --> <ul class="cf global-ul-load-ads">' . $str . '</ul>';
			/*
		} else {
			$str = '<i></i>';
			*/
		}
		
		//
		$str = str_replace( 'xwatch.echbay.com/', 'xwatch.vn/', $str );
		
		//
		/*
		_eb_get_static_html ( $strCacheFilter, $str );
		
	}
	*/
	
	//
	return $str;
}


function EBE_get_big_banner ( $limit = 5, $option = array () ) {
	global $__cf_row;
	
	//
	return _eb_load_ads(
		1,
		$limit,
		$__cf_row['cf_top_banner_size'],
		$option,
		0,
		'
<li title="{tmp.post_title}" class="global-a-posi"><a href="{tmp.p_link}">&nbsp;</a>
	<div data-size="{tmp.data_size}" data-img="{tmp.trv_img}" data-table-img="{tmp.trv_table_img}" data-mobile-img="{tmp.trv_mobile_img}" class="ti-le-global banner-ads-media" style="background-image:url({tmp.trv_img});">&nbsp;</div>
</li>'
	);
}


function _eb_load_post_obj ( $posts_per_page, $_eb_query ) {
	
	//
	$arr['post_type'] = 'post';
	$arr['posts_per_page'] = $posts_per_page;
//	$arr['orderby'] = 'menu_order';
	$arr['orderby'] = 'menu_order ID';
	$arr['order'] = 'DESC';
	$arr['post_status'] = 'publish';
	
	//
	foreach ( $_eb_query as $k => $v ) {
		$arr[$k] = $v;
	}
//	print_r( $_eb_query );
//	print_r( $arr );
	
	// https://codex.wordpress.org/Class_Reference/WP_Query
	return new WP_Query( $arr );
	
}

/*
* Load danh sách đơn hàng
*/
// tạo đơn hàng
function EBE_set_order ( $arr ) {
	_eb_sd( $arr, 'eb_in_con_voi' );
	
	// lấy ID trả về
	$strsql = _eb_q("SELECT *
	FROM
		`eb_in_con_voi`
	WHERE
		tv_id = " . $arr['tv_id'] . "
	ORDER BY
		order_id DESC
	LIMIT 0, 1" );
//	print_r( $strsql );
//	echo count($strsql);
	if ( count($strsql) > 0 ) {
		return $strsql[0]->order_id;
	}
	
	return 0;
}

// xóa chi tiết đơn hàng
function EBE_update_details_order ( $k, $id, $v = '' ) {
	_eb_q ( "DELETE
	FROM
		`eb_details_in_con_voi`
	WHERE
		order_id = " . $id . "
		AND dorder_key = '" . $k . "'" );
	
	// nếu có value mới -> add mới luôn
	if ( $v != '' ) {
		EBE_set_details_order( $k, $v, $id );
	}
}

// tạo chi tiết đơn hàng
function EBE_set_details_order ( $k, $v, $id ) {
	_eb_q ( "INSERT INTO
	`eb_details_in_con_voi`
	( dorder_key, dorder_name, order_id )
	VALUES
	( '" . $k . "', '" . $v . "', " . $id . " )" );
}

// danh sách đơn hàng
function _eb_load_order ( $posts_per_page = 68, $_eb_query = array() ) {
	
	//
//	print_r( $_eb_query );
	
	//
	$strFilter = "";
	$offset = 0;
	
	// lấy theo ID hóa đơn
	if ( isset( $_eb_query['offset'] ) ) {
		$offset = $_eb_query['offset'];
	}
	
	// lấy theo ID hóa đơn
	if ( isset( $_eb_query['p'] ) && $_eb_query['p'] > 0 ) {
		$strFilter .= " AND order_id = " . $_eb_query['p'];
	}
	
	// lấy theo trạng thái hóa đơn
	if ( isset( $_eb_query['status_by'] ) && $_eb_query['status_by'] != '' ) {
		$strFilter .= " AND order_status = " . $_eb_query['status_by'];
	}
	
	//
	$sql = _eb_q( "SELECT *
	FROM
		`eb_in_con_voi`
	WHERE
		tv_id > 0
		" . $strFilter . "
	ORDER BY
		order_id DESC
	LIMIT " . $offset . ", " . $posts_per_page );
//	print_r( $sql );
	
	return $sql;
	
}

function _eb_load_order_v1 ( $posts_per_page = 68, $_eb_query = array() ) {
	global $wpdb;
	
	//
//	print_r( $_eb_query );
	
	//
	$strFilter = "";
	if ( isset( $_eb_query['p'] ) && $_eb_query['p'] > 0 ) {
		$strFilter .= " AND ID = " . $_eb_query['p'];
	}
	
	//
	$sql = _eb_q( "SELECT *
	FROM
		" . $wpdb->posts . "
	WHERE
		post_type = 'shop_order'
		AND post_status = 'private'
		" . $strFilter . "
	ORDER BY
		ID DESC
	LIMIT 0, " . $posts_per_page );
//	print_r( $sql );
	
	return $sql;
	
	
	//
	/*
	$_eb_query['post_type'] = 'shop_order';
	$_eb_query['post_status'] = 'private';
	$_eb_query['orderby'] = 'ID';
	$_eb_query['order'] = 'DESC';
	
	return _eb_load_post_obj( $posts_per_page, $_eb_query );
	*/
}

/*
* https://codex.wordpress.org/Class_Reference/WP_Query
* posts_per_page: số lượng bài viết cần lấy
* _eb_query: gán giá trị để thực thi wordpres query
* html: mặc định là sử dụng HTML của theme, file thread_node.html, nếu muốn sử dụng HTML riêng thì truyền giá trị HTML mới vào
* not_set_not_in: mặc định là lọc các sản phẩm trùng lặp trên mỗi trang, nếu để bằng 1, sẽ bỏ qua chế độ lọc -> chấp nhận lấy trùng
*/
function _eb_load_post ( $posts_per_page = 20, $_eb_query = array(), $html = __eb_thread_template, $not_set_not_in = 0 ) {
	global $___eb_post__not_in;
//		echo 'POST NOT IN: ' . $___eb_post__not_in . '<br>' . "\n";
	
	// lọc các sản phẩm trùng nhau
	if ( $___eb_post__not_in != '' && $not_set_not_in == 0 ) {
		$_eb_query['post__not_in'] = explode( ',', substr( $___eb_post__not_in, 1 ) );
	}
	
	//
	$sql = _eb_load_post_obj( $posts_per_page, $_eb_query );
	
	//
//		if ( $_eb_query['post_type'] == 'blog' ) {
//			print_r( $sql );
//			print_r( $_eb_query );
//			exit();
//		}
	
	//
	$str = '';
	
	//
	while ( $sql->have_posts() ) {
		
		$sql->the_post();
//			the_content();
		
		//
		if ( $not_set_not_in == 0 ) {
			$___eb_post__not_in .= ',' . $sql->post->ID;
		}
		
		//
		$str .= EBE_select_thread_list_all( $sql->post, $html );
		
	}
	
	//
	wp_reset_postdata();
	
	return $str;
}






function _eb_checkPostServerClient() {
	if ($_SERVER ['REQUEST_METHOD'] != 'POST') {
		die ( '<h1>POST DIE</h1>' );
		exit ();
	}
	
	
	$checkPostServer = $_SERVER ['HTTP_HOST'];
	$checkPostServer = str_replace ( 'www.', '', $checkPostServer );
//		$checkPostServer = explode ( '/', $checkPostServer );
//		$checkPostServer = $checkPostServer [0];
	
	$checkPostClient = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : '';
	$checkPostClient = explode( '//', $checkPostClient );
	$checkPostClient = $checkPostClient[1];
	$checkPostClient = str_replace ( 'www.', '', $checkPostClient );
	$checkPostClient = explode ( '/', $checkPostClient );
	$checkPostClient = $checkPostClient [0];
	
	//
	if ( strtolower ( $checkPostServer ) != strtolower ( $checkPostClient ) ) {
		die ( '<h1>REFERER DIE</h1>' );
		exit ();
	}
	
	
	
	/*
	* xử lý an toàn cho chuỗi
	*/
	
	// kiểm tra get_magic_quotes_gpc đang bật hay tắt
	// Magic_quotes_gpc là 1 giá trị tùy chọn bật chế độ tự động thêm ký tự escape vào trước các ký tự đặc biệt như: nháy đơn ('), nháy kép ("), dấu backslash (\) khi nó đc POST hoặc GET từ client lên
	$magic_quotes = 0;
	if ( get_magic_quotes_gpc () ) {
		$magic_quotes = 1;
	}
	
	//
	foreach ( $_POST as $k => $v ) {
		if ( gettype( $v ) == 'string' ) {
			// nếu Magic_quotes_gpc đang tắt -> loại bỏ ký tự đặc biệt
//				if ( $magic_quotes == 1 ) {
//					$v = stripslashes ( $v );
//				}
			
			// nếu Magic_quotes_gpc đang tắt -> add dữ liệu an toàn thủ công vào
			if ( $magic_quotes == 0 ) {
				// xử lý an toàn cho chuỗi
				$v = addslashes ( $v );
				
				// mysqli_real_escape_string tương tự như addslashes, nhưng công việc sẽ do mysql xử lý
//					$str = mysqli_real_escape_string ( $str );
			}
			
			$_POST [$k] = $v;
		}
	}
	
	
	//
	return $_POST;
}



function _eb_checkDevice () {
	if ( wp_is_mobile() ) {
		return 'mobile';
	}
	// mặc định cho rằng đây là PC
	return 'pc';
}

function _eb_checkDevice_v1 () {
	if ( isset($_SERVER['HTTP_USER_AGENT']) ) {
		// lấy thông tin hệ điều hành của người dùng
		$_ebArrUAAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		// mảng các thiết bị mobile chuyên dụng
		$_ebArrMobi = array('midp', 'j2me', 'avantg', 'ipad', 'iphone', 'docomo', 'novarra', 'palmos', 'palmsource', '240x320', 'opwv', 'chtml', 'pda', 'windows ce', 'mmp/', 'mib/', 'symbian', 'wireless', 'nokia', 'hand', 'mobi', 'phone', 'cdm', 'up.b', 'audio', 'sie-', 'sec-', 'samsung', 'htc', 'mot-', 'mitsu', 'sagem', 'sony', 'alcatel', 'lg', 'erics', 'vx', 'nec', 'philips', 'mmm', 'xx', 'panasonic', 'sharp', 'wap', 'sch', 'rover', 'pocket', 'benq', 'java', 'pt', 'pg', 'vox', 'amoi', 'bird', 'compal', 'kg', 'voda', 'sany', 'kdd', 'dbt', 'sendo', 'sgh', 'gradi', 'jb', 'dddi', 'moto', 'opera mobi', 'opera mini', 'android');
		foreach ($_ebArrMobi as $k => $v) {
			// nếu không xác định được chuỗi
			if (strpos($_ebArrUAAgent, $v) === false) {
				// ~> bỏ qua ko làm gì cả
			}
			// nếu tìm được -> trả về thông tin rằng đây là thiết bị mobile
			else {
				return 'mobile';
				break;
			}
		}
	}
	// mặc định cho rằng đây là PC
	return 'pc';
}



function _eb_un_money_format($str) {
	return _eb_number_only( $str );
}



// Chuyển ký tự UTF-8 -> ra bảng mã mới
function _eb_str_block_fix_content ($str) {
//	$str = iconv('UTF-16', 'UTF-8', $str);
//	$str = mb_convert_encoding($str, 'UTF-8', 'UTF-16');
//	$str = mysqli_escape_string($str);
//	$str = htmlentities($str, ENT_COMPAT, 'UTF-16');
	// https://www.google.com/search?q=site:charbase.com+%E1%BB%9D#q=site:charbase.com+%E1%BA%A3
	$arr = array(
		'á' => '\u00e1',
		'à' => '\u00e0',
		'ả' => '\u1ea3',
		'ã' => '\u00e3',
		'ạ' => '\u1ea1',
		'ă' => '\u0103',
		'ắ' => '\u1eaf',
		'ặ' => '\u1eb7',
		'ằ' => '\u1eb1',
		'ẳ' => '\u1eb3',
		'ẵ' => '\u1eb5',
		'â' => '\u00e2',
		'ấ' => '\u1ea5',
		'ầ' => '\u1ea7',
		'ẩ' => '\u1ea9',
		'ẫ' => '\u1eab',
		'ậ' => '\u1ead',
		'Á' => '\u00c1',
		'À' => '\u00c0',
		'Ả' => '\u1ea2',
		'Ã' => '\u00c3',
		'Ạ' => '\u1ea0',
		'Ă' => '\u0102',
		'Ắ' => '\u1eae',
		'Ặ' => '\u1eb6',
		'Ằ' => '\u1eb0',
		'Ẳ' => '\u1eb2',
		'Ẵ' => '\u1eb4',
		'Â' => '\u00c2',
		'Ấ' => '\u1ea4',
		'Ầ' => '\u1ea6',
		'Ẩ' => '\u1ea8',
		'Ẫ' => '\u1eaa',
		'Ậ' => '\u1eac',
		'đ' => '\u0111',
		'Đ' => '\u0110',
		'é' => '\u00e9',
		'è' => '\u00e8',
		'ẻ' => '\u1ebb',
		'ẽ' => '\u1ebd',
		'ẹ' => '\u1eb9',
		'ê' => '\u00ea',
		'ế' => '\u1ebf',
		'ề' => '\u1ec1',
		'ể' => '\u1ec3',
		'ễ' => '\u1ec5',
		'ệ' => '\u1ec7',
		'É' => '\u00c9',
		'È' => '\u00c8',
		'Ẻ' => '\u1eba',
		'Ẽ' => '\u1ebc',
		'Ẹ' => '\u1eb8',
		'Ê' => '\u00ca',
		'Ế' => '\u1ebe',
		'Ề' => '\u1ec0',
		'Ể' => '\u1ec2',
		'Ễ' => '\u1ec4',
		'Ệ' => '\u1ec6',
		'í' => '\u00ed',
		'ì' => '\u00ec',
		'ỉ' => '\u1ec9',
		'ĩ' => '\u0129',
		'ị' => '\u1ecb',
		'Í' => '\u00cd',
		'Ì' => '\u00cc',
		'Ỉ' => '\u1ec8',
		'Ĩ' => '\u0128',
		'Ị' => '\u1eca',
		'ó' => '\u00f3',
		'ò' => '\u00f2',
		'ỏ' => '\u1ecf',
		'õ' => '\u00f5',
		'ọ' => '\u1ecd',
		'ô' => '\u00f4',
		'ố' => '\u1ed1',
		'ồ' => '\u1ed3',
		'ổ' => '\u1ed5',
		'ỗ' => '\u1ed7',
		'ộ' => '\u1ed9',
		'ơ' => '\u01a1',
		'ớ' => '\u1edb',
		'ờ' => '\u1edd',
		'ở' => '\u1edf',
		'ỡ' => '\u1ee1',
		'ợ' => '\u1ee3',
		'Ó' => '\u00d3',
		'Ò' => '\u00d2',
		'Ỏ' => '\u1ece',
		'Õ' => '\u00d5',
		'Ọ' => '\u1ecc',
		'Ô' => '\u00d4',
		'Ố' => '\u1ed0',
		'Ồ' => '\u1ed2',
		'Ổ' => '\u1ed4',
		'Ỗ' => '\u1ed6',
		'Ộ' => '\u1ed8',
		'Ơ' => '\u01a0',
		'Ớ' => '\u1eda',
		'Ờ' => '\u1edc',
		'Ở' => '\u1ede',
		'Ỡ' => '\u1ee0',
		'Ợ' => '\u1ee2',
		'ú' => '\u00fa',
		'ù' => '\u00f9',
		'ủ' => '\u1ee7',
		'ũ' => '\u0169',
		'ụ' => '\u1ee5',
		'ư' => '\u01b0',
		'ứ' => '\u1ee9',
		'ừ' => '\u1eeb',
		'ử' => '\u1eed',
		'ữ' => '\u1eef',
		'ự' => '\u1ef1',
		'Ú' => '\u00da',
		'Ù' => '\u00d9',
		'Ủ' => '\u1ee6',
		'Ũ' => '\u0168',
		'Ụ' => '\u1ee4',
		'Ư' => '\u01af',
		'Ứ' => '\u1ee8',
		'Ừ' => '\u1eea',
		'Ử' => '\u1eec',
		'Ữ' => '\u1eee',
		'Ự' => '\u1ef0',
		'ý' => '\u00fd',
		'ỳ' => '\u1ef3',
		'ỷ' => '\u1ef7',
		'ỹ' => '\u1ef9',
		'ỵ' => '\u1ef5',
		'Ý' => '\u00dd',
		'Ỳ' => '\u1ef2',
		'Ỷ' => '\u1ef6',
		'Ỹ' => '\u1ef8',
		'Ỵ' => '\u1ef4',
		// Loại bỏ dòng trắng
//			';if (' => ';if(',
//			'{if (' => '{if(',
//			'}if (' => '}if(',
//			'} else if (' => '}else if(',
//			'} else {' => '}else{',
//			'}else {' => '}else{',
//			';for (' => ';for(',
//			'}for (' => '}for(',
//			'function (' => 'function(',
//			//
//			' != ' => '!=',
//			' == ' => '==',
//			' || ' => '||',
//			' -= ' => '-=',
//			' += ' => '+=',
//			' && ' => '&&',
//			//
//			') {' => '){',
//			';}' => '}',
//			' = \'' => '=\'',
//			'\' +' => '\'+',
//			'+ \'' => '+\'',
//			' = ' => '=',
//			'}, {' => '},{',
//			'}, ' => '},',
		'\'' => '\\\'',
		'' => ''
	);
	foreach ($arr as $k => $v) {
		if ($v != '') {
			$str = str_replace($k, $v, $str);
		}
	}
//	$str = str_replace('\\', '/', str_replace("'", "\'", $str) );
	return $str;
}




function _eb_postUrlContent($url, $data = '', $head = 0) {
	global $post_get_cc;
	
	return $post_get_cc->post ( $url, $data, $head );
}
function _eb_getUrlContent($url, $agent = '', $options = array(), $head = 0) {
	global $post_get_cc;
	
	return $post_get_cc->get ( $url, $agent, $options, $head );
}




// fix URL theo 1 chuẩn nhất định
function _eb_fix_url( $url ) {
//	echo $url . '<br>' . "\n";
//	echo _eb_full_url() . '<br>' . "\n";
	
	//
//	if ( strstr( $url, '//' ) != strstr( _eb_full_url (), '//' ) ) {
	if ( strstr( strstr( _eb_full_url (), '//' ), strstr( $url, '//' ) ) == false ) {
//	if ( count( explode( strstr( $url, '//' ), strstr( _eb_full_url (), '//' ) ) ) == 1 ) {
		
//		header ( 'Location:' . $url, true, 301 );
		
		wp_redirect( $url, 301 );
		
		exit();
		
	}
}

// short link
function _eb_s_link ($id, $seo = 'p') {
	return web_link . '?' . $seo . '=' . $id;
}

// link cho sản phẩm
function _eb_p_link ($id, $seo = '') {
	$strCacheFilter = 'prod_link' . $id;
	$a = _eb_get_static_html ( $strCacheFilter, '', '', eb_default_cache_time );
	if ($a == false) {
		$a = get_the_permalink( $id );
		if ( $a == '' ) {
			$a = _eb_s_link($id);
		}
		
		//
		_eb_get_static_html ( $strCacheFilter, $a, '', 60 );
	}
//		echo $a . '<br>' . "\n";
	
	return $a;
}



// link cho phân nhóm
$arr_cache_for_get_cat_url = array();

function _eb_c_link ( $id, $taxx = 'category' ) {
	global $arr_cache_for_get_cat_url;
	
	//
	if ( isset($arr_cache_for_get_cat_url[ $id ]) ) {
		return $arr_cache_for_get_cat_url[ $id ];
	}
	
	$strCacheFilter = 'cat_link' . $id;
	$a = _eb_get_static_html ( $strCacheFilter, '', '', eb_default_cache_time );
//		$a = _eb_get_static_html ( $strCacheFilter, '', '', 5 );
	if ($a == false) {
		
		$a = get_category_link( $id );
//			$a = get_term_link( get_term( $id, $taxx ), $taxx );
		
		// nếu trùng với short link -> không ghi cache nữa
		/*
		if ( $a == $default_return ) {
			return $a;
		}
		*/
		
		//
		if ( isset($a->errors) || $a == '' ) {
//				print_r($a);
			
			$tem = get_term_by( 'id', $id, EB_BLOG_POST_LINK );
			
			// lấy theo blog
			$a = get_term_link( $tem, EB_BLOG_POST_LINK );
//				$a = get_term_link( get_term( $id, EB_BLOG_POST_LINK ), EB_BLOG_POST_LINK );
			
			// lấy theo post_options
			if ( isset($a->errors) || $a == '' ) {
				$a = get_term_link( $tem, 'post_options' );
				
				// lấy theo post_tag
				if ( isset($a->errors) || $a == '' ) {
					$a = get_term_link( $tem, 'post_tag' );
				}
			}
		}
		
		//
		if ( isset($a->errors) || $a == '' ) {
			$a = '#';
		}
		// xóa ký tự đặc biệt khi rút link category
		else {
			$a = str_replace( '/./', '/', $a );
		}
//			echo $id . ' -> ' . $a . '<br>' . "\n";
		
		//
		_eb_get_static_html ( $strCacheFilter, $a, '', 60 );
	}
//		echo $a . '<br>' . "\n";
	
	//
	$arr_cache_for_get_cat_url[ $id ] = $a;
	
	return $a;
}

// blog
function _eb_b_link($id, $seo = '') {
	return _eb_p_link($id);
}

// blog group
function _eb_bs_link($id, $seo = '') {
	return _eb_c_link( $id );
}



function _eb_remove_file ($file_, $ftp = 1) {
	if ( file_exists( $file_ ) ) {
		if ( ! unlink( $ffile_ ) ) {
			// thử xóa bằng ftp
			if ( $ftp == 1 ) {
				return EBE_ftp_remove_file($file_);
			}
		} else {
			return true;
		}
	}
	
	return false;
}

function _eb_create_file ($file_, $content_, $add_line = '', $ftp = 1) {
	
	//
	if ( ! file_exists( $file_ ) ) {
		$filew = fopen( $file_, 'x+' );
		
		// nếu không tạo được file
		if ( ! $filew ) {
			// thử tạo bằng ftp
			if ( $ftp == 1 ) {
				return EBE_ftp_create_file( $file_, $content_, $add_line );
			}
			
			//
			echo 'ERROR create file: ' . $file_ . '<br>' . "\n";
			return false;
		}
		else {
			// nhớ set 777 cho file
			chmod($file_, 0777);
		}
		fclose($filew);
	}
	
	//
	if ( $add_line != '' ) {
		$aa = file_put_contents( $file_, $content_, FILE_APPEND );
//		chmod($file_, 0777);
	}
	//
	else {
//		file_put_contents( $file_, $content_, LOCK_EX ) or die('ERROR: write to file');
		$aa = file_put_contents( $file_, $content_ );
//		chmod($file_, 0777);
	}
	
	//
	if ( ! $aa ) {
		if ( EBE_ftp_create_file( $file_, $content_, $add_line ) != true ) {
			echo 'ERROR write to file: ' . $file_ . '<br>' . "\n";
			return false;
		}
	}
	
	
	
	/*
	* add_line: thêm dòng mới
	*/
//	$content_ = str_replace('\"', '"', $content_);
//	$content_ = str_replace("\'", "'", $content_);
	
	/*
	// nếu tồn tại file rồi -> sửa
	if (file_exists($file_)) {
//			if( flock( $file_, LOCK_EX ) ) {
			// open
	//		$fh = fopen($file_, 'r+') or die('ERROR: open 1');
	//		$str_data = fread($fh, filesize($file_));
			if ($add_line != '') {
				$fh = fopen($file_, 'a+') or die('ERROR: add to file');
			} else {
				$fh = fopen($file_, 'w+') or die('ERROR: write to file');
			}
//			}
	}
	// chưa tồn tại file -> tạo
	else {
		// open
		$fh = fopen($file_, 'x+') or die('ERROR: create file');
		chmod($file_, 0777);
	}
	
	// write
	fwrite($fh, $content_) or die('ERROR: write');
	// close
	fclose($fh) or die('ERROR: close');
	*/
	
	return true;
}

function EBE_create_cache_for_ftp () {
	return EB_THEME_CACHE . 'cache_for_ftp.txt';
}

function EBE_check_ftp_account () {
	
	if ( ! defined('FTP_USER') || ! defined('FTP_PASS') ) {
		echo 'ERROR FTP: FTP_USER or FTP_PASS not found<br>' . "\n";
		return false;
	}
	
	if ( defined('FTP_HOST') ) {
		$ftp_server = FTP_HOST;
	} else {
//		$ftp_server = $_SERVER['HTTP_HOST'];
		$ftp_server = $_SERVER['SERVER_ADDR'];
	}
//	echo $ftp_server . '<br>' . "\n";
	
	return $ftp_server;
}

function EBE_get_config_ftp_root_dir ( $content_ = '1' ) {
	global $__cf_row;
	
	// Nếu chưa có thư mục root cho FTP -> bắt đầu dò tìm
	if ( $__cf_row['cf_ftp_root_dir'] == '' ) {
		$__cf_row['cf_ftp_root_dir'] = EBE_get_ftp_root_dir( $content_ );
	}
	// Tạo file cache để truyền dữ liệu
	else {
		_eb_create_file( EBE_create_cache_for_ftp(), $content_, '', 0 );
	}
	
	return $__cf_row['cf_ftp_root_dir'];
}

function EBE_get_ftp_root_dir ( $content_ = 'test' ) {
	
	$ftp_server = EBE_check_ftp_account();
	if ( $ftp_server == false ) {
		echo 'FTP account not found';
		return '';
	}
	$ftp_user_name = FTP_USER;
	$ftp_user_pass = FTP_PASS;
//	echo $ftp_user_name . '<br>';
//	echo $ftp_user_pass . '<br>';
	
	
	// tạo kết nối
	$conn_id = ftp_connect($ftp_server);
	if ( ! $conn_id ) {
		echo 'ERROR FTP connect to server<br>' . "\n";
		return '';
	}
	
	
	// đăng nhập
	if ( ! ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) ) {
		echo 'ERROR FTP login false<br>' . "\n";
		return '';
	}
	
	
	// tạo file trong cache
	$cache_for_ftp = EBE_create_cache_for_ftp();
	
	// Tạo một file bằng hàm của PHP thường -> không dùng FTP
	if ( _eb_create_file( $cache_for_ftp, $content_, '', 0 ) != true ) {
		return '';
	}
	
	
	// lấy thư mục gốc của tài khoản FTP
	$a = explode( '/', $cache_for_ftp );
	$ftp_dir_root = '';
//	print_r( $a );
	foreach ( $a as $v ) {
//		echo $v . "\n";
		if ( $ftp_dir_root == '' && $v != '' ) {
			$file_test = strstr( $cache_for_ftp, '/' . $v . '/' );
//			echo $file_test . " - \n";
			
			//
			if ( $file_test != '' ) {
				if ( ftp_nlist($conn_id, '.' . $file_test) != false ) {
					$ftp_dir_root = $v;
					break;
				}
			}
		}
	}
//	echo $ftp_dir_root . '<br>' . "\n";
	
	//
	ftp_close($conn_id);
	
	//
	if ( $ftp_dir_root == '' ) {
		echo 'ERROR FTP: ftp_dir_root not found<br>' . "\n";
	}
	
	return $ftp_dir_root;
}

// Tạo file thông qua tài khoản FTP
function EBE_ftp_create_file ($file_, $content_, $add_line = '') {
	
	$ftp_dir_root = EBE_get_config_ftp_root_dir( $content_ );
	
	
	if ( ! file_exists( $file_ ) && ! is_dir( dirname( $file_ ) ) ) {
		echo 'ERROR FTP: dir not found<br>' . "\n";
		return false;
	}
	
	$ftp_server = EBE_check_ftp_account();
	if ( $ftp_server == false ) {
		echo 'FTP account not found';
		return false;
	}
	$ftp_user_name = FTP_USER;
	$ftp_user_pass = FTP_PASS;
	
	
	// tạo kết nối
	$conn_id = ftp_connect($ftp_server);
	if ( ! $conn_id ) {
		echo 'ERROR FTP connect to server<br>' . "\n";
		return false;
	}
	
	
	// đăng nhập
	if ( ! ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) ) {
		echo 'ERROR FTP login false<br>' . "\n";
		return false;
	}
	
	
	//
	$file_for_ftp = $file_;
	if ( $ftp_dir_root != '' ) {
		$file_for_ftp = strstr( $file_, '/' . $ftp_dir_root . '/' );
	}
//	echo $file_for_ftp . '<br>';
//	echo EBE_create_cache_for_ftp() . '<br>';
	
	// upload file
	$result = true;
	if ( ! ftp_put($conn_id, '.' . $file_for_ftp, EBE_create_cache_for_ftp(), FTP_BINARY) ) {
		echo 'ERROR FTP: ftp_put error<br>' . "\n";
		$result = false;
	}
	
	
	// close the connection
	ftp_close($conn_id);
	
	
	//
	return $result;
	
}

// Xóa file thông qua tài khoản FTP
function EBE_ftp_remove_file ($file_) {
	
	$ftp_dir_root = EBE_get_config_ftp_root_dir();
	
	
	$ftp_server = EBE_check_ftp_account();
	if ( $ftp_server == false ) {
		echo 'FTP account not found';
		return false;
	}
	$ftp_user_name = FTP_USER;
	$ftp_user_pass = FTP_PASS;
	
	
	// tạo kết nối
	$conn_id = ftp_connect($ftp_server);
	if ( ! $conn_id ) {
		echo 'ERROR FTP connect to server<br>' . "\n";
		return false;
	}
	
	
	// đăng nhập
	if ( ! ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) ) {
		echo 'ERROR FTP login false<br>' . "\n";
		return false;
	}
	
	
	//
	$file_for_ftp = $file_;
	if ( $ftp_dir_root != '' ) {
		$file_for_ftp = strstr( $file_, '/' . $ftp_dir_root . '/' );
	}
	
	// upload file
	$result = true;
	if ( ftp_delete($conn_id, $file_for_ftp) ) {
		echo 'ERROR FTP: ftp_delete error<br>' . "\n";
		$result = false;
	}
	
	
	// close the connection
	ftp_close($conn_id);
	
	
	//
	return $result;
	
}




function _eb_setCucki ( $c_name, $c_value = 0, $c_time = 0, $c_path = '/' ) {
	__eb_set_cookie( $c_name, $c_value, $c_time, $c_path );
}
function _eb_getCucki ( $c_name, $default_value = '' ) {
	if ( isset($_COOKIE[ $c_name ]) ) {
		return $_COOKIE[ $c_name ];
	}
	return $default_value;
}



function _eb_alert($m) {
	die ( '<script type="text/javascript">alert("' . $m . '");</script>' );
}



function _eb_number_only( $str = '', $re = '/[^0-9]+/' ) {
	if ($str == '') {
		return 0;
	}
	return (int) preg_replace ( $re, '', trim( $str ) );
}

function _eb_float_only( $str = '' ) {
	return _eb_number_only( $str, '/[^0-9|\.]+/' );
}

function _eb_text_only($str = '') {
	if ($str == '') {
		return '';
	}
	return preg_replace ( '/[^a-zA-Z0-9\-\.]+/', '', $str );
}



function EBE_get_file_in_folder($open_folder, $type = '', $brace = '') {
	if ($brace != '') {
		$arr = glob ( $open_folder . $brace, GLOB_BRACE );
	} else {
		$arr = glob ( $open_folder . '*' );
	}
}

function _eb_remove_ebcache_content($dir = EB_THEME_CACHE, $remove_dir = 0) {
//		echo $dir . '<br>'; exit();
	
	// nếu ký tự cuối là dấu / -> bỏ đi
	if ( substr( $dir, -1 ) == '/' ) {
		$dir = substr( $dir, 0, -1 );
	}
//		echo $dir . '<br>';
	
//		exit();
	
	
	// lấy d.sách file và thư mục trong thư mục cần xóa
	$arr = glob ( $dir . '/*' );
//	print_r( $arr ); exit();
	
	
	/*
	* v2
	*/
	foreach ( $arr as $v ) {
//		echo $v . '<br>' . "\n";
		
		// nếu là thư mục -> xóa nội dung trong thư mục
		if ( is_dir( $v ) ) {
			// gọi lệnh xóa tiếp các file trong thư mục -> đến hết mới thôi
			_eb_remove_ebcache_content ( $v );
		}
		else if ( is_file( $v ) ) {
			unlink( $v );
		}
	}
	
	//
	return true;
	
	
	
	/*
	* v1
	*/
	// lọc lấy file
	$_file = array_filter ( $arr, 'is_file' );
	// và xóa
	array_map ( 'unlink', $_file );
	
	// lọc lấy thư mục
	$_dir = array_filter ( $arr, 'is_dir' );
	foreach ( $_dir as $v ) {
		// gọi lệnh xóa tiếp đến hết mới thôi
		_eb_remove_ebcache_content ( $v );
		
		//
//		if ($remove_dir == 1) {
//			rmdir ( $v );
//			echo $v . "\n";
//		}
	}
}


function _eb_create_account_auto ( $arr = array() ) {
	if ( count( $arr ) == 0 ) {
		return 0;
	}
	
	
	//
	$user_email = _eb_non_mark( strtolower( $arr['tv_email'] ) );
	
	// tìm theo email
	$user_id = email_exists( $user_email );
	
	// có thì trả về luôn
	if ( $user_id > 0 ) {
		return $user_id;
	}
	
	
	// tạo username từ email
	if ( ! isset( $arr['user_name'] ) ) {
		$user_name = str_replace( '.', '_', str_replace( '@', '', $user_email ) );
	} else {
		$user_name = strtolower( $arr['user_name'] );
	}
	$user_name = str_replace( '-', '', str_replace( '.', '', _eb_text_only( trim( $user_name ) ) ) );
	
	// Kiểm tra user có chưa
	$user_id = username_exists( $user_name );
//		echo $user_id; exit();
	
	// có thì trả về luôn
	if ( $user_id > 0 ) {
		return $user_id;
	}
	
	
	// chưa có -> tạo mới ->  mật khẩu mặc định ;))
	return wp_create_user( $user_name, 'echbay.com', $user_email );
}

/*
* Tự động tạo trang nếu chưa có
*/
function _eb_create_page( $page_url, $page_name, $page_template = '' ) {
	global $wpdb;
	
	$name = $wpdb->get_var("SELECT ID
	FROM
		" . $wpdb->posts . "
	WHERE
		post_name = '" . $page_url . "'");
	
	if ($name == '') {
		$page = array(
			'post_title' => $page_name,
			'post_type' => 'page',
			'post_content' => 'Vui lòng không xóa hoặc thay đổi bất kỳ điều gì trong trang này.',
			'post_parent' => 0,
			'post_author' => mtv_id,
			'post_status' => 'publish',
			'post_name' => $page_url,
		);
		
		// tạo page mới
//			$page = apply_filters('yourplugin_add_new_page', $page, 'teams');
		$pageid = wp_insert_post ($page);
		
		
		/*
		* add template tương ứng
		*/
		if ( $page_template == '' ) {
//				$page_template = 'templates/' . $page_url . '.php';
			$page_template = 'templates/index.php';
		}
		
		add_post_meta( $pageid, '_wp_page_template', $page_template, true );
	}
}


function _eb_create_breadcrumb ( $url, $tit ) {
	global $breadcrumb_position;
	global $group_go_to;
	
	//
	$group_go_to[$url] = ' <li><a href="' . $url . '">' . $tit . '</a></li>';
	
	//
//	echo $breadcrumb_position . "\n";
	
	$breadcrumb_position++;
	
	//
	return '
	, {
		"@type": "ListItem",
		"position": ' . $breadcrumb_position . ',
		"item": {
			"@id": "' . str_replace( '/', '\/', $url ) . '",
			"name": "' . str_replace( '"', '&quot;', $tit ) . '"
		}
	}';
}

function _eb_create_html_breadcrumb ($c) {
	global $group_go_to;
	global $schema_BreadcrumbList;
	
	//
//	print_r( $c );
	
	//
	$return_id = $c->term_id;
	
	//
	if ( $c->parent > 0 ) {
		
		//
		$return_id = $c->parent;
		
		//
		$parent_cat = get_term_by( 'id', $c->parent, $c->taxonomy );
//		print_r( $parent_cat );
		
		//
		$lnk = _eb_c_link($parent_cat->term_id);
		$group_go_to[$lnk] = ' <li><a href="' . $lnk . '">' . $parent_cat->name . '</a></li>';
		
		// tìm tiếp nhóm cha khác nếu có
		if ( $parent_cat->parent > 0 ) {
			$return_id = _eb_create_html_breadcrumb( $parent_cat );
		}
	}
	
	return $return_id;
}

function _eb_echbay_category_menu ( $id, $tax = 'category' ) {
	$str = '';
	
	$strCacheFilter = 'eb_cat_menu' . $id;
//	echo $strCacheFilter;
	
	$str = _eb_get_static_html ( $strCacheFilter );
	
	if ($str == false) {
		
		// parent
		$parent_cat = get_term_by( 'id', $id, $tax );
//		print_r( $parent_cat );
		
		// sub
		$sub_cat = get_categories( array(
//			'hide_empty' => 0,
			'parent' => $parent_cat->term_id
//			'child_of' => $parent_cat->term_id
		) );
//		print_r( $sub_cat );
		
		foreach ( $sub_cat as $k => $v ) {
			$str .= '<li><a href="' . _eb_c_link( $v->term_id ) . '">' . $v->name . '</a></li>';
		}
		
		if ( $str != '' ) {
			$str = '<ul class="sub-menu">' . $str . '</ul>';
		}
		
		// tổng hợp
		$str = '<ul><li><a href="' . _eb_c_link( $parent_cat->term_id ) . '">' . $parent_cat->name . '</a>' . $str . '</li></ul>';
		
		//
		_eb_get_static_html ( $strCacheFilter, $str );
		
	}
	
	//
	return $str;
}

function _eb_get_youtube_id ( $url ) {
	if ( $url == '' ) {
		return '';
	}
	
	parse_str( parse_url( $url, PHP_URL_QUERY ), $a );
	
	if ( isset( $a['v'] ) ) {
		return $a['v'];  
	} else {
		$a = explode( '/embed/', $url );
		if ( isset( $a[1] ) ) {
			$a = explode( '?', $a[1] );
			$a = explode( '&', $a[0] );
			
			return $a[0];
		}
	}
	
	return '';
}

// tiêu đề tiêu chuẩn của google < 70 ký tự
function _eb_tieu_de_chuan_seo( $str ) {
	global $__cf_row;
	
	// nếu sử dụng module SEO của EchBay
	if ( $__cf_row['cf_on_off_echbay_seo'] == 1 || is_404() ) {
		$str = trim( $str );
		
		// hoặc tự bổ sung nếu có dữ liệu đầu vào
		if ( strlen( $str ) < 35 && $__cf_row ['cf_abstract'] != '' ) {
			$str .= ' - ' . $__cf_row ['cf_abstract'];
			
			//
			if ( strlen( $str ) > 70 ) {
				$str = _eb_short_string( $str, 70 );
			}
		}
//		echo '<!-- title by EchBay -->';
	}
	// mặc định thì lấy theo mẫu của wordpress
	else {
		// chỉ lấy mỗi title cho phần trang chủ
		if ( is_home() || is_front_page() ) {
			$str = web_name;
		}
		// còn lại thì không can thiệp
		else {
			$str = wp_title( '|', false, 'right' );
		}
//		$str = wp_title( '', false );
//		echo '<!-- title by other plugin -->';
	}
	
	//
	echo '<title>' . $str . '</title>' . "\n";
//	return $str;
}

function _eb_short_string( $str, $len, $more = 1 ) {
	$str = trim ( $str );
	
	if ($len > 0 && strlen ( $str ) > $len) {
		$str = substr ( $str, 0, $len );
		if (! substr_count ( $str, " " )) {
			if ($more == 1) {
				$str .= "...";
			}
			return $str;
		}
		while ( strlen ( $str ) && ($str [strlen ( $str ) - 1] != " ") ) {
			$str = substr ( $str, 0, - 1 );
		}
		$str = substr ( $str, 0, - 1 );
		if ($more == 1) {
			$str .= "...";
		}
	}
	
	return $str;
}

function _eb_del_line ( $str, $re = "", $pe = "/\r\n|\n\r|\n|\t/i" ) {
	return preg_replace( $pe, $re, trim( $str ) );
}

function _eb_lay_email_tu_cache ( $id ) {
	if ( $id <= 0 ) {
		return 'NULL';
	}
	$strCacheFilter = 'tv_mail/' . $id;
	
	$tv_email = _eb_get_static_html ( $strCacheFilter, '', '', 24 * 3600 );
	
	if ($tv_email == false) {
		$user = get_user_by( 'id', $id );
//			print_r($user);
		
		//
		if ( ! empty( $user ) ) {
			$tv_email = $user->user_email;
		} else {
			$tv_email = $id;
		}
		
		//
		_eb_get_static_html ( $strCacheFilter, $tv_email, '', 60 );
	}
	
	return $tv_email;
}

function _eb_categories_list_list_v3 ( $taxx = 'category' ) {
	$arr = get_categories( array(
		'taxonomy' => $taxx,
		'hide_empty' => 0,
	) );
//		print_r($arr);
	
	//
//		echo count( $arr ) . "\n";
	
	//
	$str = '';
	
	foreach ( $arr as $v ) {
		$str .= '<option data-parent="' . $v->category_parent . '" value="' . $v->term_id . '">' . $v->name . '</option>';
	}
	
	return $str;
}

function _eb_categories_list_v3 ( $select_name = 't_ant', $taxx = 'category' ) {
	$str = '<option value="0">[ Lựa chọn phân nhóm ]</option>';
	
	$str .= _eb_categories_list_list_v3( $taxx );
	
	$str .= '<option data-show="1" data-href="' . web_link . WP_ADMIN_DIR . '/edit-tags.php?taxonomy=category">[+] Thêm phân nhóm mới</option>';
	
	return '<select name="' . $select_name . '">' . $str . '</select>';
}


$cache_thumbnail_id = array();
//$cache_attachment_image_src = array();
function _eb_get_post_img ( $id, $_size = 'full' ) {
	global $cache_thumbnail_id;
//	global $cache_attachment_image_src;
	
	//
//	if ( isset( $cache_attachment_image_src[ $id . $_size ] ) ) {
//		return $cache_attachment_image_src[ $id . $_size ];
//	}
	
	/*
	if ( $_size == '' ) {
		global $__cf_row;
		
		$_size =  $__cf_row['cf_product_thumbnail_size'];
//		$_size =  $__cf_row['cf_ads_thumbnail_size'];
	}
	*/
	
	/*
	$strCacheFilter = 'post_img/' . $id;
	$a = _eb_get_static_html ( $strCacheFilter );
	if ($a == false) {
		global $__cf_row;
		*/
		
		if ( has_post_thumbnail( $id ) ) {
			
			// lưu ID thumbnail vào biến để sử dụng lại
			if ( ! isset( $cache_thumbnail_id[ $id ] ) ) {
				$cache_thumbnail_id[ $id ] = get_post_thumbnail_id( $id );
			}
			
			// size riêng cho bản EchBay mobile
			if ( $_size == 'ebmobile' ) {
				// nếu server có hỗ trợ Imagick
				if ( class_exists('Imagick') ) {
					return EBE_resize_mobile_table_img( $cache_thumbnail_id[ $id ], $_size );
				}
				// không thì lấy size medium
				else {
					$_size = 'medium';
//					$_size = 'thumbnail';
				}
			}
			
			//
			$a = wp_get_attachment_image_src ( $cache_thumbnail_id[ $id ], $_size );
//			print_r( $a );
//			$a = esc_url( $a[0] );
			$a = $a[0];
		} else {
			$a = _eb_get_post_object( $id, '_eb_product_avatar' );
		}
		
		/*
		
		//
		if ($a != '') {
			_eb_get_static_html ( $strCacheFilter, $a );
		}
	}
	*/
	
	//
//	$cache_attachment_image_src[ $id . $_size ] = $a;
	
	//
	return $a;
}

function EBE_resize_mobile_table_img ( $attachment_id, $_size ) {
	// lấy ảnh full
	$source_file = wp_get_attachment_image_src ( $attachment_id, 'full' );
	$source_file = $source_file[0];
	
	// -> ảnh cho bản mobile
	$file_type = explode( '.', $source_file );
	$file_type = $file_type[ count($file_type) - 1 ];
	
	$new_file = $source_file . '_' . $_size . '.' . $file_type;
	
	// xem file này có tồn tại không -> không thì tạo
	$check_file = ABSPATH . strstr( $new_file, 'wp-content/' );
	if ( ! file_exists( $check_file ) ) {
		// Kiểm tra file nguồn
		$source_file = ABSPATH . strstr( $source_file, 'wp-content/' );
		if ( ! file_exists( $source_file ) ) {
			return 'source not found!';
		}
		$arr_parent_size = getimagesize( $source_file );
		
		// resize sang ảnh mới
		$image = new Imagick();
		$image->readImage($source_file);
		
		// copy và resize theo chiều rộng
		if ( $arr_parent_size[0] > $arr_parent_size[1] ) {
			$image->resizeImage(160, 0, Imagick::FILTER_CATROM, 1);
		}
		// theo chiều cao
		else {
			$image->resizeImage(0, 160, Imagick::FILTER_CATROM, 1);
		}
		/*
		if ( $arr_parent_size['mime'] == 'image/jpeg' ) {
			$image->setImageFormat( 'jpg' );
			$image->setImageCompression(Imagick::COMPRESSION_JPEG);
		}
		else {
			$image->setImageCompression(Imagick::COMPRESSION_UNDEFINED);
		}
		$image->setImageCompressionQuality( 75 );
		$image->optimizeImageLayers();
		*/
		
		$image->writeImages($check_file, true);
		$image->destroy();
		
		chmod ( $check_file, 0666 );
		
//		return $check_file;
	}
	
	return $new_file;
}


/*
* Chức năng lấy post meta dưới dạng object
*/
function _eb_get_object_post_meta ( $id, $key = eb_post_obj_data, $sing = true, $default_value = array() ) {
	$a = get_post_meta( $id, $key, $sing );
	if ($a == '') {
		$a = $default_value;
	} 
	// thêm ID của mảng để sau còn check lại dữ liệu cho chuẩn
	else {
		$a['id'] = $id;
	}
	
	return $a;
}

/*
* Chức năng dùng để gộp các post metae vào 1 post meta duy nhất -> select sẽ nhanh gọn hơn -> giảm thiểu việc mysql sử dụng quá nhiều ram server
*/
//function _eb_convert_postmeta_to_v2 ( $id, $key, $meta_key ) {
function _eb_convert_postmeta_to_v2 ( $id, $key = '_eb_product_', $meta_key = eb_post_obj_data ) {
	
	//
	$strFilter = " meta_key LIKE '{$key}%' ";
	if ( $key != '_eb_category_' ) {
		$key1 = '_eb_product_';
		$key2 = '_eb_ads_';
		
		$strFilter = " ( meta_key LIKE '{$key1}%' OR meta_key LIKE '{$key2}%' ) ";
	}
	
	// lấy tất cả các post meta thuộc post tương ứng
	$row = _eb_q("SELECT *
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . $id . "
		AND " . $strFilter . "
	ORDER BY
		meta_id DESC");
//			print_r($old_post_meta);
	
	// lưu vào 1 mảng tạm để xuất dữ liệu ra cho chuẩn
	$arr = array();
	$arr_update = array();
	foreach ( $row as $v ) {
		
		// mảng hiển thị thì phải cắt bỏ hết các ký tự không liên quan
		$arr[ $v->meta_key ] = stripslashes( stripslashes( stripslashes( $v->meta_value ) ) );
		
		// còn mảng dùng để update thì bắt buộc phải lắp thêm vào -> nếu không sẽ gây lỗi chuỗi khi convert sang mảng
		$arr_update[ $v->meta_key ] = addslashes( $arr[ $v->meta_key ] );
		
	}
//	print_r($arr);
//	print_r($arr_update);
	
	// gán thêm ID để đỡ phải lấy lại lần sau
	$arr['id'] = $id;
	$arr_update['id'] = $id;
//	print_r($arr);
//	print_r($arr_update);
	
	// cập nhật theo chức năng mới luôn
	update_post_meta( $id, $meta_key, $arr_update );
	
//	exit();
	
	//
	return $arr;
	
}

/*
* Gán vào một tham số khác để phân định giữa category với post
*/
//$arr_object_cat_meta = array();

function _eb_get_cat_object ( $id, $key, $default_value = '' ) {
	return _eb_get_post_object ( $id, $key, $default_value, eb_cat_obj_data, '_eb_category_' );
	
	/*
	global $arr_object_cat_meta;
	
	//
	if ( ! isset( $arr_object_cat_meta['id'] ) || $arr_object_cat_meta['id'] != $id ) {
		$arr_object_cat_meta = _eb_get_object_post_meta( $id, eb_cat_obj_data );
		
		// nếu không tồn tại mảng tiêu đề -> vẫn là kiểu dữ liệu cũ -> chuyển sang dữ liệu mới luôn và ngay
		if ( ! isset( $arr_object_cat_meta['id'] ) ) {
			$arr_object_cat_meta = _eb_convert_postmeta_to_v2( $id, '_eb_category_', eb_cat_obj_data );
		}
	}
	
	if ( ! isset ( $arr_object_cat_meta[ $key ] ) ) {
		return $default_value;
	}
	
	return $arr_object_cat_meta[ $key ];
	*/
	
}

/*
* Gán vào một tham số khác để phân định giữa ads với post
*/
function _eb_get_ads_object ( $id, $key, $default_value = '' ) {
	return _eb_get_post_object ( $id, $key, $default_value, eb_post_obj_data, '_eb_ads_' );
	
	/*
	global $arr_object_cat_meta;
	
	//
	if ( ! isset( $arr_object_cat_meta['id'] ) || $arr_object_cat_meta['id'] != $id ) {
		$arr_object_cat_meta = _eb_get_object_post_meta( $id );
		
		// nếu không tồn tại mảng tiêu đề -> vẫn là kiểu dữ liệu cũ -> chuyển sang dữ liệu mới luôn và ngay
		if ( ! isset( $arr_object_cat_meta['id'] ) ) {
			$arr_object_cat_meta = _eb_convert_postmeta_to_v2( $id, '_eb_ads_' );
		}
	}
	
	if ( ! isset ( $arr_object_cat_meta[ $key ] ) ) {
		return $default_value;
	}
	
	return $arr_object_cat_meta[ $key ];
	*/
	
}

/*
* Hàm này dùng để lấy object của post, object này bao gồm các thông tin khác tương tự như post meta riêng lẻ. Ví dụ: giá bán, ảnh đại diện...
*/
$arr_object_post_meta = array();

function _eb_get_post_object ( $id, $key, $default_value = '', $meta_key = eb_post_obj_data, $meta_convert = '_eb_product_' ) {
	global $arr_object_post_meta;
	
	//
	$check_id = ( $meta_convert == '_eb_category_' ) ? 'cid' : 'id';
	$check_id .= $id;
	
	//
//	echo $check_id . ' -------<br>' . "\n";
//	echo $meta_convert . ' -------<br>' . "\n";
	
	
	/*
	* Đỡ phải select nhiều -> nhẹ server, host -> hàm sẽ kiểm tra mảng dữ liệu cũ. Nếu trùng ID thì sử dụng luôn, không cần lấy lại nữa.
	* Trường hợp không tìm thấy hoặc ID truyền vào khác ID trước đó -> sẽ tiền hành lấy mới trong CSDL
	*/
//	if ( ! isset( $arr_object_post_meta[$check_id] ) || $arr_object_post_meta[$check_id] != $id ) {
	if ( ! isset( $arr_object_post_meta[$check_id] ) ) {
		// v2
		$sql = _eb_q ("SELECT meta_key, meta_value
		FROM
			`" . wp_postmeta . "`
		WHERE
			post_id = " . $id);
//		print_r($sql); exit();
		
		//
		$arr = array();
//		if ( count($sql) > 0 ) {
			foreach ( $sql as $v ) {
				$arr[ $v->meta_key ] = $v->meta_value;
			}
//		}
		
		
		
		// v1
		/*
		$arr_object_post_meta = _eb_get_object_post_meta( $id, $meta_key );
		
		// nếu không tồn tại mảng ID -> vẫn là kiểu dữ liệu cũ -> chuyển sang dữ liệu mới luôn và ngay
		if ( ! isset( $arr_object_post_meta[check_id] ) ) {
			$arr_object_post_meta = _eb_convert_postmeta_to_v2( $id, $meta_convert, $meta_key );
		}
		*/
		
		// nếu không có kết quả trả về -> trả về dữ liệu mặc định
		if ( ! isset ( $arr[ $key ] ) || $arr[ $key ] == '' ) {
			$arr[ $key ] = $default_value;
			
			// chuyển về dạng số nếu dữ liệu mặc định cũng là số
			if ( is_numeric( $default_value ) ) {
				$arr[ $key ] = (int)$arr[ $key ];
			}
		}
		$arr[ $meta_key ] = '';
		
		//
//		echo $key . ' --------0<br>' . "\n";
//		print_r( $arr );
		
		// gán ID để lần sau còn dùng lại
		$arr_object_post_meta[$check_id] = $arr;
	}
	else {
//		echo $key . ' --------1<br>' . "\n";
		$arr = $arr_object_post_meta[$check_id];
	}
//	echo '=====================<br>' . "\n";
	
	//
//	print_r($arr_object_post_meta);
	
	// có kết quả thì trả về kết quả tìm được
	/*
	if ( isset( $arr[ $key ] ) ) {
		return $arr[ $key ];
	}
	else {
//		echo $key . '<br>' . "\n";
//		print_r( $arr );
		return '';
	}
	*/
	return isset( $arr[ $key ] ) ? $arr[ $key ] : $default_value;
}

function _eb_get_post_meta ( $id, $key, $sing = true, $default_value = '' ) {
	
	// chuyển sang sử dụng phiên bản code mới
//	if ( strstr( $key, '_eb_product_' ) == true ) {
		return _eb_get_post_object( $id, $key, $default_value );
		/*
	}
	else if ( strstr( $key, '_eb_category_' ) == true ) {
		return _eb_get_cat_object( $id, $key, $default_value );
	}
	*/
	
	
	
	// bản code cũ
	$strCacheFilter = 'post_meta/' . $key . $id;
	$a = _eb_get_static_html ( $strCacheFilter );
	if ($a == false) {
		$a = get_post_meta( $id, $key, $sing );
		if ($a == '') {
			$row = _eb_q("SELECT meta_value
			FROM
				`" . wp_postmeta . "`
			WHERE
				post_id = " . $id . "
				AND meta_key = '" . $key . "'
			ORDER BY
				meta_id DESC
			LIMIT 0, 1");
//			print_r($row);
//			echo $id . "\n";
//			echo $key . "\n";
			
			//
			if ( isset($row[0]->meta_value) ) {
				$a = $row[0]->meta_value;
			}
			
			//
			if ($a == '') {
				$a = $default_value;
			}
		}
		
		//
		if ($a != '') {
			_eb_get_static_html ( $strCacheFilter, $a );
		}
	}
	
	//
	return $a;
}


// kiểm tra nếu có file html riêng -> sử dụng html riêng
function _eb_get_html_for_module ( $check_file ) {
	// kiểm tra ở thư mục code riêng
	if ( file_exists( EB_THEME_HTML . $check_file ) ) {
		$f = EB_THEME_HTML . $check_file;
	}
	// nếu không -> kiểm tra ở thư mục dùng chung
	else if ( file_exists( EB_THEME_PLUGIN_INDEX . 'html/' . $check_file ) ) {
		$f = EB_THEME_PLUGIN_INDEX . 'html/' . $check_file;
	}
	
	return file_get_contents( $f, 1 );
}

function _eb_get_private_html ( $f, $f2 = '' ) {
	$check = EB_THEME_HTML . $f;
	$dir = EB_THEME_HTML;
	
	//
	if ( $f2 == '' ) {
		$f2 = $f;
	}
	
	// sử dụng html riêng (nếu có)
	if ( file_exists($check) ) {
		$html = EB_THEME_HTML . $f2;
	}
	// mặc định là html chung
	else {
		$dir = EB_THEME_PLUGIN_INDEX . 'html/';
		
		$html = EB_THEME_PLUGIN_INDEX . 'html/' . $f2;
	}
	
	//
	return array(
		'dir' => $dir,
		'html' => file_get_contents( $html, 1 ),
	);
}



//
function _eb_get_full_category_v2($this_id = 0, $taxx = 'category') {
	global $web_link;
	
	$arr = get_categories( array(
		'taxonomy' => $taxx,
//			'hide_empty' => 0,
		'parent' => $this_id
	) );
//		print_r($arr);
	
	//
	$str = '';
	foreach ( $arr as $v ) {
//			print_r($v);
		
		//
//			$c_link = _eb_c_link( $v->term_id, $web_link . '?cat=' . $v->term_id );
		$c_link = $web_link . '?cat=' . $v->term_id;
		
		//
		$cat_order = 0;
		if ( $this_id == 0 ) {
			$cat_order = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
		}
		
		//
		$str .= ',{id:' . $v->term_id . ',ten:"' . _eb_str_block_fix_content ( $v->name ) . '",lnk:"' . $c_link . '",order:' . $cat_order . ',arr:[' . _eb_get_full_category_v2 ( $v->term_id, $taxx ) . ']}';
	}
	$str = substr ( $str, 1 );
	
	//
	return $str;
}




function _eb_get_tax_post_options ( $arr_option = array(), $taxo = 'post_options' ) {
//	global $func;
	
	/*
	* arr_option -> bao gồm các giá trị sau:
	* ul_before: nội dung khi bắt đầu UL -> trước LI đầu
	* ul_after: nội dung khi kết thúc UL -> sau LI cuối
	* ul_class: class CSS cho thẻ UL
	*
	* select_before: nội dung khi bắt đầu SELECT -> trước OPTION đầu
	* select_after: nội dung khi kết thúc SELECT -> sau OPTION cuối
	* select_class: class CSS cho thẻ SELECT
	*/
	
	
	$arrs = get_categories( array(
		'taxonomy' => $taxo,
//		'hide_empty' => 0,
		'parent' => 0,
	) );
	
	//
	$oders = array();
	$options = array();
	
	//
	foreach ( $arrs as $v ) {
		$oders[ $v->term_id ] = (int) _eb_get_post_meta( $v->term_id, '_eb_category_order', true, 0 );
		$options[$v->term_id] = $v;
	}
	arsort( $oders );
	
	//
	$javascripts = '';
	$strs = '';
	$selects = '';
	
	//
	foreach ( $oders as $k => $v ) {
		$v = $options[$k];
		
		//
		$arr = get_categories( array(
			'taxonomy' => 'post_options',
//			'hide_empty' => 0,
			'parent' => $v->term_id,
		) );
		
		//
		$oder = array();
		$option = array();
		
		//
		foreach ( $arr as $v2 ) {
			$oder[ $v2->term_id ] = (int) _eb_get_post_meta( $v2->term_id, '_eb_category_order', true, 0 );
			$option[$v2->term_id] = $v2;
		}
		arsort( $oder );
		
		//
		$javascript = '';
		$str = '';
		$select = '';
		foreach ( $oder as $k2 => $v2 ) {
			$v2 = $option[$k2];
			
			$op_link = _eb_c_link( $v2->term_id );
			
			$str .= '<li><a data-parent="' . $v->term_id . '" data-id="' . $v2->term_id . '" href="' . $op_link . '">' . $v2->name . '</a></li>';
			
			$select .= '<option value="' . $v2->term_id . '">' . $v2->name . '</option>';
			
			$javascript .= ',{id:"' . $v2->term_id . '",ten:"' . $v2->name . '",url:"' . $op_link . '"}';
		}
		
		//
		if ( $str != '' ) {
			
			//
			$strs .= '
			<li>
				<div class="search-advanced-padding click-add-id-to-sa">
					<div class="search-advanced-name"><a data-parent="0" data-id="' . $v->term_id . '" href="' . _eb_c_link( $v->term_id ) . '" title="' . $v->name . '">' . $v->name . ' <i class="fa fa-caret-down"></i></a></div>
					<ul class="sub-menu">
						' . $str . '
					</ul>
				</div>
			</li>';
			
			//
			$selects .= '
			<select class="change-add-id-to-sa">
				<option value="0">' . $v->name . '</option>
				' . $select . '
			</select>';
			
			//
			$javascripts .= ',{id:"' . $v->term_id . '",ten:"' . $v->name . '",arr:[' . substr( $javascript, 1 ) . ']}';
		}
	}
	
	// tổng hợp dữ liệu trả về
	if ( !isset( $arr_option['ul_before'] ) ) {
		$arr_option['ul_before'] = '';
	}
	if ( !isset( $arr_option['ul_after'] ) ) {
		$arr_option['ul_after'] = '';
	}
	if ( !isset( $arr_option['ul_class'] ) ) {
		$arr_option['ul_class'] = '';
	}
	
	if ( !isset( $arr_option['select_before'] ) ) {
		$arr_option['select_before'] = '';
	}
	if ( !isset( $arr_option['select_after'] ) ) {
		$arr_option['select_after'] = '';
	}
	if ( !isset( $arr_option['select_class'] ) ) {
		$arr_option['select_class'] = '';
	}
	
	
	// js
//	if ( $type == 'js' ) {
//	}
	// html
//	else {
		return '
		<ul class="widget-search-advanced ul-eb-postoptions ' . $arr_option['ul_class'] . '">' . $arr_option['ul_before'] . $strs . $arr_option['ul_after'] . '</ul>
		<div class="select-eb-postoptions ' . $arr_option['select_class'] . '2 d-none">' . $arr_option['select_before'] . $selects . $arr_option['select_after'] . '</div>
		<script type="text/javascript">var js_eb_postoptions=[' . substr( $javascripts, 1 ) . '];</script>';
//	}
}




/*
* chức năng thay thế cho hàm thread-remove-endbegin trên javascript
*/
function _eb_thread_remove_endbegin ( $arr, $begin = 0, $end = 0, $tag = '</li>' ) {
	$arr = explode( $tag, $arr );
	$str = '';
//	$str = array();
	foreach ( $arr as $k => $v ) {
		if ( $k >= $begin && $k <= $end ) {
			$v = trim( $v );
			if ( $v != '' ) {
				$str .=  '<!-- ' . $k . ' -->' . $v . $tag;
			}
//			$str[] =  '<!-- ' . $k . ' -->' . $v;
		}
	}
	
	return $str;
//	return implode( $tag, $str );
}



function _eb_selected ( $k, $v ) {
	return $k == $v ? ' selected="selected"' : '';
}




function _eb_parse_args ( $arr, $default ) {
	// sử dụng hàm của wp
	return wp_parse_args ( $arr, $default );
}

function _eb_widget_parse_args ( $arr, $default ) {
	// tìm ở mảng default -> nếu mảng chính không có thì gán thêm vào
	/*
	foreach ( $default as $k => $v ) {
		if ( ! isset( $arr[$k] ) ) {
			$arr[$k] = $v;
		}
	}
	*/
	
	// bỏ HTML cho mảng chính
	foreach ( $arr as $k => $v ) {
		$arr [$k] = strip_tags ( $v );
	}
	
	return $arr;
}




function _eb_update_option ( $name, $value ) {
	global $wpdb;
	
	_eb_q("UPDATE `" . $wpdb->options . "`
	SET
		option_value = '" . $value . "'
	WHERE
		option_name = '" . $name . "'");
}




function EBE_create_in_con_voi_table ( $table, $pri_key, $arr ) {
	
	// mảng các cột mẫu
//	print_r($arr);
//	$arr = array_reverse( $arr );
//	print_r($arr);
	
	// các cột hiện tại trong database
	$arr_check = _eb_q( "SHOW TABLES LIKE '" . $table . "'" );
	
	// nếu chưa có bảng hóa đơn
	if ( count( $arr_check ) == 0 ) {
		
		//  -> thêm bảng -> thêm cột khóa chính
		$sql = trim('
		CREATE TABLE `' . $table . '` (
			`' . $pri_key . '` ' . strtoupper( $arr[ $pri_key ]['type'] ) . ' NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		');
		_eb_q($sql);
		
		// tạo khóa chính
		$sql = trim('ALTER TABLE `' . $table . '` ADD PRIMARY KEY(`' . $pri_key . '`)');
		_eb_q($sql);
		
		// sửa lại cột
		$sql = trim('ALTER TABLE `' . $table . '` CHANGE `' . $pri_key . '` `' . $pri_key . '` ' . strtoupper( $arr[ $pri_key ]['type'] ) . ' NOT NULL AUTO_INCREMENT' );
		_eb_q($sql);
		
		// lấy lại danh sách cột sau khi tạo mới
		$arr_check = _eb_q( "SHOW TABLES LIKE '" . $table . "'" );
		
	}
	//print_r( $arr_check );
	
	// cấu trúc bảng
	$strsql = _eb_q( "DESCRIBE `" . $table . "`" );
//	print_r( $strsql );
	
	// chạy lệnh để kiểm tra cột có hay chưa
	$arr_current = array();
	foreach ( $strsql as $v2 ) {
//		print_r( $v2 );
		$v2 = (array)$v2;
//		print_r( $v2 );
		
		$arr_current[ $v2['Field'] ] = 1;
	}
//	print_r( $arr_current );
	
	//
	$first_cloumn = $pri_key;
	foreach ( $arr as $k => $v ) {
		if ( ! isset( $arr_current[$k] ) ) {
			$v['field'] = $k;
			
			//
			$sql = 'ALTER TABLE `' . $table . '` ADD `' . $k . '` ' . strtoupper( $v['type'] ) . ' ' . ( $v['null'] == 'no' ? 'NOT NULL' : 'NULL' ) . ' AFTER `' . $first_cloumn . '`;';
//			echo $sql . "\n";
			_eb_q( $sql );
			
			// UNIQUE
			if ( $v['key'] == 'uni' ) {
				$sql = 'ALTER TABLE `' . $table . '` ADD UNIQUE(`' .$k. '`)';
//				echo $sql . "\n";
				_eb_q( $sql );
			}
			// INDEX
			else if ( $v['key'] == 'mul' ) {
				$sql = 'ALTER TABLE `' . $table . '` ADD INDEX(`' .$k. '`);';
//				echo $sql . "\n";
				_eb_q( $sql );
			}
//			echo $sql . "\n";
//			_eb_q( $sql );
		}
		
		// thay đổi cột tiếp theo
		$first_cloumn = $k;
	}
}



function EBE_tao_bang_hoa_don_cho_echbay_wp () {
	
	//
	EBE_create_in_con_voi_table( 'eb_in_con_voi', 'order_id', array(
		'order_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'pri',
			'default' => '',
			'extra' => 'auto_increment',
		),
		'order_sku' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'order_products' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_customer' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_agent' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_ip' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'order_time' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_status' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'tv_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
	) );
	
	EBE_create_in_con_voi_table( 'eb_details_in_con_voi', 'dorder_id', array(
		'dorder_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'pri',
			'default' => '',
			'extra' => 'auto_increment',
		),
		'dorder_key' => array(
			'type' => 'varchar(191)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
		'dorder_name' => array(
			'type' => 'longtext',
			'null' => 'no',
			'key' => '',
			'default' => '',
			'extra' => '',
		),
		'order_id' => array(
			'type' => 'bigint(20)',
			'null' => 'no',
			'key' => 'mul',
			'default' => '',
			'extra' => '',
		),
	) );
	
}



function EBE_part_page($Page, $TotalPage, $strLinkPager) {
	$show_page = 8;
	$str_page = '';
	if ($Page <= $show_page) {
		if ($TotalPage <= $show_page) {
			for ($i = 1; $i <= $TotalPage; $i++) {
				if ($i == $Page) {
					$str_page .= '<strong>' .$i. '</strong>';
				} else {
					$str_page .= '<a rel="nofollow" href="' .$strLinkPager . $i. '">' .$i. '</a>';
				}
			}
		} else {
			for ($i = 1; $i <= $show_page; $i++) {
				if ($i == $Page) {
					$str_page .= '<strong>' .$i. '</strong>';
				} else {
					$str_page .= '<a rel="nofollow" href="' .$strLinkPager . $i. '">' .$i. '</a>';
				}
			}
			$str_page .= ' ... <a rel="nofollow" href="' .$strLinkPager .$i. '">&gt;</a>';
		}
	} else {
		$chiadoi = $show_page / 2;
		$i = $Page - ($chiadoi + 1);
		$str_page = '<a rel="nofollow" href="' .$strLinkPager .$i. '">&lt;&lt;</a> <a rel="nofollow" href="' .$strLinkPager. '1">1</a> ... ';
		$i++;
		for ($i; $i < $Page; $i++) {
			$str_page .= '<a rel="nofollow" href="' .$strLinkPager . $i. '">' .$i. '</a>';
		}
		$str_page .= '<strong>' .$i. '</strong>';
		$i++;
		$_Page = $Page + $chiadoi;
		if ($_Page > $TotalPage) {
			$_Page = $TotalPage;
		}
		for ($i; $i < $_Page; $i++) {
			$str_page .= '<a rel="nofollow" href="' .$strLinkPager . $i. '">' .$i. '</a>';
		}
		$str_page .= ' ... <a rel="nofollow" href="' .$strLinkPager . $TotalPage. '">' .$TotalPage. '</a> <a href="' .$strLinkPager .$i. '" rel="nofollow">&gt;&gt;</a>';
	}
	
	return $str_page;
}


function EBE_part_page_ajax($Page, $TotalPage, $strLinkPager, $return) {
	$show_page = 8;
	$str_page = '';
	if ($Page <= $show_page) {
		if ($TotalPage <= $show_page) {
			for ($i = 1; $i <= $TotalPage; $i++) {
				if ($i == $Page) {
					$str_page .= ' <a title="Trang ' .$i. '" href="javascript:;"><span class="bold">[ ' .$i. ' ]</span></a>';
				} else {
					$str_page .= ' <a title="Trang ' .$i. '" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">' .$i. '</a>';
				}
			}
		} else {
			for ($i = 1; $i <= $show_page; $i++) {
				if ($i == $Page) {
					$str_page .= ' <a title="Trang ' .$i. '" href="javascript:;"><span class="bold">[ ' .$i. ' ]</span></a>';
				} else {
					$str_page .= ' <a title="Trang ' .$i. '" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">' .$i. '</a>';
				}
			}
			$str_page .= ' ... <a title="Tiếp" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">&gt;&gt;</a>';
		}
	} else {
		$chiadoi = $show_page / 2;
		$i = $Page - ($chiadoi + 1);
		$str_page = '<a title="Trước" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">&lt;&lt;</a> <a title="Trang 1" onclick="ajaxl(\'' .$strLinkPager. '1\',\''.$return.'\',1)" href="javascript:;">1</a> ... ';
		$i++;
		for ($i; $i < $Page; $i++) {
			$str_page .= ' <a title="Trang ' .$i. '" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">' .$i. '</a>';
		}
		$str_page .= ' <a title="Trang ' .$i. '" href="javascript:;"><span class="bold">[ ' .$i. ' ]</span></a>';
		$i++;
		$_Page = $Page + $chiadoi;
		if ($_Page > $TotalPage) {
			$_Page = $TotalPage;
		}
		for ($i; $i <= $_Page; $i++) {
			$str_page .= ' <a title="Trang ' .$i. '" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">' .$i. '</a>';
		}
		$str_page .= ' ... <a title="Tiếp" onclick="ajaxl(\'' .$strLinkPager . $i. '\',\''.$return.'\',1)" href="javascript:;">&gt;&gt;</a>';
	}
	return '<div class="public-part-page"><span class="bold">Trang: </span> ' .$str_page. '</div>';
}





function EBE_check_list_post_null ( $str = '' ) {
	if ( $str == '' ) {
		global $__cf_row;
		
		$__cf_row ["cf_blog_public"] = 0;
		
		$str = '
		<li class="no-set-width-this-li" style="width:100% !important;padding:0;margin:0;">
			<div class="text-center big bold" style="padding:90px 20px;">Chưa có dữ liệu</div>
		</li>';
	}
	
	return $str;
}



// ebp -> ech bay post
function EBE_print_product_img_css_class ( $arr, $in = 'Header' ) {
	echo '<!-- EchBay Product Image in ' . $in . ' -->
<style type="text/css">' . str_replace( 'http://' . $_SERVER['HTTP_HOST'] . '/', './', str_replace( 'https://' . $_SERVER['HTTP_HOST'] . '/', './', implode( "\n", $arr ) ) ) . '</style>';
}



function EBE_set_header ( $status = 200 ) {
	// Chuyển header sang 200
	if ( $status == 200 ) {
		$pcol = ( isset($_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		//echo $pcol;
		header( $pcol . ' 200 OK' );
	}
}



function EBE_get_css_for_config_design ( $f, $type = '.php' ) {
	return EB_THEME_PLUGIN_INDEX . 'themes/css/' . str_replace( $type, '.css', $f );
}



