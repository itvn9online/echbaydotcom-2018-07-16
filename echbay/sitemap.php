<?php



if ( file_exists(EB_THEME_CACHE . 'sitemap.txt') ) {
	$get_sitemap_last_update = filemtime( EB_THEME_CACHE . 'sitemap.txt' );
} else {
	$get_sitemap_last_update = 0;
}



?>

<div class="l25 medium18">Sitemap được tự động khởi tạo và làm mới khoảng tiếng một lần. Các dữ liệu được cho vào sitemap bao gồm: các phân nhóm sản phẩm, phân nhóm bài viết, sản phẩm và bài viết. Dưới đây là một số thông tin về sitemap tự động này:<br>
	- URL sitemap: <a href="<?php echo web_link; ?>sitemap" target="_blank"><?php echo web_link; ?>sitemap</a> (<em>dùng để cho vào google webmaster hoặc các webmaster tool khác</em>).<br>
	- Thời gian cập nhật trước: <?php echo date( 'r', $get_sitemap_last_update ); ?>.</div>
<p class="l25 medium">* Xin lưu ý: sitemap này được khởi tạo riêng theo quy chuẩn kỹ thuật của người viết code, do plugin này được tổng hợp và phát triển dựa theo sự tổng hợp về vấn đề kỹ thuật cũng như nhu cầu của số đông khách hàng, vì thế, trong trường hợp bạn có nhu cầu sử dụng sitemap với một cấu trúc khác, theo nhu cầu riêng, vui lòng tìm kiếm các plugin khác chuyên dùng để dựng sitemap và sử dụng.</p>
