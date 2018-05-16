<?php



//
$arr_order_tab = array(
	'languages' => 'Ngôn ngữ',
//	'design' => 'Chỉnh sửa giao diện',
	'404_monitor' => '404 Monitor',
	'sitemap' => 'Sitemap',
	'robots' => 'Robots',
	'check_html' => 'Kiểm tra mã HTML',
	'file_list' => 'Kiểm tra chuẩn code',
	'server_info' => 'Thông tin server',
	'cleanup_cache' => 'Xóa bộ nhớ đệm',
	'php_info' => 'PHP Info',
	'local_attack' => 'Local attack',
	'leech_data' => 'Leech data',
	'export_products' => 'Xuất sản phẩm ra XML',
	'woo_convert' => 'Chuyển đổi Plugin',
	'install_demo' => 'Install demo',
	'cleanup_database' => 'Dọn dẹp website'
//	'wordpress_update_core' => 'Cập nhật WordPress',
//	'echbay_update_core' => 'Cập nhật EchBay',
//	'wordpress_rules' => 'WordPress rules',
);

echo '<ul class="cf eb-admin-tab">';

foreach ( $arr_order_tab as $k => $v ) {
	echo '<li><a href="admin.php?page=eb-coder&tab=' . $k . '">' . $v . '</a></li>';
}

echo '</ul>';




$eb_get_tab = isset($_GET['tab']) ? trim($_GET['tab']) : 'languages';
//echo $eb_get_tab . '<br>';

//
$include_tab = ECHBAY_PRI_CODE . $eb_get_tab . '.php';
//echo $include_tab . '<br>';



// nếu không có file -> module lỗi -> hủy bỏ
if ( ! file_exists( $include_tab ) || ! isset( $arr_order_tab[$eb_get_tab] ) ) {
	die('Module <strong>' . $eb_get_tab . '</strong> not found');
}


//
include_once $include_tab;




