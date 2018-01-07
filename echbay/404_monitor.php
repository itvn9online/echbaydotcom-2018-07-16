<style type="text/css">
.split-url-to-short {
	/*
	height: 19px;
	overflow: hidden;
	width: 99%;
	*/
	max-width: 600px;
}
</style>
<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">404 Monitor</a></div>
<br>
<div>* Tất cả các trang 404 sẽ được lưu log, nếu trang đã bị thay đổi URL, bạn hãy nhấp đúp chuột vào bên cột <strong>URL redirect to</strong> để nhập URL mới cho trang 404. Nếu nhiều log quá, hãy <a href="#" class="url-for-cleanup-404">bấm vào đây</a> để dọn dẹp bớt log cho nó nhẹ web.</div>
<br>
<script type="text/javascript">
$('.url-for-cleanup-404').attr({
	href: window.location.href.split('&cleanup_404=')[0].split('#')[0] + '&cleanup_404=1'
});
</script>
<table border="0" cellpadding="6" cellspacing="0" width="100%" class="table-list ip-invoice-alert">
	<tr class="table-list-title">
		<td width="50%">URL with 404 Error</td>
		<td width="50%">URL redirect to</td>
	</tr>
	<?php


//
//global $wpdb;

//
//echo wp_termmeta . '<br>' . "\n";

// dọn dẹp các bản ghi cũ
/*
$count_monitor = _eb_c("SELECT COUNT(meta_id) AS c
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . eb_log_404_id_postmeta . "
		AND meta_value = 1");
if ( $count_monitor > 500 ) {
	*/
if ( isset( $_GET['cleanup_404'] ) ) {
	_eb_q("DELETE
	FROM
		`" . wp_termmeta . "`
	WHERE
		term_id = " . eb_log_404_id_postmeta . "
		AND meta_value = 1", 0);
}



// chuyển sang sử dụng term meta cho đỡ tập trung vào bảng post
$sql = _eb_q("SELECT *
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . eb_log_404_id_postmeta . "
	ORDER BY
		meta_id DESC");
//print_r($sql);
//if ( count( $sql ) > 0 ) {
if ( ! empty( $sql ) ) {
	foreach ( $sql as $v ) {
		add_term_meta( eb_log_404_id_postmeta, $v->meta_key, $v->meta_value, true );
	}
	
	//
	_eb_q("DELETE
	FROM
		`" . wp_postmeta . "`
	WHERE
		post_id = " . eb_log_404_id_postmeta, 0);
}


//
$sql = _eb_q("SELECT *
	FROM
		`" . wp_termmeta . "`
	WHERE
		term_id = " . eb_log_404_id_postmeta . "
	ORDER BY
		meta_id DESC
	LIMIT 0, 1000");
//print_r($sql);

foreach ( $sql as $v ) {
	
	//
	if ( $v->meta_value == 1 ) {
		$val = '<em>NULL</em>';
	}
	else {
//		$val = '<a href="' . $v->meta_value . '" target="_blank">' . $v->meta_value . '</a>';
		$val = $v->meta_value;
	}
	
	//
	echo '
<tr>
	<td><div title="' . $v->meta_key . '" class="split-url-to-short"><a href="' . web_link . substr( $v->meta_key, 1 ) . '" target="_blank">' . $v->meta_key . '</a></div></td>
	<td id="redirect_404_progress' . $v->meta_id . '" data-id="' . $v->meta_id . '" data-value="' . $v->meta_value . '" class="click-to-update-url-redirect cur">' . $val . '</td>
</tr>';
}


?>
</table>
<script type="text/javascript">

function click_to_update_404_url_redirect () {
	$('.click-to-update-url-redirect').off('dblclick').dblclick(function () {
		var a = $(this).attr('data-id') || '',
			b = $(this).attr('data-value') || '',
			c = null,
			d = $(this).attr('id') || '';
		
		//
		if ( a != '' && a > 0 ) {
			if ( b == 1 ) {
				b = '';
			}
			
			//
			c = prompt( 'Redirect URL:', b );
	//		console.log(c);
			
			//
			if ( c != null ) {
	//			console.log('ajax update');
				ajaxl('404_redirect_monitor&url=' + encodeURIComponent( c ) + '&meta_id=' + a, d, 1);
				
				//
				$(this).attr({
					'data-value' : c == '' ? 1 : c
				});
			}
		}
	});
}

//
click_to_update_404_url_redirect();

</script> 
