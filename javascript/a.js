



//
//console.log( typeof jQuery );
if ( typeof jQuery != 'function' ) {
	console.log( 'jQuery not found' );
}

//
//console.log( typeof $ );
if ( typeof $ != 'function' ) {
	$ = jQuery;
}




//
if ( cf_chu_de_chinh != '' ) {
	jQuery('#menu-posts .wp-menu-name').html( cf_chu_de_chinh );
}




// chức năng xử lý cho product size
var eb_global_product_size = '',
	eb_inner_html_product_size = '',
	gallery_has_been_load = false;




// tạo url chung cho các module
//$(document).ready(function() {
(function ( admin_body_class ) {
	
	
	//
//	$('body').addClass('folded');
//	$('#adminmenu').addClass('cf');
	
	//
//	console.log( typeof jQuery );
//	console.log( typeof $ );
	
	
	//
	var win_href = window.location.href,
		admin_act = EBE_get_current_wp_module( win_href );
	console.log(admin_act);
	
	//
	$('.admin-set-reload-url').attr({
		href : win_href
	});
	
	
	
	
	// đánh dấu các tab đang được xem
	$('.eb-admin-tab a').each(function () {
		var a = $(this).attr('href') || '';
//		console.log(a);
		
		if ( a != '' ) {
			a = a.split('&tab=');
			
			if ( a.length > 1 ) {
				a = a[1].split('&')[0];
				
				$(this).attr({
					'data-tab' : a
				});
			}
		}
	});
	
	// đánh dấu tab
	var a = win_href.split('&tab=');
	if ( a.length > 1 ) {
		a = a[1].split('&')[0].split('#')[0];
//		console.log(a);
		
		$('.eb-admin-tab a[data-tab="' +a+ '"]').addClass('selected');
	} else {
		$('.eb-admin-tab li:first a').addClass('selected');
	}
	
	
	
	
	// post size (product size)
	// nếu đang trong phần sửa bài viết
	if ( admin_act == 'post' ) {
		WGR_run_for_admin_edit_post();
	}
	// thêm bài viết mới
	else if ( admin_act == 'post-new' ) {
		// thêm STT mới nhất để bài viết này luôn được lên đầu khi thêm mới
		if ( order_max_post_new > 0 ) {
			$('#menu_order').val( order_max_post_new - -1 );
			console.log('Add menu order to maximun');
		}
	}
	// danh sách post, page, custom post type
	else if ( admin_act == 'list' ) {
		// nếu là post
		if ( win_href.split('post_type=').length == 1
		|| win_href.split('post_type=post').length > 1 ) {
			$('table.wp-list-table').width( '150%' );
		}
	}
	// danh sách đơn hàng
	/*
	else if ( win_href.split('?page=eb-order').length > 1 ) {
		// thu gọn menu của wp
//		$('body').addClass('folded');
	}
	*/
	// danh sách category
	else if ( admin_act == 'cat_list' ) {
		/*
		// fix chiều cao cho cột mô tả -> vì nó dài quá
		$('#the-list').addClass('eb-hide-description');
		
		$('#the-list .column-description').each(function(index, element) {
			var a = $(this).html() || '';
			if ( a != '' ) {
				$(this).html( '<div class="eb-fixed-content-height">' + a + '</div>' );
			}
		}).addClass('show-column-description');
		
		// mặc định sẽ ẩn cột description đi cho nó gọn
		if ( dog('description-hide') != null && dog('description-hide').checked == true ) {
			$('#description-hide').click();
			if ( dog('description-hide').checked == true ) {
				dog('description-hide').checked = false;
			}
		}
		*/
	}
	// chỉnh sửa category
	else if ( admin_act == 'cat_details' ) {
		WGR_check_if_value_this_is_one('_eb_category_primary');
		WGR_check_if_value_this_is_one('_eb_category_noindex');
	}
	// thêm tài khoản thành viên
	else if ( admin_act == 'user-new' ) {
		$('#createuser .form-table tr:last').after('\
		<tr class="form-field">\
			<th>&nbsp;</th>\
			<td>' + ( $('#echbay_role_user_note').html() || 'DIV #echbay_role_user_note not found' ) + '</td>\
		</tr>');
	}
	// sửa tài khoản thành viên
	else if ( admin_act == 'user-edit' ) {
		$('.user-role-wrap').after('\
		<tr class="form-field">\
			<th>&nbsp;</th>\
			<td>' + ( $('#echbay_role_user_note').html() || 'DIV #echbay_role_user_note not found' ) + '</td>\
		</tr>');
	}
	// không cho người dùng chỉnh sửa kích thước ảnh thumb -> để các câu lệnh dùng thumb sẽ chính xác hơn
	else if ( admin_act == 'media' ) {
		$('#wpbody-content .form-table tr:first td:last').addClass('disable-edit-thumb-small').append('<div class="div-edit-thumb-small">&nbsp;</div>');
	}
	// chuyển rule wordpress sang nginx cho nó mượt
	else if ( admin_act == 'permalink' ) {
//		console.log( arr_wordpress_rules.length );
		console.log( arr_wordpress_rules );
		
		var str = '';
		for ( var x in arr_wordpress_rules ) {
			var rule = x,
				rewrite = arr_wordpress_rules[x];
			
			if ( rule.substr( rule.length - 1 ) != '$' ) {
				rule += '$';
			}
			if ( rule.substr( 0, 1 ) != '^' ) {
				rule = '^' + rule;
			}
			
			if ( rewrite.substr( 0, 1 ) != '/' ) {
				rewrite = '/' + rewrite;
			}
			
			str += 'rewrite ' + rule + ' ' + rewrite + ';' + "\n";
		}
		
		// Thay tham số của wordpress bằng tham số nginx
		str = str.replace( /\$matches\[1\]/gi, '$1' );
		str = str.replace( /\$matches\[2\]/gi, '$2' );
		str = str.replace( /\$matches\[3\]/gi, '$3' );
		str = str.replace( /\$matches\[4\]/gi, '$4' );
		str = str.replace( /\$matches\[5\]/gi, '$5' );
		str = str.replace( /\$matches\[6\]/gi, '$6' );
		str = str.replace( /\$matches\[7\]/gi, '$7' );
		str = str.replace( /\$matches\[8\]/gi, '$8' );
		str = str.replace( /\$matches\[9\]/gi, '$9' );
		str = str.replace( /\$matches\[10\]/gi, '$10' );
		
//		str = str.replace( /\{1\,\}/gi, '{1,10}' );
		str = str.replace( /\{1\,\}/gi, '?' );
		str = str.replace( /\{4\}/gi, '(4)' );
		str = str.replace( /\{1,2\}/gi, '(1,2)' );
		str = str.replace( /\{4\}/gi, '(4)' );
		str = str.replace( /\{4\}/gi, '(4)' );
		str = str.replace( /\{4\}/gi, '(4)' );
		
//		console.log(str);
		
		$('form[name="form"]').after( '<textarea style="width:99%;height:600px;">' + str + '</textarea>' );
	}
	// ở phần menu thì thêm 1 số menu tĩnh vào để add cho nhanh
	else if ( admin_act == 'menu' ) {
		
		$('#side-sortables ul.outer-border').after( $('#content-for-quick-add-menu').html() || '' );
		
		// khi người dùng bấm thêm vào menu
		$('.click-to-add-custom-link').click(function () {
			$('#custom-menu-item-url').val( $(this).attr('data-link') || '#' );
			$('#custom-menu-item-name').val( $(this).attr('data-text') || 'Home' );
			$('#submit-customlinkdiv').click();
//			$('#menu-to-edit li:last').click();
		});
		
	}
	
	
	
	
	// hiển thị khung post dưới localhost để test
	if ( win_href.split('localhost:').length > 1 ) {
		$('#target_eb_iframe').height(600).css({
			position: 'relative',
			top: 0,
			left: 0,
			height : '600px'
		});
	}
	
	
	
	//
	$('input[id="_eb_category_order"]').width( 90 );
	
	
	//
	fix_textarea_height();
	
	
	
	
	// mở gallery tự viết
	$('.click-open-new-gallery').click(function () {
		$('#oi_admin_popup').show();
		
		//
		var show_only = $(this).attr('data-show') || '';
		
		//
		if ( gallery_has_been_load == false ) {
			gallery_has_been_load = true;
			
			ajaxl('gallery', 'oi_admin_popup', 9, function () {
				// Nếu có thuộc tính hiển thị option
				if ( show_only != '' ) {
					// chỉ hiển thị option theo chỉ định
					$('#oi_admin_popup .eb-newgallery-option .' + show_only).show();
				}
			});
		}
		// Hiển thị option theo chỉ định
		else if ( show_only != '' && $('#oi_admin_popup .eb-newgallery-option').length > 0 ) {
//			$('#oi_admin_popup .eb-newgallery-option div').hide();
			$('#oi_admin_popup .eb-newgallery-option .' + show_only).show();
		}
	});
//	$('.click-open-new-gallery').click();
	
	
//});
})( $('body').attr('class') || '' );





//
function process_for_press_esc () {
	$('.click-to-exit-design').click();
	$('#oi_admin_popup, .hide-if-press-esc').hide();
	
	$('body').removeClass('ebdesign-no-scroll');
}

// Tất cả các hiệu ứng khi bấm ESC sẽ bị đóng lại
$(document).keydown(function(e) {
	if (e.keyCode == 27) {
		console.log('ESC to close');
		
		process_for_press_esc();
	}
});



// hiển thị iframe submit của EchBay
$('.click-show-eb-target').click(function () {
	$('#target_eb_iframe').addClass('show-target-echbay');
});



// xóa CSS chặn các menu khác của admin
var current_cookie_show_hide_admin_menu = g_func.getc('ebe_click_show_hidden_menu');
console.log( current_cookie_show_hide_admin_menu );

$('.click-show-no-customize').click(function(e) {
	// đang bật -> tắt
	if ( current_cookie_show_hide_admin_menu == null ) {
		$('#admin-hide-menu').remove();
		
		//
		current_cookie_show_hide_admin_menu = encodeURIComponent( window.location.href );
		g_func.setc( 'ebe_click_show_hidden_menu', current_cookie_show_hide_admin_menu, 4 * 3600 );
	}
	// đang tắt -> bật
	else {
		g_func.delck( 'ebe_click_show_hidden_menu' );
		
		current_cookie_show_hide_admin_menu = null;
		
		console.log("Please re-load this page for show admin menu");
	}
});

//
if ( cf_hide_supper_admin_menu == 1 ) {
	// thông báo cho người dùng
	if ( current_cookie_show_hide_admin_menu == null ) {
		console.log("Hide menu for admin");
	}
	else {
		console.log("Hide menu admin is active! but cookies disable is ON");
	}
}




// clone menu EchBay.com to top
(function () {
	
	var id_echbay_menu = 'toplevel_page_eb-order',
		a = {};
	$('#' + id_echbay_menu + ' a').each(function(index, element) {
		var h = $(this).attr('href') || '',
			t = $(this).html() || '';
		a[h] = t;
	});
//	console.log(a);
	
	//
	$('#wp-admin-bar-root-default').append( '<li id="' + id_echbay_menu + '-top" class="menupop"><a href="javascript://" class="ab-item"><i class="fa fa-leaf"></i> EchBay.com</a></li>' );
	
	$('#' + id_echbay_menu + '-top').append( '<div class="ab-sub-wrapper"><ul id="' + id_echbay_menu + '-submenu" class="ab-submenu"></ul></div>' );
	
	//
	for ( var x in a ) {
		$('#' + id_echbay_menu + '-submenu').append( '<li><a class="ab-item" href="' + x + '">' + a[x] + '</a></li>' );
	}
	
})();




