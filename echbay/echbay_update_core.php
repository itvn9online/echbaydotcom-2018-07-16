<hr>
<p>Mọi hướng dẫn cũng như các bản cập nhật mới nhất sẽ được giới thiệu tại liên kết này: <a href="https://github.com/itvn9online/echbaydotcom" target="_blank" rel="nofollow">https://github.com/itvn9online/echbaydotcom</a></p>
<!-- <h1>Cập nhật bộ plugin tổng của EchBay.com (webgiare.org)</h1> -->
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

function EBE_update_file_via_php ( $dir_source, $arr_dir, $arr_file, $arr_old_dir, $arr_old_file ) {
	
	//
	foreach ( $arr_dir as $v ) {
		$v2 = str_replace( $dir_source, EB_THEME_PLUGIN_INDEX, $v );
		
		echo '<strong>from</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v . ' - <strong>to</strong>: ' . $v2 ) . '<br>' . "\n";
		
		// tạo thư mục nếu chưa có
		if ( ! is_dir( $v2 ) ) {
			echo '<strong>Create dir:</strong> ' . $v2 . '<br>' . "\n";
			mkdir($v2, 0755) or die('mkdir error');
			// server window ko cần chmod
			chmod($v2, 0755) or die('chmod ERROR');
		}
	}
	
	
	// tìm và xóa các file không tồn tại trong bản mới
	foreach ( $arr_old_file as $v ) {
		
//		echo $v . "\n";
		
		// chuyển sang file ở thư mục update
		$v2 = str_replace( EB_THEME_PLUGIN_INDEX, $dir_source, $v );
//		echo $v2 . "\n";
		
		// kiểm tra xem có file ở thư mục update không -> không có -> xóa luôn file hiện tại
		if ( ! file_exists( $v2 ) ) {
			if ( unlink( $v ) ) {
				echo $v . ' <strong>deleted successful</strong><br>' . "\n";
			} else {
				echo '<strong>could not delete</strong> ' . $v . '<br>' . "\n";
			}
//			echo $v . "\n";
		}
	}
//	exit();
	
	
	// tìm và xóa các thư mục không tồn tại trong bản mới (thực hiện sau khi xóa file)
	foreach ( $arr_old_dir as $v ) {
		
//		echo $v . "\n";
		
		// chuyển sang thư mục ở thư mục update
		$v2 = str_replace( EB_THEME_PLUGIN_INDEX, $dir_source, $v );
//		echo $v2 . "\n";
		
		// kiểm tra xem có thư mục ở thư mục update không -> không có -> xóa luôn thư mục hiện tại
		if ( ! file_exists( $v2 ) ) {
			if ( rmdir( $v ) ) {
				echo $v . ' <strong>deleted successful</strong><br>' . "\n";
			} else {
				echo '<strong>could not delete</strong> ' . $v . '<br>' . "\n";
			}
//			echo $v . "\n";
		}
	}
//	exit();
	
	
	//
	foreach ( $arr_file as $v ) {
		$v2 = str_replace( $dir_source, EB_THEME_PLUGIN_INDEX, $v );
		
		echo '<strong>from</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v . ' - <strong>to</strong>: ' . $v2 ) . '<br>' . "\n";
		
		// upload file
		copy( $v, $v2 );
		
		unlink( $v );
	}
	
	//
	EBE_remove_dir_after_update( $dir_source, $arr_dir );
	
	return true;
	
}

function EBE_update_file_via_ftp () {
	
	// Thư mục sau khi download và giải nén file zip
	$dir_source_update = EB_THEME_CACHE . 'echbaydotcom-master/';
	
	//
	if ( ! is_dir( $dir_source_update ) ) {
		echo 'dir not found: ' . $dir_source_update . '<br>' . "\n";
		echo '* <em>Kiểm tra module zip.so đã có trong thư mục <strong>/usr/lib64/php/modules/</strong> chưa!</em>';
		return false;
	}
	
	// lấy danh sách file và thư mục (thư mục mới)
	$a = EBE_get_list_file_update_echbay_core( $dir_source_update );
	$list_dir_for_update_eb_core = $a[0];
	$list_file_for_update_eb_core = $a[1];
//	print_r( $list_dir_for_update_eb_core );
//	print_r( $list_file_for_update_eb_core );
//	exit();
	
	// lấy danh sách file và thư mục (thư mục cũ) -> để so sánh và xóa các file không còn tồn tại
	$a = EBE_get_list_file_update_echbay_core( EB_THEME_PLUGIN_INDEX );
	$list_dir_for_update_old_core = $a[0];
	$list_file_for_update_old_core = $a[1];
//	print_r( $list_dir_for_update_old_core );
//	print_r( $list_file_for_update_old_core );
//	exit();
	
	
	// update file thông qua ftp -> nếu không có dữ liệu -> hủy luôn
	$ftp_server = EBE_check_ftp_account();
//	if ( ! defined('FTP_USER') || ! defined('FTP_PASS') ) {
	if ( $ftp_server == false ) {
		
		// update thông qua hàm cơ bản của php
		return EBE_update_file_via_php( $dir_source_update, $list_dir_for_update_eb_core, $list_file_for_update_eb_core, $list_dir_for_update_old_core, $list_file_for_update_old_core );
		
//		return false;
	}
	
	
	// tạo kết nối tới FTP
	$ftp_user_name = FTP_USER;
	$ftp_user_pass = FTP_PASS;
	
	
	
	//
	$ftp_dir_root = EBE_get_ftp_root_dir();
	echo 'FTP root dir: ' . $ftp_dir_root . '<br><br>' . "\n";
	
	
	
	// tạo kết nối
	$conn_id = ftp_connect($ftp_server) or die('ERROR connect to server');
	
	// đăng nhập
	ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die('AutoBot login false');
	
	//
//	echo getcwd() . "\n";
	
	// Tạo file trong thư mục cache
//	$file_test = EBE_create_cache_for_ftp();
//	$file_cache_update = $file_test;
//	echo $file_test . " - \n";
//	$file_source_test = $list_file_for_update_eb_core[0];
//	$file_source_test = EB_THEME_CACHE . 'cat.js';
//	echo $file_source_test . " + \n";
	
	//
	
	//
	
	//
//	echo $ftp_dir_root . '<br>' . "\n";
//	echo $file_cache_update . '<br>' . "\n";
//	echo $file_test . '<br>' . "\n";
//	$file_test = './' . $file_test;
//	echo $file_test . '<br>' . "\n";
	
	//
//	ftp_close($conn_id);
	
	
	//
//	print_r( $list_dir_for_update_eb_core );
	foreach ( $list_dir_for_update_eb_core as $v ) {
		$v2 = str_replace( $dir_source_update, EB_THEME_PLUGIN_INDEX, $v );
		
		echo '<strong>from</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v . ' - <strong>to</strong>: ' . $v2 ) . '<br>' . "\n";
		
		// tạo thư mục nếu chưa có
		if ( ! is_dir( $v2 ) ) {
			$create_dir = '.' . strstr( $v2, '/' . $ftp_dir_root . '/' );
			echo '<strong>Create dir:</strong> ' . $create_dir . '<br>' . "\n";
			ftp_mkdir($conn_id, $create_dir);
		}
	}
//	exit();
	
	
	// tìm và xóa các file không tồn tại trong bản mới
	foreach ( $list_file_for_update_old_core as $v ) {
		
//		echo $v . "\n";
		
		// chuyển sang file ở thư mục update
		$v2 = str_replace( EB_THEME_PLUGIN_INDEX, $dir_source_update, $v );
//		echo $v2 . "\n";
		
		// kiểm tra xem có file ở thư mục update không -> không có -> xóa luôn file hiện tại
		if ( ! file_exists( $v2 ) ) {
			$v = '.' . strstr( $v, '/' . $ftp_dir_root . '/' );
			
			if ( ftp_delete($conn_id, $v) ) {
				echo $v . ' <strong>deleted successful</strong><br>' . "\n";
			} else {
				echo '<strong>could not delete</strong> ' . $v . '<br>' . "\n";
			}
//			echo $v . "\n";
		}
	}
//	exit();
	
	
	// tìm và xóa các thư mục không tồn tại trong bản mới (thực hiện sau khi xóa file)
	$arr = array_reverse( $list_dir_for_update_old_core );
	foreach ( $arr as $v ) {
		
//		echo $v . "\n";
		
		// chuyển sang thư mục ở thư mục update
		$v2 = str_replace( EB_THEME_PLUGIN_INDEX, $dir_source_update, $v );
//		echo $v2 . "\n";
		
		// kiểm tra xem có thư mục ở thư mục update không -> không có -> xóa luôn thư mục hiện tại
		if ( ! file_exists( $v2 ) ) {
			$v = '.' . strstr( $v, '/' . $ftp_dir_root . '/' );
			
			if ( ftp_rmdir($conn_id, $v) ) {
				echo $v . ' <strong>deleted successful</strong><br>' . "\n";
			} else {
				echo '<strong>could not delete</strong> ' . $v . '<br>' . "\n";
			}
//			echo $v . "\n";
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
		
		echo '<strong>from</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v . ' - <strong>to</strong>: ' . $v2 ) . '<br>' . "\n";
//		echo $file_test . ' - file cache<br>' . "\n";
		
		// upload file FTP_BINARY or FTP_ASCII -> nên sử dụng FTP_BINARY
//		ftp_put($conn_id, $v2, $v, FTP_ASCII) or die( 'ERROR upload file to server #' . $v );
		ftp_put($conn_id, $v2, $v, FTP_BINARY) or die( 'ERROR upload file to server #' . $v );
//		ftp_put($conn_id, $v2, $v) or die( 'ERROR upload file to server #' . $v );
//		ftp_put($conn_id, $v2, $file_cache_update, FTP_ASCII) or die( 'ERROR upload file to server #' . $v );
		
		unlink( $v );
	}
	
	
	
	// xóa thư mục sau khi update
//	foreach ( $list_dir_for_update_eb_core as $v ) {
//	}
	
	
	
	
	// close the connection
	ftp_close($conn_id);
	
	
	//
	EBE_remove_dir_after_update( $dir_source_update, $list_dir_for_update_eb_core );
	
	
	//
	return true;
	
}

function EBE_remove_dir_after_update ( $dir, $arr ) {
	
	echo '<br><br>' . "\n\n";
	
	// lật ngược mảng để xóa thư mục
	$arr = array_reverse( $arr );
//	print_r( $list_dir_for_update_eb_core );
	foreach ( $arr as $v ) {
		rmdir( $v );
		echo '<strong>remove dir</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v ) . '<br>' . "\n";
	}
	if ( file_exists( $dir . '.gitattributes' ) ) {
		unlink( $dir . '.gitattributes' );
		echo '<strong>remove file</strong>: ' . str_replace( EB_THEME_CONTENT, '', $dir ) . '.gitattributes<br>' . "\n";
	}
	rmdir( $dir );
	echo '<strong>remove dir</strong>: ' . str_replace( EB_THEME_CONTENT, '', $dir ) . '<br>' . "\n";
	
	// cập nhật lại version trong file cache
	_eb_get_static_html ( 'github_version', EBE_get_text_version( file_get_contents( EB_THEME_PLUGIN_INDEX . 'readme.txt', 1 ) ), '', 60 );
	
}

function EBE_get_text_version ( $str ) {
	$str = explode( 'Stable tag:', $str );
	$str = explode( "\n", $str[1] );
	return trim( $str[0] );
}



//
//if ( mtv_id == 1 ) {
//if ( current_user_can('manage_options') )  {
	if ( isset( $_GET['confirm_eb_process'] ) ) {
		
		set_time_limit( 0 );
		
		$file_cache_test = EB_THEME_CACHE . 'eb_update_core.txt';
		
		//
		$lats_update_file_test = 0;
		if ( file_exists( $file_cache_test ) ) {
			$lats_update_file_test = file_get_contents( $file_cache_test, 1 );
		}
		
		//
		$time_limit_update = 60;
		
		//
		if ( date_time - $lats_update_file_test > $time_limit_update ) {
			
			// nơi lưu file zip
			$destination_path = EB_THEME_CACHE . '/echbaydotcom.zip';
			
			// download từ github
			if ( ! file_exists( $destination_path ) ) {
				copy( 'https://github.com/itvn9online/echbaydotcom/archive/master.zip', $destination_path );
				chmod( $destination_path, 0777 );
			}
			
			
			// dir for content
			echo 'Dir content: <strong>' . EB_THEME_CONTENT . '</strong><br>' . "\n";
			
			
			
			// Giải nén file
			if ( file_exists( $destination_path ) ) {
				if ( class_exists( 'ZipArchive' ) ) {
					echo '<div>Using: <strong>ZipArchive</strong></div>'; 
					
					$zip = new ZipArchive;
					if ($zip->open( $destination_path ) === TRUE) {
						$zip->extractTo( EB_THEME_CACHE );
						$zip->close();
						echo '<div>Unzip to: ' . EB_THEME_CACHE . '</div>'; 
					} else {
						
						//
						echo '<div>Do not unzip file, update faild!</div>';
						
						// nếu không unzip được -> có thể do lỗi permission -> xóa đi để tải lại
						if ( EBE_ftp_remove_file( $destination_path ) == true ) {
							echo '<div>Remove zip file via FTP!</div>';
						}
					}
				}
				else {
					echo '<div>Using: <strong>unzip_file (wordpress)</strong></div>'; 
					
					$unzipfile = unzip_file( $destination_path, EB_THEME_CACHE );
					if ( $unzipfile == true ) {
						echo '<div>Unzip to: ' . EB_THEME_CACHE . '</div>'; 
					} else {
						echo '<div>Do not unzip file, update faild!</div>';
					}
				}
				echo '<br>' . "\n";
				
				
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
				if ( EBE_update_file_via_ftp() == true ) {
					
					// xóa file download để lần sau còn ghi đè lên
					unlink( $destination_path );
					echo '<br><div>Remove zip file after unzip.</div><br>' . "\n";
					
					// tạo file cache để quá trình này không diễn ra liên tục
					_eb_create_file( $file_cache_test, date_time );
				}
				
			}
			else {
				echo '<h3>Không tồn tại file zip để giải nén!</h3>';
			}
		}
		else {
			echo '<h3>Giãn cách mỗi lần update core tối thiểu là ' . ( $time_limit_update/ 60 ) . ' phút</h3>';
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
			echo '<h3>* Phiên bản mới nhất <strong>' . $version_in_github . '</strong> đã được phát hành, phiên bản hiện tại của bạn là <strong>' . $version_current . '</strong>!</h3>';
		} else {
			echo '<h3>Xin chúc mừng! Phiên bản <strong>' . $version_current . '</strong> bạn đang sử dụng là phiên bản mới nhất.</h3>';
		}
//		echo '<br>';
		
		//
		echo '<br><h2><center><a href="#" class="click-connect-to-github-update-eb-core">[ Bấm vào đây để cập nhật lại mã nguồn cho EchBay! ]</a></center></h2>';
	}

/*	
}
else {
	echo 'Supper admin only access!';
}
*/


//
$last_time_update_eb = filemtime( EB_THEME_PLUGIN_INDEX . 'readme.txt' );


function EBE_eb_update_time_to_new_time ( $t ) {
	$t = date_time - $t;
	
	if ( $t < 3600 ) {
		$t = 'Khoảng ' . ceil( $t/ 60 ) . ' phút trước';
	}
	else {
		$t = 'Khoảng ' . ceil( $t/ 3600 ) . ' giờ trước';
	}
	
	return $t;
}


?>
<p><em>* Xin lưu ý! các tính năng được cập nhật là xây dựng và phát triển cho phiên bản trả phí, nên với phiên bản miễn phí, một số tính năng sẽ không tương thích hoặc phải chỉnh lại giao diện sau khi cập nhật. Lần cập nhật trước: <strong><?php echo date( 'r', $last_time_update_eb ); ?> (<?php echo EBE_eb_update_time_to_new_time( $last_time_update_eb ); ?>)</strong></em></p>
<br>
<script type="text/javascript">
jQuery('.click-connect-to-github-update-eb-core').attr({
	href : window.location.href.split('&confirm_eb_process=')[0] + '&confirm_eb_process=1'
}).click(function () {
	$(this).hide();
});

//
if ( window.location.href.split('&confirm_eb_process=').length > 1 ) {
	window.history.pushState("", '', window.location.href.split('&confirm_eb_process=')[0]);
}
</script>
