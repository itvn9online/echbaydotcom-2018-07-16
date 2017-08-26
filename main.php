<?php



// chế độ bảo trì đang được bật -> tạm dừng mọi truy cập
if ( file_exists( EB_THEME_CACHE . 'update_running.txt' ) ) {
	
	//
	$time_for_bao_tri = file_get_contents( EB_THEME_CACHE . 'update_running.txt', 1 );
	
	// Hiển thị chế độ bảo trì trong vòng 2 phút thôi
	if ( date_time - $time_for_bao_tri < 120 ) {
		
		// Set trạng thái cho trang 404
		$protocol = ( isset($_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		
		//echo $protocol;
		header( $protocol . ' 404 Not Found' );
		
		die('<title>He thong dang duoc bao tri</time><h1>He thong dang duoc bao tri</h1>');
		
	}
	else {
		echo '<!-- Remove update_running.txt in ebcache dir -->';
	}
}




// chuyển từ vesion cũ sang version mới
if ( ! file_exists( EB_THEME_URL . 'i.php' ) ) {
	$arr = glob ( EB_THEME_URL . 'theme/*' );
	print_r( $arr );
	
	// lần đầu chỉ copy thư mục và các file trong đó
	foreach ( $arr as $v ) {
		// tạo thư mục nếu chưa có
		if ( is_dir( $v ) ) {
			echo $v . "\n";
			$fname = basename( $v );
			
			//
			$path = EB_THEME_URL . $fname;
			echo $path . "\n";
			
			if ( $fname == '.' || $fname == '..' ) {
			}
			else {
				EBE_create_dir( $path );
				
				//
				$arr2 = glob ( $v . '/*' );
				print_r( $arr2 );
				
				foreach ( $arr2 as $v2 ) {
					$copy_to = EB_THEME_URL . $fname . '/' . basename( $v2 );
					echo $copy_to . "\n";
					echo filesize( $v2 ) . "\n";
					
					if ( filesize( $v2 ) > 0 && ! file_exists( $copy_to ) ) {
						WGR_copy( $v2, $copy_to );
					}
				}
			}
		}
	}
	
	// lần 2 mới copy các file
	foreach ( $arr as $v ) {
		if ( is_file( $v ) ) {
			echo $v . "\n";
			$fname = basename( $v );
			
			// file index thì chuyển thành i.php
			if ( $fname == 'index.php' ) {
				$fname = 'i.php';
			}
			
			//
			$path = EB_THEME_URL . $fname;
			echo $path . "\n";
			
			// copy file nếu chưa có
			if ( ! file_exists( $path ) ) {
				WGR_copy( $v, $path );
			}
		}
	}
}



/*
* CONFIG
*/
// thời gian lưu cache
$set_time_for_main_cache = 600;
//$set_time_for_main_cache = 60;

// thời gian cache
//$set_time_for_main_cache = $__cf_row['cf_reset_cache'];

// thử xem cache x2 đối với đoạn này xem có ok không
//$set_time_for_main_cache = $__cf_row['cf_reset_cache'] * 2;

// set tĩnh thời gian cache
$set_time_for_main_cache = $set_time_for_main_cache - rand( 0, $set_time_for_main_cache/ 2 );





//
//echo $__cf_row['cf_reset_cache'] . '<br>' . "\n";
//echo mtv_id . '<br>' . "\n";
//echo $act . '<br>' . "\n";





//
function ___eb_cache_getUrl () {
	if ( isset($_SERVER['REQUEST_URI']) ) {
		$url = $_SERVER['REQUEST_URI'];
	} else {
		$url = $_SERVER['SCRIPT_NAME'];
		$url .= ( !empty($_SERVER['QUERY_STRING']) ) ? '?' . $_SERVER[ 'QUERY_STRING' ] : '';
	}
	if ( $url == '/' || $url == '' ) {
		$url = '-';
	} else {
		$url = explode( '?gclid=', $url );
		$url = explode( '?utm_', $url[0] );
		$url = explode( '?fb_comment_id=', $url[0] );
		$url = $url[0];
		
		//
		if ( strlen ( $url ) > 200 ) {
			$url = md5( $url );
		} else {
			$url = preg_replace( "/\/|\?|\&|\,/", "-", $url );
		}
	}
	
	//
    $url = EB_THEME_CACHE . 'all/' . $url . '.txt';
	
	//
	return $url;
}
//echo $_SERVER['REQUEST_URI'] . '<br>' . "\n";
//echo $_SERVER['SCRIPT_NAME'] . '<br>' . "\n";
//echo $_SERVER['QUERY_STRING'] . '<br>' . "\n";
//echo ___eb_cache_getUrl () . '<br>' . "\n";
//exit();

// getUrl gets the queried page with query string
// page's content is $buffer ($data)
function ___eb_cache_cache ( $filename, $data ) {
	
	// sử dụng hàm này cho gọn
	file_put_contents( $filename, $data ) or die('ERROR: write cache file');
//	chmod($filename, 0777);
	
	/*
	// mở file để ghi
	$filew = fopen( $filename, 'w+' );
	// ghi nội dung cho file
	fwrite($filew, $data);
	fclose($filew);
	*/
	
	return true;
}

function ___eb_cache_display ( $cache_time = 60 ) {
	$filename = ___eb_cache_getUrl();
	
	// nếu không tồn tại file/
	if ( ! file_exists( $filename ) ) {
		
		//
		/*
		file_put_contents( $filename, '.', LOCK_EX ) or die('ERROR: create cache file');
		chmod($filename, 0777);
		*/
//		exit();
		
		// -> tạo file và trả về tên file
		$filew = fopen( $filename, 'x+' );
		// nhớ set 777 cho file
		chmod($filename, 0777);
		fclose($filew);
		
		//
//		exit();
		
		// trả về tên file
		return $filename;
	}
	
	// nếu tồn tại -> tiếp tục kiểm tra thời gian tạo cache
	/*
	$filer = fopen( $filename, 'r' );
	$data = fread( $filer, filesize( $filename) );
	fclose( $filer );
	*/
	
	//
	$time_file = filemtime ( $filename );
	// 100 is the cache time here!!!
	if ( date_time - $cache_time > $time_file ) {
		return $filename;
	}
	
	//
	$data = file_get_contents ( $filename, 1 );
	if ( $data == '' || $data == '.' ) {
		return $filename;
	}
	
	//
	echo ___eb_cache_mobile_class ( $data );
	
	//
	exit();
	die();
}


// set class cho bản mobile nếu sử dụng cache
function ___eb_cache_mobile_class ( $data ) {
//	global $func;
	
	if ( _eb_checkDevice() == 'mobile' ) {
		$data = str_replace( 'eb-set-css-pc-mobile', 'style-for-mobile', $data );
	}
	
	echo $data;
}




//
function ___eb_cache_end_ob_cache ( $strEBPageDynamicCache ) {
	global $set_time_for_main_cache;
	
	
	
	//
	$main_content = ob_get_contents();
	
	
	//
//	ob_end_flush();
	ob_end_clean();
	
	
	
	// xóa các class của WP đi, lằng nhằng vãi -> chiếm dụng nhiều HTML quá
	/*
	$arr_remove_wp_class = array(
		'menu-item-type-custom',
		'menu-item-type-taxonomy',
		'menu-item-object-blogs',
		'menu-item-object-category',
		'menu-item-has-children',
	);
	foreach ( $arr_remove_wp_class as $v ) {
		$main_content = str_replace( $v, '', $main_content );
	}
	*/
	
	// xóa các thẻ TAB đi -> rút gọn lại HTML 1 chút
	$main_content = preg_replace( "/\t/", "", $main_content );
	
	// optimize javascript
	
	// bỏ các dấu xuống dòng thừa
//	$main_content = preg_replace( "/\n\n/", "\n", $main_content );
	
	
	
	// -> echo nội dung ra -> bị ob nên nội dung không được in ra
//	echo $main_content;
	___eb_cache_mobile_class ( $main_content );
	
	
	
	
	// thêm câu báo rằng đang lấy nội dung trong cache
	$eb_cache_note = '<!-- Cached page generated by EchBay Cache (ebcache)
Served from: ' . $_SERVER ['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ' on ' . date( 'Y-m-d H:i:s', date_time ) . '
Cache auto clean after ' . $set_time_for_main_cache . ' secondes
Caching using hard disk drive

Compression = gzip -->';
	
	//
//	echo $eb_cache_note;
	
	
	
	// lưu file tĩnh
//	_eb_get_static_html ( $strEBPageDynamicCache, $main_content );
	___eb_cache_cache ( $strEBPageDynamicCache, $main_content . $eb_cache_note );
}



// if no cache, callback cache
//ob_start ('___eb_cache_cache');







// mặc định là không cache
$enable_echbay_super_cache = 0;

// kiểm tra các chế độ cache
if ( $__cf_row['cf_reset_cache'] > 0 ) {
	// nếu thành viên đang đăng nhập -> không cache
	if ( mtv_id > 0 ) {
		$enable_echbay_super_cache = 3;
	}
	// sử dụng cache echbay cho một số trang thôi, dùng nhiều chưa kiểm chứng lỗi
	else if ( $act == '' || $act == 'archive' || $act == 'single' || $act == 'page' ) {
//	else if ( $act == 'archive' || $act == 'single' || $act == 'page' ) {
		$enable_echbay_super_cache = 1;
		
		//
		if ( $__cf_row['cf_reset_cache'] < 30 ) {
			$enable_echbay_super_cache = 8;
		}
		// nếu chế độ cache wp đang được bật -> không dùng cache EchBay
		else if ( defined('WP_CACHE') && WP_CACHE == true ) {
			$enable_echbay_super_cache = 2;
		}
	}
	else {
		$enable_echbay_super_cache = 9;
	}
}
//echo WP_CACHE . '<br>' . "\n";


//
$css_m_css = implode( ' ', get_body_class() );


// cache chỉ được kích hoạt khi tham số này = 1
if ( $enable_echbay_super_cache == 1 ) {

	// check device (có cache) -> mặc định là 1 class css để lát replace nếu là mobile
	$css_m_css .= ' eb-set-css-pc-mobile';
	
	
	
	
	// kiểm tra và hiển thị nội dung cũ nếu có -> có thì nó sẽ exist luôn rồi
	$strEBPageDynamicCache = ___eb_cache_display( $set_time_for_main_cache );
	
	
	
	
	
	// tạo file trước để giữ chỗ luôn và ngay đã
//	_eb_create_file ( EB_THEME_CACHE . $strEBPageDynamicCache . '.txt', '&nbsp;' );
	
	
	
	
	
	
	// chưa có -> gọi lệnh cache luôn
	// bắt đầu cho bộ cache toàn trang -> ở footer gọi hàm ob_end là được
	ob_start();
	
	
	
	
	// gọi đến file index của từng theme
	include_once EB_THEME_URL . 'i.php';
	
	
	
	//
	___eb_cache_end_ob_cache ( $strEBPageDynamicCache );
	
	
	
}
// nếu không có cache -> include bình thường thôi
else {
//	echo 1;
	// check device (không cache)
//	$css_m_css = implode( ' ', get_body_class() );
//	$css_m_css = '';
	// dùng tính năng cache toàn trang thì tạm thời tắt chức năng phát hiện mobile bằng php
	if ( _eb_checkDevice() == 'mobile' ) {
		$css_m_css .= ' style-for-mobile';
	}
	
	
	
	// gọi đến file index của từng theme
	//include_once EB_THEME_URL . 'index.php';
	include_once EB_THEME_URL . 'i.php';
	
	
	
	// nếu cache đang được bật, nhưng lại dùng cache của đơn vị khác -> cũng hủy cache luôn
	if ( $enable_echbay_super_cache == 2 ) {
		echo '<!-- EchBay Cache (ebcache) is enable, but an another plugin cache is enable too
If you want to using EchBay Cache, please set WP_CACHE = false or comment WP_CACHE in file wp-config.php -->';
	}
	// nếu cache đang được bật, nhưng người dùng đăng nhập -> thông báo tới người dùng
	else if ( $enable_echbay_super_cache == 3 ) {
		echo '<!-- EchBay Cache (ebcache) is enable, but not caching requests by known users -->';
	}
	// chỉ cache với 1 số trang cụ thể thôi
	else if ( $enable_echbay_super_cache == 9 ) {
		echo '<!-- EchBay Cache cache only home page, category page, post details page -->';
	}
	// thời gian tối thiểu để cache là 30s
	else if ( $enable_echbay_super_cache == 8 ) {
		echo '<!-- EchBay Cache (ebcache) is enable, but not time for reset cache too many short (' . $__cf_row['cf_reset_cache'] . ' secondes). Min 30 secondes -->';
	}
}




