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
$arr = $eb_all_themes_support[ $create_theme_key ];



//
for ( $i = 1; $i <= 10; $i++ ) {
	$k = 'cf_top' . $i . '_include_file';
	
	if ( isset( $__cf_row_default[ $k ] ) ) {
		_eb_set_config( $k, '' );
	}
}

for ( $i = 1; $i <= 10; $i++ ) {
	$k = 'cf_footer' . $i . '_include_file';
	
	if ( isset( $__cf_row_default[ $k ] ) ) {
		_eb_set_config( $k, '' );
	}
}

//
_eb_set_config( 'cf_threaddetails_include_file', '' );
_eb_set_config( 'cf_threadnode_include_file', '' );



// chạy vòng lặp rồi in các dữ liệu vào bảng lưu
foreach( $arr as $k => $v ) {
//	echo $k . '<br>';
	
	// hải có chữ cf_ ở đầu tiền
//	if ( substr( $k, 0, 3 ) == 'cf_' ) {
	if ( substr( $k, 0, 3 ) == 'cf_' && isset( $__cf_row_default[ $k ] ) ) {
		
		//
		_eb_set_config( $k, $v );
		
	}
}



//
die('<script type="text/javascript">
alert("Cài đặt giao diện mới thành công");
parent.window.location = parent.window.location.href;
</script>');




