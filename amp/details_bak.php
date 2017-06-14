<?php


/*
* Loại bỏ các attr không cần thiết
*/
function eb_remove_attr_for_amp_content ( $str ) {
	
	//
	$arr = array(
		'id',
		'class',
		'style',
		'dir',
		'type',
		'border',
		'align',
		'longdesc',
	);
	
	//
//	$str = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $str);
	
	foreach ( $arr as $v ) {
		$str = eb_step2_remove_attr_for_amp_content( $str, ' ' . $v . '="', '"' );
		$str = eb_step2_remove_attr_for_amp_content( $str, " " . $v . "='", "'" );
	}
	
	
	
	// xóa các thẻ không còn được hỗ trợ
	$arr = array(
		'font',
	);
	
	//
	foreach ( $arr as $v ) {
		$str = eb_step2_remove_tag_for_amp_content( $str, $v );
	}
	
	
	
	//
	return $str;
}

function eb_step2_remove_attr_for_amp_content ( $str, $attr, $end_attr ) {
	$c = explode( $attr, $str );
//	print_r( $c );
	
	$new_str = '';
	foreach ( $c as $k => $v ) {
		if ( $k > 0 ) {
			$v = substr( strstr( $v, $end_attr ), 1 );
		}
		
		//
		$new_str .= $v;
	}
	
	return $new_str;
}



function eb_step2_remove_tag_for_amp_content ( $str, $tag ) {
	$c = explode( '<' . $tag, $str );
//	print_r( $c );
	
	$new_str = '';
	foreach ( $c as $k => $v ) {
		if ( $k > 0 ) {
//			echo $v . "\n";
//			echo strstr( $v, '>' ) . "\n";
//			echo substr( strstr( $v, '>' ), 1 ) . "\n";
			
			//
			$v = substr( strstr( $v, '>' ), 1 );
		}
		
		//
		$new_str .= $v;
	}
	
	// xóa thẻ đóng
	$new_str = str_replace( '</' . $tag . '>', '', $new_str );
	
	//
	return $new_str;
}




/*
* Chuyển các tag không được hỗ trợ về tag mới
*/
function eb_replace_tag_for_amp_content ( $str ) {
	
	$arr = array(
		'img' => 'amp-img',
		'iframe' => 'amp-iframe',
	);
	
	foreach ( $arr as $k => $v ) {
		$str = eb_step2_replace_tag_for_amp_content( $str, $k, $v );
	}
	
	//
	$str = str_replace( '</iframe>', '', $str );
	
	//
	return $str;
	
}

function eb_step2_replace_tag_for_amp_content ( $str, $tag, $new_tag, $end_tag = '>' ) {
//	global $func;
	global $other_amp_cdn;
	
	//
	$c = explode( '<' . $tag . ' ', $str );
//	print_r( $c );
	
	$new_str = '';
	foreach ( $c as $k => $v ) {
		if ( $k > 0 ) {
			$v2 = explode( '>', $v );
			$v2 = $v2[0];
//			echo $v2. "\n";
//			echo substr( $v2, -1 ) . "\n";
//			echo substr( $v2, 0, -1 ) . "\n";
			
			// xóa đoạn
			$v = str_replace( $v2, '', $v );
			$v = substr( $v, 1 );
			
			//
			if ( substr( $v2, -1 ) == '/' ) {
				$v2 = substr( $v2, 0, -1 );
			}
			$v2 = trim($v2);
			
			// riêng với video
			if ( strstr( $v2, 'youtube.com/' ) == true ) {
//				echo $v2 . "\n";
				$v2 = explode( 'src="', $v2 );
				$v2 = $v2[1];
				$v2 = explode( '"', $v2 );
				$v2 = $v2[0];
//				echo $v2 . "\n";
				$v2 = _eb_get_youtube_id( $v2 );
//				echo $v2 . "\n";
				
				$v2 = 'data-videoid="' . $v2 . '" layout="responsive" width="480" height="270"';
				$new_tag = 'amp-youtube';
				
				// tải cdn cho youtube
				$other_amp_cdn['youtube'] = '';
			}
			// với hình ảnh, nếu thiếu layout thì 
			else if ( $new_tag == 'amp-img' ) {
				if ( strstr( $v2, ' width=' ) == false ) {
					$v2 .= ' width="400"';
				}
				if ( strstr( $v2, ' height=' ) == false ) {
					$v2 .= ' height="400"';
				}
				
				// thêm class để resize ảnh
				$v2 .= ' class="amp-wp-enforced-sizes" sizes="(min-width: 600px) 600px, 100vw"';
			}
			
			//
			$v = '<' . $new_tag . ' ' . $v2 . '></' . $new_tag . '>' . $v;
		}
		
		//
		$new_str .= $v;
	}
	
	return $new_str;
}




// sử lý nội dung
$trv_noidung = $post->post_content;





//
$amp_avatar_top = '';

// nếu có video -> lấy video
$_eb_product_video_url = _eb_get_post_meta( $pid, '_eb_product_video_url', true );
if ( $_eb_product_video_url != '' ) {
	$amp_avatar_top = '<div><iframe src="' . $_eb_product_video_url . '" width="600" height="400" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div><br>';
	
	// tải cdn cho youtube
	$other_amp_cdn['youtube'] = '';
}
// nếu không có video -> lấy ảnh đại diện
else if ( $_eb_product_video_url == '' ) {
	$amp_avatar_top = '<div><img src="' . $trv_img . '" width="400" height="400" /></div><br>';
}

//
$trv_noidung = $amp_avatar_top . $trv_noidung;






// điều chỉnh lại nội dung theo chuẩn AMP
$trv_noidung = eb_remove_attr_for_amp_content( $trv_noidung );

//
$trv_noidung = eb_replace_tag_for_amp_content( $trv_noidung );




// bài xem nhiều
$args_other_blog = array(
	'post_type' => EB_BLOG_POST_TYPE,
	'offset' => 0,
	'tax_query' => array(
		array(
			'taxonomy' => EB_BLOG_POST_LINK,
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
	<h1 class="amp-wp-title">' . $post->post_title . '</h1>
	<div>' . date( 'd/m/Y H:i', strtotime( $post->post_modified ) ) . '</div>
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



