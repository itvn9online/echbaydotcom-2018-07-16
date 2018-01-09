<?php




$html_v2_file = 'page';
//	$html_file = $html_v2_file . '.html';

// nếu không tồn tại file thiết kế riêng -> kiểm tra file HTML mẫu
//	if ( ! file_exists( EB_THEME_HTML . $html_file ) ) {
	if ( $__cf_row['cf_page_column_style'] != '' ) {
//		$html_v2_file = $html_v2_file . '_' . $__cf_row['cf_page_column_style'];
		
		$custom_product_flex_css = EBE_get_html_file_addon( $html_v2_file, $__cf_row['cf_page_column_style'] );
	}
//	}
//	echo $__cf_row['cf_page_column_style'] . '<br>' . "\n";
//	echo $html_v2_file . '<br>' . "\n";

// kiểm tra nếu có file html riêng -> sử dụng html riêng
//	$check_html_rieng = _eb_get_private_html( $html_file, 'blog_node.html' );
//	$thu_muc_for_html = $check_html_rieng['dir'];




$str_for_details_sidebar = _eb_echbay_get_sidebar( 'page_content_sidebar' );



