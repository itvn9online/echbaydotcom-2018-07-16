



//
var EBE_current_first_domain = '',
	auto_submit_save_domain_cookies = false,
	source_url = '',
	current_url = '',
	// giãn cách cập nhật tin
	gian_cach_submit = 2 * 1000,
	firts_img_in_content = '';



//
if ( arr_for_save_domain_config != '' ) {
	arr_for_save_domain_config = $.parseJSON( unescape( arr_for_save_domain_config ) );
	
	for ( var x in arr_for_save_domain_config ) {
		if ( EBE_current_first_domain == '' ) {
			EBE_current_first_domain = x;
		}
		else {
			break;
		}
	}
} else {
	arr_for_save_domain_config = {};
}
console.log( arr_for_save_domain_config );



// tùy theo trang web mà url nằm đầu hay cuối
function get_leech_data_post_id ( str, vitri ) {
	console.log(str);
	
	var b = $('#id_post_begin').val() || '',
		e = $('#id_post_end').val() || '';
	
	
	// nếu điểm bắt đầu chỉ có 1 ký tự
	if ( b.length == 1 ) {
		// nếu không có điểm kết thúc -> lấy ngay vị trí cuối cùng
		if ( e == '' ) {
			var a = str.split( b )[0];
			
			return a[ a.length - 1 ];
		}
		
		// nếu có điểm kết thúc -> lấy mảng ngay trước vị trí kết thúc
		var a = str.split( e )[0].split( b );
		
		return a[ a.length - 1 ];
	}
	// nếu có điều kiện để lọc ID
	else if ( b != '' && e != '' ) {
		var a = str.split( b );
		if ( a.length > 1 ) {
			return a[1].split( e )[0];
		}
		return 0;
	}
	
	
	// nếu không -> chủ động tìm
	if ( typeof vitri == 'undefined' ) {
		vitri = 0;
	}
	
	// https://www.xwatch.vn/dong-ho-citizen/an8050-51e-2821.html
	// http://luxshopping.vn/dong-ho/bulova-facets-crystal-rose-women-s-watch-28mm--13443.aspx
	try {
		// ở cuối
		if ( vitri == 0 ) {
			str = g_func.number_only( str.split('-').pop().split('.')[0].split('/')[0] );
		}
	} catch ( e ) {
		console.log('ERROR get post ID: ' + str);
		str = 0;
	}
	
	return str;
}


// mỗi trang sẽ có một function được viết riêng vào đây
function function_rieng_theo_domain () {
	console.log(source_url);
	
	//
	var f = document.frm_leech_data;
	
	//
	if ( f.t_giacu.value != '' ) {
		f.t_giacu.value = g_func.number_only( f.t_giacu.value );
	}
	if ( f.t_giamoi.value != '' ) {
		f.t_giamoi.value = g_func.number_only( f.t_giamoi.value );
	}
	
	// lấy ảnh mặc định nếu có
	if ( f.t_img.value == '' ) {
		f.t_img.value = $('#details_finish_url li:last a').attr('data-img') || '';
	}
	
	// nếu vẫn không có -> thử lấy trong nội dung
	if ( f.t_img.value == '' ) {
//		f.t_img.value = $('#leech_data_fix_content img:first').attr('data-src') || '';
		f.t_img.value = firts_img_in_content;
//		console.log($('#leech_data_fix_content img:first').attr('data-src'));
	}
	
	//
	if ( source_url.split('vuonthangdung.vn').length > 1 ) {
		if ( f.post_tai.value == 'blog' ) {
			f.t_noidung.value = f.t_noidung.value.split('<div class="clearfix">')[0];
		}
	}
	else if ( source_url.split('thegioibang.com').length > 1 ) {
		var str_size = '';
		$('#size-list li').each(function() {
			var size_price = $('input  ', this).attr('data-price') || '';
			if ( size_price != '' ) {
				size_price = g_func.number_only(size_price);
				
				str_size += ',{name:"' + ( $('label ', this).html() || '' ) + '",val:"' + size_price + '"}';
			}
		});
		console.log(str_size);
		
		f.t_size_list.value = str_size;
		
		f.t_goithieu.value = (function ( str ) {
			if ( str == '' ) {
				return '';
			}
			
			return str.replace(/\<\/p\>/gi, "\n").replace(/\<p\>/gi, '');
		})( f.t_goithieu.value );
	}
	else if ( source_url.split('luxshopping.vn').length > 1 ) {
		f.t_masanpham.value = g_func.number_only( f.t_masanpham.value );
		
		//
		f.t_gallery.value = "";
		$('.thumblist img').each(function() {
			var a = $(this).attr('alt') || '';
//			console.log(a);
			
			if ( a != '' ) {
				a = full_url_for_img_src(a);
				f.t_gallery.value += a + "\n";
			}
		});
		
		//
		if ( f.t_goithieu.value != '' ) {
			f.t_goithieu.value = g_func.strip_tags(f.t_goithieu.value);
			
			var a = f.t_goithieu.value.split("\n");
			f.t_goithieu.value = "";
			
			for ( var i = 0; i < a.length; i++ ) {
				a[i] = g_func.trim(a[i]);
				
				if ( a[i] != '' ) {
					f.t_goithieu.value += a[i] + "\n";
				}
			}
		}
	}
	else if ( source_url.split('xwatch.vn').length > 1 ) {
		// xử lý lại đoạn giới thiệu
		var a = $('#details_goithieu').val() || '';
		if ( a != '' ) {
			console.log(a);
			
			// xóa các class linh tinh đi
			$(a + ' li, ' + a + ' div').removeAttr('class').removeAttr('style');
			// lấy lại html
			a = $(a).html() || '';
			
			if ( a != '' ) {
				a = a.replace(/\<\/li\>/gi, '[br]').replace(/\<li\>|\<div\>|\<\/div\>|\t/gi, '').split("\n");
				
				var str = '';
				for ( var i = 0; i < a.length; i++ ) {
					a[i] = g_func.trim(a[i]);
					
					if ( a[i] != '' ) {
						str += a[i];
						if ( a[i].slice(-1) == ':' ) {
							str += ' ';
						}
					}
				}
				a = str.replace(/\[br\]/gi, "\n");
			}
//			console.log(a);
			f.t_goithieu.value = a;
		}
		
		// gắp cả url (bao gồm ID) để giữ nguyên url cũ
		if ( f.t_source.value.split('/news/').length > 1
		|| f.t_source.value.split('/xchanel/').length > 1
		|| f.t_source.value.split('/blog/').length > 1 ) {
//		if ( f.t_source.value.split('/blog/').length > 1 ) {
			f.t_seo.value = (function ( str ) {
				return str.split('/').pop().split('.html')[0];
			})( f.t_source.value );
		}
		
		
		// tìm giá và mã sản phẩm
		var a = $('#aspnetForm').html() || '';
		if ( a != '' ) {
			a = a.split('TÌNH TRẠNG:')[0].split('Thongsokythuat.png')[0].split('</h1>');
			
			if ( a.length > 1 ) {
				a = a[1];
				
				//
//				console.log(a);
				
				var gia = a.split('GIÁ:');
				if ( gia.length > 1 ) {
//					console.log(gia[1]);
					
					try {
						gia = gia[1].split('</div>')[1].split('>')[1];
						gia = g_func.trim(gia);
						gia = g_func.number_only(gia);
//						console.log(gia);
						
						//
						if ( gia != '' && gia > 0 ) {
							f.t_giamoi.value = gia;
						}
					} catch (e) {
						console.log('Lỗi lọc giá sản phẩm');
					}
				}
				
				var msp = a.split('MÃ SẢN PHẨM:');
				if ( msp.length > 1 ) {
//					console.log(msp[1]);
					
					try {
						msp = msp[1].split('</div>')[1].split('>')[1];
						msp = g_func.trim(msp);
//						console.log(msp);
						
						//
						f.t_masanpham.value = msp;
					} catch (e) {
						console.log('Lỗi lọc mã sản phẩm');
					}
				}
			}
		}
	}
	
	// gallery kiểu mới
	if ( f.t_gallery.value != '' ) {
		var a = f.t_gallery.value.split("\n"),
			str = '';
		for ( var i = 0; i < a.length; i++ ) {
			a[i] = g_func.trim(a[i]);
			
			if ( a[i] != '' ) {
				str += '<div><img src="' + a[i] + '"></div>';
			}
		}
		f.t_gallery.value = str;
	}
}


function full_url_for_img_src ( a ) {
	if ( a.split('//').length == 1 ) {
		if ( a.substr( 0, 1 ) == '/' ) {
			a = a.substr( 1 );
		}
		
		a = source_url + a;
	}
	// nếu sử dụng url tương đối -> chuyển thành tuyệt đối
	else if ( a.substr( 0, 2 ) == '//' ) {
		if ( source_url.substr( 0, 5 ).toLowerCase() == 'https' ) {
			a = 'https:' + a;
		}
		else {
			a = 'http:' + a;
		}
	}
//	console.log( a );
	
	//
	return a.replace(/\.\.\//gi, '').split('?')[0].split('#')[0];
}

function set_source_url_leech ( str ) {
	// xác định url hiện tại của bài viết
	source_url = str.split('/');
	source_url = source_url[0] + '//' +source_url[2]+ '/';
//	console.log(source_url);
}



// lưu coookie của phiên làm việc
function leech_data_save_cookie ( nem, val ) {
	if ( typeof nem == 'undefined' || nem == '' ) {
		console.log( 'Cookie name' );
		return false;
	}
	
	g_func.setc( nem, val, 30 );
	
	console.log( 'Save cookies #' +nem+ ' with: ' + val );
}


// lấy nội dung dữ liệu gốc
function leech_data_content ( url, id, callBack ) {
	if ( typeof url == 'undefined' || url == '' ) {
		console.log('url not found');
		return false;
	}
	if ( typeof id == 'undefined' || id == '' ) {
		id = 'leech_data_html';
//		console.log('id not found');
//		return false;
	}
//	var new_bay = '';
//	if ( typeof new_bay == 'undefined' || new_bay == '' ) {
//		console.log('new_bay not found');
//		return false;
//	}
	console.log( web_link + url );
	
	$.ajax({
		type: 'POST',
		url: web_link + url,
		data: ''
	}).done(function(msg) {
		// chỉ lấy nội dung trong body
		try {
			msg = msg.replace( /\<\/head\>/gi, '</head>' ).replace( /\<\/html\>/gi, '</html>' );
			msg = msg.split('</head>');
			if ( msg.length > 1 ) {
				msg = msg[1];
			} else {
				msg = msg[0];
			}
			msg = msg.split('</html>')[0];
		} catch ( e ) {
			console.log(msg);
			
			console.log('name: ' + e.name + '; line: ' + (e.lineNumber || e.line) + '; script: ' + (e.fileName || e.sourceURL || e.script) + '; stack: ' + (e.stackTrace || e.stack) + '; message: ' + e.message);
			
//			ket_thuc_lay_du_lieu( 0, '<span class=redcolor>ERROR</span>' );
			ket_thuc_lay_du_lieu( 0, '<span class="redcolor cur" onclick="func_leech_data_lay_chi_tiet(\'' +current_url+ '\');">ERROR</span>' );
			
			return false;
		}
		
		// xóa bỏ mã ko liên quan
		msg = msg.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, " ");
//		msg = msg.replace(/<iframe \b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/gi, " ");
//		msg = msg.replace(/<link[^>]*>/gi, " ");
		msg = msg.replace(/<link.*?\/>/gi, " ");
		
		// đổi iframe -> video youtube
//		msg = msg.replace(/\sdata-src=/gi, " data-old-src=");
//		msg = msg.replace(/\ssrc=/gi, " data-src=");
		
		// đổi URL ảnh
		msg = msg.replace(/\sdata-src=/gi, " data-old-src=");
		msg = msg.replace(/\ssrc=/gi, " data-src=");
		
		//
//		console.log( msg );
		
		//
		if ( dog(id) == null ) {
			$('body').append('<div id="' +id+ '" class="d-none"></div>');
		}
		
		//
		var old_bay = $('base').attr('href');
		
		//
//		$('base').attr({
//			href : new_bay
//		});
		
		//
		$('#' + id).html(msg);
		
		//
//		setTimeout(function () {
//			$('base').attr({
//				href : old_bay
//			});
//		}, 2000);
		
		//
		if (typeof callBack == 'function') {
			callBack();
		}
	});
}


function func_leech_data_lay_chi_tiet ( push_url ) {
	// lấy thông số từ thẻ LI đầu tiên
	var a = $('#details_list_url li:first a').attr('href') || '',
		f = document.frm_leech_data;
	
	if ( typeof push_url != 'undefined' && push_url != '' ) {
		a = push_url;
	}
	current_url = a;
	
	//
//	f.reset();
	
	//
	a = g_func.trim(a);
	
	if ( a != '' ) {
	
		// lấy xong xóa
		$('#details_finish_url').append('<li>' + $('#details_list_url li:first').html() + '</li>');
		$('#details_list_url li:first').remove();
		
		//
//		console.log( a );
		f.t_source.value = a;
		
		//
		set_source_url_leech ( a );
		
		// ID bài viết
		f.t_id.value = '';
		if ( dog('bai_viet_nay_duoc_lay_theo_id').checked == true ) {
			f.t_id.value = get_leech_data_post_id ( f.t_source.value );
		}
		
		//
		leech_data_content ('temp/?set_module=leech_data&categories_url=' + encodeURIComponent( a ) + '&leech_id=' + f.t_id.value, '', function () {
			var f = document.frm_leech_data;
//			var img_tags = $('#details_img').val() || '';
			
			//
			var arr = {
				noidung_tags : {
					get : $('#details_noidung').val() || '',
					set : 't_noidung'
				},
				dieukien_tags : {
					get : $('#details_dieukien').val() || '',
					set : 't_dieukien'
				},
				goithieu_tags : {
					get : $('#details_goithieu').val() || '',
					set : 't_goithieu'
				},
				giacu_tags : {
					get : $('#details_giacu').val() || '',
					set : 't_giacu'
				},
				giamoi_tags : {
					get : $('#details_giamoi').val() || '',
					set : 't_giamoi'
				},
				tit_tags : {
					get : $('#details_title').val() || '',
					set : 't_tieude'
				},
				masanpham_tags : {
					get : $('#details_masanpham').val() || '',
					set : 't_masanpham'
				},
				img_tags : {
					get : $('#details_img').val() || '',
					set : 't_img',
					img : true
				},
				youtube_url_tags : {
					get : $('#details_youtube_url').val() || '',
					set : 't_youtube_url',
					youtube : true
				},
				gallery_tags : {
					get : $('#details_gallery').val() || '',
					set : 't_gallery',
					img : true
				}
			};
			
			//
			for ( var x in arr ) {
//				console.log( arr[x] );
				var a = '';
				
				//
				if ( arr[x].get != '' ) {
					
					// nếu là youtube video
					if ( typeof arr[x].youtube != 'undefined' ) {
						console.log(arr[x].get);
						a = $(arr[x].get).attr('data-old-src')
							|| $(arr[x].get).attr('data-src')
							|| $(arr[x].get).attr('src')
							|| '';
						console.log(a);
					}
					// nếu là hình ảnh
					else if ( typeof arr[x].img != 'undefined' ) {
						$(arr[x].get).each(function() {
							var str = $(this).attr('data-old-src')
								|| $(this).attr('data-src')
								|| $(this).attr('src')
								|| '';
							
							if ( str != '' ) {
								a += full_url_for_img_src(str) + "\n";
							}
						});
					}
					// mặc định là lấy chữ
					else {
						// nếu nội dung nằm ở 2 nơi -> sử dụng && để lấy
						var a2 = arr[x].get.replace(/\+\+/g, '&&').split( '&&' );
						for ( var i = 0; i < a2.length; i++ ) {
							a2[i] = g_func.trim( a2[i] );
							
							var str = '';
							
							// nếu là foreach để lấy dữ liệu -> có dấu :each ở cuối chuỗi
							if ( a2[i].split(':each').length > 1 ) {
								
								// xóa chữ each đi
								a2[i] = a2[i].split(':')[0];
								
								// xác định tag của foreach
								var tag_begin = a2[i].split(' ').pop().split('#')[0].split('.')[0],
									tag_end = '';
								if ( tag_begin != '' ) {
									tag_end = '</' + tag_begin + '>';
									tag_begin = '<' + tag_begin + '>';
								}
								
								$( a2[i] ).each(function() {
									str += tag_begin + ( $(this).html() || '' ) + tag_end;
								});
							} else {
								str = $( a2[i] ).html() || '';
								str = g_func.trim( str );
							}
							
							//
							a += str;
						}
					}
					a = g_func.trim( a );
//					console.log(a);
				}
				
				//
				$('form[name=\'frm_leech_data\'] input[name=\'' +arr[x].set+ '\'], form[name=\'frm_leech_data\'] textarea[name=\'' +arr[x].set+ '\']').val( a );
			}
			
			//
			if ( f.t_tieude.value == '' ) {
				console.log( $('#leech_data_html').html() );
				
				//
				console.log('Không tìm thấy tiêu đề sản phẩm');
				ket_thuc_lay_du_lieu( 0, '<span class="redcolor cur" onclick="func_leech_data_lay_chi_tiet(\'' +current_url+ '\');">ERROR</span>' );
				
				//
				return false;
			}
			
			// bỏ tag HTML
			f.t_tieude.value = g_func.strip_tags( f.t_tieude.value );
			f.t_tieude.value = f.t_tieude.value.replace(/\s+\s/g, " ");
			f.t_tieude.value = f.t_tieude.value.replace(/\s+\s/g, " ");
			
			// Tạo URL SEO
			f.t_seo.value = g_func.non_mark_seo( f.t_tieude.value );
			
			
			
			
			
			
			/*
			* chỉnh lại phần nội dung
			*/
			dog( 'leech_data_fix_content', f.t_noidung.value );
//			console.log($('#leech_data_fix_content').html());
			
			// URL
			if ( dog('loai_bo_url_trong_noi_dung').checked == true ) {
				$('#leech_data_fix_content a').each(function() {
					var a = $(this).attr('href') || '';
					
					$(this).attr({
						'data-href' : a,
						rel : 'nofollow',
						href : 'javascript:;'
					});
				});
			}
			
			// hình ảnh
			firts_img_in_content = '';
			$('#leech_data_fix_content img').each(function() {
				var a = $(this).attr('data-src') || '';
//				console.log(a);
				
				// kiểm tra URL ảnh có link tuyệt đối chưa
				if ( a != '' && a.split('//').length == 1 ) {
					if ( a.substr( 0, 1 ) == '/' ) {
						a = a.substr( 1 );
					}
					a = source_url + a;
//					console.log(a);
					
					//
					if ( firts_img_in_content == '' ) {
						firts_img_in_content = a;
					}
					
					// chưa có thì gán thêm vào
					$(this).attr({
						'data-src' : a
					});
				}
			});
//			console.log($('#leech_data_fix_content').html());
			
			//
			f.t_noidung.value = $('#leech_data_fix_content').html();
			
			//
			f.t_noidung.value = f.t_noidung.value.replace(/\n|\r|\t/g, ' ');
			f.t_noidung.value = f.t_noidung.value.replace(/\sdata-src=/gi, " src=");
//			$('form[name=\'frm_leech_data\'] textarea[name=\'t_noidung\']').change();
//			return false;
			
			
			
			
			
			
			/*
			* chỉnh lại phần nội dung
			*/
			dog( 'leech_data_fix_content', f.t_dieukien.value );
//			console.log($('#leech_data_fix_content').html());
			
			// URL
			/*
			if ( dog('loai_bo_url_trong_noi_dung').checked == true ) {
				$('#leech_data_fix_content a').each(function() {
					var a = $(this).attr('href') || '';
					
					$(this).attr({
						'data-href' : a,
						rel : 'nofollow',
						href : 'javascript:;'
					});
				});
			}
			
			// hình ảnh
			$('#leech_data_fix_content img').each(function() {
				var a = $(this).attr('data-src') || '';
//				console.log(a);
				
				// kiểm tra URL ảnh có link tuyệt đối chưa
				if ( a != '' && a.split('//').length == 1 ) {
					if ( a.substr( 0, 1 ) == '/' ) {
						a = a.substr( 1 );
					}
					a = source_url + a;
//					console.log(a);
					
					// chưa có thì gán thêm vào
					$(this).attr({
						'data-src' : a
					});
				}
			});
			*/
//			console.log($('#leech_data_fix_content').html());
			
			//
			f.t_dieukien.value = $('#leech_data_fix_content').html();
			
			//
			f.t_dieukien.value = f.t_dieukien.value.replace(/\n|\r|\t/g, ' ');
			f.t_dieukien.value = f.t_dieukien.value.replace(/\sdata-src=/gi, " src=");
//			$('form[name=\'frm_leech_data\'] textarea[name=\'t_dieukien\']').change();
//			return false;
			
			
			
			
			
			//
			/*
			if ( img_tags != '' ) {
				var a = $(img_tags).attr('data-old-src') || $(img_tags).attr('data-src') || '';
				
				// full url nếu chưa có
				a = full_url_for_img_src( a );
				
				f.t_img.value = a;
			}
			*/
			
			//
			function_rieng_theo_domain();
			
//			if ( check_lech_data_submit() == false ) return false;
			
			//
			if ( dog('leech_data_auto_next').checked == true ) {
				f.submit();
			}
		});
	}
	else {
		$('.click-submit-url-categories').click();
//		$('#categories_url').change();
//		alert('Không tìm thấy dữ liệu nguồn');
	}
}

//
function check_lech_data_submit ( _alert ) {
	
	var f = document.frm_leech_data;
	
	// ID phân nhóm
	f.t_ant.value = g_func.number_only( $('#oiAnt input[name="t_ant"]').val() || 0 );
	if ( f.t_ant.value.toString() == '0' ) {
//		console.log( f.t_ant.value );
		
		if ( typeof _alert != 'undefined' && _alert == 'no' ) {
		}
		else {
			alert('Không thấy phân nhóm sản phẩm');
			
			window.scroll( 0, $('#oiAnt').offset().top - 90 );
		}
		
		return false;
	}
	
	// nếu có dữ liệu cache chưa được lưu -> lưu xong mới tiếp tục đoạn này
	if ( auto_submit_save_domain_cookies == true ) {
		EBE_auto_save_domain_cookie();
		
		//
		/*
		setTimeout(function () {
			document.frm_leech_data.submit();
		}, 5000);
		*/
		
//		return 2;
	}
	
	//
	return true;
}

function ket_thuc_lay_du_lieu ( id, m, lnk ) {
	if ( typeof id == 'number' && id > 0 ) {
		console.log(lnk);
		
		$('#details_finish_url li:last').append( ' - <a href="' +lnk+ '" target="_blank">' +m+ '</a>' );
	} else {
		$('#details_finish_url li:last').append( ' - ' +m );
	}
	
	
	// tiếp tục lấy link tiếp theo
	setTimeout(function () {
		if ( gian_cach_submit > 999 && dog('leech_data_auto_next').checked == true ) {
			func_leech_data_lay_chi_tiet();
		}
	}, gian_cach_submit);
}






$('#categories_url').off('change').change(function () {
	var a = $(this).val() || '';
	console.log(a);
	
	// nếu là url trang chi tiết -> hiển thị chi tiết luôn
	if ( dog('this_id_url_product_detail').checked == true ) {
		a = a.split("\n");
		var str = '';
		
		for ( var i = 0; i < a.length; i++ ) {
			a[i] = g_func.trim( a[i] );
			
			if ( a[i] != '' ) {
				str += '<li><a href="' +a[i]+ '" target="_blank" rel="nofollow">' +a[i]+ '</a></li>';
			}
		}
		
		// gán d.sách tìm được
		$('#details_list_url').html( str );
		$('#categories_url').val( '' ).focus();
		
		return false;
	}
	
	// lấy URL phân nhóm để làm việc
	a = a.split("\n");
	var str = '';
	for ( var i = 0; i < a.length; i++ ) {
		a[i] = g_func.trim( a[i] );
		
		if ( a[i] != '' ) {
			if ( EBE_current_first_domain == '' ) {
//				console.log( a[i] );
				EBE_current_first_domain = a[i];
			}
			
			//
			str += '<li>' + a[i] + '</li>';
		}
	}
	
	//
	if ( typeof a[0] != 'undefined' && a[0] != '' ) {
		console.log( a[0] );
		g_func.setc( 'ck_old_categories_url', a[0], 30 );
		
		//
		set_source_url_leech ( a[0] );
	}
	
	//
//	console.log( str );
	
	//
	$('#categories_list_url').append( str );
	$('#categories_url').val( '' ).focus();
	
	
	
	//
	EBE_save_cookie_to_data_base();
	
	// nạp lại dữ liệu nếu người dùng thay đổi URL
	for ( var x in arr_cookie_lamviec ) {
		if ( $( '#' + x ).length > 0 ) {
			$( '#' + x ).val( arr_for_save_domain_config[EBE_current_first_domain][x] );
		}
	}
	
});


function EBE_save_cookie_to_data_base () {
	
	//
	if ( EBE_current_first_domain == '' ) {
		console.log( 'EBE_current_first_domain not found' );
		return false;
	}
	
	// Chạy vòng lặp để tạo mảng lưu cookie vào database
	console.log( EBE_current_first_domain );
	if ( EBE_current_first_domain.split('//').length > 1 ) {
		EBE_current_first_domain = EBE_current_first_domain.split('//')[1].split('/')[0];
		console.log( EBE_current_first_domain );
		EBE_current_first_domain = EBE_current_first_domain.replace(/\./gi, '_');
		console.log( EBE_current_first_domain );
	}
	
	//
	if ( typeof arr_for_save_domain_config[EBE_current_first_domain] != 'object' ) {
		arr_for_save_domain_config[EBE_current_first_domain] = arr_cookie_lamviec;
	}
	console.log( arr_for_save_domain_config );
	
	//
	for ( var x in arr_cookie_lamviec ) {
		arr_for_save_domain_config[EBE_current_first_domain][x] = $( '#' + x ).val() || '';
	}
	console.log( arr_for_save_domain_config );
	
	
	//
	document.frm_leech_data_save.t_noidung.value = escape( JSON.stringify( arr_for_save_domain_config ) );
	
	//
	auto_submit_save_domain_cookies = true;
	
}


function EBE_auto_save_domain_cookie () {
	if ( auto_submit_save_domain_cookies == true ) {
		console.log( 'Auto save, while 60 secondes' );
		auto_submit_save_domain_cookies = false;
		
		//
		document.frm_leech_data_save.submit();
	}
}



//
setInterval(function () {
	EBE_auto_save_domain_cookie();
//}, 5000);
}, 60 * 1000);


//
(function () {
	var a = g_func.getc( 'ck_old_categories_url' );
	
	// nạp dữ liệu từ phiên làm việc cũ
	if ( a != null ) {
		$('#categories_url').val( a );
	}
})();


$('.click-submit-url-details').off('click').click(function () {
	
	var a = check_lech_data_submit( 'no' );
	
	if ( a != true ) {
		/*
		if ( a == 2 ) {
			alert('Tự động chạy sau 5 giây');
			return false;
		}
		else */ if ( confirm( 'Chưa chọn Phân nhóm sản phẩm! Bạn có muốn chọn lại không?' ) == true ) {
			return false;
		}
	}
	
	
	
	// gọi function lấy chi tiết sản phẩm
	func_leech_data_lay_chi_tiet ();
	
});



$('.click-submit-url-categories').off('click').click(function () {
	
	//
	var html_tags = $('#categories_tags').val() || '';
	
	//
	if ( html_tags == '' ) {
		alert('html_tags không được để trống');
		$('#categories_tags').focus();
		return false;
	}
	
	//
	a = $('#categories_list_url li:first').html() || '',
	a = g_func.trim( a );
	
	// nếu có URL -> tiếp tục
	if ( a != '' ) {
		
		//
		$('#categories_list_finish').append( '<li>' +$('#categories_list_url li:first').html()+ '</li>' );
		$('#categories_list_url li:first').remove();
		
		//
		window.scroll( 0, $('#details_list_url').offset().top - 90 );
		
		//
		leech_data_content ('temp/?set_module=leech_data&categories_url=' + encodeURIComponent( a ), '', function () {
			
			var str = '',
				arr_exist = {};
			
			$( html_tags ).each(function() {
				var a = $(this).attr('href') || $('a', this).attr('href') || '',
					img = $('img', this).attr('data-src') || $('img', this).attr('src') || $(this).attr('data-img') || '';
				
				// full url nếu chưa có
				a = full_url_for_img_src(a);
				console.log( a );
				
				if ( img != '' ) {
					img = full_url_for_img_src(img);
				}
//				console.log( img );
				
				//
				if ( typeof arr_exist[a] == 'undefined' ) {
					arr_exist[a] = 1;
					
					str += '<li><a href="' +a+ '" data-img="' + img + '" target="_blank" rel="nofollow">' +a+ '</a></li>';
				} else {
					console.log('URL exist: ' + a);
				}
			});
			
			// gán d.sách tìm được
			$('#details_list_url').html( str );
			
			//
			if ( dog('leech_data_auto_next').checked == true ) {
				var check_ant_select = g_func.number_only( $('#oiAnt input[name="t_ant"]').val() || 0 );
				
				if ( check_ant_select > 0 ) {
					$('.click-submit-url-details').click();
				} else {
					console.log('Select categories for auto leech');
				}
			} else {
				console.log('Check leech_data_auto_next to auto leech');
			}
		});
	}
	else {
		console.log('Không tìm thấy danh sách nhóm cần lấy sản phẩm');
	}
});



/*
* Nhớ 1 số thao tác trước đó
*/
(function () {
	var arr = [
		'loai_bo_url_trong_noi_dung',
		'bai_viet_nay_duoc_lay_theo_id',
		'this_id_url_product_detail',
		'leech_data_auto_next'
	];
	
	for ( var i = 0; i < arr.length; i++ ) {
//		console.log(arr[i]);
		
		//
		$( '#' + arr[i] ).off('click').click(function () {
			var a = $(this).attr('id') || '';
			
			if ( a == '' ) {
				console.log('ID cookie not found');
				return false;
			}
			
			//
			if ( dog( a ).checked == true ) {
				g_func.setc( a, 1, 30 );
			} else {
				g_func.setc( a, 0, 30 );
			}
		});
		
		//
		if ( g_func.getc( arr[i] ) == 1 ) {
			dog(arr[i]).checked = true;
		}
	}
	
	
	//
	var a = 'select_name_post_tai';
	$('select[name="post_tai"]').change(function () {
		var a = 'select_name_post_tai';
//		console.log(a);
		g_func.setc( a, $(this).val(), 30 );
	});
	
	//
	a = g_func.getc( a );
//	console.log( a );
	if ( a != null && typeof a == 'string' ) {
		$('select[name="post_tai"]').val(a)
		|| $('select[name="post_tai"]').val(a).change()
		|| $('select[name="post_tai"] option[value="' +a+ '"]').attr('selected','selected');
	}
})();


/*
$('#leech_data_auto_next').off('click').click(function () {
	if ( dog('leech_data_auto_next').checked == true ) {
		g_func.setc( 'leech_data_auto_next', 1, 30 );
	} else {
		g_func.setc( 'leech_data_auto_next', 0, 30 );
	}
});

//
if ( g_func.getc( 'leech_data_auto_next' ) == 1 ) {
	dog('leech_data_auto_next').checked = true;
}
*/



//
//fix_textarea_height();



// lưu cookies cho phiên làm việc -> lưu và làm dưới dạng mảng cho thống nhất
var arr_cookie_lamviec = {
	id_post_begin : '',
	id_post_end : '',
	
	details_noidung : '',
	details_dieukien : '',
	details_goithieu : '',
	details_giacu : '',
	details_giamoi : '',
	details_img : '',
	details_youtube_url : '',
	details_title : '',
	details_masanpham : '',
	details_gallery : '',
	categories_tags : ''
};

(function () {
	for ( var x in arr_cookie_lamviec ) {
		if ( dog( x ) != null ) {
			var a_name = 'leech_data_' + x,
				a = g_func.getc( a_name );
//			console.log( a_name );
//			console.log( a );
			
			// nạp dữ liệu từ phiên làm việc cũ
			if ( a != null ) {
				// gán lại dữ liệu
				$( '#' + x ).val( a );
				
				// gia hạn lại cookie
				leech_data_save_cookie( a_name, a );
			}
			
			// đặt tên để lưu cookie mỗi khi có sự thay đổi
			$( '#' + x ).attr({
				cname : a_name
			});
			
			// lưu cookies mới khi có sự thay đổi
			$( '#' + x ).off('change').change(function () {
				leech_data_save_cookie( $(this).attr('cname'), $(this).val() || '' );
				
				EBE_save_cookie_to_data_base();
			});
		}
	}
})();



//
//categories_list_v3();

// chèn thêm phân nhóm của blog/ tin tức
$('#oiBlogAnt option[data-show="1"], #oiBlogAnt option[value="0"]').remove();
$('#oiAnt option:last').before( $('#oiBlogAnt select').html() );

//
eb_drop_menu('oiAnt');




// TEST
/*
if ( window.location.href.split('localhost').length > 1 ) {
	$('#categories_url').val( 'https://xwatchluxury.vn/dong-ho-nam/' ).change();
	$('.click-submit-url-categories').click();
}
/**/


