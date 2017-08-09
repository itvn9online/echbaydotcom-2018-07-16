<?php



$term_id = isset( $_GET['term_id'] ) ? (int)$_GET['term_id'] : 0;
$by_taxonomy = isset( $_GET['by_taxonomy'] ) ? trim( $_GET['by_taxonomy'] ) : 'category';




if ( $term_id > 0 && $type != '' ) {
	
	// thay đổi STT sản phẩm
	if ( isset( $_GET['stt'] ) ) {
		$new_stt = (int) $_GET['stt'];
		
		if ( $type == 'auto' ) {
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
		update_post_meta( $term_id, '_eb_category_order', $new_stt );
	}
	
}



