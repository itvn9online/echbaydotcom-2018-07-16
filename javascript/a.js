



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
	var win_href = window.location.href;
	var admin_act = EBE_get_current_wp_module( win_href );
	
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
		
		
		
		
		//
		/*
		if ( win_href.split('www.webgiare.org').length > 1 ) {
			$(document).ready(function() {
				setTimeout(function () {
					$('#click_remove_content_style').click();
				}, 2000);
			});
			
			//
			$('#excerpt').val( $('#excerpt').val().replace( /\&nbsp\;/gi, ' ' ) );
		}
		*/
		
		
		
		eb_func_global_product_size();
		
		
		
		// gán ảnh đại diện
		(function () {
			
			
			
			// chuyển định dạng số cho phần giá
			$('#_eb_product_oldprice, #_eb_product_price').change(function () {
				var a = $(this).val() || 0;
				
//				a = g_func.number_only( a );
				a = g_func.money_format( a );
				
				if ( a == '' ) {
					a = 0;
				}
				
//				console.log(a);
				$(this).val(a);
			}).change();
			
			
			
			// tạo hiệu ứng cho textarea
			if ( $('textarea[id="excerpt"]').length > 0 ) {
				$('textarea[id="excerpt"]').addClass('fix-textarea-height');
			}
			
			
			//
			var a = $('#_eb_product_avatar').val() || '',
				b = $('tr[data-row="_eb_product_avatar"]').length;
			if ( a != '' && b > 0 ) {
				
				// xử lý hình ảnh lỗi cho xwatch cũ
				a = a.replace( '/home/pictures/', '/Home/Pictures/' );
				$('#_eb_product_avatar').val( a );
				
				//
				$('tr[data-row="_eb_product_avatar"]').after( '\
				<tr>\
					<td class="t">&nbsp;</td>\
					<td class="i"><img src="' + a + '" height="110" /></td>\
				</tr>' );
			}
			
			
			// xử lý hình ảnh lỗi cho xwatch cũ
			setTimeout(function () {
				if ( $("#_eb_product_gallery_ifr").length > 0 ) {
					$("#_eb_product_gallery_ifr").contents().find('img').each(function() {
						var a = $(this).attr('src') || '',
							b = a;
						if (a != '') {
							a = a.replace( '/home/pictures/', '/Home/Pictures/' );
							
							$(this).attr({
								src : a,
								'data-old-src' : b
							});
						}
					});
				}
			}, 2000);
			
			
			
			
			// tạo chức năng chỉnh sửa nội dung, đưa hết về 1 định dạng chuẩn
			var str = '\
			<div style="padding-top:8px;">\
				<input type="checkbox" id="click_remove_content_style" class="click_remove_content_style" />\
				<label for="click_remove_content_style">Loại bỏ toàn bộ các style tĩnh để chuẩn hóa style cho bài viết theo một thiết kế chung.</label>\
			</div>';
			
			$('#postdivrich').after(str);
			
			//
			click_remove_style_of_content();
			
			
			
		})();
		
		
		
		//
		var check_and_set_height_for_img_content = function ( iff_id, default_h, fix_height ) {
			
			// Khung nội dung chính của wordpress thì hạn chế can thiệp vào ảnh -> để người dùng có thể tự ý điều chỉnh size
			if ( typeof fix_height == 'undefined' ) {
				fix_height = 1;
			}
			
			//
			if ( $('#' + iff_id).length > 0 ) {
//				console.log(iff_id);
				$('#' + iff_id).contents().find( 'img' ).each(function() {
					// current style
					var cs = $(this).attr('style') || '',
						// height
						h = $(this).attr('height') || '',
						// width
						w = $(this).attr('width') || default_h;
					
					if ( cs != '' ) {
						$(this).removeAttr('style').removeAttr('data-mce-src');
					}
					
					// nếu không tìm thấy chiều cao
					if ( h == '' ) {
						// rết lại toàn bộ size ảnh
						$(this).removeAttr('width').removeAttr('height').width('auto').height('auto');
//						$(this).removeAttr('width').removeAttr('height');
						
						// tìm chiều cao mặc định
						h = $(this).height() || 0;
						
						// khi nào tìm được mới thôi
						if ( h > 0 ) {
							w = $(this).width() || 0;
							
							//
							$(this).attr({
								'width' : Math.ceil( w ),
								'height' : h
							});
						}
					}
					// có chiều cao -> set thuộc tính mới luôn
					else if ( h > default_h && fix_height == 1 ) {
						var dh = $(this).attr('data-height') || h,
							dw = $(this).attr('data-width') || w;
						
						
						var nw = dh/ default_h;
//						console.log(nw);
						nw = dw/ nw;
//						console.log(nw);
						
						//
						$(this).attr({
							'data-width' : dw,
							'data-height' : dh,
							'width' : Math.ceil( nw ),
							'height' : default_h
						});
					}
				});
				
				
				// riêng đối với phần list của màu sắc thì chuyển caption sang alt để lấy tên màu cho chuẩn
				if ( iff_id == '_eb_product_list_color_ifr' ) {
//					console.log(iff_id);
					$('#' + iff_id).contents().find( 'dl' ).each(function() {
						var a = $('.wp-caption-dd', this).html() || '',
							b = $('img', this).attr('alt') || '';
//						console.log(a);
						if ( a != '' && a != b ) {
							$('img', this).attr({
								alt: a
							});
							
							console.log('Convert caption to ALT');
						}
					});
				}
			}
		};
		
		
		
		// chỉnh lại ảnh của phần gallery để nhìn cho dễ
		setInterval(function () {
			check_and_set_height_for_img_content('content_ifr', 300, 0);
			check_and_set_height_for_img_content('_eb_product_gallery_ifr', 120);
			check_and_set_height_for_img_content('_eb_product_list_color_ifr', 90);
		}, 2000);
		
		//
		setTimeout(function () {
			$('#_eb_product_list_color_ifr').height( 250 );
			
			setTimeout(function () {
				$('#_eb_product_list_color_ifr').height( 250 );
				
				setTimeout(function () {
					$('#_eb_product_list_color_ifr').height( 250 );
				}, 2000);
			}, 2000);
		}, 2000);
		
		
		//
		$('#publish').addClass('publish-position-fixed')
		/*
		.css({
			'position' : 'fixed',
			'bottom': '20px',
			'right' : '20px',
			'z-index' : 99
		})
		*/
		.click(function () {
			EBE_set_default_img_avt();
			EBE_set_default_title_for_seo();
		});
		
		
		
		//
		$(window).on('load', function () {
			EBE_set_default_title_for_seo();
		});
		
		
		
		//
		WGR_check_if_value_this_is_one('_eb_product_chinhhang');
		WGR_check_if_value_this_is_one('_eb_product_noindex');
		WGR_check_if_value_this_is_one('_eb_ads_target');
		
		
		
		//
		jQuery(document).ready(function($) {
			if ( dog('_eb_product_ngayhethan') != null ) {
				_global_js_eb.select_date('#_eb_product_ngayhethan');
			}
		});
		
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



//
$('.click-show-eb-target').click(function () {
	$('#target_eb_iframe').addClass('show-target-echbay');
});




