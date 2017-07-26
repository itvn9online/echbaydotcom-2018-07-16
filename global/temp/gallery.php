<?php



//
/*
$all_sizes = get_intermediate_image_sizes();
$all_sizes[] = 'full';
$all_sizes = array_reverse( $all_sizes );
print_r( $all_sizes );
*/

//
/*
$all_sizes = array();
$all_sizes[] = 'full';
$all_sizes[] = 'thumbnail';
print_r( $all_sizes );
*/




//
$total_post = 0;
$sql = $wpdb->get_results( "SELECT COUNT(ID)
	FROM
		`" . $wpdb->posts . "`
	WHERE
		post_type = 'attachment'", OBJECT );
//print_r( $sql );
if ( isset($sql[0]) ) {
	$sql = $sql[0];
	foreach ( $sql as $v ) {
		$total_post = $v;
	}
}
$post_per_page = 50;
$trang = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
$totalPage = ceil ( $total_post / $post_per_page );
if ($trang > $totalPage) {
	$trang = $totalPage;
}
else if ( $trang < 1 ) {
	$trang = 1;
}
//echo $trang . '<br>' . "\n";
$offset = ($trang - 1) * $post_per_page;

//
$sql = $wpdb->get_results( "SELECT *
	FROM
		`" . $wpdb->posts . "`
	WHERE
		post_type = 'attachment'
	ORDER BY
		ID DESC
	LIMIT " . $offset . ", " . $post_per_page, OBJECT );
//print_r( $sql );

//
$str_list_file = '';
foreach ( $sql as $v ) {
//	echo $v->guid . '<br>' . "\n";
	
	//
	$a_full = wp_get_attachment_image_src( $v->ID, 'full' );
//	print_r( $a_full );
	
	$a_thumb = wp_get_attachment_image_src( $v->ID, 'thumbnail' );
//	print_r( $a_thumb );
	
	//
	$str_list_file .= '
	<li>
		<div class="eb-newgallery-padding">
			<div class="eb-newgallery-option">
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'cf_logo\');" class="gallery-add-to-logo">Đặt làm Logo</div>
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'cf_favicon\');" class="gallery-add-to-favicon">Đặt làm Favicon</div>
			</div>
			<div class="eb-newgallery-bg" style="background-image:url(\'' . $a_thumb[0] . '\');">&nbsp;</div>
		</div>
	</li>';
}

//
echo '<ul class="cf eb-newgallery">' . $str_list_file . '</ul>';



