<br>
<div style="padding-right:10%;text-align:justify;">
	<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Về tác giả</a></div>
	<p>Giao diện được phát triển bởi <a href="http://facebook.com/ech.bay" target="_blank" rel="nofollow">Đào Quốc Đại</a>, trên nền tảng mã nguồn mở <a href="http://wordpress.org/" target="_blank" rel="nofollow">WordPress</a> và sử dụng ngôn ngữ lập trình <a href="http://php.net/" target="_blank" rel="nofollow">PHP</a>, và một số thư viện mã nguồn mở khác như <a href="http://jquery.com/" target="_blank" rel="nofollow">jQuery</a>, <a href="http://fontawesome.io/" target="_blank" rel="nofollow">Font Awesome</a>. Mọi thông tin quý vị có thể xem thêm tại website <a href="http://echbay.com/" target="_blank" rel="nofollow">echbay.com</a>.<br>
		<br>
		Để tối ưu hiệu suất của mã nguồn <a href="http://wordpress.org/" target="_blank" rel="nofollow">WordPress</a> nói chung, và giao diện được viết bởi <a href="http://echbay.com/" target="_blank" rel="nofollow">Ếch Bay</a> nói riêng, chúng tôi khuyến khích bạn sử dụng hosting trên hệ điều hành <a href="http://linux.com/" target="_blank" rel="nofollow"><i class="fa fa-linux"></i> Linux (CentOS)</a>, hệ thống quản trị cơ sở dữ liệu <a href="http://mariadb.com/" target="_blank" rel="nofollow">MariaDB</a> thay vì <a href="http://mysql.com/" target="_blank" rel="nofollow">MySQL</a>, webserver <a href="http://nginx.org/" target="_blank" rel="nofollow">Nginx</a> thay cho <a href="http://apache.org/" target="_blank" rel="nofollow">Apache</a>, ổ cứng chứa dữ liệu dạng SSD để cho tốc độ đọc ghi dữ liệu từ bộ nhớ đệm tốt hơn.<br>
		<br>
		Việc sử dụng code là hoàn toàn miễn phí, bạn chỉ mất phí trong trường hợp cần tác giả hỗ trợ trực tiếp để thay đổi website theo yêu cầu. Khi đó, chúng tôi sẽ tính phí theo số giờ làm việc, mức phí có thể sẽ thay đổi vào từng thời điểm, chúng tôi sẽ báo giá cụ thể trước khi làm.</p>
	<br>
	<?php
include ECHBAY_PRI_CODE . 'role_user.php';


if ( current_user_can('manage_options') )  {
	include ECHBAY_PRI_CODE . 'echbay_update_core.php';
	include ECHBAY_PRI_CODE . 'wordpress_update_core.php';
}



?>
	<br>
	<hr>
	<p align="right">Cảm ơn vì đã chọn chúng tôi. Chúc thành công và trân trọng hợp tác.</p>
</div>
<br>
<br>
