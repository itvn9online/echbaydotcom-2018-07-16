


//
/*
if ( typeof eb_site_group == 'undefined' ) {
	eb_site_group = [];
}
//console.log(eb_site_group);
//console.log(eb_blog_group);

// sắp xếp menu cho cat
(function () {
	for ( var i = 0; i < eb_site_group.length; i++ ) {
		jQuery( '.echbay-category-in-js .cat-item-' + eb_site_group[i].id ).css({
			order : eb_site_group[i].order
		});
	}
})();
*/




// list function /////////////////////////////////////////////////////////////////
/*
* Các function dùng chung cho phần danh sách bài viết sẽ được cho vào đây
* Sau đó các file js riêng của từng theme sẽ kế thừa và sử dụng các chức năng bằng cách gọi function
*/

//
var product_selected_url = '',
	eb_this_current_url = jQuery('link[rel="canonical"]:first').attr('href') || window.location.href.split('?')[0].split('&')[0].split('#')[0],
	size_rieng_cua_tung_mau = '',
	// nếu size đã được load rồi thì thôi không load lại
	size_has_been_load = false,
	price_by_color = 0,
	price_for_quick_cart = 0;
//console.log(eb_this_current_url);
if ( eb_this_current_url == web_link ) {
	eb_this_current_url = window.location.href.split('#')[0];
}



//
jQuery('.eb-set-menu-selected .sub-menu').addClass('cf');



// Sắp xếp sản phẩm theo ý muốn người dùng
(function () {
	if ( jQuery('#oi_order_by').length == 0 ) {
		return false;
	}
	
	
	//
	var arr = {
		time : lang_order_by,
//		time : 'Mới nhất',
		view : lang_order_view,
		price_down : lang_order_price_down,
		price_up : lang_order_price_up,
		az : lang_order_az,
		za : lang_order_za
	};
	
	//
	var str = '',
		sl = '';
	for (var x in arr) {
		sl = '';
		if ( x == current_order ) {
			sl = ' selected="selected"';
		}
		
		//
		str += '<option value="' + eb_this_current_url + '?orderby=' +x+ '" ' +sl+ '>' +arr[x]+ '</option>';
	}
	
	//
	dog( 'oi_order_by', '<select>' +str+ '</select>' );
	jQuery('#oi_order_by select').change(function () {
		var a = jQuery(this).val() || '';
		if ( a != '' ) {
//				alert(a);
			window.location = a;
		}
	});
})();

//
function ___eb_list_product_order () {
	console.log('WARNING! Function ___eb_list_product_order bas been remove, please clear in your code!');
}


function WGR_check_option_on ( a ) {
	if ( a == 1 || a == "1" ) {
		return true;
	}
	return false;
}



// end list function /////////////////////////////////////////////////////////////////






// details function /////////////////////////////////////////////////////////////////
/*
* Các function dùng chung cho phần chi tiết bài viết sẽ được cho vào đây
* Sau đó các file js riêng của từng theme sẽ kế thừa và sử dụng các chức năng bằng cách gọi function
*/




//
var time_next_details_slider = null;

// slider show (nếu có)
function ___eb_details_slider ( auto_next_details_slider ) {
	console.log('WARNING! Function ___eb_details_slider bas been remove, please clear in your code!');
}

function ___eb_set_thumb_to_fullsize ( s ) {
	if ( typeof s == 'undefined' || s == '' ) {
		return '';
	}
//	console.log(s);
	
	//
	if ( s.split(wp_content + '/uploads/').length > 1 ) {
		var t = s.split('-');
		t = t[ t.length - 1 ];
//		console.log( t );
		
		if ( t.split('.').length == 2 ) {
			t = t.split('.')[0].split('x');
			
			if ( t.length == 2 ) {
				var re = /^\d+$/;
				
				// nếu đang là thumbnail hoặc ảnh thu nhỏ -> thì mới cần chuyển sang ảnh to
				if ( re.test( t[ 0 ] ) == true
				&& re.test( t[ 1 ] ) == true ) {
					s = s.replace( '-' + t[ 0 ] + 'x' + t[ 1 ] + '.', '.' );
				}
			}
		}
	}
//	console.log(s);
	
	// bỏ thumb đi
	return s;
}

function ___eb_set_img_to_thumbnail ( sr ) {
	if ( typeof sr == 'undefined' || sr == '' ) {
		return '';
	}
//	console.log( sr );
	
	// nếu có tham số này -> site không sử dụng thumb hoặc không có thumb
	if ( typeof eb_disable_auto_get_thumb == 'number' && eb_disable_auto_get_thumb == 1 ) {
		if ( cf_tester_mode == 1 ) console.log('Auto get thumb disable');
	}
	// lấy thumb để làm ảnh slider -> load cho nhanh
	else if ( sr.split(wp_content + '/uploads/').length > 1 ) {
		// cắt lấy chuỗi cuối cùng của ảnh để kiểm tra xem có phải thumb hay không
		var file_name = sr.split('/');
		file_name = file_name[ file_name.length - 1 ];
//		console.log( file_name );
		
//		var is_thumb = sr.split('/').pop().split('-').pop().split('.')[0];
		var is_thumb = file_name.split('-');
		is_thumb = is_thumb[ is_thumb.length - 1 ];
//		console.log( is_thumb );
		
		//
		if ( is_thumb.split('.').length == 2 ) {
			var file_type = file_name.split('.');
			file_type = file_type[ file_type.length - 1 ];
//			console.log( file_type );
			
			var thumbnail = '-150x150.' + file_type;
//			console.log( thumbnail );
			
			is_thumb = is_thumb.split('.')[0];
//			console.log( is_thumb );
			
			// có chữ x -> có thể là thumb
			if ( is_thumb.split('x').length > 1 ) {
				var re = /^\d+$/;
				is_thumb = is_thumb.split('x');
				
				// nếu đang là thumbnail hoặc ảnh thu nhỏ
				if ( re.test( is_thumb[ is_thumb.length - 2 ] ) == true
				&& re.test( is_thumb[ is_thumb.length - 1 ] ) == true ) {
//					console.log( is_thumb[ is_thumb.length - 2 ] );
//					console.log( is_thumb[ is_thumb.length - 1 ] );
					
					sr = sr.replace( '-' + is_thumb[ is_thumb.length - 2 ] + 'x' + is_thumb[ is_thumb.length - 1 ] + '.' + file_type, thumbnail );
				}
				// nếu không phải thumbnail -> tạo thumbnail luôn
				else {
					sr = sr.replace( '.' + file_type, thumbnail );
				}
			}
			// nếu không có chữ x -> không phải thumb
			else {
//			if ( is_thumb.split('x').length != 2 ) {
				// -> thêm thumb
//				var img_type = sr.split('.').pop();
				
				sr = sr.replace( '.' + file_type, thumbnail );
			}
		}
	}
//	console.log( sr );
	
	return sr;
}



function ___eb_details_slider_v2 () {
	
	// trên mobile thì để 1 chế độ xem thôi -> xóa CSS điều khiển định dạng slider trước khi lệnh JS chạy để không bị vỡ khung
	if ( cf_details_right_thumbnail == 1 && jQuery(window).width() < 775 ) {
//		jQuery('link#thumb-col, link#thumb-col-left, link#thumb-col-mobile').remove();
		jQuery('link#thumb-col, link#thumb-col-left').remove();
	}
	
	// thời gian chuyển slider, nếu có thì phải hợp lệ (kiểu số nguyên, tối thiểu 1 giây)
//	if ( typeof auto_next_details_slider != 'number' || auto_next_details_slider < 1000 ) {
//		auto_next_details_slider = 0;
//	}
	
	var str = '',
		str_thumb = '',
		i = 0,
		sr = '',
		slider_btn = '',
		slider_len = jQuery('#export_img_product img').length,
		html_for_get = '#export_img_product img',
		data_get = 'data-src';
	
	//
//	console.log( slider_len );
	
	// nếu slider chính không có ảnh -> lấy ảnh từ nội dung
	if ( slider_len == 0 ) {
		slider_len = jQuery('#content_img_product img').length;
		html_for_get = '#content_img_product img';
		data_get = 'src';
	}
//	console.log( slider_len );
//	console.log( html_for_get );
	
	// -> nếu vẫn không có -> hủy slider
	if ( slider_len <= 1 ) {
		jQuery('.hide-if-slider-null').hide();
		
		//
		var a = '',
			wit = jQuery('.thread-details-mobileAvt').width();
		// nếu chỉ có 1 ảnh -> in luôn cái ảnh đấy ra -> ảnh slider có thể là ảnh chất lượng hơn
		if ( slider_len == 1 ) {
			a = jQuery(html_for_get).attr('data-src') || jQuery(html_for_get).attr('src') || '';
		}
		// xử lý chính ảnh đại diện
		else {
			a = jQuery('.thread-details-mobileAvt').attr('data-img') || '';
		}
		
		//
		if ( a != '' ) {
			jQuery('.thread-details-mobileAvt').removeClass('ti-le-global').height('auto').css({
				'background-image' : 'none',
				'line-height' : 'normal'
			}).html( '<img src="' + ___eb_set_thumb_to_fullsize(a) + '" data-width="' + wit + '" style="max-width:' + wit + 'px;" />' );
		}
		
		//
		return false;
	}
	
	
	//
	jQuery(html_for_get).each(function() {
//		sr = jQuery(this).attr(data_get) || '';
		sr = jQuery(this).attr('data-src') || jQuery(this).attr('src') || '';
//		console.log( sr );
		
		//
		sr = ___eb_set_img_to_thumbnail( sr );
		if ( cf_tester_mode == 1 ) console.log( sr );
		
		//
		str += '<li data-node="' +i+ '" data-src="' + sr + '" style="background-image:url(\'' + sr + '\')">&nbsp;</li>';
		
		str_thumb += '<li data-node="' +i+ '" data-src="' + sr + '"><div style="background-image:url(\'' + sr + '\')">&nbsp;</div></li>';
		
		slider_btn += '<li data-node="' +i+ '"><i class="fa fa-circle"></i></li>';
		
		//
		i++;
	});
	
	//
//	dog('export_img_product', '<ul class="cf">' + str_thumb + '</ul>');
	
	
	//
//	if ( slider_len <= 1 ) {
//		return false;
//	}
//	jQuery('.thread-details-mobileLeft, .thread-details-mobileRight').show();
	
	
	// tạo thumb nếu đủ ảnh
	jQuery('.thread-details-mobileAvt').html('<ul class="cf">' + str + '</ul>').css({
		'background-image' : ''
	});
	
	
	
	
	// tải slider theo code mới
	jEBE_slider( '.thread-details-mobileAvt', {
		buttonListNext: cf_details_show_list_next == 1 ? true : false,
		
		// tự động chạy slider theo thời gian mà người dùng chỉ định
		autoplay : cf_slider_details_play > 0 ? true : false,
		speedNext : cf_slider_details_play,
		
		sliderArrow: true,
		sliderArrowWidthLeft : '40%',
		sliderArrowWidthRight : '60%',
		sliderArrowLeft : 'fa-chevron-circle-left',
		sliderArrowRight : 'fa-chevron-circle-right',
		
//		thumbnail : 'ul li',
		thumbnail : cf_details_show_list_thumb == 1 ? 'ul li' : false,
		size : jQuery('.thread-details-mobileAvt').attr('data-size') || ''
	}, function () {
		jQuery('.thread-details-mobileAvt li').click(function () {
			var a = jQuery(this).attr('data-src') || '';
			if ( a != '' ) {
				a = ___eb_set_thumb_to_fullsize( a );
				if ( cf_tester_mode == 1 ) console.log(a);
				
				jQuery(this).css({
					'background-image': 'url("' + a + '")'
				});
			}
		});
		
		// click vào cái đầu tiên luôn
		jQuery('.thread-details-mobileAvt li:first').click();
		
		// thay đổi kiểu tải thumb nếu thumb được chuyển sang chiều dọc
		// trên mobile thì để 1 chế độ xem thôi
		if ( cf_details_right_thumbnail == 1 && jQuery(window).width() >= 775 ) {
			
			//
			var effect_for_post_slider = '.child-thread-details-mobileAvt .jEBE_slider-thumbnail ul';
			
			//
			jQuery('.child-thread-details-mobileAvt .jEBE_slider-right-thumbnail').off('click').click(function () {
//				var a = jQuery('.child-thread-details-mobileAvt .jEBE_slider-thumbnail li.selected').attr('data-i') || 0;
				var a = jQuery(effect_for_post_slider).attr('data-scroll') || 1,
					len = jQuery('.child-thread-details-mobileAvt .jEBE_slider-thumbnail li').length - 1;
//					console.log(a);
				a = a - ( 0 - 1 );
				if ( a >= len ) {
					a = len - 1;
				}
//					console.log(a);
				
				//
				jQuery(effect_for_post_slider).css({
					top: ( 0 - a * jQuery('.child-thread-details-mobileAvt .jEBE_slider-thumbnail li:first').height() - a * 5 ) + 'px'
				}).attr({
					'data-scroll' : a
				});
				
				//
				jQuery('.child-thread-details-mobileAvt .jEBE_slider-left-thumbnail').show();
			});
			
			jQuery('.child-thread-details-mobileAvt .jEBE_slider-left-thumbnail').off('click').click(function () {
//					var a = jQuery('.child-thread-details-mobileAvt .jEBE_slider-thumbnail li.selected').attr('data-i') || 0;
				var a = jQuery(effect_for_post_slider).attr('data-scroll') || 1;
//					console.log(a);
				a = a - 1;
				if ( a < 0 ) {
					a = 0;
				}
//					console.log(a);
				
				//
				jQuery(effect_for_post_slider).css({
					top: ( 0 - a * jQuery('.child-thread-details-mobileAvt .jEBE_slider-thumbnail li:first').height() - a * 5 ) + 'px'
				}).attr({
					'data-scroll' : a
				});
			});
			
		}
		
	});
	
}





// hẹn giờ cho các deal
function ___eb_details_countdown () {
	
	var a = jQuery('.thread-details-countdown').attr('data-timeend') || 0;
	if ( a == 0 || a == '0' ) {
	} else {
		jQuery('.thread-details-countdown').show();
	}
	
}





// tạo style cho phần tóm tắt, từ dạng không html sang có html
function ___eb_details_ul_options () {
	
	// tắt chế độ tạo style cho phần excerpt nếu option này đang được tắt
	if ( ! WGR_check_option_on( cf_details_ul_options ) ) {
		if ( cf_tester_mode == 1 ) console.log('___eb_details_ul_options disable');
		return false;
	}
	if ( cf_tester_mode == 1 ) console.log('___eb_details_ul_options is running...');
	
	// chặn -> không cho chạy lại lần nữa
	cf_details_ul_options = 'off';
	
	
	
	//
	var a = jQuery('.thread-details-options tbody').html() || jQuery('.thread-details-options').html() || '';
	//console.log(a);
	if ( a != '' ) {
		// thay TR -> LI
		a = a.replace( /\<tr\s/gi, '<li ' ).replace( /\<tr\>/gi, '<li>' ).replace( /\<\/tr\>/gi, '</li>' );
		
		// TD -> DIV
	//	a = a.replace( /\<td\s/gi, '<div ' ).replace( /\<td\>/gi, '<div>' ).replace( /\<\/td\>/gi, '</div>' );
		
		//
//		console.log(a);
		jQuery('.thread-details-options').hide().after( '<ul class="thread-details2-options">' + a + '</ul>' );
		
		// xóa bỏ TD -> chỉ giữ lại DIV
		jQuery('.thread-details2-options td').each(function() {
			jQuery(this).after( jQuery(this).html() );
		}).remove();
	}
	
}

function ___eb_details_excerpt_html ( a_before, a_after ) {
	
	// tắt chế độ tạo style cho phần excerpt nếu option này đang được tắt
	if ( ! WGR_check_option_on( cf_details_excerpt ) ) {
		if ( cf_tester_mode == 1 ) console.log('___eb_details_excerpt_html disable');
		return false;
	}
	if ( cf_tester_mode == 1 ) console.log('___eb_details_excerpt_html is running...');
	
	// chặn -> không cho chạy lại lần nữa
	cf_details_excerpt = 'off';
	
	//
	var a = jQuery('.thread-details-comment').html() || '',
		str = '';
	
	// Bỏ qua nếu không tìm thấy CSS hoặc dữ liệu bị trống
	if ( a == '' ) {
		if ( cf_tester_mode == 1 ) console.log('thread-details-comment is NULL');
		return false;
	}
	
	// Tách lấy từng dòng -> để tạo style cho thống nhất
	a = a.split("\n");
	
	// 1 dòng thì cũng bỏ qua luôn
	if ( a.length <= 1 ) {
		if ( cf_tester_mode == 1 ) console.log('thread-details-comment is one line');
		return false;
	}
	
	// dữ liệu phụ họa
	if ( typeof a_before == 'undefined' ) {
		a_before = '';
	}
	
	if ( typeof a_after == 'undefined' ) {
		a_after = '';
	}
	
	// bắt đầu tạo style
	for (var i = 0; i < a.length; i++) {
		a[i] = g_func.trim( a[i] );
		
		if ( a[i] != '' ) {
			// tạo dưới dạng bảng -> cho vào bảng post options luôn
			if ( WGR_check_option_on( cf_options_excerpt ) ) {
				var a_bold = a[i].split(':');
				
				// in đậm đề mục
				if ( WGR_check_option_on( cf_details_bold_excerpt ) ) {
					a_bold[0] = '<strong>' + a_bold[0] + '</strong>';
				}
				
				for ( var  j = 0; j < a_bold.length; j++ ) {
					if ( jQuery.trim( a_bold[j] ) != '' ) {
						a_bold[j] = '<td><div>' + a_bold[j] + '</div></td>';
					}
				}
				
				//
				jQuery('.thread-details-options').append( '<tr>' + a_bold.join('') + '</tr>' );
			}
			// Tạo LI thông thường
			else {
				// in đậm đề mục
				if ( WGR_check_option_on( cf_details_bold_excerpt ) ) {
					var a_bold = a[i].split(':');
					a_bold[0] = '<strong>' + a_bold[0] + '</strong>';
					
					a[i] = a_bold.join(':');
				}
				
				str += '<li>' + a_before + a[i] + a_after + '</li>';
			}
		}
	}
	
	// In ra dữ liệu mới
	jQuery('.thread-details-comment').show().html( '<ul>' +str+ '</ul>' );
	
}





// tạo số liệu rating ảo
function ___eb_details_product_rating () {
	
	var a = jQuery('.each-to-rating').attr('data-rating') || 0;
//	console.log(a);
	a = a * 10/ 10;
//	console.log(a);
	
	var str = '';
	for ( var i = 0; i < 5; i++ ) {
//		console.log( i );
		
		if ( i < a ) {
			if ( i + 0.5 == a ) {
				str += '<i data-start="' +(i + 1)+ '" class="fa fa-star-half-o orgcolor cur"></i> ';
			}
			else {
				str += '<i data-start="' +(i + 1)+ '" class="fa fa-star orgcolor cur"></i> ';
			}
		}
		else {
			str += '<i data-start="' +(i + 1)+ '" class="fa fa-star-o cur"></i> ';
		}
	}
	jQuery('.each-to-rating').html( str );
	jQuery('.each-to-rating i').click(function () {
		console.log('Thank for rating...');
	});
	
}





// hiệu ứng với các tab nội dung
function ___eb_details_product_tab () {
	
	//
	jQuery('.thread-details-tab li').click(function () {
		jQuery('.thread-details-tab li').removeClass('selected');
		jQuery(this).addClass('selected');
		
		var a = jQuery(this).attr('data-show') || '';
//		console.log(a);
		
		if ( a != '' ) {
			jQuery('.thread-details-contenttab').hide();
			
			jQuery('.' + a).show();
			
			if ( a == 'thread-details-tab-comment' ) {
				jQuery('.hide-if-show-comment').hide();
			} else {
				jQuery('.hide-if-show-comment').show();
				_global_js_eb.auto_margin();
			}
		}
		
		//
//		_global_js_eb.auto_margin();
	});
	
	//
//	jQuery(document).ready(function(e) {
		jQuery('.thread-details-tab li:first').click();
//	});
	
	//
	setTimeout(function () {
		// định vị lại style cho bản PC
		if ( g_func.mb_v2() == false ) {
			// Chiều cao định vị cho tab
			var min_tab_height = jQuery('.thread-details-tab').attr('data-max-height') || 40;
			if ( cf_tester_mode == 1 ) console.log( 'Fixed data height (max ' + min_tab_height + 'px) for thread-details-tab' );
			
	//		console.log( jQuery('.thread-details-tab').height() );
			if ( jQuery('.thread-details-tab').height() > min_tab_height ) {
				var j = 30;
				for ( var i = 0; i < 28; i++ ) {
					jQuery('.thread-details-tab li').css({
						padding: '0 ' +j+ 'px'
					});
					
					//
					if ( jQuery('.thread-details-tab').height() < min_tab_height ) {
						break;
					}
					
					//
					j--;
				}
			}
			
			// nếu vẫn chưa được -> màn hình có thể còn nhỏ hơn nữa -> tiếp tục thu font-size
			if ( jQuery('.thread-details-tab').height() > min_tab_height ) {
				var j = 17;
				for ( var i = 0; i < 5; i++ ) {
					jQuery('.thread-details-tab').css({
						'font-size' : j+ 'px'
					});
					
					//
					if ( jQuery('.thread-details-tab').height() < min_tab_height ) {
						break;
					}
					
					//
					j--;
				}
			}
		}
	}, 600);
	
}





// màu sắc sản phẩm
// hiển thị tên màu trực tiếp nếu không có màu nào được chỉ định
function WGR_show_product_color_name () {
//	console.log(product_color_name);
	
	// nếu có tên màu sắc -> hiển thị tên màu ra ngoài cho dễ nhìn
	if ( product_color_name != '' ) {
		jQuery('.show-if-color-exist').show();
		
		// lấy hình ảnh nếu có
		var product_img = jQuery('meta[itemprop="image"]').attr('content')
						|| jQuery('meta[itemprop="og:image"]').attr('content')
						|| '';
		
		//
		var str = '';
		
		// nếu có hình ảnh -> thêm hình ảnh vào phần size
		if ( product_img != '' ) {
			str += '<li title="' + product_color_name + '" data-img="' + product_img + '" data-node="0" class="selected" style="background-image:url(' + product_img + ');">&nbsp;<div>' + product_color_name + '</div></li>';
			
			jQuery('.oi_product_color ul').after('<div class="show-products-color-text l19 small">&nbsp;</div>');
		}
		// nếu không, chỉ hiển thị mỗi tên
		else {
			str = '<li class="text-center text-color-center">' + product_color_name + '</li>';
		}
		jQuery('.oi_product_color ul').html( str );
	}
	
	return false;
}

function ___eb_details_product_color () {
	
	//
	if ( jQuery('#export_img_list_color img').length == 0 ) {
		return WGR_show_product_color_name();
	}
	
	//
	var str = '',
		i = 0;
	jQuery('#export_img_list_color img').each(function() {
		var s = jQuery(this).attr('data-src') || jQuery(this).attr('src') || '';
		
		if ( s != '' ) {
			// trạng thái
			var status = jQuery(this).attr('data-status') || 1,
				img_fullsize = ___eb_set_thumb_to_fullsize(s);
//			console.log(status);
			
			if ( status > 0 ) {
				var color_name = jQuery(this).attr('alt') || jQuery(this).attr('title') || jQuery(this).attr('data-color') || '',
					color_quan = jQuery(this).attr('data-quan') || '',
					color_price = jQuery(this).attr('data-price') || '';
				
				// Để trống -> coi như còn hàng
				if ( color_quan == '' ) {
					color_quan = 1;
				}
				console.log('color_quan: ' + color_quan);
				
				// còn hàng thì mới hiển thị
				if ( color_quan > 0 ) {
					str += '<li title="' + color_name + '" data-img="' + img_fullsize + '" data-node="' + i + '" data-quan="' + color_quan + '" data-price="' + color_price + '" style="background-image:url(' + ___eb_set_img_to_thumbnail( s ) + ');">&nbsp;<div>' + color_name + '</div></li>';
					
					arr_product_color.push( img_fullsize );
					
					i++;
				}
			}
		}
	});
	
	// nếu ít hơn 1 màu -> hủy bỏ
//	console.log(i);
	if ( i < 2 ) {
		WGR_show_product_color_name();
		
		arr_product_color = [];
		
		return false;
	}
//	console.log(arr_product_color);
	
	//
	jQuery('.show-if-color-exist').show();
	jQuery('.oi_product_color ul').html( str ).after('<div class="show-products-color-text l19 small"></div>');
	
	jQuery('.oi_product_color li').off('click').click(function () {
		jQuery('.oi_product_color li').removeClass('selected');
//		jQuery(this).addClass('selected');
		
		jQuery('.thread-details-mobileAvt li').css({
			'background-image' : 'url(' + ( jQuery(this).attr('data-img') || '' ) + ')'
		});
		
		// Lấy tên màu
		var color_name = jQuery(this).attr('title') || '',
			color_img = jQuery(this).attr('data-img') || '',
			color_price = jQuery(this).attr('data-price') || '',
			color_size = jQuery(this).attr('data-size') || '',
			color_node = jQuery(this).attr('data-node') || 0;
		
		//
		jQuery('.oi_product_color li[data-node="' + color_node + '"]').addClass('selected');
		
		// Hiển thị ra cho người dùng xem
//		jQuery('.show-products-color-text').html(color_name);
		
		// đổi tên sản phẩm theo màu sắc
		WGR_show_product_name_and_color (color_name);
		
		// gán size riêng theo mỗi màu nếu có
		size_rieng_cua_tung_mau = color_size;
		price_by_color = color_price;
		
		//
		if ( typeof document.frm_cart != 'undefined' ) {
			if ( color_name == '' ) {
				color_name = 'Unknown';
			}
			
			/*
			if ( color_img != '' ) {
				color_img = ' <img src="' + color_img + '" height="50" />';
			}
			*/
			
//			jQuery('.eb-global-frm-cart input[name^=t_color]').val( color_name + color_img );
			jQuery('.eb-global-frm-cart input[name^=t_color]').val( color_name );
			
			//
			var select_quan = jQuery('#oi_change_soluong select').val() || 0,
				show_price = 0;
			
			// hiển thị giá riêng của từng mầu nếu có
			if ( color_price != '' && color_price > 0 ) {
				show_price = color_price;
				price_for_quick_cart = color_price;
				if ( cf_tester_mode == 1 ) console.log('price_color');
			}
			// lấy giá mặc định
			else {
				show_price = product_js.gm;
				price_for_quick_cart = 0;
				if ( cf_tester_mode == 1 ) console.log('price_default');
			}
//			console.log('COLOR');
			jQuery('#oi_change_tongtien').html( g_func.money_format( select_quan * show_price ) );
			
			//
			_global_js_eb.cart_create_arr_poruduct();
		}
		else {
			console.log('frm_cart not found');
		}
		
		
		// load lại size để điều chỉnh giá theo size -> phủ định cái giá riêng của màu ở trên
		size_has_been_load = false;
		___eb_details_product_size();
	});
	
	//
	jQuery('.oi_product_color:first li:first').click();
	
	// nếu không có size theo màu và không có size của sản phẩm chính -> hẹn giờ lấy giá của màu đầu tiên (nếu có)
	// nếu có thì đã có 1 lệnh sau đó tìm và lấy giá theo size rồi
	if ( size_rieng_cua_tung_mau == '' && arr_product_size.length == 0 ) {
		setTimeout(function () {
			console.log('load price in color');
			jQuery('.oi_product_color:first li:first').click();
		}, 600);
	}
	
	//
	/*
	if ( jQuery('.oi_product_color').length > 1 ) {
		jQuery('.oi_product_color').each(function() {
			jQuery('li:first', this).addClass('selected');
		});
	}
	*/
	
}

function WGR_show_product_name_and_color ( color_name ) {
	
	// tạo thêm một dòng phụ bên dưới phần màu sắc để tạo độ dãn dòng
	jQuery('.show-products-color-text').html('&nbsp;');
	
	// bắt đầu hiển thị thêm tên màu vào tiêu đề
	if ( typeof color_name != 'string' ) {
		color_name = '';
	}
	
	var product_name = product_js.tieude;
	
	if ( color_name != '' ) {
		product_name += ' - (' + color_name + ')';
	}
	
	// hiển thị tên theo từng vị trí cụ thể
	if ( jQuery('.thread-details-title a').length > 0 ) {
		jQuery('.thread-details-title a').html( product_name );
	}
	else if ( jQuery('.thread-details-title').length > 0 ) {
		jQuery('.thread-details-title').html( product_name );
	}
	else if ( jQuery('h1 a').length > 0 ) {
		jQuery('h1 a').html( product_name );
	}
	else if ( jQuery('h1').length > 0 ) {
		jQuery('h1').html( product_name );
	}
}





// size sản phẩm
function ___eb_details_convert_product_size () {
	
	// convert mảng size sang kiểu dữ liệu mới
	if ( typeof arr_product_size != 'object' ) {
		if ( arr_product_size == '' ) {
			arr_product_size = [];
		} else {
			var a = arr_product_size.slice();
//			console.log(a);
			
			//
			if ( a.substr(0, 1) == ',' ) {
				a = a.substr(1);
			}
			if ( a.substr(0, 1) != '[' ) {
				a = "[" + a + "]";
			}
			
			// convert to array
//			a = JSON.parse( a );
//			a = jQuery.parseJSON( a );
			a = eval( a );
//			console.log( JSON.stringify( a ) );
			
			// gán lại mảng size từ mảng a0 nếu chưa đúng
			if ( typeof a[0] != 'undefined' && typeof a[0].name == 'undefined' ) {
				a = a[0];
			}
			arr_product_size = a;
		}
	}
//	console.log( JSON.stringify( arr_product_size ) );
//	console.log( arr_product_size );
	
}

function ___eb_details_product_size () {
	//
	if ( size_has_been_load == true ) {
		console.log('size_has_been_load');
		return false;
	}
	size_has_been_load = true;
	
	
	//
	___eb_details_convert_product_size();
	
	
	// nếu có mảng giá trị truyền vào từ màu -> sử dụng màu này
	if ( size_rieng_cua_tung_mau != '' ) {
		arr_product_size = eval( size_rieng_cua_tung_mau );
	}
	
	
	// có 1 size thì bỏ qua, mặc định rồi
//	if ( arr_product_size.length <= 1 || jQuery('.oi_product_size').length == 0 ) {
	// có 1 size cũng hiển thị, mặc định select cái size đấy cho khách là được
	if ( arr_product_size.length < 1 || jQuery('.oi_product_size').length == 0 ) {
		return false;
	}
	if ( cf_tester_mode == 1 ) console.log(arr_product_size);
	
	// có nhiều size thì tạo list
	var str = '',
		select_default_size = '';
	
	for (var i = 0; i < arr_product_size.length; i++) {
		// conver từ bản code cũ sang
		if ( typeof arr_product_size[i].name == 'undefined' ) {
			if ( typeof arr_product_size[i].ten != 'undefined' ) {
				arr_product_size[i].name = arr_product_size[i].ten;
			}
			else {
				arr_product_size[i].name = '';
			}
		}
		
		if ( typeof arr_product_size[i].val == 'undefined' ) {
			if ( typeof arr_product_size[i].soluong != 'undefined' ) {
				arr_product_size[i].val = arr_product_size[i].soluong;
			}
			else {
				arr_product_size[i].val = 0;
			}
		}
		else if ( arr_product_size[i].val == '' ) {
			arr_product_size[i].val = 0;
		}
		
		if ( typeof arr_product_size[i].price == 'undefined' || arr_product_size[i].price == '' ) {
			arr_product_size[i].price = 0;
		}
		
		// Giá trị mảng phải khác null -> null = xóa
		if ( arr_product_size[i].val != null && arr_product_size[i].val >= 0 ) {
			if ( select_default_size == '' ) {
				select_default_size = i;
			}
			
			// Tên và Số lượng phải tồn tại
//			if ( arr_product_size[i].val != '' && arr_product_size[i].name != '' ) {
			if ( arr_product_size[i].name != '' ) {
				var str_alert = '',
					str_title = '';
				if ( arr_product_size[i].val > 0 ) {
					if ( arr_product_size[i].val < 5 ) {
						str_title = 'C\u00f2n ' + arr_product_size[i].val + ' s\u1ea3n ph\u1ea9m';
						str_alert = '<span class="bluecolor">' + str_title + '</span>';
					} else {
						str_title = 'S\u1eb5n h\u00e0ng';
						str_alert = '<span class="greencolor">' + str_title + '</span>';
					}
				} else {
					str_title = 'H\u1ebft h\u00e0ng';
					str_alert = '<span class="redcolor">' + str_title + '</span>';
				}
				
				//
				str += '<li title="' + str_title + '" data-size-node="' + i + '" data-name="' + arr_product_size[i].name + '" data-quan="' + arr_product_size[i].val + '" data-price="' + arr_product_size[i].price + '"><div>' + arr_product_size[i].name + '</div>' + str_alert + '</li>';
			}
		}
	}
	if ( str == '' ) {
		arr_product_size = [];
		return false;
	}
	
	jQuery('.oi_product_size, .show-if-size-exist').show();
	jQuery('.oi_product_size ul').html(str).after('<div class="show-products-size-text l19 small"></div>');
	
	jQuery('.oi_product_size li').off('click').click(function() {
		var size_node = jQuery(this).attr('data-size-node') || '';
		
		if ( size_node == '' ) {
			return false;
		}
//		console.log(size_node);
		
		jQuery('.oi_product_size li.selected').removeClass('selected');
//		jQuery(this).addClass('selected');
		jQuery('.oi_product_size li[data-size-node="' +size_node+ '"]').addClass('selected');
		
		var curent_soluong = jQuery(this).attr('data-quan') || 0,
			size_price = jQuery(this).attr('data-price') || '';
		curent_soluong = 0 - curent_soluong;
		curent_soluong = 0 - curent_soluong;
		
		var str_alert = '';
		if ( curent_soluong > 0 ) {
			if ( curent_soluong < 5 ) {
				str_alert = '<span class="bluecolor">C\u00f2n ' + curent_soluong + ' s\u1ea3n ph\u1ea9m</span>';
			} else {
				str_alert = '<span class="greencolor">S\u1eb5n h\u00e0ng</span>';
			}
		} else {
			str_alert = '<span class="redcolor">H\u1ebft h\u00e0ng</span>';
			jQuery('.show-if-user-size').show();
		}
		jQuery('.oi_product_size .product-size-soluong > span').html(str_alert);
//		jQuery('.oi_product_size .product-size-soluong').show();
		
		if ( typeof document.frm_cart != 'undefined' ) {
//			jQuery('#click_show_cpa input[name^="t_size"]').val( jQuery(this).attr('data-name') || '' );
//			jQuery('#click_show_cpa input[name="t_size[]"]').val( jQuery(this).attr('data-name') || '' );
			jQuery('.eb-global-frm-cart input[name^=t_size]').val( jQuery(this).attr('data-name') || '' );
//			document.frm_cart.t_size.value = jQuery(this).attr('data-id') || '';
			
			//
			var select_quan = jQuery('#oi_change_soluong select').val() || 0,
				show_price = 0;
			
			// nếu có giá theo size -> lấy giá theo size
			if ( size_price != '' && size_price > 0 ) {
				show_price = size_price;
				price_for_quick_cart = size_price;
				if ( cf_tester_mode == 1 ) console.log('price_by_size');
			}
			// nếu có giá theo mầu vừa click -> lấy giá theo mầu
			else if ( price_by_color != '' && price_by_color> 0 ) {
				show_price = price_by_color;
				price_for_quick_cart = price_by_color;
				if ( cf_tester_mode == 1 ) console.log('price_by_color');
			}
			// mặc định thì lấy giá của size chính
			else {
				show_price = product_js.gm;
				price_for_quick_cart = 0;
				if ( cf_tester_mode == 1 ) console.log('price_default');
			}
//			console.log('SIZE');
			jQuery('#oi_change_tongtien').html( g_func.money_format( select_quan * show_price ) );
			
			//
			_global_js_eb.cart_create_arr_poruduct();
		}
		else {
			console.log('frm_cart not found');
		}
	});
	
	//
//	jQuery('.oi_product_size li:first').click();
	jQuery('.oi_product_size:first li[data-size-node="' + select_default_size + '"]').click();
	setTimeout(function () {
		if ( cf_tester_mode == 1 ) console.log('select_default_size: ' + select_default_size);
		jQuery('.oi_product_size:first li[data-size-node="' + select_default_size + '"]').click();
	}, 800);
	
}


// số lượng để khách hàng mua hàng nhanh
function ___eb_details_cart_quan () {
	
	//
	var str = '<option value="1">[ Chọn số lượng ]</option>',
		sl = '';
	for (var i = 1; i < 11; i++) {
		sl = '';
		if ( i == 1 ) {
			sl = ' selected="selected"';
		}
		
		str += '<option value="' + i + '"' + sl + '>' + i + '</option>';
	}
	
	dog('oi_change_soluong', '<select name="t_soluong[' + pid + ']">' + str + '</select>');
	
	jQuery('#oi_change_soluong select').change(function () {
		var a = jQuery(this).val() || 0;
		
		/* TEST
		a = 3;
		console.log( a );
		console.log( product_js.gm );
		console.log( a * product_js.gm );
		console.log( g_func.money_format( a * product_js.gm ) );
		*/
		jQuery('#oi_change_tongtien').html( g_func.money_format( a * product_js.gm ) );
		
		_global_js_eb.cart_create_arr_poruduct();
	});
	jQuery('#oi_change_soluong select').change();
	
}


// tạo html cho khung đếm số phiếu mua hàng
function ___eb_details_product_quan () {
//	if ( cf_tester_mode == 1 ) console.log('___eb_details_product_quan');
	
	//
	if ( jQuery('#oi_mua_max').length == 0 ) {
		return false;
	}
	
	//
	var a = jQuery('#oi_mua_max').attr('data-min') || '',
		b = jQuery('#oi_mua_max').attr('data-max') || '';
	if ( a != '' && b != '' ) {
		jQuery('#oi_mua_max').width( ( a * 100 / b ) + '%' );
		jQuery('#oi_con_phieu').html( b - a );
	}
	
}
// end details function /////////////////////////////////////////////////////////////////



// global function /////////////////////////////////////////////////////////////////
/*
* Các function dùng chung cho toàn trang sẽ được cho vào đây
* Sau đó các file js riêng của từng theme sẽ kế thừa và sử dụng các chức năng bằng cách gọi function
*/
// big banner
var big_banner_timeout1 = null;

(function () {
	
	var big_banner_len = jQuery('.oi_big_banner li').length;
	
	//
	if ( big_banner_len == 0 ) {
		jQuery('.hide-if-banner-null').hide();
		return false;
	}
	
	// chuyển big banner đến vị trí mới (chỉ làm khi số lượng big banner là 1)
	if ( big_banner_len > 0 && jQuery('.oi_big_banner').length == 1 && jQuery('.clone-big-banner-to-here').length > 0 ) {
		// thiết lập class để lát xóa
		jQuery('.oi_big_banner').addClass('oi_big_banner-remove');
		
		// nhân bản sang vị trí mới
		jQuery('.clone-big-banner-to-here').html( jQuery('.oi_big_banner').html() ).addClass('oi_big_banner').show();
		
		// xóa cái cũ
		jQuery('.oi_big_banner-remove').remove();
		
		// bỏ chế độ hiển thị menu liên quan đến big banner
		jQuery('.show-menu-if-banner').removeClass('show-menu-if-banner');
	}
	
	// tải slider theo code mới
	jEBE_slider( '.oi_big_banner', {
		autoplay : cf_slider_big_play > 0 ? true : false,
		speedNext: cf_slider_big_play,
		
		sliderArrow: ( cf_arrow_big_banner == 1 ) ? true : false,
		
//		thumbnail : '.banner-ads-media',
		size : jQuery('.oi_big_banner li:first .ti-le-global').attr('data-size') || ''
	});
	
	// Hiển thị menu NAV dưới dạng hover
	if ( big_banner_len > 0 && jQuery('.show-menu-if-banner').length > 0 ) {
		jQuery('.show-menu-if-banner .all-category-hover').addClass('selected');
		jQuery('.oi_big_banner').css({
			'min-height' : jQuery('.show-menu-if-banner .all-category-cats').height() + 'px'
		});
	}
	
})();

function ___eb_big_banner () {
	console.log('WARNING! Function ___eb_big_banner bas been remove, please clear in your code!');
}


// logo đối tác
(function () {
	// chỉ chạy trên pc
	/*
	if ( g_func.mb_v2() == true ) {
		return false;
	}
	*/
	
	//
	jQuery('.sponsor-top-desktop').each(function() {
		if ( jQuery('li', this ).length == 0 ) {
			jQuery(this).hide().remove();
		}
	});
	
	//
	if ( jQuery('.sponsor-top-desktop').length == 0 ) {
		if ( cf_tester_mode == 1 ) console.log('sponsor-top-desktop not found');
		return false;
	}
	
	//
	var len = jQuery('.banner-chan-trang:first li').length || 0;
	/*
	if ( len == 0 ) {
		jQuery('.sponsor-top-desktop, .hide-if-footer-banner-null').hide();
		return false;
	}
	*/
	
	// số thẻ LI mặc định được hiển thị/ 1000px
	var so_the_li_mong_muon = jQuery('.banner-chan-trang:first').attr('data-num') || 5;
//	console.log( so_the_li_mong_muon );
	/*
	if ( typeof so_the_li_mong_muon != 'number' ) {
		so_the_li_mong_muon = 5;
	}
	*/
	// -> chiểu rộng trung bình của mỗi LI
	so_the_li_mong_muon = 999/ so_the_li_mong_muon - 1;
//	console.log( so_the_li_mong_muon );
//	console.log( jQuery('.banner-chan-trang:first').width() );
	
	// tính toán số thẻ LI được hiển thị
	var global_chantrang_len = jQuery('.banner-chan-trang:first').width()/ so_the_li_mong_muon;
	global_chantrang_len = Math.ceil( global_chantrang_len ) - 1;
//	console.log( global_chantrang_len );
	
	// hiển thị 2 đối với bản mobile
	if ( global_chantrang_len == 1 && jQuery(window).width() < 400 ) {
		global_chantrang_len = 2;
	}
	
	// nếu nhiều hơn so với số LI thật -> gán lại giá trị mới
	/*
	if ( global_chantrang_len > len ) {
		global_chantrang_len = len;
	}
	*/
//	console.log( global_chantrang_len );
	
	//
	jQuery('.banner-chan-trang:first li').width( ( 100/ global_chantrang_len ) + '%' );
	_global_js_eb.auto_margin();
	
	//
//	jQuery('.home-next-chantrang, .home-prev-chantrang').hide();
	
	// không đủ thì thôi, ẩn nút next
	if ( len <= global_chantrang_len ) {
		
		jQuery('.banner-chan-trang:first').height('auto').css({
			'line-height' : jQuery('.banner-chan-trang:first').height() + 'px'
		});
		
		return false;
	}
	
	// đủ thì hiển thị và tạo hiệu ứng
	/*
	var li_fo_scroll = jQuery('.banner-chan-trang:first').attr('data-scroll') || global_chantrang_len;
	if ( typeof li_fo_scroll != 'number' ) {
		li_fo_scroll = global_chantrang_len;
	}
	*/
//	console.log( global_chantrang_len );
	
	//
//	jQuery('.home-next-chantrang, .home-prev-chantrang').hide();
	
	jEBE_slider( '.banner-chan-trang', {
		buttonListNext: false,
//		autoplay : true,
		visible : global_chantrang_len,
		
		sliderArrow: true,
//		sliderArrowWidthLeft : '40%',
//		sliderArrowWidthRight : '60%',
//		sliderArrowLeft : 'fa-chevron-circle-left',
//		sliderArrowRight : 'fa-chevron-circle-right',
		
//		thumbnail : 'ul li',
		size : jQuery('.banner-chan-trang li:first .ti-le-global').attr('data-size') || ''
	});
	
})();

function ___eb_logo_doitac_chantrang ( so_the_li_mong_muon, li_fo_scroll ) {
	console.log('WARNING! Function ___eb_logo_doitac_chantrang bas been remove, please clear in your code!');
}



// tạo hiệu ứng với phần danh sách sản phẩm
function ___eb_thread_list_li () {
	jQuery('.thread-list li').each(function() {
		var ngay = jQuery(this).attr('data-ngay') || 0,
	//		giacu = jQuery(this).attr('data-gia') || '',
	//		giamoi = jQuery(this).attr('data-giamoi') || '',
	//		a = jQuery(this).attr('data-giovang') || '',
	//		b = jQuery(this).attr('data-soluong') || 0,
	//		gia = jQuery(this).attr('data-gia') || 0,
			per = jQuery(this).attr('data-per') || 0;
		
	//	gia = parseInt(gia, 10);
		
		/*
		b = parseInt(b, 10);
		if (b <= 0 || isNaN(b)) {
			jQuery('.thread-list-chayhang', this).css({
				'background-image': 'url(images/bg-sold-out.png)'
			})
		}
		*/
		
		//
		if (per > 0) {
//			jQuery(this).addClass('thread-list-giamgiashow');
			
			//
			if (ngay > date_time) {
				jQuery(this).addClass('thread-list-giovangshow');
			}
		}
	});
	
	
	//
//	jQuery('.hide-if-gia-zero[data-per="0"]').addClass('aaaaaaaaa');
}


// thêm dòng phân cách cho thẻ breadcrumb
function ___eb_add_space_for_breadcrumb ( con ) {
	console.log('___eb_add_space_for_breadcrumb has been remove');
	
	/*
	if ( typeof con == 'undefined' ) {
		con = '/';
	}
	
	jQuery('.thread-details-tohome li').before('<li>' + con + '</li>');
	jQuery('.thread-details-tohome li:first').remove();
	*/
}


// hiệu ứng xem video tại chỗ
var press_esc_to_quickvideo_close = false,
	current_ls_url = window.location.href;

function close_img_quick_video_details () {
	// ẩn video
	jQuery('.quick-video').hide().height('auto');
	
	// xóa nội dung -> tránh video vẫn đang bật
	dog( 'quick-video-content', '&nbsp;' );
	
	//
	jQuery('#click_show_cpa, .hide-if-esc').hide();
	
	//
	jQuery('body').removeClass('body-no-scroll');
	
	window.history.pushState("", '', current_ls_url);
	
}

function ___eb_click_open_video_popup () {
	jQuery('.click-quick-view-video').each(function() {
		var a = jQuery(this).attr('data-video') || '',
			lnk = jQuery(this).attr('href') || '',
			module = jQuery(this).attr('data-module') || '';
		if ( module == '' ) {
			jQuery(this).attr({
				'data-module': 'video_no_group'
			});
		}
		
		// lấy URL để tạo ID cho youtube nếu không có ID
		if ( a == '' && lnk != '' ) {
			a = _global_js_eb.youtube_id( lnk );
//			if ( cf_tester_mode == 1 ) console.log( lnk );
			if ( a != '' ) {
//				if ( cf_tester_mode == 1 ) console.log( a );
				jQuery(this).attr({
					'data-video': '//www.youtube.com/embed/' + a
				});
			}
		}
	}).off('click').click(function () {
//		alert(1);
		var a = jQuery(this).attr('data-video') || '',
			tit = jQuery(this).attr('title') || '',
			lnk = jQuery(this).attr('href') || '',
			// nhóm các video liên quan theo module
			module = jQuery(this).attr('data-module') || '',
			str = '',
			arr_list_video = {};
		
		//
		if ( a != '' ) {
			
			//
			jQuery('.quick-video').show().height( jQuery(document).height() );
//			jQuery('body').addClass('body-scroll-disable');
			
			//
			var wit = jQuery('#quick-video-content').width(),
				hai = jQuery(window).height(),
				wit_hai = 0;
			
			// xem đang là màn ngang hay dọc
			if ( hai > wit ) {
				wit_hai = wit;
				wit = hai;
				hai = wit_hai;
			}
//			console.log( wit );
//			console.log( hai );
			
			// chiều cao video -> không để hết màn hình là đẹp
			hai = Math.ceil( hai/ 100 * 90 );
//			console.log( hai );
			
			//
			wit = Math.ceil( hai/ youtube_video_default_size );
//			console.log( wit );
			
			if ( wit > 1024 ) {
				wit = 1024;
				hai = Math.ceil( wit * youtube_video_default_size );
			}
			
			/*
			if ( hai > 600 ) {
				hai = 400;
			} else {
				hai = hai / 3 * 2;
			}
			*/
			
			//
			a = _global_js_eb.youtube_id( a );
//			alert(a);
			
			//
			if ( lnk == '' || lnk == 'javascript:;' ) {
			} else {
				// chỉ link nội bộ mới sử dụng chức năng này
				if ( lnk.split('//').length == 1 || lnk.split(web_link).length > 1 ) {
					window.history.pushState("", '', lnk);
				}
			}
			
			//
			str += '\
			<div class="quick-video-node">\
				<div class="quick-video-width" style="width:' + wit + 'px">\
					<div class="quick-video-title bold">' +tit+ '</div>\
					<iframe width="' + wit + '" height="' +hai+ '" src="//www.youtube.com/embed/' +a+ '?autoplay=1" frameborder="0" allowfullscreen></iframe>\
				</div>\
			</div>';
			
			
			
			// Tạo list video -> Lấy các video khác trên cùng trang
			var get_other_video = '.click-quick-view-video';
			if ( module != '' ) {
				if ( cf_tester_mode == 1 ) console.log(module);
				get_other_video = '.click-quick-view-video[data-module="' +module+ '"]';
			}
			if ( cf_tester_mode == 1 ) console.log(get_other_video);
			if ( cf_tester_mode == 1 ) console.log(jQuery(get_other_video).length);
			
			//
			jQuery(get_other_video).each(function () {
				var a2 = jQuery(this).attr('data-video') || '',
					tit2 = jQuery(this).attr('title') || '';
				
				//
				if ( a2 != '' ) {
					a2 = _global_js_eb.youtube_id( a2 );
					
					//
					if ( a2 != a ) {
						arr_list_video[a2] = tit2;
					}
				}
			});
//			console.log( arr_list_video );
			
			//
			for ( var x in arr_list_video ) {
				
				//
				str += '\
				<div class="quick-video-node">\
					<div class="quick-video-width" style="width:' + wit + 'px">\
						<div class="quick-video-title bold">' +arr_list_video[x]+ '</div>\
						<iframe width="' + wit + '" height="' +hai+ '" src="//www.youtube.com/embed/' +x+ '" frameborder="0" allowfullscreen></iframe>\
					</div>\
				</div>';
				
			}
			
			
			//
			var new_scroll_top = window.scrollY || jQuery(window).scrollTop();
			
			//
			jQuery('#quick-video-content').css({
				'padding-top' : new_scroll_top + 'px'
			});
			
			//
			dog( 'quick-video-content', str );
//			dog( 'quick-video-content', str + str + str + str + str + str + str );
			
			
			// chỉnh lại chiều cao dữ liệu một lần nữa
			jQuery('.quick-video').show().height( jQuery(document).height() );
			
			
			//
			return false;
		}
	});
//	jQuery('.click-quick-view-video:first').click();
	
	
	//
	jQuery('.quick-video-close i.fa-remove').click(function () {
		close_img_quick_video_details();
	});
}



// fix menu khi cuộn chuột
var fix_right_top_menu = 0,
	fix_menu_top_or_bottom = 'bottom',
	id_for_fix_main_content = '#main',
	id_for_fix_menu_content = '#main_right',
	// Kết thúc fix menu
	end_right_top_menu = 0,
	privary_main_height = jQuery( id_for_fix_main_content ).height() || 0,
	right_main_height = jQuery( id_for_fix_menu_content ).height() || 0,
	fix_right_window_height = jQuery(window).height(),
	fix_details_right_menu = false;

//
function ___eb_func_fix_right_menu () {
	
	// chiều cao của menu phải
//	var a = jQuery('.fix-right-menu').height();
	fix_right_window_height = jQuery(window).height();
	
	// chiều cao của main -> lớn hơn right thì mới dùng chức năng này
	privary_main_height = jQuery( id_for_fix_main_content ).height() || 0;
//	console.log( 'main: ' + privary_main_height );
	
	// điểm bắt đầu fix menu
	right_main_height = jQuery( id_for_fix_menu_content ).offset().top || 0;
	right_main_height += jQuery('.fix-right-menu').height();
//	console.log( 'main_right: ' + right_main_height );
	
	// xác định có auto scroll hay không
	fix_details_right_menu = false;
	if ( right_main_height < privary_main_height ) {
		fix_details_right_menu = true;
	}
	
	// thêm vào chiều cao của window để điểm cuối của scroll được ok
	if ( fix_menu_top_or_bottom == 'bottom' ) {
		right_main_height -= fix_right_window_height;
	}
	
	// điểm kết thúc fix menu
	end_right_top_menu = jQuery('#fix_end_right_menu').offset().top - fix_right_window_height;
//	console.log( 'end right: ' + end_right_top_menu );
	
	// fix style cho menu bên này, tránh bị vỡ khung
	jQuery('.fix-right-menu').width( jQuery('#fix_right_menu').width() ).css({
		left : jQuery('#fix_right_menu').offset().left + 'px'
	});
	
	//
	jQuery(window).scroll();
}

function ___eb_fix_left_right_menu () {
	
	//
	if ( g_func.mb_v2() == true ) {
		return false;
	}
	
	// Xác định lại vị trí menu
	setTimeout(function () {
		___eb_func_fix_right_menu();
	}, 2000);
	
	setInterval(function () {
		___eb_func_fix_right_menu();
	}, 5000);
	
	//
	jQuery(window).resize(function () {
		___eb_func_fix_right_menu();
//	}).on('load', function() {
//		___eb_func_fix_right_menu();
	}).scroll(function() {
//		console.log( fix_right_left_menu );
//		console.log( fix_right_top_menu );
//		console.log( end_right_top_menu );
		
		//
		var a = window.scrollY || jQuery(window).scrollTop();
//		console.log( end_right_top_menu );
		
		if ( fix_details_right_menu == true ) {
			if ( a > right_main_height ) {
				// fixed
				if ( a < end_right_top_menu ) {
					jQuery('body').removeClass('abs-right-menu').addClass('fixed-right-menu');
				}
				// absolute
				else {
					jQuery('body').removeClass('fixed-right-menu').addClass('abs-right-menu');
				}
			} else {
				jQuery('body').removeClass('fixed-right-menu').removeClass('abs-right-menu');
			}
		}
	});
}


function ___eb_show_cart_count () {
	var c = 'eb_cookie_cart_list_id',
		cart_id_in_cookie = g_func.getc( c );
//	console.log( cart_id_in_cookie );
	if ( cart_id_in_cookie == null ) {
		return false;
	}
//	console.log( cart_id_in_cookie );
	
	//
	cart_id_in_cookie = jQuery.trim(cart_id_in_cookie);
	if ( cart_id_in_cookie == '' ) {
		return false;
	}
	
	// bỏ dấu , ở đầu chuỗi
	if ( cart_id_in_cookie.substr(0, 1) == ',' ) {
		cart_id_in_cookie = cart_id_in_cookie.substr(1);
	}
	
	// tính tổng số SP
	jQuery('.show_count_cart').html( cart_id_in_cookie.split(',').length );
}
___eb_show_cart_count();




// function cho từng action

// các function này trước được gọi ở theme, giờ chuyển vào plugin thì bổ sung biến để kiểm tra nó chạy rồi hay chưa
var khong_chay_function_o_theme_nua = 0;

function ___eb_global_home_runing ( r ) {
	if ( khong_chay_function_o_theme_nua == 1 ) {
		console.log('WARNING!!!!!!!!!!!!!!!!!!! function ___eb_global_home_runing has been runing...');
		return false;
	}
	khong_chay_function_o_theme_nua = 1;
	
	if ( typeof Child_eb_global_home_runing == 'function' ) {
		Child_eb_global_home_runing();
	}
}

//
function ___eb_list_post_run ( r ) {
	if ( khong_chay_function_o_theme_nua == 1 ) {
		console.log('WARNING!!!!!!!!!!!!!!!!!!! function ___eb_list_post_run has been runing...');
		return false;
	}
	khong_chay_function_o_theme_nua = 1;
	
	if ( typeof Child_eb_list_post_run == 'function' ) {
		if ( cf_tester_mode == 1 ) console.log('Child_eb_list_post_run');
		
		Child_eb_list_post_run();
	}
	
	
	//
	(function ( a ) {
		
		if ( a != '' ) {
			
			// chỉ xử lý khi nội dung đủ lớn
			if ( cf_cats_description_viewmore < 0 ) {
				if ( cf_tester_mode == 1 ) console.log('View more category disable!');
				
				jQuery('.global-cats-description').hide();
				
				return false;
			}
//			else if ( cf_cats_description_viewmore > 0 && jQuery('.global-cats-description').height() < cf_cats_description_viewmore * 1.5 ) {
			else if ( cf_cats_description_viewmore == 0 || jQuery('.global-cats-description').height() < cf_cats_description_viewmore * 1.5 ) {
//				console.log( jQuery('.global-cats-description').height() );
				jQuery('.global-cats-description').addClass('global-cats-description-active');
				return false;
			}
			
			// hiển thị nút bấm hiển thị thêm nội dung
			jQuery('.viewmore-cats-description').show();
			
			// thêm class tạo hiệu ứng thu gọn nội dung
			jQuery('.global-cats-description').addClass('global-cats-description-scroll').height( cf_cats_description_viewmore );
			
			//
			jQuery('.click-viewmore-cats-description').click(function () {
				jQuery('.global-cats-description').toggleClass('global-cats-description-active');
				
				window.scroll( 0, jQuery('.global-cats-description').offset().top - 90 );
			});
			
		} else {
			jQuery('.global-cats-description').hide();
		}
		
	})( jQuery('.global-cats-description').html() || '' );
}





//
function WGR_for_post_details ( function_for_post, function_for_blog ) {
	
	//
	if ( typeof switch_taxonomy == 'undefined' ) {
		console.log('switch_taxonomy not found');
		return false;
	}
	
	// post
	if ( switch_taxonomy == 'post' ) {
		/*
		if ( typeof function_for_post == 'function' ) {
			___eb_details_post_run( function_for_post );
		}
		else {
			*/
			___eb_details_post_run();
//		}
	}
	// blog, page...
	else {
		/*
		if ( typeof function_for_blog == 'function' ) {
			___eb_global_blog_details_runing( function_for_blog );
		}
		else {
			*/
			___eb_global_blog_details_runing();
//		}
	}
	
	
	// tạo mục lục cho trang chi tiết sản phẩm, chi tiết blog
	(function () {
		
		//
		if ( cf_post_index_content == '' ) {
			return false;
		}
		
		//
		var str = '';
		
		jQuery('.thread-content-bmask ' + cf_post_index_content).each(function() {
			var jd = jQuery(this).attr('id') || '',
				a = jQuery(this).html();
			
			if ( jd == '' ) {
				jd = '_' + Math.random().toString(32).replace(/\./g, '_');
				
				jQuery(this).attr({
					id: jd
				});
			}
			
			str += '<li data-id="' + jd + '">' + g_func.strip_tags( a ) + '</li>';
		});
		
		//
		if ( str == '' ) {
			if ( cf_tester_mode == 1 ) console.log('Post index not found!');
			return false;
		}
		str = '<div class="thread-details-index"><strong>Nội dung chính:</strong><ul>' + str + '</ul></div>';
		
		// cho đến thẻ H2 đầu tiên
		if ( jQuery('.thread-content-bmask p').length > 0 ) {
			jQuery('.thread-content-bmask p:first').after( str );
		}
		else if ( jQuery('.thread-content-bmask .ul-default-style div').length > 0 ) {
			jQuery('.thread-content-bmask .ul-default-style:first div:first').after( str );
		}
		else {
			jQuery('.thread-content-bmask').before( str );
//			jQuery('.thread-content-bmask h2:first').before( str );
		}
		
		//
		jQuery('.thread-details-index li').click(function () {
			var a = jQuery(this).attr('data-id') || '';
			
			if ( a != '' ) {
//				window.scroll( 0, jQuery('#' + a).offset().top - 90 );
				jQuery('body,html').animate({
					scrollTop: jQuery('#' + a).offset().top - 90
				}, 800);
			}
		});
		
	})();
	
}

//
function ___eb_details_post_run ( r ) {
	if ( khong_chay_function_o_theme_nua == 1 ) {
		console.log('WARNING!!!!!!!!!!!!!!!!!!! function ___eb_details_post_run has been runing...');
		return false;
	}
	khong_chay_function_o_theme_nua = 1;
	
	// với bản pc -> chỉnh lại kích thước ảnh thành fullsize (mặc định trước đó trong admind dể mobile hết)
	/*
	if ( jQuery(window).width() > 768 ) {
		jQuery('#content_img_product img, .max-width-img-content img, .echbay-tintuc-noidung img').removeAttr('sizes');
		console.log('Set img fullsize for mobile');
	}
	*/
	
	// chạy function riêng (nếu có)
	/*
	if ( typeof r == 'function' ) {
		r();
	}
	*/
	if ( typeof Child_eb_details_post_run == 'function' ) {
		Child_eb_details_post_run();
	}
	
	
	/*
	* và function chung mà phần lớn theme đều cần đến
	*/
	
	// slider cho trang chi tiết
	___eb_details_slider_v2();
	
	
	// tạo style cho phần tóm tắt
	___eb_details_excerpt_html();
	___eb_details_ul_options();
	
	
	//
	___eb_details_product_tab();
	
	
	// tạo bộ đếm lượt mua
	___eb_details_product_quan();
	
	
	// mặc định form quick cart nằm cuối trang
//	jQuery('form[name^=frm_cart]').addClass('eb-global-frm-cart');
	
	// -> một số theme nào cần hiển thị thì tạo kiểm tra class và đưa lên
	if ( jQuery('.clone-show-quick-cart').length > 0 ) {
		jQuery('.clone-show-quick-cart').html( jQuery('#click_show_cpa .cart-quick-padding').html() );
		
		// xong thì xóa cái quick cart, size, color mặc định đi
		jQuery('#click_show_cpa, .remove-if-clone-quickcart').remove();
		
//		jQuery('.clone-show-quick-cart input[name^="t_muangay"]').val( pid );
//		jQuery('.clone-show-quick-cart input[name="t_muangay[]"]').val( pid );
	}
	// nạp ID cho phần quick cart
//	else {
		// nạp ID cho phần quick cart
//		jQuery('#click_show_cpa input[name^="t_muangay"]').val( pid );
//		jQuery('#click_show_cpa input[name="t_muangay[]"]').val( pid );
//	}
	jQuery('.eb-global-frm-cart input[name^=t_muangay]').val( pid );
	
	// color
	___eb_details_product_color();
	
	// size
	___eb_details_product_size();
	
	// selext box số lượng sản phẩm khi mua hàng
	___eb_details_cart_quan();
	
	// nạp thông tin khách hàng (nếu có)
	_global_js_eb.cart_customer_cache();
	
	// facebook track
	var track_arr = {
		'content_ids' : [pid],
		'content_name' : product_js.tieude
	};
	if ( typeof product_js.gm == 'number' && product_js.gm > 0 ) {
		track_arr.value = product_js.gm;
//		track_arr.currency = 'VND';
		track_arr.currency = cf_current_sd_price;
	}
	_global_js_eb.fb_track( 'ViewContent', track_arr );
	
	
	
	
	//
	/*
	var arr_attr_img_content = [],
		i = 0;
	jQuery('.thread-details-tab-content img').each(function(index, element) {
		var arr = {};
		
		jQuery(this).each(function() {
			jQuery.each(this.attributes, function() {
				// this.attributes is not a plain object, but an array
				// of attribute nodes, which contain both the name and value
				if(this.specified) {
//					console.log(this.name, this.value);
					
					arr[this.name] = this.value;
				}
			});
		});
		
		//
		arr_attr_img_content[i] = arr;
		i++;
	});
	console.log( arr_attr_img_content );
	*/
	
	
	
	// đếm thời gian hiển thị
//	console.log(trv_ngayhethan);
	if ( trv_ngayhethan > 0 ) {
		(function () {
			
			var id_for_show = 'oi_time_line';
			
			// nếu ko có ID để hiển thị thời gian -> hủy bỏ luôn
			if ( dog(id_for_show) == null ) {
				if ( cf_tester_mode == 1 ) console.log('Thời gian hết hạn được kích hoạt, nhưng không tìm thấy DIV id="' + id_for_show + '"');
				return false;
			}
			
			// nếu có -> hiển thị thời gian
			jQuery('#' + id_for_show).before('<div class="medium l35">' + lang_details_time_discount + '</div>');
			
			// Nếu trả về false -> khả năng cao là hết hạn hiển thị -> hiển thị thông báo hết hạn
			if ( ___wgr_dem_thoi_gian_san_pham( trv_ngayhethan - date_time ) == false ) {
				dog('oi_time_line').innerHTML = lang_details_time_soldout;
				jQuery('#' + id_for_show).removeClass('bold');
			}
			// điều chỉnh class theo style riêng
			else {
				jQuery('#' + id_for_show).addClass('global-details-countdown');
			}
			
		})();
	}
	
	// hiển thị con dấu hàng chính hãng
	if ( WGR_check_option_on( _eb_product_chinhhang ) ) {
		if ( cf_tester_mode == 1 ) console.log('Hàng chính hãng');
		
		//
		if ( jQuery('.show-tem-chinh-hang').length > 0 ) {
			jQuery('.show-tem-chinh-hang').addClass('tem-chinh-hang').html('&nbsp;');
		}
		else {
//			jQuery('.pdetail-slider-btn').after('<div class="tem-chinh-hang">&nbsp;</div>');
			jQuery('.thread-details-mobileCenter').after('<div class="tem-chinh-hang">&nbsp;</div>');
		}
	}
	
	
	
	// tạo hiệu ứng thu gọn nội dung -> bấm xem thêm để hiển thị đầy đủ
	(function () {
		// thiết lập bằng 0 -> tắt chức năng
		if ( cf_product_details_viewmore == 0 ) {
			return false;
		}
		
		// nếu mở trong iframe -> không dùng chức năng thu gọn nội dung
		if ( top != self ) {
			if ( cf_tester_mode == 1 ) console.log('Short post content is active! but post open in iframe!');
			return false;
		}
		
		var a = null;
		
		// chỉnh theo phần mặt nạ của nội dung
		if ( jQuery('.thread-content-bmask').length > 0 ) {
			a = jQuery('.thread-content-bmask');
		}
		// mặc định là can thiệp vào nội dung luôn
		else if ( jQuery('#content_img_product').length > 0 ) {
			a = jQuery('#content_img_product');
		}
		else {
			console.log('thread-content-bmask or content_img_product not found!');
		}
		
		if ( a != null ) {
			
			// nếu tính năng được kích hoạt, nhưng chiều cao không đủ
			if ( a.height() < cf_product_details_viewmore * 1.5 ) {
				if ( cf_tester_mode == 1 ) console.log('cf_product_details_viewmore it active! but height of content not enough');
				return false;
			}
			
			//
			a.addClass('thread-content-viewmore').height( cf_product_details_viewmore ).after('<br /><div class="text-center"><a href="javascript:;" class="click-viewmore-thread-details">Xem thêm</a></div>');
			
			//
			jQuery('.click-viewmore-thread-details').click(function () {
				jQuery('.thread-content-bmask, #content_img_product').height('auto').removeClass('thread-content-viewmore');
				
				jQuery('.click-viewmore-thread-details').hide();
				
				var new_scroll = jQuery('#content_img_product').offset().top || jQuery('.thread-content-bmask').offset().top || 0;
				
				if ( new_scroll > 0 ) {
					window.scroll( 0, new_scroll - 110 );
				}
			});
		}
		
	})();
	
	
	
	//
	___wgr_set_product_id_cookie();
	
	
	// thêm chiều rộng tuyệt đối cho khung nội dung
	var a = jQuery('#content_img_product').attr('data-max-width') || '';
	if ( a == '' ) {
		jQuery('#content_img_product').attr({
			'data-max-width': cf_img_details_maxwidth
		});
	}
	
}

// danh sách sản phẩm đã xem, lưu dưới dạng cookies
function ___wgr_set_product_id_cookie ( cookie_name, add_id, limit_history, limit_save ) {
	// tên của cookie lưu trữ
	if ( typeof cookie_name == 'undefined' || cookie_name == '' ) {
		cookie_name = 'wgr_product_id_view_history';
	}
	
	// giới hạn lưu trữ
	if ( typeof limit_history == 'undefined' || limit_history < 0 ) {
		limit_history = 25;
	}
	else {
		limit_history = parseInt( limit_history, 10 );
	}
	
	// thời hạn lưu trữ
	if ( typeof limit_save == 'undefined' || limit_save < 0 ) {
		limit_save = 7;
	}
	else {
		limit_save = parseInt( limit_save, 10 );
	}
	
	// ID lưu trữ
//	console.log(typeof add_id);
//	console.log(add_id);
	if ( typeof add_id == 'undefined' || add_id == '' || add_id < 0 ) {
		add_id = pid;
	}
	else {
		add_id = parseInt( add_id, 10 );
	}
//	console.log(typeof add_id);
//	console.log(add_id);
	if ( add_id <= 0 ) {
		if ( cf_tester_mode == 1 ) console.log('new ID for add not found: ' + add_id);
		return false;
	}
	
	// lấy danh sách trong cookie trước đó
	var str_history = g_func.getc(cookie_name),
		new_id = '[' + add_id + ']';
	if ( cf_tester_mode == 1 ) {
		console.log(str_history);
		limit_history = 5;
	}
	
	// nếu chưa có -> null
	if ( str_history == null || str_history == '' ) {
		str_history = '';
	}
	// nếu có rồi -> kiểm tra có trùng với ID hiện tại không
	else if ( str_history.split( new_id ).length > 1 ) {
		if ( cf_tester_mode == 1 ) console.log('product ID exist in history cookie');
		return false;
	}
	
	//
//	str_history = str_history.replace( '[' + pid + ']', '' );
//	console.log(str_history);
	
	// kiểm tra đọ dài của log
	var check_history = str_history.split('][');
//	console.log(check_history.length);
//	console.log(check_history);
	
	// nếu nhiều quá -> thay mảng cuối bằng ID hiện tại
	if ( check_history.length >= limit_history ) {
		// thêm vào cuối
//		check_history[ check_history.length - 1 ] = pid + ']';
		
		// sau đó ghép chuỗi lại -> trong giới hạn cho phép thì ghép luôn là được
		if ( check_history.length < limit_history * 2 ) {
			// thêm vào đầu
			check_history[ 0 ] = '[' + add_id;
			
			str_history = check_history.join('][');
		}
		else {
			str_history = '';
			for ( var i = 0; i < limit_history + 1; i++ ) {
				str_history += check_history[i] + '][';
			}
			// thêm vào cuối
			str_history += add_id + ']';
		}
		if ( cf_tester_mode == 1 ) console.log('Split history: ' + str_history);
	}
	// thêm mới
	else {
		// thêm vào cuối
//		str_history += new_id;
		
		// thêm vào đầu
		str_history = new_id + str_history;
	}
//	console.log(str_history);
//	return false;
	
	// lưu cookie mới
	g_func.setc(cookie_name, str_history, 0, limit_save);
	
	//
	return str_history;
}



function ___wgr_dem_thoi_gian_san_pham ( thoi_gian_con_lai ) {
	
	// hết hạn hiển thị
	if ( thoi_gian_con_lai < 0 ) {
		console.log('Hết hạn hiển thị');
		return false;
	}
	
	// hẹn giờ load lại chức năng
	setTimeout(function () {
		___wgr_dem_thoi_gian_san_pham( thoi_gian_con_lai - 1 );
	}, 1000);
	
	// còn hạn hiển thị
//	console.log(thoi_gian_con_lai);
//	return false;
	
	//
	var so_du = thoi_gian_con_lai % 3600;
	var gio = (thoi_gian_con_lai - so_du) / 3600;
	if ( gio < 10 ) gio = '0' + gio;
	var giay = so_du % 60;
	if ( giay < 10 ) giay = '0' + giay;
	var phut = (so_du - giay)/ 60;
	if ( phut < 10 ) phut = '0' + phut;
	
	var ngay = 0;
	if ( gio > 24 ) {
		ngay = gio;
		gio = gio % 24;
		ngay = (ngay - gio)/ 24;
	}
	
	//
//	console.log(gio + ':' + phut + ':' + giay);
	dog('oi_time_line').innerHTML = '<span>' + ngay + '<em>ngày</em></span><span>' + gio + '<em>giờ</em></span><span>' + phut + '<em>phút</em></span><span>' + giay + '<em>giây</em></span>';
	
	return true;
	
}






function ___eb_global_blogs_runing ( r ) {
	if ( khong_chay_function_o_theme_nua == 1 ) {
		console.log('WARNING!!!!!!!!!!!!!!!!!!! function ___eb_global_blogs_runing has been runing...');
		return false;
	}
	khong_chay_function_o_theme_nua = 1;
	
	if ( typeof Child_eb_global_blogs_runing == 'function' ) {
		Child_eb_global_blogs_runing();
	}
}


function ___eb_global_blog_details_runing ( r ) {
	if ( khong_chay_function_o_theme_nua == 1 ) {
		console.log('WARNING!!!!!!!!!!!!!!!!!!! function ___eb_global_blog_details_runing has been runing...');
		return false;
	}
	khong_chay_function_o_theme_nua = 1;
	
	if ( typeof Child_eb_global_blog_details_runing == 'function' ) {
		Child_eb_global_blog_details_runing();
	}
	
	
	// lưu cookie tạo view cho blog, page
	if ( pid > 0 ) {
		var check_update_views = g_func.getc('wgr_post_id_view_history'),
			new_id = '[' + pid + ']';
		if ( cf_tester_mode == 1 ) {
			console.log(check_update_views);
		}
		
		// nếu không có dữ liệu hoặc xem nhiều tin quá -> xóa bớt đi thôi
		if ( check_update_views == null || check_update_views.split('][').length > 30 ) {
			check_update_views = '';
		}
		
		//
		if ( check_update_views.split( new_id ).length == 1 ) {
			g_func.setc('wgr_post_id_view_history', new_id + check_update_views, 0, 7);
		}
	}
}

// end global function /////////////////////////////////////////////////////////////////







// hiển thị bộ thẻ tag nếu có
if ( jQuery('.thread-details-tags a').length > 0 ) {
	jQuery('.thread-details-tags').show();
}
//console.log( jQuery('.thread-details-tags a').length );




// Kiểm tra người dùng đã đăng nhập chưa
if ( isLogin > 0 && logout_url != '' ) {
	jQuery('.oi_member_func').html( '<a href="' + web_link + 'profile" class="bold"><i class="fa fa-user"></i> ' + lang_taikhoan + '</a> <a onclick="return confirm(\'' + lang_xacnhan_thoat + '\');" href="' +logout_url+ '">' + lang_thoat + '</a>' );
} else {
	jQuery('.oi_member_func').html( '<a href="javascript:;" onclick="g_func.opopup(\'login\');"><i class="fa fa-user"></i> ' + lang_dangnhap + '</a> <a onclick="g_func.opopup(\'register\');" href="javascript:;">' + lang_dangky + '</a>' );
}
//jQuery('.oi_member_func').addClass('fa fa-user');

//
function ___eb_custom_login_done () {
	window.location = window.location.href;
}




// tạo menu cho bản mobile ( nếu chưa có )
/*
if ( jQuery('#nav_mobile_top li').length == 0 ) {
	jQuery('#nav_mobile_top').html( '<ul>' + ( jQuery('.nav-menu ul').html() || jQuery('.global-nav ul').html() || '' ) + '</ul>' );
	
	jQuery('#nav_mobile_top li').removeAttr('id');
}

jQuery('#nav_mobile_top li li a').each(function() {
	jQuery(this).html( '<i class="fa fa-angle-right"></i> ' + jQuery(this).html() );
});
*/

//
jQuery('#nav_mobile_top li').click(function () {
	jQuery('#nav_mobile_top li').removeClass('active');
	jQuery(this).addClass('active');
});


//
jQuery('#click_show_mobile_bars').click(function () {
	var a = jQuery(this).attr('data-show') || '';
	
	// đang hiển thị
	if ( a == 1 ) {
		a = 0;
		
		jQuery('.menu-mobile-nav').hide();
		
		jQuery('body').css({
			overflow : 'auto'
		});
	}
	// đang ẩn
	else {
		// trỏ vào khung tìm kiếm luôn
		jQuery('#value_add_to_search').focus();
		
		//
		a = 1;
		
		jQuery('.menu-mobile-nav').show().height( jQuery(window).height() );
		
		jQuery('body').css({
			overflow : 'hidden'
		});
	}
	
	jQuery(this).attr({
		'data-show' : a
	});
	
	jQuery('#click_show_mobile_bars i').toggleClass('fa-bars').toggleClass('fa-remove');
	
	//
	/*
	if ( jQuery('.menu-mobile-nav').height() > jQuery(window).height() ) {
		jQuery('.menu-mobile-nav').height( jQuery(window).height() - 50 );
		
		jQuery('body').css({
			overflow : 'hidden'
		});
	} else {
		jQuery('.menu-mobile-nav').height( '' );
		
		jQuery('body').css({
			overflow : ''
		});
	}
	*/
});
//jQuery('#click_show_mobile_bars').click();




//
jQuery('#click_show_search_bars').click(function () {
	jQuery('#click_show_mobile_bars').click();
//	jQuery('body').toggleClass('show-search-mobile');
});
//jQuery('#click_show_search_bars').click();





//
var arr_detect_browser = (function () {
	var r = 'unknown';
	if ((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1) {
		r = 'Opera';
	} else if (navigator.userAgent.indexOf("Chrome") != -1) {
		r = 'Chrome';
	} else if (navigator.userAgent.indexOf("Safari") != -1) {
		r = 'Safari';
	} else if (navigator.userAgent.indexOf("Firefox") != -1) {
		r = 'Firefox';
	}
	else if ((navigator.userAgent.indexOf("MSIE") != -1)
	// IF IE > 10
	|| (!document.documentMode == true)) {
		r = 'IE';
	}
	
	return r.toLowerCase();
})( navigator.userAgent );
//alert( arr_detect_browser );

//
/*
jQuery('.phone-numbers-block').attr({
	'data-block': 1
});
*/


//
var str_for_click_call = 'tel';
/*
if ( navigator.userAgent.toLowerCase().split("iphone").length > 1
|| arr_detect_browser == 'safari' ) {
if ( arr_detect_browser == 'safari' ) {
	str_for_click_call = 'callto';
}
*/



// trên safari nó tự nhận diện số điện thoại -> không can thiệp bằng thẻ a
//if ( arr_detect_browser == 'safari' && g_func.mb_v2() == true ) {
	/*
if ( arr_detect_browser == 'safari' ) {
	jQuery('.phone-numbers-inline').each(function() {
		var a = jQuery(this).html() || '';
		
		a = a.replace(/<br\s*[\/]?>/gi, "\n").replace(/\r\n|\r|\n/g, " - ");
		
		jQuery(this).html(a);
	});
} else {
	*/
	jQuery('.phone-numbers-inline, .phone-numbers-block').each(function() {
		
		if ( jQuery('a', this).length > 0 ) {
			return false;
		}
		
		//	
		var a = jQuery(this).html() || '',
			block = jQuery(this).attr('data-block') || '';
//		if (a.length >= 8) {
		if (a != '') {
			a = a.replace(/<br\s*[\/]?>/gi, "\n").replace(/\r\n|\r|\n/g, "[br]").split("[br]");
//			console.log(a);
			
			var str = '';
			for (var i = 0; i < a.length; i++) {
				a[i] = g_func.trim(a[i]);
				if (a[i] != '') {
					if (block == '' && str != '') {
						str += ' - ';
					}
					
					//
//					str += '<a href="' + str_for_click_call + ':' + a[i].toString().replace(/[^0-9|\+]/g, '') + '" rel="nofollow" class="gg-phone-conversion">' + a[i] + '</a>';
					str += '<a title="' + jQuery.trim( g_func.strip_tags( a[i] ) ) + '" class="phone-to-cell">' + a[i] + '</a>';
				}
			}
			
			jQuery(this).html(str);
		}
		
	});
	
	//
//	jQuery('.phone-numbers-block a').addClass('d-block');
//}

//
jQuery('.phone-numbers-inline a, .phone-numbers-block a').addClass('gg-phone-conversion');


//
jQuery('a.phone-to-cell').each(function() {
	var a = jQuery(this).attr('title') || jQuery(this).html() || '';
	a = a.toString().replace(/[^0-9|\+]/g, '');
//	if (a != '') {
	if (a.length >= 8) {
		jQuery(this).attr({
			href: str_for_click_call + ':' + a,
//			target: "_blank",
			rel: "nofollow"
		}).removeAttr('title');
	}
}).removeClass('phone-to-cell').addClass('gg-phone-conversion');

// track for phone or add to cart
jQuery('a.gg-phone-conversion').click(function () {
	var a = jQuery(this).attr('href') || '';
	
	// nếu có chức năng kiểm tra lượt bấm gọi của gg -> nạp vào
	_global_js_eb.gg_track( a );
	
	_global_js_eb.ga_event_track( 'Click to phone', a );
	
	
	// khi người dùng nhấp gọi điện
	_global_js_eb.fb_track( 'Call' );
	
	
	//
//	return false;
});




function WGR_show_or_hide_to_top () {
	var new_scroll_top = window.scrollY || jQuery(window).scrollTop();
	
	//
	/*
	if ( didScroll == true ) {
		didScroll = false;
		*/
	if (new_scroll_top > 120) {
		jQuery('body').addClass('ebfixed-top-menu');
		
		//
		if (new_scroll_top > 500) {
//		if ( new_scroll_top < old_scroll_top ) {
			jQuery('body').addClass('ebshow-top-scroll');
			
			//
			_global_js_eb.ebBgLazzyLoad(new_scroll_top);
		}
		else {
			jQuery('body').removeClass('ebshow-top-scroll');
		}
	} else {
		jQuery('body').removeClass('ebfixed-top-menu').removeClass('ebshow-top-scroll');
	}
	/*
	clearTimeout( set_old_scroll_top );
	set_old_scroll_top = setTimeout(function () {
//		old_scroll_top = new_scroll_top;
		didScroll = true;
	}, 200);
//	}
*/
	
	/*
	if (new_scroll_top > 500) {
//		jQuery('#oi_scroll_top').show();
		
		_global_js_eb.ebBgLazzyLoad(new_scroll_top);
//	} else {
//		jQuery('#oi_scroll_top').hide();
	}
	*/
}




//
jQuery('#oi_scroll_top, .oi_scroll_top').click(function() {
//	jQuery('body,html').animate({
	jQuery('body,html').animate({
		scrollTop: 0
	}, 800);
});





// thêm class định hình cho hình ảnh của elementor
jQuery('.elementor-image').addClass('img-max-width');

//_global_js_eb.ebBgLazzyLoadOffset();
_global_js_eb.ebBgLazzyLoad();
_global_js_eb.auto_margin();
setTimeout(function () {
	_global_js_eb.auto_margin();
}, 2000);



/*
var old_scroll_top = 0,
	set_old_scroll_top = null,
	didScroll = true;
*/
jQuery(window).resize(function() {
	/*
	if (jQuery(window).width() > 1240) {
		jQuery('#qc_2ben_left, #qc_2ben_right').show();
	} else {
		jQuery('#qc_2ben_left, #qc_2ben_right').hide();
	}
	*/
	
	_global_js_eb.auto_margin();
//}).on('load', function(e) {
	
	/*
	if (pid <= 0 && qc_2ben.length > 0 && jQuery(window).width() > 1100) {
		load_ads_2ben = true;
	}
	*/
	
//	_global_js_eb.auto_margin();
	
	
	/*
	var a = jQuery('.thread-details-content').width();
	
	jQuery('.thread-details-content img').each(function() {
		var w = jQuery(this).attr('width') || a;
		
		jQuery(this).css({
			'width' : 'auto',
			'height' : 'auto',
			'max-width' : w + 'px'
		});
	}).removeAttr('width').removeAttr('height');
	*/
//}).scroll(function() {
//	WGR_show_or_hide_to_top();
});

//
setInterval(function () {
	WGR_show_or_hide_to_top();
}, 250);


//
/*
setInterval(function () {
	if ( didScroll == true ) {
		didScroll = false;
		old_scroll_top = window.scrollY || jQuery(window).scrollTop();
	}
}, 250);
*/



//
/*
setTimeout(function () {
	_global_js_eb.user_loc();
}, 5000);
*/




/*
jQuery('.click-show-top-top-bars').click(function () {
	jQuery('.top-top-position').toggleClass('top-top-2position');
	
	jQuery('.click-show-top-top-bars i').toggleClass('fa-bars').toggleClass('fa-remove');
});
*/




/*
jQuery('.click-show-div-content').click(function () {
	var a = jQuery(this).attr('data-show') || '';
	
	//
	jQuery(a).toggle();
	
	//
	return false;
});
*/




// show content like the_content() -> wp nó tự bỏ thẻ P trong nội dung -> dùng cái này để tạo lại
(function () {
	
	//
	if ( jQuery('.each-to-fix-ptags').length == 0 ) {
		return false;
	}
//	console.log( jQuery('.each-to-fix-ptags').length );
	
	// xử lý lỗi nếu bị 2 lần fix ptag -> chưa xác định nguyên nhân cụ thể
	jQuery('.each-to-fix-ptags .each-to-fix-ptags').removeClass('each-to-fix-ptags');
	jQuery('.each-to-fix-ptags .each-to-fix-ptags').removeClass('each-to-fix-ptags');
	
	//
	jQuery('.each-to-fix-ptags').each(function() {
		if ( jQuery('script', this).length > 0 || jQuery('script', this).length > 0 ) {
			console.log('each-to-fix-ptags has been active! but, SCRIPT or STYLE exist in this content.');
			return false;
		}
		
		//
		var a = jQuery(this).html() || '',
			tag = jQuery(this).attr('data-tag') || 'div';
		
		if ( a != '' ) {
			a = g_func.trim( a );
			
			/*
			a = a.split("\n");
			
			var str = '';
			for ( var i = 0; i < a.length; i++ ) {
				a[i] = g_func.trim( a[i] );
				
				if ( a != '' ) {
					str += '<p>' +a[i]+ '</p>';
				}
			}
			
			//
			jQuery(this).html( str );
			*/
			
			var arr = a.split("\n");
//			console.log( arr );
			a = '';
			
			for ( var i = 0; i < arr.length; i++ ) {
				arr[i] = g_func.trim( arr[i] );
				
				if ( arr[i] != '' ) {
					a += '<div>' + arr[i] + '</div>';
				}
			}
			
			//
			/*
			a = a.replace( /\r\n|\n|\r/gi, '</' + tag + '><' + tag + '>' );
			a = '<' + tag + '>' + a + '</' + tag + '>';
			
			// xóa các dòng không có nội dung
			if ( tag == 'div' ) {
				a = a.replace( /\<div\>\<\/div\>/gi, '' );
			}
			else if ( tag == 'p' ) {
				a = a.replace( /<p><\/p>/gi, '' );
			}
			*/
			
			jQuery(this).html( a );
			
			// test
//			console.log( '<div>' + a.replace( /\r\n|\n|\r/gi, '</div><div>' ).replace( /\<div\>\<\/div\>/gi, '' ) + '</div>' );
		}
	});
	
	// xong việc thì xóa class này đi, để đỡ bị lặp lại -> phòng lỗi
	jQuery('.each-to-fix-ptags').removeClass('each-to-fix-ptags');
	
})();






// tính số ngày hết hạn của sản phẩm
var threadDetailsTimeend = null;
function ___eb_thread_details_timeend () {
	threadDetailsTimeend = setInterval(function () {
		if ( jQuery('.thread-details-timeend').length == 0 ) {
			clearInterval(threadDetailsTimeend);
			return false;
		}
		
		//
		jQuery('.thread-details-timeend').each(function() {
			var te = jQuery(this).attr('data-timeend') || '';
	//		te = date_time + 24 * 3600 + 5;
	//		console.log( te );
			if ( te != '' ) {
				var a = te - date_time;
				
				//
				if ( a > 0 ) {
					var mot_ngay = 24 * 3600,
						giay = a % 60,
						phut = a - giay,
						phut = a > 3600 ? phut % 3600 : phut,
						ngay = a > mot_ngay ? Math.ceil( a/ mot_ngay ) - 1 : 0,
						gio = ngay > 0 ? a - ngay * mot_ngay : a,
	//					so_du = a > mot_ngay ? a % mot_ngay : a,
	//					phut = gio > 0 ? a % 3600 : a,
						bbbbbbb = 1;
					
					//
					gio = Math.ceil( gio/ 3600 ) - 1;
					phut = phut/ 60;
					if (phut == 0 && giay == 0) {
						phut = 59;
					}
					
					//
					ngay = ngay < 10 ? "0" + ngay : ngay;
					gio = gio < 10 ? "0" + gio : gio;
					phut = phut < 10 ? "0" + phut : phut;
					giay = giay < 10 ? "0" + giay : giay;
					
					//
					jQuery(this).attr({
						'data-timeend' : te - 1
					}).html( '\
					<li><div><span>' +ngay+ '<em>Ngày</em></span></div></li>\
					<li><div><span>' +gio+ '<em>Giờ</em></span></div></li>\
					<li><div><span>' +phut+ '<em>Phút</em></span></div></li>\
					<li><div><span>' +giay+ '<em>Giây</em></span></div></li>' ).show();
				} else {
					jQuery(this).removeClass('thread-details-timeend');
				}
			} else {
				jQuery(this).removeClass('thread-details-timeend');
			}
		});
	}, 1000);
}






// auto search
(function () {
	
	//
	if ( typeof thread_js_list != 'object' ) {
		return false;
	}
	
	// kiểm tra chế độ tự động tìm kiếm
	var data_auto_search = jQuery('#search_keys').attr('data-auto-search') || '';
//	console.log(data_auto_search);
	
	// nếu đang bật -> kích hoạt chức năng tự tìm
	if ( data_auto_search == 'off' ) {
		return false;
	}
	
	//
	for ( var x in thread_js_list ) {
		thread_js_list[x].key = g_func.non_mark_seo( thread_js_list[x].tag ) + thread_js_list[x].seo;
		thread_js_list[x].key = thread_js_list[x].key.replace( /\-/g, '' );
//		console.log(thread_js_list[x].key);
	}
	
	jQuery('#search_keys').attr({
		 autocomplete : "off"
	}).focus(function () {
		jQuery('#oiSearchAjax').fadeIn();
	}).blur(function () {
		setTimeout(function () {
			jQuery('#oiSearchAjax').hide();
		}, 200);
	}).keyup(function (e) {
		var a = jQuery(this).val(),
			b = g_func.non_mark_seo( a );
		
		//
		if ( b.length < 3 ) {
			jQuery('#oiSearchAjax').hide();
			return false;
		}
		
		//
		b = b.replace( /\-/g, '' );
		
		// thử tìm sản phẩm trong js trước
		var str = '',
			i = 1;
		for ( var x in thread_js_list ) {
			if ( thread_js_list[x].key.split(b).length > 1 ) {
				str += '<li><a title="' + thread_js_list[x].ten + '" href="' + _global_js_eb._p_link( thread_js_list[x].id, thread_js_list[x].seo ) + '">' + thread_js_list[x].ten + '</a></li>';
				
				//
				i++;
				if ( i > 10 ) {
					break;
				}
			}
		}
		
		// nếu có -> hiển thị luôn
		if ( str != '' ) {
//			console.log(1);
			jQuery('#oiSearchAjax').show().html( '<ul><li><i class="fa fa-lightbulb-o"></i> Sản phẩm</li>' + str + '</ul>' );
			return false;
		}
		
		// nếu người dùng nhấn cách -> tìm luôn
		if ( data_auto_search != 'off' && e.keyCode == 32 ) {
//			console.log(2);
//			ajaxl('guest.php?act=search&key=' + a.replace(/\s/gi, '+'), 'oiSearchAjax', 9);
//		} else {
//			console.log(3);
		}
	});
})();





// cắt xén danh sách sản phẩm để tạo số lượng mong muốn
(function () {
	var len = jQuery('.thread-remove-endbegin').length || 0;
	if ( len == 0 ) {
		return false;
	}
	
	// lấy HTML đầu tiên để tạo cho toàn bộ những cái còn lại, tránh spam nội dung trực tiếp
	var first_html = jQuery('.thread-remove-endbegin:first').html() || '';
//	console.log(first_html);
	
	//
	jQuery('.thread-remove-endbegin').each(function() {
		jQuery(this).html( first_html );
		
		//
		var e = jQuery(this).attr('data-end') || 0,
			between = jQuery(this).attr('data-between') || 0,
			b = jQuery(this).attr('data-begin') || 0;
		
		// end -> xóa đằng sau, lấy đằng trước cho đủ end
		if ( e > 0 ) {
			// Nếu tồn tại tham số lấy đoạn giữa -> xóa đằng trước -> lát xóa đằng sau nữa là ok
			if ( between > 0 ) {
				for ( var i = 0; i < between; i++ ) {
					jQuery('li:first', this).remove();
				}
			}
			
			//
			for ( var i = 0; i < 100; i++ ) {
				jQuery('li:last', this).remove();
				
				if ( jQuery('li', this).length <= e ) {
					break;
				}
			}
		}
		// begin -> xóa đằng trước, lấy đằng sau cho đủ begin
		else if ( b > 0 ) {
			for ( var i = 0; i < 100; i++ ) {
				jQuery('li:first', this).remove();
				
				if ( jQuery('li', this).length <= b ) {
					break;
				}
			}
		}
	});
	
	//
	jQuery('.thread-remove-endbegin li').show();
	
})();
	
	
	
	
	
// module hiển thị quảng cáo ngẫu nhiên
(function () {
	var len = jQuery('.each-to-share-ads').length || 0;
	if ( len == 0 ) {
		return false;
	}
	
	//
	jQuery('.each-to-share-ads').each(function () {
		var len = jQuery('li', this).length;
//		console.log( '---' + len );
		
		if ( len > 0 ) {
			jQuery(this).show();
			
			jQuery('li', this).each(function () {
				var a = jQuery(this).attr('data-img') || '',
					l = jQuery(this).attr('data-lnk') || '';
				if ( a != '' ) {
//					console.log(a);
					if ( l == '' ) {
						l = 'javascript:;';
					}
					jQuery(this).html('<a href="' +l+ '"><img src="' +a+ '" width="' +jQuery(this).width()+ '" /></a>');
				}
			});
			
			// nếu có nhiều quảng cáo -> kiểm tra định dạng quảng cáo
			if ( len > 1 ) {
				var slider = jQuery('ul', this).attr('data-slide') || '';
					lister = jQuery('ul', this).attr('data-list') || '';
				
				// Chạy slide
				if ( slider == 1 ) {
				}
				// hiển thị theo list -> chả phải làm gì cả
				else if ( lister == 1 ) {
				}
				// hiển thị theo kiểu chia sẻ
				else {
					var i = 1,
						min = 0,
						max = len,
						rand = Math.floor(Math.random() * (max - min)) + min;
//					console.log( rand );
					
					//
					jQuery('li', this).hide();
					jQuery('li', this).eq( rand ).show();
				}
			}
		}
	});
	
})();







// với các link # -> tắt chức năng click
jQuery('a[href="#"]').attr({
	href : 'javascript:;'
//}).click(function () {
//	return false;
});

// tạo hiệu ứng select với url trùng với link hiện tại
(function ( u ) {
//	console.log(u);
	
	// tạo class select với thẻ A trùng link đang xem
	jQuery('a[href="' + u + '"]').addClass('current-url-select');
//	console.log(jQuery('a.current-url-select').length);
	
	// nếu URL này không được tìm thấy -> thử theo canonical URL
	if ( jQuery('a.current-url-select').length == 0 ) {
		jQuery('a[href="' + eb_this_current_url + '"]').addClass('current-url-select');
	}
	
	// -> tạo select cho LI chứa nó
	jQuery('li').each(function() {
//		console.log( jQuery('a.current-url-select', this).length );
		if ( jQuery('a.current-url-select', this).length > 0 ) {
			jQuery(this).addClass('selected');
		}
	});
	
})( window.location.href.split('#')[0] );




// load danh sách nhóm dưới dạng JS
function WGR_get_js_sub_category_to_menu ( arr ) {
	if ( arr.length == 0 ) {
		return '';
	}
	// sắp xếp mảng từ to đến bé
	arr.sort( function ( a, b ) {
		return parseFloat(b.order) - parseFloat(a.order);
	} );
//	console.log( arr );
	
	//
//	var str = '<!-- JS for sub-category menu -->';
	var str = '';
	
	str += '<ul class="sub-menu cf">';
	for ( var i = 0; i < arr.length; i++ ) {
		str += '<li style="order:' + arr[i].order + ';"><a href="' + arr[i].lnk + '">' + arr[i].ten + '</a>' + WGR_get_js_sub_category_to_menu( arr[i].arr ) + '</li>';
	}
	str += '</ul>';
	
	return str;
}

function WGR_get_js_category_to_menu ( arr ) {
	if ( arr.length == 0 ) {
		return '';
	}
	// sắp xếp mảng từ to đến bé
	arr.sort( function ( a, b ) {
		return parseFloat(b.order) - parseFloat(a.order);
	} );
//	console.log( arr );
	
	//
	var str = '<!-- JS for category menu -->';
	
	for ( var i = 0; i < arr.length; i++ ) {
		str += '<li class="echbay-category-order"><a href="' + arr[i].lnk + '">' + arr[i].ten + '</a>' + WGR_get_js_sub_category_to_menu( arr[i].arr ) + '</li>';
	}
	
	return str;
}

function WGR_check_load_js_category ( i ) {
	if ( typeof i == 'undefined' ) {
		i = 20;
	}
	else if ( i < 0 ) {
		console.log('Max load eb_site_group or eb_blog_group');
		return false;
	}
	
	if ( typeof eb_site_group == 'undefined' ) {
		setTimeout(function () {
			WGR_check_load_js_category( i - 1 );
		}, 200);
		
		return false;
	}
//	return false;
	
	//
//	console.log( eb_site_group );
	
	// MENU chính -> xóa LI hiện tại, ghi nội dung mới vào
	// catgory
//	if ( eb_site_group.length > 0 && jQuery('.wgr-load-js-category').length > 0 ) {
	if ( jQuery('.wgr-load-js-category').length > 0 ) {
		jQuery('.wgr-load-js-category').after( WGR_get_js_category_to_menu( eb_site_group ) ).remove();
	}
	
	// blog group
//	if ( eb_blog_group.length > 0 && jQuery('.wgr-load-js-blogs').length > 0 ) {
	if ( jQuery('.wgr-load-js-blogs').length > 0 ) {
		jQuery('.wgr-load-js-blogs').after( WGR_get_js_category_to_menu( eb_blog_group ) ).remove();
	}
	
	// SUB-MENU -> bổ sung nội dung vào thẻ LI hiện tại
	// nhớ add thêm class echbay-category-order để order cho phần li
	// sub catgory
//	if ( eb_site_group.length > 0 && jQuery('.wgr-load-js-sub-category').length > 0 ) {
	if ( jQuery('.wgr-load-js-sub-category').length > 0 ) {
		jQuery('.wgr-load-js-sub-category').addClass('echbay-category-order').append( WGR_get_js_sub_category_to_menu( eb_site_group ) );
	}
	
	// sub blog group
//	if ( eb_blog_group.length > 0 && jQuery('.wgr-load-js-sub-blogs').length > 0 ) {
	if ( jQuery('.wgr-load-js-sub-blogs').length > 0 ) {
		jQuery('.wgr-load-js-sub-blogs').addClass('echbay-category-order').append( WGR_get_js_sub_category_to_menu( eb_blog_group ) );
	}
	
}
WGR_check_load_js_category();




//
function WGR_show_or_scroll_to_quick_cart () {
	
	// Nếu có thuộc tính hiển thị quick cart -> cuộn chuột đến đó
	if ( jQuery('.clone-show-quick-cart').length > 0 ) {
//		window.scroll( 0, jQuery('.clone-show-quick-cart').offset().top - 90 );
		jQuery('body,html').animate({
			scrollTop: jQuery('.clone-show-quick-cart').offset().top - 90
		}, 800, function () {
			jQuery('.clone-show-quick-cart input[name="t_dienthoai"]').focus();
		});
		
		return true;
	}
	
	// nếu không -> trả về false để thực thi lệnh tiếp theo
	return false;
	
}

// nút thêm sản phẩm vào giỏ hàng
setTimeout(function () {
	jQuery('.click-jquery-add-to-cart').click(function() {
		/*
		if ( pid == 0 ) {
			return false;
		}
		*/
		
		//
		var product_price = jQuery(this).attr('data-gia') || jQuery(this).attr('data-price') || '',
			product_object = {};
		
		//
		if ( product_price == '' ) {
			product_price = 0;
			
			if ( pid > 0 ) {
				
				// nếu chưa chọn màu hoặc size -> yêu cầu chọn
				// sau sư dụng php để tạo list chọn size, color
				/*
				if ( _global_js_eb.check_size_color_cart() == false ) {
					return false;
				}
				*/
				
				if ( typeof product_js.gm == 'number' && product_js.gm > 0 ) {
					product_price = product_js.gm;
				}
			}
		}
		
		//
		product_object.price = product_price;
		
		_global_js_eb.cart_add_item( jQuery(this).attr('data-id') || pid || 0, product_object );
	});
	
	
	//
	jQuery('.click-jquery-show-quick-cart').click(function() {
		if ( pid == 0 ) {
			return false;
		}
		
		// Hiển thị quick cart dạng popup nếu quick cart không hiển thị sẵn
		if ( WGR_show_or_scroll_to_quick_cart() == false ) {
			// nếu đang xem trong iframe -> mở ra giỏ hàng luôn
			if ( top != self ) {
				parent.window.location = web_link + 'cart/?id=' + pid;
				return false;
			}
			
			// Hiển thị bình thường
			jQuery('#click_show_cpa').show();
			jQuery('body').addClass('body-no-scroll');
			jQuery('#click_show_cpa input[name="t_dienthoai"]').focus();
			
			//
			var a = jQuery(window).height() - jQuery('.cart-quick').height();
			if ( a > 0 ) {
				a = a/ 3;
			} else {
				a = 25;
			}
			jQuery('.cart-quick').css({
				'margin-top' : a + 'px'
			});
		}
	});
	
	
	// Nút kép -> nhảy sang giỏ hàng hoặc mở quick cart
	jQuery('.click-jquery-quickcart-or-cart').click(function(e) {
		// Chuyển sang giỏ hàng nếu không có quick cart
		if ( WGR_show_or_scroll_to_quick_cart() == false ) {
			jQuery('.click-jquery-add-to-cart:first').click();
		}
	});
	
	
	
	//
//	console.log('TEST');
//	jQuery('.click-jquery-show-quick-cart:first').click();
}, 600);




// chuyển các URL video thành dạng list video
(function () {
	jQuery('.echbay-widget-youtube-padding .img-max-width').each(function() {
		var a = jQuery(this).html() || '';
		
		if ( a != '' ) {
			jQuery(this).show();
			
			//
		var str = '',
			wit = jQuery(this).width(),
			hai = wit * youtube_video_default_size;
			
			//
//			console.log(a);
			a = a.split("\n");
//			console.log(a);
			
			for ( var i = 0; i < a.length; i++ ) {
				a[i] = g_func.trim( a[i] );
				
				if ( a[i] != '' ) {
					a[i] = _global_js_eb.youtube_id( a[i] );
				}
				
				if ( a[i] != '' ) {
					if ( cf_tester_mode == 1 ) console.log( 'Widget YouTube video: ' + a[i] );
					
					str += '<div class="widget_echbay_youtube-node"><iframe src="//www.youtube.com/embed/' + a[i] + '" allowfullscreen="" frameborder="0" height="' + hai + '" width="' + wit + '"></iframe></div>';
				}
			}
			
			//
			jQuery(this).html( str );
		}
	});
})();




// chuyển các URL video thành dạng list video
(function () {
	jQuery('.widget_echbay_gg_map .url-to-google-map').each(function() {
		var a = jQuery(this).html() || '',
			str = '',
			wit = 4/ 5;
		
		if ( a != '' ) {
			a = a.split("\n")[0];
			a = g_func.trim( a );
			
			if ( a != '' ) {
				jQuery(this).show();
				
				str += '<div class="widget_echbay_gg_map-node"><iframe src="' + a + '" width="100%" height="' + ( jQuery(this).width() * wit ) + 'px" frameborder="0" style="border:0" allowfullscreen=""></iframe></div>';
				
				jQuery(this).html( str );
			}
		}
	});
})();





//
//console.log(act);

//
if ( act == 'search' ) {
	jQuery('.thread-search-avt[data-img=""]').hide();
}

// google analytics event tracking
setTimeout(function () {
	if ( pid > 0 ) {
		// đối với sản phẩm
		if ( eb_wp_post_type == 'post' ) {
			_global_js_eb.ga_event_track( 'View product', document.title );
		}
		// mặc định là cho blog
		else {
			_global_js_eb.ga_event_track( 'View blog', document.title );
		}
	}
	else if ( act == 'archive' ) {
		if ( switch_taxonomy == 'category'
		|| switch_taxonomy == 'post_tag'
		|| switch_taxonomy == 'post_options' ) {
			if ( cf_tester_mode == 1 ) console.log('test track for fb');
			
			//
			var track_arr = {
				'content_name' : jQuery('h1:first a').html() || jQuery('h1:first').html() || document.title
			};
			
			//
			var ids = '';
			jQuery('.thread-list li').slice(0, 10).each(function() {
				var a = jQuery(this).attr('data-id') || '';
				
				if ( a != '' ) {
					ids += ',' + a;
				}
			});
			if ( ids != '' ) {
				track_arr['content_ids'] = ids.substr(1).split(',');
				
				//
				_global_js_eb.fb_track( 'ViewContent', track_arr );
			}
			else {
				console.log('ids for facebok track not found');
			}
		}
	}
	else if ( act == 'cart' ) {
		_global_js_eb.ga_event_track( 'View cart', 'Xem gio hang' );
	}
	else if ( act == 'hoan-tat' ) {
		_global_js_eb.ga_event_track( 'Booking done', 'Dat hang thanh cong' );
		
		//
//		setTimeout(function () {
			if ( typeof current_hd_id != 'undefined' && current_hd_id != '' ) {
				ajaxl('hoan-tat-mail&id=' + current_hd_id, 'oi_hoan_tat_mail', 1);
			}
//		}, 3000);
	}
}, 3000);



//
function WGR_set_a_target_top () {
	jQuery('a').each(function() {
		var a = jQuery(this).attr('target') || '';
		if ( a == '' ) {
			jQuery(this).attr({
				target: '_top'
			});
		}
	});
}


	// ID của pid -> để tạo giỏ hàng cho chuẩn
var current_pid_quicview = pid,
	set_new_height_for_quick_view = true,
	time_for_new_height_quick_view = 800,
	// lưu title hiện tại của trang
	cache_for_quick_view_title = document.title,
	// lưu lại ID hiện tại của quick view
	cache_for_quick_view_id = 0;

function close_ebe_quick_view () {
	jQuery('#oi_ebe_quick_view').hide();
	jQuery('body').removeClass('body-no-scroll');
	
	window.history.pushState("", '', current_ls_url);
	
	pid = current_pid_quicview;
	
	document.title = cache_for_quick_view_title;
}

function WGR_set_quick_view_height () {
	if ( set_new_height_for_quick_view == false ) {
		return false;
	}
	setTimeout(function () {
		WGR_set_quick_view_height();
	}, time_for_new_height_quick_view);
	
	//
	var h = jQuery( '#ui_ebe_quick_view' ).contents().find( 'body' ).height() || 0;
//	console.log(h);
	if ( h == 0 ) {
		h = 600;
	}
	else {
		h -= -200;
	}
//	console.log(h);
	jQuery('#ui_ebe_quick_view').height( h ).scrollTop(0);
	
	//
//	window.scroll( 0, 0 );
}


//
(function () {
	if ( cf_post_class_style == '' && cf_blog_class_style != '' ) {
		cf_post_class_style = cf_blog_class_style;
	}
	
	//
	if ( top != self ) {
		console.log('quick view not active in iframe');
		
		// chuyển các thẻ A, chưa có target thành target top
		WGR_set_a_target_top();
		setTimeout(function () {
			WGR_set_a_target_top();
			
			//
			setTimeout(function () {
				WGR_set_a_target_top();
			}, 1200);
		}, 600);
		
		//
		return false;
	}
	
	//
	jQuery('.thread-list-wgr-quickview').click(function () {
		var a = jQuery(this).attr('data-id') || '',
			h = jQuery(this).attr('href') || '';
		
		//
		a = g_func.number_only( a );
		
		if ( a == 0 || h == '' ) {
			return false;
		}
		pid = a;
		
		//
		if ( dog('oi_ebe_quick_view') == null ) {
			return false;
		}
		
		//
		jQuery('body').addClass('body-no-scroll');
		jQuery('#oi_ebe_quick_view').show();
		
		// using DIV -> remove
		/*
		if ( jQuery('div#ui_ebe_quick_view').length > 0 ) {
			jQuery('#ui_ebe_quick_view').html('Đang tải...');
		}
		*/
		
		//
		window.history.pushState("", '', h);
		document.title = jQuery(this).attr('title') || cache_for_quick_view_title;
		
		// nếu ID mới này giống với ID cũ -> không load lại
		if ( a == cache_for_quick_view_id ) {
			set_new_height_for_quick_view = true;
			
			//
			setTimeout(function () {
				WGR_set_quick_view_height();
				
				//
				setTimeout(function () {
					set_new_height_for_quick_view = false;
				}, time_for_new_height_quick_view);
			}, time_for_new_height_quick_view);
			
			return false;
		}
		
		// lưu lại phiên của cache
		cache_for_quick_view_id = a;
		
		// sử dụng ajax
//		ajaxl('quick_view&id=' + a, 'ui_ebe_quick_view');
		
		//
		var device = 'desktop';
		if ( jQuery(window).width() < 750 ) {
			device = 'mobile';
		}
		
		// sử dụng iframe
		dog('ui_ebe_quick_view').src = 'about:blank';
		dog('ui_ebe_quick_view').src = web_link + 'eb-ajaxservice?set_module=quick_view&id=' + a + '&view_type=iframe&set_device=' + device;
		
		// chỉnh chiều cao cho iframe
		set_new_height_for_quick_view = true;
		
		jQuery('#ui_ebe_quick_view').height( jQuery(window).height() - 110 );
		
		setTimeout(function () {
			WGR_set_quick_view_height();
		}, time_for_new_height_quick_view);
		
		jQuery('#ui_ebe_quick_view').on('load', function () {
			// sau đó thì không cho set lại chiều cao của quick view nữa
			setTimeout(function () {
				set_new_height_for_quick_view = false;
			}, time_for_new_height_quick_view);
		});
		
		//
		return false;
		
	});
})();



//
if (press_esc_to_quickvideo_close == false) {
	if ( cf_tester_mode == 1 ) console.log('close');
	
	//
	press_esc_to_quickvideo_close = true;
	
	jQuery(document).keydown(function(e) {
//		console.log( e.keyCode );
		
		//
		if (e.keyCode == 27) {
			// trong cùng một cửa sổ
			if ( top == self ) {
				close_img_quick_video_details();
				g_func.opopup();
				close_ebe_quick_view();
			}
			// khác cửa sổ (ví dụ như khi dùng quick view)
			else {
				try {
					if ( cf_tester_mode == 1 ) console.log('Close popup window');
					
					// hàm tự viết
					top.close_img_quick_video_details();
					top.g_func.opopup();
					top.close_ebe_quick_view();
					
					// hoặc hàm mặc định của trình duyệt
					window.close();
					self.close();
				} catch ( e ) {
					console.log( WGR_show_try_catch_err( e ) );
				}
			}
			
		}
	});
}





//
(function () {
	var i = 0,
		fn = 'frm_search',
		fn_rand = '';
	jQuery('.div-search form').each(function() {
		var a = jQuery(this).attr('name') || '';
		
		if ( a == '' ) {
			if ( i > 0 ) {
				fn_rand = i;
			}
			
			jQuery(this).attr({
				name : fn + fn_rand
			});
			
			i++;
		}
	});
})();

// menu for mobile
if ( typeof document.frm_search != 'undefined' ) {
	if ( jQuery('#click_add_to_search').length > 0 ) {
		jQuery('#value_add_to_search').off().keyup(function(e) {
		//	console.log(e.keyCode);
			if (e.keyCode == 13) {
				jQuery('#click_add_to_search').click();
				return false;
			}
	//	}).val( jQuery('input[type="search"]').val() || '' );
//		}).val( document.frm_search.s.value );
		}).val( jQuery('form[name="frm_search"] input[type="search"]').val() || '' );
		
		
		//
		jQuery('#click_add_to_search').off('click').click(function () {
//			document.frm_search.s.value = jQuery('#value_add_to_search').val() || '';
			jQuery('form[name="frm_search"] input[type="search"]').val( jQuery('#value_add_to_search').val() || '' );
			
			//
//			if ( document.frm_search.s.value.length > 2 ) {
			if ( jQuery('form[name="frm_search"] input[type="search"]').val().length > 2 ) {
				document.frm_search.submit();
			}
			else {
				jQuery('#value_add_to_search').focus();
			}
		});
	}
}




//
_global_js_eb._log_click_ref();





// báo lỗi nếu có thẻ dynamic_title_tag chưa được chuyển đổi
if ( jQuery('dynamic_title_tag').length > 0 ) {
	alert('dynamic_title_tag cần được thay đổi sang DIV hoặc H*');
	console.log('================= dynamic_title_tag =================');
}
else if ( jQuery('dynamic_widget_tag').length > 0 ) {
	alert('dynamic_widget_tag cần được thay đổi sang DIV hoặc H*');
	console.log('================= dynamic_widget_tag =================');
}





// TEST
//g_func.opopup('login');
//g_func.opopup('register');



