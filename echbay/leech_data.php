<?php







/*
$a = wp_list_categories( array(
	'hide_empty' => 0,
	'echo' => 0,
	'style' => '<br>',
	'taxonomy' => 'category',
) );
print_r( $a );
*/

//
//$list_cat = _eb_categories_list_v3();
//echo $list_cat;




// chỉ coder mới được xem thông tin này
$main_content = EBE_str_template( 'html/leech_data.html', array(
	'tmp.list_cat' => _eb_categories_list_v3(),
	'tmp.list_blog_cat' => _eb_categories_list_v3( 't_blog_ant', EB_BLOG_POST_LINK ),
), ECHBAY_PRI_CODE );



