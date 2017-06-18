<h1 class="l35">* Lưu ý: tính năng chỉ dành cho các website sử dụng hosting cung cấp bởi EchBay.com</h1>
<?php


//
//if ( mtv_id == 1 ) {
if ( current_user_can('manage_options') )  {
	if ( isset( $_GET['confirm_process'] ) ) {
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
		echo '<h2><a href="#" class="click-connect-to-echbay-update-wp-core">Bấm vào đây để cập nhật lại core cho wordpress!</a></h2>';
	}
}
else {
	echo 'Supper admin only access!';
}



?>
<script type="text/javascript">
jQuery('.click-connect-to-echbay-update-wp-core').attr({
	href : window.location.href.split('&confirm_process=')[0] + '&confirm_process=1'
});
</script>
