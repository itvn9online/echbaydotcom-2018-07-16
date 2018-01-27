<?php


//
$str_robots_txt = trim( 'User-agent: *
Disallow: /cgi-bin/
Disallow: /' . WP_ADMIN_DIR . '/
Disallow: /wp-includes/
Disallow: /' . EB_DIR_CONTENT . '/plugins/
Disallow: /' . EB_DIR_CONTENT . '/themes/
Disallow: /' . EB_DIR_CONTENT . '/cache/
Disallow: /' . EB_DIR_CONTENT . '/uploads/ebcache/
Disallow: /search?q=*
Disallow: *?replytocom
Disallow: */attachment/*
Disallow: /images/

Allow: /*.js$
Allow: /*.css$
Sitemap: ' . web_link . 'sitemap' );




//
$dir_robots_txt = ABSPATH . 'robots.txt';
//echo $dir_robots_txt . '<br>' . "\n";


//
$robots_txt_content = '';
if ( file_exists( $dir_robots_txt ) ) {
	$robots_txt_content = file_get_contents( $dir_robots_txt, 1 );
}


// tạo file robots nếu chưa có
if ( ! file_exists( $dir_robots_txt ) || $robots_txt_content == '' ) {
	
	/*
	// ưu tiên tạo bằng FTP trước
	$cache_robots_txt = EB_THEME_CACHE . 'robots.txt';
//	echo $cache_robots_txt . '<br>' . "\n";
	
	_eb_create_file( $cache_robots_txt, $str_robots_txt );
//	exit();
	
	// tạo kết nối tới FTP
	$ftp_server = '';
	$ftp_user_name = '';
	$ftp_user_pass = '';
	
	//
	if ( defined('FTP_HOST') ) {
		$ftp_server = FTP_HOST;
	} else {
//		$ftp_server = $_SERVER['HTTP_HOST'];
		$ftp_server = $_SERVER['SERVER_ADDR'];
	}
	if ( defined('FTP_USER') ) {
		$ftp_user_name = FTP_USER;
	}
	if ( defined('FTP_PASS') ) {
		$ftp_user_pass = FTP_PASS;
	}
	
	//
	if ( $ftp_user_name != '' && $ftp_user_pass != '' ) {
		
		// tạo kết nối
		$conn_id = ftp_connect($ftp_server) or die('ERROR connect to server');
		
		
		// đăng nhập
		ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)or die('AutoBot login false');
		
		
		// lấy thư mục gốc
		$ftp_root_dir = explode( '/', $cache_robots_txt );
//		print_r( $ftp_root_dir );
		foreach ( $ftp_root_dir as $v ) {
//			echo $v . "\n";
			if ( $v != '' ) {
				$file_test = strstr( $cache_robots_txt, $v );
//				echo $file_test . " - \n";
				
				//
				if ( $file_test != '' ) {
					if ( ftp_nlist($conn_id, './' . $file_test) != false ) {
						$ftp_dir_root = $v;
						break;
					}
				}
			}
		}
//		echo $ftp_dir_root . '<br>' . "\n";
		
		
		// upload file
//		ftp_put($conn_id, $dir_robots_txt, $cache_robots_txt, FTP_ASCII);
		ftp_put($conn_id, './' . $ftp_dir_root . '/robots.txt', $cache_robots_txt, FTP_BINARY);
//		echo './' . strstr( $cache_robots_txt, EB_DIR_CONTENT . '/' ) . '<br>' . "\n";
		
		
		// close the connection
		ftp_close($conn_id);
		
	}
	// tạo theo cách thông thường
	else {
		*/
		_eb_create_file( $dir_robots_txt, $str_robots_txt );
//	}
	
}



?>

<div class="l25">
	<p class="bold">Nội dung file robots.txt hiện tại: <a href="<?php echo web_link; ?>robots.txt" target="_blank" rel="nofollow">Xem chi tiết</a></p>
	<div>
		<form name="frm_robots" method="post" action="<?php echo web_link; ?>process/?set_module=robots" target="target_eb_iframe">
			<textarea name="t_noidung" style="width:90%;max-width:800px;height:300px;"><?php echo $robots_txt_content; ?></textarea>
			<div>
				<input type="submit" value="Cập nhật" class="eb-admin-wp-submit" />
			</div>
		</form>
	</div>
	<br>
	<p class="bold">Nội dung file robots.txt mẫu (file khuyên dùng của coder đưa ra):</p>
	<div>
		<textarea style="width:90%;max-width:800px;height:300px;" disabled><?php echo $str_robots_txt; ?></textarea>
	</div>
	<br>
</div>
