



// thu gọn menu của wordpress -> để tăng kích thước cho khung thiết kế
//$('body').addClass('folded');




// Tham số dùng để xác định xem file được add vào mục nào
var id_for_set_new_include_file = '',
	// tạo key cho phần quick search
	load_key_for_quick_serach = false;



function check_create_theme () {
	
	if ( confirm('Xác nhận tạo theme') == false ) {
		return false;
	}
	
	return true;
}


function EBE_themes_key_quick_search () {
	if ( load_key_for_quick_serach == false ) {
		load_key_for_quick_serach = true;
		
		$('.for-themes-quick-search').each(function() {
			var a = $(this).attr('data-key') || '',
				b = $(this).attr('data-tags') || '';
//			console.log(a);
//			console.log(b);
			
			if ( a != '' ) {
				a = g_func.non_mark_seo( a.split('.')[0] );
				a = a.replace(/\-/g, '');
				
				b = g_func.non_mark_seo( b.split('.')[0] );
				b = b.replace(/\-/g, '');
				
				$(this).attr({
					'data-search' : a + b
				});
			}
		});
	}
}


function WGR_show_temp_if_using_module ( chech, sau ) {
	
	//
	show_note_for_checkbox_config( chech );
	
	//
	$('#' + chech).click(function () {
		if ( dog(chech).checked == true ) {
			$('.' + sau).show();
		} else {
			$('.' + sau).hide();
		}
	});
	
	if ( dog(chech).checked == true ) {
		$('.' + sau).show();
	} else {
		$('.' + sau).hide();
	}
	
}

//
WGR_show_temp_if_using_module( 'cf_using_top_default', 'show-if-using-top-default' );
WGR_show_temp_if_using_module( 'cf_using_footer_default', 'show-if-using-footer-default' );
WGR_show_temp_if_using_module( 'cf_using_home_default', 'show-if-using-home-default' );
WGR_show_temp_if_using_module( 'cf_using_cats_default', 'show-if-using-cats-default' );




// đổi hiệu ứng slected khi người dụng chọn design
$('.click-add-class-selected').click(function () {
	var a = $(this).attr('data-key') || '',
		img = $(this).attr('data-img') || '',
		val  = $(this).attr('data-val') || '',
		size = $(this).attr('data-size') || '',
		type = $(this).attr('data-type') || '';
	
//	console.log( a );
//	console.log( type );
//	console.log( img );
//	console.log( val );
	
	if ( a != '' ) {
//		$('.click-add-class-selected[data-key="' + a + '"]').removeClass('selected');
		$('.click-add-class-selected').removeClass('selected');
		$(this).addClass('selected');
		
		// mặc định nạp lần đầu (auto click) -> lấy theo A
//		var jPro = $('.click-to-change-file-design[data-key="' + a + '"]');
//		var jPro = '.click-to-change-file-design[data-name="' + type + '"]';
		var jPro = '.click-to-change-file-design[data-val="' + val + '"]';
		
		// khi người dùng click thì lấy theo ID đã được click
		if ( id_for_set_new_include_file != '' ) {
			jPro = '.click-to-change-file-design[data-key="' + id_for_set_new_include_file + '"]';
		}
//		console.log( jPro );
//		console.log( $(jPro).length );
//		$(jPro).html('aaaaaaaaaa'); return false;
		
		$(jPro).css({
			'background-image' : 'url(\'' + img + '\')'
		});
		
//		if ( val == '' && img == '' ) {
		if ( img == '' ) {
//			console.log( $(this).attr('title') );
			
			$(jPro)
//			.hide()
			.html( $(this).attr('title') )
			.height('auto')
			.addClass('bold')
			;
		}
		else {
			$(jPro)
//			.show()
			.html( '&nbsp;' )
			.attr({
				'data-size' : size
			})
			;
			
			if ( size != '' ) {
				$(jPro).height( $(jPro).width() * eval(size) );
			}
		}
		
		//
//		console.log( val );
//		console.log( type );
		
		// nếu là click thủ công -> nạp giá trị mới
		if ( id_for_set_new_include_file != '' ) {
			$( '#' + $(jPro).attr('data-name') ).val( val );
		}
	}
});

// chạy riêng với function trên cho nó chuẩn chỉ, đỡ lỗi
$('.click-add-class-selected').each(function () {
	
	// tạo key để tìm kiếm nhanh
	var a = $(this).attr('data-val') || '';
	if ( a != '' ) {
		$(this).attr({
			'data-search': a.split('-')[0]
		});
	}
	
	/* v1
	var a = $('input[type="radio"]', this).attr('id') || '';
	if ( a != '' ) {
		if ( dog( a ).checked == true ) {
			$(this).click();
		}
	}
	*/
});

// v2
$('.each-to-get-current-value-file').each(function() {
	var a = $(this).val() || '',
		b = $(this).attr('name') || '',
		key = $(this).attr('data-key') || '';
	
	// Nếu có giá trị -> đã có file được chọn
	if ( a != '' ) {
//		console.log(a);
//		console.log(b);
		
		// Nếu là widget -> hiển thị giá trị riêng
		if ( a.split( '_widget.' ).length > 1 ) {
			a = 'Mẫu #' + a.split('.')[0];
			$('div[data-name="' + b + '"]').addClass('bold redcolor');
		}
		// Hoặc gọi đến hàm hiển thị file tương ứng
		else {
//			id_for_set_new_include_file = key;
			
			$('.click-add-class-selected[data-val="' + a + '"]').click();
//			$('.click-add-class-selected[data-type="' + b + '"]').click();
			
			a = '';
		}
	}
	// Nếu không có giá trị -> hiển thị hướng dẫn bấm chọn
	else {
		a = '[ Chọn file thiết kế cho phần #' + $(this).attr('data-type') + ' ]';
	}
	
	if ( a != '' ) {
		$('div[data-name="' + b + '"]').html( a );
	}
});



// Xóa file
$('.click-remove-file-include-form-input').click(function () {
	if ( id_for_set_new_include_file == '' ) {
		console.log( 'id_for_set_new_include_file not found' );
		return false;
	}
	
	var jPro = $('.click-to-change-file-design[data-key="' + id_for_set_new_include_file + '"]');
	
	$( '#' + jPro.attr('data-name') ).val( '' );
	
	jPro.css({
		'background-image' : 'url(\'\')'
	}).height('auto').html('[ Chọn file thiết kế cho phần #' + jPro.attr('data-key') + ' ]');
});



// Đặt làm widget
$('.click-add-widget-include-to-input').click(function () {
	if ( id_for_set_new_include_file == '' ) {
		console.log( 'id_for_set_new_include_file not found' );
		return false;
	}
	
	var a = $(this).attr('data-type') || '';
	
	var jPro = $('.click-to-change-file-design[data-key="' + id_for_set_new_include_file + '"]');
	
	$( '#' + jPro.attr('data-name') ).val( a + '_widget.php' );
	
	jPro.css({
		'background-image' : 'url(\'\')'
	}).height('auto').html('Mẫu #' + a + '_widget');
});




//
$('.click-to-exit-design').click(function () {
	$('.change-eb-design-fixed').hide();
	$('#press_for_search_eb_themes').hide();
	$('body').removeClass('ebdesign-no-scroll');
	current_frame_design_is_show = '';
});

//
$('.click-open-create-themes').click(function () {
	$('#eb_add_new_themes').show();
	$('body').addClass('ebdesign-no-scroll');
	
	$('#create_theme_name').focus();
});



// tên khung đang được hiển thị
var current_frame_design_is_show = '';

// click hiển thị khung chọn file design
$('.click-to-change-file-design').click(function () {
	
	// hiển thị hết các theme ra
	$('.for-themes-quick-search').show();
	
	//
	EBE_themes_key_quick_search();
	
	
	// hiển thị khung tìm kiếm nhanh
	$('#press_for_search_eb_themes').show().focus();
	
	//
	var key_search = $('#press_for_search_eb_themes').val();
	if ( key_search == '' ) {
		key_search = window.location.href.split('#');
//		key_search = window.location.hash || '';
//		if ( key_search != '' ) {
		if ( key_search.length > 1 ) {
			key_search = key_search[1];
			$('#press_for_search_eb_themes').val( key_search );
		} else {
			key_search = '';
		}
	}
	
	// hiển thị theo từ khóa đang tìm
	if ( key_search != '' ) {
//		console.log(key_search);
		$('#press_for_search_eb_themes').click().keyup();
	}
	
	
	
	
//	window.scroll( 0, $(this).offset().top - ( $(window).height()/ 4 ) );
	$('body,html').animate({
		scrollTop: $(this).offset().top - ( $(window).height()/ 4 ) + 'px'
	}, 600);
	
	// ẩn scroll của body làm việc cho dễ
	$('body').addClass('ebdesign-no-scroll');
	
	
	
	//
	var key = $(this).attr('data-key') || '',
		text = g_func.text_only(key);
//	console.log(key);
//	console.log(text);
	
	id_for_set_new_include_file = key;
	console.log( 'Set value to: ' + id_for_set_new_include_file );
	
	// nếu vẫn đang là khung cũ được hiển thị thì bỏ qua
	if ( current_frame_design_is_show == text ) {
		return false;
	}
	current_frame_design_is_show = text;
	
	// v1
//	$('.change-eb-design-fixed').hide();
//	$('.change-eb-design-fixed[data-key="' + text + '"]').show().addClass('selected');
	
	// v2
	$('.change-eb-design-fixed').show().addClass('selected');
	
	$('.change-eb-design-hide-fixed').hide();
	
	//
	console.log('Show HTML for ' + text);
	if ( text == 'threadsearchnode' ) {
		$('.change-eb-design-threadnode-fixed').show();
	}
	else {
		$('.change-eb-design-' + text + '-fixed').show();
	}
	
	
	
	// Căn chỉnh lại size cho phần chọn thiết kế
	var eb_design_width = $('#change_eb_design_width').width();
	
//	$('.preview-in-ebdesign').hide();
//	$('.preview-in-ebdesign[data-key="' + key + '"]').show();
	$('.preview-in-ebdesign').each(function() {
		var a = $(this).attr('data-size') || '';
		if ( a != '' ) {
//			$(this).height( $('.change-eb-design-fixed[data-key="' + text + '"]  h3:first').width() * eval(a) );
			$(this).height( eb_design_width * eval(a) );
		}
	});
	
	
	
	// xóa class định hình sau khi xong việc
	setTimeout(function () {
		$('.change-eb-design-fixed').removeClass('selected');
	}, 600);
	
});



// khi click chuyển tab thì chỉnh lại chiều cao của cột design
$('#list-tab-eb-admin-config li').click(function () {
	$('.click-to-change-file-design').each(function() {
		var a = $(this).attr('data-size') || '';
		
		if ( a != '' ) {
			$(this).height( $(this).width() * eval( a ) );
		}
	});
});


// quick search
var ul_for_quick_search_theme = '';
$('#press_for_search_eb_themes, #press_for_search_all_themes').click(function () {
	// tìm kiểm theme hoặc module của theme
	ul_for_quick_search_theme = $(this).attr('data-class-search') || 'for-themes-quick-search';
	
	//
	EBE_themes_key_quick_search();
}).keyup(function(e) {
//	var fix_id = '.for-themes-quick-search';
	var fix_id = '.' + ul_for_quick_search_theme;
	
//	console.log(e.keyCode);
	
	// enter
	if (e.keyCode == 13) {
		return false;
		/*
	} else if (e.keyCode == 27) {
		$(fix_id).hide();
		return false
	}
	// space
	else if (e.keyCode == 32) {
		$(fix_id).show();
		*/
	}
	
	var key = $(this).val() || '';
	if (key != '') {
		key = g_func.non_mark_seo(key);
		key = key.replace(/[^0-9a-zA-Z]/g, '');
	}
//	console.log(key);
//	return false;
	
	//
//	window.location.hash = key;
	window.history.pushState("", '', window.location.href.split('#')[0] + '#' + key);
	
	//
	if (key != '') {
		$(fix_id).hide().each(function() {
			if ( ul_for_quick_search_theme == 'for-themes-quick-search' ) {
				var a = $(this).attr('data-search') || '';
			}
			else {
				var a = $(this).attr('data-key') || '';
			}
			
			//
			if ( a != '' ) {
				if ( key.length == 1 && a.substr(0, 1) == key ) {
					$(this).show();
				} else if ( a.split(key).length > 1 ) {
					$(this).show();
				}
			}
		});
	} else {
		$(fix_id).show();
	}
});




//
$('#list-tab-eb-admin-config').click(function () {
	window.scroll( 0, 0 );
});



//
$('.click-active-eb-themes').click(function () {
	var a = $(this).attr('data-theme') || '';
	if ( a == '' ) {
		console.log('data-theme not found');
		return false;
	}
	
	$('#create_theme_key').val(a);
	
	
	
	// xóa toàn bộ phần top hiện tại đi, để nạp giao diện mới
	/*
	for ( var i = 1; i <= 10; i++ ) {
		
		var top = 'cf_top' + i + '_include_file';
		if ( dog(top) != null ) {
			dog(top).value = '';
		}
		console.log( top );
		
		var footer = 'cf_footer' + i + '_include_file';
		if ( dog(footer) != null ) {
			dog(footer).value = '';
		}
		console.log( footer );
		
	}
	dog('cf_threaddetails_include_file').value = '';
	dog('cf_threadnode_include_file').value = '';
	dog('cf_threadsearchnode_include_file').value = '';
	*/
	
	
	
	//
	document.frm_config_active_theme.submit();
	
});


//
if ( cf_current_theme_using != '' ) {
	console.log(cf_current_theme_using);
	console.log('Select and move current theme to top');
	
	$('.skins-admin-edit li[data-key="' + cf_current_theme_using + '"]')
	/*
	.css({
		order : 0
	})
	*/
	.addClass('selected');
	
	$('.skins-admin-edit li[data-key="' + cf_current_theme_using + '"] .click-active-eb-themes')
	.html('<i class="fa fa-refresh"></i> Nạp lại')
	.addClass('red-button')
	.removeClass('blue-button');
}




// hiển thị ảnh của theme khi người dùng cuộn chuột
function WGR_show_bg_for_skins_adminedit () {
	
	//
	if ( window.location.href.split('&tab=theme-themes').length == 1 ) {
		return false;
	}
	
	//
	$('.each-to-adminbg').slice( 0, 3 ).each(function() {
		var a = $(this).attr('data-img') || '';
//		console.log(a);
		
		if ( a != '' ) {
			$(this).css({
				'background-image' : 'url(\'' + a + '\')'
			});
		}
	}).removeClass('each-to-adminbg');
	
	//
	if ( $('.each-to-adminbg').length > 0 ) {
		setTimeout(function () {
			WGR_show_bg_for_skins_adminedit();
		}, 600);
	}
	
}

//
$('.skins-adminedit-bg').on('hover', function () {
	var a = $(this).attr('data-img') || '';
//	console.log(a);
	
	if ( a != '' ) {
		$(this).css({
			'background-image' : 'url(\'' + a + '\')'
		});
		$(this).removeAttr('data-img').removeClass('each-to-adminbg');
	}
});

//
setTimeout(function () {
	WGR_show_bg_for_skins_adminedit();
	$('.skins-admin-edit li.selected .skins-adminedit-bg').hover();
}, 2000);



