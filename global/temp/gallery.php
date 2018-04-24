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
$total_post = _eb_c( "SELECT COUNT(ID) AS c
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = 'attachment'" );
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
		`" . wp_posts . "`
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
	<li title="' . basename( $a_full[0] ) . '">
		<div class="eb-newgallery-padding">
			<div class="eb-newgallery-option">
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'cf_logo\');" class="gallery-add-to-logo">Đặt làm Logo</div>
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'cf_favicon\');" class="gallery-add-to-favicon">Đặt làm Favicon</div>
				
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'cf_og_image\', 1);" class="gallery-add-to-og_image">Đặt làm Ảnh mặc định</div>
				
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'_eb_product_avatar\', 1);" class="gallery-add-to-post_avt small">Đặt làm Ảnh đại diện</div>
				
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'_eb_category_avt\', 1);" class="gallery-add-to-category_avt small">Đặt làm Ảnh đại diện (Banner)</div>
				<div onClick="EBA_add_img_logo(\'' . $a_full[0] . '\', \'_eb_category_favicon\');" class="gallery-add-to-category_favicon small">Đặt làm Ảnh thu gọn (Favicon)</div>
			</div>
			<div class="eb-newgallery-bg" style="background-image:url(\'' . $a_thumb[0] . '\');">&nbsp;</div>
		</div>
	</li>';
}



//
$str_part_page = '';
if ( $totalPage > 1 ) {
	for ( $i = 1; $i <= $totalPage; $i++ ) {
		$str_part_page .= '<a href="javascript:;" onClick="ajaxl(\'gallery&trang=' . $i . '\', \'oi_admin_popup\', 9);" class="' . ( $i == $trang ? 'bold redcolor' : '' ) . '">' . $i . '</a>';
	}
}


//
echo '
<div class="eb-newgallery">
	<div class="text-right eb-gallery-close"><button type="button" onClick="$(\'#oi_admin_popup\').hide();" class="cur">Đóng [ x ] <em>hoặc</em> nhấn phím <strong>Esc</strong></button></div>
	<ul class="cf">' . $str_list_file . '</ul>
	<div class="text-center"><strong>' . $trang . '</strong>/ ' . $totalPage . '</div>
	<div class="text-center eb-gallery-part-page">' . $str_part_page . '</div>
</div>
<br>';




