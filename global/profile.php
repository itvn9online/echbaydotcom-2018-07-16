<?php



//
if ( mtv_id > 0 ) {
	$__cf_row ['cf_title'] = EBE_get_lang('taikhoan');
	$group_go_to[] = ' <li><a href="./profile" rel="nofollow">' . $__cf_row ['cf_title'] . '</a></li>';
	
	
	//
	$arr_user_profile = get_userdata( mtv_id );
//	$arr_user_profile = get_currentuserinfo();
//	$arr_user_profile = get_user_by('id', mtv_id);
//	print_r( $arr_user_profile );
	
	//
	$arr_user_meta = get_user_meta(mtv_id);
//	print_r( $arr_user_meta );
	
	//
	$connect_admin = '';
	// nếu có quyền xóa bài viết -> có quyền admin rồi
	if ( current_user_can('delete_posts') ) {
		
		$connect_admin = web_link;
		
		// nếu đang sử dụng plugin EchBay Admin Security
		if ( class_exists ( 'EAS_Actions_Module' )) {
//			echo $EAS_func->eb_plugin_data;
			
			$connect_admin .= $EAS_func->eb_plugin_data;
		}
		// admin mặc định
		else {
			$connect_admin .= WP_ADMIN_DIR;
		}
		
		//
		$connect_admin = ' <a href="' . $connect_admin . '">@</a>';
	}
	
	//
	$tv_dienthoai = '';
	if ( isset( $arr_user_meta['phone'] ) ) {
		$tv_dienthoai = $arr_user_meta['phone'][0];
	}
	
	$tv_diachi = '';
	if ( isset( $arr_user_meta['address'] ) ) {
		$tv_diachi = $arr_user_meta['address'][0];
	}
	
	
	//
	$main_content = EBE_str_template( 'profile.html', array(
		'tmp.css_link' => str_replace( ABSPATH, web_link, EB_THEME_PLUGIN_INDEX ),
		
		'tmp.tv_email' => mtv_email,
		'tmp.connect_admin' => $connect_admin,
		'tmp.mtv_id' => mtv_id,
		'tmp.tv_hoten' => $arr_user_meta['first_name'][0],
		'tmp.tv_dienthoai' => $tv_dienthoai,
		'tmp.tv_diachi' => $tv_diachi,
		'tmp.tv_ngaydangky' => date( 'H:i:s d/m/Y', strtotime( $arr_user_profile->data->user_registered ) ),
		
		// lang
		'tmp.pr_tonquan' => EBE_get_lang('pr_tonquan'),
		'tmp.pr_email' => EBE_get_lang('pr_email'),
		'tmp.pr_id' => EBE_get_lang('pr_id'),
		'tmp.pr_matkhau' => EBE_get_lang('pr_matkhau'),
		'tmp.pr_doimatkhau' => EBE_get_lang('pr_doimatkhau'),
		'tmp.pr_hoten' => EBE_get_lang('pr_hoten'),
		'tmp.pr_dienthoai' => EBE_get_lang('pr_dienthoai'),
		'tmp.pr_diachi' => EBE_get_lang('pr_diachi'),
		'tmp.pr_ngaydangky' => EBE_get_lang('pr_ngaydangky'),
		'tmp.pr_capnhat' => EBE_get_lang('pr_capnhat')
	), EB_THEME_PLUGIN_INDEX . 'html/' );
}
else {
	// không được include file 404 -> vì sẽ gây lỗi vòng lặp liên tọi
	$main_content = '<br><h1 class="text-center">Permission ERROR!</h1><br>';
}


