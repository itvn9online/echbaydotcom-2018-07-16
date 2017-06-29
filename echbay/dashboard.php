<br>
<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Trang tổng quan</a></div>
<br>
<?php

//
global $wpdb;
//	global $func;

//
$str_eb_warning = '';


// Nên bật WP_DEBUG = true
if ( ! defined('WP_DEBUG') || WP_DEBUG == true ) {
	$str_eb_warning .= '
	<div><i class="fa fa-warning orgcolor"></i> CẢNH BÁO: Nên tắt tính năng kiểm thử lỗi trên wordpress khi chạy chính thức, chỉ bật nó lên khi làm việc trên localhost hoặc cần kiểm tra lỗi khi website đã chạy chính thức. Khuyên dùng:
		<pre><code>define( \'WP_DEBUG\', false );</code></pre>
	</div>';
}


// Nên tắt WP_AUTO_UPDATE_CORE = true
/*
if ( ! defined('WP_AUTO_UPDATE_CORE') || WP_AUTO_UPDATE_CORE != false ) {
	$str_eb_warning .= '
	<div><i class="fa fa-warning orgcolor"></i> CẢNH BÁO: Không nên sử dụng tính năng tự động update của wordpress. Trong mọi trường hợp, nên update thủ công và backup dữ liệu trước khi update để tránh sự cố đáng tiếc nếu có. Khuyên dùng:
		<pre><code>define( \'WP_AUTO_UPDATE_CORE\', false );</code></pre>
	</div>';
}
*/


// cảnh báo người dùng 1 số tính năng nên bật
if ( ! defined('WP_SITEURL') ) {
	$str_eb_warning .= '
	<div><i class="fa fa-warning orgcolor"></i> CẢNH BÁO: nên sử dụng thiết lập tĩnh cho URL website bằng cách bổ sung lệnh khai báo trong file <strong>wp-config.php</strong>. Khuyên dùng:
		<pre><code>define( \'WP_SITEURL\', \'http://\' . $_SERVER[\'HTTP_HOST\'] );</code></pre>
	</div>';
}


// cảnh báo người dùng 1 số tính năng nên bật
if ( ! defined('WP_HOME') ) {
	$str_eb_warning .= '
	<div><i class="fa fa-warning orgcolor"></i> CẢNH BÁO: Nên sử dụng thiết lập tĩnh cho URL website bằng cách bổ sung lệnh khai báo trong file <strong>wp-config.php</strong>. Khuyên dùng:
		<pre><code>define( \'WP_HOME\', \'http://\' . $_SERVER[\'HTTP_HOST\'] );</code></pre>
	</div>';
}




// kiểm tra tình trạng index của website
/*
$sql = _eb_q("SELECT option_value
	FROM
		`" . $wpdb->options . "`
	WHERE
		option_name = 'blog_public'
	ORDER BY
		option_id DESC
	LIMIT 0, 1");
//print_r($sql);

if ( isset( $sql[0]->option_value ) && $sql[0]->option_value == 0 ) {
	*/
if ( get_option( 'blog_public' ) == 0 ) {
	$str_eb_warning .= '
	<div class="redcolor"><i class="fa fa-warning redcolor"></i> CẢNH BÁO: Thiết lập website của bạn đang chặn không cho các công cụ tìm kiếm index website này. Nếu bạn muốn thay đổi ý định này, <a href="' . web_link . WP_ADMIN_DIR . '/options-reading.php" target="_blank" class="bluecolor"><u>có thể thay đổi tại đây</u></a>.</div>';
}




// kiểm tra quyền đọc ghi qua FTP
//	if ( defined('FTP_USER') && defined('FTP_PASS') && defined('FTP_HOST') ) {
if ( defined('FTP_USER') && defined('FTP_PASS') ) {
	$str_eb_warning .= '
	<div class="orgcolor"><i class="fa fa-warning redcolor"></i> NGUY HIỂM: Bạn đang cho phép website được update hoặc ghi file thông qua tài khoản FTP. Điều này làm giảm khả năng bảo mật của website khi bị dính mã độc hại. Chúng tôi khuyên bạn <strong>HÃY NHẬP THỦ CÔNG NẾU CÓ THỂ</strong>.</div>';
}
else {
	$str_eb_warning .= '
	<div class="graycolor"><i class="fa fa-lightbulb-o orgcolor"></i> LƯU Ý: trong một số trường hợp, bạn không thể update được wordpress cho permission của hosting không cho phép, hãy nhập cấu hình qua tài khoản FTP trog file wp-config.php theo mẫu sau:
		<pre><code>define( \'FTP_HOST\', $_SERVER[\'SERVER_ADDR\'] );</code></pre>
		<pre><code>define( \'FTP_USER\', \'\' );</code></pre>
		<pre><code>define( \'FTP_PASS\', \'\' );</code></pre>
	</div>';
}




// kiểm tra quyền đọc ghi trực tiếp trên php
$file_test = ABSPATH . 'test_local_attack.txt';
$file_cache_test = EB_THEME_CACHE . 'test_local_attack.txt';

//
$lats_update_file_test = 0;
if ( file_exists( $file_cache_test ) ) {
	$lats_update_file_test = file_get_contents( $file_cache_test, 1 );
}

//
if ( date_time - $lats_update_file_test > 3600 ) {
	
	// tạo file cache để quá trình này không diễn ra liên tục
	_eb_create_file( $file_cache_test, date_time );
	
	
	
	// xóa file test trước đó nếu có
	if ( file_exists( $file_test ) ) {
		unlink( $file_test );
	}
	
	// tạo file ở root
	_eb_create_file( $file_test, date_time, '', 0 );
	
}

//
if ( file_exists( $file_test ) ) {
	$str_eb_warning .= '
	<div class="redcolor"><i class="fa fa-warning redcolor"></i> CẢNH BÁO: Hệ thống có thể tạo vào ghi nội dung file bất kỳ vào website, điều này không an toàn cho web khi bị dính mã độc.</div>';
}






//
$dir_robots_txt = ABSPATH . 'robots.txt';
if ( ! file_exists( $dir_robots_txt ) ) {
	$str_eb_warning .= '
	<div class="redcolor"><i class="fa fa-warning redcolor"></i> CẢNH BÁO: Bạn chưa tạo file robots.txt cho website, hãy <a href="' . web_link . WP_ADMIN_DIR . '/admin.php?page=eb-coder&tab=robots" target="_blank"><u>nhấn vào đây</u></a> để tạo.</div>';
}







// kiểm tra quyền đọc ghi qua FTP
if ( ( defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT == true )
|| ( defined('DISALLOW_FILE_MODS') && DISALLOW_FILE_MODS == true ) ) {
	$str_eb_warning .= '
	<div class="graycolor"><i class="fa fa-lightbulb-o orgcolor"></i> THÔNG BÁO: Bạn đang sử dụng phiên bản miễn phí, ở phiên bản này bạn sẽ bị giới hạn một số tính năng, để mở các chức năng này, vui lòng liên hệ kỹ thuật đã cài đặt website cho bạn hoặc bổ sung đoạn mã sau (chỉ bổ sung đoạn nào chưa có) vào trong file wp-config.php của bạn:
		<pre><code>define( \'DISALLOW_FILE_EDIT\', false );</code></pre>
		<pre><code>define( \'DISALLOW_FILE_MODS\', false );</code></pre>
	</div>';
}







// kiểm tra quyền đọc ghi qua FTP
if ( ( defined('WP_AUTO_UPDATE_CORE') && WP_AUTO_UPDATE_CORE == true ) ) {
	$str_eb_warning .= '
	<div><i class="fa fa-lightbulb-o orgcolor"></i> THÔNG BÁO: Tính năng tự động cập nhật đang được BẬT, điều này chỉ nên áp dụng cho các website không quan trọng (site vệ tinh). Với các site chính, ưu tiên việc update thủ công để còn kiểm tra lỗi sau mỗi lần update. Thay đổi điều này bằng cách đặt lệnh sau vào file wp-config.php hoặc bật tắt trong phần <a href="' . web_link . WP_ADMIN_DIR . '/admin.php?page=eb-config&tab=permalinks" target="_blank">Cấu hình website</a>:
		<pre><code>define( \'WP_AUTO_UPDATE_CORE\', false );</code></pre>
	</div>';
} else {
	$str_eb_warning .= '
	<div><i class="fa fa-lightbulb-o orgcolor"></i> THÔNG BÁO: Tính năng tự động cập nhật đang bị TẮT, nếu đây là site vệ tinh hoặc bạn không có nhiều thời gian chăm sóc cho nó, chúng tôi khuyên bạn hãy bật nó lên. Thay đổi điều này bằng cách đặt lệnh sau vào file wp-config.php hoặc bật tắt trong phần <a href="' . web_link . WP_ADMIN_DIR . '/admin.php?page=eb-config&tab=permalinks" target="_blank">Cấu hình website</a>:
		<pre><code>define( \'WP_AUTO_UPDATE_CORE\', true );</code></pre>
	</div>';
}





//
if ( $str_eb_warning != '' ) {
	echo '<div class="eb-warning-site-config">' . $str_eb_warning . ' <p>* Các lưu ý này sẽ được thiết lập trong file: <strong>wp-config.php</strong> của wordpress.</p></div><br>';
}
/*
else {
	echo '<p><em>Thật tuyệt vời, không có bất kỳ cảnh báo nào nguy hại đến website của bạn được phát hiện.</em></p>';
}
*/






