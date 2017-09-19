<?php
/*
Description: Alias breadcrumb-top1 -> Breadcrumb cho website, sử dụng thiết kế tràn khung, tràn màn hình (không giới hạn chiều rộng) -> đổi chữ sang màu trắng, hợp với các nền có màu, bỏ background, viền.
Tags: breadcrumb
*/
?>

<div id="norcaljump-top4">
	<?php
	include EB_THEME_PLUGIN_INDEX . 'themes/top/breadcrumb-top1.php';
//	$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/breadcrumb-top1.css' ] = 0;
	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/breadcrumb-top1.css' ] = 0;
	?>
</div>
