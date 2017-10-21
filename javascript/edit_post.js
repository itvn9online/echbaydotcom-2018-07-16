


function WGR_run_for_admin_edit_post () {
	
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
			<tr data-row="_eb_show_product_avatar">\
				<td class="t">&nbsp;</td>\
				<td class="i"><img src="' + a + '" height="110" /></td>\
			</tr>' );
		}
		
		
		// xử lý hình ảnh lỗi cho xwatch cũ
		setTimeout(function () {
			console.log('for xwatch domain');
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
		
		
		
		
		$('#postdivrich').after('<div class="ebe-fixed-content-style">\
			<input type="checkbox" id="click_remove_content_style" />\
			<label for="click_remove_content_style">Loại bỏ toàn bộ các style tĩnh để chuẩn hóa style cho bài viết theo một thiết kế chung.</label>\
		</div>\
		<div class="ebe-fixed-content-style">\
			<input type="checkbox" id="click_convert_table_tags" />\
			<label for="click_convert_table_tags">Chuyển đổi thẻ TABLE sang thẻ DIV cho nội dung dễ style hơn, tương thích nhiều thiết bị hơn.</label>\
		</div>\
		<div class="ebe-fixed-content-style graycolor small">\
			<input type="checkbox" id="click_remove_table_tags" />\
			<label for="click_remove_table_tags">Loại bỏ toàn bộ các thẻ TABLE để nội dung có thể chạy trên nhiều thiết bị khác như mobile, table... (<em>điều này có thể làm vỡ khối nên không khuyên dùng</em>)</label>\
		</div>\
		<div class="ebe-fixed-content-style">\
			<input type="checkbox" id="click_fixed_a_tags_redirect" />\
			<label for="click_fixed_a_tags_redirect">Xử lý các URL thuộc dạng redirect về non-redirect (thường áp dụng cho web chết, bị lưu trữ trên web.archive.org).</label>\
		</div>\
		<div class="ebe-fixed-content-style">\
			<input type="checkbox" id="click_download_img_other_domain" />\
			<label for="click_download_img_other_domain">Download ảnh từ host khác về host hiện tại (giúp cho ảnh được xử lý với tốc độ tối ưu hơn).</label>\
		</div>');
		
		
		//
//		console.log('aaaaaaaaaaaaaaaaa');
		
		// tạo chức năng format nội dung, đưa hết về 1 định dạng chuẩn
		click_remove_style_of_content();
		
		// chuyển thẻ table thành thẻ DIV -> theo tiêu chuẩn riêng của EchBay
		click_convert_table_tags_of_content();
		
		// xóa thẻ table khỏi nội dung -> làm cho nội dung chuẩn hơn trên mobile
		click_remove_table_tags_of_content();
		
		// xóa URL dạng redirect
		click_fixed_a_tags_redirect_of_content();
		
		// download IMG về
		click_download_img_other_domain_of_content();
		
		
		
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
	
	
	
	//
	jQuery(document).ready(function($) {
		if ( dog('_eb_product_ngayhethan') != null ) {
			_global_js_eb.select_date('#_eb_product_ngayhethan');
		}
	});
	
	
	
	
	// riêng cho ads
	WGR_run_for_admin_edit_ads_post();
	
	
	
	
	// thêm CSS hiển thị nút add ảnh đại diện
	$('body').append( '<style>div.gallery-add-to-post_avt { display: block; }</style>' );
	
	
}

function WGR_run_for_admin_edit_ads_post () {
	if ( dog('_eb_ads_for_post') == null ) {
		return false;
	}
	
	//
	WGR_check_if_value_this_is_one('_eb_ads_target');
	
	//
	// nhập ID blog, product, page mà q.cáo alias tới
	var jd_for_quick_search_post = 'quick_sreach_for_eb_ads_for_post',
		action_for_quick_search_post = '';
	$('#_eb_ads_for_post').click(function () {
//		console.log(eb_site_group);
		
		//
		action_for_quick_search_post = jd_for_quick_search_post;
		
		//
		if ( dog(jd_for_quick_search_post) == null ) {
			$(this).after('<div class="admin-show-quick-search"><div id="' + jd_for_quick_search_post + '" class="ads-show-quick-search-post"></div></div>');
			
			$('#' + jd_for_quick_search_post).append( edit_post_load_list_post_for_quick_search( eb_posts_list, 'Sản phẩm (Post)' ) );
			$('#' + jd_for_quick_search_post).append( edit_post_load_list_post_for_quick_search( eb_blogs_list, 'Blog/ Tin tức' ) );
			$('#' + jd_for_quick_search_post).append( edit_post_load_list_post_for_quick_search( eb_pages_list, 'Trang tĩnh (Page)' ) );
			
			//
			$('#' + jd_for_quick_search_post + ' li').click(function () {
				$('#_eb_ads_for_post').val( $(this).attr('data-id') || '' );
				$('body').addClass('hide-module-advanced-ads');
			});
		}
		
		//
		$('#' + jd_for_quick_search_post).show();
	}).focus(function () {
		if ( dog(jd_for_quick_search_post) == null ) {
			$(this).click();
		}
		
		action_for_quick_search_post = jd_for_quick_search_post;
		$('#' + jd_for_quick_search_post).show();
	}).blur(function () {
		$('#' + jd_for_quick_search_post).fadeOut();
		
		//
		if ( $(this).val() == '' ) {
			$('body').removeClass('hide-module-advanced-ads');
		}
	});
	
	// thêm class để ẩn các chức năng không còn cần thiết khi q.cáo có alias
	var check_ads_alias = $('#_eb_ads_for_post').val() || '';
	if ( check_ads_alias != '' ) {
		$('body').addClass('hide-module-advanced-ads');
	}
	
	
	// kích hoạt chức năng tìm kiếm nhanh
	$('#_eb_ads_for_post').keyup(function (e) {
//		console.log(e.keyCode);
		
		//
		var fix_id = '#' + action_for_quick_search_post + ' li';
		
		// enter
		if (e.keyCode == 13) {
			return false;
		}
		// ESC
		else if (e.keyCode == 27) {
			$('#' + action_for_quick_search_post).fadeOut();
			return false;
		}
		
		//
		var key = $(this).val() || '';
		if (key != '') {
			key = g_func.non_mark_seo(key);
			key = key.replace(/[^0-9a-zA-Z]/g, '');
		}
		
		//
		if (key != '') {
			$(fix_id).hide().each(function() {
				var a = $(this).attr('data-key') || '';
				
				//
				if ( a != '' ) {
					if ( key.length == 1 && a.substr(0, 1) == key) {
						$(this).show();
					} else if ( a.split(key).length > 1) {
						$(this).show();
					}
				}
			});
		} else {
			$(fix_id).show();
		}
	});
}

function edit_post_load_list_post_for_quick_search ( arr, arr_name ) {
	var str = '';
	for ( var i = 0; i < arr.length; i++ ) {
		var key = g_func.non_mark_seo( arr[i].ten ) + arr[i].seo;
		
		str += '<li data-id="' + arr[i].id + '" data-key="' + key.replace(/\-/g, '') + '">' + arr[i].ten + ' <a href="' + web_link + '?p=' + arr[i].id + '" target="_blank"><i class="fa fa-external-link"></i></a></li>';
	}
	
	return '<h4>' + arr_name + '</h4><ul>' + str + '</ul>';
}


