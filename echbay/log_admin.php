<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Admin log (<?php echo number_format( _eb_count_log( 1 ) ); ?>)</a></div>
<br>
<?php





$a = _eb_get_log_admin( " LIMIT 0, 100 " );





?>
<table border="0" cellpadding="6" cellspacing="0" width="100%" class="table-list">
	<tr class="table-list-title">
		<td width="20%">Thành viên</td>
		<td width="14%">Thời gian</td>
		<td width="11%">IP</td>
		<td>Nội dung</td>
	</tr>
	<?php
foreach ( $a as $v ) {
	echo '
<tr>
	<td><a href="' . admin_link . 'user-edit.php?user_id=' . $v->tv_id . '">' . WGR_get_user_email( $v->tv_id ) . '</a></td>
	<td>' . date( $date_format . ' (' . $time_format . ')', $v->l_ngay ) . '</td>
	<td>' . $v->l_ip . '</td>
	<td class="content-to-short">' . $v->l_noidung . '</td>
</tr>';
}
?>
</table>
