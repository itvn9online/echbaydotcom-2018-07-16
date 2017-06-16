<h1>Cập nhật bộ plugin tổng của EchBay.com (webgiare.org)</h1>
<br>
<p>* Xin lưu ý! các tính năng được cập nhật là xây dựng và phát triển cho phiên bản trả phí, nên với phiên bản miễn phí, một số tính năng sẽ không tương thích hoặc phải chỉnh lại giao diện sau khi cập nhật.</p>
<br>
<?php


function EBE_get_list_file_update_echbay_core ( $dir, $arr_dir = array(), $arr_file = array() ) {
	
	if ( substr( $dir, -1 ) == '/' ) {
		$dir = substr( $dir, 0, -1 );
	}
	
	$arr = glob ( $dir . '/*' );
//	print_r( $arr );
	
	//
	foreach ( $arr as $v ) {
		if ( is_dir( $v ) ) {
			$arr_dir[] = $v;
			
			$a = EBE_get_list_file_update_echbay_core( $v, $arr_dir, $arr_file );
			$arr_dir += $a[0];
			$arr_file += $a[1];
		}
		else if ( is_file( $v ) ) {
			$arr_file[] = $v;
		}
	}
	
	return array(
		$arr_dir,
		$arr_file
	);
}

function EBE_update_file_via_php ( $dir_source, $arr_dir, $arr_file ) {
	
	//
	foreach ( $arr_dir as $v ) {
		$v2 = str_replace( $dir_source, EB_THEME_PLUGIN_INDEX, $v );
		
		echo '<strong>from</strong>: ' . $v . ' - <strong>to</strong>: ' . $v2 . '<br>' . "\n";
		
		// tạo thư mục nếu chưa có
		if ( ! is_dir( $v2 ) ) {
			echo '<strong>Create dir:</strong> ' . $v2 . '<br>' . "\n";
			mkdir($v2, 0755) or die('mkdir error');
			// server window ko cần chmod
			chmod($v2, 0755) or die('chmod ERROR');
		}
	}
	
	//
	foreach ( $list_file_for_update_eb_core as $v ) {
		$v2 = str_replace( $dir_source, EB_THEME_PLUGIN_INDEX, $v );
		
		echo '<strong>from</strong>: ' . $v . ' - <strong>to</strong>: ' . $v2 . '<br>' . "\n";
		
		// upload file
		copy( $v, $v2 );
		
		unlink( $v );
	}
	
	//
	EBE_remove_dir_after_update( $dir_source, $arr_dir );
	
}

function EBE_update_file_via_ftp () {
	
	// Thư mục sau khi download và giải nén file zip
	$dir_source_update = EB_THEME_CACHE . 'echbaydotcom-master/';
	
	// lấy danh sách file và thư mục
	$a = EBE_get_list_file_update_echbay_core( $dir_source_update );
	$list_dir_for_update_eb_core = $a[0];
	$list_file_for_update_eb_core = $a[1];
	
	
	// update file thông qua ftp -> nếu không có dữ liệu -> hủy luôn
	if ( ! defined('FTP_USER') || ! defined('FTP_PASS') ) {
		
		// update thông qua hàm cơ bản của php
		EBE_update_file_via_php( $dir_source_update, $list_dir_for_update_eb_core, $list_file_for_update_eb_core );
		
		return false;
	}
	
	
	// tạo kết nối tới FTP
	if ( ! defined('FTP_HOST') ) {
		$ftp_server = $_SERVER['SERVER_ADDR'];
	} else {
		$ftp_server = FTP_HOST;
	}
	$ftp_user_name = FTP_USER;
	$ftp_user_pass = FTP_PASS;
	
	// tạo kết nối
	$conn_id = ftp_connect($ftp_server) or die('ERROR connect to server');
	
	// đăng nhập
	ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die('AutoBot login false');
	
	//
//	echo getcwd() . "\n";
	
	// Tạo file trong thư mục cache
	$file_test = EB_THEME_CACHE . 'test_ftp.txt';
//	$file_cache_update = $file_test;
//	echo $file_test . " - \n";
//	$file_source_test = $list_file_for_update_eb_core[0];
//	$file_source_test = EB_THEME_CACHE . 'cat.js';
//	echo $file_source_test . " + \n";
	
	//
	$ftp_dir_root = '';
	
	//
	if ( ! file_exists( $file_test ) ) {
		_eb_create_file( $file_test, 1 );
	}
	
	//
	if ( ! file_exists( $file_test ) ) {
		die('ERROR create test file!');
	}
	
	// Tìm thư mục gốc của tài khoản FTP này
//	if ( ! ftp_put($conn_id, '.' . $file_test, '.' . $file_source_test, FTP_ASCII) ) {
		$ftp_root_dir = explode( '/', $file_test );
		
		foreach ( $ftp_root_dir as $v ) {
//			echo $v . "\n";
			if ( $v != '' ) {
				$file_test = strstr( $file_test, $v );
//				echo $file_test . " - \n";
//				$file_source_test = strstr( $file_source_test, $v );
//				echo $file_source_test . " + \n";
				
				//
//				if ( $file_test != '' && $file_source_test != '' ) {
				if ( $file_test != '' ) {
//					if ( ftp_put($conn_id, './' . $file_test, './' . $file_source_test, FTP_ASCII) ) {
					if ( ftp_nlist($conn_id, './' . $file_test) != false ) {
//						$ftp_dir_root = './' . $v;
						$ftp_dir_root = $v;
						break;
					}
//					echo "\n";
				}
			}
		}
//	}
	
	//
//	echo $ftp_dir_root . '<br>' . "\n";
//	echo $file_cache_update . '<br>' . "\n";
//	echo $file_test . '<br>' . "\n";
	$file_test = './' . $file_test;
//	echo $file_test . '<br>' . "\n";
	
	//
//	ftp_close($conn_id);
	
	
	//
//	print_r( $list_dir_for_update_eb_core );
	foreach ( $list_dir_for_update_eb_core as $v ) {
		$v2 = str_replace( $dir_source_update, EB_THEME_PLUGIN_INDEX, $v );
		
		echo '<strong>from</strong>: ' . $v . ' - <strong>to</strong>: ' . $v2 . '<br>' . "\n";
		
		// tạo thư mục nếu chưa có
		if ( ! is_dir( $v2 ) ) {
			$create_dir = '.' . strstr( $v2, '/' . $ftp_dir_root . '/' );
			echo '<strong>Create dir:</strong> ' . $create_dir . '<br>' . "\n";
			ftp_mkdir($conn_id, $create_dir);
		}
	}
//	exit();
	
	//
//	print_r( $list_file_for_update_eb_core );
	foreach ( $list_file_for_update_eb_core as $v ) {
//		_eb_create_file( $file_cache_update, file_get_contents( $v, 1 ) );
		
		$v2 = str_replace( $dir_source_update, EB_THEME_PLUGIN_INDEX, $v );
		$v2 = '.' . strstr( $v2, '/' . $ftp_dir_root . '/' );
		
//		$v = '.' . strstr( $v, '/' . $ftp_dir_root . '/' );
		
		echo '<strong>from</strong>: ' . $v . ' - <strong>to</strong>: ' . $v2 . '<br>' . "\n";
//		echo $file_test . ' - file cache<br>' . "\n";
		
		/*
		if( ftp_nlist($conn_id, $file_test) == false ) {
			die( 'File not exist: ' . $file_test );
		}
		if( ftp_nlist($conn_id, $v2) == false ) {
			die( 'File not exist: ' . $v2 );
		}
		*/
		
		// upload file
		ftp_put($conn_id, $v2, $v, FTP_ASCII) or die( 'ERROR upload file to server #' . $v );
//		ftp_put($conn_id, $v2, $file_cache_update, FTP_ASCII) or die( 'ERROR upload file to server #' . $v );
		
		unlink( $v );
	}
	
	
	// close the connection
	ftp_close($conn_id);
	
	
	//
	EBE_remove_dir_after_update( $dir_source_update, $list_dir_for_update_eb_core );
	
}

function EBE_remove_dir_after_update ( $dir, $arr ) {
	
	echo '<br><br>' . "\n\n";
	
	// lật ngược mảng để xóa thư mục
	$arr = array_reverse( $arr );
//	print_r( $list_dir_for_update_eb_core );
	foreach ( $arr as $v ) {
		rmdir( $v );
		echo '<strong>remove dir</strong>: ' . $v . '<br>' . "\n";
	}
	if ( file_exists( $dir . '.gitattributes' ) ) {
		unlink( $dir . '.gitattributes' );
		echo '<strong>remove file</strong>: ' . $dir . '.gitattributes<br>' . "\n";
	}
	rmdir( $dir );
	echo '<strong>remove dir</strong>: ' . $dir . '<br>' . "\n";
	
	// cập nhật lại version trong file cache
	_eb_get_static_html ( 'github_version', EBE_get_text_version( file_get_contents( EB_THEME_PLUGIN_INDEX . 'readme.txt', 1 ) ), '', 60 );
	
}

function EBE_get_text_version ( $str ) {
	$str = explode( 'Stable tag:', $str );
	$str = explode( "\n", $str[1] );
	return trim( $str[0] );
}



//
if ( mtv_id == 1 ) {
	if ( isset( $_GET['confirm_process'] ) ) {
		
		set_time_limit( 0 );
		
		$file_cache_test = EB_THEME_CACHE . 'eb_update_core.txt';
		
		//
		$lats_update_file_test = 0;
		if ( file_exists( $file_cache_test ) ) {
			$lats_update_file_test = file_get_contents( $file_cache_test, 1 );
		}
		
		//
		if ( date_time - $lats_update_file_test > 300 ) {
			
			// nơi lưu file zip
			$destination_path = EB_THEME_CACHE . '/echbaydotcom.zip';
			
			// download từ github
			copy( 'https://github.com/itvn9online/echbaydotcom/archive/master.zip', $destination_path );
			chmod( $destination_path, 0777 );
			
			// Giải nén file
			if ( file_exists( $destination_path ) ) {
				if ( class_exists( 'ZipArchive' ) ) {
					$zip = new ZipArchive;
					if ($zip->open( $destination_path ) === TRUE) {
						$zip->extractTo( EB_THEME_CACHE );
						$zip->close();
						echo '<div>Unzip to: ' . EB_THEME_CACHE . '</div>'; 
					} else {
						echo '<div>Do not unzip file, update faild!</div>';
					}
				}
				else {
					$unzipfile = unzip_file( $destination_path, EB_THEME_CACHE );
					if ( $unzipfile == true ) {
						echo '<div>Unzip to: ' . EB_THEME_CACHE . '</div>'; 
					} else {
						echo '<div>Do not unzip file, update faild!</div>';
					}
				}
				
				
				//
				unlink( $destination_path );
				echo '<div>Remove zip file after unzip.</div><br>' . "\n";
				
				
				/*
				// Get array of all source files
				$files = scandir( EB_THEME_CONTENT );
				// Identify directories
				$source = EB_THEME_CACHE . 'echbaydotcom-master/';
				$destination = EB_THEME_CONTENT;
				$delete = array();
				// Cycle through all source files
				foreach ($files as $file) {
					if ( in_array( $file, array( ".", ".." ) ) ) continue;
					
					// If we copied this successfully, mark it for deletion
					if ( copy( $source . $file, $destination . $file ) ) {
						$delete[] = $source . $file;
					}
				}
				
				// Delete all successfully-copied files
				foreach ($delete as $file) {
					unlink($file);
				}
				*/
				
				//
				EBE_update_file_via_ftp();
				
				// tạo file cache để quá trình này không diễn ra liên tục
				_eb_create_file( $file_cache_test, date_time );
				
			}
			else {
				echo '<h3>Không tồn tại file zip để giải nén!</h3>';
			}
		}
		else {
			echo '<h3>Giãn cách mỗi lần update core tối thiểu là 5 phút</h3>';
		}
	}
	else {
		
		// Kiểm tra phiên bản trên github
		$strCacheFilter = 'github_version';
		$version_in_github = _eb_get_static_html ( $strCacheFilter, '', '', 300 );
		if ( $version_in_github == false ) {
			$version_in_github = _eb_getUrlContent( 'https://raw.githubusercontent.com/itvn9online/echbaydotcom/master/readme.txt' );
			
			$version_in_github = EBE_get_text_version( $version_in_github );
			
			_eb_get_static_html ( $strCacheFilter, $version_in_github, '', 60 );
		}
		
		// Phiên bản hiện tại
		$version_current = EBE_get_text_version( file_get_contents( EB_THEME_PLUGIN_INDEX . 'readme.txt', 1 ) );
		
		//
		if ( $version_in_github != $version_current ) {
			echo '<h3>* Phiên bản mới nhất <strong>' . $version_in_github . '</strong> đã được phát hành, phiên bản hiện tại của bạn là <strong>' . $version_current . '</strong>.</h3>';
		} else {
			echo '<h3>Xin chúc mừng! Phiên bản <strong>' . $version_current . '</strong> bạn đang sử dụng là phiên bản mới nhất.</h3>';
		}
		echo '<br>';
		
		//
		echo '<h2><a href="#" class="click-connect-to-echbay-update-wp-core">Bấm vào đây để cập nhật lại core cho EchBay!</a></h2>';
	}
	
}
else {
	echo 'Supper admin only access!';
}



?>
<script type="text/javascript">
jQuery('.click-connect-to-echbay-update-wp-core').attr({
	href : window.location.href.split('&confirm_process=')[0] + '&confirm_process=1'
}).click(function () {
	$(this).hide();
});

//
if ( window.location.href.split('&confirm_process=').length > 1 ) {
	window.history.pushState("", '', window.location.href.split('&confirm_process=')[0]);
}
</script>
