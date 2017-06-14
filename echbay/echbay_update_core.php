aaaaaaaa
<?php


//
if ( mtv_id == 1 ) {
	if ( isset( $_GET['confirm_process'] ) ) {
		$file_cache_test = EB_THEME_CACHE . 'eb_update_core.txt';
		
		//
		$lats_update_file_test = 0;
		if ( file_exists( $file_cache_test ) ) {
			$lats_update_file_test = file_get_contents( $file_cache_test, 1 );
		}
		
		//
		if ( date_time - $lats_update_file_test > 60 ) {
			
			// tạo file cache để quá trình này không diễn ra liên tục
			_eb_create_file( $file_cache_test, date_time );
			
			// nơi lưu file zip
			$destination_path = EB_THEME_CACHE . '/echbaydotcom.zip';
			
			// download từ github
			copy( 'https://github.com/itvn9online/echbaydotcom/archive/master.zip', $destination_path );
			
			// Giải nén file
			if ( file_exists( $destination_path ) ) {
				$unzipfile = unzip_file( $destination_path, EB_THEME_PLUGIN_INDEX );
				if ( $unzipfile ) {
					echo 'Cập nhật EchBay core thành công!';       
				} else {
					echo 'Không giải nén được tệp tin, cập nhật thất bại!';       
				}
			}
			else {
				echo '<h3>Không tồn tại file zip để giải nén!</h3>';
			}
		}
		else {
			echo '<h3>Giãn cách mỗi lần update core tối thiểu là 5 phút</h3>';
		}
	}
	else {
		echo '<h2><a href="#" class="click-connect-to-echbay-update-wp-core">Bấm vào đây để cập nhật lại core cho EchBay!</a></h2>';
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
