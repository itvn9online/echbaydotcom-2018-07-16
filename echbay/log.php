<ul class="cf eb-admin-tab">
	<li><a href="admin.php?page=eb-log&tab=click">Click log</a></li>
	<li><a href="admin.php?page=eb-log&tab=admin">Admin log</a></li>
	<li><a href="admin.php?page=eb-log&tab=user">User log</a></li>
	<li><a href="admin.php?page=eb-log&tab=search">Search log</a></li>
	<li><a href="admin.php?page=eb-log&tab=error">Error log</a></li>
	<li><a href="admin.php?page=eb-log&tab=contact">Liên hệ</a></li>
</ul>
<?php




$eb_ajax_get_tab = isset($_GET['tab']) ? trim($_GET['tab']) : 'click';
$eb_get_tab = 'log_' . $eb_ajax_get_tab;
//echo $eb_get_tab . '<br>';

//
$include_tab = ECHBAY_PRI_CODE . $eb_get_tab . '.php';
//echo $include_tab . '<br>';



// nếu không có file -> module lỗi -> hủy bỏ
if ( ! file_exists( $include_tab ) ) {
	die('Module <strong>' . $eb_get_tab . '</strong> not found');
}



//
$date_format = _eb_get_option('date_format');
$time_format = _eb_get_option('time_format');


//
$log_type = 0;
$log_name = 'Default log';



//
include_once $include_tab;



?>
<script type="text/javascript">



//
$('.content-to-short').each(function() {
	var len = 110,
		a = $(this).html() || '',
		str_len = g_func.strip_tags(a),
		str = '';
	if (a != '' && str_len.length > len + 10) {
		$(this).attr({
			title: str_len
		});
		a = a.split(' ');
		for (var i = 0; i < a.length; i++) {
			str += a[i] + ' ';
			if (str.length > len) {
				break;
			}
		}
		if (str.length > len + 10) {
			str = str.substr(0, len);
		}
		str += '...';
		$(this).html(str);
	}
});



// nạp lại trang sau 1 khoảng thời gian
if ( typeof eb_reload_this_page != 'number' ) {
	var eb_reload_this_page = 1;
}
setTimeout(function () {
	eb_reload_this_page ++;
	console.log(eb_reload_this_page);
	if ( eb_reload_this_page > 10 ) {
		window.location = window.location.href;
	}
	else {
		ajaxl('log&tab=<?php echo $eb_ajax_get_tab; ?>', 'rAdminME');
	}
}, 61 * 1000);



</script> 