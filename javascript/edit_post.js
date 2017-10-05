


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
	
	
	
	
	// nhập ID blog, product, page mà q.cáo alias tới
	$('#_eb_ads_for_post').click(function () {
	});
	
	
}



