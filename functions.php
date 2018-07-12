<?php




// lấy sản phẩm theo mẫu chung
function EBE_select_thread_list_all ( $post, $html = __eb_thread_template, $pot_tai = 'category', $other_options = array() ) {
	global $__cf_row;
	global $wpdb;
	global $eb_background_for_post;
//	global $eb_background_for_mobile_post;
	
//	print_r( $other_options );
	
	//
	$ant_ten = '';
	$ant_option = '';
	$ant_tags = '';
	
	//
//	print_r( $post );
//	print_r( $__cf_row ); exit();
	
	// truyền các giá trị cho HTML cũ có thể chạy được
	
	
	// riêng với mục quảng cáo -> kiểm tra xem có alias tới post, page, blog nào không
	$anh_dai_dien_goc = '';
	$ads_id = $post->ID;
	if ( $post->post_type == 'ads' ) {
		// lấy ảnh đại diện gốc để dùng trong trường hợp q.cáo có ảnh riêng
		$anh_dai_dien_goc = _eb_get_post_img( $post->ID, $__cf_row['cf_ads_thumbnail_size'] );
		
		//
		$alias_post = _eb_number_only( _eb_get_post_object( $post->ID, '_eb_ads_for_post', 0 ) );
		$alias_taxonomy = _eb_number_only( _eb_get_post_object( $post->ID, '_eb_ads_for_category', 0 ) );
		
		// nếu có -> nạp thông tin post, page... mà nó alias tới
		if ( $alias_post > 0 ) {
			$sql = _eb_q("SELECT *
			FROM
				`" . wp_posts . "`
			WHERE
				ID = " . $alias_post . "
				AND post_status = 'publish'");
//			print_r( $sql );
			// gán post mới nếu có
			if ( ! empty( $sql ) ) {
				$post = $sql[0];
			}
		}
	}
	
	
	// với quảng cáo thì lấy link theo kiểu quảng cáo
	if ( $post->post_type == 'ads' ) {
//		echo $alias_taxonomy;
		
		// Nếu có link trỏ tới 1 nhóm nào đó -> lấy link và tên nhóm để gán cho post này
		if ( $alias_taxonomy > 0 ) {
			$new_name = WGR_get_all_term( $alias_taxonomy );
//			print_r( $new_name );
			
			//
			if ( ! isset($new_name->errors) ) {
				$post->post_title = $new_name->name;
//				$post->p_link = _eb_c_link( $alias_taxonomy, $new_name->taxonomy );
				$post->p_link = _eb_cs_link( $new_name );
				
				//
				$post->post_excerpt = $new_name->description;
			}
		}
		else {
			$post->p_link = _eb_get_post_meta( $post->ID, '_eb_ads_url', true, 'javascript:;' );
		}
		
		// đặt ảnh đại diện cho phần q.cáo
		$post->trv_img = $anh_dai_dien_goc;
		
		//
		$youtube_id = _eb_get_youtube_id( _eb_get_post_meta( $post->ID, '_eb_ads_video_url' ) );
//		$youtube_id = _eb_get_youtube_id( _eb_get_ads_object( $post->ID, '_eb_ads_video_url' ) );
		$youtube_url = 'about:blank';
		$youtube_avt = '';
		if ( $youtube_id != '' ) {
//			$youtube_url = '//www.youtube.com/watch?v=' . $youtube_id;
			$youtube_url = '//www.youtube.com/embed/' . $youtube_id;
			$youtube_avt = '//i.ytimg.com/vi/' . $youtube_id . '/0.jpg';
		}
		$post->youtube_id = $youtube_id;
		$post->youtube_url = $youtube_url;
		$post->youtube_avt = $youtube_avt;
	} else {
		// sử dụng ảnh riêng của q.cáo (nếu có)
		if ( $anh_dai_dien_goc != '' ) {
			$post->trv_img = $anh_dai_dien_goc;
		}
		// sử dụng ảnh mặc định của post
		else {
			$post->trv_img = _eb_get_post_img( $post->ID, $__cf_row['cf_product_thumbnail_size'] );
			$ads_id = $post->ID;
		}
		
		// nếu có lệnh lấy full nội dung -> lấy luôn
		if ( isset( $other_options['get_full_content'] ) && $other_options['get_full_content'] == 1 ) {
			$post->post_excerpt = $post->post_content;
		}
//		else if ( $post->post_type == 'blog' && $post->post_excerpt == '' ) {
		else if ( $post->post_excerpt == '' && $__cf_row['cf_content_for_excerpt_null'] > 69 ) {
			$post->post_excerpt = _eb_short_string( strip_tags ( $post->post_content ), $__cf_row['cf_content_for_excerpt_null'] );
//			$post->post_excerpt = 'bbbbbbbb';
		}
		/*
		else {
			$post->post_excerpt = nl2br( $post->post_excerpt );
		}
		*/
		
		//
		$post->p_link = _eb_p_link( $post->ID );
		
		
		
		// blog
		if ( $post->post_type == EB_BLOG_POST_TYPE ) {
			$pot_tai = EB_BLOG_POST_LINK;
			
			// tags
			$arr_list_tag = wp_get_object_terms( $post->ID, 'blog_tag' );
			
		}
		// product
		else {
			
			// post option
			$arr_post_options = wp_get_object_terms( $post->ID, 'post_options' );
			if ( ! empty ( $arr_post_options ) ) {
//				print_r( $arr_post_options );
				
				//
				foreach ( $arr_post_options as $v ) {
					if ( $v->parent > 0 ) {
						$parent_name = WGR_get_taxonomy_parent( $v );
						
						//
						$ant_option .= '<span>' . $parent_name->name . '</span>: <a href="' . _eb_cs_link( $v ) . '" target="_blank">' . $v->name . '</a> ';
					}
				}
				$ant_option = '<span class="thread-list-options">' . $ant_option . '</span>';
			}
			
			
			// tags
			$arr_list_tag = get_the_tags( $post->ID );
			
			
			
			// các thuộc tính chỉ ở sản phẩm mới có
			$post->trv_masanpham = _eb_get_post_object( $post->ID, '_eb_product_sku', $post->ID );
			
			$post->trv_mua = (int) _eb_get_post_object( $post->ID, '_eb_product_buyer', 0 );
			
			//
			$post->trv_giaban = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_oldprice' ) );
			
			$post->trv_giamoi = _eb_float_only( _eb_get_post_object( $post->ID, '_eb_product_price' ) );
			
			if ( $post->trv_giaban <= $post->trv_giamoi ) {
				$post->trv_giaban = 0;
			}
			
			$post->trv_num_giacu = $post->trv_giaban;
			$post->trv_num_giamoi = $post->trv_giamoi;
			
			//
			$post->trv_color_count = 1;
			
			$post->trv_trangthai = 1;
//			$post->trv_ngayhethan = date_time;
			$post->trv_ngayhethan = '';
			
			
			
			//
			$post->pt = 0;
			if ( $post->trv_giaban > $post->trv_giamoi ) {
				$post->pt = 100 - _eb_float_only( $post->trv_giamoi * 100 / $post->trv_giaban, 1 );
			}
			
			//
			$post->trv_giaban = EBE_add_ebe_currency_class( $post->trv_giaban, 1, '&nbsp;' );
			
			$post->trv_giamoi = EBE_add_ebe_currency_class( $post->trv_giamoi );
			
			$post->product_status = _eb_get_post_object( $post->ID, '_eb_product_status', $post->post_status );
			
		}
		
		// -> tag
		if ( ! empty ( $arr_list_tag ) ) {
//			print_r( $arr_list_tag );
			
			//
			foreach ( $arr_list_tag as $v ) {
				$ant_tags .= '<a href="' . get_tag_link( $v->term_id ) . '">' . $v->name . '</a> ';
			}
			$ant_tags = '<span class="thread-list-tags">' . $ant_tags . '</span>';
		}
		
		
		// lấy danh mục sản phẩm
//		$ant = get_the_category( $post->ID );
		$ant = get_the_terms( $post->ID, $pot_tai );
//		print_r( $ant );
		if ( ! empty( $ant ) ) {
			foreach ( $ant as $v ) {
				// ưu tiên lấy nhóm con trước
				if ( $ant_ten == '' && $v->parent > 0 ) {
					$ant_ten = '<a href="' . _eb_cs_link( $v ) . '">' . $v->name . '</a>';
					break;
				}
			}
			
			// nếu ko tìm được -> lấy luôn nhóm cha đầu tiên
			if ( $ant_ten == '' ) {
				foreach ( $ant as $v ) {
					$ant_ten = '<a href="' . _eb_cs_link( $v ) . '">' . $v->name . '</a>';
					break;
				}
			}
		}
		
//		$post->ant_ten = isset ($ant[0]->name ) ? '<a href="' . _eb_cs_link( $ant[0] ) . '">' . $ant[0]->name . '</a>' : '';
		
	}
	$post->ant_ten = $ant_ten;
	$post->ant_option = $ant_option;
	$post->ant_tags = $ant_tags;
	
	
	
//	$post->p_link = $post->guid;
	$post->trv_tieude = $post->post_title;
	$post->trv_title = str_replace( '"', '&quot;', trim( strip_tags( $post->post_title ) ) );
	$post->trv_id = $post->ID;
	$post->trv_gioithieu = nl2br( $post->post_excerpt );
//	$post->trv_gioithieu = $post->post_excerpt;
	
	//
//	$post_time = strtotime( $post->post_modified );
	$post_time = strtotime( $post->post_date );
//	$post->ngaycapnhat = date( 'd/m/Y', $post_time );
	$post->ngaycapnhat = date( $__cf_row['cf_date_format'], $post_time );
	$post->ngaycapnhats = $post->ngaycapnhat . ' ' . date( $__cf_row['cf_time_format'], $post_time );
	
	$post->cf_product_size = $__cf_row['cf_product_size'];
	$post->cf_blog_size = $__cf_row['cf_blog_size'];
	
	
	// load ảnh đại diện cho phần quảng cáo
	// lấy ảnh đại diện kích thước medium ( chỉnh trong wp-admin/options-media.php )
	if ( $__cf_row['cf_product_thumbnail_table_size'] == $__cf_row['cf_product_thumbnail_size'] ) {
		$post->trv_table_img = $post->trv_img;
	} else {
		$post->trv_table_img = _eb_get_post_img( $ads_id, $__cf_row['cf_product_thumbnail_table_size'] );
	}
	
	if ( $__cf_row['cf_product_thumbnail_mobile_size'] == $__cf_row['cf_product_thumbnail_table_size'] ) {
		$post->trv_mobile_img = $post->trv_table_img;
	} else {
		$post->trv_mobile_img = _eb_get_post_img( $ads_id, $__cf_row['cf_product_thumbnail_mobile_size'] );
	}
	
	
	//
	$html = EBE_dynamic_title_tag( $html );
	
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


function WGR_get_taxonomy_parent ( $arr ) {
//	$a = get_term_by( 'id', $arr->parent, $arr->taxonomy );
	$a = get_term( $arr->parent, $arr->taxonomy );
//	print_r( $a );
	
	// tìm đến khi lấy được nhóm cấp 1 thì thôi
	if ( $a->parent > 0 ) {
		$a = WGR_get_taxonomy_parent( $a );
	}
	
	return $a;
}


// tạo thẻ động cho phần tiêu đề sản phẩm, blog
function EBE_dynamic_title_tag ( $html, $tag = '' ) {
	// lấy tag mặc định
	if ( $tag == '' ) {
		global $__cf_row;
		
		$tag = $__cf_row['cf_threadnode_title_tag'];
	}
//	echo '<!-- =========================== ' . $tag . ' =========================== -->';
	
	// tạo thẻ đóng
	$html = str_replace( 'dynamic_title_tag>', $tag . '>', $html );
	// tạo thẻ mở
	$html = str_replace( '<dynamic_title_tag', '<' . $tag . ' dynamic-title-tag="1"', $html );
	
	return $html;
}


function WGR_money_format ( $n ) {
	$n = explode( '.', $n );
	
	// định dạng tiền USD
	if ( isset( $n[1] ) ) {
		return number_format( $n[0] ) . '.' . $n[1];
	}
	
	// Tiền Việt
	return number_format( $n[0] );
}

function EBE_add_ebe_currency_class ( $gia, $gia_cu = 0, $default_value = '' ) {
	
	//
	$str = $default_value;
	
	// giá mới
	if ( $gia_cu == 0 ) {
		if ( $gia > 0 ) {
			$str = '<strong data-num="' . $gia . '" class="global-details-giamoi ebe-currency ebe-currency-format">&nbsp;</strong>';
		}
		else {
			$str = '<strong class="global-details-giamoi global-details-gialienhe">{tmp.post_zero}</strong>';
		}
	}
	// giá cũ
	else if ( $gia > 0 ) {
		$str = '<span data-num="' . $gia . '" class="global-details-giacu old-price ebe-currency ebe-currency-format">&nbsp;</span>';
	}
	
	// Giá trị mặc định
	return $str;
	
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
	return 'File "' .$f. '" not found.';
}

// thay thế các văn bản trong html tìm được
function EBE_html_template ( $html, $arr = array() ) {
	foreach ($arr as $k => $v) {
		$html = str_replace('{' .$k. '}', $v, $html);
	}
	
	return $html;
}

// tạo tên class riêng theo config
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
		`" . wp_posts . "`
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
//	global $arr_for_add_theme_css;
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
	
	// kiểm tra trong child theme
	$tmp_child_theme = '';
	if ( using_child_wgr_theme == 1 ) {
		$tmp_child_theme = EB_CHILD_THEME_URL . 'html/' . $page_name . '.html';
//		echo $tmp_child_theme . '<br>' . "\n";
	}
	
	// không có HTML động -> lấy file tĩnh theo theme
	$f = $dir . $page_name . '.html';
//	echo $f . '<br>';
	
	// tìm trong thư mục theme riêng (ưu tiên)
	if ( $tmp_child_theme != '' && file_exists($tmp_child_theme) ) {
		$f = $tmp_child_theme;
		
		$arr_for_show_html_file_load[] = '<!-- child theme HTML: ' . $page_name . ' -->';
		
		$html = file_get_contents($f, 1);
		
		// dùng chung thì gán CSS dùng chung luôn (nếu có)
		$css = EB_CHILD_THEME_URL . 'css/' . $page_name . '.css';
//		echo $css;
//		if ( file_exists( $css ) ) {
//			$arr_for_add_theme_css[ $css ] = 1;
			$arr_for_add_css[ $css ] = 1;
			
//			$arr_for_show_html_file_load[] = '<!-- child theme CSS: ' . $page_name . ' -->';
//		}
	}
	else if ( file_exists($f) ) {
		$arr_for_show_html_file_load[] = '<!-- theme HTML: ' . $page_name . ' -->';
		
		$html = file_get_contents($f, 1);
		
		// dùng chung thì gán CSS dùng chung luôn (nếu có)
		$css = EB_THEME_THEME . 'css/' . $page_name . '.css';
//		echo $css;
//		if ( file_exists( $css ) ) {
//			$arr_for_add_theme_css[ $css ] = 1;
			$arr_for_add_css[ $css ] = 1;
			
//			$arr_for_show_html_file_load[] = '<!-- theme CSS: ' . $page_name . ' -->';
//		}
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
//		if ( file_exists( $css ) ) {
			$arr_for_add_css[ $css ] = 1;
			
//			$arr_for_show_html_file_load[] = '<!-- global CSS: ' . $page_name . ' -->';
//		}
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
			echo '<script type="text/javascript" src="' . $v . '"></script>' . "\n";
		}
//	}
	
	//
	/*
	echo '<script type="text/javascript" src="';
	echo implode( '?v=' . web_version . '"></script>' . "\n" . '<script type="text/javascript" src="', $arr );
	echo '"></script>';
	*/
	
}

function EBE_add_js_compiler_in_cache (
	$arr_eb_add_full_js,
	$async = '',
	// có tối ưu nội dung file hay không
	$optimize = 0
) {
	
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
	$full_file_name = '';
	foreach ( $arr_eb_add_full_js as $v ) {
		if ( file_exists( $v ) ) {
//			$file_name_cache .= basename( $v ) . filemtime( $v );
			
			// thời gian cập nhật file
//			$file_time = filemtime ( $v );
//			$file_name_cache .= basename( $v, '.js' ) . substr( $file_time, strlen($file_time) - 3 );
			
			// chỉ lấy mỗi tên file, thời gian cập nhật file thì cho định kỳ cho nhẹ
			$file_name = basename( $v, '.js' );
			
			$full_file_name .= '+' . $file_name;
			
			$file_name_cache .= $file_name;
		}
	}
//	echo $file_name_cache . '<br>' . "\n";
	$file_name_cache = md5( $file_name_cache );
	$file_show = $file_name_cache;
	
	// thêm khoảng thời gian lưu file
	$current_server_minute = (int) substr( date( 'i', date_time ), 0, 1 );
	$file_name_cache = 'zjs-' . $file_name_cache . '-' . $current_server_minute . '.js';
	
	// file hiển thị sẽ hiển thị sớm hơn chút
	if ( $current_server_minute == 0 ) {
		$current_server_minute = 5;
	}
	else {
		$current_server_minute = $current_server_minute - 1;
	}
	$file_show = 'zjs-' . $file_show . '-' . $current_server_minute . '.js';
	
	
	// nếu file có rồi -> nhúng luôn file
//	$file_in_cache = ABSPATH . EB_DIR_CONTENT . '/uploads/ebcache/' . $file_name_cache;
	$file_in_cache = EB_THEME_CACHE . $file_name_cache;
	// chỉ cập nhật file khi có sự thay đổi
//	if ( file_exists( $file_in_cache ) ) {
	// cập nhật file định kỳ
	if ( ! file_exists( $file_in_cache ) || date_time - filemtime ( $file_in_cache ) + rand( 0, 300 ) > 1800 ) {
		
		//
		$new_content = '';
		foreach ( $arr_eb_add_full_js as $v ) {
			// xem file có tồn tại không
			if ( file_exists( $v ) ) {
	//			echo $v . "\n";
				
				// xem trong cache có chưa
	//			$file_name_cache = basename( $v ) . filemtime( $v ) . '.js';
	//			$file_in_cache = ABSPATH . EB_DIR_CONTENT . '/uploads/ebcache/' . $file_name_cache;
				
				// nếu chưa có -> tạo cache
	//			if ( ! file_exists( $file_in_cache ) ) {
	//				echo $file_in_cache . "\n";
					
					//
					$file_content = file_get_contents( $v, 1 );
					
					// thu gọn nội dung
					if ( $optimize == 1 ) {
						$file_content = WGR_remove_js_multi_comment( $file_content );
						$file_content = explode( "\n", $file_content );
						
						foreach ( $file_content as $v ) {
							$v = trim( $v );
							
							if ( $v == '' || substr( $v, 0, 2 ) == '//' ) {
							}
							else {
								if ( strstr( $v, '//' ) == true ) {
									$v .= "\n";
								}
								$new_content .= $v;
							}
						}
					}
					// chỉ gộp nội dung thành 1 file
					else {
						$new_content .= $file_content . "\n";
					}
					
					//
					/*
					$file_content = explode( "\n", $file_content );
					foreach ( $file_content as $v ) {
						$v = trim( $v );
						
						// tối ưu sơ qua cho nội dung
						if ( $v == '' || substr( $v, 0, 2 ) == '//' ) {
						}
						// tối ưu sâu hơn chút
						else if ( $optimize == 1 ) {
							if ( strstr( $v, '//' ) == true ) {
								$v .= "\n";
							}
							$new_content .= $v;
						}
						// gần như không làm gì cả
						else {
							$new_content .= $v . "\n";
						}
					}
					*/
	//			}
			}
		}
		
		//
		_eb_create_file( $file_in_cache, create_cache_infor_by( $full_file_name ) . $new_content );
		
		// chưa có file phụ -> tạo luôn file phụ
		if ( ! file_exists( EB_THEME_CACHE . $file_show ) ) {
			if ( copy( $file_in_cache, EB_THEME_CACHE . $file_show ) ) {
				chmod( EB_THEME_CACHE . $file_show, 0777 );
			}
		}
		
		// cập nhật lại version để css mới nhận nhanh hơn
//		_eb_set_config( 'cf_web_version', date( 'md.Hi', date_time ), 0 );
		
	}
	
	//
	echo '<!-- ' . $file_name_cache . ' --><script type="text/javascript" src="' . EB_DIR_CONTENT . '/uploads/ebcache/' . $file_show . '?v=' . web_version . '" ' . $async . '></script>' . "\n";
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
					/*
					$arr_css_new_content = array(
						'../images/' => './' . EB_DIR_CONTENT . '/themes/' . basename( get_template_directory() ) . '/images/',
//							'../../../../plugins/' => '../../plugins/',
						
						// các css ngoài -> trong outsource -> vd: font awesome
//							'../../../../plugins/' => EB_DIR_CONTENT . '/plugins/',
//							'../outsource/' => EB_DIR_CONTENT . '/plugins/echbaydotcom/outsource/',
						'../outsource/' => EB_DIR_CONTENT . '/echbaydotcom/outsource/',
						
						'../fonts/' => EB_DIR_CONTENT . '/echbaydotcom/outsource/fonts/',
						
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
					*/
					
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
					/*
					foreach ( $arr_css_new_content as $k => $v ) {
						$new_content = str_replace( $k, $v, $new_content );
					}
					*/
					$new_content = EBE_replace_link_in_cache_css ( $new_content );
					
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
//		$none_http_url = str_replace( 'http://', '//', content_url() );
		$none_http_url = EB_DIR_CONTENT;
//		$none_http_url = basename( EB_THEME_CONTENT );
		
		//
		if ( $file_type == '.js' ) {
			
			// tạo nội dung nhúng file css
			$f_url = $none_http_url . '/uploads/ebcache/' . $f_filename;
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
		
		': ' => ':',
	);
	
	//
//	print_r( $arr );
	$arr = array_merge( $arr, $new_array );
//	print_r( $arr );
	
	foreach ( $arr as $k => $v ) {
		$str = str_replace( $k, $v, $str );
	}
	
	return $str;
}

// khi file css nằm trong cache
function EBE_replace_link_in_cache_css ( $c ) {
	return _eb_replace_css_space ( $c, array(
		// IMG của theme
//		'../images/' => '../../themes/' . basename( get_template_directory() ) . '/images/',
		'../images/' => '../../themes/' . basename( EB_THEME_URL ) . '/images/',
		
		// IMG của plugin tổng
//		'../../images-global/' => EB_URL_OF_PLUGIN . 'images-global/',
		'../../images-global/' => '../../echbaydotcom/images-global/',
//		'../images-global/' => EB_URL_OF_PLUGIN . 'images-global/',
		'../images-global/' => '../../echbaydotcom/images-global/',
		
		// các css ngoài -> trong outsource -> vd: font awesome
		'../outsource/' => '../../echbaydotcom/outsource/',
		'../fonts/' => '../../echbaydotcom/outsource/fonts/',
	) );
}

// khi css thuộc dạng inline (hiển thị trực tiếp trong HTML)
function EBE_replace_link_in_css ( $c ) {
	return _eb_replace_css_space ( $c, array(
//		'../images/' => './' . EB_DIR_CONTENT . '/themes/' . basename( get_template_directory() ) . '/images/',
		'../images/' => './' . EB_DIR_CONTENT . '/themes/' . basename( EB_THEME_URL ) . '/images/',
//		'../../images-global/' => EB_URL_OF_PLUGIN . 'images-global/',
		'../../images-global/' => './' . EB_DIR_CONTENT . '/echbaydotcom/images-global/',
//		'../images-global/' => EB_URL_OF_PLUGIN . 'images-global/',
		'../images-global/' => './' . EB_DIR_CONTENT . '/echbaydotcom/images-global/',
		
		// các css ngoài -> trong outsource -> vd: font awesome
		'../outsource/' => './' . EB_DIR_CONTENT . '/echbaydotcom/outsource/',
		
		'../fonts/' => './' . EB_DIR_CONTENT . '/echbaydotcom/outsource/fonts/',
	) );
}

function WGR_remove_css_multi_comment ( $a ) {
	
	$a = explode( '*/', $a );
	$str = '';
	foreach ( $a as $v ) {
		$v = explode('/*', $v);
		$str .= $v[0];
	}
	
	//
	$a = explode( "\n", $str );
	$str = '';
	foreach ( $a as $v ) {
		$v = trim( $v );
		if ( $v != '' ) {
			$str .= $v;
		}
	}
	
	// bỏ các ký tự thừa nhiều nhất có thể
	$str = str_replace( '; }', '}', $str );
	$str = str_replace( ';}', '}', $str );
	$str = str_replace( ' { ', '{', $str );
	$str = str_replace( ' {', '{', $str );
	$str = str_replace( ', .', ',.', $str );
	$str = str_replace( ', #', ',#', $str );
	$str = str_replace( ': ', ':', $str );
	$str = str_replace( '} .', '}.', $str );
	
	// thay url ảnh của child theme thành url tuyệt đối
	if ( using_child_wgr_theme == 1 ) {
		$str = str_replace( '../images-child/', str_replace( '\\', '/', str_replace( ABSPATH, web_link, EB_CHILD_THEME_URL ) ) . 'images-child/', $str );
		$str = str_replace( '../image-child/', str_replace( '\\', '/', str_replace( ABSPATH, web_link, EB_CHILD_THEME_URL ) ) . 'image-child/', $str );
	}
	
	return $str;
	
}

function WGR_remove_js_multi_comment ( $a ) {
	
	$str = $a;
	
	$b = explode( '/*', $a );
	$a = explode( '*/', $a );
	
	// nếu số thẻ đóng với thẻ mở khác nhau -> hủy luôn
	if ( count( $a ) != count( $b ) ) {
		return $str;
//		return _eb_str_block_fix_content( $str );
	}
	
	//
	$str = '';
	
	//
	foreach ( $a as $v ) {
		$v = explode('/*', $v);
		$str .= $v[0];
	}
	
	return $str;
//	return _eb_str_block_fix_content( $str );
	
}

// add css thẳng vào HTML
function _eb_add_compiler_css ( $arr ) {
//	print_r( $arr );
	
	/*
	// nếu là dạng tester -> chỉ có 1 kiểu add thôi
	if ( eb_code_tester == true ) {
		_eb_add_compiler_css_v2( $arr );
	}
	// sử dụng thật thì có 2 kiểu add: inline và add link
	else {
		*/
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
		
		// nếu là dạng tester -> chỉ có 1 kiểu add thôi -> nhúng link CSS
		if ( eb_code_tester == true ) {
			echo '<!-- CSS node 0 -->' . "\n";
			_eb_add_compiler_css_v2( $new_arr1 );
			
			echo '<!-- CSS node 1 -->' . "\n";
			_eb_add_compiler_css_v2( $new_arr2 );
		}
		// sử dụng thật thì có 2 kiểu add: inline và add link
		else {
			// nhúng nội dung file css
			_eb_add_compiler_css_v2( $new_arr1 );
			
			// nhúng link CSS
			_eb_add_compiler_css_v2( $new_arr2, 0 );
		}
//	}
}

function _eb_add_compiler_css_v2 ( $arr, $css_inline = 1 ) {
	
	// nhúng link trực tiếp
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
	
	
	// nhúng link đã qua cache
	if ( $css_inline != 1 ) {
		$file_cache = '';
		$full_file_name = '';
		$new_arr = array();
		foreach ( $arr as $v => $k ) {
			// chỉ add file có trong host
			if ( file_exists( $v ) ) {
				// lấy tên file
				$file_name = basename($v, '.css');
//				echo $file_name . '<br>' . "\n";
				
				//
				$full_file_name .= '+' . $file_name;
				
				// thời gian cập nhật file
				/*
				$file_time = filemtime ( $v );
//				$file_time = '-' . substr( filemtime ( $v ), 6 );
				$file_time = $file_name . substr( $file_time, strlen($file_time) - 3 );
				
//				$file_cache .= $file_name . $file_time;
				$file_cache .= $file_time;
				*/
				$file_cache .= $file_name;
				
				$new_arr[$v] = 1;
			}
		}
		
		//
//		echo $file_cache . '<br>' . "\n";
		$file_cache = md5( $file_cache );
		$file_show = $file_cache;
		
		// thêm khoảng thời gian lưu file
		$current_server_minute = (int) substr( date( 'i', date_time ), 0, 1 );
		$file_cache = 'zss-' . $file_cache . '-' . $current_server_minute . '.css';
		
		// file hiển thị sẽ hiển thị sớm hơn chút
		if ( $current_server_minute == 0 ) {
			$current_server_minute = 5;
		}
		else {
			$current_server_minute = $current_server_minute - 1;
		}
		$file_show = 'zss-' . $file_show . '-' . $current_server_minute . '.css';
		
		
		$file_save = EB_THEME_CACHE . $file_cache;
//		echo $file_save . "\n";
		
		// nếu chưa -> tạo file cache
//		if ( ! file_exists( $file_save ) ) {
		// tạo file cache định kỳ
		if ( ! file_exists( $file_save ) || date_time - filemtime ( $file_save ) + rand( 0, 300 ) > 1800 ) {
			$cache_content = '';
			foreach ( $new_arr as $v => $k ) {
				$file_content = explode( "\n", file_get_contents( $v, 1 ) );
				
				foreach ( $file_content as $v2 ) {
					$v2 = trim( $v2 );
					$cache_content .= $v2;
				}
			}
			
			//
			$cache_content = WGR_remove_css_multi_comment ( $cache_content );
			
			//
			_eb_create_file ( $file_save, create_cache_infor_by( $full_file_name ) . EBE_replace_link_in_cache_css ( $cache_content ) );
			
			// chưa có file phụ -> tạo luôn file phụ
			if ( ! file_exists( EB_THEME_CACHE . $file_show ) ) {
				if ( copy( $file_save, EB_THEME_CACHE . $file_show ) ) {
					chmod( EB_THEME_CACHE . $file_show, 0777 );
				}
			}
			
			// cập nhật lại version để css mới nhận nhanh hơn
//			_eb_set_config( 'cf_web_version', date( 'md.Hi', date_time ), 0 );
		}
		
		// -> done
		echo '<!-- ' . $file_cache . ' --><link rel="stylesheet" href="' . EB_DIR_CONTENT . '/uploads/ebcache/' . $file_show . '?v=' . web_version . '" type="text/css" media="all" />';
		
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
				
				//
//				$cache_content = '/* ' . $file_cache . ' - ' . date( 'r', date_time ) . ' */' . "\n";
				$cache_content = '';
				
				foreach ( $file_content as $v2 ) {
					$v2 = trim( $v2 );
					$cache_content .= $v2;
				}
				
				//
				$cache_content = WGR_remove_css_multi_comment ( $cache_content );
				
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
//			$file_link = $__cf_row['cf_dns_prefetch'] . EB_DIR_CONTENT . '/uploads/ebcache/' . $file_cache;
//			$file_link = web_link . EB_DIR_CONTENT . '/uploads/ebcache/' . $file_cache;
			$file_link = EB_DIR_CONTENT . '/uploads/ebcache/' . $file_cache;
			
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
	global $__cf_row;
	
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
		
		//
		$a = wp_nav_menu( $menu );
		
		// nếu có chuỗi /auto.get_all_category/ -> đây là menu tự động -> lấy toàn bộ category
		if ( strpos( $a, '/auto.get_all_category/' ) !== false ) {
			// lấy danh sách danh mục
			$all_cats = EBE_echbay_category_menu();
			
			// class cho menu
			$menu_slug_class = str_replace( ' ', '-', $slug );
			
			// các mẫu danh mục khác nhau
			if ( strpos( $a, '/auto.get_all_category/bars/' ) !== false ) {
				$a = '
				<div class="all-category-hover ' . $menu_slug_class . '-hover">
					<div class="all-category-bars cur ' . $menu_slug_class . '-bars"><i class="fa fa-bars"></i> Danh mục</div>
					<div class="all-category-cats ' . $menu_slug_class . '-cats">' . $all_cats . '</div>
				</div>';
			}
			else if ( strpos( $a, '/auto.get_all_category/caret/' ) !== false ) {
				$a = '
				<div class="all-category-hover ' . $menu_slug_class . '-hover">
					<div class="all-category-bars cur ' . $menu_slug_class . '-bars"><i class="fa fa-bars"></i> Danh mục <i class="fa fa-caret-down"></i></div>
					<div class="all-category-cats ' . $menu_slug_class . '-cats">' . $all_cats . '</div>
				</div>';
			}
			// thêm nút trang chủ
			else if ( strpos( $a, '/auto.get_all_category/home/' ) !== false ) {
				$a = str_replace( '<!-- ul:before -->', '<li><div><a href="./"><i class="fa fa-home"></i> ' . EBE_get_lang('home') . '</a></div></li>', $all_cats );
			}
			// thêm icon trang chủ
			else if ( strpos( $a, '/auto.get_all_category/home_icon/' ) !== false ) {
				$a = str_replace( '<!-- ul:before -->', '<li><div><a href="./"><i class="fa fa-home"></i></a></div></li>', $all_cats );
			}
			else {
				$a = $all_cats;
			}
		}
		else {
			// xóa các ID và class trong menu
			$a = preg_replace('/ id=\"menu-item-(.*)\"/iU', '', $a );
			$a = preg_replace('/ class=\"menu-item (.*)\"/iU', '', $a );
			
			// xóa ký tự đặc biệt khi rút link category
			$a = str_replace( '/./', '/', $a );
//			$a = str_replace( '/category/', '/', $a );
		}
		
		/*
		_eb_get_static_html ( $strCacheFilter, $a );
	}
	*/
	
	//
	$arr = array(
		'cf_diachi' => $__cf_row['cf_diachi'],
		'cf_email' => $__cf_row['cf_email'],
		'cf_dienthoai' => $__cf_row['cf_dienthoai'],
		'cf_hotline' => $__cf_row['cf_hotline']
	);
	foreach ( $arr as $k => $v ) {
		$a = str_replace( '{tmp.' . $k . '}' , $v, $a );
	}
	
	//
	/*
	if ( $__cf_row['cf_replace_content'] != '' ) {
		$a = WGR_replace_for_all_content( $__cf_row['cf_replace_content'], $a );
	}
	*/
	if ( $__cf_row['cf_old_domain'] != '' ) {
		$a = WGR_sync_old_url_in_content( $__cf_row['cf_old_domain'], $a );
	}
	
	// trả về menu và URL tương đối
	return '<!-- menu slug: ' . $slug . ' -->' . $menu_name . str_replace( web_link, '', _eb_supper_del_line( $a ) );
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
	if ( $i_echbay_footer_menu > 10 ) {
		$i_echbay_footer_menu = 10;
	}
	
	return _eb_echbay_menu(
		'footer-menu-0' . $i_echbay_footer_menu,
		$menu,
		$in_cache,
		$tag_menu_name,
		$tag_close_menu_name
	);
}

// Lấy toàn bộ danh sách category rồi hiển thị thành menu
function EBE_echbay_category_menu (
	// taxonomy mặc định
	$cat_type = 'category',
	// nhóm cha mặc định -> mặc định lấy nhóm cấp 1
	$cat_ids = 0,
	// class riêng (nếu có)
	$ul_class = 'eball-category-main',
	// có lấy nhóm con hay không -> mặc định là có
	$get_child = 1,
	//  thẻ theo yêu cầu (tùy vào seoer muốn thẻ gì thì truyền vào)
	$dynamic_tags = 'div'
) {
	
	//
	$arrs_cats = array(
		'taxonomy' => $cat_type,
//		'hide_empty' => 0,
		'parent' => $cat_ids,
	);
	// lấy toàn bộ danh mục để làm design ở chế độ debug
	if ( eb_code_tester == true ) {
		$arrs_cats['hide_empty'] = 0;
	}
	
	//
	$arrs_cats = get_categories( $arrs_cats );
//	print_r($arrs_cats);
	if ( count($arrs_cats) == 0 ) {
		// nếu đang là nhóm cấp 1 -> trả về thông báo
		if ( $cat_ids == 0 ) {
			return '<!-- no ' . $cat_type . ' detected -->';
		}
		// nếu từ nhóm cấp 2 trở đi -> trả về NULL
		else {
			return '';
		}
	}
	
	
	// Nếu đang là lấy nhóm cấp 1
	if ( $cat_ids == 0 ) {
		// Thử kiểm tra xem trong này có nhóm nào được set là nhóm chính không
		$post_primary_categories = array();
//		print_r( $post_categories );
		foreach ( $arrs_cats as $v ) {
			if ( _eb_get_cat_object( $v->term_id, '_eb_category_primary', 0 ) > 0 ) {
				$post_primary_categories[] = $v;
			}
		}
//		print_r( $post_primary_categories );
		
		
		// nếu có nhóm chính -> tiếp theo chỉ lấy các nhóm chính
		if ( count( $post_primary_categories ) > 0 ) {
			$arrs_cats = $post_primary_categories;
		}
//		print_r($arrs_cats);
	}

	
	// sắp xếp mảng theo chủ đích của người dùng
	$oders = WGR_order_and_hidden_taxonomy( $arrs_cats, 1 );
	/*
	$oders = array();
	$options = array();
	
	//
	foreach ( $arrs_cats as $v ) {
		$oders[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
		$options[$v->term_id] = $v;
	}
	arsort( $oders );	
	*/
	
	
	//
	$str = '';
//	foreach ( $arrs_cats as $v ) {
	foreach ( $oders as $k => $v ) {
		
		//
//		$v = $options[$k];
		
		// không lấy nhóm có ID là 1
		if ( $v->term_id != 1 ) {
			$str_child = '';
			if ( $get_child == 1 ) {
				$str_child = EBE_echbay_category_menu (
					$v->taxonomy,
					$v->term_id,
					'sub-menu',
					'div'
				);
			}
			
			// lấy ảnh đại diện nhỏ đối với các nhóm cấp 1
			$cat_favicon = '';
			if ( $cat_ids == 0 ) {
				$cat_favicon = _eb_get_cat_object( $v->term_id, '_eb_category_favicon' );
				if ( $cat_favicon != '' ) {
					$cat_favicon = '<span class="eball-category-icon" style="background-image:url(\'' . $cat_favicon . '\');"></span>';
				}
			}
			
			//
			$str .= '<li>' . $cat_favicon . '<' . $dynamic_tags . '><a href="' . _eb_cs_link( $v ) . '">' . $v->name . '<span class="eball-category-count"> (' . $v->count . ')</span></a></' . $dynamic_tags . '>' . $str_child . '</li>';
		}
		
	}
	
	// nếu là lấy nhóm cha -> thêm thuộc tính thêm chuỗi vào đầu và cuối menu
	if ( $cat_ids == 0 ) {
		return '<ul class="cf ' . $ul_class . '"><!-- ul:before -->' . $str . '<!-- ul:after --></ul>';
	}
	// với sub-menu thì trả về menu không thôi
	else {
		return '<ul class="cf ' . $ul_class . '">' . $str . '</ul>';
	}
}


/*
* tags: sidebar, widget
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
			$a = '<!-- ' . $slug . ' --><div class="sidebar-' . $slug . ' eb-sidebar-global-css ' . $css . '">' . $a . '</div>';
		}
		
		/*
		_eb_get_static_html ( $strCacheFilter, $a );
	}
	*/
	
	return $a;
}




function _eb_q ( $str, $type = 1 ) {
	global $wpdb;
	
//	echo $str . '<br>' . "\n";
	
	// Không trả về gì cả -> delete, update, insert
	if ( $type == 0 ) {
//		$wpdb->query( $wpdb->prepare( $str ) );
		$wpdb->query( trim( $str ) );
	}
	// có trả về dữ liệu -> select
	else {
		return $wpdb->get_results( trim( $str ), OBJECT );
	}
	
	//
	return false;
}

function _eb_c ($str) {
	$sql = _eb_q( $str );
	
	// v1 -> chạy 1 vòng lặp rồi trả về kết quả
//	if ( count( $sql ) > 0 ) {
	if ( ! empty( $sql ) ) {
//		echo 'aaaaaaaaa';
//		print_r( $sql );
		$sql = $sql[0];
//		print_r( $sql );
		foreach ( $sql as $v ) {
			$a = $v;
		}
		return $a;
	}
	
	// mặc định trả về 0
	return 0;
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
	( " . $str1 . " )", 0 );
	
	return true;
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
//	echo $id . "<br>\n";
//	echo $key . "<br>\n";
//	echo $val . "<br>\n";
	
	// kiểm tra trùng lặp
//	WGR_update_meta_post( $id, $key, $val, true );
	
	// bỏ qua kiểm tra
	WGR_update_meta_post( $id, $key, $val );
}




// cấu trúc để phân định option của EchBay với các mã khác (sợ trùng)
define( '_eb_option_prefix', '_eb_' );

//
function _eb_set_config($key, $val, $etro = 1) {
	
//	global $wpdb;
	
//	_eb_postmeta( eb_config_id_postmeta, $key, $val );
//	WGR_update_meta_post( eb_config_id_postmeta, $key, $val );
	
	// sử dụng option thay cho meta_post -> load nhanh hơn nhiều
	$key = _eb_option_prefix . $key;
	
	// xóa option cũ đi cho đỡ lằng nhằng
//	if ( delete_option( $key ) ) {
	if ( WGR_delete_option( $key ) == true && $etro == 1 ) {
		echo '<em>Remove</em>: ' . $key . '<br>' . "\n";
	}
	
	//
//	$val = WGR_stripslashes( $val );
	
	// thêm option mới
//	if ( get_option( $key ) == false ) {
//	if ( $val == 0 || $val != '' ) {
	if ( $val != '' ) {
		/*
		$sql = "INSERT INTO `" . $wpdb->options . "`
		( option_name, option_name, option_name )
		VALUES
		()";
		*/
//		add_option( $key, $val, '', 'no' );
//		add_option( $key, $val );
		WGR_set_option( $key, $val, 'no' );
		
		//
		if ( $etro == 1 ) {
			if ( strlen( $val ) < 50 ) {
				echo 'Add: ' . $key . ' (' . $val . ')<br>' . "\n";
			}
			else {
				echo 'Add: ' . $key . '<br>' . "\n";
			}
		}
	}
	else if ( $etro == 1 ) {
		echo 'Value: ' . $key . ' is NULL<br>' . "\n";
	}
	/*
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
				$__cf_row[ $k ] = WGR_stripslashes( $v );
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
	
	
	//
//	$__cf_row = $__cf_row_default;
		
	
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
			post_id = " . eb_config_id_postmeta, 0);
	}
//	exit();
	
	
	//
	$option_conf_name = _eb_option_prefix . 'cf_';
	
	$row = _eb_q("SELECT option_name, option_value
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name LIKE '{$option_conf_name}%'");
//	print_r( $row );
//	exit();
	
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
//				$a->option_value = $__cf_row_default[ $a->option_name ];
				$a->option_value = $__cf_row_default[ $a->option_name ];
			}
			/*
			else if ( $a->option_value == 'off' ) {
				$__cf_row[ $a->option_name ] = 0;
			}
			*/
			else {
				$a->option_value = WGR_stripslashes( $a->option_value );
//				$__cf_row[ $a->option_name ] = $a->option_value;
			}
			
			//
			$__cf_row[ $a->option_name ] = $a->option_value;
			
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


// lúc lấy lang thì không cần gán key đầy đủ, mà sẽ gán trong function này
function EBE_get_lang($k) {
	global $___eb_lang;
	
//	return isset( $___eb_lang[eb_key_for_site_lang . $k] ) ? $___eb_lang[eb_key_for_site_lang . $k] : '';
	return $___eb_lang[eb_key_for_site_lang . $k];
}

function EBE_set_lang($key, $val) {
	
	// sử dụng option thay cho meta_post -> load nhanh hơn nhiều
//	$key = eb_key_for_site_lang . $key;
	
	// xóa option cũ đi cho đỡ lằng nhằng
//	delete_option( $key );
	WGR_delete_option( $key );
	
	// chỉ cập nhật khi có value, nếu không có thì sử dụng của bản default
	if ( $val != '' ) {
//		$val = WGR_stripslashes( $val );
		
		// thêm option mới
//		add_option( $key, $val, '', 'no' );
		WGR_set_option( $key, $val, 'no' );
	}
	
}

function EBE_get_lang_list() {
	
	global $wpdb;
	global $___eb_lang;
//	print_r( $___eb_lang );
	
	
	//
	$option_conf_name = eb_key_for_site_lang;
	
	$row = _eb_q("SELECT option_name, option_value
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name LIKE '{$option_conf_name}%'");
//	print_r( $row );
//	exit();
	
	//
	foreach ( $row as $k => $a ) {
		// chỉ hiện thị các lang được hỗ trợ
//		if ( isset( $___eb_lang[ $a->option_name ] ) ) {
			$___eb_lang[ $a->option_name ] = WGR_stripslashes( $a->option_value );
//		}
		// xóa các lang không tồn tại
//		else {
//			delete_option( $a->option_name );
//		}
	}
//	print_r( $___eb_lang );
	
}





// Log mặc định
function _eb_log_default($m) {
	return _eb_set_log( array(
		'l_noidung' => $m
	) );
}

// Log LỖI, cho vào log đồng thời báo lỗi luôn
function _eb_log_error($m) {
	echo $m;
	
	return _eb_set_log( array(
		'l_noidung' => $m
	), 6 );
}

function _eb_log_click($m) {
//	return false;
	
	// v2
	return _eb_set_log( array(
		'l_noidung' => $m
	), 3 );
	
	// v1
	_eb_postmeta( eb_log_click_id_postmeta, '__eb_log_click', $m );
}
function _eb_get_log_click( $limit = '' ) {
	// v2
	return _eb_get_log(3);
	
	// v1
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
//	return false;
	
	// v2
	return _eb_set_log( array(
		'l_noidung' => $m
	), 4 );
	
	// v1
	$m .= ' (at ' . date( 'r', date_time ) . ')';
	
	_eb_postmeta( eb_log_user_id_postmeta, '__eb_log_user', $m );
}
function _eb_get_log_user( $limit = '' ) {
	// v2
	return _eb_get_log(4);
	
	// v1
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

function _eb_log_admin($m, $post_id = 0) {
//	return false;
	
	// v2
	return _eb_set_log( array(
		'post_id' => $post_id,
		'l_noidung' => $m
	), 1 );
	
	// v1
	$m .= ' (by ' . mtv_email . ' at ' . date( 'r', date_time ) . ')';
//		echo $m . "\n";
	
	_eb_postmeta( eb_log_user_id_postmeta, '__eb_log_admin', $m );
}
function _eb_get_log_admin( $limit = '' ) {
	// v2
	return _eb_get_log(1);
	
	// v1
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
//	return false;
	
	// v2
	return _eb_set_log( array(
		'hd_id' => $order_id,
		'l_noidung' => $m
	), 2 );
	
	// v1
	_eb_postmeta( eb_log_user_id_postmeta, '__eb_log_invoice' . $order_id, $m );
}
function _eb_get_log_admin_order( $order_id, $limit = 50 ) {
	// v2
	return _eb_get_log(2, $limit, $order_id);
	
	// v1
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
//	return false;
	
	// v2
	return _eb_set_log( array(
		'l_noidung' => $m
	), 5 );
	
	// v1
	_eb_postmeta( eb_log_search_id_postmeta, '__eb_log_search', $m );
}
function _eb_get_log_search( $limit = '' ) {
	// v2
	return _eb_get_log(5);
	
	// v1
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

function _eb_set_log ( $arr, $log_type = 0 ) {
	global $client_ip;
	
	$arr['l_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	$arr['l_ip'] = $client_ip;
	$arr['l_ngay'] = date_time;
	$arr['l_type'] = $log_type;
//	$arr['hd_id'] = $hd_id;
//	$arr['post_id'] = $post_id;
	$arr['tv_id'] = mtv_id;
	
	return _eb_sd( $arr, 'eb_wgr_log' );
}

function _eb_get_log ( $log_type = 0, $limit = 100, $hd_id = 0 ) {
	$filter = "";
	if ( $hd_id > 0 ) {
		$filter = " AND hd_id = " . $hd_id;
	}
	
	//
	return _eb_q("SELECT *
	FROM
		`eb_wgr_log`
	WHERE
		l_type = " . $log_type . $filter . "
	ORDER BY
		l_id DESC
	LIMIT 0, " . $limit);
}

/*
* Tính số lượng log theo khoảng thời gian
* limit_clear_log: số lượng bản ghi tối đa cho mỗi log
*/
function _eb_count_log ( $log_type = 0, $limit_time = 3600, $limit_day = 0, $limit_clear_log = 35000 ) {
	/*
	* limit_day < 182 -> lấy theo giây
	*/
	/*
	if ( $limit_time < 182 ) {
		$limit_time = $limit_time * 24 * 3600;
	}
	*/
	$limit_time += $limit_day * 24 * 3600;
	// mặc định thì tính theo số giây
//	echo $log_type . '<br>' . "\n";
	
	//
	$sql = _eb_q("SELECT count(l_id) as c
	FROM
		`eb_wgr_log`
	WHERE
		l_type = " . $log_type . "
		AND l_ngay > " . ( date_time - $limit_time ) . "
	ORDER BY
		l_id DESC");
//	print_r( $sql );
	
	if ( ! empty ( $sql ) ) {
		$a = $sql[0]->c;
		
		// nếu không phải log của đơn hàng -> xóa bớt log cho nhẹ db
		if ( $log_type != 2 && $a > $limit_clear_log * 1.5 ) {
			$sql = _eb_q("SELECT l_id
			FROM
				`eb_wgr_log`
			WHERE
				l_type = " . $log_type . "
			ORDER BY
				l_id DESC
			LIMIT " . $limit_clear_log . ", 1");
			
			//
			if ( ! empty ( $sql ) ) {
				// lưu cái tổng kia lại đã
				$strsql = _eb_q("SELECT count(l_id) as c
				FROM
					`eb_wgr_log`
				WHERE
					l_type = " . $log_type . "
					AND l_id < " . $sql[0]->l_id);
//				print_r( $strsql );
				_eb_set_option( 'WGR_history_for_log' . $log_type, $strsql[0]->c, 'no' );
				
				// xóa
				_eb_q("DELETE
				FROM
					`eb_wgr_log`
				WHERE
					l_type = " . $log_type . "
					AND l_id < " . $sql[0]->l_id . "
					AND hd_id = 0", 0);
			}
		}
		
		//
		return $a;
	}
	return 0;
}

function _eb_clear_log ( $log_type = 0, $limit_day = 61 ) {
	
	// tính toán lại log, đồng thời dọn dẹp bớt đi cho nó gọn
	_eb_count_log( $log_type, 0, $limit_day );
	
	//
	/*
	$limit_day = date_time - $limit_day * 24 * 3600;
	
	//
	_eb_q("DELETE
	FROM
		`eb_wgr_log`
	WHERE
		l_type = " . $log_type . "
		AND l_ngay < " . $limit_day, 0);
		*/
	
	return true;
}

// làm 1 vòng lặp, xóa toàn bộ cac loại log theo type
function _eb_clear_all_log () {
	for ( $i = 0; $i < 10; $i++ ) {
		_eb_clear_log( $i );
	}
}




function _eb_number_only( $str = '', $re = '/[^0-9]+/' ) {
	$str = trim( $str );
	if ($str == '') {
		return 0;
	}
	return preg_replace ( $re, '', trim( $str ) );
}

function _eb_float_only( $str = '', $lam_tron = 0 ) {
	$a = _eb_number_only( $str, '/[^0-9|\.]+/' );
	
	// làm tròn hết sang số nguyên
	if ( $lam_tron == 1 ) {
		$a = ceil( $a );
	}
	// làm tròn phần số nguyên, số thập phân giữ nguyên
	else if ( $lam_tron == 2 ) {
		$a = explode( '.', $a );
		if ( isset( $a[1] ) ) {
			$a = (int) $a[0] . '.' . $a[1];
		} else {
			$a = (int) $a[0];
		}
	}
	
	return $a;
}

function _eb_text_only($str = '') {
	if ($str == '') {
		return '';
	}
	return preg_replace ( '/[^a-zA-Z0-9\-\.]+/', '', $str );
}

function _eb_un_money_format($str) {
	return _eb_number_only( $str );
}




function _eb_non_mark_seo($str) {
	
	//
	$str = _eb_non_mark ( trim( $str ) );
	
	//
	$unicode = array(
		/*
		'a' => array('á','à','ả','ã','ạ','ă','ắ','ặ','ằ','ẳ','ẵ','â','ấ','ầ','ẩ','ẫ','ậ','Á','À','Ả','Ã','Ạ','Ă','Ắ','Ặ','Ằ','Ẳ','Ẵ','Â','Ấ','Ầ','Ẩ','Ẫ','Ậ'),
		'd' => array('đ','Đ'),
		'e' => array('é','è','ẻ','ẽ','ẹ','ê','ế','ề','ể','ễ','ệ','É','È','Ẻ','Ẽ','Ẹ','Ê','Ế','Ề','Ể','Ễ','Ệ'),
		'i' => array('í','ì','ỉ','ĩ','ị', 'Í','Ì','Ỉ','Ĩ','Ị'),
		'o' => array('ó','ò','ỏ','õ','ọ','ô','ố','ồ','ổ','ỗ','ộ','ơ','ớ','ờ','ở','ỡ','ợ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ố','Ồ','Ổ','Ỗ','Ộ','Ơ','Ớ','Ờ','Ở','Ỡ','Ợ'),
		'u' => array('ú','ù','ủ','ũ','ụ','ư','ứ','ừ','ử','ữ','ự','Ú','Ù','Ủ','Ũ','Ụ','Ư','Ứ','Ừ','Ử','Ữ','Ự'),
		'y' => array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		*/
		'-' => array(' ','~','`','!','@','#','$','%','^','&','*','(',')','=','[',']','{','}','\\','|',';',':','\'','"',',','<','>','/','?')
	);
	foreach ($unicode as $nonUnicode=>$uni) {
		foreach ($uni as $v) {
			$str = str_replace($v,$nonUnicode,$str);
		}
	}
	
	
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
		foreach ($uni as $v) {
			$str = str_replace($v,$nonUnicode,$str);
		}
	 }
	 return $str;
	 
}




function _eb_build_mail_header($from_email, $bcc_email = '') {
	$headers = array();
	
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
//	$headers[] = 'Date: ' . gmdate('d M Y H:i:s Z', NOW);
	$headers[] = 'From: ' . web_name .' <'. $from_email . '>';
	$headers[] = 'Reply-To: <'. $from_email . '>';
	
	//
	$bcc_email = str_replace( ';', ',', str_replace( ' ', '', trim($bcc_email) ) );
	if ( $bcc_email != '' ) {
		$bcc_email = explode( ',', $bcc_email );
		foreach ( $bcc_email as $v ) {
			$v = trim( $v );
			
			if ( $v != '' && _eb_check_email_type( $v ) == 1 ) {
				$headers[] = 'BCC: '. $v;
			}
		}
	}
	
	//
	$headers[] = 'Auto-Submitted: auto-generated';
	$headers[] = 'Return-Path: <'. $from_email . '>';
	$headers[] = 'X-Sender: <'. $from_email . '>'; 
	$headers[] = 'X-Priority: 3';
	$headers[] = 'X-MSMail-Priority: Normal';
	$headers[] = 'X-MimeOLE: Produced By xtreMedia';
	$headers[] = 'X-Mailer: PHP/ '. phpversion();
	
	// trả về header
	return trim( implode ( "\r\n", $headers ) );
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
	if ($headers == '') {
		/*
		if ( $__cf_row['cf_email_note'] != '' ) {
			$headers = _eb_build_mail_header ( $__cf_row['cf_email_note'] );
		} else if ( $__cf_row['cf_email'] != '' ) {
			$headers = _eb_build_mail_header ( $__cf_row['cf_email'] );
		} else {
			*/
			$headers = _eb_build_mail_header ( 'noreply@' . $chost, $bcc_email );
			/*
		}
		*/
	}
	/*
	else {
		$bcc_email = str_replace( ';', ',', str_replace( ' ', '', trim($bcc_email) ) );
		if ($bcc_email != '') {
			$bcc_email = explode( ',', $bcc_email );
			foreach ( $bcc_email as $v ) {
				$v = trim( $v );
				
				if ( $v != '' && _eb_check_email_type( $v ) == 1 ) {
					$headers .= "\r\n" . 'BCC: ' . $v;
				}
			}
		}
	}
	*/
	
	
	//
	$custom_lang_html = EBE_get_lang('mail_main');
	// mặc định là lấy theo file HTML -> act
	if ( trim( $custom_lang_html ) == 'mail_main' ) {
		$custom_lang_html = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/mail.html' );
	}
	
	//
//	$message = _eb_del_line( EBE_str_template ( 'html/mail/mail.html', array (
	$message = _eb_del_line( EBE_html_template( $custom_lang_html, array(
			'tmp.message' => $message,
			
			'tmp.web_name' => web_name,
			'tmp.web_link' => web_link,
			'tmp.web_host' => $_SERVER['HTTP_HOST'],
			
			'tmp.block_email' => _eb_lnk_block_email( $to_email ),
			
			'tmp.year_curent' => $year_curent,
			'tmp.cf_ten_cty' => $__cf_row['cf_ten_cty'],
			'tmp.to_email' => $to_email,
			'tmp.captcha' => _eb_mdnam ( $to_email )
//	), EB_THEME_PLUGIN_INDEX ) );
	) ) );
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
	$ham_gui_mail = 'WP mail';
	
	// sử dụng hame mail mặc định
	if ( $__cf_row ['cf_sys_email'] == '' ) {
		$mail = mail( $to_email, $title, $message, $headers );
		$ham_gui_mail = 'PHP mail';
	}
	// sử dụng wordpress mail
//	else if ( $__cf_row ['cf_sys_email'] == 'wpmail' ) {
	else {
		$mail = wp_mail( $to_email, $title, $message, $headers );
		
		//
		if ( $__cf_row ['cf_sys_email'] != 'wpmail' ) {
			$ham_gui_mail = 'SMTP';
		}
	}
	
	//
	if( ! $mail ) {
//	if( ! wp_mail( $to_email, $title, $message, $headers ) ) {
		EBE_show_log( 'ERROR send mail: ' . $to_email );
		return false;
	}
	
	// Thông báo kết quả
	EBE_show_log( 'Send email to: ' . $to_email . ' (Using: ' . $ham_gui_mail . ')' );
	
	//
	return true;
}

function EBE_show_log ($m) {
	echo '<script>console.log("' . $m . '");</script>';
}

// https://codex.wordpress.org/Plugin_API/Action_Reference/phpmailer_init
function EBE_configure_smtp( PHPMailer $phpmailer ){
	
	global $__cf_row;
	
	if ( $__cf_row['cf_smtp_host'] == ''
	|| $__cf_row['cf_smtp_email'] == ''
	|| $__cf_row['cf_smtp_pass'] == '' ) {
		return false;
	}
	
	if ( $__cf_row['cf_smtp_port'] == '' || $__cf_row['cf_smtp_port'] == '0' ) {
		$__cf_row['cf_smtp_port'] == 25;
	}
	
	// switch to smtp
	$phpmailer->isSMTP();
	$phpmailer->CharSet = 'utf-8';
	
	// https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging
	if ( $__cf_row['cf_tester_mode'] == 1 ) {
		$phpmailer->SMTPDebug = 2;
	}
	else {
		$phpmailer->SMTPDebug = 0;
	}
	
	// Force it to use Username and Password to authenticate
	$phpmailer->SMTPAuth = true;
	
	// Set the Pepipost settings
	// default setting
	$phpmailer->Host = $__cf_row['cf_smtp_host'];
	$phpmailer->Port = $__cf_row['cf_smtp_port'];
	$phpmailer->Username = $__cf_row['cf_smtp_email'];
	$phpmailer->Password = $__cf_row['cf_smtp_pass'];
	
	// Additional settings...
	// Choose SSL or TLS, if necessary for your server
	if ( $__cf_row['cf_smtp_encryption'] == '' ) {
		$phpmailer->SMTPSecure = false;
	}
	else {
		$phpmailer->SMTPSecure = $__cf_row['cf_smtp_encryption'];
	}
//	$phpmailer->SMTPSecure = 'tls';
//	$phpmailer->SMTPSecure = 'ssl';
	
	if ( _eb_check_email_type( $__cf_row['cf_smtp_email'] ) != 1 ) {
		$phpmailer->From = $__cf_row['cf_email'];
	}
	else {
		$phpmailer->From = $__cf_row['cf_smtp_email'];
	}
	if ( $__cf_row['cf_web_name'] == '' ) {
		$phpmailer->FromName = '(' . strtoupper( $_SERVER['HTTP_HOST'] ) . ')';
	}
	else {
		$phpmailer->FromName = _eb_non_mark( $__cf_row['cf_web_name'] );
	}
	
	//
	$phpmailer->SMTPOptions = array (
		'ssl' => array (
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true 
		) 
	);
	$phpmailer->WordWrap = 50;
	$phpmailer->IsHTML ( true );
	
	//
	return true;
	
}

function _eb_send_mail_phpmailer( $to, $to_name = '', $subject, $message, $from_reply = '', $bcc_email = '' ) {
//	global $dir_index;
	global $__cf_row;
	global $__cf_row_default;
	
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
		
		// gửi qua smtp riêng (nếu có)
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
		$__cf_row ['cf_sys_email'] = $__cf_row_default['cf_sys_email'];
		
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

function _eb_load_ads (
	// Trạng thái của banner quảng cáo
	$type = 0,
	// số lượng bản ghi cần lấy
	$posts_per_page = 20,
	// kích thước muốn hiển thị, nếu là auto -> tự lấy theo size ảnh
	$data_size = 1,
	// query phủ định
	$_eb_query = array(),
	// offset như mysql thông thương
	$offset = 0,
	// định dạng HTML cần xuất ra
	// default: EBE_get_page_template( 'ads_node' )
	// get title: EBE_get_page_template( 'ads_node_title' )
	// get title and excerpt EBE_get_page_template( 'ads_node_excerpt' )
	$html = '',
	$other_options = array()
) {
	global $__cf_row;
	global $arr_eb_ads_status;
	global $eb_background_for_post;
	global $cid;
	global $wpdb;
//	global $___eb_ads__not_in;
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
		$arr_in = array();
		
		// nếu đang có nhóm -> lấy luôn ID của nhóm này
		if ( $cid > 0 ) {
			$arr_in[] = $cid;
		}
		// hoặc lấy ID các category đang xuất hiện ở đây
		else {
			// chỉ lấy category hiện tại
			$categories = get_queried_object();
//			print_r($categories);
			if ( isset( $categories->term_id ) ) {
				$arr_in[] = $categories->term_id;
			}
			else {
			// lấy các category theo sản phẩm
				$categories = get_the_category();
//				print_r($categories);
				foreach ( $categories as $k => $v ) {
					$arr_in[] = $v->term_id;
	//				$strCacheFilter .= $v->term_id;
				}
			}
		}
//		print_r($arr_in);
		$_eb_query['category__in'] = $arr_in;
	}
	// nếu có thuộc tính not_in_cat, mà giá trị trống -> chỉ lấy các q.cáo không có nhóm
	else if ( isset($_eb_query['category__not_in']) && $_eb_query['category__not_in'] == '' ) {
		$arr_in = array();
		
		// nếu đang có nhóm -> lấy luôn ID của nhóm này
		if ( $cid > 0 ) {
			$arr_in[] = $cid;
		}
		// mặc định là lấy toàn bộ category
		else {
//			$categories = get_the_category();
//			print_r($categories);
			
			$categories = get_categories();
			/*
			$categories = get_categories( array(
				'hide_empty' => 0,
			) );
			*/
			/*
			echo '<!-- ';
			print_r($categories);
			echo ' -->';
			*/
			
			foreach ( $categories as $k => $v ) {
				$arr_in[] = $v->term_id;
//				$strCacheFilter .= $v->term_id;
			}
			
			
			/*
			* với custom taxonomy thì add vào phần not in kiểu khác
			*/
			
			// tạo tax_query nếu chưa có
			if ( ! isset( $_eb_query['tax_query'] ) ) {
				$_eb_query['tax_query'] = array();
			}
			
			//
			$categories = get_categories( array(
				'taxonomy' => 'post_options'
			) );
			/*
			echo '<!-- ';
			print_r($categories);
			echo ' -->';
			*/
			
			$arr_not_in = array();
			foreach ( $categories as $k => $v ) {
				$arr_not_in[] = $v->term_id;
			}
			// tạo list các banner not in phần post_options
			$_eb_query['tax_query'][] = array (
				'taxonomy' => 'post_options',
				'field' => 'term_id',
				'terms' => $arr_not_in,
				'operator' => 'NOT IN'
			);
			
			
			//
			$categories = get_categories( array(
				'taxonomy' => EB_BLOG_POST_LINK
			) );
			/*
			echo '<!-- ';
			print_r($categories);
			echo ' -->';
			*/
			
			$arr_not_in = array();
			foreach ( $categories as $k => $v ) {
				$arr_not_in[] = $v->term_id;
			}
			// tạo list các banner not in phần blog
			$_eb_query['tax_query'][] = array (
				'taxonomy' => EB_BLOG_POST_LINK,
				'field' => 'term_id',
				'terms' => $arr_not_in,
				'operator' => 'NOT IN'
			);
			
			//
//			$_eb_query['tag__not_in'] = $arr_not_in;
			
			/*
			echo '<!-- ';
			print_r($_eb_query);
			echo ' -->';
			*/
			
		}
//		print_r($arr_in);
		
		//
		$_eb_query['category__not_in'] = $arr_in;
	}
	
	
	/*
	if ( $strCacheFilter != '' ) {
		$strCacheFilter = md5($strCacheFilter);
	}
	
	
//	$strCacheFilter = 'ads' . $type . implode ( '-', $_eb_query );
	$strCacheFilter = 'ads' . $type . $strCacheFilter;
//	echo $strCacheFilter . '<br>' . "\n";
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
		$arr['compare'] = '=';
		$arr['type'] = 'NUMERIC';
		
		$arr['offset'] = $offset;
//		$arr['offset'] = 0;
		$arr['posts_per_page'] = $posts_per_page;
		
		$arr['orderby'] = 'menu_order ID';
		$arr['order'] = 'DESC';
		
		$arr['post_status'] = 'publish';
		
		//
		foreach ( $_eb_query as $k => $v ) {
			$arr[$k] = $v;
		}
		/*
		echo '<!-- ';
//		print_r( $_eb_query );
		print_r( $arr );
		echo ' -->';
		*/
		
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
		
		// lấy size theo dữ liệu truyền vào
//		if ( $__cf_row['cf_auto_get_ads_size'] != 1 ) {
			$data_size = ( $data_size == '' ) ? 1 : $data_size;
//		}
		// lấy size tự động theo ảnh đầu tiên
		$auto_get_size = '';
		if ( $__cf_row['cf_auto_get_ads_size'] == 1 || $data_size == 'auto' ) {
			$auto_get_size = 'auto_get_size';
		}
		
		//
		while ( $sql->have_posts() ) {
			
			$sql->the_post();
//			print_r( $sql );
			
			$post = $sql->post;
//			print_r( $post );
			
			//
			$p_link = '';
			
			
			//
			$anh_dai_dien_goc = _eb_get_post_img( $post->ID, $__cf_row['cf_ads_thumbnail_size'] );
			$ads_id = $post->ID;
			
			// kiểm tra xem q.cáo có alias tới post, page... nào không
			$alias_post = _eb_number_only( _eb_get_post_object( $post->ID, '_eb_ads_for_post', 0 ) );
			$alias_taxonomy = _eb_number_only( _eb_get_post_object( $post->ID, '_eb_ads_for_category', 0 ) );
			
			// nếu có -> nạp thông tin post, page... mà nó alias tới
			if ( $alias_post > 0 ) {
				$strsql = _eb_q("SELECT *
				FROM
					`" . wp_posts . "`
				WHERE
					ID = " . $alias_post . "
					AND post_status = 'publish'");
//				print_r( $strsql );
				if ( ! empty( $strsql ) ) {
					$post = $strsql[0];
					$p_link = _eb_p_link( $post->ID );
				}
			}
			else if ( $alias_taxonomy > 0 ) {
				$new_name = WGR_get_all_term( $alias_taxonomy );
				
				//
				if ( ! isset($new_name->errors) ) {
					$post->post_title = $new_name->name;
//					$p_link = _eb_c_link( $alias_taxonomy, $new_name->taxonomy );
					$p_link = _eb_cs_link( $new_name );
				}
			}
			
			//
			if ( $p_link == '' ) {
				$p_link = _eb_get_post_meta( $post->ID, '_eb_ads_url', true, 'javascript:;' );
			}
			
			
			//
//			$___eb_ads__not_in .= ',' . $post->ID;
			
			//
//			$p_link = _eb_get_ads_object( $post->ID, '_eb_ads_url', 'javascript:;' );
//			echo $p_link . '<br>';
			
			// nếu q.cáo này không có ảnh
			$trv_img = '';
			if ( $anh_dai_dien_goc == '' ) {
				// -> gán lại ID nếu nó có alias
				if ( $alias_post > 0 ) {
					$ads_id = $post->ID;
					
					// lấy ảnh theo post alias
					$trv_img = _eb_get_post_img( $post->ID, $__cf_row['cf_ads_thumbnail_size'] );
				}
				// không thì bỏ qua phần lấy ảnh
				else {
					$ads_id = 0;
				}
			}
			else {
				$trv_img = $anh_dai_dien_goc;
			}
			
			// lấy ảnh từ bài viết
			$trv_table_img = '';
			$trv_mobile_img = '';
			if ( $ads_id > 0 ) {
				if ( $__cf_row['cf_product_thumbnail_table_size'] == $__cf_row['cf_product_thumbnail_size'] ) {
					$trv_table_img = $trv_img;
				} else {
					$trv_table_img = _eb_get_post_img( $ads_id, $__cf_row['cf_product_thumbnail_table_size'] );
				}
				
				if ( $__cf_row['cf_product_thumbnail_mobile_size'] == $__cf_row['cf_product_thumbnail_table_size'] ) {
					$trv_mobile_img = $trv_table_img;
				} else {
					$trv_mobile_img = _eb_get_post_img( $ads_id, $__cf_row['cf_product_thumbnail_mobile_size'] );
				}
			}
			
			//
			$youtube_avt = '';
			$youtube_url = _eb_get_post_meta( $post->ID, '_eb_ads_video_url' );
			$youtube_id = '';
			if ( strstr( $youtube_url, '.mp4' ) == false ) {
				$youtube_id = _eb_get_youtube_id( $youtube_url );
//				$youtube_id = _eb_get_youtube_id( _eb_get_ads_object( $post->ID, '_eb_ads_video_url' ) );
				if ( $youtube_id != '' ) {
//					$youtube_url = '//www.youtube.com/watch?v=' . $youtube_id;
					$youtube_url = '//www.youtube.com/embed/' . $youtube_id;
					$youtube_avt = '//i.ytimg.com/vi/' . $youtube_id . '/0.jpg';
				}
				else {
					$youtube_url = 'about:blank';
				}
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
			
			// tạo size tự động theo ảnh (nếu chưa có)
//			if ( $__cf_row['cf_auto_get_ads_size'] == 1 && $auto_get_size == '' ) {
			if ( $auto_get_size == 'auto_get_size' ) {
				// ảnh phải nằm trong thư mục wp-content
				if ( strstr( $trv_img, EB_DIR_CONTENT . '/' ) == true ) {
					$auto_get_size = strstr( $trv_img, EB_DIR_CONTENT . '/' );
				}
				// hoặc cùng với domain cũng được
				else if ( strstr( $trv_img, web_link ) == true ) {
					$auto_get_size = str_replace( web_link, '', $trv_img );
				}
//				echo $auto_get_size . '<br>' . "\n";
				
				if ( $auto_get_size != '' ) {
					// ghép nối lại để bắt đầu xác định size
					$auto_get_size = ABSPATH . $auto_get_size;
//					echo $auto_get_size . '<br>' . "\n";
					
					if ( file_exists( $auto_get_size ) ) {
						$auto_get_size = getimagesize( $auto_get_size );
//						print_r( $auto_get_size );
						
						// -> tạo size mới
						$data_size = $auto_get_size[1] . '/' . $auto_get_size[0];
					}
				}
				
				// gán lại size auto để sau nó không lặp lại nữa
				$auto_get_size = $data_size;
			}
			$post->data_size = $data_size;
			
			//
			$post->trv_img = $trv_img;
			$post->trv_mobile_img = $trv_mobile_img;
			$post->trv_table_img = $trv_table_img;
			
			//
			$post->target_blank = ( _eb_get_post_meta( $post->ID, '_eb_ads_target' ) == 1 ) ? ' target="_blank"' : '';
			
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
			$post->trv_title = str_replace( '"', '&quot;', trim( strip_tags( $post->post_title ) ) );
			
			// mặc định là sử dụng post_excerpt, nếu không có -> sẽ sử dụng post_content
//			$post->trv_gioithieu = ( $post->post_excerpt == '' ) ? '<div class="each-to-fix-ptags">' . trim( $post->post_content ) . '</div>' : nl2br( $post->post_excerpt );
			$post->trv_gioithieu = ( $post->post_excerpt == '' ) ? nl2br( trim( $post->post_content ) ) : nl2br( $post->post_excerpt );
			
			// với phần nội dung thì không có nl2br
			$post->post_content = $post->post_content;
			$post->trv_noidung = $post->post_content;
			
			//
			$str .=  EBE_arr_tmp( $post, $html );
		
		}
		
		//
		wp_reset_postdata();
		
		// nếu có dữ liệu -> trả về dữ liệu theo cấu trúc định sẵn
		if ( $str != '' ) {
			$str = '<ul class="cf global-ul-load-ads' . ( isset( $other_options['add_class'] ) ? ' ' . $other_options['add_class'] : '' ) . '">' . $str . '</ul>';
		}
		// nếu không -> trả về giá trị mặc định (nếu có)
		else if ( isset ( $other_options['default_value'] ) ) {
			return $other_options['default_value'];
		}
		// hoặc trả về câu thông báo cho người dùng add banner cần thiết để chạy
		else {
			$str = '<div class="show-if-site-demo global-ul-load-ads' . $type . '">Please add banner for "' . $arr_eb_ads_status[ $type ] . ' (' . $type . ')"</div>';
		}
		
		//
		/*
		_eb_get_static_html ( $strCacheFilter, $str );
		
	}
	*/
	
	//
	/*
	if ( $__cf_row['cf_replace_content'] != '' ) {
		$str = WGR_replace_for_all_content( $__cf_row['cf_replace_content'], $str );
	}
	*/
	if ( $__cf_row['cf_old_domain'] != '' ) {
		$str = WGR_sync_old_url_in_content( $__cf_row['cf_old_domain'], $str );
	}
	
	//
	return '<!-- ADS status: ' . $type . ' - ' . $arr_eb_ads_status[ $type ] . ' -->' . _eb_supper_del_line( $str );
}


// xác định lại post type của 1 post bất kỳ
function WGR_get_post_type_name ( $id ) {
	global $wpdb;
	
	//
	$sql = _eb_q("SELECT post_type
	FROM
		`" . wp_posts . "`
	WHERE
		ID = " . $id . "
	LIMIT 0, 1");
//	print_r( $sql );
	if ( ! empty( $sql ) ) {
		return $sql[0]->post_type;
	}
	
	return '';
}


// Dùng để lấy thông tin các term chưa được xác định
function WGR_get_taxonomy_name ( $id ) {
	global $wpdb;
	
	//
	$sql = _eb_q("SELECT taxonomy
	FROM
		`" . $wpdb->term_taxonomy . "`
	WHERE
		term_id = " . $id . "
		OR term_taxonomy_id = " . $id . "
	LIMIT 0, 1");
//	print_r( $sql );
	if ( ! empty( $sql ) ) {
		return $sql[0]->taxonomy;
	}
	
	return '';
}

function WGR_get_all_term ( $id ) {
	$taxonomy = WGR_get_taxonomy_name($id);
//	echo $id . '<br>';
//	echo $taxonomy . '<br>';
	if ( $taxonomy == '' ) {
		return (object) array( 'errors' => 'Taxonomy not found!' );
	}
	
	$t = get_term( $id, $taxonomy );
//	print_r( $t );
//	echo 'bbbbbbbbbbb<br>';
//	echo gettype($t);
	
	//
	if ( gettype($t) == 'object' && ! isset($t->errors) ) {
		return $t;
	}
	
	//
	$t = get_term( $id, 'category' );
//	print_r( $t );
	
	if ( isset($t->errors) ) {
		$t = get_term( $id, EB_BLOG_POST_LINK );
//		print_r( $t );
		
		if ( isset($t->errors) ) {
			$t = get_term( $id, 'post_tag' );
//			print_r( $t );
			
			if ( isset($t->errors) ) {
				$t = get_term( $id, 'post_options' );
//				print_r( $t );
			}
		}
	}
	
	//
	return $t;
}



// tách các phiên bản ra cho nhẹ người code
include EB_THEME_PLUGIN_INDEX . 'functionsP2.php';
include EB_THEME_PLUGIN_INDEX . 'functionsP3.php';
include EB_THEME_PLUGIN_INDEX . 'functionsTemplate.php';
include EB_THEME_PLUGIN_INDEX . 'functionsWidget.php';
