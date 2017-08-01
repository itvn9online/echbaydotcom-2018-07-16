



//
function xu_ly_du_lieu_js(fun) {
	/*
	fun = fun.replace(/<!--\s-->/g, "");
	fun = fun.replace(/<!--\s\s-->/g, "");
	fun = fun.replace(/<!--\s\s\s-->/g, "");
	*/
	
	// optimize code
	fun = fun.replace( / type=\"text\/javascript\"/gi, '' );
	fun = fun.replace( / type=\'text\/javascript\'/gi, '' );
	
	//
	var arr = fun.split("\n"),
		str = '',
		re = /^\w+$/,
		ky_tu_cuoi_cung = '';
	for (var i = 0; i < arr.length; i++) {
		arr[i] = $.trim(arr[i]);
		
		//
		if ( arr[i] != '' ) {
			// remove comment
			if ( arr[i].substr( 0, 4 ) == '<!--' && arr[i].substr( arr[i].length - 3 ) == '-->' ) {
			}
			else if ( arr[i].substr( 0, 2 ) == '/*' && arr[i].substr( arr[i].length - 2 ) == '*/' ) {
			}
			// accept code
			else if ( arr[i].substr(0, 2) != '//' ) {
				
				/*
				if (arr[i].substr(0, 4) == '<!--') {
					if (arr[i].substr(arr[i].length - 3) == '-->') {
						arr[i] = '';
					}
				}
				*/
//				if (arr[i] != '') {
					str += arr[i];
//					str += "\n";
//				}
				
				//
				ky_tu_cuoi_cung = arr[i].substr( arr[i].length - 1 );
				if ( ky_tu_cuoi_cung != ';' ) {
//					console.log( ky_tu_cuoi_cung );
//				} else {
//					console.log( ky_tu_cuoi_cung+ ' ------------------> OK' );
					str += "\n";
				}
			}
		}
	}
	return str;
}

function check_update_config_theme () {
	return true;
}

function check_update_config() {
	
	var f = document.frm_config;
	
	var fun = f.cf_js_allpage_full.value,
		js_hoantat = f.cf_js_hoan_tat_full.value,
		js_head = f.cf_js_head_full.value;
	
	var str = xu_ly_du_lieu_js(fun),
		str_hoantat = xu_ly_du_lieu_js(js_hoantat),
		str_head = xu_ly_du_lieu_js(js_head);
	
	f.cf_js_allpage.value = str;
	f.cf_js_hoan_tat.value = str_hoantat;
	f.cf_js_head.value = str_head;
	
	//
	console.log(str);
	console.log(str_hoantat);
	console.log(str_head);
	
	//
	if ( $.trim( f.cf_dns_prefetch.value ) != '' ) {
		var a = f.cf_dns_prefetch.value.split('//');
//		console.log( a.length );
		
		if ( a.length > 1 ) {
			a = a[1];
		} else {
			a = a[0];
		}
		
		f.cf_dns_prefetch.value = a.split('/')[0];
	}
	
	
	//
	create_phone_click_to_call();
	create_deault_css();
	
	//
//	return false;
	return true;
}


function create_deault_css () {
	var str = '',
		f = document.frm_config,
		a = '';
	
	
	// màu nền của AMP chính là màu nền cơ bản
	$('#cf_default_amp_bg').val( $('#cf_default_bg').val() || '' );
	
	
	// chiều cao của big_banner -> chỉ áp dụng cho bản PC
	a = f.cf_top_banner_size.value.split('/')[0];
	a -= Math.ceil(a/ 8);
	str += '.oi_big_banner {height: ' + a + 'px;line-height: ' + a + 'px;}';
	
	// table
	a = Math.ceil(a/ 2);
	str += '@media screen and (max-width:775px) { .oi_big_banner {height: ' + a + 'px;line-height: ' + a + 'px;} }';
	
	// mobile
	a = Math.ceil(a/ 2);
	str += '@media screen and (max-width:350px) { .oi_big_banner {height: ' + a + 'px;line-height: ' + a + 'px;} }';
	
	
	// body
	a = f.cf_default_body_bg.value;
	str += 'body { background-color: ' + a + '; }';
	
	// text color
	a = f.cf_default_color.value;
	str += '.default-color, .mcb { color: ' + a + '; }';
	
	// link color
	a = f.cf_default_link_color.value;
	str += 'a { color: ' + a + '; }';
	
	// button, menu, default bg
	a = f.cf_default_bg.value;
	str += '.default-bg, .thread-home-c2 a:first-child, #oi_scroll_top { background-color: ' + a + '; }';
	str += '.div-search, .thread-home-c2, .echbay-widget-title:before { border-color: ' + a + '; }';
//	str += '.thread-home-c2 { border-bottom-color: ' + a + '; }';
	
	// button, menu 2
	a = f.cf_default_2bg.value;
	str += '.default-2bg, #oi_scroll_top:hover { background-color: ' + a + '; }';
	
	// text color (button, menu)
	a = f.cf_default_bg_color.value;
	str += '.default-bg, .default-bg a { color: ' + a + '; }';
	
	// text color (button, menu)
	if ( dog('cf_on_off_echbay_logo').checked == false ) {
		str += '.powered-by-echbay { display: none; }';
	}
	
	//
	$('#cf_default_css').val(str);
}

// tạo số điện thoại dưới dạng HTML
function create_phone_click_to_call () {
	
	var f = document.frm_config;
	
	// điện thoại
	var a = $.trim( f.cf_dienthoai.value ),
		str = '';
	if ( a != '' ) {
		a = a.split("\n");
		
		for ( var i = 0; i < a.length; i++ ) {
			a[i] = $.trim( a[i] );
			
			if ( a[i] != '' ) {
				str += '<a href="tel:' + g_func.number_only( a[i] ) + '" rel="nofollow">' + a[i] + '</a>' + "\n";
			}
		}
	}
	f.cf_call_dienthoai.value = $.trim( str );
	
	// hotline
	var a = $.trim( f.cf_hotline.value ),
		str = '';
	if ( a != '' ) {
		a = a.split("\n");
		
		for ( var i = 0; i < a.length; i++ ) {
			a[i] = $.trim( a[i] );
			
			if ( a[i] != '' ) {
				str += '<a href="tel:' + g_func.number_only( a[i] ) + '" rel="nofollow">' + a[i] + '</a>' + "\n";
			}
		}
	}
	f.cf_call_hotline.value = $.trim( str );
	
}

//
if ( $('#cf_call_dienthoai').val() == '' || $('#cf_call_hotline').val() == '' ) {
	create_phone_click_to_call();
}




function config_test_send_mail() {
	var f = document.frm_config,
		from = f.cf_smtp_email.value,
		pass = f.cf_smtp_pass.value,
		host = f.cf_smtp_host.value,
		to = f.cf_email.value;
	if (from != '' && pass != '' && host != '' && to != '') {
		dog('test_smtp_email', 'Đang tải...');
		$('#test_smtp_email').show();
//		ajaxl('guest.php?act=test_smtp_email&t_email=' + to, 'test_smtp_email', 1);
	} else {
		alert('Nhập đầy đủ Email, Host, Pass để thử');
		f.cf_smtp_email.focus();
	}
}



//
//func_preview_cf_logo();
//fix_textarea_height();





/*
* Định vị vị trí trụ sở chính của website
*/
function click_get_user_position () {
	var f = document.frm_config;
	
	//
	f.cf_region.value = '';
	f.cf_placename.value = '';
	f.cf_position.value = '';
//	f.cf_content_language.value = '';
	
	//
	auto_get_user_position();
}

//
auto_get_user_position();





/*
* Bật tắt chế độ lưu trữ dữ liệu qua JSON
*/
function click_on_off_eb_cf_json ( key, val ) {
	console.log(key);
	
	var str = '';
	
	if ( val == 1 ) {
		str = $('label[for="' + key + '"]').attr('data-off') || '';
	}
	else {
		str = $('label[for="' + key + '"]').attr('data-on') || '';
	}
	$('label[for="' + key + '"]').html( str );
}

function show_note_for_checkbox_config ( key ) {
	console.log(key);
	
	$('#' + key).click(function () {
		if ( dog(key).checked == true ) {
			$(this).val( 1 );
		} else {
			$(this).val( 0 );
		}
		
		//
		click_on_off_eb_cf_json( key, $(this).val() );
	});
	
	//
	if ( $('#' + key).val() == 1 ) {
		dog(key).checked = true;
	}
	
	click_on_off_eb_cf_json( key, $('#' + key).val() );
}


// config
if ( current_module_config != 'config_theme' ) {
	show_note_for_checkbox_config( 'cf_tester_mode' );
	show_note_for_checkbox_config( 'cf_on_off_json' );
	show_note_for_checkbox_config( 'cf_on_off_xmlrpc' );
	show_note_for_checkbox_config( 'cf_remove_category_base' );
	show_note_for_checkbox_config( 'cf_on_off_echbay_seo' );
	show_note_for_checkbox_config( 'cf_on_off_echbay_logo' );
	
	show_note_for_checkbox_config( 'cf_on_off_amp_logo' );
	show_note_for_checkbox_config( 'cf_on_off_amp_category' );
	show_note_for_checkbox_config( 'cf_on_off_amp_product' );
	show_note_for_checkbox_config( 'cf_on_off_amp_blogs' );
	show_note_for_checkbox_config( 'cf_on_off_amp_blog' );
	show_note_for_checkbox_config( 'cf_on_off_auto_update_wp' );
	show_note_for_checkbox_config( 'cf_disable_auto_get_thumb' );
	show_note_for_checkbox_config( 'cf_set_link_for_h1' );
	show_note_for_checkbox_config( 'cf_hide_supper_admin_menu' );
	show_note_for_checkbox_config( 'cf_set_news_version' );
	show_note_for_checkbox_config( 'cf_echbay_migrate_version' );
	show_note_for_checkbox_config( 'cf_global_big_banner' );
}
// config_theme
else {
	show_note_for_checkbox_config( 'cf_details_show_list_next' );
}





//
$('input[name=cf_position]').off('change').change(function () {
	var a = $(this).val() || '';
	
	if ( a != '' ) {
		// chuẩn hóa dữ liệu đầu vào
		
		// nếu người dùng nhập từ url
		a = a.split( '@' );
		if ( a.length > 1 ) {
			a = a[1];
		}
		else {
			a = a[0];
		}
		
		//
		a = a.replace( ';', ',' );
		
		// chỉ lấy 2 tọa độ
		a = a.split( ',' );
		if ( a.length > 1 ) {
			a = a[0] + ',' + a[1];
			
			dog( 'mapholder', create_img_gg_map ( a ) );
		}
		// dữ liệu sai -> xóa trắng
		else {
			a = '';
		}
		
		//
		$('input[name=cf_position]').val( a );
	}
});





//
$('#oi_smtp_pass').off('focus').focus(function () {
	$(this).attr({
		type : 'password'
	}).val( $('input[name=cf_smtp_pass]').val() );
}).off('blur').blur(function () {
	var a = $(this).val() || '',
		str = '';
	
	if ( a != '' ) {
		for ( var i = 0; i < a.length; i++ ) str += '*';
	}
	
	//
	$(this).attr({
		type : 'text'
	}).val( str );
}).off('keyup').keyup(function () {
	$('input[name=cf_smtp_pass]').val( $(this).val() || '' );
}).blur();



//
(function () {
	
	// hiển thị module config tương ứng
	$('.show-if-module-' + current_module_config).show();
	
	//
	var str = '';
	// eb-admin-config-tab
	// eb-admin-config_theme-tab
	$('.eb-admin-' + current_module_config + '-tab').each(function() {
		var i = $(this).attr('id') || '',
			tit = $(this).attr('title') || '';
		
		str += '<li data-id="' +i+ '" data-tab="' + i.replace('eb-admin-config-', '') + '">' + tit + '</li>';
	});
	
	$('#list-tab-eb-admin-config').html( str );
	
	$('#list-tab-eb-admin-config li').click(function () {
		var a = $(this).attr('data-id') || '',
			tab = $(this).attr('data-tab') || '';
		if ( a != '' ) {
			$('.eb-admin-hide-config-tab').hide();
			$('#' + a).show();
			
			//
			$('#list-tab-eb-admin-config li').removeClass('selected');
			$(this).addClass('selected');
			
			window.history.pushState( "", '', window.location.href.split('&tab=')[0] + '&tab=' + tab );
		}
	});
	
	var a = window.location.href.split('&tab=');
	if ( a.length > 1 ) {
		a = a[1].split('&')[0];
		console.log(a);
		
		$('.eb-admin-tab a[data-tab="' +a+ '"]').addClass('selected');
		$('#list-tab-eb-admin-config li[data-tab="' +a+ '"]').click();
	} else {
		$('#list-tab-eb-admin-config li:first').click();
	}
})();



//
eb_drop_menu('oi_select_timezone', cf_timezone);






//
/*
$('#cf_sys_email').click(function () {
	if ( dog('cf_sys_email').checked == true ) {
		$(this).val( 1 );
	} else {
		$(this).val( 0 );
	}
});

//
if ( $('#cf_sys_email').val() == 1 ) {
	dog('cf_sys_email').checked = true;
}
*/





// phần thiết lập thông số của size -> chỉnh về 1 định dạng
$('.fixed-size-for-config').change(function () {
	var a = $(this).val() || '';
	if ( a != '' ) {
		a = a.replace( /\s/g, '' );
		
		// nếu có dấu x -> chuyển về định dạng của Cao/ Rộng
		if ( a.split('x').length > 1 ) {
			a = a.split( 'x' );
			
			a = a[1] + '/' + a[0];
		}
		a = a.toString().replace(/[^0-9\/]/g, '');
		
		$(this).val( a );
	}
}).blur(function () {
	$(this).change();
});




//
$('.click-to-set-site-color').click(function () {
	var a = $(this).attr('data-set') || '';
	
	if ( a == '' ) {
		console.log('Color picker not found');
		return false;
	}
	
	var b = $('input[name="' + a + '"]').val() || $('input[name="' + a + '"]').attr('placeholder') || '';
	var n = prompt('Color code #:', b);
//	console.log(n);
	
	// cho về mã hiện tại nếu người dùng hủy hoặc không nhập màu
	if ( n == null || n == '' ) {
		n = b;
	}
	n = g_func.trim( n.replace( /\s/g, '' ) );
	if ( n == '' ) {
		n = b;
	}
	
	// bỏ dấu # ở đầu đi để định dạng lại
	if ( n.substr(0, 1) == '#' ) {
		n = n.substr(1);
	}
	
	// tự chuyển thành mã 6 màu nếu mã màu nhập vào là 3
	if ( n.length == 3 ) {
		n = n.substr(0, 1) + n.substr(0, 1) + n.substr(1, 1) + n.substr(1, 1) + n.substr(2, 1) + n.substr(2, 1);
	}
	
	// đến đây, mã màu bắt buộc phải là 6 ký tự
	if ( n.length != 6 ) {
		alert('Color code with 6 character');
		return false;
	}
	
	// done
	$('input[name="' + a + '"]').val( '#' + n );
});

$('.click-to-reset-site-color').click(function () {
	var a = $(this).attr('data-set') || '';
	
	if ( a == '' ) {
		console.log('Color picker not found');
		return false;
	}
	
	var b = $('input[name="' + a + '"]').attr('placeholder') || '';
	if ( b != '' ) {
		$('input[name="' + a + '"]').val( b );
	}
});





// các hàm chạy sau một chút
if ( current_module_config != 'config_theme' ) {
	
	$('.click-add-url-for-logo').click(function () {
		var a = $(this).attr('data-id') || '';
		if ( a != '' ) {
			var b = prompt('URL image:', '');
			if ( b != null && b != '' ) {
				EBA_add_img_logo( b, a );
			}
		}
	});
	
	//
	setTimeout(function () {
		EBA_preview_img_logo( dog('cf_logo').value, 'cf_logo' );
		EBA_preview_img_logo( dog('cf_favicon').value, 'cf_favicon' );
	}, 600);
}


