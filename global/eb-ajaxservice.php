<?php




// tham số không thể thiếu
if ( ! isset( $_GET['set_module'] ) || $_GET['set_module'] == '' ) {
	WGR_parameter_not_found(__FILE__);
}




//
$action_module = trim( $_GET['set_module'] );




// kiểm tra file này có trên theme của người dùng không
$echbay_ajax_file = EB_THEME_PHP . $action_module . '.php';

// tìm trong theme con trước
$child_theme_ajaxl = '';
if ( using_child_wgr_theme == 1 ) {
	$child_theme_ajaxl = EB_CHILD_THEME_URL . $action_module . '.php';
}

//
if ( $child_theme_ajaxl != '' && file_exists( $child_theme_ajaxl ) ) {
	$echbay_ajax_file = $child_theme_ajaxl;
	
	if ( ! isset( $_GET['no_echo'] ) ) {
		echo '<!-- ajax by child theme (EchBay plugin) -->';
	}
}
else if ( file_exists( $echbay_ajax_file ) ) {
	echo '<!-- ajax by theme (EchBay plugin) -->';
}
else {
	
	// kiểm tra ajax theo plugin
	$echbay_ajax_file = EB_THEME_PLUGIN_INDEX . 'global/temp/' . $action_module . '.php';
	
	if ( file_exists( $echbay_ajax_file ) ) {
		if ( ! isset( $_GET['no_echo'] ) ) {
			echo '<!-- EchBay plugin ajax -->';
		}
	}
	else {
		echo 'Module not found (ajaxl). Please check in <strong>' . EB_THEME_PLUGIN_INDEX . 'global/temp/</strong>';
		
		// -> thoát luôn, không cho nó đẻ trứng
		exit();
	}
	
}

//
include $echbay_ajax_file;




// đến đây xong việc rồi cũng cắt trứng luôn, không cho nó thoát
exit();



