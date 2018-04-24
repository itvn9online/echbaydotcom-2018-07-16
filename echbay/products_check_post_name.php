<?php



//
echo '<link rel="stylesheet" href="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/css/products_post.css?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'css/products_post.css' ) . '" type="text/css" media="all" />' . "\n";




//
$check_post_name = trim( $_GET['check_post_name'] );
$ok_cho_remove = false;

// kiểm tra tham số đầu vào, phải chuẩn cấu trúc
if ( substr( $check_post_name, 0, 2 ) != '-2' ) {
	$check_post_name = '-2';
}

//
if ( isset( $_GET['remove_now'] ) ) {
	// kiểm tra độ chuẩn xác của URL -> chỉ có thể là chuỗi -2
	$str = '-2';
	$str2 = $str;
	for ( $i = 0; $i < 100; $i++ ) {
//		echo $str . '<br>';
		if ( $check_post_name == $str ) {
			$ok_cho_remove = true;
			break;
		}
		
		// thêm chuỗi vào để kiểm tra tiếp
		$str .= $str2;
	}
}

//
$cao = _eb_c("SELECT COUNT(ID) as a
	FROM
		`" . $wpdb->posts . "`
	WHERE
		`post_name` LIKE '%{$check_post_name}'");

//
$limit_select = 200;
if ( isset( $_GET['total_no_remove'] ) ) {
	$limit_select += (int) $_GET['total_no_remove'];
}

$sql = _eb_q("SELECT ID, post_title, post_name
	FROM
		`" . $wpdb->posts . "`
	WHERE
		`post_name` LIKE '%{$check_post_name}'
	ORDER BY
		ID DESC
	LIMIT 0, " . $limit_select);

//
//print_r( $sql );


?>

<br>
<div class="text-right"><a href="<?php echo admin_link; ?>admin.php?page=eb-products&check_post_name=<?php echo $check_post_name; ?>&remove_now=1" class="d-iblock blue-button whitecolor">Xóa các bài viết này</a></div>
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
	<td><a href="' . web_link . '?p=' . $o->ID . '" target="_blank">' . $o->post_name . ' <i class="fa fa-eye"></i></a></td>';
	
	if ( $ok_cho_remove == true ) {
		// thử kiểm tra lại URL tử title xem có đúng không
		$check_post_title = _eb_non_mark_seo( $o->post_title );
		$check_post_title = substr( $check_post_title, strlen( $check_post_title ) - 2 );
		
		if ( $check_post_title == '-2' ) {
			echo '<td class="bluecolor bold">No no</td>';
			$count_no_remove++;
		}
		else {
			/*
			_eb_q("DELETE
			FROM
				`" . $wpdb->posts . "`
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
if ( $auto_reload_page == true ) {
	?>
setTimeout(function () {
	window.location = window.location.href.split('&total_no_remove=')[0] + '&total_no_remove=<?php echo $count_no_remove; ?>';
}, 10000);
	<?php
}
?>
</script> 
