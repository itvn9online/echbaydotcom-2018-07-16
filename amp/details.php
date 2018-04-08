<?php


// sử lý nội dung
$trv_noidung = $__post->post_content;





// thêm hình ảnh hoặc video vào nội dung
$amp_avatar_top = '';

// nếu có video -> lấy video
$_eb_product_video_url = _eb_get_post_meta( $pid, '_eb_product_video_url', true );
if ( $_eb_product_video_url != '' ) {
	$amp_avatar_top = '<div><iframe src="' . $_eb_product_video_url . '" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div><br>';
}
// nếu không có video -> lấy ảnh đại diện
else if ( $trv_img != '' ) {
	
	//
	$amp_avt_size = $eb_amp->img_size( $trv_img );
	
	//
	$amp_avt_width = $amp_avt_size[0];
	$amp_avt_height = $amp_avt_size[1];
	
	//
	$amp_avatar_top = '<div><img src="' . $trv_img . '" width="' . $amp_avt_width . '" height="' . $amp_avt_height . '" /></div><br>';
}

//
$trv_noidung = $amp_avatar_top . $trv_noidung;






/*
* điều chỉnh lại nội dung theo chuẩn AMP
*/

// Loại bỏ các attr không cần thiết và tag không được hỗ trợ
$trv_noidung = $eb_amp->amp_remove_attr ( $trv_noidung );

// thay thế các tag cũ bằng tag mới
$trv_noidung = $eb_amp->amp_change_tag ( $trv_noidung );




// bài xem nhiều
$args_other_blog = array(
//	'post_type' => EB_BLOG_POST_TYPE,
	'post_type' => $__post->post_type,
	'offset' => 0,
	'tax_query' => array(
		array(
			'taxonomy' => $__post->post_type == EB_BLOG_POST_TYPE ? EB_BLOG_POST_LINK : 'category',
			'terms' => $ant_id,
		)
	),
);





// cây menu (nếu có)
$amp_str_go_to = '';
if ( isset( $post_categories[0] ) ) {
	foreach($post_categories as $c){
		$cat = get_term( $c );
		
		//
		$cats[] = $cat;
		
		$amp_str_go_to .= ' &raquo; <a href="' . _eb_c_link($cat->term_id) . '">' . $cat->name . '</a>';
	}
}





// tổng hợp nội dung
$amp_content = '
<header class="amp-wp-article-header">
	<h1 class="amp-wp-title"><a href="' . _eb_p_link( $pid ) . '">' . $__post->post_title . '</a></h1>
	<div>' . date( 'd/m/Y H:i', strtotime( $__post->post_modified ) ) . '</div>
</header>
<div class="amp-wp-article-content">
	' . $trv_noidung . '
</div>
<br>
<h2>Bài cùng chuyên mục</h2>
<ul class="amp-related-posts">
	' . _eb_load_post( 10, $args_other_blog, '<li><a href="{tmp.p_link}">{tmp.trv_tieude}</a></li>' ) . '
</ul>
<br>';



