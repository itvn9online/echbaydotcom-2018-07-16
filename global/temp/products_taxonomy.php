<?php



$term_id = isset( $_GET['term_id'] ) ? (int)$_GET['term_id'] : 0;
$by_taxonomy = isset( $_GET['by_taxonomy'] ) ? trim( $_GET['by_taxonomy'] ) : 'category';




if ( $term_id > 0 && $type != '' ) {
	
	// thay đổi STT sản phẩm
	if ( isset( $_GET['stt'] ) ) {
		$new_stt = (int) $_GET['stt'];
		
		if ( $type == 'auto' ) {
//			echo wp_termmeta . '<br>' . "\n";
			
			//
			$sql = _eb_q("SELECT *
			FROM
				`" . wp_termmeta . "`
			WHERE
				meta_key = '_eb_category_order'
				AND term_id != " . $term_id . "
			ORDER BY
				meta_value DESC
			LIMIT 0, 1");
			/*
			$sql = _eb_q("SELECT *
			FROM
				" . wp_postmeta . "
			WHERE
				meta_key = '_eb_category_order'
				AND post_id != " . $term_id . "
			ORDER BY
				meta_value DESC
			LIMIT 0, 1");
			*/
//			print_r( $sql );
			
			//
			if ( isset( $sql[0] ) ) {
				$new_stt = $sql[0]->meta_value + 1;
			}
		}
		else if ( $type == 'up' ) {
			$new_stt ++;
		}
		else if ( $type == 'down' ) {
			$new_stt --;
			if ($new_stt < 0) {
				$new_stt = 0;
			}
		}
//		echo $new_stt . '<br>' . "\n";
//		echo $term_id . '<br>' . "\n";
		
		//
//		WGR_update_meta_post( $term_id, '_eb_category_order', $new_stt );
		update_term_meta( $term_id, '_eb_category_order', $new_stt );
		
		echo '<br>set category order: ' . $new_stt;
	}
	// đặt làm phân nhóm chính
	else if ( isset( $_GET['current_primary'] ) ) {
		$new_value = 0;
		if ( $_GET['current_primary'] == 0 ) {
			$new_value = 1;
		}
		
		//
//		WGR_update_meta_post( $term_id, '_eb_category_primary', $new_value );
		update_term_meta( $term_id, '_eb_category_primary', $new_value );
		
		echo '<br>set category primary: ' . $new_value;
	}
	// cho phép bot lập chỉ mục
	else if ( isset( $_GET['current_index'] ) ) {
		$new_value = 0;
		if ( $_GET['current_index'] == 0 ) {
			$new_value = 1;
		}
		
		//
		update_term_meta( $term_id, '_eb_category_noindex', $new_value );
		
		echo '<br>set category index: ' . $new_value;
	}
	// ẩn hoặc hiện nhóm
	else if ( isset( $_GET['current_hidden'] ) ) {
		$new_value = 0;
		if ( $_GET['current_hidden'] == 0 ) {
			$new_value = 1;
		}
		
		//
		update_term_meta( $term_id, '_eb_category_hidden', $new_value );
		
		echo '<br>set category hidden: ' . $new_value;
	}
	// đổi nhóm cha
	else if ( isset( $_GET['current_parent'], $_GET['new_parent'] ) ) {
		if ( $term_id != $_GET['new_parent'] && $_GET['current_parent'] != $_GET['new_parent'] ) {
			wp_update_term($term_id, $by_taxonomy, array(
				'parent' => (int) $_GET['new_parent']
			));
			
			echo '<br>set category parent: ' . $_GET['new_parent'];
		}
	}
	else {
		echo '<br>method not found';
	}
	
	// xóa cache đi để nó nhận dữ liệu ngay khi update
	$arr_object_post_meta = array();
	
}



