<hr>
<p>Mọi hướng dẫn cũng như các bản cập nhật mới nhất sẽ được giới thiệu tại liên kết này: <a href="https://github.com/itvn9online/echbaydotcom" target="_blank" rel="nofollow">https://github.com/itvn9online/echbaydotcom</a></p>
<p>Lịch sử chi tiết các cập nhật sẽ được liệt kê tại đây: <a href="https://github.com/itvn9online/echbaydotcom/commits/master" target="_blank" rel="nofollow">https://github.com/itvn9online/echbaydotcom/commits/master</a></p>
<!-- <h1>Cập nhật bộ plugin tổng của EchBay.com (webgiare.org)</h1> -->
<?php




// chuyển từ vesion cũ sang version mới
if ( ! file_exists( EB_THEME_URL . 'i.php' ) ) {
	$arr = glob ( EB_THEME_URL . 'theme/*' );
//	print_r( $arr );
	
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
//				print_r( $arr2 );
				
				foreach ( $arr2 as $v2 ) {
					$copy_to = EB_THEME_URL . $fname . '/' . basename( $v2 );
					echo $copy_to . ' (file size: ' . filesize( $v2 ) . ')' . "\n";
					
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

function EBE_update_file_via_php ( $dir_source, $arr_dir, $arr_file, $arr_old_dir, $arr_old_file, $dir_to ) {
	
	//
	foreach ( $arr_dir as $v ) {
		$v2 = str_replace( $dir_source, $dir_to, $v );
		
		echo '<strong>from</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v . ' - <strong>to</strong>: ' . $v2 ) . '<br>' . "\n";
		
		// tạo thư mục nếu chưa có
		if ( EBE_create_dir( $v2 ) == true ) {
			echo '<strong>Create dir:</strong> ' . $v2 . '<br>' . "\n";
		}
	}
	
	
	// tìm và xóa các file không tồn tại trong bản mới
	foreach ( $arr_old_file as $v ) {
		
//		echo $v . "\n";
		
		// chuyển sang file ở thư mục update
		$v2 = str_replace( $dir_to, $dir_source, $v );
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
		$v2 = str_replace( $dir_to, $dir_source, $v );
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
		$v2 = str_replace( $dir_source, $dir_to, $v );
		
		echo '<strong>from</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v . ' - <strong>to</strong>: ' . $v2 ) . '<br>' . "\n";
		
		// upload file
		copy( $v, $v2 );
		
		unlink( $v );
	}
	
	//
	EBE_remove_dir_after_update( $dir_source, $arr_dir, $dir_to );
	
	return true;
	
}

function EBE_update_file_via_ftp () {
	
	// Thư mục sau khi download và giải nén file zip
	$dir_source_update = EB_THEME_CACHE . 'echbaydotcom-master/';
	
	// thư mục mà các file sẽ được update tới
	$dir_to_update = EB_THEME_PLUGIN_INDEX;
	
	
	// mặc định là update plugin
	if ( ! is_dir( $dir_source_update ) ) {
		// nếu không có -> có thể là update theme
		$dir_source_update = EB_THEME_CACHE . 'echbaytwo-master/';
		$dir_to_update = EB_THEME_URL;
		
		// kiểm tra lại
		if ( ! is_dir( $dir_source_update ) ) {
			echo 'dir not found: ' . $dir_source_update . '<br>' . "\n";
			echo '* <em>Kiểm tra module zip.so đã có trong thư mục <strong>/usr/lib64/php/modules/</strong> chưa!</em>';
			return false;
		}
		
		// chỉ hỗ trợ update theme có tên chỉ định
		if ( strstr( $dir_to_update, 'echbaytwo' ) == false ) {
			echo 'theme it not support update via this panel: ' . $dir_to_update . '<br>' . "\n";
			echo '* <em>Chỉ hỗ trợ update theme có nền là <strong>echbaytwo</strong>!</em>';
			return false;
		}
	}
	echo 'Source udpate: <strong>' . basename( $dir_source_update ) . '</strong><br>' . "\n";
	echo 'To update: <strong>' . basename( $dir_to_update ) . '</strong><br>' . "\n";
	
	// lấy danh sách file và thư mục (thư mục mới)
	$a = EBE_get_list_file_update_echbay_core( $dir_source_update );
	$list_dir_for_update_eb_core = $a[0];
	$list_file_for_update_eb_core = $a[1];
//	print_r( $list_dir_for_update_eb_core );
//	print_r( $list_file_for_update_eb_core );
//	exit();
	
	// lấy danh sách file và thư mục (thư mục cũ) -> để so sánh và xóa các file không còn tồn tại
	$a = EBE_get_list_file_update_echbay_core( $dir_to_update );
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
		return EBE_update_file_via_php( $dir_source_update, $list_dir_for_update_eb_core, $list_file_for_update_eb_core, $list_dir_for_update_old_core, $list_file_for_update_old_core, $dir_to_update );
		
//		return false;
	}
	
	
	// tạo kết nối tới FTP
	$ftp_user_name = FTP_USER;
	$ftp_user_pass = FTP_PASS;
	
	
	
	//
	$ftp_dir_root = EBE_get_ftp_root_dir();
	echo 'FTP root dir: <strong>' . $ftp_dir_root . '</strong><br><br>' . "\n";
	
	
	
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
		$v2 = str_replace( $dir_source_update, $dir_to_update, $v );
		
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
		$v2 = str_replace( $dir_to_update, $dir_source_update, $v );
//		echo $v2 . '<br>' . "\n";
		
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
		$v2 = str_replace( $dir_to_update, $dir_source_update, $v );
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
		
		$v2 = str_replace( $dir_source_update, $dir_to_update, $v );
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
//	exit();
	
	
	
	// xóa thư mục sau khi update
//	foreach ( $list_dir_for_update_eb_core as $v ) {
//	}
	
	
	
	
	// close the connection
	ftp_close($conn_id);
	
	
	//
	EBE_remove_dir_after_update( $dir_source_update, $list_dir_for_update_eb_core, $dir_to_update );
	
	
	//
	return true;
	
}

function EBE_remove_dir_after_update ( $dir, $arr, $dir_to = '' ) {
	
	echo '<br><br>' . "\n\n";
	
	// lật ngược mảng để xóa thư mục trước
	$arr = array_reverse( $arr );
//	print_r( $arr );
	foreach ( $arr as $v ) {
		rmdir( $v );
		echo '<strong>remove dir</strong>: ' . str_replace( EB_THEME_CONTENT, '', $v ) . '<br>' . "\n";
	}
	
	// xóa thư mục gốc
	rmdir( $dir );
	echo '<strong>remove dir</strong>: ' . str_replace( EB_THEME_CONTENT, '', $dir ) . '<br>' . "\n";
	
	// test
//	exit();
	
	
	// cập nhật lại version trong file cache
//	_eb_get_static_html ( 'github_version', EBE_get_text_version( file_get_contents( EB_THEME_PLUGIN_INDEX . 'readme.txt', 1 ) ), '', 60 );
	_eb_get_static_html ( 'github_version', file_get_contents( EB_THEME_PLUGIN_INDEX . 'VERSION', 1 ), '', 60 );
	
}

function EBE_get_text_version ( $str ) {
	$str = explode( 'Stable tag:', $str );
	if ( isset( $str[1] ) ) {
		$str = explode( "\n", $str[1] );
		return trim( $str[0] );
	}
	return 'null';
}



//
//if ( mtv_id == 1 ) {
//if ( current_user_can('manage_options') )  {
	if ( isset( $_GET['confirm_eb_process'] ) ) {
		
		
		// không cập nhật trên localhost
		if ( strstr( $_SERVER['HTTP_HOST'], 'localhost' ) == true ) {
//			echo $_SERVER['HTTP_HOST']; exit();
//			echo $_SERVER['REQUEST_URI']; exit();
			
			// nếu thư mục là webgiare thì bỏ qua chế độ cập nhật
			if ( strstr( $_SERVER['REQUEST_URI'], '/wordpress.org/' ) == true ) {
				echo '<h1>Chế độ cập nhật đã bị vô hiệu hóa bởi coder!</h1>';
				exit();
			}
		}
		
		
		
		// không giới hạn thời gian để download file được lâu hơn
		set_time_limit( 0 );
		
		//
		$connect_to_server = isset( $_GET['connect_to'] ) ? $_GET['connect_to'] : '';
		
		//
		if ( $connect_to_server == 'theme' ) {
			$file_cache_test = EB_THEME_CACHE . 'eb_update_theme.txt';
		}
		else {
			$file_cache_test = EB_THEME_CACHE . 'eb_update_core.txt';
		}
		
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
			$destination_path = EB_THEME_CACHE . 'echbaydotcom.zip';
			
			// download từ github
			if ( ! file_exists( $destination_path ) ) {
				
				// server dự phòng
				$url2_for_download_ebdotcom = '';
				
				// chọn server để update -> github là thời gian thực
				if ( $connect_to_server == 'github' ) {
					$url_for_download_ebdotcom = 'https://github.com/itvn9online/echbaydotcom/archive/master.zip';
				}
				// cập nhật theme
				else if ( $connect_to_server == 'theme' ) {
					$url_for_download_ebdotcom = 'https://github.com/itvn9online/echbaytwo/archive/master.zip';
				}
				// server của echbay thì update chậm hơn chút, nhưng tải nhanh hơn -> mặc định
				else {
					$url_for_download_ebdotcom = 'https://www.echbay.com/daoloat/echbaydotcom.zip';
					
					// thiết lập chế độ download từ server dự phòng
					$url2_for_download_ebdotcom = 'http://api.echbay.com/daoloat/echbaydotcom.zip';
				}
				
				// TEST
//				$url_for_download_ebdotcom = 'http://api.echbay.com/css/bg/HD-Eagle-Wallpapers.jpg';
//				$destination_path = EB_THEME_CACHE . 'w.jpg';
				
				// thử download theo cách thông thường
				if ( copy( $url_for_download_ebdotcom, $destination_path ) ) {
					chmod( $destination_path, 0777 );
				}
				// download từ server dự phòng
				else if ( $url2_for_download_ebdotcom != '' && copy( $url2_for_download_ebdotcom, $destination_path ) ) {
					chmod( $destination_path, 0777 );
				}
				// đổi hàm khác xem ok không
				else if ( file_put_contents( $destination_path, fopen( $url_for_download_ebdotcom, 'r') ) ) {
					chmod( $destination_path, 0777 );
				}
				// sử dụng cURL để download file qua https
				else if ( WGR_copy_secure_file( $url_for_download_ebdotcom, $destination_path ) ) {
					chmod( $destination_path, 0777 );
				}
				// vẫn không được thì báo lỗi
				else {
					die('<p>URL download: <strong>' . $url_for_download_ebdotcom . '</strong></p>
					<p>SAVE to: <strong>' . $destination_path . '</strong></p>
					<h1>Download file faild!</h1>');
				}
//				exit();
				
				//
				echo '<div>Download in: <a href="' . $url_for_download_ebdotcom . '" target="_blank">' . $url_for_download_ebdotcom . '</a></div>'; 
			}
			// nếu có file -> thử kiểm tra file size chưa đủ đô -> xóa luôn
			else if ( filesize( $destination_path ) < 1000 ) {
				if ( unlink( $destination_path ) ) {
					echo '<div>Remove file because file size zero!</div>';
				}
				// xóa lại bằng ftp nếu không xóa được theo cách thông thường
				else if ( EBE_ftp_remove_file( $destination_path ) == true ) {
					echo '<div>Remove file via FTP because file size zero!</div>';
				}
				else {
					echo '<div>Canot remove file with filesize zero!</div>';
				}
			}
			
			
			// dir for content
			echo 'Dir content: <strong>' . EB_THEME_CONTENT . '</strong><br>' . "\n";
			
			
			
			// Giải nén file
			if ( file_exists( $destination_path ) ) {
				
				// kết quả giải nén
				$unzipfile = false;
				
				//
				if ( class_exists( 'ZipArchive' ) ) {
					echo '<div>Using: <strong>ZipArchive</strong></div>'; 
					
					$zip = new ZipArchive;
					if ($zip->open( $destination_path ) === TRUE) {
						$zip->extractTo( EB_THEME_CACHE );
						$zip->close();
						
						//
						$unzipfile = true;
					}
				}
				else {
					echo '<div>Using: <strong>unzip_file (wordpress)</strong></div>'; 
					
					$unzipfile = unzip_file( $destination_path, EB_THEME_CACHE );
				}
				
				//
				if ( $unzipfile == true ) {
					echo '<div>Unzip to: <strong>' . EB_THEME_CACHE . '</strong></div>'; 
					
					// xóa file của github luôn và ngay
					$f_gitattributes = EB_THEME_CACHE . 'echbaydotcom-master/.gitattributes';
					if ( file_exists( $f_gitattributes ) ) {
						if ( unlink( $f_gitattributes ) ) {
							echo '<strong>remove file</strong>: ';
						}
						else {
							echo '<strong>NOT remove file</strong>: ';
						}
						echo str_replace( EB_THEME_CONTENT, '', $f_gitattributes ) . '.gitattributes<br>' . "\n";
					}
					else {
						$f_gitattributes = EB_THEME_CACHE . 'echbaytwo-master/.gitattributes';
						if ( file_exists( $f_gitattributes ) ) {
							if ( unlink( $f_gitattributes ) ) {
								echo '<strong>remove file</strong>: ';
							}
							else {
								echo '<strong>NOT remove file</strong>: ';
							}
							echo str_replace( EB_THEME_CONTENT, '', $f_gitattributes ) . '.gitattributes<br>' . "\n";
						}
					}
					
					// v1
					/*
					if ( file_exists( $dir . '.gitattributes' ) ) {
						if ( unlink( $dir . '.gitattributes' ) ) {
							echo '<strong>remove file</strong>: ';
						}
						else {
							echo '<strong>NOT remove file</strong>: ';
						}
						echo str_replace( EB_THEME_CONTENT, '', $dir ) . '.gitattributes<br>' . "\n";
					}
					if ( $dir_to != '' && file_exists( $dir_to . '.gitattributes' ) ) {
						if ( _eb_remove_file( $dir_to . '.gitattributes' ) ) {
							echo '<strong>remove file</strong>: ';
						}
						else {
							echo '<strong>NOT remove file</strong>: ';
						}
						echo str_replace( EB_THEME_CONTENT, '', $dir_to ) . '.gitattributes<br>' . "\n";
					}
					*/
					
				} else {
					echo '<div>Do not unzip file, update faild!</div>';
					
					// nếu không unzip được -> có thể do lỗi permission -> xóa đi để tải lại
					if ( EBE_ftp_remove_file( $destination_path ) == true ) {
						echo '<div>Remove zip file via FTP!</div>';
					}
				}
				
				//
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
				
				
				
				// Bật chế độ bảo trì hệ thống
				$bat_che_do_bao_tri = EB_THEME_CACHE . 'update_running.txt';
				_eb_create_file( $bat_che_do_bao_tri, date_time );
				echo '<h2>BẬT chế độ bảo trì website!</h2><br>';
				
				// bắt đầu cập nhật
				if ( EBE_update_file_via_ftp() == true ) {
					
					// xóa file download để lần sau còn ghi đè lên
					unlink( $destination_path );
					echo '<br><div>Remove zip file after unzip.</div><br>' . "\n";
					
					// tạo file cache để quá trình này không diễn ra liên tục
					_eb_create_file( $file_cache_test, date_time );
					
					//
					echo '<div id="eb_core_update_all_done"></div>';
					
					// cho website vào chế độ chờ
					sleep(15);
					
				}
				
				// tắt chế độ bảo trì
				if ( _eb_remove_file( $bat_che_do_bao_tri ) == true ) {
					echo '<br><h2>TẮT chế độ bảo trì website!</h2>';
				}
				else {
					echo '<br><h2>Không TẮT được chế độ bảo trì! Hãy vào thư mục ebcache và xóa file update_running.txt thủ công.</h2>';
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
			$version_in_github = _eb_getUrlContent( 'https://raw.githubusercontent.com/itvn9online/echbaydotcom/master/VERSION' );
			/*
			$version_in_github = _eb_getUrlContent( 'https://raw.githubusercontent.com/itvn9online/echbaydotcom/master/readme.txt' );
			
			$version_in_github = EBE_get_text_version( $version_in_github );
			*/
			
			_eb_get_static_html ( $strCacheFilter, $version_in_github, '', 60 );
		}
		
		// Phiên bản hiện tại
//		$version_current = EBE_get_text_version( file_get_contents( EB_THEME_PLUGIN_INDEX . 'readme.txt', 1 ) );
		$version_current = file_get_contents( EB_THEME_PLUGIN_INDEX . 'VERSION', 1 );
		
		//
		if ( $version_in_github != $version_current ) {
			echo '<h3>* Phiên bản mới nhất <strong>' . $version_in_github . '</strong> đã được phát hành, phiên bản hiện tại của bạn là <strong>' . $version_current . '</strong>!</h3>';
		} else {
			echo '<h3>Xin chúc mừng! Phiên bản <strong>' . $version_current . '</strong> bạn đang sử dụng là phiên bản mới nhất.</h3>';
		}
//		echo '<br>';
		
		// Link cập nhật core từ echbay.com
		echo '<br><h2><center><a href="#" class="click-connect-to-echbay-update-eb-core">[ Bấm vào đây để cập nhật lại mã nguồn cho EchBay! ]</a></center></h2>';
		
		// Link cập nhật core từ github
		echo '<p><center><a href="#" class="click-connect-to-github-update-eb-core">[ Cập nhật mã nguồn cho EchBay theo thời gian thực! Server quốc tế (GitHub) ]</a></center></p>';
		
	}

/*	
}
else {
	echo 'Supper admin only access!';
}
*/


//
$last_time_update_eb = filemtime( EB_THEME_PLUGIN_INDEX . 'readme.txt' );
$last_time_update_theme_eb = filemtime( EB_THEME_URL . 'index.php' );


function EBE_eb_update_time_to_new_time ( $t ) {
	$t = date_time - $t;
	
	if ( $t < 3600 ) {
		$t = 'Khoảng ' . ceil( $t/ 60 ) . ' phút trước';
	}
	else if ( $t < 24 * 3600 ) {
		$t = 'Khoảng ' . ceil( $t/ 3600 ) . ' giờ trước';
	}
	else {
		$t = 'Khoảng ' . ceil( $t/ 3600/ 24 ) . ' ngày trước';
	}
	
	return $t;
}



// thư mục chứa theme hiện tại
$current_theme_dir_update = basename( EB_THEME_URL );

// hỗ trợ cập nhật theme khi sử dụng giao diện có thư mục tên như này
$enable_theme_dir_update = 'echbaytwo';



?>
<p><em>* Xin lưu ý! các tính năng được cập nhật là xây dựng và phát triển cho phiên bản trả phí, nên với phiên bản miễn phí, một số tính năng sẽ không tương thích hoặc phải chỉnh lại giao diện sau khi cập nhật. Lần cập nhật trước: <strong><?php echo date( 'r', $last_time_update_eb ); ?> (<?php echo EBE_eb_update_time_to_new_time( $last_time_update_eb ); ?>)</strong></em></p>
<br>
<?php

// hiển thị nút update theme
if ( $current_theme_dir_update == $enable_theme_dir_update ) {
?>
<p>Giao diện bạn đang sử dụng là <strong><?php echo $__cf_row['cf_current_theme_using']; ?></strong>, thư mục nền của website là <strong><?php echo $current_theme_dir_update; ?></strong>. Nền này đang được hỗ trợ cập nhật miễn phí từ hệ thống, nếu bạn muốn cập nhật hoặc cài đặt lại, vui lòng bấm nút bên dưới để thực hiện:</p>
<h2 class="text-center"><a href="#" class="click-connect-to-echbay-update-eb-theme">[ Bấm vào đây để cập nhật lại giao diện nền cho website! ]</a></h2>
<p class="text-center"><em>Lần cập nhật trước: <strong><?php echo date( 'r', $last_time_update_theme_eb ); ?> (<?php echo EBE_eb_update_time_to_new_time( $last_time_update_theme_eb ); ?>)</strong></em></p>
<br>
<?php
}
else {
?>
<p>Giao diện bạn đang sử dụng là <strong><?php echo $__cf_row['cf_current_theme_using']; ?></strong>, thư mục nền của website là <strong><?php echo $current_theme_dir_update; ?></strong>. Nền này hiện chưa hỗ trợ cập nhật miễn phí từ hệ thống của chúng tôi.</p>
<?php
}
?>
<br>
<script type="text/javascript">

// cập nhật plugin từ server của EchBay.com
jQuery('.click-connect-to-echbay-update-eb-core').attr({
	href : window.location.href.split('&confirm_eb_process=')[0] + '&confirm_eb_process=1'
}).click(function () {
	$(this).hide();
});

// cập nhật plugin từ github
jQuery('.click-connect-to-github-update-eb-core').attr({
	href : window.location.href.split('&confirm_eb_process=')[0] + '&confirm_eb_process=1&connect_to=github'
}).click(function () {
	$(this).hide();
});

// cập nhật theme
jQuery('.click-connect-to-echbay-update-eb-theme').attr({
	href : window.location.href.split('&confirm_eb_process=')[0] + '&confirm_eb_process=1&connect_to=theme'
}).click(function () {
	$(this).hide();
});

//
if ( window.location.href.split('&confirm_eb_process=').length > 1 ) {
	_global_js_eb.change_url_tab( 'confirm_eb_process' );
//	window.history.pushState("", '', window.location.href.split('&confirm_eb_process=')[0]);
}

if ( jQuery('#eb_core_update_all_done').length > 0 ) {
	window.scroll( 0, jQuery(document).height() );
	console.log('All done');
}

</script> 
