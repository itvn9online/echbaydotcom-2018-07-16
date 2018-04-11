



//
var EBE_current_first_domain = '',
	auto_submit_save_domain_cookies = false,
	source_url = '',
	current_url = '',
	// giãn cách cập nhật tin
	gian_cach_submit = 2 * 1000,
	firts_img_in_content = '',
	cache_name_for_download_img = '',
	download_img_runing = 0,
	arr_check_value_exist = {},
	tu_dong_load_lai_trang_neu_submit_loi = 0,
	// hẹn mỗi 10 giây load 1 lần, nên số cài đặt ở đây sẽ nhân với 10
	limit_time_for_reload_this_page = 12,
	// Dành để load các tag không trong cùng function
	current_loading_tags = '';



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
function num_leech_data_post_id ( i ) {
	// ID chỉ là dạng số -> tích vào để loại bỏ các ký tự không phải số
	if ( dog('post_id_is_numberic').checked == true ) {
		return g_func.number_only( i );
	}
	return i;
}

function get_leech_data_post_id ( str, vitri ) {
	console.log(str);
	
	var b = $('#id_post_begin').val() || '',
		e = $('#id_post_end').val() || '',
		a = null;
	
	
	// nếu điểm bắt đầu chỉ có 1 ký tự
	if ( b.length == 1 ) {
		// nếu không có điểm kết thúc -> lấy ngay vị trí cuối cùng
		if ( e == '' ) {
			a = str.split( b )[0];
		}
		// nếu có điểm kết thúc -> lấy mảng ngay trước vị trí kết thúc
		else {
			a = str.split( e )[0].split( b );
		}
		return num_leech_data_post_id( a[ a.length - 1 ] );
	}
	// nếu có điều kiện để lọc ID
	else if ( b != '' ) {
		// Tách theo điều kiện nếu có nhiều điều kiện để lấy ID
		b = b.split( '||' );
		for ( var i = 0; i < b.length; i++ ) {
			a = str.split( $.trim( b[i] ) );
//			console.log(a);
			if ( a.length > 1 ) {
				str = a[1];
				if ( e != '' ) {
					str = str.split( e )[0];
				}
				return num_leech_data_post_id( str );
			}
		}
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
			str = str.split('-').pop().split('.')[0].split('/')[0].split('?')[0].split('&')[0];
			
			str = num_leech_data_post_id( str );
		}
	} catch ( e ) {
		console.log('ERROR get post ID: ' + str);
		console.log( WGR_show_try_catch_err( e ) );
		str = 0;
	}
	
	return str;
}


// mỗi trang sẽ có một function được viết riêng vào đây
function function_rieng_theo_domain () {
	console.log(source_url);
	
	//
	var f = document.frm_leech_data,
		current_img_domain = document.domain;
	
	//
	var format_price = $('#details_format_price').val() || '';
	if ( f.t_giacu.value != '' ) {
		if ( format_price == '' ) {
			f.t_giacu.value = g_func.number_only( f.t_giacu.value );
		}
		else {
			f.t_giacu.value = f.t_giacu.value.toString().replace( eval(format_price), '');
		}
	}
	if ( f.t_giamoi.value != '' ) {
		if ( format_price == '' ) {
			f.t_giamoi.value = g_func.number_only( f.t_giamoi.value );
		}
		else {
			f.t_giamoi.value = f.t_giamoi.value.toString().replace( eval(format_price), '');
		}
	}
	
	// lấy ảnh mặc định nếu có
	if ( f.t_img.value == '' ) {
		f.t_img.value = $('#details_finish_url li:last a').attr('data-img') || '';
		
		// nếu vẫn không có -> thử lấy trong nội dung
		if ( f.t_img.value == '' ) {
//			f.t_img.value = $('#leech_data_fix_content img:first').attr('data-src') || '';
			f.t_img.value = firts_img_in_content;
//			console.log($('#leech_data_fix_content img:first').attr('data-src'));
		}
	}
	
	//
	if ( typeof custom_func_leech_data_by_theme == 'function' ) {
		console.log('custom_func_leech_data_by_theme running...');
		custom_func_leech_data_by_theme( f );
	}
	
	// gallery kiểu mới
	if ( f.t_gallery.value != '' ) {
		var a = f.t_gallery.value.split("\n"),
			str = '';
		for ( var i = 0; i < a.length; i++ ) {
			a[i] = g_func.trim(a[i]);
			
			if ( a[i] != '' ) {
				if ( f.t_img.value == '' ) {
					f.t_img.value = a[i];
				}
				
				//
				str += '<div><img src="' + a[i] + '" /></div>';
			}
		}
		f.t_gallery.value = str;
	}
	
	//
	if ( dog('download_img_to_my_host').checked == true ) {
		// download ảnh đại diện
		f.t_img.value = func_download_img_to_my_host( f.t_img.value, current_img_domain );
		
		// download ảnh trong nội dung
		dog( 'leech_data_fix_content', f.t_noidung.value.replace(/\ssrc=/gi, " download-src=") );
//		console.log( $('#leech_data_fix_content').html() );
		
		//
		if ( $('#leech_data_fix_content img').length > 0 ) {
			$('#leech_data_fix_content img').addClass('download-img-to-here');
//			console.log( $('#leech_data_fix_content').html() );
			
			func_download_img_content_to_my_host();
		}
		else {
			auto_submit_after_download_img();
		}
	}
	
}


function auto_submit_after_download_img () {
	if ( dog('leech_data_auto_next').checked == false ) {
		console.log('Auto submit not tick!');
		return false;
	}
	
	// Nếu quá trình download đang diễn ra -> chờ
	if ( download_img_runing == 1 ) {
		setTimeout(function () {
			auto_submit_after_download_img();
		}, 800);
		
		return false;
	}
	
	//
	console.log('Auto submit after download img!');
	setTimeout(function () {
		document.frm_leech_data.submit();
	}, 800);
}

function func_download_img_content_to_my_host () {
	if ( download_img_runing == 1 ) {
		console.log('download is runing...');
		
		// hẹn giờ download lại, cho tới khi download xong cái ảnh này mới thôi
		setTimeout(function () {
			func_download_img_content_to_my_host();
		}, 600);
		
		return false;
	}
	
	// không có -> có thể là xong rồi -> finish thôi
	if ( $('#leech_data_fix_content img.download-img-to-here').length == 0 ) {
		console.log('img for download not found!');
//		console.log( $('#leech_data_fix_content').html() );
		
		var add_content = $('#leech_data_fix_content').html() || '';
		document.frm_leech_data.t_noidung.value = add_content.replace(/\sdownload-src=/gi, " src=");
		
		auto_submit_after_download_img();
		
		return false;
	}
	var dm = document.domain;
	
	// tìm src xem có không
	var img = $('#leech_data_fix_content img.download-img-to-here:first').attr('download-src') || '';
	if ( img == '' ) {
		console.log('src for download not found!');
		return false;
	}
	
	// lấy tên file sẽ được download
	var file_name = decodeURIComponent(img).split('/');
	file_name = file_name[ file_name.length - 1 ];
	
	// tạo url file download luôn
	$('#leech_data_fix_content img.download-img-to-here:first').attr({
		'download-src': web_link + 'ebarchive/' + year_curent + '/' + file_name
	}).removeClass('download-img-to-here');
	
	// bắt đầu download ảnh về host
	func_download_img_to_my_host( img, dm );
	
	// lấy tiếp ảnh tiếp theo
	func_download_img_content_to_my_host();
}

function func_download_img_to_my_host ( img, dm ) {
//	console.log( img );
//	console.log( dm );
	if ( typeof img == 'undefined' || img == '' ) {
		return '';
	}
	
	// nếu ảnh chưa được download -> download về thôi
	if ( img.split('/' + dm + '/').length == 1 ) {
		var download_url = web_link + 'download_img_to_site/?img=' + encodeURIComponent( img );
		var file_name = decodeURIComponent(img).split('/');
		file_name = file_name[ file_name.length - 1 ];
		download_url += '&file_name=' + file_name;
		
		// thư mục download theo năm
		download_url += '&set_year=' + year_curent;
		
		// hiển thị url ảnh luôn và ngay
		download_url += '&show_url_img=1';
		
		//
//		console.log( download_url );
		
		//
		download_img_runing = 1;
		ajaxl(download_url, 'oi_download_img_to_my_host', 1, function () {
			var a = $('#oi_download_img_to_my_host').html();
			console.log( a );
			
			//
//			cache_name_for_download_img = a;
			download_img_runing = 0;
		});
		
		//
		return web_link + 'ebarchive/' + year_curent + '/' + file_name;
	}
	
	return img;
}


function check_category_by_auto_slug ( a, alert_now ) {
	// nếu có lệnh tự xác định nhóm đi kèm -> xác định luôn
	if ( a.split('|').length > 1 ) {
		a = a.split('|');
		
		var auto_category = $.trim( a[1] ),
			auto_category2 = '';
		
		//
		/*
		if ( a.length > 2 ) {
			auto_category2 = $.trim( a[2] );
		}
		*/
		
		//
		if ( auto_category != '' ) {
//			console.log(auto_category);
			auto_category = g_func.non_mark_seo( auto_category );
			auto_category = auto_category.replace( /\-/g, '' );
//			console.log(auto_category);
			
			//
			/*
			if ( auto_category2 != '' ) {
//				console.log(auto_category2);
				auto_category2 = g_func.non_mark_seo( auto_category2 );
				auto_category2 = auto_category2.replace( /\-/g, '' );
//				console.log(auto_category2);
			}
			*/
			
			//
			$('#oiAnt input[type="text"]').val( 0 );
			var tim_thay_category = 0;
			$('#oiAnt ul li').each(function() {
				var a = $(this).attr('data-key') || '',
					b = $(this).attr('data-value') || '',
					slug = $(this).attr('data-slug') || '';
				
				//
				if ( b != '' && a != '' ) {
					a = a.substr( b.toString().length );
					
//					if ( a == auto_category ) {
					// Lấy theo slug cho nó chuẩn chỉ
					if ( slug == auto_category ) {
//					if ( a == auto_category || slug == auto_category ) {
//					if ( a == auto_category || a == auto_category2 ) {
						document.frm_leech_data.t_ant.value = b;
						$('#oiAnt input[name="t_ant"]').val( b );
						
						$('#oiAnt input[type="text"]').val( a );
						
						tim_thay_category = 1;
						
						return false;
					}
				}
			});
			
			//
			if ( tim_thay_category == 0 ) {
				if ( typeof alert_now != 'undefined' && alert_now == 1 ) {
					alert('Không tìm thấy category by slug: ' + auto_category);
				}
				
				console.log('Slug: ' + auto_category);
				
				return false;
			}
		}
		
		a = $.trim( a[0] );
	}
	
	return a;
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
	
	g_func.setc( nem, val, 0, 30 );
	
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
	url = web_link + url + '&source_url=' + encodeURIComponent( source_url );
	console.log( url );
	
	//
	$('body').css({
		opacity: .5
	});
	
	$.ajax({
		type: 'POST',
		url: url,
		data: ''
	}).done(function(msg) {
		try {
			// v2 -> đổi các thẻ dùng để tải dữ liệu -> giúp xử lý các thẻ này dễ hơn
			if ( dog('get_full_code_in_head').checked == true ) {
				msg = msg.replace( /\<html/gi, '<eb-html' )
					.replace( /\<\/html\>/gi, '</eb-html>' )
					//
					.replace( /\<head/gi, '<eb-head' )
					.replace( /\<\/head\>/gi, '</eb-head>' );
			}
			// v1 -> chỉ lấy nội dung trong body
			else {
				// đổi về viết thường cho đảm bảo lệnh sẽ chạy luôn đúng
				msg = msg.replace( /\<\/head\>/gi, '</head>' ).replace( /\<\/html\>/gi, '</html>' );
				msg = msg.split('</head>');
				if ( msg.length > 1 ) {
					msg = msg[1];
				} else {
					msg = msg[0];
				}
				msg = msg.split('</html>')[0];
			}
			
			//
			msg = msg.replace( /\<iframe/gi, '<eb-iframe' )
				.replace( /\<\/iframe\>/gi, '</eb-iframe>' )
				//
				.replace( /\<link/gi, '<eb-link' )
				//
				.replace( /\<script/gi, '<eb-script' )
				.replace( /\<\/script\>/gi, '</eb-script>' );
			
			//
			msg = msg.split( web_link ).join(source_url);
		} catch ( e ) {
			console.log(msg);
			
			console.log( WGR_show_try_catch_err( e ) );
			
//			ket_thuc_lay_du_lieu( 0, '<span class=redcolor>ERROR</span>' );
			ket_thuc_lay_du_lieu( 0, '<span class="redcolor cur" onclick="func_leech_data_lay_chi_tiet(\'' +current_url+ '\');">ERROR</span>' );
			
			return false;
		}
		
		// xóa bỏ mã ko liên quan
		/*
		msg = msg.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, " ");
//		msg = msg.replace(/<iframe \b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/gi, " ");
//		msg = msg.replace(/<link[^>]*>/gi, " ");
		msg = msg.replace(/<link.*?\/>/gi, " ");
		*/
		
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
		
		//
		$('body').css({
			opacity: 1
		});
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
		// dọn dẹp bớt HTML cho đỡ nhiều quá
		if ( $('#details_finish_url li').length > 50 ) {
			$('#details_finish_url').html('');
		}
		
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
				ngaydang_tags : {
					get : $('#details_ngaydang').val() || '',
					set : 't_ngaydang'
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
				arr[x].get = $.trim( arr[x].get );
				
				//
				if ( arr[x].get != '' ) {
					
					//
					arr[x].get = arr[x].get.replace(/\s\s/g, ' ').replace(/\s\s/g, ' ');
					
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
					else if ( typeof arr[x].img != 'undefined' && arr[x].img != '' ) {
						var arr_get_img = arr[x].get.replace(/\s?\|\|\s?/g, ',');
						
						// nếu là chuyển đổi theo attr cụ thể
						if ( arr_get_img.split('[').length > 1 ) {
							arr_get_img = arr_get_img.split(',');
							
							var str = '';
							
							for ( var z = 0; z < arr_get_img.length; z++ ) {
								var get_attr = arr_get_img[z].split('[');
								console.log(get_attr);
								
								if ( get_attr.length > 1 ) {
//									console.log(get_attr[0]);
//									console.log(get_attr[1]);
//									console.log(get_attr[1].split(']')[0]);
									
									if ( str == '' ) {
										str = $( get_attr[0] ).attr( get_attr[1].split(']')[0] ) || '';
									}
								}
								else {
									if ( str == '' ) {
										str = $( get_attr[0] ).attr('data-old-src')
										|| $( get_attr[0] ).attr('data-src')
										|| $( get_attr[0] ).attr('src')
										|| '';
									}
								}
								
								//
								if ( str != '' ) {
									a += full_url_for_img_src(str) + "\n";
								}
							}
						}
						else {
							// thay dấu || thành dấu , để chạy vòng lặp each
							$( arr_get_img ).each(function() {
								var str = $(this).attr('data-old-src')
									|| $(this).attr('data-src')
									|| $(this).attr('src')
									|| '';
								
								if ( str != '' ) {
									a += full_url_for_img_src(str) + "\n";
								}
							});
						}
					}
					// mặc định là lấy chữ
					else {
						// nếu nội dung nằm ở 2 nơi -> sử dụng && để lấy
						var a2 = arr[x].get.replace(/\s?\+\+\s?/g, '&&').split( '&&' );
						
						//
						for ( var i = 0; i < a2.length; i++ ) {
							a2[i] = g_func.trim( a2[i] );
							
							var str = '',
								eachn = 0;
							
							// nếu là foreach để lấy dữ liệu -> có dấu :each ở cuối chuỗi
//							if ( a2[i].split(':each').length > 1 || a2[i].split(':each').length > 1 ) {
							if ( a2[i].split(':each').length > 1 ) {
								// cắt chuỗi để xử lý dữ liệu
								var str_query = a2[i].split(',');
								
								// chạy vòng lặp lần nữa, vì ech vẫn có thể đi kèm với multi class (dấy phẩy)
								for ( var j = 0; j < str_query.length; j++ ) {
									if ( str_query[j].split(':each').length > 1 ) {
										eachn = 0;
										if ( str_query[j].split(':eachn').length > 1 ) {
											eachn = 1;
										}
										
										// xóa chữ each đi
										str_query[j] = str_query[j].split(':')[0];
										
										// xác định tag của foreach
										var tag_begin = str_query[j].split(' ').pop().split('#')[0].split('.')[0],
											tag_end = '',
											str_each = '';
										if ( tag_begin != '' ) {
											tag_end = '</' + tag_begin + '>';
											tag_begin = '<' + tag_begin + '>';
										}
										
										// bắt đầu vòng lặp
										$( str_query[j].replace(/\s?\|\|\s?/g, ',') ).each(function() {
											var get_html = $(this).html() || '';
											
											// nếu có nội dung
											if ( get_html != '' ) {
												// sử dụng \n
												if ( eachn == 1 ) {
													str_each += get_html + "\n";
												}
												// sử dụng tag
												else {
													str_each += tag_begin + get_html + tag_end;
												}
											}
										});
										
										// đối với LI -> gán thêm UL vào
										if ( str_each != '' ) {
											if ( eachn == 0 && tag_end.toLowerCase() == '</li>' ) {
												str += '<ul>' + str_each + '</ul>';
											}
											else {
												str += str_each;
											}
										}
									}
									else {
										str = $( str_query[j] ).html() || '';
										str = g_func.trim( str );
										
										// tìm được phát -> thoát luôn
										if ( str != '' ) {
											break;
										}
									}
								}
							}
							// gọi trực tiếp đến class được nhắc đến
							else {
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
				ket_thuc_lay_du_lieu( 0, '<span class="redcolor cur" onclick="func_leech_data_lay_chi_tiet(\'' +current_url+ '\');">ERROR (not title)</span>' );
				
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
			// xóa bỏ các dấu cách
			// 2 dấu cách -> 1 dấu cách
			f.t_noidung.value = f.t_noidung.value.replace( /\&nbsp\;/gi, ' ' ).replace(/\s+\s/g, " ");
			
			dog( 'leech_data_fix_content', f.t_noidung.value );
//			console.log($('#leech_data_fix_content').html());
			
			// URL
			if ( dog('loai_bo_a_trong_noi_dung').checked == true ) {
				$('#leech_data_fix_content a').each(function() {
					// xóa hẳn thẻ A
					$(this).after( $(this).html() ).remove();
				});
			}
			else if ( dog('loai_bo_url_trong_noi_dung').checked == true ) {
				$('#leech_data_fix_content a').each(function() {
					// xóa URL
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
			if ( dog('download_img_to_my_host').checked == false
			&& dog('leech_data_auto_next').checked == true ) {
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
	
	// reset lại chế độ load toàn trang
	tu_dong_load_lai_trang_neu_submit_loi = 0;
	
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
			
			if ( a[i].substr( 0, 1 ) == '#' ) {
				a[i] = '';
			}
			else if ( a[i] != '' && a[i].split('//').length > 1 ) {
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
	var str = '',
		str_slug_error = '';
	for ( var i = 0; i < a.length; i++ ) {
		a[i] = g_func.trim( a[i] );
		
		if ( a[i].substr( 0, 1 ) == '#' ) {
			a[i] = '';
		}
		else if ( a[i] != '' && a[i].split('//').length > 1 ) {
			if ( check_category_by_auto_slug( a[i] ) != false ) {
				if ( EBE_current_first_domain == '' ) {
//					console.log( a[i] );
					EBE_current_first_domain = a[i];
				}
				
				//
				str += '<li>' + a[i] + '</li>';
			}
			else {
				// nếu có mảng số 2
				if ( a[i].split('|').length > 2 ) {
					a[i] = a[i].split('|');
					
					a[i][0] = $.trim( a[i][0] );
					
					
					// Tạo mảng số 3 với tên đầy đủ của nhóm này
					a[i][3] = g_func.non_mark_seo( a[i][2] );
					a[i][3] = a[i][3].replace( /\-/g, '' );
					
					
					// Tạo mảng số 4 để tạo nhóm nếu muốn
					var category_slug = a[i][0];
					category_slug = category_slug.split('/');
					if ( category_slug[ category_slug.length - 1 ] == '' ) {
						category_slug = category_slug[ category_slug.length - 2 ];
					}
					else {
						category_slug = category_slug[ category_slug.length - 1 ];
					}
					
					a[i][4] = '<a href="' + web_link + 'temp/?set_module=leech_data&create_category=' + encodeURIComponent( $.trim( a[i][2] ) ) + '&category_slug=' + encodeURIComponent( $.trim( category_slug ) ) + '&category_parent=' + ( $('#oiAnt input[name="t_ant"]').val() || 0 ) + '&caregory_source=' + encodeURIComponent( a[i][0] ) + '" target="target_eb_iframe">[Tạo nhóm]</a>';
					
					
					a[i][2] = $.trim( a[i][2] );
					a[i][1] = $.trim( a[i][1] );
					
					
					// gán lại mảng
					a[i] = a[i].join('|');
				}
				
				//
				str_slug_error += '<li>' + a[i] + '</li>';
			}
		}
	}
	
	//
	if ( typeof a[0] != 'undefined' && a[0] != '' ) {
		console.log( a[0] );
		g_func.setc( 'ck_old_categories_url', a[0], 0, 30 );
		
		//
		set_source_url_leech ( a[0] );
	}
	
	//
//	console.log( str );
	
	//
	$('#categories_list_url').append( str );
	$('#categories_url').val( '' ).focus();
	
	// nếu có URL lỗi -> tìm và triển luôn
	if ( str_slug_error != '' ) {
		str_slug_error = '<li class="redcolor">URL có slug auto nhưng bị lỗi không tìm thấy</li>' + str_slug_error;
		$('#categories_list_finish').append( str_slug_error );
	}
	
	
	// lấy đoạn text cuối của url để cho vào khung soạn chữ tìm kiếm nhóm
	var a = $('#oiAnt input[type="text"]').val() || '';
	if ( a == '' ) {
		var b = $('#categories_list_url li:first').html() || '';
		if ( b != '' ) {
			if ( b.split('|').length > 1 ) {
				b = $.trim( b.split('|')[1] );
			}
			else {
				b = b.split('/');
				if ( b[ b.length - 1 ] == '' ) {
					b = b[ b.length - 2 ];
				}
				else {
					b = b[ b.length - 1 ];
				}
			}
			
			$('#oiAnt input[type="text"]').val( b.split('.htm')[0].split('.asp')[0].split('.')[0] );
		}
	}
	
	
	
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
	
	// gán mặc định nếu chưa có mảng nào
	if ( typeof arr_for_save_domain_config[EBE_current_first_domain] != 'object' ) {
		arr_for_save_domain_config[EBE_current_first_domain] = arr_cookie_lamviec;
	}
	console.log( arr_for_save_domain_config );
	
	// sau đó là gán giá trị thật
	for ( var x in arr_cookie_lamviec ) {
		arr_for_save_domain_config[EBE_current_first_domain][x] = $( '#' + x ).val() || '';
	}
	console.log( arr_for_save_domain_config );
	
	// gán các checkbox đã được check
	var a = [];
	for ( var i = 0; i < arr_save_checkbox_options.length; i++ ) {
		if ( dog( arr_save_checkbox_options[i] ).checked == true ) {
			a.push( arr_save_checkbox_options[i] );
		}
	}
	arr_for_save_domain_config[EBE_current_first_domain]['save_checkbox_options'] = a;
	console.log( arr_for_save_domain_config );
	
	
	//
	document.frm_leech_data_save.t_noidung.value = escape( JSON.stringify( arr_for_save_domain_config ) );
	
	//
	auto_submit_save_domain_cookies = true;
	
}


function EBE_auto_save_domain_cookie () {
	if ( auto_submit_save_domain_cookies == true ) {
		auto_submit_save_domain_cookies = false;
		
		//
		/*
		if ( dog('leech_data_auto_next').checked == true ) {
			console.log( 'Auto next is active, auto save STOP' );
		}
		else {
			*/
			console.log( 'Auto save, while 60 secondes' );
			document.frm_leech_data_save.submit();
//		}
	}
}



function create_list_post_for_crawl ( a, img ) {
	// full url nếu chưa có
	a = full_url_for_img_src(a);
	console.log( a );
	
	if ( img != '' ) {
		img = full_url_for_img_src(img);
	}
	console.log( img );
	
	//
	if ( typeof arr_check_value_exist[a] == 'undefined' ) {
		arr_check_value_exist[a] = 1;
		
		return '<li><a href="' +a+ '" data-img="' + img + '" target="_blank" rel="nofollow">' +a+ '</a></li>';
	}
	
	console.log('URL exist: ' + a);
	return '';
}


function after_list_post_for_crawl ( str ) {
	if ( str == '' ) {
		console.log('Product list not found!');
		return false;
	}
	// Thay URL chuẩn của tên miền đang lấy tin, do thi thoảng bị lỗi domain (như của amazon)
	str = str.split( web_link ).join(source_url);
	
	// gán d.sách tìm được
	$('#details_list_url').html( str );
	
	//
	if ( dog('leech_data_auto_next').checked == true ) {
		var check_ant_select = g_func.number_only( $('#oiAnt input[name="t_ant"]').val() || 0 );
		
		if ( check_ant_select > 0 ) {
			$('.click-submit-url-details:first').click();
		} else {
			console.log('Select categories for auto leech');
		}
	} else {
		console.log('Check leech_data_auto_next to auto leech');
	}
	
	return false;
}



function WGR_leech_data_after_load_iframe () {
	setTimeout(function () {
		console.log('Load done! get content in crawl_eb_iframe');
		
		var str = '';
		arr_check_value_exist = {};
		
		$('#crawl_eb_iframe').contents().find( current_loading_tags ).each(function() {
			var a = $(this).attr('href') || $('a', this).attr('href') || '',
				img = $('img', this).attr('data-src') || $('img', this).attr('src') || $(this).attr('data-img') || '';
			
			//
			str += create_list_post_for_crawl( a, img );
		});
		
		//
		after_list_post_for_crawl( str );
		
		//
		$('body').css({
			opacity: 1
		});
	}, 1200);
}




//
setInterval(function () {
	EBE_auto_save_domain_cookie();
//}, 5000);
}, 60 * 1000);



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



//
$('#oi_save_list_category').off('change').change(function () {
	var a = $(this).val() || '';
	if ( a != '' ) {
		a = a.split("\n");
		var str = '';
		
		for ( var i = 0; i < a.length; i++ ) {
			a[i] = g_func.trim( a[i] );
			
//			if ( a[i] != '' && a[i].substr( 0, 1 ) != '#' && a[i].split('//').length > 1 ) {
			if ( a[i] != '' && a[i].split('//').length > 1 ) {
				str += a[i] + "\n";
			}
		}
		
		//
		if ( str != '' ) {
			$(this).val( str );
			
			document.frm_leech_data_save.submit();
			console.log('Auto save oi_save_list_category');
		}
	}
	
	//
	EBE_auto_save_domain_cookie();
}).off('click').click(function () {
	$(this).height(20);
	
	var min_height = $(this).attr('data-min-height') || 60,
		add_height = $(this).attr('data-add-height') || 20;
	
	var new_height = $(this).get(0).scrollHeight || 0;
	new_height -= 0 - add_height;
	if (new_height < min_height) {
		new_height = min_height;
	}
	
	//
	$(this).height(new_height);
});



// sử dụng nội dung lưu trong database
$('.add-db-list-post-to-process').off('click').click(function () {
	var a = $('#oi_save_list_category').val() || '';
	if ( a != '' ) {
		$('#categories_url').val(a);
//		$('#oi_save_list_category').val('');
		
		//
		setTimeout(function () {
			$('#categories_url').change();
//			$('#oi_save_list_category').change();
		}, 600);
	}
});


// tự động lấy nhóm bất kỳ rồi tiếp tục
function func_get_random_category_for_leech ( i ) {
	if ( typeof i != 'number' ) {
		i = 0;
	}
	if ( i > 50 ) {
		console.log('max range for i');
		return false;
	}
	
	//
	var a = $('#oi_save_list_category').val() || '';
	a = $.trim( a );
//	console.log(a);
	if ( a != '' ) {
		a = a.split("\n");
		
		a = a[Math.floor(Math.random() * a.length)];
		
		if ( a != '' && a.split('|').length > 1 && a.substr( 0, 1 ) != '#' ) {
			console.log(a);
			$('#categories_url').val( a );
			
			//
			setTimeout(function () {
				$('#categories_url').change();
				
				//
				setTimeout(function () {
					$('.click-submit-url-details:first').click();
				}, 1200);
			}, 1200);
			
			return true;
		}
	}
	
	return func_get_random_category_for_leech( i + 1 );
}

function add_parameter_for_auto_leech ( start ) {
	var u = window.location.href.split('&auto_leech=1')[0];
	
	if ( typeof start == 'number' && start == 1 ) {
		u += '&auto_leech=1';
	}
	
	window.history.pushState( "", '', u );
}

function check_auto_leech_on_off () {
	if ( window.location.href.split('&auto_leech=1').length > 1 ) {
		return true;
	}
	return false;
}

//
setTimeout(function () {
//	if ( dog('auto_get_random_category_for_leech').checked == true ) {
	if ( check_auto_leech_on_off() ) {
		add_parameter_for_auto_leech(1);
		
		dog('leech_data_auto_next').checked = true;
		
		$('#star_get_random_category_for_leech').html( '<i class="fa fa-pause"></i> ' + $('#star_get_random_category_for_leech').attr('data-stop') );
		
		func_get_random_category_for_leech();
	}
	else {
		(function () {
			var a = g_func.getc( 'ck_old_categories_url' );
			
			// nạp dữ liệu từ phiên làm việc cũ
			if ( a != null ) {
				$('#categories_url').val( a );
			}
		})();
	}
	
	$('#star_get_random_category_for_leech').attr({
//		'data-stop': $('#star_get_random_category_for_leech').attr('data-stop') || '',
		'data-start': $('#star_get_random_category_for_leech').attr('data-start') || $('#star_get_random_category_for_leech').html() || ''
	}).off('click').click(function () {
		// đang chạy thì dừng lại
//		if ( dog('auto_get_random_category_for_leech').checked == true ) {
		if ( check_auto_leech_on_off() ) {
//			dog('auto_get_random_category_for_leech').checked = false;
			add_parameter_for_auto_leech();
			
			dog('leech_data_auto_next').checked = false;
			
			$(this).html( '<i class="fa fa-play"></i> ' + $(this).attr('data-start') );
		}
		// chạy tiếp
		else {
//			dog('auto_get_random_category_for_leech').checked = true;
			add_parameter_for_auto_leech(1);
			
			dog('leech_data_auto_next').checked = true;
			
			func_get_random_category_for_leech();
			
			$(this).html( '<i class="fa fa-pause"></i> ' + $(this).attr('data-stop') );
		}
		
		//
//		$('#auto_get_random_category_for_leech').click();
	});
}, 2000);


//
setInterval(function () {
	// nếu chế độ tự load trang đang được kích hoạt
//	if ( dog('auto_get_random_category_for_leech').checked == true ) {
	if ( check_auto_leech_on_off() ) {
		// load lại trang khi quá 120 giây
		if ( tu_dong_load_lai_trang_neu_submit_loi > limit_time_for_reload_this_page ) {
			window.location = window.location.href;
		}
		// nếu không cứ 10 giây thêm 1 đơn vị
		else {
			tu_dong_load_lai_trang_neu_submit_loi++;
			console.log('Reload page after ' + ( (limit_time_for_reload_this_page - tu_dong_load_lai_trang_neu_submit_loi) * 10 ) + ' secondes');
		}
	}
	// nếu không kích hoạt chế độ load trang -> đặt về 0 luôn
	else {
		tu_dong_load_lai_trang_neu_submit_loi = 0;
	}
}, 10 * 1000);


$('.click-submit-url-categories').off('click').click(function () {
	
	//
	var html_tags = $('#categories_tags').val() || '';
	
	//
	if ( html_tags == '' ) {
		alert('html_tags không được để trống');
		$('#categories_tags').focus();
		return false;
	}
	current_loading_tags = html_tags;
	
	//
	a = $('#categories_list_url li:first').html() || '',
	a = g_func.trim( a );
	
	// nếu có URL -> tiếp tục
	if ( a != '' ) {
		a = check_category_by_auto_slug( a, 1 );
		if ( a == false ) {
			return false;
		}
		
		//
//		$('#categories_list_finish').append( '<li>' +$('#categories_list_url li:first').html()+ '</li>' );
		$('#categories_list_finish').append( '<li>' +a+ '</li>' );
		$('#categories_list_url li:first').remove();
		
		//
		window.scroll( 0, $('#details_list_url').offset().top - 90 );
		
		//
		var uri_for_get_content = 'temp/?set_module=leech_data&categories_url=' + encodeURIComponent( a );
		
		//
		html_tags = html_tags.replace( /\s\|\|\s/, ', ' ).replace( /\|\|/, ', ' );
		
		// lấy dữ liệu thông qua iframe
		if ( dog('get_list_post_in_iframe').checked == true ) {
			console.log('Get content via iframe');
			uri_for_get_content = web_link + uri_for_get_content + '&load_in_iframe=1&source_url=' + encodeURIComponent( source_url );
			console.log(uri_for_get_content);
			
			//
			$('body').css({
				opacity: .5
			});
			
			//
			window.open( uri_for_get_content, 'crawl_eb_iframe' );
			
			//
			/*
			$('#crawl_eb_iframe').on('load', function () {
				WGR_leech_data_after_load_iframe();
			});
			*/
			
			return true;
		}
		
		
		
		// lấy dữ liệu theo cách thông thường
		leech_data_content (uri_for_get_content, '', function () {
			
			var str = '';
			arr_check_value_exist = {};
			
			$( html_tags ).each(function() {
				var a = $(this).attr('href') || $('a', this).attr('href') || '',
					img = $('img', this).attr('data-src') || $('img', this).attr('src') || $(this).attr('data-img') || '';
				
				//
				str += create_list_post_for_crawl( a, img );
			});
			
			//
			after_list_post_for_crawl( str );
		});
	}
	else {
		if ( $('#categories_url').val() != '' ) {
			$('#categories_url').change();
			$('#categories_url').val('');
			$('.click-submit-url-categories').click();
		}
		else {
//			console.log('Không tìm thấy danh sách nhóm cần lấy sản phẩm');
			$('#show_text_after_done').append('<li>Không tìm thấy danh sách nhóm cần lấy sản phẩm</li>');
			window.scroll( 0, $('#show_text_after_done').offset().top - 90 );
			
			// nạp lại trang sau khi hoàn thành
			if ( dog('nap_lai_trang_sau_khi_hoan_thanh').checked == true
			// tự động chuyển trang và lấy category ngẫu nhiên
//			|| dog('auto_get_random_category_for_leech').checked == true ) {
			|| check_auto_leech_on_off() ) {
				window.location = window.location.href;
			}
		}
	}
});



/*
* Nhớ 1 số thao tác trước đó
*/
var arr_save_checkbox_options = [
	'nap_lai_trang_sau_khi_hoan_thanh',
	'download_img_to_my_host',
	'loai_bo_a_trong_noi_dung',
	'loai_bo_url_trong_noi_dung',
	
	'cap_nhat_stt_cho_bai_viet',
	'cap_nhat_stt_ngau_nhien',
	
	'bai_viet_nay_duoc_lay_theo_id',
	'post_id_is_numberic',
	'this_id_url_product_detail',
	'get_list_post_in_iframe',
	'get_full_code_in_head',
//	'auto_get_random_category_for_leech',
	
	'leech_data_auto_next'
];

(function ( arr ) {
	
	//
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
				g_func.setc( a, 1, 0, 30 );
			} else {
				g_func.setc( a, 0, 0, 30 );
			}
			
			//
			EBE_save_cookie_to_data_base();
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
		g_func.setc( a, $(this).val(), 0, 30 );
	});
	
	//
	a = g_func.getc( a );
//	console.log( a );
	if ( a != null && typeof a == 'string' ) {
		$('select[name="post_tai"]').val(a)
		|| $('select[name="post_tai"]').val(a).change()
		|| $('select[name="post_tai"] option[value="' +a+ '"]').attr('selected','selected');
	}
})( arr_save_checkbox_options );


/*
$('#leech_data_auto_next').off('click').click(function () {
	if ( dog('leech_data_auto_next').checked == true ) {
		g_func.setc( 'leech_data_auto_next', 1, 0, 30 );
	} else {
		g_func.setc( 'leech_data_auto_next', 0, 0, 30 );
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
var arr_cookie_lamviec = null;

// Kiểm tra nếu có dữ liệu cũ trong cookie -> lấy trong đó ra
console.log( EBE_current_first_domain );
if ( typeof arr_for_save_domain_config == 'object' ) {
	console.log( arr_for_save_domain_config );
	for ( var x in arr_for_save_domain_config ) {
		arr_cookie_lamviec = arr_for_save_domain_config[x];
		break;
	}
	console.log( arr_cookie_lamviec );
}

// Mảng mặc định cho lần đầu tiên
var default_arr_cookie_lamviec = {
	id_post_begin : '',
	id_post_end : '',
	
	details_noidung : '',
	details_dieukien : '',
	details_goithieu : '',
	details_giacu : '',
	details_giamoi : '',
	details_format_price : '',
	details_img : '',
	details_youtube_url : '',
	details_title : '',
	details_masanpham : '',
	details_ngaydang : '',
	details_gallery : '',
	categories_tags : ''
};


(function () {
	//
	if ( arr_cookie_lamviec == null ) {
		arr_cookie_lamviec = default_arr_cookie_lamviec;
	}
	else {
		// Nạp mảng từ mảng mặc định nếu chưa có
		for ( var x in default_arr_cookie_lamviec ) {
			if ( typeof arr_cookie_lamviec[x] == 'undefined' ) {
				arr_cookie_lamviec[x] = '';
			}
		}
	}
//	console.log( arr_cookie_lamviec );
	
	//
	for ( var x in arr_cookie_lamviec ) {
		if ( x == 'save_checkbox_options' ) {
			var arr_check_op = arr_cookie_lamviec[x];
			
			for ( var j = 0; j < arr_check_op.length; j++ ) {
				console.log(arr_check_op[j]);
				
				if ( dog( arr_check_op[j] ).checked == false ) {
					dog( arr_check_op[j] ).checked = true;
				}
			}
		}
		else if ( dog( x ) != null ) {
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
			else if ( arr_cookie_lamviec[x] != '' ) {
				// gán lại dữ liệu
				$( '#' + x ).val( arr_cookie_lamviec[x] );
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




//
window.scroll(0, 0);
setTimeout(function () {
	window.scroll(0, 0);
}, 600);




// TEST
/*
if ( window.location.href.split('localhost').length > 1 ) {
	$('#categories_url').val( 'https://xwatchluxury.vn/dong-ho-nam/' ).change();
	$('.click-submit-url-categories').click();
}
/**/


