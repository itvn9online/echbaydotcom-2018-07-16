<?php



//
echo '<link rel="stylesheet" href="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/css/products_post.css?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'css/products_post.css' ) . '" type="text/css" media="all" />' . "\n";




//
$ok_cho_remove = false;
$check_post_name = _eb_number_only( $_GET['check_post_name'] );
$save_post_name = $check_post_name;
$check_post_name = '-' . $check_post_name;
$check_by_text = $check_post_name;
$len_by_text = strlen( $check_by_text );

// kiểm tra tham số đầu vào, phải chuẩn cấu trúc
/*
if ( substr( $check_post_name, 0, 2 ) != $check_by_text ) {
	$check_post_name = $check_by_text;
}
*/

//
if ( isset( $_GET['remove_now'] ) ) {
	// kiểm tra độ chuẩn xác của URL -> chỉ có thể là chuỗi -2
	/*
	$str = $check_by_text;
	$str2 = $check_by_text;
	for ( $i = 0; $i < 100; $i++ ) {
//		echo $str . '<br>';
		if ( $check_post_name == $str ) {
			*/
			$ok_cho_remove = true;
			/*
			break;
		}
		
		// thêm chuỗi vào để kiểm tra tiếp
		$str .= $str2;
	}
	*/
}

//
$cao = _eb_c("SELECT COUNT(ID) as a
	FROM
		`" . wp_posts . "`
	WHERE
		`post_name` LIKE '%{$check_post_name}'");

//
$limit_select = 500;
if ( isset( $_GET['total_no_remove'] ) ) {
	$limit_select += (int) $_GET['total_no_remove'];
}

$sql = _eb_q("SELECT ID, post_title, post_name
	FROM
		`" . wp_posts . "`
	WHERE
		`post_name` LIKE '%{$check_post_name}'
	ORDER BY
		ID DESC
	LIMIT 0, " . $limit_select);

//
//print_r( $sql );

echo '<div>';
for ( $i = 1; $i < 10; $i++ ) {
	$cl = '';
	if ( $save_post_name == $i ) {
		$cl = ' bold';
	}
	
	//
	echo '<a href="' . admin_link . 'admin.php?page=eb-products&check_post_name=' . $i . '" class="check-post-name' . $cl . '">Check (' . $i . ')</a> | ';
}
echo '</div><br>';

echo '<div>';
for ( $i = 1; $i < 20; $i++ ) {
	$cl = '';
	if ( $save_post_name == $i ) {
		$cl = ' bold';
	}
	
	//
	echo '<a href="' . admin_link . 'admin.php?page=eb-products&check_post_name=' . $i . '&remove_now=1" class="check-post-name' . $cl . '">Remove (' . $i . ')</a> | ';
}
echo '</div>';

?>

<br>
<div class="orgcolor small">* Menu chỉ hiển thị từ 1-9, các số khác có thể chủ động thay tham số <strong>check_post_name</strong> trên URL. Khi số cần check &gt; 2 -> lệnh sẽ tự động chạy cho đến 499 sẽ dừng.</div>
<br>
<div class="text-right"><a href="<?php echo admin_link; ?>admin.php?page=eb-products&check_post_name=<?php echo $save_post_name; ?>&remove_now=1" class="d-iblock blue-button whitecolor">Xóa các bài viết này</a></div>
<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-list class-for-post-type class-for-<?php echo $by_post_type; ?>">
	<tr class="table-list-title">
		<td>ID</td>
		<td>Name</td>
		<td>Slug</td>
		<td><?php echo number_format( $cao ); ?></td>
	</tr>
	<?php


//
$auto_reload_page = false;
$count_no_remove = 0;
if ( ! empty( $sql ) ) {
	
	//
	foreach ( $sql as $o ) {
		
//		print_r( $o ); exit();
		
		//
		echo '
<tr>
	<td data-id="' . $o->ID . '" class="each-to-get-id">' . $o->ID . '</td>
	<td class="small"><a href="' . admin_link . 'post.php?post=' . $o->ID . '&action=edit" target="_blank"><strong>' . $o->post_title . '</strong> <i title="Sửa" class="fa fa-edit greencolor"></i></a></td>
	<td class="small"><a href="' . web_link . '?p=' . $o->ID . '" target="_blank">' . $o->post_name . ' <i class="fa fa-eye"></i></a></td>';
	
	if ( $ok_cho_remove == true ) {
		// thử kiểm tra lại URL tử title xem có đúng không
		$check_post_title = _eb_non_mark_seo( $o->post_title );
		$check_post_title = substr( $check_post_title, strlen( $check_post_title ) - $len_by_text );
		
		if ( $check_post_title == $check_by_text ) {
			echo '<td class="bluecolor bold">Nonoo</td>';
			$count_no_remove++;
		}
		else {
			/*
			_eb_q("DELETE
			FROM
				`" . wp_posts . "`
			WHERE
				`ID` = " . $o->ID, 0);
				*/
			
			//
			wp_delete_post( $o->ID, true );
			
			echo '<td class="orgcolor">Remove</td>';
			
			//
			if ( $auto_reload_page == false ) {
				$auto_reload_page = true;
			}
		}
	}
	else {
		echo '<td>&nbsp;</td>';
	}
	
echo '</tr>';
		
	}
	
}

	?>
</table>
<script>
<?php

// nếu xác định là còn -> chạy tiếp
if ( $auto_reload_page == true && $cao > $limit_select ) {
	?>
setTimeout(function () {
	window.location = window.location.href.split('&total_no_remove=')[0] + '&total_no_remove=<?php echo $count_no_remove; ?>';
}, 5000);
	<?php
}
// tự động chạy khi check từ 3 trở lên
//else if ( $save_post_name > 2 && $save_post_name < 500 && $ok_cho_remove == true ) {
else if ( $save_post_name > 2 && $save_post_name < 500 ) {
	?>
setTimeout(function () {
	window.location = window.location.href.split('&check_post_name=')[0] + '&check_post_name=<?php echo $save_post_name + 1; ?>&remove_now=1';
}, 5000);
	<?php
}

?>

//
WGR_admin_quick_edit_select_menu();

</script>
