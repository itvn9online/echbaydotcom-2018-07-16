<?php

// get custom content
$main_content = ob_get_contents();

//
ob_end_clean();




// nếu bài viết được đánh dấu để set noindex -> set thuộc tính noindex
if ( _eb_get_post_object( $post->ID, '_eb_product_noindex', 0 ) == 1 ) {
	$__cf_row ["cf_blog_public"] = 0;
}
/*
if ( mtv_id == 1 ) {
	print_r($post);
	print_r($__cf_row);
}
*/




// show content
include_once EB_THEME_URL . 'index.php';
