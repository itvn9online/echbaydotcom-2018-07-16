



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




// nạp iframe để submit cho tiện
_global_js_eb.add_primari_iframe();




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
			$('table.wp-list-table').addClass('admin-list-product-avt')/* .width( '150%' ) */;
			
			//
			/*
			console.log(arr_eb_product_status);
			
			var ads_loc = '<li class="bold">Lọc theo trạng thái:</li>';
			for ( var i = 0; i < arr_eb_product_status.length; i++ ) {
				ads_loc += '<li><a href="' + admin_link + 'edit.php?post_type=post&post_filter_status=' + arr_eb_product_status[i].id + '">' + arr_eb_product_status[i].ten + '</a></li>';
			}
			console.log(ads_loc);
			
			$('#posts-filter').before('<ul class="echbay-subsubsub cf">' + ads_loc + '</ul>');
			$('ul.subsubsub').addClass('cf').css({
				float: 'none'
			});
			*/
		}
		// nếu là ads -> thêm bộ lọc tìm kiếm theo trạng thái
		else if ( win_href.split('post_type=ads').length > 1 ) {
			console.log(arr_eb_ads_status);
			
			var ads_loc = '<li class="bold">Lọc theo trạng thái:</li>';
			for ( var i = 0; i < arr_eb_ads_status.length; i++ ) {
				ads_loc += '<li><a href="' + admin_link + 'edit.php?post_type=ads&ads_filter_status=' + arr_eb_ads_status[i].id + '">' + arr_eb_ads_status[i].ten + '</a></li>';
			}
			console.log(ads_loc);
			
			$('#posts-filter').before('<ul class="echbay-subsubsub cf">' + ads_loc + '</ul>');
			$('ul.subsubsub').addClass('cf').css({
				float: 'none'
			});
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
		WGR_check_if_value_this_is_one('_eb_category_hidden');
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
			var lnk = $(this).attr('data-link') || '#',
				nem = $(this).attr('data-text') || 'Home';
			$('#custom-menu-item-url').val( lnk );
			$('#custom-menu-item-name').val( nem );
			$('#submit-customlinkdiv').click();
//			$('#menu-to-edit li:last').click();
			
			// nếu có class CSS riêng
			var a = $(this).attr('data-css') || '';
			if ( a != '' ) {
//				console.log( a );
				WGR_done_add_class_for_custom_link_menu = false;
				WGR_add_class_for_custom_link_menu( lnk, nem, a );
			}
		});
		
		
		// tạo menu tìm kiếm bài viết cho phần menu, do tìm kiếm của wp tìm không chính xác
		$('#nav-menus-frame').before('<br><div><input type="text" id="wgr_search_product_in_menu" placeholder="Tìm kiếm Sản phẩm/ Bài viết... để thêm vào menu" class="wgr-search-post-menu" /></div>');
		
//		WGR_custom_search_and_add_menu( 1, 'post' );
		
		// nạp danh sách sản phẩm, tin tức... khi người dùng nhấn vào ô tìm kiếm
		$('#wgr_search_product_in_menu').click(function () {
			if ( dog('show_all_list_post_page_menu') == null ) {
				$('#wgr_search_product_in_menu').after('<p class="orgcolor">* Nhập từ khóa vào ô tìm kiếm để tìm kiếm Sản phẩm, bài viết tin tức, trang tĩnh, chuyên mục, danh mục... sau đó bấm chọn trong danh sách vừa tim được để thêm vào menu.</p><div id="show_all_list_post_page_menu"><ul></ul></div>');
				
				//
				WGR_load_post_page_for_add_menu( eb_site_group, 'category', 'Chuyên mục sản phẩm', 'taxonomy' );
				WGR_load_post_page_for_add_menu( eb_tags_group, 'post_tag', 'Từ khóa sản phẩm', 'taxonomy' );
				WGR_load_post_page_for_add_menu( eb_options_group, 'post_options', 'Thông số khác của sản phẩm', 'taxonomy' );
				WGR_load_post_page_for_add_menu( eb_blog_group, 'blogs', 'Danh mục tin tức', 'taxonomy' );
				//
				WGR_load_post_page_for_add_menu( eb_posts_list, 'post', 'Sản phẩm' );
				WGR_load_post_page_for_add_menu( eb_blogs_list, 'blog', 'Tin tức/ Blog' );
				WGR_load_post_page_for_add_menu( eb_pages_list, 'page', 'Trang tĩnh' );
				
				//
				WGR_press_for_search_post_page();
				
			}
		});
		
		
		// hiển thị các menu hay dùng
		// hiển thị phần option để người dùng chọn các menu hay dùng
		jQuery(window).on('load', function () {
			setTimeout(function () {
				if ( dog('add-blogs-hide').checked == false ) {
					jQuery('#add-blogs-hide').click();
				}
				
				if ( dog('add-post-type-blog-hide').checked == false ) {
					jQuery('#add-post-type-blog-hide').click();
				}
				
				/*
				if ( dog('add-blogs-hide').checked == false || dog('add-post-type-blog-hide').checked == false ) {
					jQuery('#show-settings-link').click();
				}
				*/
			}, 800);
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
	
	
	
	
	// thêm CSS hiển thị nút add IMG cho category
	if ( $('#_eb_category_avt').length > 0 || $('#_eb_category_favicon').length ) {
		$('head').append('<style>\
div.gallery-add-to-category_avt,\
div.gallery-add-to-category_favicon { display: block; }\
</style>');
	}
	
	// mở gallery tự viết
	$('#_eb_category_avt, #_eb_category_favicon, #_eb_product_avatar').addClass('click-open-new-gallery');
	
	//
	$('.click-open-new-gallery').click(function () {
		$('#oi_admin_popup').show();
		
		// cuộn đến cuối của ô thêm ảnh
		window.scroll( 0, $(this).offset().top - $(window).height() + 90 );
		
		//
		var show_only = $(this).attr('data-show') || '';
		
		//
		if ( gallery_has_been_load == false ) {
			gallery_has_been_load = true;
			setTimeout(function () {
				gallery_has_been_load = false;
			}, 15 * 1000 );
			
			//
			dog('oi_admin_popup').innerHTML = 'waiting...';
			
			//
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
	
	
	
	//
	$('#wp-admin-bar-top-secondary').addClass('cf eb-admin-bar-support');
	$('#wp-admin-bar-top-secondary li:first').before('<li>TEST</li>');
	
	
	
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
//console.log( current_cookie_show_hide_admin_menu );

$('.click-show-no-customize').click(function(e) {
	// đang bật -> tắt
	if ( current_cookie_show_hide_admin_menu == null ) {
		$('#admin-hide-menu').remove();
		
		//
		current_cookie_show_hide_admin_menu = encodeURIComponent( window.location.href );
		g_func.setc( 'ebe_click_show_hidden_menu', current_cookie_show_hide_admin_menu, 4 * 3600, 7 );
	}
	// đang tắt -> bật
	else {
		g_func.delck( 'ebe_click_show_hidden_menu' );
		
		current_cookie_show_hide_admin_menu = null;
		
		console.log("Please re-load for disable function hide-menu");
		setTimeout(function () {
			if ( confirm('Re-load for disable function hide-menu?') == true ) {
				window.location = window.location.href;
			}
		}, 200);
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
	
	// thêm menu update nếu có update mới
	var check_update = $('#menu-dashboard ul a .update-plugins .update-count').html() || 0;
	if ( parseInt( check_update, 10 ) > 0 ) {
//		console.log( $('#menu-dashboard ul a .update-plugins .update-count').length );
		
		// Hiển thị menu update trên top
		$('#wp-admin-bar-root-default').append( '<li class="menupop"><a href="update-core.php" class="ab-item orgcolor bold wgr-eb-show-menu-update"><i class="fa fa-download"></i> ' + ( $('#menu-dashboard ul a[href="update-core.php"]').html() || 'Update core' ) + '</a></li>' );
		
		// Hiển thị menu chỗ mục update
		$('#menu-dashboard ul').show();
		
		// xóa thẻ span trong menu update
		$('.wgr-eb-show-menu-update span').remove();
	}
	
	//
	for ( var x in a ) {
		$('#' + id_echbay_menu + '-submenu').append( '<li><a class="ab-item" href="' + x + '">' + a[x] + '</a></li>' );
	}
	
})();




//
function WGR_admin_add_img_lazzy_load ( img ) {
	if (img != '') {
		$('.each-to-bgimg:first').css({
			'background-image': 'url(\'' + img + '\')'
		});
	}
	
	//
	$('.each-to-bgimg:first').removeClass('each-to-bgimg').removeClass('eb-lazzy-effect');
}

// load 10 cái đầu tiên trước
$('.each-to-bgimg').slice(0, 10).each(function() {
	WGR_admin_add_img_lazzy_load( $(this).attr('data-img') || '' );
});

//
if ( $('.each-to-bgimg').length > 0 ) {
	
	//
	$('.each-to-bgimg').addClass('eb-lazzy-effect');
	
	//
	$(window).scroll(function() {
		var new_scroll_top = window.scrollY || $(window).scrollTop();
//		console.log(new_scroll_top);
		
		$('.eb-lazzy-effect').each(function() {
			a = $(this).offset().top || 0;
			
			if ( a < new_scroll_top + 600 ) {
				WGR_admin_add_img_lazzy_load( $(this).attr('data-img') || '' );
			}
		});
	});
}



// Hủy lưu URL mỗi khi người dùng bấm vào link
$('#adminmenu a').click(function () {
	// Nếu phiên lưu URL đã hết hạn
	if ( g_func.getc('wgr_check_last_user_visit') == null ) {
		// -> lưu phiên mới luôn
		g_func.setc( 'wgr_check_last_user_visit', 'webgiare.org', 2 * 3600 );
//		g_func.setc( 'wgr_last_url_user_visit', '', 60 );
	}
	
	// chỉ lưu các URL nằm trong menu chính
	var a = $(this).attr('href') || '';
	if ( a != '' ) {
		g_func.setc( 'wgr_last_url_user_visit', escape( a ), 0, 7 );
	}
});



