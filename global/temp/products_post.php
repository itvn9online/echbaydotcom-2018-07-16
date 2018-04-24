<?php



$post_id = isset( $_GET['post_id'] ) ? (int)$_GET['post_id'] : 0;
$by_post_type = isset( $_GET['by_post_type'] ) ? trim( $_GET['by_post_type'] ) : 'post';
$arr_for_update_post = array();




if ( $post_id > 0 && $type != '' ) {
	
	// thay đổi STT sản phẩm
	if ( isset( $_GET['stt'] ) ) {
		$trv_stt = (int) $_GET['stt'];
		
		if ( $type == 'auto' ) {
			$sql = _eb_q ( "SELECT menu_order
			FROM
				`" . wp_posts . "`
			WHERE
				post_type = '" . $by_post_type . "'
				AND ID != " . $post_id . "
			ORDER BY
				menu_order DESC
			LIMIT 0, 1" );
//			print_r($sql); exit();
			$sql = $sql[0];
			foreach ( $sql as $v ) {
				$trv_stt = $v;
			}
			$trv_stt ++;
		}
		else if ( $type == 'up' ) {
			$trv_stt ++;
		}
		else if ( $type == 'down' ) {
			$trv_stt --;
			if ($trv_stt < 0) {
				$trv_stt = 0;
			}
		}
//		echo $trv_stt . '<br>' . "\n";
		
		//
		$arr_for_update_post['menu_order'] = $trv_stt;
		
		echo '<br>set post order: ' . $trv_stt;
	}
	// thay đổi trạng thái của sản phẩm
	else if ( isset( $_GET['toggle_status'] ) ) {
		$current_status = (int) $_GET['toggle_status'];
		
		// Đang mở -> ẩn
		if ( $current_status == 1 ) {
			$new_status = 'draft';
		}
		// Mặc định là hiển thị
		else {
			$new_status = 'publish';
		}
		
		//
		$arr_for_update_post['post_status'] = $new_status;
		
		echo '<br>set post status: ' . $new_status;
	}
	// thay đổi trạng thái ping với comment
	else if ( isset( $_GET['comment_status'] ) ) {
		$comment_status = trim( $_GET['comment_status'] );
		
		// Đang mở -> ẩn
		if ( $comment_status == 'open' ) {
			$new_status = 'closed';
		}
		// Mặc định là hiển thị
		else {
			$new_status = 'open';
		}
		
		//
		$arr_for_update_post['comment_status'] = $new_status;
		
		echo '<br>set comment status: ' . $new_status;
	}
	// thay đổi trạng thái ping với ping
	else if ( isset( $_GET['ping_status'] ) ) {
		$ping_status = trim( $_GET['ping_status'] );
		
		// Đang mở -> ẩn
		if ( $ping_status == 'open' ) {
			$new_status = 'closed';
		}
		// Mặc định là hiển thị
		else {
			$new_status = 'open';
		}
		
		//
		$arr_for_update_post['ping_status'] = $new_status;
		
		echo '<br>set ping status: ' . $new_status;
	}
	// cho phép công cụ tìm kiếm index hoặc noindex bài viết
	else if ( isset( $_GET['set_noindex'] ) ) {
		$set_noindex = trim( $_GET['set_noindex'] );
		
		// Đang mở -> ẩn
		if ( $set_noindex == 1 ) {
			$new_status = 0;
		}
		// Mặc định là hiển thị
		else {
			$new_status = 1;
		}
		
		//
		WGR_update_meta_post( $post_id, '_eb_product_noindex', $new_status );
		
		echo '<br>set index status: ' . $new_status;
	}
	// đặt làm hàng chính hãng
	else if ( isset( $_GET['chinh_hang'] ) ) {
		$chinh_hang = trim( $_GET['chinh_hang'] );
		
		// Đang mở -> ẩn
		if ( $chinh_hang == 1 ) {
			$new_status = 0;
		}
		// Mặc định là hiển thị
		else {
			$new_status = 1;
		}
		
		//
		WGR_update_meta_post( $post_id, '_eb_product_chinhhang', $new_status );
		
		echo '<br>Dat S.Pham chinh hang: ' . $new_status;
	}
	// sản phẩm nổi bật
	else if ( isset( $_GET['current_sticky'] ) ) {
		
		$arr_stick = get_option( 'sticky_posts' );
//		print_r( $arr_stick );
		
		//
		$new_stick = array();
		
		// nếu đang được đánh dấu -> xóa đánh dấu
		if ( in_array( $post_id, $arr_stick ) ) {
//		if ( (int) $_GET['current_sticky'] == 1 ) {
			foreach ( $arr_stick as $v ) {
				if ( $v != $post_id ) {
					$new_stick[] = $v;
				}
			}
		}
		// mặc định thì thêm sản phẩm này vào đánh dấu
		else {
			$arr_stick[] = $post_id;
			$new_stick = $arr_stick;
		}
//		print_r( $new_stick );
		
		//
		update_option( 'sticky_posts', $new_stick );
		
	}
	// cập nhật lại giá
	else if ( isset( $_GET['new_price'] ) && $type == 'update_price' ) {
		$old_price = trim( $_GET['old_price'] );
		$new_price = trim( $_GET['new_price'] );
		
		//
		WGR_update_meta_post( $post_id, '_eb_product_oldprice', $old_price );
		if ( $old_price <= 0 ) {
			delete_post_meta( $post_id, '_eb_product_oldprice' );
		}
		
		//
		WGR_update_meta_post( $post_id, '_eb_product_price', $new_price );
		if ( $new_price <= 0 ) {
			delete_post_meta( $post_id, '_eb_product_price' );
		}
		
		//
		echo '<br>Cập nhật giá cho sản phẩm: ' . $old_price . ' - ' . $new_price;
	}
	else {
		echo '<br>method not found';
	}
	
	//
	if ( count( $arr_for_update_post ) > 0 ) {
		$arr_for_update_post['ID'] = $post_id;
//		print_r( $arr_for_update_post );
		
		// chạy lệnh cập nhật
		$update_id = WGR_update_post( $arr_for_update_post, 'ERROR!' );
	}
	
}



