<?php





// chức năng cho hoặc không cho truy cập vào 1 file nào đó
function WGR_deny_or_accept_vist_php_file ( $progress_file, $deny_or_accept, $warning_content ) {
	if ( file_exists( $progress_file ) ) {
		$progress_content = file_get_contents( $progress_file, 1 );
		$progress_content = explode( "\n", trim( $progress_content ) );
		
		// Kiểm tra dòng đầu tiên xem đã được add câu lệnh die vào chưa
		$progress_content[0] = trim( $progress_content[0] );
		
		// nếu chế độ xem qua xmlrpc đang tắt
		if ( $deny_or_accept != 1 ) {
			// kiểm tra có lệnh die chưa -> như này là chưa add -> add thêm thôi
			if ( $progress_content[0] == '<?php' || $progress_content[0] == '<?' ) {
				$progress_content[0] = '<?php die("' . $warning_content . ' method has been disable by EchBay.com");';
				
				_eb_create_file( $progress_file, implode( "\n", $progress_content ) );
			}
		}
		// cho phép xem qua xmlrpc
		else {
			// cho xem
			if ( $progress_content[0] == '<?php' || $progress_content[0] == '<?' ) {
			}
			// không cho xem
			else {
				$progress_content[0] = '<?php';
				
				_eb_create_file( $progress_file, implode( "\n", $progress_content ) );
			}
		}
	}
}




function WGR_remove_html_comments ( $a ) {
	
	$str = '';
	
	$a = explode( '-->', $a );
	foreach ( $a as $v ) {
		$v = explode('<!--', $v);
		$str .= $v[0];
	}
	
	return trim( $str );
	
}



function WGR_copy_secure_file($FromLocation, $ToLocation, $VerifyPeer = false, $VerifyHost = true) {
	// Initialize CURL with providing full https URL of the file location
	$Channel = curl_init ( $FromLocation );
	
	// Open file handle at the location you want to copy the file: destination path at local drive
	$File = fopen ( $ToLocation, "w" );
	
	// Set CURL options
	curl_setopt ( $Channel, CURLOPT_FILE, $File );
	
	// We are not sending any headers
	curl_setopt ( $Channel, CURLOPT_HEADER, 0 );
	
	// Disable PEER SSL Verification: If you are not running with SSL or if you don't have valid SSL
	curl_setopt ( $Channel, CURLOPT_SSL_VERIFYPEER, $VerifyPeer );
	
	// Disable HOST (the site you are sending request to) SSL Verification,
	// if Host can have certificate which is nvalid / expired / not signed by authorized CA.
	curl_setopt ( $Channel, CURLOPT_SSL_VERIFYHOST, $VerifyHost );
	
	// Execute CURL command
	curl_exec ( $Channel );
	
	// Close the CURL channel
	curl_close ( $Channel );
	
	// Close file handle
	fclose ( $File );
	
	// return true if file download is successfull
	return file_exists ( $ToLocation );
}




/*
* Tải file theo thời gian thực
*/
function EBE_admin_get_realtime_for_file ( $v ) {
	return filemtime( str_replace( EB_URL_OF_PLUGIN, EB_THEME_PLUGIN_INDEX, $v ) );
}

function EBE_admin_set_realtime_for_file ( $arr ) {
	foreach ( $arr as $k => $v ) {
		$arr[$k] = $v . '?v=' . EBE_admin_get_realtime_for_file( $v );
	}
	return $arr;
}



// kiểm tra và trả về đường dẫn của file theme tương ứng
function WGR_check_and_load_tmp_theme ( $load_config_temp, $dir_all_theme ) {
	global $arr_for_show_html_file_load;
	global $arr_for_add_css;
//	global $arr_for_add_theme_css;
	
	//
	$tmp_child_theme = '';
	if ( using_child_wgr_theme == 1 ) {
		$tmp_child_theme = EB_CHILD_THEME_URL . 'ui/' . $load_config_temp;
//		echo $tmp_child_theme . '<br>' . "\n";
	}
	
	$tmp_theme = EB_THEME_URL . 'ui/' . $load_config_temp;
//	echo $tmp_theme . '<br>' . "\n";
	
	$tmp_plugin = EB_THEME_PLUGIN_INDEX . 'themes/' . $dir_all_theme . '/' . $load_config_temp;
//	echo $tmp_plugin . '<br>' . "\n";
	
	
	// ưu tiên hàng của child theme trước
	if ( $tmp_child_theme != '' && file_exists( $tmp_child_theme ) ) {
		$arr_for_show_html_file_load[] = '<!-- config HTML (child theme): ' . $load_config_temp . ' -->';
		
		$main_content = file_get_contents( $tmp_child_theme, 1 );
		
		$arr_for_add_css[ EBE_get_css_for_theme_design ( $load_config_temp, EB_CHILD_THEME_URL ) ] = 1;
//		$arr_for_add_theme_css[ EBE_get_css_for_theme_design ( $load_config_temp, EB_CHILD_THEME_URL ) ] = 1;
	}
	// sau đó đến theme
	else if ( file_exists( $tmp_theme ) ) {
		$arr_for_show_html_file_load[] = '<!-- config HTML (theme): ' . $load_config_temp . ' -->';
		
		$main_content = file_get_contents( $tmp_theme, 1 );
		
		$arr_for_add_css[ EBE_get_css_for_theme_design ( $load_config_temp ) ] = 1;
//		$arr_for_add_theme_css[ EBE_get_css_for_theme_design ( $load_config_temp ) ] = 1;
	}
	// rồi đến plugin
	else if ( file_exists( $tmp_plugin ) ) {
		$arr_for_show_html_file_load[] = '<!-- config HTML (plugin): ' . $load_config_temp . ' -->';
		
		$main_content = file_get_contents( $tmp_plugin, 1 );
		
		$arr_for_add_css[ EBE_get_css_for_config_design ( $load_config_temp, '.html' ) ] = 1;
//		$arr_for_add_theme_css[ EBE_get_css_for_config_design ( $load_config_temp, '.html' ) ] = 1;
	}
	else {
		return 'File ' . $load_config_temp . ' not exist';
	}
	
	return $main_content;
}


// chuyển các mảng dữ liệu động về một định dạng chuẩn hơn
function WGR_convert_default_theme_to_confog ( $arr ) {
	if ( isset( $arr['top'] ) ) {
		foreach ( $arr['top'] as $k => $v ) {
			$arr['cf_top' . ( $k + 1 ) . '_include_file'] = $v;
		}
		unset( $arr['top'] );
	}
	
	if ( isset( $arr['footer'] ) ) {
		foreach ( $arr['footer'] as $k => $v ) {
			$arr['cf_footer' . ( $k + 1 ) . '_include_file'] = $v;
		}
		unset( $arr['footer'] );
	}
	
	if ( isset( $arr['home'] ) ) {
		foreach ( $arr['home'] as $k => $v ) {
			$arr['cf_home' . ( $k + 1 ) . '_include_file'] = $v;
		}
		unset( $arr['home'] );
	}
	
	return $arr;
}



function WGR_parameter_not_found ( $f ) {
	die('Parameter not found (' . basename( $v, '.php' ) . ')');
}



// host không phải là bản demo -> cập nhật lại url mới luôn và ngay
function WGR_auto_update_link_for_demo ( $current_homeurl, $current_siteurl ) {
	if ( $_SERVER['HTTP_HOST'] == 'demo.webgiare.org' ) {
		return false;
	}
	
	// riêng đối với domain demo của webgiare
	if ( strstr( $current_homeurl, '/demo.webgiare.org' ) == true
	|| strstr( $current_homeurl, 'www.demo.webgiare.org' ) == true
	|| strstr( $current_siteurl, '/demo.webgiare.org' ) == true
	|| strstr( $current_siteurl, 'www.demo.webgiare.org' ) == true ) {
		_eb_update_option( 'home', eb_web_protocol . '://' . $_SERVER['HTTP_HOST'] );
		_eb_update_option( 'siteurl', eb_web_protocol . '://' . $_SERVER['HTTP_HOST'] );
		
		wp_redirect( _eb_full_url(), 301 ); exit();
	}
	
	return true;
}




// Lấy DOM content của file xml
function WGR_get_dom_xml ( $a, $tag ) {
	$a = explode( '</' . $tag . '>', $a );
	$a = explode( '<' . $tag . '>', $a[0] );
	if ( count($a) > 1 ) {
		return $a[1];
	}
	
	return '';
}



// đồng bộ URL cũ với mới cho nội dung
function WGR_sync_old_url_in_content ( $a, $c ) {
	/*
	if ( $a == '' ) {
		return $c;
	}
	*/
	
	//
	$a = explode( ',', $a );
	foreach ( $a as $v ) {
//		$v = trim( $v );
//		if ( $v != '' ) {
			$c = str_replace( '/' . $v . '/', '/' . $_SERVER['HTTP_HOST'] . '/', $c );
//		}
	}
	
	return $c;
}

function WGR_replace_for_all_content ( $list_replace, $content_replace ) {
//	global $__cf_row;
//	$list_replace = $__cf_row['cf_replace_content'];
	
	//
//	if ( mtv_id == 1 ) echo $list_replace . '<br>' . "\n";
	
//	$list_replace = explode( "\n", trim( $list_replace ) );
	$list_replace = explode( "\n", $list_replace );
	
	//
//	if ( mtv_id == 1 ) print_r( $list_replace );
	
	foreach ( $list_replace as $v ) {
//		$v = trim( $v );
//		if ( $v != '' ) {
			$v = explode( '|', $v );
//			if ( mtv_id == 1 ) print_r( $v );
			$content_replace = str_replace( trim( $v[0] ), trim( $v[1] ), $content_replace );
//		}
	}
	
	return $content_replace;
}



// thêm thẻ LI theo tiêu chuẩn chung cho thread node
function WGR_add_li_to_thread_node ( $str ) {
	if ( strstr( $str, '</li>' ) == false ) {
		$str = '<li data-id="{tmp.trv_id}" data-ngay="{tmp.trv_ngayhethan}" data-price="{tmp.trv_num_giamoi}" data-per="{tmp.pt}" data-link="{tmp.p_link}" data-status="{tmp.product_status}" class="hide-if-gia-zero">' . $str . '</li>';
	}
	
	return $str;
}




// sắp xếp lại mảng của taxonomy sau khi select, ẩn các nhóm đang bị khóa
function WGR_order_and_hidden_taxonomy ( $arr, $order_only = 0 ) {
	
	$a = array();
	$a2 = array();
	
	// sắp xếp lại thứ tự của cat
	if ( $order_only == 1 ) {
		foreach ( $arr as $v ) {
			$stt = _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
			
			$a[ $v->term_id ] = $stt;
			
			$v->stt = $stt;
			$a2[ $v->term_id ] = $v;
		}
	}
	// thêm cả chức năng bỏ qua các nhóm đã khóa
	else {
		foreach ( $arr as $v ) {
			// không lấy các nhóm đã bị khóa
			if ( _eb_get_cat_object( $v->term_id, '_eb_category_hidden', 0 ) != 1 ) {
				$stt = _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
				
				$a[ $v->term_id ] = $stt;
				
				$v->stt = $stt;
				$a2[ $v->term_id ] = $v;
			}
		}
	}
	
	// Sắp xếp mảng từ lớn đến bé
	arsort( $a );
	
	// gán lại giá trị cho mảng sa khi order
	foreach ( $a as $k => $v ) {
		$a[$k] = $a2[$k];
	}
	
	//
	return $a;
	
}



function create_cache_infor_by ( $s ) {
	return trim( '
/*
Served from: ' . $_SERVER ['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ' on ' . date('r', date_time) . '
List file: ' . substr( $s, 1 ) . '
*/
	' );
}



function WGR_default_config ( $k ) {
	if ( ! isset( $_POST[ $k ] ) || (int) $_POST[ $k ] != 1 ) {
//		return 0;
		return 'off';
	}
	return 1;
}



// xóa bài viết theo cách riêng
function WGR_remove_post_by_type ( $post_type = 'revision', $ID = 0, $strFilter = '' ) {
	// Nếu có ID -> xóa luôn theo ID
	if ( $ID > 0 ) {
		wp_delete_post( $ID, true );
	}
	// nếu không -> xóa theo post type truyền vào
	else {
		global $wpdb;
		
		
		// xóa postmeta trước
		$wpdb->query( "DELETE FROM
			`" . wp_postmeta . "`
		WHERE
			post_id IN ( select
							ID
						from
							`" . $wpdb->posts . "`
						where
							post_type = '" . $post_type . "' " . $strFilter . " )" );
		
		// tiếp theo là term_relationships
	//	echo $wpdb->term_relationships . '<br>' . "\n"; exit();
		$wpdb->query( "DELETE FROM
			`" . $wpdb->term_relationships . "`
		WHERE
			object_id IN ( select
							ID
						from
							`" . $wpdb->posts . "`
						where
							post_type = '" . $post_type . "' " . $strFilter . " )" );
		
		// sau đó xóa posts
		$wpdb->query( "DELETE FROM
			`" . $wpdb->posts . "`
		WHERE
			post_type = '" . $post_type . "' " . $strFilter . " " );
	}
	
	return true;
}



