


//console.log( typeof $ );
//console.log( typeof jQuery );
if ( typeof $ == 'undefined' ) {
	$ = jQuery;
}




function eb_drop_menu(fix_id, select_id) {
//	console.log( select_id );
	if (typeof select_id == 'undefined') {
		select_id = 0;
	}
	else {
		$('#' + fix_id + ' option[value=\'' + select_id + '\']').attr({
			selected: 'selected'
		});
	}
	
	var str = '',
		sl = $('#' + fix_id + ' select').val(),
		sl_name = $('#' + fix_id + ' select').attr('name'),
		search_id = sl_name + Math.random().toString(32) + Math.random().toString(32),
		//
//		sl_html = $('#' + fix_id).html(),
		sl_html = '<input type="hidden" name="' +sl_name+ '" value="' +select_id+ '" />',
		list = '';
	
	search_id = search_id.replace(/\./g, '_');
	str += '<i class="fa fa-caret-down search-select-down"></i>';
	str += '<input type="text" title="T\u00ecm ki\u1ebfm nhanh" id="' + search_id + '" autocomplete="off" />';
	
	$('#' + fix_id + ' option').each(function() {
		var a = $(this).val() || '',
			b = $(this).text(),
			lnk = $(this).attr('data-href') || '',
			level = $(this).attr('data-level') || '0',
			al_show = $(this).attr('data-show') || '0',
			c = g_func.non_mark_seo(a + b);
		
		if (lnk == '') {
			lnk = b;
		} else {
			lnk = '<a href="' + lnk + '">' + b + '</a>';
		}
		
		list += '<li title="' + b + '" data-show="' + al_show + '" data-level="' + level + '" data-value="' + a + '" data-key="' + c.replace(/-/g, '') + '" class="fa">' + lnk + '</li>';
	});
	
	list = '<div><ul>' + list + '</ul></div>';
	$('#' + fix_id).html(str + list + sl_html).addClass('search-select-option');
	
	/*
	$('#' + fix_id + ' option[value=\'' + select_id + '\']').attr({
		selected: 'selected'
	});
	*/
	
	var z_index = $('.search-select-option').length + 1;
	$('.search-select-option').each(function() {
		$(this).css({
			'z-index': z_index
		});
		
		z_index--;
	});
	
	$('#' + fix_id + ' li').off('click').click(function() {
		$('#' + fix_id + ' li').removeClass('selected');
		$(this).addClass('selected');
		
		var tit = $(this).attr('title') || '';
		tit = tit.replace(/\s+\s/g, ' ');
		
		$('#' + search_id).attr({
			placeholder: tit
		}).val('');
		
		
		// sử dụng text type thay vì selext box
		$('#' + fix_id + ' input[name=\'' +sl_name+ '\']').val( $(this).attr('data-value') || '' );
		
		//
		/*
		$('#' + fix_id + ' option').removeAttr('selected');
		
		$('#' + fix_id + ' option[value=\'' + ($(this).attr('data-value') || '') + '\']').attr({
			selected: 'selected'
		});
		*/
	});
	
	$('#' + fix_id + ' li[data-value=\'' + sl + '\']').click();
	$('#' + fix_id + ' div').addClass('search-select-scroll');
	
	$(document).mouseup(function(e) {
		var container = $("#" + fix_id + " div");
		if (!container.is(e.target) && container.has(e.target).length === 0) {
			container.hide();
		}
	});
	
	$('#' + search_id).off('click').click(function() {
		$('#' + fix_id + ' div').show()
	}).off('keyup').keyup(function(e) {
		if (e.keyCode == 13) {
			return false
		} else if (e.keyCode == 27) {
			$("#" + fix_id + " div").hide();
			return false
		} else if (e.keyCode == 32) {
			$('#' + fix_id + ' div').show();
		}
		
		var key = $(this).val() || '';
		if (key != '') {
			key = g_func.non_mark_seo(key);
			key = key.replace(/[^0-9a-zA-Z]/g, '');
		}
		
		if (key != '') {
			$('#' + fix_id + ' li').hide().each(function() {
				if (a != '') {
					var a = $(this).attr('data-key') || '';
					if (a != '' && a.split(key).length > 1) {
						$(this).show();
					}
				}
			});
			
			$('#' + fix_id + ' li[data-show=1]').show()
		} else {
			$('#' + fix_id + ' li').show()
		}
		
		if ($('#' + fix_id + ' ul').height() > 250) {
			$('#' + fix_id + ' div').addClass('search-select-scroll');
		} else {
			$('#' + fix_id + ' div').removeClass('search-select-scroll');
		}
	});
}

// chức năng đồng bộ nội dung website theo chuẩn chung của EchBay
/*
function click_remove_style_of_content () {
	
	//
	$('.click_remove_content_style').click(function () {
		
		// hủy check ngay và luôn
		$(this).prop({
			checked : false
		});
		
		//
		var content_id = $(this).attr('data-editer') || 't_noidung';
		
		// tên đầy đủ của text editter
		content_id += 'wysiwyg';
		
		//
		if ( dog( content_id ) == null ) {
			alert('Text editer #' +content_id+ ' not found');
			return false;
		}
		
		// ID cho jQuery
		content_id = '#' + content_id;
		
		//
		if ( confirm('Confirm remove all style in this content!') == false ) {
			return false;
		}
		
		// Các thẻ sẽ loại bỏ các attr gây ảnh hưởng đến style
		var arr = [
			'article',
			'font',
			'span',
			'ul',
			'ol',
			'li',
			'br',
			
			'strong',
			'blockquote',
			'b',
			'u',
			'i',
			'em',
			
			'pre',
			'code',
			'section',
			
			'table',
			'tr',
			'td',
			
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			
			'a',
			'p',
			'div'
		];
		
		//
		for ( var i = 0; i < arr.length; i++ ) {
			$( content_id ).contents().find( arr[i] ).removeAttr('style').removeAttr('id').removeAttr('face').removeAttr('dir').removeAttr('size');
		}
		
		
		// Các thẻ sẽ bị loại bỏ khỏi html
		var arr = [
			'figure',
			'figcaption'
		];
		
		//
		for ( var i = 0; i < arr.length; i++ ) {
			$( content_id ).contents().find( arr[i] ).each(function() {
				$(this).before( $(this).html() ).remove();
			});
		}
		
		
		// xử lý riêng với IM
		$( content_id ).contents().find( 'img' ).removeAttr('style');
		
		
		// xử lý riêng với TABLE
		$( content_id ).contents().find( 'table' ).removeAttr('width').attr({
			border : 0,
//			width : '100%',
			cellpadding : 6,
			cellspacing : 0
		}).addClass('table-list');
		
		//
		$( content_id ).contents().find( 'table p' ).each(function () {
			$(this).before( $(this).html() ).remove();
		});
		
		//
		$( content_id ).contents().find( 'td' ).removeAttr('width');
		
		
		// loại bỏ thẻ style nếu có
//		console.log( 1 );
//		console.log( $( content_id ).contents().find( 'style' ).length );
		$( content_id ).contents().find( 'style' ).remove();
	});
}
*/



// chức năng đồng bộ hình ảnh trong nội dung website theo chuẩn chung của EchBay
/*
function click_remove_style_of_img_content () {
	
	//
	$('.click_remove_content_img_style').click(function () {
		
		// hủy check ngay và luôn
		$(this).prop({
			checked : false
		});
		
		//
		var content_id = $(this).attr('data-editer') || 't_noidung';
		
		// tên đầy đủ của text editter
		content_id += 'wysiwyg';
		
		//
		if ( dog( content_id ) == null ) {
			alert('Text editer #' +content_id+ ' not found');
			return false;
		}
		
		// ID cho jQuery
		content_id = '#' + content_id;
		
		//
		if ( confirm('Confirm remove image style in this content!') == false ) {
			return false;
		}
		
		//
		$( content_id ).contents().find( 'img' ).each(function() {
			var a = $(this).attr('src') || '';
			
			if ( a != '' ) {
				$(this).before( '<img src="' +a+ '" />' );
			}
			
			$(this).remove();
		});
	});
}
*/




function create_content_editer(id) {
	var frame_id = id + 'wysiwyg';
	
	// tự hủy nếu không có ID
	if ( dog ( frame_id ) == null ) {
		return false;
	}
	
	// thi thoảng bị lỗi mất scoll hiện tại -> thêm lệnh này để trỏ về đúng vị trí
	var current_scroll_top = window.scrollY || $(window).scrollTop();
	
	// đưa về kích thước chuẩn để tính toán lại
	$('#' + frame_id).height( 300 );
	
	//
	var famre_height = $('#' + frame_id).contents().find('body').height();
	famre_height = $w.number_only(famre_height);
//	console.log(famre_height);
	
	if (isNaN(famre_height) || famre_height < 300) {
		famre_height = 300
	}
//	console.log(famre_height);
	
	$('#' + frame_id).height( famre_height - -80 );
	console.log('Fix editer height #' + frame_id);
	
	click_edit_img_in_content();
	
	//
	window.scroll( 0, current_scroll_top );
}





function click_download_img_in_content() {
	// lấy URL của frm upload hiện tại -> dùng để copy ảnh
	var a = document.frm_multi_upload.action || '',
		b = $('#img_edit_source').val() || '';
//			alert(a);
	
	if ( a == '' ) {
		alert('Không xác định được nguồn xử lý');
		return false;
	}
	
	if ( b == '' ) {
		alert('Không xác định được file nguồn');
		return false;
	}
	
	if ( b.split('//').length == 1 ) {
		alert('Tính năng chỉ áp dụng cho URL tuyệt đối');
		return false;
	}
	
	// lấy nguồn hiện tại để so sánh
	var c = web_link.split('//')[1].split('/')[0];
	if ( c.substr(0, 4) == 'www.' ) {
		c = c.substr(4);
	}
	//alert(c);
	
	// ảnh cần copy phải khác nguồn với site này
	if ( b.split( c ).length > 1 ) {
		alert('Tính năng chỉ hỗ trợ download ảnh từ website khác về');
		return false;
	}
	
	// kiểm tra xem có phải là ảnh không
	var fname = b.split('/').pop().split('?')[0].split('&')[0].split('#')[0].toLowerCase(),
		ftype = fname.split('.').pop();
//				alert(ftype);
	
	// định dạng được phép upload
	switch ( ftype ) {
		case "gif":
		case "jpg":
		case "jpeg":
		case "png":
//					case "swf":
			break;
		
		default:
			alert('Định dạng chưa được hỗ trợ');
			return false;
			break;
	}
	
//				return false;
	
	// tạo link download
	if ( a.split('?').length == 1 ) {
		a += '?';
	} else {
		a += '&';
	}
	
	window.open( a + 'download_img=' + encodeURIComponent( b ) + '&fname=' + fname, 'target_eb_iframe' );
}




function click_edit_img_in_content() {
	if ( dog('t_noidungwysiwyg') != null ) {
		
		
		var rand_img_a_id = function ( t ) {
			return t + '-for-contant-' + pid + '_' + Math.random().toString(32).substr(3, 4);
		};
		
		// chỉnh sửa URL
		$("#t_noidungwysiwyg").contents().find('a').off('click').click(function() {
			var x = $(this).offset().left + $("#t_noidungwysiwyg").offset().left,
				y = $(this).offset().top + $("#t_noidungwysiwyg").offset().top + 20,
				jd = $(this).attr('id') || '';
//			console.log(x);
//			console.log(y);
			
			//
			if (jd == '') {
				jd = rand_img_a_id('url');
				$(this).attr({
					id : jd
				});
			}
			
			//
			$('.img-click-edit-img').show().css({
				left : x + 'px',
				top : y + 'px',
			}).attr({
				'data-process' : jd
			}).off('click').click(function () {
				$(this).fadeOut();
//				console.log($(this).attr('data-process'));
				
//				$( 'img#' + $(this).attr('data-process') ).dblclick();
				$("#t_noidungwysiwyg").contents().find( 'a#' + $(this).attr('data-process') ).dblclick();
			}).html('Chỉnh sửa URL <i class="fa fa-link"></i>');
		}).off('dblclick').dblclick(function() {
			// Nếu trong thẻ a này có thẻ IMG -> tắt chức năng sửa URL đi
			if ( $('img', this).length > 0 ) {
//				$(this).off('dblclick');
//				return false;
			}
			
			//
			var a = $(this).attr('title') || '',
				tex = $(this).html() || '',
				jd = $(this).attr('id') || '',
				lnk = $(this).attr('href') || '',
				tar = $(this).attr('target') || '',
				ren = $(this).attr('rel') || '',
				s = window.scrollY || $(window).scrollTop(),
				edit_frm = $('.admin-edit-url');
			
			edit_frm.show();
			
			var l = $(window).width() - edit_frm.width(),
				t = $(window).height() - edit_frm.height();
			l = l / 2;
			t = t / 5;
			
			edit_frm.show().css({
				top: (t + s) + 'px',
				left: l + 'px'
			});
			
			if (jd == '') {
				jd = rand_img_a_id('url');
				$(this).attr({
					id: jd
				});
			}
			
			//
			$('#editer_url_edit_url').val(lnk);
			$('#editer_url_edit_title').val(a);
			$('#editer_url_edit_text').val(tex);
			
			//
			$('#editer_url_edit_target option:first, #editer_url_edit_rel option:first').prop({
				selected : true
			});
			if ( tar != '' ) {
				$('#editer_url_edit_target option[value="' +tar+ '"]').prop({
					selected : true
				});
			}
			if ( ren != '' ) {
				$('#editer_url_edit_rel option[value="' +ren+ '"]').prop({
					selected : true
				});
			}
			
			//
			edit_frm.find('.img_edit_ok').off('click').click(function() {
				var arr_attr = {
					href: $('#editer_url_edit_url').val()
				};
				
				//
				var tit = $('#editer_url_edit_title').val() || '',
					tar = $('#editer_url_edit_target').val() || '',
					rel = $('#editer_url_edit_rel').val() || '';
				
				//
				if ( tit != '' ) {
					arr_attr['title'] = tit;
				}
				
				//
				if ( tar != '' ) {
					arr_attr['target'] = tar;
				}
				
				//
				if ( rel != '' ) {
					arr_attr['rel'] = rel;
				}
				
				$("#t_noidungwysiwyg").contents().find('a#' + jd).removeAttr('title').removeAttr('target').removeAttr('rel').attr(arr_attr).html( $('#editer_url_edit_text').val() || '' );
				
				$('.admin-edit-url .img_edit_cancel').click();
				
				click_edit_img_in_content();
			});
		});
		
		// chỉnh sửa ảnh
		$("#t_noidungwysiwyg").contents().find('img').off('click').click(function() {
			var x = $(this).offset().left + $("#t_noidungwysiwyg").offset().left,
				y = $(this).offset().top + $("#t_noidungwysiwyg").offset().top + $(this).height()/ 2,
				jd = $(this).attr('id') || '';
//			console.log(x);
//			console.log(y);
			
			//
			if (jd == '') {
				jd = rand_img_a_id('img');
				$(this).attr({
					id : jd
				});
			}
			
			//
			$('.img-click-edit-img').show().css({
				left : x + 'px',
				top : y + 'px',
			}).attr({
				'data-process' : jd
			}).off('click').click(function () {
				$(this).fadeOut();
//				console.log($(this).attr('data-process'));
				
//				$( 'img#' + $(this).attr('data-process') ).dblclick();
				$("#t_noidungwysiwyg").contents().find( 'img#' + $(this).attr('data-process') ).dblclick();
			}).html('Chỉnh sửa ảnh <i class="fa fa-image"></i>');
		}).off('dblclick').dblclick(function() {
			var a = $(this).attr('alt') || '',
				jd = $(this).attr('id') || '',
				img = $(this).attr('src') || '',
				wit = $(this).width(),
				hai = $(this).height(),
				s = window.scrollY || $(window).scrollTop(),
				edit_frm = $('.img-edit-img');
			
			edit_frm.show();
			
			var l = $(window).width() - edit_frm.width(),
				t = $(window).height() - edit_frm.height();
			l = l / 2;
			t = t / 5;
			
			edit_frm.show().css({
				top: (t + s) + 'px',
				left: l + 'px'
			});
			
			if (a == '') {
				if ( typeof document.frm_admin_edit_content != 'undefined' ) {
					a = document.frm_admin_edit_content.t_tieude.value;
				}
				else if ( typeof document.frm_thread_add != 'undefined' ) {
					a = document.frm_thread_add.t_tieude.value;
				}
			}
			
			if (jd == '') {
				jd = rand_img_a_id('img');
				$(this).attr({
					id: jd
				});
			}
			
			// v2
			edit_frm.find('input[name="t_source"]').val( img );
			edit_frm.find('input[name="t_description"]').val( a ).focus();
			edit_frm.find('input[name="t_with"]').val( wit );
			edit_frm.find('input[name="t_height"]').val( hai );
			
			// v1
			/*
			$('#img_edit_source').val(img);
			$('#img_edit_description').val(a).focus();
			$('#img_edit_width').val(wit);
			$('#img_edit_height').val(hai);
			*/
			
			//
			edit_frm.find('.img_edit_ok').off('click').click(function() {
				var arr_attr = {
					src: $('#img_edit_source').val(),
					alt: $('#img_edit_description').val()
				};
				
				//
				var a = $("#t_noidungwysiwyg").contents().find('img#' + jd);
				
				//
				a.removeAttr('width').removeAttr('height').attr(arr_attr).width('auto').height('auto');
				
				var wit = $('#img_edit_width').val() || '',
					hai = $('#img_edit_height').val() || '';
				
				if (wit != '') {
					wit = $w.number_only(wit);
					if (wit > 0) {
						a.width(wit);
//						arr_attr['width'] = wit;
					}
				}
				
				if (hai != '') {
					hai = $w.number_only(hai);
					if (hai > 0) {
						a.height(hai);
//						arr_attr['height'] = hai;
					}
				}
				
				$('.img-edit-img .img_edit_cancel').click();
				
				click_edit_img_in_content();
			});
		});
		
		//
		$('#img_edit_width, #img_edit_height').off('click').click(function() {
			$(this).select();
		});
		
		//
		$('.img-edit-img .img_edit_cancel').off('click').click(function() {
			$('.img-edit-img').hide();
		});
		
		//
		$('.admin-edit-url .img_edit_cancel').off('click').click(function() {
			$('.admin-edit-url').hide();
		});
		
		//
		$('.img_edit_downoad').off('click').click(function() {
			// lấy URL của frm upload hiện tại -> dùng để copy ảnh
			var a = document.frm_multi_upload.action || '',
				b = $('#img_edit_source').val() || '';
//			alert(a);
			
			if ( a != '' && b != '' ) {
				// lấy nguồn hiện tại để so sánh
				var c = web_link.split('//')[1].split('/')[0];
				if ( c.substr(0, 4) == 'www.' ) {
					c = c.substr(4);
				}
				//alert(c);
				
				// ảnh cần copy phải khác nguồn với site này
				if ( b.split( c ).length > 1 ) {
					alert('Tính năng chỉ hỗ trợ download ảnh từ website khác về');
					return false;
				}
				
				// kiểm tra xem có phải là ảnh không
				var fname = b.split('/').pop().split('?')[0].split('&')[0].split('#')[0].toLowerCase(),
					ftype = fname.split('.').pop();
//				alert(ftype);
				
				// định dạng được phép upload
				switch ( ftype ) {
					case "gif":
					case "jpg":
					case "jpeg":
					case "png":
//					case "swf":
						break;
					
					default:
						alert('Định dạng chưa được hỗ trợ');
						return false;
						break;
				}
				
//				return false;
				
				// tạo link download
				if ( a.split('?').length == 1 ) {
					a += '?';
				} else {
					a += '&';
				}
				
				window.open( a + 'download_img=' + encodeURIComponent( b ) + '&fname=' + fname, 'target_eb_iframe' );
			}
		});
		
		//
		$(document).mouseup(function(e) {
			var container = $(".img-edit-img");
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				container.hide();
			}
		});
	}
}




function fix_textarea_height() {
	$('.fix-textarea-height textarea, textarea.fix-textarea-height').each(function() {
		var a = $(this).attr('data-resize') || '',
			min_height = $(this).attr('data-min-height') || 60,
			add_height = $(this).attr('data-add-height') || 20;
//		console.log(min_height);
		
		if (a == '') {
			$(this).height(20);
			
			//
			var new_height = $(this).get(0).scrollHeight || 0;
			new_height -= 0 - add_height;
			if (new_height < min_height) {
				new_height = min_height;
			}
			
			//
			$(this).height(new_height);
			
			//
			console.log('Fix textarea height #' + ( $(this).attr('name') || $(this).attr('id') || 'NULL' ) );
		}
	}).off('click').click(function() {
		fix_textarea_height()
	}).off('change').change(function() {
		fix_textarea_height()
	});
}





/*
* Định vị vị trí trụ sở chính của website
*/
function create_img_gg_map ( latlon ) {
	if ( typeof latlon == 'undefined' || latlon == '' ) {
		return '';
	}
	
	var wit = $('#mapholder').width() || 400;
	if ( wit > 640 ) {
		wit = 640;
	}
	
	// Bản đồ trực tuyến
	var site = 'https://www.google.com/maps/@' + latlon + ',15z';
//	var site = 'https://maps.google.com/maps?sspn=' + latlon + '&t=h&hnear=London,+United+Kingdom&z=15&output=embed';
//	console.log(site);
	
	// URL only
	return '<a title="' +site+ '" href="' +site+ '" rel="nofollow" target="_blank">' +site+ '</a>';
	
	//
	/*
	var img = '//maps.googleapis.com/maps/api/staticmap?center=' + latlon + '&zoom=14&size=' + wit + 'x300&sensor=true';
	
	// iframe img
//	return '<iframe src="' +img+ '" width="' +wit+ '" height="300"></iframe>';
	
	// url and img
	return '<a title="' +site+ '" href="' +site+ '" rel="nofollow" target="_blank" class="d-block"><img src="' +img+ '" /></a>';
	*/
}


//
function auto_get_user_position ( current_position ) {
	if ( typeof document.frm_config == 'undefined' ) {
		console.log('frm_config not found');
		return false;
	}
	
	if ( dog('mapholder') == null ) {
		console.log('mapholder not found');
		return false;
	}
	
	var f = document.frm_config;
	
	//
	dog( 'mapholder', create_img_gg_map ( f.cf_position.value.replace( ';', ',' ) ) );
	
	/*
	if ( f.cf_content_language.value == '' ) {
		f.cf_content_language.value = navigator.userLanguage || navigator.language || '';
	}
	*/
	
	
	// lấy vị trí chính xác
	if ( typeof current_position != 'undefined' ) {
		navigator.geolocation.getCurrentPosition( function ( position ) {
			var lat = position.coords.latitude,
				lon = position.coords.longitude;
//			console.log( lat );
//			console.log( lon );
			
			//
			$('input[name=cf_position]').val( lat+ ';' +lon );
			
			//
			dog( 'mapholder', create_img_gg_map ( lat+ ',' +lon ) );
		}, function () {
			console.log( 'Not get user Position' );
		}, {
			timeout : 10000
		});
	}
	
	
	// lấy vị trí gần đúng
	if ( f.cf_region.value == '' || f.cf_placename.value == '' || f.cf_position.value == '' ) {
//		console.log( window.location.protocol );
		var url_get_ip_info = window.location.protocol + '//ipinfo.io';
		if ( typeof client_ip != 'undefined' && client_ip != '' ) {
			url_get_ip_info += '/' + client_ip;
		}
//		console.log( url_get_ip_info );
		
		//
		$.getJSON( url_get_ip_info, function(data) {
//			console.log( data ); return;
			
			if ( f.cf_region.value == '' && typeof data['country'] != 'undefined' ) {
				f.cf_region.value = data['country'];
			}
			
			if ( f.cf_placename.value == '' && typeof data['region'] != 'undefined' ) {
				f.cf_placename.value = data['region'];
			}
			
			if ( f.cf_position.value == '' && typeof data['loc'] != 'undefined' ) {
				f.cf_position.value = data['loc'];
				
				//
				dog( 'mapholder', create_img_gg_map ( f.cf_position.value.replace( ';', ',' ) ) );
			}
		});
	}
}

function checkFlashT(img) {
	img = img.split('.');
	img = img[img.length - 1];
	
	//
	if (img == 'swf') {
		return true;
	}
	
	//
	return false;
}


function insertPictureContent(image) {
	if (checkFlashT(image) == true) {
		alert('Không hỗ trợ Flash cho mục này');
		return;
	}
	
	//
	if (image.split('//').length == 1) {
		image = web_link.replace('https://', 'http://') + image;
	}
	
	// thi thoảng bị lỗi mất scoll hiện tại -> thêm lệnh này để trỏ về đúng vị trí
	var current_scroll_top = window.scrollY || $(window).scrollTop();
	
	//
	$w.fm('t_noidung', 'img', image);
	
	//
	create_content_editer('t_noidung');
	
	//
	window.scroll( 0, current_scroll_top );
}



