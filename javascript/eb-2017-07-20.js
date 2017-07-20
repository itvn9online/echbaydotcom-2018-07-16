

/*
* file js thiết kế riêng cho theme wp
*/







var bg_load = 'Loading...',
	ctimeout = null,
	// tỉ lệ tiêu chuẩn của video youtube
	youtube_video_default_size = 315/ 560,
	// tên miền chính sử dụng code này
	primary_domain_usage_eb = '',
	disable_eblazzy_load = false,
	sb_submit_cart_disabled = 0,
	ebe_arr_cart_product_list = [],
	ebe_arr_cart_customer_info = [];




//
/*
if (top == self) {
	var so_lan_reset_current_page = 0;
	setInterval(function() {
		so_lan_reset_current_page++;
		if (so_lan_reset_current_page < 3) {
			var jd = '_____eb_js_session_reset_timeout';
			if (dog(jd) == null) {
				$('<div id="' + jd + '" class="d-none"></div>').appendTo('body');
			}
			ajaxl('guest.php?act=reset_timeout', jd, 9, function() {
				console.log('Reset timeout');
			});
		} else {
			window.location = window.location.href;
		}
	}, 1200 * 1000);
}
*/

function dog(o, s) {
	if (typeof o == 'undefined' || o == '' || document.getElementById(o) == null) {
		console.log('id: ' + o + ' NULL');
		return null;
	}
	if (typeof s != 'undefined') {
		document.getElementById(o).innerHTML = s;
	}
	return document.getElementById(o);
}

function _date(phomat, t) {
	var result = '';
	if (typeof phomat != 'string' || phomat.replace(/\s/g, '') == '') {
		return _date('D, M d,Y H:i:s');
	} else {
		var type = typeof t,
			js_date = function(d) {
				var arr_D = "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),
					arr_M = "January February March April May June July August September October November December".split(" ");
				for (var i = 0, str = ''; i < phomat.length; i++) {
					str += (function(a) {
						if (typeof a == 'undefined') {
							return '';
						}
						a = a.replace(/\s/g, ' ');
						switch (a) {
							case "d":
								a = d.getDate();
								break;
							case "D":
								a = arr_D[d.getDay()].substr(0, 3);
								break;
							case "l":
								a = arr_D[d.getDay()];
								break;
							case "F":
								a = arr_M[d.getMonth()];
								break;
							case "M":
								a = arr_M[d.getMonth()].substr(0, 3);
								break;
							case "m":
								a = d.getMonth() + 1;
								break;
							case "Y":
								a = d.getFullYear();
								break;
							case "y":
								a = d.getFullYear().toString().substr(2);
								break;
							case "a":
								a = d.getHours();
								if (a >= 12) {
									a = 'am'
								} else {
									a = 'pm'
								}
								break;
							case "A":
								a = d.getHours();
								if (a >= 12) {
									a = 'AM'
								} else {
									a = 'PM'
								}
								break;
							case "H":
								a = d.getHours();
								break;
							case "h":
								a = d.getHours();
								if (a > 12) {
									a -= 12
								}
								break;
							case "i":
								a = d.getMinutes();
								break;
							case "s":
								a = d.getSeconds();
								break;
						}
						if (a != ' ' && !isNaN(a) && a < 10) {
							a = '0' + a;
						}
						return a;
					})(phomat.substr(i, 1));
				}
				return str;
			};
		if (type == 'string') {
			t = parseInt(t, 10);
		}
		if (type == 'undefined' || isNaN(t)) {
			t = new Date().getTime();
		} else {
			t = t * 1000;
		}
		var nd = new Date(t);
		result = js_date(nd);
	}
	return result;
}
var g_func = {
	non_mark: function(str) {
		str = str.toLowerCase();
		str = str.replace(/\u00e0|\u00e1|\u1ea1|\u1ea3|\u00e3|\u00e2|\u1ea7|\u1ea5|\u1ead|\u1ea9|\u1eab|\u0103|\u1eb1|\u1eaf|\u1eb7|\u1eb3|\u1eb5/g, "a");
		str = str.replace(/\u00e8|\u00e9|\u1eb9|\u1ebb|\u1ebd|\u00ea|\u1ec1|\u1ebf|\u1ec7|\u1ec3|\u1ec5/g, "e");
		str = str.replace(/\u00ec|\u00ed|\u1ecb|\u1ec9|\u0129/g, "i");
		str = str.replace(/\u00f2|\u00f3|\u1ecd|\u1ecf|\u00f5|\u00f4|\u1ed3|\u1ed1|\u1ed9|\u1ed5|\u1ed7|\u01a1|\u1edd|\u1edb|\u1ee3|\u1edf|\u1ee1/g, "o");
		str = str.replace(/\u00f9|\u00fa|\u1ee5|\u1ee7|\u0169|\u01b0|\u1eeb|\u1ee9|\u1ef1|\u1eed|\u1eef/g, "u");
		str = str.replace(/\u1ef3|\u00fd|\u1ef5|\u1ef7|\u1ef9/g, "y");
		str = str.replace(/\u0111/g, "d");
		return str
	},
	non_mark_seo: function(str) {
		str = this.non_mark(str);
		str = str.replace(/\s/g, "-");
		str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|$|_/g, "");
		str = str.replace(/-+-/g, "-");
		str = str.replace(/^\-+|\-+$/g, "");
		for (var i = 0; i < 5; i++) {
			str = str.replace(/--/g, '-')
		}
		str = (function(s) {
			var str = '',
				re = /^\w+$/,
				t = '';
			for (var i = 0; i < s.length; i++) {
				t = s.substr(i, 1);
				if (t == '-' || t == '+' || re.test(t) == true) {
					str += t
				}
			}
			return str
		})(str);
		return str
	},
	strip_tags: function(input, allowed) {
		if (!allowed) {
			allowed = ''
		}
		allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
		var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
			cm = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
		return input.replace(cm, '').replace(tags, function($0, $1) {
			return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
		})
	},
	trim: function(str) {
		return $.trim( str );
//		return str.replace(/^\s+|\s+$/g, "")
	},
	
	setc: function (name, value, days) {
		var expires = "";
		
		if ( typeof days == 'number' && days > 0 ) {
			// giá trị truyền vào nhỏ hơn 60 -> tính theo ngày
			if ( days < 60 ) {
				days = days * 24 * 3600;
			}
			// chuyển sang dạng timestamp
			days = days * 1000;
			
			var date = new Date();
			date.setTime( date.getTime() + days );
			expires = "; expires=" + date.toGMTString();
		}
		
		//
		document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
	},
	getc: function (name) {
		var nameEQ = encodeURIComponent(name) + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) === ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
		}
		return null;
	},
	
	delck: function (name) {
		g_func.setc(name, "", -1);
	},
	
	text_only: function(str) {
		if (typeof str == 'undefined' || str == '') {
			return '';
		}
		str = str.toString().replace(/[^a-zA-Z]/g, '');
		
		if (str == '') {
			return '';
		}
		
		return str;
	},
	number_only: function(str) {
		if (typeof str == 'undefined' || str == '') {
			return 0;
		}
		str = str.toString().replace(/[^0-9]/g, '');
		
		if (str == '') {
			return 0;
		}
		
		return str;
	},
	only_number: function(str) {
		return g_func.number_only(str);
	},
	money_format: function(str) {
		return g_func.formatCurrency(str);
	},
	number_format: function(str) {
		return g_func.formatCurrency(str);
	},
	formatCurrency: function(num, dot) {
		if (typeof num == 'undefined' || num == '') {
			num = '0';
		} else {
			if (typeof dot == 'undefined' || dot == '') {
				dot = ',';
			}
			num = num.toString().replace(/\s/g, '');
			var str = '',
				re = /^\d+$/,
				so_am = '';
			if (num.substr(0, 1) == '-') {
				so_am = '-';
			}
			for (var i = 0, t = ''; i < num.length; i++) {
				t = num.substr(i, 1);
				if (re.test(t) == true) {
					str += t;
				}
			}
			var len = str.length;
			if (len > 3) {
				var new_str = str;
				str = '';
				for (var i = 0; i < new_str.length; i++) {
					len -= 3;
					if (len > 0) {
						str = dot + new_str.substr(len, 3) + str;
					} else {
						str = new_str.substr(0, len + 3) + str;
						break;
					}
				}
			}
			num = so_am + str;
		}
		
		//
		return num;
	},
	
	
	
	wh: function() {},
	opopup: function(o) {
		if (typeof o == 'undefined') {
			$('#oi_popup').hide();
			return false;
		}
		
		//
		dog('oi_popup', '<div id="oi_popup_inner"><div align="center" style="padding:168px 0">Loading...</div></div>');
		
		//
//		ajaxl(web_link + 'eb-' + o, 'oi_popup_inner', 9, function () {
		ajaxl('eb-' + o, 'oi_popup_inner', 9, function () {
			$('#oi_popup_inner .popup-border').show();
		});
		
		//
		var a = window.scrollY || $(window).scrollTop() || 0;
		
		//
		$('#oi_popup').show().css({
			'padding-top' : a + 'px'
		}).height( $(document).height() - a );
		
		//
		return false;
	},
	
	
	mb_v2: function() {
		if ( screen.width < 900 || $(window).width() < 900 ) {
			return true;
		}
		return false;
	},
	mb: function(a) {
		return g_func.mb_v2();
	}
};

function ajaxl(url, id, bg, callBack) {
	if ( typeof url == 'undefined' || url == '' ) {
		console.log('URL is NULL');
		return false;
	}
	
	if ( typeof id == 'undefined' || id == '' ) {
		console.log('id is NULL.');
		return false;
	}
	else if ( dog(id) == null ) {
		if ( typeof bg == 'number' && bg == 1 ) {
			$('body').append('<div id="' + id + '"></div>');
		}
		else {
			console.log('"' + id + '" not found. Set bg = 1 for auto create div[id="' + id + '"].');
			return false;
		}
	}
	
	// URL phải theo 1 chuẩn nhất định
//	if ( url.split( web_link ).length == 1 ) {
		url = web_link + 'eb-ajaxservice?set_module=' + url;
		console.log(url);
//	}
	
	//
	$.ajax({
		type: 'POST',
		url: url,
		data: ''
	}).done(function(msg) {
		$('#' + id).html(msg);
		
		if ( typeof callBack == 'function' ) {
			callBack();
		}
	});
}


function a_lert(m) {
	clearTimeout(ctimeout);
	dog('o_load', '<div class="o-load">' + m + '</div>');
	ctimeout = setTimeout(function() {
		g_func.jquery_null('o_load')
	}, 3000)
}






var _global_js_eb = {
	check_email: function(email, alert_true) {
		var re = /^\w+([\-\.]?\w+)*@\w+(\.\w+){1,3}$/;
		if (re.test(email) == true) {
			return true;
		}
		if (alert_true && alert_true == 1) {
			alert('Email kh\u00f4ng \u0111\u00fang \u0111\u1ecbnh d\u1ea1ng');
		}
		return false;
	},
	tim_theo_gia: function(id, arr_gia, str_lnk) {
		if ( typeof arr_gia == 'undefined' ) {
			arr_gia = [{
				v: '-10,000,000',
				t: 'Dưới 10 triệu'
			}, {
				v: '10,000,000 - 20,000,000',
				t: 'Từ 10 triệu đến 20 triệu'
			}, {
				v: '20,000,000 - 50,000,000',
				t: 'Từ 20 triệu đến 50 triệu'
			}, {
				v: '50,000,000 - 100,000,000',
				t: 'Từ 50 triệu đến 100 triệu'
			}, {
				v: '100,000,000',
				t: 'Trên 100 triệu'
			}];
		}
		
		//
		if ( typeof str_lnk == 'undefined' ) {
			str_lnk = 'price';
		}
		
		var str = '',
			sl = '';
		
		for ( var i = 0; i < arr_gia.length; i++ ) {
			arr_gia[i].v = arr_gia[i].v.replace( /\s|\,/g, '' );
			arr_gia[i].v = encodeURIComponent( arr_gia[i].v );
			
			//
			str += '<div><a data-data="' +arr_gia[i].v+ '" href="actions/thread&' +str_lnk+ '=' + arr_gia[i].v + '">' + arr_gia[i].t + '</a></div>';
		}
		
		//
		if ( typeof id != 'undefined' && id != '' ) {
			dog(id, str);
		}
		
		//
		return str;
	},
	
	
	//
	check_contact_frm : function () {
		var f = document.frm_contact;
		
		//
		return true;
	},
	
	contact_func : function () {
		_global_js_eb.cart_customer_cache( document.frm_contact );
	},
	
	
	//
	auto_margin: function() {
		
//		if ( window.location.href.split('localhost').length == 1 ) {
//			console.log('test on localhost');
//			return false;
//		}
//		console.log( 560 * 1.5 );
//		console.log( 315 * 1.5 );
		
		// tạo attr mặc định để lưu thuộc tính cũ
		$('.img-max-width').each(function() {
			var max_width = $(this).width();
//			console.log(max_width);
			
			// chỉnh lại chiều rộng của thẻ DIV trong khung nội dung (trừ đi padding với bỏe của div)
			$('.wp-caption', this).width( max_width - 5 );
			
			//
			$('img', this).each(function() {
				var wit = $(this).attr('data-width') || $(this).attr('width') || 'auto',
					hai = $(this).attr('data-height') || $(this).attr('height') || 'auto';
					/*
				var m_wit = wit == 'auto' ? 0 : wit;
				
				if ( m_wit == 0 || m_wit > max_width ) {
					m_wit = max_width - 1;
				}
				*/
				
				$(this).attr({
					'data-height' : hai,
					'data-width' : wit
					/*
				}).css({
					'max-width' : m_wit + 'px'
					*/
				});
//			}).removeAttr('width').removeAttr('height');
			});
			
			
			$('iframe', this).each(function() {
				var a = $(this).attr('src') || '',
					wit = $(this).attr('data-width') || $(this).attr('width') || 560;
//				console.log(a);
				
				if ( wit > max_width ) {
					wit = max_width - 1;
				}
				
				// chỉ xử lý với video youtube
				if ( a.split('youtube.com/').length > 1 ) {
					$(this).attr({
//						'data-height' : $(this).attr('data-height') || $(this).attr('height') || 315,
						'data-width' : wit
					});
				}
			});
		});
		
		
		
		var avt_max_height = 250,
//			css_m_id = 'css-for-mobile',
			screen_width = $(window).width(),
			current_device = g_func.getc('click_set_device_style');
		if (screen_width < 950 && current_device != 'desktop') {
			/*
			(function(d, j) {
				if (d.getElementById(j)) return;
				var head = d.getElementsByTagName('head')[0];
				var l = d.createElement('link');
				l.rel = 'stylesheet';
				l.type = 'text/css';
				l.href = 'css/m.css?v=' + _date('Y-m-d-H');
				l.media = 'all';
				l.id = css_m_id;
				head.appendChild(l);
			}(document, css_m_id));
			*/
			$('body').addClass('style-for-mobile');
			
			
			
			
			// Điều chỉnh bằng cách dùng chung một chức năng
			$('.fix-li-wit').each(function () {
				var a = $( this ).width() || 0,
					w = $( this ).attr('data-width') || '',
					w_big = $( this ).attr('data-big-width') || '',
					// điều chỉnh chiều rộng cho loại thẻ hoặc class nào -> mặc định là li
					fix_for = $( this ).attr('data-tags') || 'li';
				
				//
				if ( a > 0 && w != '' ) {
					
					// Với màn hình ipad dọc Sử dụng kích thước lớn hơn chút
//					if ( screen_width > 700 ) {
//						w *= 1.5;
//					}
					if ( screen_width > 700 && w_big != '' ) {
						w = w_big;
					}
					
					//
					w = Math.ceil( a / w ) - 1;
					if ( w < 1 ) {
						w = 1;
					}
					
					//
					$( fix_for, this ).width( ( 100/ w ) + '%' );
				}
			});
			
			
			
			// treen mobile -> giới hạn kích thước media
			$('.img-max-width').each(function() {
				var max_width = $(this).width() || 250,
					max_sizes_width = max_width + 99;
				
				// xử lý với hình ảnh
				$('img', this).each(function() {
					// chuyển phần fix kích thước về auto và xóa attr liên liên quan đến kích thước
					$(this).css({
//						'max-width' : max_width + 'px',
						'width' : 'auto',
						'height' : 'auto'
//					}).attr({
//						'width' : 'auto',
//						'height' : 'auto',
//					}).removeAttr('width').removeAttr('height');
					});
				}).css({
					'max-width' : max_width + 'px'
				}).attr({
					sizes : '(max-width: ' + max_sizes_width + 'px) 100vw, ' + max_sizes_width + 'px'
				}).removeAttr('width').removeAttr('height');
			
			
				// xử lý với video của youtube
				$('iframe', this).each(function() {
					var a = $(this).attr('src') || '';
					
					// chỉ xử lý với video youtube
					if ( a.split('youtube.com/').length > 1 ) {
//						var pt = $(this).attr('data-height') * 100 / $(this).attr('data-width');
						
						/*
						var w = $(this).attr('data-width') || '',
							h = $(this).attr('data-height') || '',
							new_width = w,
							new_height = h,
							pt = h * 100 / w;
						
						//
						if ( new_width > max_width ) {
							new_width = max_width;
						}
						
						//
						$(this).attr({
							'width' : new_width,
							'height' : new_width/ 100 * pt
						});
						*/
						
						//
						$(this).attr({
							'width' : max_width,
							'height' : max_width * youtube_video_default_size
						});
					}
				});
			});
		} else {
//			$('#' + css_m_id).remove();
			$('body').removeClass('style-for-mobile');
			
			//
			$('.fix-li-wit').each(function () {
				var fix_for = $( this ).attr('data-tags') || 'li';
				
				//
				$( fix_for, this ).width( '' );
			});
			
			
			// hình ảnh và clip trên bản pc -> giờ mới xử lý
			$('.img-max-width').each(function() {
				var max_width = $(this).width() || 250,
					max_sizes_width = max_width + 99;
//				console.log(max_width);
				
				// xử lý với hình ảnh
				$('img', this).each(function() {
					
					var current_wit = $(this).attr('data-width') || '';
					if ( current_wit != '' ) {
						if ( current_wit > max_width ) {
							current_wit = max_width;
						}
						current_wit -= 5;
					}
//					console.log(current_wit);
					
					//
					$(this).css({
//						'max-width' : max_width + 'px',
						'width' : '',
						'height' : ''
					}).attr({
						'width' : current_wit,
//						'height' : $(this).attr('data-height') || '',
//					}).removeAttr('width').removeAttr('height');
					});
//					}).removeAttr('height');
				}).css({
					'max-width' : max_width + 'px'
				}).attr({
					sizes : '(max-width: ' + max_sizes_width + 'px) 100vw, ' + max_sizes_width + 'px'
				}).removeAttr('height');
			});
			
			$('.img-max-width iframe').each(function() {
				var a = $(this).attr('src') || '';
				
				// chỉ xử lý với video youtube
				if ( a.split('youtube.com/').length > 1 ) {
					var wit = $(this).attr('data-width') || $(this).attr('width') || 560;
					$(this).attr({
						'width' : wit,
						'height' : wit * youtube_video_default_size
					});
				}
			});
		}
		
		//
		if ( typeof pid != 'undefined' && pid > 0 ) {
			var wit_mb = $('.thread-details-mobileAvt').width(),
				hai_mb = wit_mb,
				li_len = $('.thread-details-mobileAvt li').length,
				li_wit = 100/ li_len;
			
			$('.thread-details-mobileAvt ul').width( wit_mb * li_len );
			$('.thread-details-mobileAvt li').width( li_wit + '%' );
		}
		
		
		
		//
		$('.no-set-width-this-li').width( '100%' );
		
		
		
		// chỉnh kích cỡ ảnh theo tỉ lệ
		$('.ti-le-global').each(function() {
			var a = $(this).width(),
				// tỉ lệ kích thước giữa chiều cao và rộng (nếu có), mặc định là 1x1
				// -> nhập vào là: chiều cao/ chiều rộng
				new_size = $(this).attr('data-size') || '';
			
			if ( new_size != '' ) {
//				a *= new_size;
				a *= eval(new_size);
				a += 1;
			}
			
			$(this).css({
				'line-height': a + 'px',
				height: a + 'px'
			});
		});
//		console.log( eval('560/315') );
//		console.log( eval('2/3') );
		
		
		
		//
//		_global_js_eb.big_banner();
		
	},
	
	big_banner : function () {
		var a = $('.oi_big_banner li:first').height();
		
		$('.oi_big_banner, .oi_big_banner li').height( a ).css({
			'line-height' : a + 'px'
		});
//		$('.oi_big_banner').height( a );
	},
	
	money_format_keyup: function() {
		$('.change-tranto-money-format').off('keyup').off('change').keyup(function(e) {
			var k = e.keyCode,
				a = $(this).val() || '';
			if ((k >= 48 && k <= 57) || (k >= 96 && k <= 105) || k == 8 || k == 46) {
				a = g_func.formatCurrency(a);
				if (a == 0 || a == '0') {
					$(this).val(a).select();
				} else {
					$(this).val(a).focus();
				}
			}
		}).change(function() {
			$(this).val(g_func.formatCurrency($(this).val()));
		});
	},
	
	select_date: function(id, op) {
		if (typeof op == 'undefined') {
			op = {};
		}
		if (typeof op['dateFormat'] == 'undefined') {
			op['dateFormat'] = 'yy/mm/dd';
		}
		$.datepicker.regional['de'] = {
			monthNames: ['Th\u00e1ng 1', 'Th\u00e1ng 2', 'Th\u00e1ng 3', 'Th\u00e1ng 4', 'Th\u00e1ng 5', 'Th\u00e1ng 6', 'Th\u00e1ng 7', 'Th\u00e1ng 8', 'Th\u00e1ng 9', 'Th\u00e1ng 10', 'Th\u00e1ng 11', 'Th\u00e1ng 12'],
			monthNamesShort: ['Jan', 'Feb', 'M&auml;r', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
			dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
			dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
			dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
		};
		$.datepicker.setDefaults($.datepicker.regional['de']);
		$(id).datepicker(op);
	},
	
	_log_click_ref: function() {
		setTimeout(function() {
			var a = document.referrer || '',
				click_url = window.location.href,
				s = '',
				uri = '',
				staff_id = '',
				check_staff_id = '',
				jd = 'process_referrer_data_click';
			if (a != '') {
				s = a.replace('www.', '').split('//')[1].split('/')[0];
				if (s.replace('m.', '') == click_url.replace('www.', '').replace('m.', '').split('//')[1].split('/')[0]) {
					return false;
				}
				if (dog(jd) == null) {
					$('<div id="' + jd + '" style="display:none;"></div>').appendTo('body');
				}
				check_staff_id = click_url.split('utm_source=');
				if (check_staff_id.length > 1) {
					staff_id = check_staff_id[1].split('&')[0].split('/')[0].split('?')[0].split('#')[0];
					if (staff_id != '') {
						staff_id = staff_id.toLowerCase().split('ctv');
						if (staff_id.length > 1) {
							staff_id = staff_id[1].split('eb')[0];
							staff_id = parseInt(staff_id, 10);
							if (isNaN(staff_id) || staff_id <= 0) {
								staff_id = '';
							}
						} else {
							staff_id = '';
						}
					}
				}
				if (staff_id == '') {
					staff_id = 0;
				}
				if (staff_id > 0) {
					g_func.setc('ss_staff_id', staff_id, 30);
				}
				if (g_func.getc('ss_ads_referre') != null) {
					console.log('user return');
					return false;
				}
				g_func.setc('ss_ads_referre', encodeURIComponent(a), 3600 * 6);
				var pad = function(number, length) {
						var str = "" + number;
						while (str.length < length) {
							str = '0' + str;
						}
						return str;
					},
					offset = new Date().getTimezoneOffset();
				offset = ((offset < 0 ? '+' : '-') + pad(parseInt(Math.abs(offset / 60)), 2) + pad(Math.abs(offset % 60), 2));
				var arr = {
					click_ref: encodeURIComponent(a),
					click_url: encodeURIComponent(click_url),
					click_iframe: (function() {
						return (top != self) ? 1 : 0
					})(),
					click_title: (function() {
						var str = document.title || '';
						if (str != '') {
							str = encodeURIComponent(str)
						}
						return str
					})(),
					click_timezone: encodeURIComponent(offset),
					click_lang: (function() {
						var str = navigator.userLanguage || navigator.language || '';
						return str
					})(),
					click_usertime: (function() {
						var t = new Date().getTime();
						t = parseInt(t / 1000, 10);
						return t
					})(),
					click_window: $(window).width() + 'x' + $(window).height(),
					click_document: $(document).width() + 'x' + $(document).height(),
					click_screen: screen.width + 'x' + screen.height,
					click_agent: (function() {
						var str = navigator.userAgent || navigator.vendor || window.opera || '';
						str = str.replace(/\s/g, '+');
						return str
					})(),
					click_staff_id: staff_id
				};
				uri = 'guest.php?act=log_click';
				for (var x in arr) {
					uri += '&' + x + '=' + arr[x];
				}
				setTimeout(function() {
					ajaxl(uri, jd, 9);
					console.log('Log referrer');
				}, 200);
			}
		}, 600);
	},
	
	ebBgLazzyLoadOffset: function(i) {
//		console.log( 'each-to-bgimg offset' );
		
		if ( typeof i != 'number' ) {
			i = 5;
		}
		
		$('.each-to-bgimg').each(function() {
			a = $(this).attr({
				'data-offset' : $(this).offset().top
			});
		});
		
		if ( i > 0 ) {
			setTimeout(function () {
				_global_js_eb.ebBgLazzyLoadOffset( i - 1 );
			}, 2000);
		}
	},
	
	ebBgLazzyLoad: function(lazzy_show) {
		var eb_lazzy_class = 'eb-lazzy-effect',
			a = 0,
			wh = $(window).width();
		
		//
		if (typeof lazzy_show == 'number' && lazzy_show > 0) {
//			console.log(lazzy_show);
			
			// Nếu ko đủ class để làm việc -> thoát luôn
			if ( disable_eblazzy_load == true || $('.' + eb_lazzy_class).length <= 0 ) {
				disable_eblazzy_load = true;
				return false;
			}
			
			//
			lazzy_show += 600;
//			lazzy_show += 1500;
//			lazzy_show += $(window).height();
			
			//
			$('.' + eb_lazzy_class).each(function() {
				a = $(this).offset().top || 0;
//				a = $(this).attr('data-offset') || $(this).offset().top || 0;
				
				if ( a < lazzy_show ) {
					var wit = $(this).width() || 300;
					
					// v1
					/*
					$(this).css({
//						opacity: 1,
//					}).css({
						'background-image': 'url(\'' + ($(this).attr('data-img') || '') + '\')'
					});
					*/
					
					
					// v2
					var img = $(this).attr('data-img') || '',
						img_table = $(this).attr('data-table-img') || img || '',
						img_mobile = $(this).attr('data-mobile-img') || img_table || '';
					
					//
					if ( img == 'speed' ) {
						img = img_mobile;
						// sử dụng ảnh cho bản mobile
//						if ( wh < 768 && img_mobile != '' ) {
						if ( img_mobile != '' ) {
							// mobile
							if ( wit < 250 ) {
								img += 'm';
							}
							// table
							/*
							else if ( wit < 400 ) {
								img += 't';
							}
							*/
						}
						$(this).addClass(img);
					}
					else if (img != '') {
						// sử dụng ảnh cho bản mobile
//						if ( wh < 768 && img_mobile != '' && img.split('.').pop().toLowerCase() != 'png' ) {
//						if ( img_mobile != '' && img.split('.').pop().toLowerCase() != 'png' ) {
							if ( wit < 250 ) {
								img = img_mobile;
							}
							/*
							else if ( wit < 768 ) {
								img = img_table;
							}
							*/
//						}
						
						// sử dụng cdn nếu ảnh trong thư mục upload
//						if ( primary_domain_usage_eb != '' && img.split('/')[0] == 'upload' ) {
//							img = img.replace( 'upload/', '//upload.' +primary_domain_usage_eb+ '.com.vn/' );
//						}
						
						//
						$(this).css({
//							opacity: 1,
//						}).css({
//							'background-image': 'url(\'' + _global_js_eb.resize_img( img, $(this).width() ) + '\')'
							'background-image': 'url(\'' + img + '\')'
						});
					}
					
					//
					$(this).removeClass(eb_lazzy_class);
				}
				/*
				else {
					return false;
				}
				*/
			});
		} else {
			$('.each-to-bgimg').addClass(eb_lazzy_class);
			/*
			$('.each-to-bgimg').addClass(eb_lazzy_class).css({
				opacity: .2
			});
			*/
			
			_global_js_eb.ebBgLazzyLoad( $(window).height() * 1.5 );
		}
	},
	
	fix_url_id: function() {
		if (cid <= 0) {
			return false;
		}
		
		var wh = window.location.href,
			new_url = '';
		if ( wh.split('&').length > 1 || wh.split('-page').length > 1 ) {
			console.log('Not rewrite URL or Part page');
			return false;
		}
		
		
		//
		/*
		if (pid > 0) {
			if (typeof fix_url_pid != 'undefined' && fix_url_pid != '') {
				fix_url_pid = web_link + fix_url_pid;
				
//					console.log( window.location.href.split('//')[1] );
//					console.log( fix_url_pid.split('//')[1] );
				
				try {
					if ( window.location.href.split('//')[1] != fix_url_pid.split('//')[1] ) {
						new_url = fix_url_pid;
					}
				} catch (e) {}
			}
		}
		else if (fid > 0) {
			*/
		if (fid > 0) {
			for (var i = 0; i < site_group.length; i++) {
				if (new_url == '') {
					(function(arr) {
						for (var i = 0; i < arr.length; i++) {
							(function(arr) {
								for (var i = 0; i < arr.length; i++) {
									if (arr[i].id == fid) {
										new_url = _global_js_eb._c_link( fid, arr[i].seo, 'f' );
										break;
									}
								}
							})(arr[i].arr);
						}
					})(site_group[i].arr);
				}
			}
		}
		else if (sid > 0) {
			for (var i = 0; i < site_group.length; i++) {
				if (new_url == '') {
					(function(arr) {
						for (var i = 0; i < arr.length; i++) {
							if (arr[i].id == sid) {
								new_url = _global_js_eb._c_link( sid, arr[i].seo, 's' );
								break;
							}
						}
					})(site_group[i].arr);
				}
			}
		}
		else {
			for (var i = 0; i < site_group.length; i++) {
				if (site_group[i].id == cid) {
					new_url = _global_js_eb._c_link( cid, site_group[i].seo );
					break;
				}
			}
		}
		
		//
		if ( web_link.split('//')[1] + new_url != window.location.href.split('//')[1] ) {
			console.log( web_link.split('//')[1] + new_url );
			console.log( window.location.href.split('//')[1] );
			
			window.history.pushState("", '', new_url);
		}
	},
	
	cart_agent: function() {
		
		if (dog('cart_user_agent') == null) {
			console.log( 'cart_user_agent not found' );
			return false;
		}
		
		
		
		//
		var pad = function(number, length) {
				var str = "" + number;
				while (str.length < length) {
					str = '0' + str;
				}
				return str;
			},
			offset = new Date().getTimezoneOffset(),
			str = '';
		
		//
		offset = ((offset < 0 ? '+' : '-') + pad(parseInt(Math.abs(offset / 60)), 2) + pad(Math.abs(offset % 60), 2));
		
		//
		var arr = {
			// user info
			hd_ten: '',
			hd_dienthoai: '',
			hd_email: '',
			hd_diachi: '',
			hd_ghichu: '',
			hd_thanhtoan: 'tructiep',
			
			// user agent
			hd_url: window.location.href,
			hd_title: (function(str) {
				return str
			})(document.title || ''),
			hd_timezone: offset,
			hd_lang: (function(str) {
				return str
			})(navigator.userLanguage || navigator.language || ''),
			hd_usertime: (function() {
				var t = new Date().getTime();
				t = parseInt(t / 1000, 10);
				return t
			})(),
			hd_window: $(window).width() + 'x' + $(window).height(),
			hd_document: $(document).width() + 'x' + $(document).height(),
			hd_screen: screen.width + 'x' + screen.height,
			hd_agent: navigator.userAgent
		};
		
		// user info
		if ( pid > 0 ) {
			var f = document.frm_cart;
			
			arr['hd_ten'] = f.t_ten.value;
			arr['hd_dienthoai'] = f.t_dienthoai.value;
			arr['hd_email'] = f.t_email.value;
			arr['hd_diachi'] = f.t_diachi.value;
			arr['hd_ghichu'] = f.t_ghichu.value;
		}
		else {
			arr['hd_ten'] = $('#t_ten').val() || '';
			arr['hd_dienthoai'] = $('#t_dienthoai').val() || '';
			arr['hd_email'] = $('#t_email').val() || '';
			arr['hd_diachi'] = $('#t_diachi').val() || '';
			arr['hd_ghichu'] = $('#t_ghichu').val() || '';
			arr['hd_thanhtoan'] = $('input[name="t_thanhtoan"]:checked').val() || 'tructiep';
		}
		
//		console.log(arr);
		
		/*
		for (var x in arr) {
			// v2
			arr[x] = encodeURIComponent(arr[x].toString().replace(/"/g, '&quot;'));
			str += ',' + x + ':"' + arr[x] + '"'
			
			// v1
//					str += '<input type="text" name="' + x + '" value="' + arr[x] + '" />';
		}
		if (str != '') {
			str = str.substr(1)
		}
		*/
//		str = JSON.stringify( arr );
//		alert( str );
		
		//
//		if ( dog('hd_customer_info') == null ) {
		if ( $('#hd_customer_info').length == 0 ) {
			$('#cart_user_agent').append('<textarea name="hd_customer_info" id="hd_customer_info"></textarea>');
		}
		$('#hd_customer_info').val( escape( JSON.stringify( arr ) ) );
		
		//
//		if ( dog('hd_re_link') == null ) {
		if ( $('#hd_re_link').length == 0 ) {
			$('#cart_user_agent').append('<input type="text" name="t_re_link" id="hd_re_link" value="" />');
		}
		$('#hd_re_link').val( window.location.href );
		
	},
	
	_c_link : function ( id, seo, name ) {
		if (typeof name == 'undefined' || name == '') {
			name = 'c';
		}
		if (typeof seo == 'undefined') {
			return name + id + '/';
		}
		
		/*
		* định hình URL
		*/
		// -> /thiet-ke-web-gia-re-c1/
		if ( cf_categories_url == 1 ) {
			return seo + '-' + name + id + '/';
		}
		// -> /thiet-ke-web-gia-re/
		else if ( cf_categories_url == 2 ) {
			return seo + '/';
		}
		// /c1/thiet-ke-web-gia-re.html
		else if ( cf_categories_url == 3 ) {
			return name + id + '/' + seo + '.html';
		}
		// -> /c1/thiet-ke-web-gia-re/
		else if ( cf_categories_url == 4 ) {
			return name + id + '/' + seo + '/';
		}
		// -> /thiet-ke-web-gia-re.html
		else if ( cf_categories_url == 5 ) {
			return seo + '.html';
		}
		
		// default -> /c1-thiet-ke-web-gia-re.html
		return seo + '-' + name + id + '.html';
	},
	
	youtube_id : function ( a ) {
		if ( a.split('youtube.com').length > 1 || a.split('youtu.be').length > 1 ) {
			var youtube_parser = function (url){
				var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
				
				var match = url.match(regExp);
				
				return ( match && match[7].length == 11 ) ? match[7] : false;
			};
			
			return youtube_parser( a );
		}
		
		//
		return '';
	},
	
	user_img_loc : function ( wit, hai ) {
		// lấy tọa độ người dùng
		var a = _global_js_eb.user_loc();
//		console.log(a);
//		console.log(typeof a);
		
		// Kiểu dữ liệu về bắt buộc phải là một mảng
		if ( typeof a == 'object' && typeof a['loc'] != 'undefined' ) {
//			console.log(a);
			
			//
			if ( typeof wit != 'number' ) wit = 400;
			
			if ( typeof hai != 'number' ) hai = 400;
			
			return '//maps.googleapis.com/maps/api/staticmap?center=' +a['loc']+ '&zoom=14&size=' +wit+ 'x' +hai+ '&sensor=false';
		}
		
		// Mặc định trả về 1 chuỗi
		return '';
	},
	
	user_string_loc : function () {
		// lấy tọa độ người dùng
		var a = _global_js_eb.user_loc();
//		console.log(a);
//		console.log(typeof a);
		
		// Kiểu dữ liệu về bắt buộc phải là một mảng
		if ( typeof a == 'object' ) {
			// Chuyển thành chuỗi
			a = JSON.stringify( a );
//			console.log(a);
//			console.log(typeof a);
			
			return a;
		}
		
		// Mặc định trả về 1 chuỗi
		return '';
	},
	
	user_loc: function() {
		// TEST
//		g_func.delck('ipinfo_to_language'); return;
		
		// kiểm tra trong cookie xem có ko
		var a = g_func.getc('ipinfo_to_language');
//		console.log( a );
		
		// nếu có -> trả về luôn
		if ( a != null ) {
//			console.log(a);
//			console.log(typeof a);
			
			//
			g_func.setc('ipinfo_to_language', a, 7 );
			
			//
			var json_array = function ( a ) {
				if ( typeof a != 'object' ) {
					try {
						return JSON.parse(a);
					} catch (e) {}
				}
				
				return a;
			};
			
			// Chỉnh lại chuỗi về dạng mảng
			a = json_array (a);
			
			// làm lại lần nữa cho chắc ăn
			a = json_array (a);
			
			// quá tam 3 bận
			if ( typeof a != 'object' ) {
				// xóa cookie này đi để tạo lại sau
				g_func.delck('ipinfo_to_language');
				
				//trả về một trường trống
				return {};
			}
			
//			console.log(a);
			
			return a;
		}
		
		
		// Hỏi tọa độ của người dùng
		navigator.geolocation.getCurrentPosition( function ( position ) {
			// Nếu người dùng tiết lộ -> xin luôn
			var lat = position.coords.latitude,
				lon = position.coords.longitude;
//			console.log( lat );
//			console.log( lon );
			
			//
//			var data = '{"loc":"' +lat+ ',' +lon+ '"}';
			var data = {
				loc : lat + ',' + lon
			};
//			console.log( data );
			
			// lưu lại trong cookies
			g_func.setc('ipinfo_to_language', JSON.stringify( data ), 7 );
		}, function () {
			
			//
			console.log( 'Not get user Position' );
			
			// Không cho thì lấy gần đúng
			$.getJSON( '//ipinfo.io', function(data) {
//				console.log( data );
				
				g_func.setc('ipinfo_to_language', JSON.stringify( data ), 7 );
			});
		}, {
			timeout : 10000
		});
		
		// mặc định là tra về 1 mảng trống
		return {};
	},
	
	demo_html : function ( clat, len ) {
		console.log('Demo html');
		
		//
		$('.' + clat).each(function() {
			var str = $(this).html() || '',
				demo = '';
			
			if ( str != '' ) {
				for ( var i = 0; i < len; i++ ) {
					demo += str;
				}
				
				$(this).html( demo );
			}
		});
	},
	
	
	
	page404_func : function () {
		$('.click-go-to-search').click(function () {
			$('input[type="search"]:first').focus();
		});
	},
	
	
	
	cart_create_arr_porudct : function () {
		
		// reset lại mảng
		ebe_arr_cart_product_list = [];
		
		// nếu đang là xem trang chi tiết
		if ( pid > 0 ) {
			ebe_arr_cart_product_list.push( {
				"id" : pid,
				"name" : product_js.tieude,
				"size" : '',
				"color" : '',
				"old_price" : product_js.gia,
				"price" : product_js.gm,
				"quan" : $('#oi_change_soluong select').val() || 1,
				"sku" : ''
			} );
		}
		// nếu đang là xem trong giỏ hàng
		else {
			$('.each-for-set-cart-value').each(function () {
				ebe_arr_cart_product_list.push( {
					"id" : $(this).attr('data-id') || 0,
					"name" : $('.get-product-name-for-cart', this).html() || '',
					"size" : '',
					"color" : '',
					"old_price" : $(this).attr('data-old-price') || 0,
					"price" : $(this).attr('data-price') || 0,
					"quan" : $('.change-select-quanlity', this).val() || 1,
					"sku" : $(this).attr('data-sku') || ''
				} );
			});
		}
		console.log( ebe_arr_cart_product_list );
		
		//
//		if ( dog('hd_products_info') == null ) {
		if ( $('#hd_products_info').length == 0 ) {
			$('#cart_user_agent').append('<textarea name="hd_products_info" id="hd_products_info"></textarea>');
		}
		$('#hd_products_info').val( escape ( JSON.stringify( ebe_arr_cart_product_list ) ) );
		
	},
	
	cart_func : function () {
		
		//
		_global_js_eb.cart_create_arr_porudct();
		_global_js_eb.cart_agent();
		
		//
		if ( typeof new_cart_auto_add_id == 'number' && new_cart_auto_add_id > 0 ) {
			_global_js_eb.cart_add_item( new_cart_auto_add_id );
		}
		
		//
		_global_js_eb.check_null_cart();
		_global_js_eb.cart_customer_cache();
		
		//
		$('.change-select-quanlity').change(function () {
			_global_js_eb.cart_create_arr_porudct();
		});
		
	},
	
	check_null_cart : function () {
		if ( typeof pid == 'number' && pid > 0 ) {
			return true;
		}
		
		var a = $('.cart-count-tr tr').length || 0;
//		console.log(a);
		
		// Nếu có sản phẩm trong giỏ hàng (bỏ đi tr đầu tiên)
		if ( a > 1 ) {
			$('#cart_null').hide();
			$('#oi_cart, #oi_send_invoice').fadeIn();
			
			return true;
		} else {
			$('#oi_cart, #oi_send_invoice').hide();
			$('#cart_null').fadeIn();
		}
		
		//
		return false;
	},
	
	check_cart : function () {
		
		//
		if ( sb_submit_cart_disabled == 1 ) {
			console.log('wating cart submit');
			return false;
		}
		
		// nếu giỏ hàng trống -> bỏ qua
		if ( _global_js_eb.check_null_cart() == false ) {
			alert('Vui lòng chọn sản phẩm trước khi tiếp tục');
			return false;
		}
		
		//
		var f = document.frm_cart;
		
		var check_phone_number = g_func.number_only( f.t_dienthoai.value );
		
		/*
		if (check_phone_number.toString().length < 10) {
			alert('Vui lòng nhập ít nhất một số điện thoại bạn đang sử dụng');
			f.t_dienthoai.focus();
			return false;
		}
		*/
		
		if (_global_js_eb.check_email(f.t_email.value) == false) {
			var new_email = g_func.non_mark_seo(f.t_dienthoai.value);
			try {
				new_email += '@' + web_link.split('//')[1].split('/')[0].replace('www.', '').replace(/\:/g, '.');
			} catch (e) {};
			f.t_email.value = new_email;
		}
		
		if (f.t_diachi.value.replace(/\s/g, '') == '') {
			f.t_diachi.value = f.t_dienthoai.value;
		}
		
//		_global_js_eb.cart_create_arr_porudct();
		_global_js_eb.cart_agent();
//		return false;
		
		// lưu thông tin khách hàng
		g_func.setc( 'eb_cookie_cart_name', f.t_ten.value, 7 );
		g_func.setc( 'eb_cookie_cart_phone', f.t_dienthoai.value, 7 );
		g_func.setc( 'eb_cookie_cart_email', f.t_email.value, 7 );
		g_func.setc( 'eb_cookie_cart_address', f.t_diachi.value, 7 );
		
		//
		$('body').css({
			opacity: 0.2
		});
		
		// không cho submit đơn liên tục
//		f.sb_submit_cart.disabled = true;
		sb_submit_cart_disabled = 1;
		
		// khi load xong sẽ cho submit trở lại
		$('#target_eb_iframe').on('load', function () {
			$('rME').css({
				opacity: 1
			});
			
			
			//
//			f.sb_submit_cart.disabled = false;
			sb_submit_cart_disabled = 0;
		});
		
		// hoặc load lâu quá -> cũng cho load trở lại
		setTimeout(function () {
			sb_submit_cart_disabled = 0;
		}, 5000);
		
		//
		return true;
	},
	
	cart_add_item_v2 : function ( new_cart_id, action_obj ) {
		
		//
		if ( typeof g_func.number_only( new_cart_id ) == 'number' ) {
			alert('Không xác định được sản phẩm');
			return false;
		}
		
		//
		if ( typeof action_obj != 'object' ) {
			action_obj = {};
		}
		
		var remove_item = 0;
		if ( typeof action_obj['remove_item'] != 'undefined' ) {
			remove_item = action_obj['remove_item'];
		}
//		console.log(remove_item);
		
		var tr_id = '';
		if ( typeof action_obj['tr_id'] != 'undefined' ) {
			tr_id = action_obj['tr_id'];
		}
		
		var c = 'eb_cookie_cart_list_id',
			cart_id_in_cookie = g_func.getc( c ),
			c_arr = 'eb_cookie_cart_list_arr',
			cart_arr_in_cookie = g_func.getc( c_arr ),
			list_cart_id = '';
		console.log(cart_id_in_cookie);
		console.log(cart_arr_in_cookie);
		
		//
		if ( cart_id_in_cookie == null ) {
			cart_id_in_cookie = '';
		}
		console.log(cart_id_in_cookie);
		
		//
		if ( cart_arr_in_cookie == null ) {
			cart_arr_in_cookie = [];
		} else {
			try {
				cart_arr_in_cookie = $.parseJSON( cart_arr_in_cookie );
			} catch ( e ) {
				console.log('ERROR conver cart in cookie');
				cart_arr_in_cookie = [];
			}
		}
		console.log(cart_arr_in_cookie);
		
		
		// xóa khỏi giỏ hàng
		if ( remove_item == 1 ) {
			if ( confirm('Xác nhận xóa sản phẩm khỏi giỏ hàng') == false ) {
				return false;
			}
			
			//
			for ( var i = 0; i < cart_arr_in_cookie.length; i++ ) {
				if ( cart_arr_in_cookie[i] == null || cart_arr_in_cookie[i].id == new_cart_id ) {
					cart_arr_in_cookie[i] = null;
				}
				else {
					list_cart_id += ',' + cart_arr_in_cookie[i].id;
				}
			}
//			console.log(list_cart_id);
			g_func.setc( c, list_cart_id, 7 );
			
//			console.log(list_cart_id);
			g_func.setc( c_arr, JSON.stringify( cart_arr_in_cookie ), 7 );
			
			//
			if ( tr_id != '' && dog(tr_id) != null ) {
				$('#' + tr_id).fadeOut().remove();
			}
			
			//
			_global_js_eb.check_null_cart();
			
			console.log('Remove cart (' + new_cart_id + ')');
			return false;
		}
		
		
		// add to cart
		var check_cart_exist = 0;
		for ( var i = 0; i < cart_arr_in_cookie.length; i++ ) {
			if ( cart_arr_in_cookie[i].id == new_cart_id ) {
				console.log('Cart exist (' + new_cart_id + ')');
				check_cart_exist = 1;
				break;
			}
		}
		
		//
		if ( check_cart_exist == 0 ) {
			console.log('Add to cart (' + new_cart_id + ')');
			
			cart_arr_in_cookie.push( {
				id : new_cart_id,
				quan : 1
			} );
			
			list_cart_id += ',' + new_cart_id;
			
			//
			console.log('Save cart (' + new_cart_id + ')');
			
			g_func.setc( c, list_cart_id, 7 );
			g_func.setc( c_arr, JSON.stringify( cart_arr_in_cookie ), 7 );
		}
		console.log( list_cart_id );
		console.log( cart_arr_in_cookie );
		console.log( JSON.stringify( cart_arr_in_cookie ) );
		
		
		
		// thời gian chuyển sang trang cart -> để mấy cái pixel tải xong đã
		var time_to_cart = 600;
		
		
		
		// google tracking add to cart -> Sử dụng chức năng Mục tiêu trong google analytics
		/*
		if ( _global_js_eb.gg_track( web_link + 'cart/?id=' + new_cart_id ) == true ) {
			time_to_cart = 1200;
		}
		*/
		setTimeout(function () {
			//
//				_global_js_eb.gg_track( web_link + 'cart/?id=' + new_cart_id );
			
			//
			_global_js_eb.ga_event_track( 'Add to cart', 'Product ' + new_cart_id );
		}, 200);
		
		
		
		// facebook tracking add to cart
		var track_arr = {
			'content_ids' : [ new_cart_id ]
		};
		
		if ( typeof action_obj['price'] != 'undefined' && action_obj['price'] > 0 ) {
			track_arr['value'] = action_obj['price'];
			track_arr['currency'] = 'VND';
		}
		
		//
		if ( _global_js_eb.fb_track( 'AddToCart', track_arr ) == true ) {
			time_to_cart = 1200;
		}
		
		
		// nếu có ID tự động add
		if ( typeof new_cart_auto_add_id != 'undefined' ) {
			console.log('Cart auto add');
		}
		// hoặc chuyển tới trang giỏ hàng
		else {
			console.log('Waiting redirect to cart');
			
			//
			setTimeout(function () {
				window.location = web_link + 'cart/';
//					window.location = web_link + 'cart/?id=' + new_cart_id;
			}, time_to_cart );
		}
		
	},
	
	cart_add_item : function ( new_cart_id, action_obj ) {
		
		//
		if ( typeof g_func.number_only( new_cart_id ) == 'number' ) {
			alert('Không xác định được sản phẩm');
			return false;
		}
		
		//
		if ( typeof action_obj != 'object' ) {
			action_obj = {};
		}
		
		//
		var remove_item = 0;
		if ( typeof action_obj['remove_item'] != 'undefined' ) {
			remove_item = action_obj['remove_item'];
		}
//		console.log(remove_item);
		
		var tr_id = '';
		if ( typeof action_obj['tr_id'] != 'undefined' ) {
			tr_id = action_obj['tr_id'];
		}
		
		var c = 'eb_cookie_cart_list_id',
			cart_id_in_cookie = g_func.getc( c ),
			add_cart_id = ',' + new_cart_id,
			list_cart_id = '';
		
		list_cart_id = cart_id_in_cookie == null ? '' : cart_id_in_cookie;
//		console.log(list_cart_id);
//		console.log(add_cart_id);
		
		// xóa khỏi giỏ hàng
		if ( remove_item == 1 ) {
			if ( confirm('Xác nhận xóa sản phẩm khỏi giỏ hàng') == false ) {
				return false;
			}
			
			//
			if ( list_cart_id != '' ) {
				list_cart_id = list_cart_id.replace( add_cart_id, '' );
//					console.log(list_cart_id);
				g_func.setc( c, list_cart_id, 7 );
			}
			
			//
			if ( tr_id != '' && dog(tr_id) != null ) {
				$('#' + tr_id).fadeOut().remove();
			}
			
			//
			_global_js_eb.check_null_cart();
			
			console.log('Remove cart (' + new_cart_id + ')');
			
			return false;
		}
		
		
		// thêm vào giỏ hàng
		if ( list_cart_id == '' || list_cart_id.split( add_cart_id ).length == 1 ) {
			list_cart_id += add_cart_id.toString();
			g_func.setc( c, list_cart_id, 7 );
			
			console.log('Save cart (' + new_cart_id + ')');
		} else {
			console.log('Cart exist (' + new_cart_id + ')');
		}
		
		
		
		// thời gian chuyển sang trang cart -> để mấy cái pixel tải xong đã
		var time_to_cart = 600;
		
		
		
		// google tracking add to cart -> Sử dụng chức năng Mục tiêu trong google analytics
		/*
		if ( _global_js_eb.gg_track( web_link + 'cart/?id=' + new_cart_id ) == true ) {
			time_to_cart = 1200;
		}
		*/
		setTimeout(function () {
//			_global_js_eb.gg_track( web_link + 'cart/?id=' + new_cart_id );
			_global_js_eb.ga_event_track( 'Add to cart', 'Product ' + new_cart_id );
		}, 200);
		
		
		
		// facebook tracking add to cart
		var track_arr = {
			'content_ids' : [ new_cart_id ]
		};
		
		if ( typeof action_obj['price'] != 'undefined' && action_obj['price'] > 0 ) {
			track_arr['value'] = action_obj['price'];
			track_arr['currency'] = 'VND';
		}
		
		//
		if ( _global_js_eb.fb_track( 'AddToCart', track_arr ) == true ) {
			time_to_cart = 1200;
		}
		
		
		// nếu có ID tự động add
		if ( typeof new_cart_auto_add_id != 'undefined' ) {
			console.log('Cart auto add');
			return false;
		}
		
		
		// chuyển tới trang giỏ hàng
		console.log('Waiting redirect to cart');
		
		//
		setTimeout(function () {
			window.location = web_link + 'cart/';
//			window.location = web_link + 'cart/?id=' + new_cart_id;
		}, time_to_cart );
		
		/*
		_global_js_eb.cart_func.pro_add(pid, {
			size: ($('#oi_product_size li.selected').attr('data-id') || '')
		});
		*/
	},
	
	cart_remove_item : function ( remove_id, tr_id ) {
//		alert(remove_id);
		_global_js_eb.cart_add_item( remove_id, {
			'remove_item' : 1,
			'tr_id' : tr_id
		} );
	},
	
	cpl_cart : function ( my_hd_id, my_hd_mahoadon, my_message ) {
//		alert(my_hd_id); alert(my_hd_mahoadon); return false;
		
		// xóa cookie giỏ hàng
		g_func.delck( 'eb_cookie_cart_list_id' );
		
		//
		if ( typeof my_hd_id == 'undefined' || typeof my_hd_mahoadon == 'undefined' ) {
			console.log('Lỗi chốt dữ liệu');
			return false;
		}
		
		// lưu thông tin đơn hàng để gửi đi
		g_func.setc( 'eb_cookie_order_id', my_hd_id, 7 );
//		g_func.setc( 'eb_cookie_order_sku', my_hd_mahoadon, 7 );
		
		//
//		if ( typeof my_message != 'undefined' && my_message != '' ) alert( my_message );
		
		//
		window.location = web_link + 'hoan-tat';
	},
	
	// nạp thông tin khách hàng cho giỏ hàng -> từ cookies
	cart_customer_cache : function ( f ) {
		
		// nếu không có form truyền vào -> tìm form mặc định
		if ( typeof f == 'undefined' ) {
			// nếu frm mặc định cũng không có -> lỗi
			if ( typeof document.frm_cart == 'undefined' ) {
				return false;
			}
			
			f = document.frm_cart;
		}
		
		//
		var a = function ( c ) {
				c = g_func.getc( c );
				return c == null ? '' : c;
			};
		
		if ( typeof f.t_ten != 'undefined' ) f.t_ten.value = a( 'eb_cookie_cart_name' );
		if ( typeof f.t_dienthoai != 'undefined' ) f.t_dienthoai.value = a( 'eb_cookie_cart_phone' );
		if ( typeof f.t_email != 'undefined' ) f.t_email.value = a( 'eb_cookie_cart_email' );
		if ( typeof f.t_diachi != 'undefined' ) f.t_diachi.value = a( 'eb_cookie_cart_address' );
	},
	
	// google tracking
	// https://support.google.com/adwords/answer/6331304?&hl=vi
	gg_track : function ( url ) {
		if ( typeof url == 'undefined'
		|| url == ''
		|| typeof goog_report_conversion != 'function' ) {
			return false;
		}
		console.log('Google tracking (' + url + ') by EchBay.com');
		
		//
		goog_report_conversion( url );
		
		//
		return true;
	},
	
	// google analytics tracking
	// https://developers.google.com/analytics/devguides/collection/analyticsjs/events
	ga_event_track : function ( eventCategory, eventAction, eventLabel ) {
		
		if ( typeof ga == 'undefined' ) {
			console.log('ga not found');
			return false;
		}
		
		if ( typeof goog_report_conversion == 'undefined' ) {
			return false;
		}
		
		//
		if ( typeof eventCategory == 'undefined' || eventCategory == '' ) {
			eventCategory = 'Null Category';
		}
		
		if ( typeof eventAction == 'undefined' || eventAction == '' ) {
			eventAction = 'Null Action';
		}
		
		if ( typeof eventLabel == 'undefined' || eventLabel == '' ) {
			eventLabel = document.title;
		}
		
		//
		console.log('Google analytics event tracking (' + eventAction + ') by EchBay.com');
		
		//
		ga( 'send', 'event', eventCategory + ' (EB)', eventAction, eventLabel );
		
		//
		return true;
	},
	
	// facebook dynamic remarketing
	// https://developers.facebook.com/docs/marketing-api/facebook-pixel/v2.8
	fb_track : function ( track_name, track_arr ) {
		if ( typeof track_name == 'undefined'
		|| track_name == ''
		|| typeof fbq == 'undefined'
		|| top != self ) {
			return false;
		}
		
		//
		if ( typeof track_arr != 'object' ) {
			track_arr = {};
		} else {
			// mặc định type = product
			if ( typeof track_arr['content_type'] == 'undefined' || track_arr['content_type'] == '' ) {
				track_arr['content_type'] = 'product';
			}
		}
		console.log('Facebook pixel (' + track_name + ') by EchBay.com');
		console.log( track_arr );
		
		//
		fbq('track', track_name, track_arr);
		
		//
		return true;
	}
	
};

//
//var ___eb_for_wp = _global_js_eb;

