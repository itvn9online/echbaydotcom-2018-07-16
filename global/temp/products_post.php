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
				`" . $wpdb->posts . "`
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
	// thay đổi trạng thái ping với ping
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
		update_post_meta( $post_id, '_eb_product_noindex', $new_status );
		
		echo '<br>set index status: ' . $new_status;
	}
	else {
		echo '<br>method not found';
	}
	
	//
	if ( count( $arr_for_update_post ) > 0 ) {
		$arr_for_update_post['ID'] = $post_id;
//		print_r( $arr_for_update_post );
		
		// chạy lệnh cập nhật
		$update_id = wp_update_post( $arr_for_update_post, true );
		
		// nếu có lỗi thì trả về lỗi
		if ( is_wp_error($update_id) ) {
			$errors = $update_id->get_error_messages();
			foreach ($errors as $error) {
				echo $error . '<br>' . "\n";
			}
		}
	}
	
}



