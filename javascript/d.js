


//
if ( typeof eb_site_group == 'undefined' ) {
	eb_site_group = [];
}
//console.log(eb_site_group);
//console.log(eb_blog_group);

// sắp xếp menu cho cat
(function () {
	for ( var i = 0; i < eb_site_group.length; i++ ) {
		$( '.echbay-category-in-js .cat-item-' + eb_site_group[i].id ).css({
			order : eb_site_group[i].order
		});
	}
})();




// list function /////////////////////////////////////////////////////////////////
/*
* Các function dùng chung cho phần danh sách bài viết sẽ được cho vào đây
* Sau đó các file js riêng của từng theme sẽ kế thừa và sử dụng các chức năng bằng cách gọi function
*/

//
var product_selected_url = '',
	eb_this_current_url = $('link[rel="canonical"]:first').attr('href') || window.location.href.split('?')[0].split('&')[0].split('#')[0];
//console.log(eb_this_current_url);
if ( eb_this_current_url == web_link ) {
	eb_this_current_url = window.location.href.split('#')[0];
}



//
$('.eb-set-menu-selected .sub-menu').addClass('cf');



// Sắp xếp sản phẩm theo ý muốn người dùng
(function () {
	if ( $('#oi_order_by').length == 0 ) {
		return false;
	}
	
	
	//
	var arr = {
		time : 'Sắp xếp theo',
//		time : 'Mới nhất',
//		view : 'Xem nhiều',
		price_down : 'Giá giảm dần',
		price_up : 'Giá Tăng dần',
		az : 'Tên sản phẩm ( từ A đến Z )',
		za : 'Tên sản phẩm ( từ Z đến A )'
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
	$('#oi_order_by select').change(function () {
		var a = $(this).val() || '';
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
	
	var t = s.split('-').pop();
//	console.log( t );
	if ( t.split('.').length == 2 && t.split('.')[0].split('x').length == 2 ) {
		s = s.replace( '-' + t, '.' + t.split('.')[1] );
	}
//	console.log(s);
	
	// bỏ thumb đi
	return s;
}

function ___eb_set_img_to_thumbnail ( sr ) {
	if ( typeof sr == 'undefined' || sr == '' ) {
		return '';
	}
	
	// nếu có tham số này -> site không sử dụng thumb hoặc không có thumb
	if ( typeof eb_disable_auto_get_thumb != 'undefined' && eb_disable_auto_get_thumb == 1 ) {
		console.log('Auto get thumb disable');
	}
	// lấy thumb để làm ảnh slider -> load cho nhanh
	else if ( sr.split('wp-content/uploads/').length > 1 ) {
		// cắt lấy chuỗi cuối cùng của ảnh để kiểm tra xem có phải thumb hay không
//		var is_thumb = sr.split('/').pop().split('-').pop().split('.')[0];
		var is_thumb = sr.split('-').pop();
//		console.log( is_thumb );
		
		//
		if ( is_thumb.split('.').length == 2 ) {
			// có chữ x -> có thể là thumb
			if ( is_thumb.split('.')[0].split('x').length == 2 ) {
				sr = sr.replace( '-' + is_thumb, '-150x150.' + is_thumb.split('.')[1] );
			}
			// nếu không có chữ x -> không phải thumb
			else {
//			if ( is_thumb.split('x').length != 2 ) {
				// -> thêm thumb
				var img_type = sr.split('.').pop();
				
				sr = sr.replace( '.' + img_type, '-150x150.' + img_type );
			}
		}
//		console.log( sr );
	}
	
	return sr;
}



function ___eb_details_slider_v2 () {
	
	// thời gian chuyển slider, nếu có thì phải hợp lệ (kiểu số nguyên, tối thiểu 1 giây)
//	if ( typeof auto_next_details_slider != 'number' || auto_next_details_slider < 1000 ) {
//		auto_next_details_slider = 0;
//	}
	
	var str = '',
		str_thumb = '',
		i = 0,
		sr = '',
		slider_btn = '',
		slider_len = $('#export_img_product img').length,
		html_for_get = '#export_img_product img',
		data_get = 'data-src';
	
	//
//	console.log( slider_len );
	
	// nếu slider chính không có ảnh -> lấy ảnh từ nội dung
	if ( slider_len == 0 ) {
		slider_len = $('#content_img_product img').length;
		html_for_get = '#content_img_product img';
		data_get = 'src';
	}
//	console.log( slider_len );
	
	// -> nếu vẫn không có -> hủy slider
	if ( slider_len < 1 ) {
		$('.hide-if-slider-null').hide();
		return false;
	}
	
	//
	$(html_for_get).each(function() {
		sr = $(this).attr(data_get) || '';
//		console.log( sr );
		
		//
		sr = ___eb_set_img_to_thumbnail( sr );
		
		//
		str += '<li data-node="' +i+ '" data-src="' + sr + '" style="background-image:url(\'' + sr + '\')">&nbsp;</li>';
		
		str_thumb += '<li data-node="' +i+ '" data-src="' + sr + '"><div style="background-image:url(\'' + sr + '\')">&nbsp;</div></li>';
		
		slider_btn += '<li data-node="' +i+ '"><i class="fa fa-circle"></i></li>';
		
		//
		i++;
	});
	
	//
	dog('export_img_product', '<ul class="cf">' + str_thumb + '</ul>');
	
	
	//
	if ( slider_len < 1 ) {
		return false;
	}
//	$('.thread-details-mobileLeft, .thread-details-mobileRight').show();
	
	
	// tạo thumb nếu đủ ảnh
	$('.thread-details-mobileAvt').html('<ul class="cf">' + str + '</ul>').css({
		'background-image' : ''
	});
	
	
	
	
	// tải slider theo code mới
	jEBE_slider( '.thread-details-mobileAvt', {
		sliderArrow: true,
//		buttonListNext: false,
//		autoplay : true,
		thumbnail : 'ul li',
		size : $('.thread-details-mobileAvt').attr('data-size') || ''
	});
	
	return false;
	
	
	
	// Xác định xem có thuộc tính tự động chuyển ảnh không
	var auto_next_details_slider = $('.thread-details-mobileAvt').attr('data-auto-next') || 0;
	
	//
	if ( slider_len > 1 ) {
		$('.product-details-thumb, .thread-details-mobileLeft, .thread-details-mobileRight').removeClass('d-none').show();
		
		// Mặc định thì ẩn đoạn nút này, sau muốn show ra thì dùng style riêng
		$('.pdetail-slider-btn').html( '<ul class="cf">' + slider_btn + '</ul>' );
	}
	
	
	
	//
	var slider_details_width = $('#export_img_product li div').width();
	if ( slider_details_width > 80 ) {
		slider_details_width = 80;
	}
//	console.log( slider_details_width );
	$('.details-thumb-center, .details-thumb-left, .details-thumb-right').css({
		'line-height' : slider_details_width + 'px'
	});
	$('.details-thumb-center').height( slider_details_width + 5 );
	
	
	//
	var num_img_line = 4;
	
	//
//	if (num_img_line > 1 && arr_img_content.length > num_img_line) {
	if (slider_len > num_img_line) {
		$('.details-thumb-left, .details-thumb-right').show();
		
		//
		$('#export_img_product').jCarouselLite({
			btnNext: ".details-thumb-right",
			btnPrev: ".details-thumb-left",
			scroll: num_img_line,
			visible: num_img_line,
			start: 0,
			speed: 700
		});
	}
	
	
	
	//
	$('#export_img_product li').click(function() {
		var a = $(this).attr('data-src') || '',
			i = $(this).attr('data-node') || 0;
		if (a != '') {
			a = ___eb_set_thumb_to_fullsize( a );
			
			// thay background mới
			$('.thread-details-mobileAvt li[data-node="' + i + '"]').css({
				'background-image' : 'url(\'' + a + '\')'
			});
			
			/*
			$('.thread-details-avt').css({
				'background-image': 'url("' + a + '")'
			});
			*/
			$('#export_img_product li, #export_img_product div').removeClass('selected');
			$(this).addClass('selected');
			
			//
			$('.pdetail-slider-btn li').removeClass('selected');
			$('.pdetail-slider-btn li[data-node="' + i + '"]').addClass('selected');
			
			//
//			console.log(i);
			$('.thread-details-mobileAvt').animate({
//				scrollTop : $('.thread-details-mobileAvt').height() * i
				scrollLeft : $('.thread-details-mobileAvt').width() * i
			});
			
			
			
			// tự động chuyển slider
			if ( auto_next_details_slider > 0 ) {
				clearTimeout(time_next_details_slider);
//				console.log(1)
				
				//
				time_next_details_slider = setTimeout(function () {
					$('.thread-details-mobileRight').click();
				}, auto_next_details_slider);
			}
			
			
			//
			$('.thread-details-mobileLeft, .thread-details-mobileRight').css({
				'line-height' : $('.thread-details-mobileAvt').height() + 'px'
			});
		}
	});
	
	
	//
	$('.pdetail-slider-btn li').click(function () {
		var i = $(this).attr('data-node') || 0;
		
		$('#export_img_product li[data-node="' + i + '"]').click();
	});
	
	
	
	//
	$('.thread-details-mobileLeft').click(function () {
		var i = $('#export_img_product li.selected').attr('data-node') || 0;
//		console.log(i);
		i--;
//		console.log(i);
		if ( i < 0 ) {
			i = $('.thread-details-mobileAvt li').length - 1;
		}
//		console.log(i);
		$('#export_img_product li[data-node="' +i+ '"]:first').click();
	});
	
	//
	$('.thread-details-mobileRight').click(function () {
		var i = $('#export_img_product li.selected').attr('data-node') || 0;

//		console.log(i);
		i++;
//		console.log(i);
		if ( i >= $('.thread-details-mobileAvt li').length ) {
			i = 0;
		}
//		console.log(i);
		$('#export_img_product li[data-node="' +i+ '"]:first').click();
	});
	
	
	
	// tự động chuyển slider
	if ( auto_next_details_slider > 0 ) {
		time_next_details_slider = setTimeout(function () {
			$('.thread-details-mobileRight').click();
		}, auto_next_details_slider);
	}
	
	
	//
	$('.thread-details-mobileLeft, .thread-details-mobileRight').css({
		'line-height' : $('.thread-details-mobileAvt').height() + 'px'
	});
	
	
	//
//	$('#export_img_product li:first').click();
//	console.log('first click');
	
	$('.thread-details-mobileAvt li[data-node="0"]').css({
		'background-image' : 'url(\'' + ___eb_set_thumb_to_fullsize ( $('.thread-details-mobileAvt li[data-node="0"]').attr('data-src') || '' ) + '\')'
	});
	
}





// hẹn giờ cho các deal
function ___eb_details_countdown () {
	
	var a = $('.thread-details-countdown').attr('data-timeend') || 0;
	if ( a == 0 || a == '0' ) {
	} else {
		$('.thread-details-countdown').show();
	}
	
}





// tạo style cho phần tóm tắt, từ dạng không html sang có html
function ___eb_details_excerpt_html ( a_before, a_after ) {
	
	var a = $('.thread-details-comment').html() || '',
		str = '';
	
	// Tách lấy từng dòng -> để tạo style cho thống nhất
	if ( a != '' ) {
		a = a.split("\n");
		
		//
		if ( a.length > 1 ) {
			if ( typeof a_before == 'undefined' ) {
				a_before = '';
			}
			
			if ( typeof a_after == 'undefined' ) {
				a_after = '';
			}
			
			for (var i = 0; i < a.length; i++) {
				a[i] = g_func.trim( a[i] );
				
				if ( a[i] != '' ) {
					str += '<li>' + a_before + a[i] + a_after + '</li>';
				}
			}
			
			// In ra dữ liệu mới
			$('.thread-details-comment').show().html( '<ul>' +str+ '</ul>' );
		}
	}
	
}





// tạo số liệu rating ảo
function ___eb_details_product_rating () {
	
	var a = $('.each-to-rating').attr('data-rating') || 0;
//	console.log(a);
	a = a * 10/ 10;
//	console.log(a);
	
	var str = '';
	for ( var i = 0; i < 5; i++ ) {
//		console.log( i );
		
		if ( i < a ) {
			if ( i + .5 == a ) {
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
	$('.each-to-rating').html( str );
	$('.each-to-rating i').click(function () {
		console.log('Thank for rating...');
	});
	
}





// hiệu ứng với các tab nội dung
function ___eb_details_product_tab () {
	
	//
	$('.thread-details-tab li').click(function () {
		$('.thread-details-tab li').removeClass('selected');
		$(this).addClass('selected');
		
		var a = $(this).attr('data-show') || '';
		
		if ( a != '' ) {
			$('.thread-details-contenttab').hide();
			
			$('.' + a).show();
			
			if ( a == 'thread-details-tab-comment' ) {
				$('.hide-if-show-comment').hide();
			} else {
				$('.hide-if-show-comment').show();
			}
		}
		
		//
//		_global_js_eb.auto_margin();
	});
	
	//
//	$(document).ready(function(e) {
		$('.thread-details-tab li:first').click();
//	});
	
	//
	setTimeout(function () {
		// Chiều cao định vị cho tab
		var min_tab_height = 40;
		
//		console.log( $('.thread-details-tab').height() );
		if ( $('.thread-details-tab').height() > min_tab_height ) {
			var j = 30;
			for ( var i = 0; i < 28; i++ ) {
				$('.thread-details-tab li').css({
					padding: '0 ' +j+ 'px'
				});
				
				//
				if ( $('.thread-details-tab').height() < min_tab_height ) {
					break;
				}
				
				//
				j--;
			}
		}
		
		// nếu vẫn chưa được -> màn hình có thể còn nhỏ hơn nữa -> tiếp tục thu font-size
		if ( $('.thread-details-tab').height() > min_tab_height ) {
			var j = 17;
			for ( var i = 0; i < 5; i++ ) {
				$('.thread-details-tab').css({
					'font-size' : j+ 'px'
				});
				
				//
				if ( $('.thread-details-tab').height() < min_tab_height ) {
					break;
				}
				
				//
				j--;
			}
		}
	}, 600);
	
}





// màu sắc sản phẩm
function ___eb_details_product_color () {
	
	if ( $('#export_img_list_color img').length == 0 ) {
		return false;
	}
	
	//
	var str = '',
		i = 0;
	$('#export_img_list_color img').each(function() {
		var s = $(this).attr('data-src') || '';
		
		if ( s != '' ) {
			str += '<li title="' + ( $(this).attr('alt') || $(this).attr('title') || '' ) + '" data-img="' + ___eb_set_thumb_to_fullsize(s) + '" data-node="' + i + '" style="background-image:url(' + ___eb_set_img_to_thumbnail( s ) + ');">&nbsp;</li>';
			
			i++;
		}
	});
	$('.show-if-color-exist').show();
	$('.oi_product_color ul').html( str );
	
	$('.oi_product_color li').click(function () {
		$('.oi_product_color li').removeClass('selected');
		$(this).addClass('selected');
		
		$('.thread-details-mobileAvt li').css({
			'background-image' : 'url(' + ( $(this).attr('data-img') || '' ) + ')'
		});
		
		//
		if ( typeof document.frm_cart != 'undefined' ) {
			$('.eb-global-frm-cart input[name^=t_color]').val( $(this).attr('title') || '' );
		}
	});
	
	
	return true;
	
	
	
	
	//
//	console.log( arr_product_color );
	
	//
	if (arr_product_color.length < 1) {
		return false;
	}
	
	// Có 1 màu -> vẫn hiển thị ảnh của màu đó
	if (arr_product_color.length == 1) {
		var str = '<li style="background-image:url(\'' +( $('.thread-details-avt').attr('data-img') || $('.thread-details-mobileAvt').attr('data-img') || '' )+ '\');"><a href="javascript:;">&nbsp;</a></li>';
		
		//
		$('#oi_product_color').show();
		$('#oi_product_color ul').html(str);
		
		//
		$('#oi_product_color li').addClass('selected');
		return false;
	}
	
	// nhiều màu thì chơi theo kiểu nhiều màu
	var str = '',
		p_link = '';
	
	for (var i = 0; i < arr_product_color.length; i++) {
//		p_link = _global_js_eb._p_link( arr_product_color[i].id, arr_product_color[i].seo );
		p_link = 'javascript:;';
		
		//
		str += '<li data-title="' + product_js['tieude'] + '" data-color="' + arr_product_color[i].colorName + '" data-i="' + arr_product_color[i].id + '" data-img="' + arr_product_color[i].img + '" data-href="' +p_link+ '" style="background-image:url(\'' +arr_product_color[i].img+ '\');"><a title="' + arr_product_color[i].colorName + '" href="javascript:;">&nbsp;</a></li>';
	}
	
	$('#oi_product_color').show();
	$('#oi_product_color ul').html(str);
	
	//
	$('#oi_product_color li').click(function () {
		var new_id = $(this).attr('data-i') || pid,
			new_url = $(this).attr('data-href') || '',
			tit = $(this).attr('data-title') || '',
			color_name = $(this).attr('data-color') || '';
		
		// Nếu vẫn ID cũ thì thôi
		if ( new_id == pid ) {
		}
		
		// Thay đổi ID mua hàng nếu người dùng chọn màu khác
		pid = new_id;
		document.frm_cart.t_muangay.value = new_id;
		
		//
		if ( color_name != '' ) {
			tit += ' - (' +color_name+ ')';
		}
		
		//
		if ( new_url != '' ) {
			window.history.pushState("", document.title, web_link + new_url );
			
			$('.thread-details-title a').attr({
				href : new_url
			}).html( tit );
			
			$('.thread-details-bottom h2').html( tit );
		}
		
		// Đổi hiệu ứng select
		$('#oi_product_color li').removeClass('selected');
		$(this).addClass('selected');
		
		//
		$('.thread-details-avt').css({
			'background-image' : 'url("' +( $(this).attr('data-img') || '' ) + '")'
		});
	});
	
	//
	$('#oi_product_color li[data-i=' +pid+ ']').addClass('selected');
			
	//
	$('.thread-details-avt').css({
		'background-image' : 'url("' +( $('#oi_product_color li[data-i=' +pid+ ']').attr('data-img') || '' ) + '")'
	});
	
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
//			a = $.parseJSON( a );
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
	
}

function ___eb_details_product_size () {
	
	___eb_details_convert_product_size();
	
	
	// có 1 size thì bỏ qua, mặc định rồi
	if ( arr_product_size.length <= 1 || $('.oi_product_size').length == 0 ) {
		return false;
	}
	
	// có nhiều size thì tạo list
	var str = '';
	
	for (var i = 0; i < arr_product_size.length; i++) {
		str += '<li data-size-node="' + i + '" data-name="' + arr_product_size[i].name + '" data-quan="' + arr_product_size[i].val + '"><div>' + arr_product_size[i].name + '</div></li>'
	}
	
	$('.oi_product_size, .show-if-size-exist').show();
	$('.oi_product_size ul').html(str);
	
	$('.oi_product_size li').off('click').click(function() {
		var size_node = $(this).attr('data-size-node') || '';
		
		if ( size_node == '' ) {
			return false;
		}
//		console.log(size_node);
		
		$('.oi_product_size li.selected').removeClass('selected');
//		$(this).addClass('selected');
		$('.oi_product_size li[data-size-node="' +size_node+ '"]').addClass('selected');
		
		var curent_soluong = $(this).attr('data-quan') || 0;
		curent_soluong = 0 - curent_soluong;
		curent_soluong = 0 - curent_soluong;
		
		var str_alert = '';
		if ( curent_soluong > 0 ) {
			if ( curent_soluong < 5 ) {
				str_alert = '<span class="bluecolor">C\u00f2n ' + curent_soluong + ' s\u1ea3n ph\u1ea9m</span>';
			} else {
				str_alert = '<span class="greencolor">S\u1eb5n h\u00e0ng</span>'
			}
		} else {
			str_alert = '<span class="redcolor">H\u1ebft h\u00e0ng</span>';
			$('.show-if-user-size').show()
		}
		$('.oi_product_size .product-size-soluong > span').html(str_alert);
//		$('.oi_product_size .product-size-soluong').show();
		
		if ( typeof document.frm_cart != 'undefined' ) {
//			$('#click_show_cpa input[name^="t_size"]').val( $(this).attr('data-name') || '' );
//			$('#click_show_cpa input[name="t_size[]"]').val( $(this).attr('data-name') || '' );
			$('.eb-global-frm-cart input[name^=t_size]').val( $(this).attr('data-name') || '' );
//			document.frm_cart.t_size.value = $(this).attr('data-id') || '';
		}
	});
	
	//
//	$('.oi_product_size li:first').click();
	$('.oi_product_size:first li[data-size-node="0"]').click();
	
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
	
	$('#oi_change_soluong select').change(function () {
		var a = $(this).val() || 0;
		
		$('#oi_change_tongtien').html( g_func.money_format( a * product_js['gm'] ) + 'đ' );
	});
	$('#oi_change_soluong select').change();
	
}


// tạo html cho khung đếm số phiếu mua hàng
function ___eb_details_product_quan () {
	
	//
	if ( $('#oi_mua_max').length == 0 ) {
		return false;
	}
	
	//
	var a = $('#oi_mua_max').attr('data-min') || '',
		b = $('#oi_mua_max').attr('data-max') || '';
	if ( a != '' && b != '' ) {
		$('#oi_mua_max').width( ( a * 100 / b ) + '%' );
		$('#oi_con_phieu').html( b - a );
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
	
	// tải slider theo code mới
	jEBE_slider( '#oi_big_banner', {
		autoplay : true,
//		thumbnail : '.banner-ads-media',
		size : $('#oi_big_banner li:first .ti-le-global').attr('data-size') || ''
	});
	
	
	return false;
	
	
	// slider
	var slider_len = $('#oi_big_banner li').length || 0;
	
	// không có slider -> thoát
	if ( slider_len < 1 ) {
//		if ( slider_len == 0 ) {
			$('#oi_big_banner').hide();
//		}
		return false;
	}
	
	//
//	if ( act == '' ) {
//		$('.global-nav').addClass('global-nav-selected');
//	}
	
	// không đủ slider -> thoát
	if ( slider_len < 2 ) {
		var wit = $(window).width(),
			img = $('#oi_big_banner div.banner-ads-media').attr('data-img') || '';
		
		// mobile
		/*
		if ( wit < 250 ) {
			img = $('#oi_big_banner div.banner-ads-media').attr('data-mobile-img') || img || '';
		}
		// table
		else */ if ( wit < 768 ) {
			img = $('#oi_big_banner div.banner-ads-media').attr('data-table-img') || img || '';
		}
		
		$('#oi_big_banner div.banner-ads-media').css({
			'background-image': 'url(\'' + img + '\')'
		});
		
		return false;
		
		
		
		
		// table
		if ( $(window).width() > 250 ) {
			var img = $('#oi_big_banner div.banner-ads-media').attr('data-img') || '';
			
			if ( img == 'speed' ) {
				// chuyển ảnh to nếu là bản pc
				if ( $(window).width() > 768 ) {
				}
				// table
				else {
				}
				var img_table = $('#oi_big_banner div.banner-ads-media').attr('data-table-img') || '',
					img_mobile = $('#oi_big_banner div.banner-ads-media').attr('data-mobile-img') || img_table || '';
				$('#oi_big_banner div.banner-ads-media').addClass(img_mobile);
			}
			else if (img != '') {
				$('#oi_big_banner div.banner-ads-media').css({
					'background-image': 'url(\'' + img + '\')'
				});
			}
		}
		
		return false;
	}
	
	//
	var change_banner_first_home = function(x) {
		if (typeof x == 'undefined' || x >= $('#oi_big_banner li').length) {
			x = 0;
		}
		
		//
//		$('#oi_big_banner ul').animate({
		$('#oi_big_banner ul').css({
//			top: 0 - $('#oi_big_banner').height() * x + 10
//			top: 0 - $('#oi_big_banner li:first').height() * x
			top: ( 0 - 100 * x ) + '%'
		}, 'slow');
//		console.log( $('#oi_big_banner li:first').height() );
		
		//
		$('.big-banner-button li').removeClass('selected');
		$('.big-banner-button li[data-i="' + x + '"]').addClass('selected');
		
		
		
		
		// chuyển ảnh từ ảnh mờ sang ảnh nét
		var img = $('#oi_big_banner ul li[data-i="' + x + '"] div.banner-ads-media').attr('data-img') || '',
			img_table = $('#oi_big_banner ul li[data-i="' + x + '"] div.banner-ads-media').attr('data-table-img') || img || '',
			img_mobile = $('#oi_big_banner ul li[data-i="' + x + '"] div.banner-ads-media').attr('data-mobile-img') || img_table || '';
		
		//
		/*
		if ( img == 'speed' ) {
			// mặc định đang sử dụng ảnh cho bản mobile -> nếu là PC -> chuyển sang ảnh cho PC
			if ( $(window).width() > 768 ) {
//				console.log(img_mobile);
				$('#oi_big_banner ul li[data-i="' + x + '"] div.banner-ads-media').addClass(img_mobile);
			}
		}
		else */ if (img != '') {
			// sử dụng ảnh cho bản mobile
			/*
			if ( $(window).width() < 250 && img_mobile != '' ) {
				img = img_mobile;
			}
			else */ if ( $(window).width() < 768 && img_table != '' ) {
				img = img_table;
			}
			
			//
			$('#oi_big_banner ul li[data-i="' + x + '"] div.banner-ads-media').css({
				'background-image': 'url(\'' + img + '\')'
			}).attr({
				'data-img' : '',
				'data-table-img' : '',
				'data-mobile-img' : ''
			});
		}
		
		//
		clearTimeout(big_banner_timeout1);
		big_banner_timeout1 = setTimeout(function() {
			change_banner_first_home(x + 1);
		}, 5 * 1000);
	};
	
	//
	var i = 0,
		str_btn = '';
	
	//
	$('#oi_big_banner li').each(function() {
		$(this).attr({
			'data-i' : i
		});
		
		//
		str_btn += '<li title="' + ( $(this).attr('title') || '' ) + '" data-i="' +i+ '"><i class="fa fa-circle"></i></li>';
		
		//
		i++;
	});
	
	//
	$('#oi_big_banner').after('<div class="big-banner-button"><ul>' + str_btn + '</ul></div>');
	
	//
	$('.big-banner-button li').click(function () {
		change_banner_first_home( $(this).attr('data-i') || 0 );
	});
	
	//
	setTimeout(function () {
		change_banner_first_home();
	}, 800);
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
	$('.sponsor-top-desktop').each(function() {
		if ( $('li', this ).length == 0 ) {
			$(this).hide().remove();
		}
	});
	
	//
	var len = $('.banner-chan-trang:first li').length || 0;
	/*
	if ( len == 0 ) {
		$('.sponsor-top-desktop, .hide-if-footer-banner-null').hide();
		return false;
	}
	*/
	
	// số thẻ LI mặc định được hiển thị/ 1000px
	var so_the_li_mong_muon = $('.banner-chan-trang:first').attr('data-num') || 5;
//	console.log( so_the_li_mong_muon );
	/*
	if ( typeof so_the_li_mong_muon != 'number' ) {
		so_the_li_mong_muon = 5;
	}
	*/
	// -> chiểu rộng trung bình của mỗi LI
	so_the_li_mong_muon = 999/ so_the_li_mong_muon - 1;
//	console.log( so_the_li_mong_muon );
//	console.log( $('.banner-chan-trang:first').width() );
	
	// tính toán số thẻ LI được hiển thị
	var global_chantrang_len = $('.banner-chan-trang:first').width()/ so_the_li_mong_muon;
	global_chantrang_len = Math.ceil( global_chantrang_len ) - 1;
//	console.log( global_chantrang_len );
	
	// nếu nhiều hơn so với số LI thật -> gán lại giá trị mới
	if ( global_chantrang_len > len ) {
		global_chantrang_len = len;
	}
//	console.log( global_chantrang_len );
	
	//
	$('.banner-chan-trang:first li').width( ( 100/ global_chantrang_len ) + '%' );
	_global_js_eb.auto_margin();
	
	// không đủ thì thôi, ẩn nút next
	if ( len <= global_chantrang_len ) {
		$('.home-next-chantrang, .home-prev-chantrang').hide();
		
		$('.banner-chan-trang:first').height('auto').css({
			'line-height' : $('.banner-chan-trang:first').height() + 'px'
		});
		
		return false;
	}
	
	// đủ thì hiển thị và tạo hiệu ứng
	var li_fo_scroll = $('.banner-chan-trang:first').attr('data-scroll') || global_chantrang_len;
	/*
	if ( typeof li_fo_scroll != 'number' ) {
		li_fo_scroll = global_chantrang_len;
	}
	*/
	
	$('.banner-chan-trang:first').height('auto').jCarouselLite({
		btnNext: ".home-next-chantrang",
		btnPrev: ".home-prev-chantrang",
		scroll: li_fo_scroll,
		visible: global_chantrang_len,
		start: 0,
		speed: 700
	});
})();

function ___eb_logo_doitac_chantrang ( so_the_li_mong_muon, li_fo_scroll ) {
	console.log('WARNING! Function ___eb_logo_doitac_chantrang bas been remove, please clear in your code!');
}



// tạo hiệu ứng với phần danh sách sản phẩm
function ___eb_thread_list_li () {
	$('.thread-list li').each(function() {
		var ngay = $(this).attr('data-ngay') || 0,
	//		giacu = $(this).attr('data-gia') || '',
	//		giamoi = $(this).attr('data-giamoi') || '',
	//		a = $(this).attr('data-giovang') || '',
	//		b = $(this).attr('data-soluong') || 0,
	//		gia = $(this).attr('data-gia') || 0,
			per = $(this).attr('data-per') || 0;
		
	//	gia = parseInt(gia, 10);
		
		/*
		b = parseInt(b, 10);
		if (b <= 0 || isNaN(b)) {
			$('.thread-list-chayhang', this).css({
				'background-image': 'url(images/bg-sold-out.png)'
			})
		}
		*/
		
		//
		if (per > 0) {
//			$(this).addClass('thread-list-giamgiashow');
			
			//
			if (ngay > date_time) {
				$(this).addClass('thread-list-giovangshow');
			}
		}
	});
	
	
	//
//	$('.hide-if-gia-zero[data-per="0"]').addClass('aaaaaaaaa');
}


// thêm dòng phân cách cho thẻ breadcrumb
function ___eb_add_space_for_breadcrumb ( con ) {
	console.log('___eb_add_space_for_breadcrumb has been remove');
	
	/*
	if ( typeof con == 'undefined' ) {
		con = '/';
	}
	
	$('.thread-details-tohome li').before('<li>' + con + '</li>');
	$('.thread-details-tohome li:first').remove();
	*/
}


// hiệu ứng xem video tại chỗ
var press_esc_to_quickvideo_close = false,
	current_ls_url = window.location.href;

function close_img_quick_video_details () {
	console.log('close');
	
	// ẩn video
	$('.quick-video').hide().height('auto');
	
	// xóa nội dung -> tránh video vẫn đang bật
	dog( 'quick-video-content', '&nbsp;' );
	
	//
	$('#click_show_cpa').hide();
	
	//
	$('body').removeClass('body-no-scroll');
	
	window.history.pushState("", '', current_ls_url);
	
}

function ___eb_click_open_video_popup () {
	$('.click-quick-view-video').click(function () {
//		alert(1);
		var a = $(this).attr('data-video') || '',
			tit = $(this).attr('title') || '',
			lnk = $(this).attr('href') || '',
			// nhóm các video liên quan theo module
			module = $(this).attr('data-module') || '',
			str = '',
			arr_list_video = {};
		
		//
		if ( a != '' ) {
			
			//
			$('.quick-video').show().height( $(document).height() );
//			$('body').addClass('body-scroll-disable');
			
			//
			var hai = $('#quick-video-content').width();
			if ( hai > 600 ) {
				hai = 400;
			} else {
				hai = hai / 3 * 2;
			}
			
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
				<div class="quick-video-width">\
					<div class="quick-video-title bold">' +tit+ '</div>\
					<iframe width="100%" height="' +hai+ '" src="//www.youtube.com/embed/' +a+ '?autoplay=1" frameborder="0" allowfullscreen></iframe>\
				</div>\
			</div>';
			
			
			
			// Tạo list video -> Lấy các video khác trên cùng trang
			var get_other_video = '.click-quick-view-video';
			if ( module != '' ) {
				get_other_video = '.click-quick-view-video[data-module="' +module+ '"]';
			}
			
			//
			$(get_other_video).each(function () {
				var a2 = $(this).attr('data-video') || '',
					tit2 = $(this).attr('title') || '';
				
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
					<div class="quick-video-width">\
						<div class="quick-video-title bold">' +arr_list_video[x]+ '</div>\
						<iframe width="100%" height="' +hai+ '" src="//www.youtube.com/embed/' +x+ '" frameborder="0" allowfullscreen></iframe>\
					</div>\
				</div>';
				
			}
			
			
			//
			var new_scroll_top = window.scrollY || $(window).scrollTop();
			
			//
			$('#quick-video-content').css({
				'padding-top' : new_scroll_top + 'px'
			});
			
			//
			dog( 'quick-video-content', str );
//			dog( 'quick-video-content', str + str + str + str + str + str + str );
			
			
			// chỉnh lại chiều cao dữ liệu một lần nữa
			$('.quick-video').show().height( $(document).height() );
			
			
			//
			return false;
		}
	});
//	$('.click-quick-view-video:first').click();
	
	
	//
	$('.quick-video-close i.fa-remove').click(function () {
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
	privary_main_height = $( id_for_fix_main_content ).height() || 0,
	right_main_height = $( id_for_fix_menu_content ).height() || 0,
	fix_right_window_height = $(window).height(),
	fix_details_right_menu = false;

//
function ___eb_func_fix_right_menu () {
	
	// chiều cao của menu phải
//	var a = $('.fix-right-menu').height();
	fix_right_window_height = $(window).height();
	
	// chiều cao của main -> lớn hơn right thì mới dùng chức năng này
	privary_main_height = $( id_for_fix_main_content ).height() || 0;
//	console.log( 'main: ' + privary_main_height );
	
	// điểm bắt đầu fix menu
	right_main_height = $( id_for_fix_menu_content ).offset().top || 0;
	right_main_height += $('.fix-right-menu').height();
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
	end_right_top_menu = $('#fix_end_right_menu').offset().top - fix_right_window_height;
//	console.log( 'end right: ' + end_right_top_menu );
	
	// fix style cho menu bên này, tránh bị vỡ khung
	$('.fix-right-menu').width( $('#fix_right_menu').width() ).css({
		left : $('#fix_right_menu').offset().left + 'px'
	});
	
	//
	$(window).scroll();
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
	$(window).resize(function () {
		___eb_func_fix_right_menu();
//	}).load(function() {
//		___eb_func_fix_right_menu();
	}).scroll(function() {
//		console.log( fix_right_left_menu );
//		console.log( fix_right_top_menu );
//		console.log( end_right_top_menu );
		
		//
		var a = window.scrollY || $(window).scrollTop();
//		console.log( end_right_top_menu );
		
		if ( fix_details_right_menu == true ) {
			if ( a > right_main_height ) {
				// fixed
				if ( a < end_right_top_menu ) {
					$('body').removeClass('abs-right-menu').addClass('fixed-right-menu');
				}
				// absolute
				else {
					$('body').removeClass('fixed-right-menu').addClass('abs-right-menu');
				}
			} else {
				$('body').removeClass('fixed-right-menu').removeClass('abs-right-menu');
			}
		}
	});
}


function ___eb_show_cart_count () {
	var c = 'eb_cookie_cart_list_id',
		cart_id_in_cookie = g_func.getc( c );
//	console.log( cart_id_in_cookie );
	if ( cart_id_in_cookie != null ) {
		if ( cart_id_in_cookie.substr(0, 1) == ',' ) {
			cart_id_in_cookie = cart_id_in_cookie.substr(1);
		}
		
		$('.show_count_cart').html( cart_id_in_cookie.split(',').length );
	}
}
___eb_show_cart_count();




// function cho từng action
function ___eb_global_home_runing ( r ) {
	
	// nếu tham số truyền vào không phải function -> hủy
	if ( typeof r != 'function' ) {
		console.log('only run with function type');
		return false;
	}
	
	// chạy function riêng
	r();
	
}


function ___eb_list_post_run ( r ) {
	
	// nếu tham số truyền vào không phải function -> hủy
	if ( typeof r != 'function' ) {
		console.log('only run with function type');
		return false;
	}
	
	// chạy function riêng
	r();
	
}





//
function ___eb_details_post_run ( r ) {
	
	// nếu tham số truyền vào không phải function -> hủy
	if ( typeof r != 'function' ) {
		console.log('only run with function type');
		return false;
	}
	
	// với bản pc -> chỉnh lại kích thước ảnh thành fullsize (mặc định trước đó trong admind dể mobile hết)
	/*
	if ( $(window).width() > 768 ) {
		$('#content_img_product img, .max-width-img-content img, .echbay-tintuc-noidung img').removeAttr('sizes');
		console.log('Set img fullsize for mobile');
	}
	*/
	
	// chạy function riêng
	r();
	
	
	/*
	* và function chung mà phần lớn theme đều cần đến
	*/
	
	// slider cho trang chi tiết
	___eb_details_slider_v2();
	
	
	// tạo bộ đếm lượt mua
	___eb_details_product_quan();
	
	
	// mặc định form quick cart nằm cuối trang
//	$('form[name^=frm_cart]').addClass('eb-global-frm-cart');
	
	// -> một số theme nào cần hiển thị thì tạo kiểm tra class và đưa lên
	if ( $('.clone-show-quick-cart').length > 0 ) {
		$('.clone-show-quick-cart').html( $('#click_show_cpa .cart-quick-padding').html() );
		$('#click_show_cpa').remove();
		
//		$('.clone-show-quick-cart input[name^="t_muangay"]').val( pid );
//		$('.clone-show-quick-cart input[name="t_muangay[]"]').val( pid );
	}
	// nạp ID cho phần quick cart
//	else {
		// nạp ID cho phần quick cart
//		$('#click_show_cpa input[name^="t_muangay"]').val( pid );
//		$('#click_show_cpa input[name="t_muangay[]"]').val( pid );
//	}
	$('.eb-global-frm-cart input[name^=t_muangay]').val( pid );
	
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
		'content_name' : product_js['tieude']
	};
	if ( typeof product_js['gm'] == 'number' && product_js['gm'] > 0 ) {
		track_arr['value'] = product_js['gm'];
		track_arr['currency'] = 'VND';
	}
	_global_js_eb.fb_track( 'ViewContent', track_arr );
	
	
	
	
	//
	/*
	var arr_attr_img_content = [],
		i = 0;
	$('.thread-details-tab-content img').each(function(index, element) {
		var arr = {};
		
		$(this).each(function() {
			$.each(this.attributes, function() {
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
	
}






function ___eb_global_blogs_runing ( r ) {
	
	// nếu tham số truyền vào không phải function -> hủy
	if ( typeof r != 'function' ) {
		console.log('only run with function type');
		return false;
	}
	
	// chạy function riêng
	r();
	
}


function ___eb_global_blog_details_runing ( r ) {
	
	// nếu tham số truyền vào không phải function -> hủy
	if ( typeof r != 'function' ) {
		console.log('only run with function type');
		return false;
	}
	
	// chạy function riêng
	r();
	
}

// end global function /////////////////////////////////////////////////////////////////







// hiển thị bộ thẻ tag nếu có
if ( $('.thread-details-tags a').length > 0 ) {
	$('.thread-details-tags').show();
}
//console.log( $('.thread-details-tags a').length );




// Kiểm tra người dùng đã đăng nhập chưa
if ( isLogin > 0 && logout_url != '' ) {
	$('.oi_member_func').html( '<a href="profile/" class="bold">Tài khoản</a> <a onclick="return confirm(\'Xác nhận đăng xuất khỏi hệ thống\');" href="' +logout_url+ '">Thoát</a>' );
} else {
	$('.oi_member_func').html( '<a href="javascript:;" onclick="g_func.opopup(\'login\');">Đăng nhập</a> <a onclick="g_func.opopup(\'register\');" href="javascript:;">Đăng ký</a>' );
}
//$('.oi_member_func').addClass('fa fa-user');

//
function ___eb_custom_login_done () {
	window.location = window.location.href;
}





// tạo menu cho bản mobile ( nếu chưa có )
if ( $('#nav_mobile_top li').length == 0 ) {
	$('#nav_mobile_top').html( '<ul>' + ( $('.nav-menu ul').html() || $('.global-nav ul').html() || '' ) + '</ul>' );
}
$('#nav_mobile_top li').removeAttr('id');

$('#nav_mobile_top li li a').each(function() {
	$(this).html( '<i class="fa fa-angle-right"></i> ' + $(this).html() );
});


//
$('#click_show_mobile_bars').click(function () {
	var a = $(this).attr('data-show') || '';
	
	// đang hiển thị
	if ( a == 1 ) {
		a = 0;
		
		$('.menu-mobile-nav').hide();
		
		$('body').css({
			overflow : 'auto'
		});
	}
	// đang ẩn
	else {
		// trỏ vào khung tìm kiếm luôn
		$('#value_add_to_search').focus();
		
		//
		a = 1;
		
		$('.menu-mobile-nav').show().height( $(window).height() );
		
		$('body').css({
			overflow : 'hidden'
		});
	}
	
	$(this).attr({
		'data-show' : a
	});
	
	$('#click_show_mobile_bars i').toggleClass('fa-bars').toggleClass('fa-remove');
	
	//
	/*
	if ( $('.menu-mobile-nav').height() > $(window).height() ) {
		$('.menu-mobile-nav').height( $(window).height() - 50 );
		
		$('body').css({
			overflow : 'hidden'
		});
	} else {
		$('.menu-mobile-nav').height( '' );
		
		$('body').css({
			overflow : ''
		});
	}
	*/
});
//$('#click_show_mobile_bars').click();




//
$('#click_show_search_bars').click(function () {
	$('#click_show_mobile_bars').click();
//	$('body').toggleClass('show-search-mobile');
});
//$('#click_show_search_bars').click();





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
	|| (!!document.documentMode == true)) {
		r = 'IE';
	}
	
	return r.toLowerCase();
})( navigator.userAgent );
//alert( arr_detect_browser );

//
/*
$('.phone-numbers-block').attr({
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
	$('.phone-numbers-inline').each(function() {
		var a = $(this).html() || '';
		
		a = a.replace(/<br\s*[\/]?>/gi, "\n").replace(/\r\n|\r|\n/g, " - ");
		
		$(this).html(a);
	});
} else {
	*/
	$('.phone-numbers-inline, .phone-numbers-block').each(function() {
		
		if ( $('a', this).length > 0 ) {
			return false;
		}
		
		//	
		var a = $(this).html() || '',
			block = $(this).attr('data-block') || '';
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
					str += '<a title="' + a[i] + '" class="phone-to-cell">' + a[i] + '</a>';
				}
			}
			
			$(this).html(str);
		}
		
	});
	
	//
//	$('.phone-numbers-block a').addClass('d-block');
//}

//
$('.phone-numbers-inline a, .phone-numbers-block a').addClass('gg-phone-conversion');


//
$('a.phone-to-cell').each(function() {
	var a = $(this).attr('title') || $(this).html() || '';
	a = a.toString().replace(/[^0-9|\+]/g, '');
//	if (a != '') {
	if (a.length >= 8) {
		$(this).attr({
			href: str_for_click_call + ':' + a,
//			target: "_blank",
			rel: "nofollow"
		}).removeAttr('title');
	}
}).removeClass('phone-to-cell').addClass('gg-phone-conversion');

// track for phone or add to cart
$('a.gg-phone-conversion').click(function () {
	var a = $(this).attr('href') || '';
	
	// nếu có chức năng kiểm tra lượt bấm gọi của gg -> nạp vào
	_global_js_eb.gg_track( a );
	
	_global_js_eb.ga_event_track( 'Click to phone', a );
	
	
	// khi người dùng nhấp gọi điện
	_global_js_eb.fb_track( 'Call' );
	
	
	//
//	return false;
});








//
$('#oi_scroll_top, .oi_scroll_top').click(function() {
	$('body,html').animate({
		scrollTop: 0
	}, 800);
});






//_global_js_eb.ebBgLazzyLoadOffset();
_global_js_eb.ebBgLazzyLoad();
_global_js_eb.auto_margin();
setTimeout(function () {
	_global_js_eb.auto_margin();
}, 2000);



$(window).resize(function() {
	/*
	if ($(window).width() > 1240) {
		$('#qc_2ben_left, #qc_2ben_right').show();
	} else {
		$('#qc_2ben_left, #qc_2ben_right').hide();
	}
	*/
	
	_global_js_eb.auto_margin();
}).load(function() {
	/*
	if (pid <= 0 && qc_2ben.length > 0 && $(window).width() > 1100) {
		load_ads_2ben = true;
	}
	*/
	
//	_global_js_eb.auto_margin();
	
	
	/*
	var a = $('.thread-details-content').width();
	
	$('.thread-details-content img').each(function() {
		var w = $(this).attr('width') || a;
		
		$(this).css({
			'width' : 'auto',
			'height' : 'auto',
			'max-width' : w + 'px'
		});
	}).removeAttr('width').removeAttr('height');
	*/
}).scroll(function() {
	var new_scroll_top = window.scrollY || $(window).scrollTop();
	
	if (new_scroll_top > 120) {
		$('body').addClass('ebfixed-top-menu');
	} else {
		$('body').removeClass('ebfixed-top-menu');
	}
	
	if (new_scroll_top > 500) {
//		$('#oi_scroll_top').show();
		
		_global_js_eb.ebBgLazzyLoad(new_scroll_top);
		/*
	} else {
		$('#oi_scroll_top').hide();
		*/
	}
});



//
/*
setTimeout(function () {
	_global_js_eb.user_loc();
}, 5000);
*/




/*
$('.click-show-top-top-bars').click(function () {
	$('.top-top-position').toggleClass('top-top-2position');
	
	$('.click-show-top-top-bars i').toggleClass('fa-bars').toggleClass('fa-remove');
});
*/




/*
$('.click-show-div-content').click(function () {
	var a = $(this).attr('data-show') || '';
	
	//
	$(a).toggle();
	
	//
	return false;
});
*/




// show content like the_content() -> wp nó tự bỏ thẻ P trong nội dung -> dùng cái này để tạo lại
(function () {
	$('.each-to-fix-ptags').each(function() {
		var a = $(this).html() || '',
			tag = $(this).attr('data-tag') || 'div';
		
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
			$(this).html( str );
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
			
			$(this).html( a );
			
			// test
//			console.log( '<div>' + a.replace( /\r\n|\n|\r/gi, '</div><div>' ).replace( /\<div\>\<\/div\>/gi, '' ) + '</div>' );
		}
	});
})();






// tính số ngày hết hạn của sản phẩm
var threadDetailsTimeend = null;
function ___eb_thread_details_timeend () {
	threadDetailsTimeend = setInterval(function () {
		if ( $('.thread-details-timeend').length == 0 ) {
			clearInterval(threadDetailsTimeend);
			return false;
		}
		
		//
		$('.thread-details-timeend').each(function() {
			var te = $(this).attr('data-timeend') || '';
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
					$(this).attr({
						'data-timeend' : te - 1
					}).html( '\
					<li><div><span>' +ngay+ '<em>Ngày</em></span></div></li>\
					<li><div><span>' +gio+ '<em>Giờ</em></span></div></li>\
					<li><div><span>' +phut+ '<em>Phút</em></span></div></li>\
					<li><div><span>' +giay+ '<em>Giây</em></span></div></li>' ).show();
				} else {
					$(this).removeClass('thread-details-timeend');
				}
			} else {
				$(this).removeClass('thread-details-timeend');
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
	var data_auto_search = $('#search_keys').attr('data-auto-search') || '';
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
	
	$('#search_keys').attr({
		 autocomplete : "off"
	}).focus(function () {
		$('#oiSearchAjax').fadeIn();
	}).blur(function () {
		setTimeout(function () {
			$('#oiSearchAjax').hide()
		}, 200);
	}).keyup(function (e) {
		var a = $(this).val(),
			b = g_func.non_mark_seo( a );
		
		//
		if ( b.length < 3 ) {
			$('#oiSearchAjax').hide();
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
			$('#oiSearchAjax').show().html( '<ul><li><i class="fa fa-lightbulb-o"></i> Sản phẩm</li>' + str + '</ul>' );
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
	var len = $('.thread-remove-endbegin').length || 0;
	if ( len == 0 ) {
		return false;
	}
	
	// lấy HTML đầu tiên để tạo cho toàn bộ những cái còn lại, tránh spam nội dung trực tiếp
	var first_html = $('.thread-remove-endbegin:first').html() || '';
//	console.log(first_html);
	
	//
	$('.thread-remove-endbegin').each(function() {
		$(this).html( first_html );
		
		//
		var e = $(this).attr('data-end') || 0,
			between = $(this).attr('data-between') || 0,
			b = $(this).attr('data-begin') || 0;
		
		// end -> xóa đằng sau, lấy đằng trước cho đủ end
		if ( e > 0 ) {
			// Nếu tồn tại tham số lấy đoạn giữa -> xóa đằng trước -> lát xóa đằng sau nữa là ok
			if ( between > 0 ) {
				for ( var i = 0; i < between; i++ ) {
					$('li:first', this).remove();
				}
			}
			
			//
			for ( var i = 0; i < 100; i++ ) {
				$('li:last', this).remove();
				
				if ( $('li', this).length <= e ) {
					break;
				}
			}
		}
		// begin -> xóa đằng trước, lấy đằng sau cho đủ begin
		else if ( b > 0 ) {
			for ( var i = 0; i < 100; i++ ) {
				$('li:first', this).remove();
				
				if ( $('li', this).length <= b ) {
					break;
				}
			}
		}
	});
	
	//
	$('.thread-remove-endbegin li').show();
	
})();
	
	
	
	
	
// module hiển thị quảng cáo ngẫu nhiên
(function () {
	var len = $('.each-to-share-ads').length || 0;
	if ( len == 0 ) {
		return false;
	}
	
	//
	$('.each-to-share-ads').each(function () {
		var len = $('li', this).length;
//		console.log( '---' + len );
		
		if ( len > 0 ) {
			$(this).show();
			
			$('li', this).each(function () {
				var a = $(this).attr('data-img') || '',
					l = $(this).attr('data-lnk') || '';
				if ( a != '' ) {
//					console.log(a);
					if ( l == '' ) {
						l = 'javascript:;';
					}
					$(this).html('<a href="' +l+ '"><img src="' +a+ '" width="' +$(this).width()+ '" /></a>');
				}
			});
			
			// nếu có nhiều quảng cáo -> kiểm tra định dạng quảng cáo
			if ( len > 1 ) {
				var slider = $('ul', this).attr('data-slide') || '';
					lister = $('ul', this).attr('data-list') || '';
				
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
					$('li', this).hide();
					$('li', this).eq( rand ).show();
				}
			}
		}
	});
	
})();







// với các link # -> tắt chức năng click
$('a[href="#"]').attr({
	href : 'javascript:;'
//}).click(function () {
//	return false;
});

// tạo hiệu ứng select với url trùng với link hiện tại
(function ( u ) {
//	console.log(u);
	
	// tạo class select với thẻ A trùng link đang xem
	$('a[href="' + u + '"]').addClass('current-url-select');
//	console.log($('a.current-url-select').length);
	
	// nếu URL này không được tìm thấy -> thử theo canonical URL
	if ( $('a.current-url-select').length == 0 ) {
		$('a[href="' + eb_this_current_url + '"]').addClass('current-url-select');
	}
	
	// -> tạo select cho LI chứa nó
	$('li').each(function() {
//		console.log( $('a.current-url-select', this).length );
		if ( $('a.current-url-select', this).length > 0 ) {
			$(this).addClass('selected');
		}
	});
	
})( window.location.href.split('#')[0] );





// nút thêm sản phẩm vào giỏ hàng
setTimeout(function () {
	$('.click-jquery-add-to-cart').click(function() {
		var product_price = $(this).attr('data-gia') || $(this).attr('data-price') || '';
		if ( product_price == '' ) {
			if ( typeof product_js['gm'] == 'number' && product_js['gm'] > 0 ) {
				product_price = product_js['gm'];
			} else {
				product_price = 0;
			}
		}
		
		_global_js_eb.cart_add_item( $(this).attr('data-id') || pid || 0, {
			'price' : product_price
		} );
	});
	
	
	//
	$('.click-jquery-show-quick-cart').click(function() {
		$('#click_show_cpa').show();
		$('body').addClass('body-no-scroll');
	});
	
	//
//	console.log('TEST');
//	$('.click-jquery-show-quick-cart:first').click();
}, 600);




// chuyển các URL video thành dạng list video
(function () {
	$('.widget_echbay_youtube .img-max-width').each(function() {
		var a = $(this).html() || '',
			str = '',
			wit = $(this).width(),
			hai = wit * youtube_video_default_size;
		
		if ( a != '' ) {
//			console.log(a);
			a = a.split("\n");
//			console.log(a);
			
			for ( var i = 0; i < a.length; i++ ) {
				a[i] = g_func.trim( a[i] );
				
				if ( a[i] != '' ) {
					a[i] = _global_js_eb.youtube_id( a[i] );
				}
				
				if ( a[i] != '' ) {
					str += '<div class="widget_echbay_youtube-node"><iframe src="//www.youtube.com/embed/' + a[i] + '" allowfullscreen="" frameborder="0" height="' + hai + '" width="' + wit + '"></iframe></div>';
				}
			}
			
			$(this).show().html( str );
		}
	});
})();




// chuyển các URL video thành dạng list video
(function () {
	$('.widget_echbay_gg_map .url-to-google-map').each(function() {
		var a = $(this).html() || '',
			str = '',
			wit = 4/ 5;
		
		if ( a != '' ) {
			a = a.split("\n")[0];
			a = g_func.trim( a );
			
			if ( a != '' ) {
				$(this).show();
				
				str += '<div class="widget_echbay_gg_map-node"><iframe src="' + a + '" width="100%" height="' + ( $(this).width() * wit ) + 'px" frameborder="0" style="border:0" allowfullscreen=""></iframe></div>';
				
				$(this).html( str );
			}
		}
	});
})();





//
//console.log(act);

//
if ( act == 'search' ) {
	$('.thread-search-avt[data-img=""]').hide();
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
	else if ( act == 'cart' ) {
		_global_js_eb.ga_event_track( 'View cart', 'Xem gio hang' );
	}
	else if ( act == 'hoan-tat' ) {
		_global_js_eb.ga_event_track( 'Booking done', 'Dat hang thanh cong' );
	}
}, 2000);



//
if (press_esc_to_quickvideo_close == false) {
	press_esc_to_quickvideo_close = true;
	
	$(document).keydown(function(e) {
//		console.log( e.keyCode );
		
		//
		if (e.keyCode == 27) {
			
			//
			close_img_quick_video_details();
			g_func.opopup();
			
		}
	});
}





//
(function ( a ) {
	if ( a != '' ) {
		$('.click-viewmore-cats-description').show().click(function () {
			$('.global-cats-description').toggleClass('global-cats-description-active');
		});
	} else {
		$('.global-cats-description').hide();
	}
})( $('.global-cats-description').html() || '' );





//
(function ( a ) {
	if ( a == '' ) {
		$('.div-search form').attr({
			name : 'frm_search'
		});
	}
})( $('.div-search form').attr('name') || '' );

// menu for mobile
if ( typeof document.frm_search != 'undefined' ) {
	if ( $('#click_add_to_search').length > 0 ) {
		$('#value_add_to_search').off().keyup(function(e) {
		//	console.log(e.keyCode);
			if (e.keyCode == 13) {
				$('#click_add_to_search').click();
				return false;
			}
	//	}).val( $('input[type="search"]').val() || '' );
		}).val( document.frm_search.s.value );
		
		
		//
		$('#click_add_to_search').off('click').click(function () {
			document.frm_search.s.value = $('#value_add_to_search').val() || '';
			
			//
			if ( document.frm_search.s.value.length > 2 ) {
				document.frm_search.submit();
			}
			else {
				$('#value_add_to_search').focus();
			}
		});
	}
}




//
function ___eb_add_conver_string_cart_to_arr_cart ( arr ) {
	
	console.log( arr );
	
	if ( typeof arr != "object" ) {
		try {
			arr = $.parseJSON( unescape( arr ) );
		} catch (e) {
			arr = '';
		}
		
		// kiểm tra lại mà vẫn thế -> lỗi
		if ( typeof arr != "object" ) {
			console.log( "cart value not found" );
			return false;
		}
		console.log( arr );
		
		//
		current_hd_object = arr;
	}
	
	return arr;
	
}

function ___eb_add_convertsion_gg_fb ( hd_id, arr ) {
	
	//
	if ( typeof hd_id != "number" ) {
		console.log( "order ID not found" );
		return false;
	}
	
	// nếu giá trị tuyền vào không phải là mảng
	arr = ___eb_add_conver_string_cart_to_arr_cart( arr );
	if ( arr == false ) {
		return false;
	}
	
	//
//	current_hd_id = hd_id;
//	current_hd_object = arr;
	
	// Set tracker currency to Euros.
//	ga('set', 'currencyCode', 'VND');
	
	//
	var tong_tien = 0,
		arr_ids = [];
	for ( var i = 0; i < arr.length; i++ ) {
//		if ( typeof arr[i].__eb_hd_customer_info == 'undefined' ) {
			arr_ids.push( arr[i].id );
			tong_tien -= ( 0 - arr[i].price );
			
			//
			if ( typeof ga != 'undefined' ) {
				var ga_add_product = {
					'id': 'p' + arr[i].id,
					'name': arr[i].name,
					'category': 'Echbay category',
					'brand': 'Echbay',
					'variant': 'red',
					'price': arr[i].price,
					'quantity': arr[i].quan
				};
//				console.log( ga_add_product );
				ga('ec:addProduct', ga_add_product);
			}
//		}
	}
	
	// fb track -> by products
	_global_js_eb.fb_track( "Purchase", {
		content_ids: arr_ids,
		content_type: "product",
//		value: arr[i].price,
		value: tong_tien,
		currency: "VND"
	});
	
	// google analytics track -> by order
	if ( typeof ga != 'undefined' ) {
		ga("ec:setAction", "purchase", {
//			"id": arr[0].id,
			"id": hd_id,
			"affiliation": window.location.href.split('//')[1].split('/')[0].replace('www.', ''),
//			"revenue": arr[0].price,
			"revenue": tong_tien,
			"tax": "0",
			"shipping": "0",
			"coupon": ""
		});
	}
	
}





// TEST
//g_func.opopup('login');
//g_func.opopup('register');



