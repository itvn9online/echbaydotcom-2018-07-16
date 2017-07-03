<?php



//
//$arr_for_update_eb_config = array();



//
//_eb_alert( $wpdb->postmeta );
//_eb_alert( $wpdb->options );

if ( ! isset( $_POST['cf_using_top_default'] ) || (int) $_POST['cf_using_top_default'] != 1 ) {
	$_POST['cf_using_top_default'] = 0;
}

if ( ! isset( $_POST['cf_using_footer_default'] ) || (int) $_POST['cf_using_footer_default'] != 1 ) {
	$_POST['cf_using_footer_default'] = 0;
}



// chạy vòng lặp rồi in các dữ liệu vào bảng lưu
foreach( $_POST as $k => $v ) {
//	echo $k . '<br>';
	
	// hải có chữ cf_ ở đầu tiền
	if ( substr( $k, 0, 3 ) == 'cf_' ) {
//		echo 'insert<br>';
//		echo $v . '<br>';
		
		//
		_eb_set_config( $k, $v );
		
//		$arr_for_update_eb_config[ $k ] = addslashes( stripslashes ( stripslashes ( stripslashes ( $v ) ) ) );
		
		//
//		$v = sanitize_text_field( $v );
//		$arr_for_update_eb_config[ $k ] = $v;
	}
}




//
_eb_log_admin( 'Update config theme' );



//
_eb_alert('Cập nhật Giao diện website thành công');




