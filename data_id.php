<?php






$add_data_id = array (
		'date_time' => date_time,
//		'check_lazyload' => $check_lazyload,
//		'web_link' => '\'' . web_link . '\'',
		'base_url_href' => '\'' . web_link . '\'',
		'web_name' => '\'' . _eb_str_block_fix_content ( web_name ) . '\'',
		'wp_content' => '\'' . EB_DIR_CONTENT . '\'',
		
		'lang_taikhoan' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('taikhoan') ) . '\'',
		'lang_thoat' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('thoat') ) . '\'',
		'lang_xacnhan_thoat' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('xacnhan_thoat') ) . '\'',
		'lang_dangnhap' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('dangnhap') ) . '\'',
		'lang_dangky' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('dangky') ) . '\'',
		
		'lang_order_by' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('order_by') ) . '\'',
		'lang_order_view' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('order_view') ) . '\'',
		'lang_order_price_down' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('order_price_down') ) . '\'',
		'lang_order_price_up' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('order_price_up') ) . '\'',
		'lang_order_az' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('order_az') ) . '\'',
		'lang_order_za' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('order_za') ) . '\'',
		
		'lang_details_time_discount' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('post_time_discount') ) . '\'',
		'lang_details_time_soldout' => '\'' . _eb_str_block_fix_content ( EBE_get_lang('post_time_soldout') ) . '\'',
		
//		'service_name' => '\'' . $service_name . '\'',
//		'co_quick_register' => '\'c_quick_register\'',
		'isLogin' => $mtv_id,
		'uEmail' => '\'' . $mtv_email . '\'',
		'eb_wp_post_type' => '\'' . $eb_wp_post_type . '\'',
		'logout_url' => '\'' . ( $mtv_id > 0 ? wp_logout_url( eb_web_protocol . ':' . _eb_full_url() ) : '' ) . '\'',
//		'cf_categories_url' => $cf_categories_url,
		'parent_cid' => $parent_cid,
		'cid' => $cid,
//		'sid' => $sid,
//		'fid' => $fid,
		'pid' => $pid,
		'eb_product_price' => $eb_product_price,
		
		// chế độ kiểm thử -> dùng để console lỗi nếu chế độ này đang bật
//		'cf_tester_mode' => $__cf_row['cf_tester_mode'],
		'cf_tester_mode' => '\'' . $__cf_row['cf_tester_mode'] . '\'',
		
		// tự động submit trong phần tìm kiếm nâng cao
		'cf_search_advanced_auto_submit' => '\'' . $__cf_row['cf_search_advanced_auto_submit'] . '\'',
		
		// chiều rộng khung
		'cf_blog_class_style' => '\'' . $__cf_row['cf_blog_class_style'] . '\'',
		'cf_post_class_style' => '\'' . $__cf_row['cf_post_class_style'] . '\'',
		
		'cf_gg_api_key' => '\'' . $__cf_row['cf_gg_api_key'] . '\'',
		'cf_current_sd_price' => '\'' . $__cf_row['cf_current_sd_price'] . '\'',
		
		// nút chuyển ảnh trên slider
		'cf_arrow_big_banner' => '\'' . $__cf_row['cf_arrow_big_banner'] . '\'',
		'cf_slider_big_play' => $__cf_row['cf_slider_big_play'],
		
		// chế độ chuyển slider cho trang chi tiết
		'cf_details_right_thumbnail' => ( $__cf_row['cf_details_right_thumbnail'] == 1 || $__cf_row['cf_details_left_thumbnail'] ) ? 1 : 0,
		
		'cf_details_show_list_next' => '\'' . $__cf_row['cf_details_show_list_next'] . '\'',
		'cf_details_show_list_thumb' => '\'' . $__cf_row['cf_details_show_list_thumb'] . '\'',
		
		'cf_post_index_content' => '\'' . $__cf_row['cf_post_index_content'] . '\'',
		
//		'tid' => $tid,
//		'url_for_cat_js' => '\'' . $url_for_cat_js . '\'' ,
		'act' => '\'' . $act . '\'' 
);
$data_id = '';
foreach ( $add_data_id as $k => $v ) {
	$data_id .= ',' . $k . '=' . $v;
}



//
echo 'var ' . $cache_data_id . $data_id . ';';
//echo 'var ' . $cache_data_id . 'aaaaaaaaaaaaaaaa' . implode( ',', $add_data_id ) . ';';
//$data_id = 'var ' . $cache_data_id . $data_id . ',site_group=[' . $site_group . '],brand_group=[' . $brand_group . '],city_group=[],arr_blog_group=[' . $js_blg_id . '];';


//
/*
$data_id .= '
</script>
<script type="text/javascript" src="' .$url_for_cat_js. '"></script>
<script type="text/javascript">
';
*/



