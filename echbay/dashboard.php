<br>
<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Trang tổng quan</a></div>
<p>* Các cài đặt được chúng tôi khuyên dùng sẽ được đưa ra tại đây, bao gồm: các cài đặt liên quan đến bảo mật website, tối ưu tốc độ web... Và các cài đặt này thường đường thay đổi trong file wp-config.php hoặc <a href="<?php echo admin_link; ?> 'admin.php?page=eb-config&tab=permalinks" target="_blank">thay đổi tại đây</a>.</p>
<?php

//
global $wpdb;
//	global $func;

//
$str_eb_warning = '';


// Nên bật WP_DEBUG = true
//if ( ! defined('WP_DEBUG') || WP_DEBUG == true ) {
if ( $__cf_row['cf_tester_mode'] == 1 ) {
	$str_eb_warning .= '
	<div><i class="fa fa-warning orgcolor"></i> CẢNH BÁO: Nên tắt tính năng kiểm thử lỗi trên wordpress khi chạy chính thức, chỉ bật nó lên khi làm việc trên localhost hoặc cần kiểm tra lỗi khi website đã chạy chính thức. Khuyên dùng:
		<pre class="d-none"><code>define( \'WP_DEBUG\', false );</code></pre>
		<div>Bạn có thể <a href="' . admin_link . 'admin.php?page=eb-config&tab=meta-home&support_tab=cf_tester_mode" target="_blank" rel="nofollow">vào đây</a> để thay đổi trực tiếp cài đặt này.</div>
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
	<div class="redcolor"><i class="fa fa-warning redcolor"></i> CẢNH BÁO: Thiết lập website của bạn đang chặn không cho các công cụ tìm kiếm index website này. Nếu bạn muốn thay đổi ý định này, <a href="' . admin_link . 'options-reading.php" target="_blank" class="bluecolor"><u>có thể thay đổi tại đây</u></a>.</div>';
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
$last_update_file_test = 0;
if ( file_exists( $file_cache_test ) ) {
	$last_update_file_test = file_get_contents( $file_cache_test, 1 );
}

//
if ( date_time - $last_update_file_test > 3600 ) {
	
	// tạo file cache để quá trình này không diễn ra liên tục
	_eb_create_file( $file_cache_test, date_time );
	
	
	
	// xóa file test trước đó nếu có
	if ( file_exists( $file_test ) ) {
		_eb_remove_file( $file_test );
//		unlink( $file_test );
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

// nếu file không tồn tại -> cảnh báo
if ( ! file_exists( $dir_robots_txt ) ) {
	$str_eb_warning .= '
	<div class="redcolor"><i class="fa fa-warning redcolor"></i> CẢNH BÁO: Bạn chưa tạo file robots.txt cho website, hãy <a href="' . admin_link . 'admin.php?page=eb-coder&tab=robots" target="_blank"><u>nhấn vào đây</u></a> để tạo.</div>';
}
// nếu có nhưng link sitemap bị sai -> cảnh báo luôn
else if ( strstr( file_get_contents( $dir_robots_txt, 1 ), web_link . 'sitemap' ) == false ) {
	$str_eb_warning .= '
	<div class="orgcolor"><i class="fa fa-warning redcolor"></i> CẢNH BÁO: file robots.txt đã được tạo, nhưng nội dung file đang thiếu hoặc bị sai tham số khá quan trọng là chỉ định sitemap chính xác của website, hãy <a href="' . admin_link . 'admin.php?page=eb-coder&tab=robots" target="_blank"><u>nhấn vào đây</u></a> để xem và cập nhật lại.</div>';
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
	<div class="greencolor"><i class="fa fa-lightbulb-o orgcolor"></i> THÔNG BÁO: Tính năng tự động cập nhật đang được BẬT, điều này chỉ nên áp dụng cho các website không quan trọng (site vệ tinh). Với các site chính, ưu tiên việc update thủ công để còn kiểm tra lỗi sau mỗi lần update. Thay đổi điều này bằng cách đặt lệnh sau vào file wp-config.php hoặc bật tắt trong phần <a href="' . admin_link . 'admin.php?page=eb-config&tab=permalinks&support_tab=cf_on_off_auto_update_wp" target="_blank">Cấu hình website</a>:
		<pre><code>define( \'WP_AUTO_UPDATE_CORE\', false );</code></pre>
	</div>';
} else {
	$str_eb_warning .= '
	<div><i class="fa fa-lightbulb-o orgcolor"></i> THÔNG BÁO: Tính năng tự động cập nhật đang bị TẮT, nếu đây là site vệ tinh hoặc bạn không có nhiều thời gian chăm sóc cho nó, chúng tôi khuyên bạn hãy bật nó lên. Thay đổi điều này bằng cách đặt lệnh sau vào file wp-config.php hoặc bật tắt trong phần <a href="' . admin_link . 'admin.php?page=eb-config&tab=permalinks&support_tab=cf_on_off_auto_update_wp" target="_blank">Cấu hình website</a>:
		<pre><code>define( \'WP_AUTO_UPDATE_CORE\', true );</code></pre>
	</div>';
}







//
/*
if ( webgiare_dot_org_install == true ) {
	$str_eb_warning .= '
	<div><i class="fa fa-lightbulb-o orgcolor"></i> THÔNG BÁO: Tính năng bảo mật cho tài khoản admin đang được bật, tính năng này sẽ ẩn đi một số menu đặc biệt quan trọng trên website, để tắt nó đi, hãy thêm đoạn code sau vào file wp-config.php:
		<pre><code>define( \'webgiare_dot_org_install\', false );</code></pre>
	</div>';
}
*/






// chặn file xmlrpc.php, không cho thực thi trên file này
WGR_deny_or_accept_vist_php_file( ABSPATH . 'xmlrpc.php', $__cf_row['cf_on_off_xmlrpc'], 'XML-RPC' );
if ( $__cf_row['cf_on_off_xmlrpc'] == 1 ) {
	$str_eb_warning .= '
	<div class="orgcolor"><i class="fa fa-warning"></i> CẢNH BÁO: chức năng <strong>Chia sẻ dữ liệu qua XML-RPC</strong> đang được bật, điều này có thể gây tốn tài nguyên không cần thiết cho website của bạn. Nếu bạn không sử dụng nó hoặc không biết XML-RPC là gì thì hãy tắt nó đi <a href="' . admin_link . 'admin.php?page=eb-config&tab=permalinks&support_tab=cf_on_off_xmlrpc" target="_blank">tại đây</a>.</div>';
}

// chặn file wp-cron.php, không cho thực thi trên file này
WGR_deny_or_accept_vist_php_file( ABSPATH . 'wp-cron.php', $__cf_row['cf_on_off_wpcron'], 'WP Cron' );
if ( $__cf_row['cf_on_off_wpcron'] == 1 ) {
	$str_eb_warning .= '
	<div class="orgcolor"><i class="fa fa-warning"></i> CẢNH BÁO: chức năng <strong>Cron Job</strong> của wordpress đang được bật, điều này có thể gây tốn tài nguyên không cần thiết cho website của bạn. Nếu bạn không sử dụng nó hoặc không biết đây là tính năng gì thì hãy tắt nó đi <a href="' . admin_link . 'admin.php?page=eb-config&tab=permalinks&support_tab=cf_on_off_wpcron" target="_blank">tại đây</a>.</div>';
}




// nếu EchBay SEO không được bật -> sẽ kiểm tra các Plugin khác
if ( cf_on_off_echbay_seo != 1 ) {
	$str_eb_warning .= '
	<div class="orgcolor"><i class="fa fa-warning"></i> CẢNH BÁO: chức năng <a href="' . admin_link . 'admin.php?page=eb-config&tab=permalinks&support_tab=cf_on_off_echbay_seo" target="_blank"><strong>EchBay SEO plugin</strong></a> đang bị tắt. Một website thì không thể thiếu SEO, hãy đảm bảo bạn đã có plugin SEO khác để thay thế. Ví dụ: <a href="https://vi.wordpress.org/plugins/wordpress-seo/" target="_blank" rel="nofollow">Yoast SEO</a>, <a href="https://vi.wordpress.org/plugins/all-in-one-seo-pack/" target="_blank" rel="nofollow">All in one seo</a>...</div>';
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



?>
<p class="greencolor medium"><i class="fa fa-lightbulb-o orgcolor"></i> Thường xuyên xem và cải thiện tốc độ cho website bằng công cụ <a href="https://developers.google.com/speed/pagespeed/insights/?url=<?php echo urlencode( web_link ); ?>&tab=mobile" target="_blank" rel="nofollow">PageSpeed Insights</a> của Google để tối ưu tốc độ tải trang cho website của bạn.</p>
<div class="text-center">
	<iframe width="569" height="320" src="https://www.youtube.com/embed/L45U7ChIMto" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
</div>
