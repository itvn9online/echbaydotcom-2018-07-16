<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Click log</a></div>
<br>
<?php





$a = _eb_get_log_click( " LIMIT 0, 100 " );
//print_r($a);





?>
<table border="0" cellpadding="6" cellspacing="0" width="100%" class="table-list">
	<tr class="table-list-title">
		<td width="20%">Thành viên</td>
		<td width="14%">Thời gian</td>
		<td width="11%">IP</td>
		<td>Nội dung</td>
	</tr>
</table>
<script type="text/javascript">
function add_content_for_log_click(a) {
	
	// TEST
//	var a = '%7B%22ref%22%3A%22https%253A%252F%252Fviettourist.vn%252Fdu-lich%252Fkhach-san%22%2C%22url%22%3A%22https%253A%252F%252Fviettourist.vn%252Fdu-lich%252Fvan-chuyen%22%2C%22iframe%22%3A0%2C%22title%22%3A%22V%25E1%25BA%25ADn%2520chuy%25E1%25BB%2583n%2520-%2520VietTourist%2520-%2520chuy%25C3%25AAn%2520tour%2520du%2520l%25E1%25BB%258Bch%2520th%25C3%25A1i%2520lan%252C%2520Du...%22%2C%22timezone%22%3A%22%252B0700%22%2C%22lang%22%3A%22vi%22%2C%22usertime%22%3A1510815729%2C%22window%22%3A%221369x398%22%2C%22document%22%3A%221369x1428%22%2C%22screen%22%3A%221452x817%22%2C%22staff_id%22%3A%22%22%7D';
	console.log(a);
	a = unescape(a);
	console.log(a);
	a = $.parseJSON(a);
	console.log(a);
	
}
</script>
<?



//
foreach ( $a as $v ) {
	echo '<script>add_content_for_log_click("' . $v->l_noidung . '");</script>';
}




