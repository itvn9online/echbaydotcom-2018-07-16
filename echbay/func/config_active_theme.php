<?php



//
//print_r( $_POST );

$create_theme_key = trim( $_POST['create_theme_key'] );

$file_for_active = EB_THEME_PLUGIN_INDEX . 'themes/all/' . $create_theme_key . '.php';
if ( ! file_exists( $file_for_active ) ) {
	_eb_alert('Không tồn tại giao diện tương ứng');
}



//
include $file_for_active;
//print_r( $eb_all_themes_support );

//
if ( empty( $eb_all_themes_support[ $create_theme_key ] ) ) {
	_eb_alert('Không không xác định được danh sách tệp giao diện');
}
$arr_new_theme= $eb_all_themes_support[ $create_theme_key ];







// Chạy vòng lặp để xóa toàn bộ cấu hình theme đang sử dụng đi
for ( $i = 1; $i <= 10; $i++ ) {
	
	$top = 'cf_top' . $i . '_include_file';
	if ( isset( $__cf_row_default[ $top ] ) ) {
		_eb_set_config( $top, '' );
	}
	
	$footer = 'cf_footer' . $i . '_include_file';
	if ( isset( $__cf_row_default[ $footer ] ) ) {
		_eb_set_config( $footer, '' );
	}
	
}

//
_eb_set_config( 'cf_threaddetails_include_file', '' );
_eb_set_config( 'cf_threadnode_include_file', '' );
//_eb_set_config( 'cf_threadsearchnode_include_file', '' );







// chạy vòng lặp rồi in các dữ liệu vào bảng lưu
foreach( $arr_new_theme as $k => $v ) {
//	echo $k . '<br>';
	
	// hải có chữ cf_ ở đầu tiền
//	if ( substr( $k, 0, 3 ) == 'cf_' ) {
	if ( substr( $k, 0, 3 ) == 'cf_' && $v != '' && isset( $__cf_row_default[ $k ] ) ) {
		
		_eb_set_config( $k, $v );
		
	}
}





// cập nhật tên giao diện mới
_eb_set_config( 'cf_current_theme_using', $create_theme_key );







//
die('<script type="text/javascript">
//alert("Cài đặt giao diện mới thành công");
parent.window.location = parent.window.location.href;
</script>');




