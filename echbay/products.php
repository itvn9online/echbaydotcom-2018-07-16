<?php



global $wpdb;



//
$threadInPage = _eb_getCucki('quick_edit_per_page');
if ( $threadInPage == '' ) {
	$threadInPage = 68;
}
$totalThread = 0;
$totalPage = 0;
$strLinkPager = admin_link . 'admin.php?page=eb-products';

$status_by = '';
$strLinkAjaxl = '';
$by_post_type = isset( $_GET['by_post_type'] ) ? trim( $_GET['by_post_type'] ) : 'post';
$by_taxonomy = isset( $_GET['by_taxonomy'] ) ? trim( $_GET['by_taxonomy'] ) : 'category';


//
$trang = isset( $_GET['trang'] ) ? (int)$_GET['trang'] : 1;
//echo $trang . '<br>' . "\n";




//
$arr_for_show_post_type = array(
	'post' => 'Sản phẩm',
	'blog' => 'Blog/ Tin tức',
	'ads' => 'Banner Quảng cáo',
);

$arr_for_show_taxonomy = array(
	'category' => 'Danh mục sản phẩm',
	'post_tag' => 'Thẻ bài viết',
	'post_options' => 'Thông số sản phẩm',
	'blogs' => 'Danh mục Blog/ Tin tức',
);





?>

<div class="wrap">
	<h1>Danh sách
		<?php
	
	if ( ! empty( $arr_for_show_post_type[$by_post_type] ) ) {
		echo $arr_for_show_post_type[$by_post_type];
	}
	else if ( ! empty( $arr_for_show_taxonomy[$by_taxonomy] ) ) {
		echo $arr_for_show_taxonomy[$by_taxonomy];
	} else {
		echo '<strong>Post_type not found</strong>';
	}
	
	?>
		(Trang <?php echo number_format( $trang ); ?>)</h1>
	<div>Theo định dạng:
		<?php
	
	foreach ( $arr_for_show_post_type as $k => $v ) {
		echo '<a data-type="' . $k . '" href="#" class="set-url-post-post-type">' . $v . '</a> | ';
	}
	
	foreach ( $arr_for_show_taxonomy as $k => $v ) {
		echo '<a data-type="' . $k . '" href="#" class="set-url-taxonomy-category">' . $v . '</a> | ';
	}
	
	// Lệnh tìm các bài trùng post_name
	echo '<a href="' . admin_link . 'admin.php?page=eb-products&check_post_name=2" class="check-post-name">Kiểm tra trùng lặp</a> | ';
	
	?>
	</div>
</div>
<script type="text/jscript">

var waiting_for_ajax_running = false,
	threadInPage = '<?php echo $threadInPage; ?>',
	strLinkPager = '<?php echo $strLinkPager; ?>',
	by_post_type = '<?php echo $by_post_type; ?>',
	by_taxonomy = '<?php echo $by_taxonomy; ?>',
	js_for_tax_or_post = '<?php echo isset( $_GET['by_taxonomy'] ) ? $by_taxonomy : $by_post_type; ?>';

</script> 
<br>
<?php



//
echo '<script type="text/javascript" src="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/javascript/products.js?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'javascript/products.js' ) . '"></script>' . "\n";





//
if ( isset( $_GET['by_taxonomy'] ) ) {
	include ECHBAY_PRI_CODE . 'products_taxonomy.php';
}
else if ( isset( $_GET['check_post_name'] ) ) {
	include ECHBAY_PRI_CODE . 'products_check_post_name.php';
}
else {
	include ECHBAY_PRI_CODE . 'products_post.php';
}

?>
<br>
<div class="admin-part-page">
	<?php
if ($totalPage > 1) {
	echo EBE_part_page ( $trang, $totalPage, $strLinkPager . '&trang=' );
}
?>
</div>
<p>* Số thứ tự (STT) càng lớn thì độ ưu tiên càng cao, sản phẩm sẽ được sắp xếp theo STT từ cao đến thấp.</p>
<br>
