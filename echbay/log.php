<ul class="cf eb-admin-tab">
	<li><a href="admin.php?page=eb-log&tab=admin">Admin log</a></li>
	<li><a href="admin.php?page=eb-log&tab=user">User log</a></li>
	<li><a href="admin.php?page=eb-log&tab=click">Click log</a></li>
	<li><a href="admin.php?page=eb-log&tab=search">Search log</a></li>
	<li><a href="admin.php?page=eb-log&tab=error">Error log</a></li>
	<li><a href="admin.php?page=eb-log&tab=contact">Liên hệ</a></li>
</ul>
<?php




$eb_get_tab = isset($_GET['tab']) ? trim($_GET['tab']) : 'admin';
$eb_get_tab = 'log_' . $eb_get_tab;
//echo $eb_get_tab . '<br>';

//
$include_tab = ECHBAY_PRI_CODE . $eb_get_tab . '.php';
//echo $include_tab . '<br>';



// nếu không có file -> module lỗi -> hủy bỏ
if ( ! file_exists( $include_tab ) ) {
	die('Module <strong>' . $eb_get_tab . '</strong> not found');
}



include_once $include_tab;



