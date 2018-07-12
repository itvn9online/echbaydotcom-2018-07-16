<?php



//
if ( mtv_id > 0 ) {
	$__cf_row ['cf_title'] = EBE_get_lang('pr_doimatkhau');
	$group_go_to[] = ' <li><a href="./profile" rel="nofollow">' . EBE_get_lang('taikhoan') . '</a></li>';
	$group_go_to[] = ' <li><a href="./password" rel="nofollow">' . $__cf_row ['cf_title'] . '</a></li>';
	
	
	//
	$main_content = EBE_str_template( 'password.html', array(
		'tmp.css_link' => str_replace( ABSPATH, web_link, EB_THEME_PLUGIN_INDEX ),
		
		'tmp.pr_short_matkhau' => EBE_get_lang('pr_short_matkhau'),
		'tmp.pr_matkhau' => EBE_get_lang('pr_matkhau'),
		'tmp.pr_doimatkhau' => EBE_get_lang('pr_doimatkhau'),
		'tmp.pr_capnhat' => EBE_get_lang('pr_capnhat')
	), EB_THEME_PLUGIN_INDEX . 'html/' );
}
else {
	// không được include file 404 -> vì sẽ gây lỗi vòng lặp liên tọi
	$main_content = '<br><h1 class="text-center">Permission ERROR!</h1><br>';
}


