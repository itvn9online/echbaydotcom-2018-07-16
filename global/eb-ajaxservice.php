<?php




// tham số không thể thiếu
if ( ! isset( $_GET['set_module'] ) || $_GET['set_module'] == '' ) {
	die('Parameter not found');
}




//
$action_module = trim( $_GET['set_module'] );




// kiểm tra file này có trên theme của người dùng không
$echbay_ajax_file = EB_THEME_PHP . $action_module . '.php';
if ( file_exists( $echbay_ajax_file ) ) {
	echo '<!-- ajax by theme (EchBay plugin) -->';
}
else {
	
	// kiểm tra ajax theo plugin
	$echbay_ajax_file = EB_THEME_PLUGIN_INDEX . 'global/temp/' . $action_module . '.php';
	
	if ( file_exists( $echbay_ajax_file ) ) {
		echo '<!-- EchBay plugin ajax -->';
	}
	else {
		echo 'Module not found';
		
		// -> thoát luôn, không cho nó đẻ trứng
		exit();
	}
	
}

//
include $echbay_ajax_file;




// đến đây xong việc rồi cũng cắt trứng luôn, không cho nó thoát
exit();



