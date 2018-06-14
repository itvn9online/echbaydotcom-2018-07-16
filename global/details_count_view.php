<?php



/*
* Cập nhật lượt xem cho phần tin tức, page
*/




// lấy lượt xem sản phẩm
$trv_luotxem = _eb_number_only( _eb_get_post_object( $pid, '_eb_product_views', 0 ) );

// kiểm tra trong cookie xem có chưa
$check_update_views = _eb_getCucki('wgr_post_id_view_history');
if ( $check_update_views == '' || strstr( $check_update_views, '[' . $pid . ']' ) == false ) {
	// tăng lượt view lên -> do lượt view sử dụng cookie lưu trong 7 ngày, nên lượt view cũng tăng nhiều lên 1 chút -> tính theo dạng 6 tiếng 1 view -> ngày 4 view
	$trv_luotxem += rand( 15, 30 );
	
	// cập nhật lượt view mới
	WGR_update_meta_post( $pid, '_eb_product_views', $trv_luotxem );
}



