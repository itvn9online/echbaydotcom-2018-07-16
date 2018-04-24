<?php


/*
* Cập nhật toàn bộ key cho các sản phẩm chưa có dữ liệu -> khác biệt phiên bản
*
* Trường hợp chức năng mới kích hoạt, nhưng dữ liệu tìm kiếm không có sẵn -> thêm tham số update_key_version để cập nhật lại toàn bộ key
*/
if ( isset($_GET['update_key_version']) && mtv_id > 0 ) {
	$sql = _eb_q("SELECT ID, post_title
	FROM
		`" . wp_posts . "`
	WHERE
		post_title != ''
		AND post_type = 'post'
		AND post_status = 'publish'
	ORDER BY
		ID DESC
	LIMIT 0, 5000");
//	print_r( $sql );
	
	// nếu có -> tạo nội dung mới để cho vào post meta
	if ( ! empty( $sql ) ) {
		foreach ( $sql as $v ) {
			$v->post_title = _eb_non_mark_seo ( $v->post_title );
			$v->post_title = str_replace ( '-', '', $v->post_title );
			
			//
			WGR_update_meta_post( $v->ID, '_eb_product_searchkey', $v->post_title );
		}
//		print_r( $sql );
	}
}





//
if ( isset($_GET['q']) ) {
	$current_search_key = trim( $_GET['q'] );
	$current_search_key = urldecode( $current_search_key );
}

//
if ( $current_search_key != '' ) {
	// bắt đầu tìm kiếm riêng
//	echo $current_search_key;
	
	//
	$search_key = _eb_non_mark_seo ( $current_search_key );
	$search_key = str_replace ( '-', ' ', $search_key );
	
	// key tìm kiếm kiểu mới
	$trv_key = str_replace ( ' ', '', $search_key );
	
	//
	$explode = explode ( ' ', $search_key );
	$strSearch = "";
	
	// tìm tương đối
	if (count ( $explode ) == 1) {
		$strSearch = " post_id LIKE '%{$trv_key}%'
		OR ( meta_key = '_eb_product_searchkey' AND meta_value LIKE '%{$trv_key}%' )
		OR ( meta_key = '_eb_product_sku' AND meta_value LIKE '%{$trv_key}%' ) ";
	}
	else {
		if (count ( $explode ) > 4) {
			$i = 1;
			$strSearch_ = '';
			
			//
			foreach ( $explode as $v ) {
				$strSearch_ .= $v;
				
				//
				if ($i % 3 == 0) {
					$strSearch_ = trim ( $strSearch_ );
					if ($strSearch_ != '') {
						if ($strSearch == "") {
							$strSearch .= " meta_value LIKE '%{$strSearch_}%'";
						}
						else {
							$strSearch .= " OR meta_value LIKE '%{$strSearch_}%'";
						}
						$strSearch_ = '';
					}
					else {
						$i --;
					}
				}
				$i ++;
			}
			
			//
			if ($strSearch_ != '' && strlen ( $strSearch_ ) > 5) {
				$strSearch_ = trim ( $strSearch_ );
				if ($strSearch_ != '') {
					$strSearch .= " OR meta_value LIKE '%{$strSearch_}%' ";
				}
			}
			
			//
			$strSearch = " meta_key = '_eb_product_searchkey' AND (" . $strSearch . ")";
		}
		else {
			$strSearch = " meta_key = '_eb_product_searchkey' AND meta_value LIKE '%{$trv_key}%' ";
		}
	}
	
	//
//	$strSearch = " AND (" . $strSearch . ")";
//	echo $strSearch;
	
	//
//	global $wpdb;
	
	//
	$sql = _eb_q("SELECT post_id
	FROM
		`" . wp_postmeta . "`
	WHERE
		" . $strSearch);
//	print_r( $sql );
	if ( ! empty( $sql ) ) {
		$strFilter = '';
		foreach ( $sql as $v ) {
			$strFilter .= ',' . $v->post_id;
		}
//		echo $strFilter;
		
		//
		if ( $strFilter != '' ) {
			$show_html_template = 'search';
			
			include EB_THEME_PLUGIN_INDEX . 'global/search_show.php';
		}
	}
	else {
		// xem có dùng mã tìm kiếm khác không
		$search_not_found = EBE_get_lang('search_addon');
		if ( $search_not_found == '' ) {
			$search_not_found = '<h4 class="text-center" style="padding:90px 0;">' . EBE_get_lang('search_not_found') . '</h4>';
		}
	}
}


