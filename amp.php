<?php



/*
* Kiểm tra chuẩn AMP
*/
// https://search.google.com/search-console/amp
// hoặc thêm #development=1 vào sau URL






//
include EB_THEME_PLUGIN_INDEX . 'amp/class.php';







/*
* amp không có phần đăng nhập -> cache toàn trang
*/

// định thời gian cache mặc định là 2 phút
$__cf_row['cf_reset_cache'] = 120;




//
/*
$strCacheFilter = 'details/' . $pid . '-amp';
$main_content = _eb_get_static_html ( $strCacheFilter );
if ($main_content == false) {
	*/



// dùng ob để lấy nội dung đã được echo thay vì echo trực tiếp
ob_start();



//
$amp_str_go_to = '';
$amp_content = '';

// 1 số cdn, nếu không dùng đến thì google nó cũng báo không chuẩn -> dcm, lắm chuyện vc
$other_amp_cdn = array();

//
if ( ! isset( $_GET['amp_act'] ) ) {
	$_GET['amp_act'] = 'details';
}

//
include EB_THEME_PLUGIN_INDEX . 'amp/' . $_GET['amp_act'] . '.php';



?>
<!doctype html>
<html amp lang="<?php echo $__cf_row['cf_content_language']; ?>">
<?php
include EB_THEME_PLUGIN_INDEX . 'amp/header.php';
?>
<body>
<?php
include EB_THEME_PLUGIN_INDEX . 'amp/top.php';
?>
<article class="amp-wp-article"><?php echo $amp_content; ?></article>
<?php
include EB_THEME_PLUGIN_INDEX . 'amp/footer.php';
?>
</body>
</html>
<?php



//
$main_content = ob_get_contents();

//ob_clean();
//ob_end_flush();
ob_end_clean();




//
$main_content = $eb_amp->del_line ( $main_content );



//
$main_content .= '<!-- Phiên bản AMP cho website, viết bởi EchBay.com -->';





// file xử lý dữ liệu AMP riêng cho từng site (nếu có)
$private_amp_file = EB_THEME_PHP . 'amp.php';
if ( file_exists( $private_amp_file ) ) {
	include $private_amp_file;
}


//
if ( $__cf_row['cf_old_domain'] != '' ) {
//	$main_content = str_replace( '/' . $__cf_row['cf_old_domain'] . '/', '/' . $_SERVER['HTTP_HOST'] . '/', $main_content );
	$main_content = WGR_sync_old_url_in_content( $__cf_row['cf_old_domain'], $main_content );
}




//
/*
_eb_get_static_html ( $strCacheFilter, $main_content );


}
*/


//
echo $main_content;



// ở bản amp -> kết thúc ở đây thì cũng lưu cache lại
if ( $enable_echbay_super_cache == 1 ) {
	___eb_cache_end_ob_cache ( $strEBPageDynamicCache );
}



exit();


