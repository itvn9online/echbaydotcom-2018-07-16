<?php


//
$str_robots_txt = trim( 'User-agent: *
Disallow: /cgi-bin/
Disallow: /' . WP_ADMIN_DIR . '/
Disallow: /wp-includes/
Disallow: /wp-content/plugins/
Disallow: /wp-content/cache/
Disallow: /wp-content/themes/
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
		$ftp_server = $_SERVER['HTTP_HOST'];
	}
	if ( defined('FTP_USER') ) {
		$ftp_user_name = FTP_USER;
	}
	if ( defined('FTP_PASS') ) {
		$ftp_user_pass = FTP_PASS;
	}
	
	//
	if ( $ftp_server != '' && $ftp_user_name != '' && $ftp_user_pass != '' ) {
		
		// tạo kết nối
		$conn_id = ftp_connect($ftp_server);
		
		
		// đăng nhập
		ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		
		// upload file
//		ftp_put($conn_id, $dir_robots_txt, $cache_robots_txt, FTP_ASCII);
		ftp_put($conn_id, './robots.txt', './' . strstr( $cache_robots_txt, 'wp-content/' ), FTP_ASCII);
//		echo './' . strstr( $cache_robots_txt, 'wp-content/' ) . '<br>' . "\n";
		
		
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
	<p class="bold">Nội dung file robots.txt hiện tại:</p>
	<div>
		<textarea style="width:90%;max-width:800px;height:300px;"><?php echo $robots_txt_content; ?></textarea>
	</div>
	<br>
	<p class="bold">Nội dung file robots.txt mẫu (của coder đưa ra):</p>
	<div>
		<textarea style="width:90%;max-width:800px;height:300px;" disabled><?php echo $str_robots_txt; ?></textarea>
	</div>
	<br>
</div>
