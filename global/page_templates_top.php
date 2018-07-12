<?php



// thiết lập tiêu đề theo mẫu chung
if ( $__cf_row['cf_set_link_for_h1'] == 1 ) {
	$trv_h1_tieude = '<a href="' . _eb_p_link( $post->ID ) . '" rel="nofollow">' . $post->post_title . '</a>';
}
else {
	$trv_h1_tieude = $post->post_title;
}




ob_start();
