<hr>
<div class="l19">* Trong trường hợp website của bạn đang sử dụng hosting cung cấp bởi <a href="https://www.echbay.com/cart" target="_blank" rel="next">EchBay.com</a>, bạn có thể sử dụng chức năng cập nhật mã nguồn cho WordPress tại đây. Chức năng cập nhật được tối ưu theo hệ thống server nên sẽ ổn định hơn so với cập nhật qua module sẵn có của WordPress.</div>
<br>
<?php


//
//if ( mtv_id == 1 ) {
//if ( current_user_can('manage_options') )  {
	if ( isset( $_GET['confirm_wp_process'] ) ) {
		$file_cache_test = EB_THEME_CACHE . 'wp_update_core.txt';
		
		//
		$lats_update_file_test = 0;
		if ( file_exists( $file_cache_test ) ) {
			$lats_update_file_test = file_get_contents( $file_cache_test, 1 );
		}
		
		//
		if ( date_time - $lats_update_file_test > 6 * 3600 ) {
			
			// tạo file cache để quá trình này không diễn ra liên tục
			_eb_create_file( $file_cache_test, date_time );
			
			//
			echo _eb_postUrlContent( 'https://www.echbay.com/actions/wordpress_core_update&domain=' . $_SERVER['HTTP_HOST'] );
		}
		else {
			echo '<h3>Giãn cách mỗi lần update core tối thiểu là 6 tiếng</h3>';
		}
	}
	else {
		echo '<h2><center><a href="#" class="click-connect-to-echbay-update-wp-core">[ Bấm vào đây để cập nhật lại core cho WordPress! ]</a></center></h2>';
	}
	/*
}
else {
	echo 'Supper admin only access!';
}
*/



?>
<script type="text/javascript">
jQuery('.click-connect-to-echbay-update-wp-core').attr({
	href : window.location.href.split('&confirm_wp_process=')[0] + '&confirm_wp_process=1'
});

//
if ( window.location.href.split('&confirm_wp_process=').length > 1 ) {
	_global_js_eb.change_url_tab( 'confirm_wp_process' );
//	window.history.pushState("", '', window.location.href.split('&confirm_wp_process=')[0]);
}
</script>
