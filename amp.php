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





//
$main_content = str_replace( 'https://www.xwatch.vn/home/pictures/', web_link . 'Home/Pictures/', $main_content );
$main_content = str_replace( 'http://xwatch.echbay.com/wp-content/uploads/', web_link . 'wp-content/uploads/', $main_content );
$main_content = str_replace( 'xwatch.echbay.com/', 'xwatch.vn/', $main_content );




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


