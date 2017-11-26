<?php

$log_type = 3;

//
_eb_add_full_css( EBE_admin_set_realtime_for_file ( array(
	EB_URL_OF_PLUGIN . 'css/log_click.css'
) ), 'link' );

?>

<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Click log</a></div>
<br>
<div align="center" class="small">* Hệ thống phân tích lượt truy cập thông qua giới thiệu (không bao gồm các truy cập trực tiếp)</div>
<br />
<div class="cf">
	<div class="lf f25">
		<ul class="ul-chu-thich small">
			<li><span><font>&nbsp;</font> Lượt truy cập mới (<em id="oi_show_total_new">0</em>)</span></li>
			<li><span><font class="font-quay-lai">&nbsp;</font> Lượt truy cập quay lại (<em id="oi_show_total_return">0</em>)</span></li>
			<li><span><font class="font-iframe">&nbsp;</font> Lượt truy cập qua iframe (<em id="oi_show_total_iframe">0</em>)</span></li>
		</ul>
	</div>
	<div class="lf f75">
		<ul class="cf thongke-log-click">
			<li>
				<div><font>Ngay bây giờ</font><span><?php echo number_format( _eb_count_log( $log_type, 60 ) ); ?></span></div>
			</li>
			<li>
				<div><font>Khoảng 30 phút qua</font><span><?php echo number_format( _eb_count_log( $log_type, 1800 ) ); ?></span></div>
			</li>
			<li>
				<div><font>24 giờ qua</font><span><?php echo number_format( _eb_count_log( $log_type, 0, 1 ) ); ?></span></div>
			</li>
			<li>
				<div><font>30 ngày qua</font><span><?php echo number_format( _eb_count_log( $log_type, 0, 30 ) + (int) _eb_get_option('WGR_history_for_log' . $log_type) ); ?></span></div>
			</li>
		</ul>
	</div>
</div>
<!--
<div class="cf">
	<div class="lf f20">
		<div class="titleCSS bold">Site đích:</div>
		<div class="top-mod-table" id="oi_dich_den_cuar_url"></div>
		<br />
		<div class="titleCSS bold d-none">Phiên bản website:</div>
		<ul class="ul-chu-thich small d-none">
			<li><span><font class="font-pc-version">&nbsp;</font> Phiên bản PC (<em id="oi_show_total_pc">0</em>)</span></li>
			<li><span><font class="font-mobile-version">&nbsp;</font> Phiên bản mobile (<em id="oi_show_total_mobile">0</em>)</span></li>
		</ul>
	</div>
	<div class="lf f80">
		<div class="cf top-mod-table">
			<div class="lf f50">
				<div class="titleCSS bold">Top domain:</div>
				<div class="cf">
					<div id="oi_top_domain" class="lf f50"></div>
					<div id="oi_top_domain2" class="lf f50"></div>
				</div>
			</div>
			<div class="lf f25">
				<div class="titleCSS bold">Top IP:</div>
				<div id="oi_top_ip"></div>
			</div>
			<div class="lf f25">
				<div class="titleCSS bold">Top Session:</div>
				<div id="oi_top_session"></div>
			</div>
		</div>
	</div>
</div>
--> 
<br />
<table border="0" cellpadding="6" cellspacing="0" width="100%" class="table-list table-log-click animate-log-click small" style="opacity:.2;background-color:#fff;">
	<tr class="table-list-title">
		<td title="IP và số nhấp chuột đến từ IP đó">IP</td>
		<td>Từ khóa</td>
		<td>Nguồn</td>
		<td>Chiến dịch</td>
		<td title="Xác định đích của session sẽ được tạo ss_ads_referre">Host</td>
		<td>Tiêu đề/ Đích</td>
		<td>Giờ máy trạm</td>
		<td>Giờ máy chủ</td>
		<td>Múi giờ</td>
		<td>Ngôn ngữ</td>
		<td title="Kích thước màn hình">Màn hình/ Hệ điều hành</td>
		<td>Trình duyệt</td>
		<td title="Kích thước cửa sổ">Window</td>
		<td title="Kích thước văn bản">Document</td>
		<td>Thành viên</td>
		<td>Nhân viên</td>
	</tr>
</table>
<table class="d-none jmp-for-tr">
	<tr data-rel="{jmp.ref}" data-time="{jmp.ngay}" data-ip="{jmp.ip}" data-return="{jmp.quaylai}" data-iframe="{jmp.iframe}" class="tr-log-click tr-log-click{jmp.quaylai} tr-log-iframe{jmp.iframe}">
		<td><a href="<?php echo admin_link; ?>admin.php?page=eb-log&tab=click&ip={jmp.ip}">{jmp.ip}{jmp.total_ip}</a></td>
		<td class="title-by-rel ref-to-keyword">-</td>
		<td class="title-by-rel"><span class="title-by-rel ref-to-source"></span> <a href="#" target="_blank" rel="nofollow" target="_blank" class="link-by-rel greencolor click-open-new-link"> &rArr; </a></td>
		<td title="{jmp.url}" class="url-to-campaign">-</td>
		<td title="{jmp.url}" class="host-to-short">-</td>
		<td><a href="{jmp.url}" target="_blank" rel="nofollow" class="title-to-short small">{jmp.title}</a></td>
		<td class="number-to-time">{jmp.usertime}</td>
		<td class="number-to-time">{jmp.ngay}</td>
		<td>{jmp.timezone}</td>
		<td>{jmp.lang}</td>
		<td>{jmp.screen} <span title="{jmp.agent}" class="agent-to-bit"></span></td>
		<td title="{jmp.agent}" class="agent-to-browser"></td>
		<td>{jmp.window}</td>
		<td>{jmp.document}</td>
		<td><a href="<?php echo admin_link; ?>user-edit.php?user_id={jmp.tv_id}" target="_blank" rel="nofollow" class="d-block">{jmp.tv_id}</a></td>
		<td><a href="<?php echo admin_link; ?>user-edit.php?user_id={jmp.staff_id}" target="_blank" rel="nofollow" class="d-block">{jmp.staff_id}</a></td>
	</tr>
</table>
<script type="text/javascript">

var arr_click_list = [],
	current_admin_link = '<?php echo admin_link; ?>admin.php?page=eb-log&tab=click';

function add_content_for_log_click(a, op) {
	
	// TEST
//	var a = '%7B%22ref%22%3A%22https%253A%252F%252Fviettourist.vn%252Fdu-lich%252Fkhach-san%22%2C%22url%22%3A%22https%253A%252F%252Fviettourist.vn%252Fdu-lich%252Fvan-chuyen%22%2C%22iframe%22%3A0%2C%22title%22%3A%22V%25E1%25BA%25ADn%2520chuy%25E1%25BB%2583n%2520-%2520VietTourist%2520-%2520chuy%25C3%25AAn%2520tour%2520du%2520l%25E1%25BB%258Bch%2520th%25C3%25A1i%2520lan%252C%2520Du...%22%2C%22timezone%22%3A%22%252B0700%22%2C%22lang%22%3A%22vi%22%2C%22usertime%22%3A1510815729%2C%22window%22%3A%221369x398%22%2C%22document%22%3A%221369x1428%22%2C%22screen%22%3A%221452x817%22%2C%22staff_id%22%3A%22%22%7D';
//	console.log(a);
	a = unescape(a);
//	console.log(a);
	a = $.parseJSON(a);
//	console.log(a);
	
	//
//	console.log(op);
	for ( var x in op ) {
		a[x] = op[x];
	}
//	console.log(a);
	
	//
	arr_click_list.push(a);
	
}

<?php

$a = _eb_get_log_click( " LIMIT 0, 100 " );
//print_r($a);

//
foreach ( $a as $v ) {
	echo 'add_content_for_log_click("' . $v->l_noidung . '", {
		agent: "' . $v->l_agent . '",
		tv_id: "' . $v->tv_id . '",
		ngay: "' . $v->l_ngay . '",
		ip: "' . $v->l_ip . '"
	});';
}

?>

</script>
<?php

//
_eb_add_full_js( EBE_admin_set_realtime_for_file ( array(
	EB_URL_OF_PLUGIN . 'echbay/js/log_click.js',
	EB_URL_OF_PLUGIN . 'echbay/js/invoice_agent.js'
) ), 'add' );


