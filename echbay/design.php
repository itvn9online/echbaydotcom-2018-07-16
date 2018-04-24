<?php




//
global $wpdb;




// lấy các file HTML theo theme
//echo EB_THEME_HTML;


$arr = glob ( EB_THEME_HTML . '*.html' );
//print_r($arr);

//
$arr = array_filter ( $arr, 'is_file' );

//
$curent_file = isset($_GET['file']) ? $_GET['file'] : '';
$curent_page_id = 0;
$curent_page_name = '';
$curent_page_content = '';
$curent_theme_dir = $__cf_row['cf_theme_dir'];
//$curent_theme_dir = basename( dirname( dirname( EB_THEME_HTML ) ) );

// kiểm tra xem có tồn tại file không
if ( $curent_file != '' && file_exists( EB_THEME_HTML . $curent_file ) ) {
	
	//
	$curent_page_name = str_replace( '.html', '', $curent_file );
	
	//
	$curent_page_name = $__cf_row['cf_theme_dir'] . '-' . $curent_page_name;
	
	// kiểm tra xem trong CSDL có nội dung cho file này không
	$sql = _eb_q("SELECT ID, post_title, post_excerpt
	FROM
		" . wp_posts . "
	WHERE
		post_name = '" . $curent_page_name . "'
		AND post_type = 'eb_page'
		AND post_status = 'private'");
//	print_r( $sql );
	
	// có -> sử dụng nội dung theme này
	if ( isset( $sql[0] ) && isset($sql[0]->ID) ) {
		$curent_page_id = $sql[0]->ID;
		$curent_page_content = $sql[0]->post_excerpt;
	}
	// không
	else {
		$curent_page_content = file_get_contents( EB_THEME_HTML . $curent_file, 1 );
	}
}
// không thì loại ngay
else {
	$curent_file = '';
}

//
$str_file_list = '';
foreach ( $arr as $k => $v ) {
	$v = basename( $v );
	
	$cl = '';
	if ( $v == $curent_file ) {
		$cl = 'bold redcolor';
	}
	
	$str_file_list .= '<li><a href="' . admin_link . 'admin.php?page=eb-coder&tab=design&file=' . $v . '" class="' . $cl . '">' . $v . '</a></li>';
}
//print_r($arr);




?>

<div class="cf">
	<div class="lf f75 fix-textarea-height">
		<div>
			<form name="frm_config" method="post" action="<?php echo web_link; ?>process/?set_module=design" target="target_eb_iframe" onsubmit="check_update_design();">
				<div class="d-none2">
					<input type="text" name="eb_page_id" value="<?php echo $curent_page_id; ?>">
					<input type="text" name="eb_page_name" value="<?php echo $curent_page_name; ?>">
					<input type="text" name="eb_page_dir" value="<?php echo $curent_theme_dir; ?>">
				</div>
				<div>
					<textarea name="eb_page_content" placeholder="Để chỉnh sửa HTML, hãy chọn tệp cần sửa ở góc bên phải." style="width:99%;"><?php echo $curent_page_content; ?></textarea>
				</div>
				<div>
					<input type="submit" value="Cập nhật" class="eb-admin-wp-submit" />
				</div>
			</form>
		</div>
		<p class="l19">* Chức năng này dùng để khách hàng tự chỉnh sửa giao diện dựa theo giao diện gốc của tác giả.<br>
			- Để chỉnh sửa, bạn hãy chọn tệp cần sửa, thay đổi nội dung rồi nhấn cập nhật. Sau khi cập nhật được lưu, website sẽ sử dụng tệp giao diện được chỉnh sửa bởi bạn thay vì sử dụng tệp giao diện của tác giả.<br>
			- Để sử dụng lại giao diện gốc của tác giả, chỉ cần xóa sạch nội dung tệp của bạn đi và cập nhật lại là được.</p>
	</div>
	<div class="lf f25">
		<div class="left-menu-space">
			<div><strong>File:</strong></div>
			<ul>
				<?php echo $str_file_list; ?>
			</ul>
		</div>
	</div>
</div>
