




/*
* Các function sẽ được nạp từ theme -> nếu có thì chạy ở đây
*/
// for home
if ( act == '' ) {
	___eb_global_home_runing();
}
// end home

// archive (category/ blog)
else if ( act == 'archive' ) {
	// category
	if ( switch_taxonomy == 'category'
	|| switch_taxonomy == 'post_tag'
	|| switch_taxonomy == 'post_options' ) {
		___eb_list_post_run();
	}
	// blog
	else {
		___eb_global_blogs_runing();
	}
}
// end archive

// for details
else if ( act == 'single' ) {
	WGR_for_post_details();
	
	//
	jQuery('.wp-caption-text').each(function() {
		var a = jQuery(this).html() || '';
		if ( a != '' ) {
			jQuery(this).html( a.replace( /\\n/g, '<br>' ) );
		}
	});
}
// end details

// for contact
else if ( act == 'contact' ) {
	_global_js_eb.contact_func();
}
// end contact

// for cart
else if ( act == 'cart' ) {
	_global_js_eb.cart_func();
}
// end cart

// for 404
else if ( act == '404' ) {
	_global_js_eb.page404_func();
}
// end 404




// tạo slider cho widget
(function () {
	var i = 0;
	
	// Tạo số lượng chạy slider dựa theo kích cỡ ảnh đã được chỉ định
	if ( jQuery(window).width() > 768 ) {
		jQuery('.ebwidget-run-slider .thread-list50').attr({
			'data-visible': 2
		});
		jQuery('.ebwidget-run-slider .thread-list33').attr({
			'data-visible': 3
		});
		jQuery('.ebwidget-run-slider .thread-list25').attr({
			'data-visible': 4
		});
		jQuery('.ebwidget-run-slider .thread-list20').attr({
			'data-visible': 5
		});
	}
	
	//
	jQuery('.ebwidget-run-slider').each(function() {
		var c = 'ebwidget-run-slider' + i;
		console.log(c);
		
		jQuery(this).addClass( c );
		
		c = '.' + c;
		
		jEBE_slider( c, {
			size : jQuery( c + ' li:first .echbay-blog-avt').attr('data-size') || '',
			visible: jQuery( c + ' ul').attr('data-visible') || 1,
//			buttonListNext: false,
			autoplay: true
//		}, function () {
		} );
		
		i++;
	});
})();





// hệ thống banner quảng cáo
//___eb_logo_doitac_chantrang(6);
___eb_thread_details_timeend();
___eb_thread_list_li();
//___eb_add_space_for_breadcrumb();
//___eb_click_open_video_popup();


// fix menu khi cuộn chuột
//___eb_fix_left_right_menu();






/*
* seach advanced
*/
var url_for_advanced_search_filter = '',
	// không cho chuyển URL khi click tự động -> 1
	search_advanced_auto_click = 1;



// tạo base URL cho tìm kiếm nâng cao
function ___eb_set_base_url_for_search_advanced () {
	if ( url_for_advanced_search_filter == '' ) {
		url_for_advanced_search_filter = window.location.href.split('#')[0].split('&search_advanced=')[0].split('?search_advanced=')[0].split('/page/')[0];
		if ( url_for_advanced_search_filter.split('?').length > 1 ) {
			url_for_advanced_search_filter += '&';
		} else {
			url_for_advanced_search_filter += '?';
		}
		url_for_advanced_search_filter += 'search_advanced=1';
	}
	if ( cf_tester_mode == 1 ) console.log( url_for_advanced_search_filter );
}


function ___eb_search_advanced_get_parameter ( a ) {
	if ( typeof a == 'undefined' ) {
		return '';
	}
	
	var u = window.location.href.replace(/\?|\#|\&amp\;/g, '&');
//	console.log( u );
	
	u = u.split( '&' + a + '=' );
	
	if ( u.length > 1 ) {
		return u[1].split('&')[0];
	}
	
	return '';
}

// tạo URL bao gồm các tham số tìm kiếm và chuyển đi
function ___eb_search_advanced_go_to_url ( op ) {
	/* option mẫu
	op = {
		'price_in': '',
		'post_options': '',
		'category': ''
	}
	*/
	
	//
	if ( typeof op != 'object' ) {
		if ( cf_tester_mode == 1 ) console.log( 'option not found in URL search advanced' );
		return false;
	}
	if ( cf_tester_mode == 1 ) console.log(op);
	
	// tạo các option khác nếu chưa có
	if ( typeof op.price_in == 'undefined' ) {
		// thử lấy khoảng giá trên URL
		op.price_in = ___eb_search_advanced_get_parameter('price_in');
		
		// nếu ko có -> thử tìm theo class có sẵn
		if ( op.price_in == '' ) {
			op.price_in = jQuery('.echbay-product-price-between a.selected').attr('data-price');
		}
		if ( cf_tester_mode == 1 ) console.log( op.price_in );
	}
	if ( typeof op.category == 'undefined' || typeof op.post_options == 'undefined' ) {
		var filter_category = '',
			filter_options = '';
		jQuery('.widget-search-advanced .widget_echbay_category a.selected').each(function() {
			var tax = jQuery(this).attr('data-taxonomy') || '',
				j = jQuery(this).attr('data-id') || 0;
			
			if ( tax == 'category' ) {
				filter_category += ',' + j;
			}
			else if ( tax == 'post_options' ) {
				filter_options += ',' + j;
			}
//			console.log( filter_category );
//			console.log( filter_options );
		});
		
		//
		op.category = filter_category;
		op.post_options = filter_options;
	}
	
	//
	var new_url = url_for_advanced_search_filter;
	
	if ( typeof op.price_in != 'undefined' && op.price_in != '' ) {
		new_url += '&price_in=' + op.price_in;
	}
	if ( typeof op.category != 'undefined' && op.category != '' ) {
		if ( op.category.substr( 0, 1 ) == ',' ) {
			op.category = op.category.substr(1);
		}
		
		new_url += '&filter_cats=' + op.category;
	}
	if ( typeof op.post_options != 'undefined' && op.post_options != '' ) {
		if ( op.post_options.substr( 0, 1 ) == ',' ) {
			op.post_options = op.post_options.substr(1);
		}
		
		new_url += '&filter=' + op.post_options;
	}
	if ( cf_tester_mode == 1 ) console.log( new_url );
	
	//
//	return false;
	
	//
	if ( new_url == '' ) {
		if ( cf_tester_mode == 1 ) console.log( 'new_url not found in URL search advanced' );
		return false;
	}
	
	//
	if ( cf_search_advanced_auto_submit == 1 ) {
		window.location = new_url;
	} else {
		jQuery('.click-to-search-advanced').attr({
			href : new_url
		}).css({
			display : 'inline-block'
		});
	}
}



// tự động đánh dấu các thuộc tính đang được chọn
function ___eb_auto_click_for_search_advanced ( clat, a ) {
//	console.log(a);
	
	//
	for ( var i = 0; i < a.length; i++ ) {
		a[i] = g_func.only_number( a[i] );
		
		if ( a[i] > 0 ) {
			
			// cho thẻ A
			jQuery(clat + ' a[data-id="' + a[i] + '"]').click();
			
			// ẩn nút tạo link đi -> vì đây chỉ tự động check
			jQuery('.click-to-search-advanced').hide();
			
		}
	}
}



// tìm theo khoảng giá
function ___eb_set_url_for_search_price_in_button ( clat ) {
	
	// chỉ tìm ở trang danh sách sản phẩm
	if ( typeof switch_taxonomy == 'undefined' || switch_taxonomy != 'category' ) {
		if ( cf_tester_mode == 1 ) console.log('search price is active, but run only category page -> STOP.');
	}
	
	//
	if ( typeof clat == 'undefined' || clat == '' ) {
		clat = '.echbay-product-price-between';
	}
	
	// nếu không có class này thì hủy chức năng luôn
	if ( jQuery(clat).length == 0 ) {
		if ( cf_tester_mode == 1 ) console.log('search price is active, but element ' + clat + ' not found -> STOP.');
		return false;
	}
	
	//
	___eb_set_base_url_for_search_advanced();
	
	// nếu có -> tìm vào dựng URL choc ác thẻ A
	/*
	if ( cf_search_advanced_auto_submit == 1 ) {
		jQuery(clat + ' a').each(function() {
			var a = jQuery(this).attr('data-price') || '';
			
			if ( a != '' ) {
				jQuery(this).attr({
					href : url_for_advanced_search_filter + '&price_in=' + a
				});
			}
			else {
				jQuery(this).attr({
					href : url_for_advanced_search_filter
				});
			}
		});
	}
	else {
		*/
		jQuery(clat + ' a').click(function() {
			jQuery(clat + ' a').removeClass('selected');
			jQuery(this).addClass('selected');
			
			//
			var a = jQuery(this).attr('data-price') || '';
			
			//
			jQuery('.echbay-widget-price-title div').html( jQuery(this).html() );
			
			___eb_search_advanced_go_to_url( {
				'price_in': a
			} );
			
			return false;
//		}).attr({
		});
//	}
	
	//
//	jQuery(clat + ' a:first').before( '<li><a href="' + eb_this_current_url + '">Tất cả khoảng giá</a></li>' );
	
	// hiển thị giá đang lọc theo URL
	var a = ___eb_search_advanced_get_parameter('price_in');
	if ( a != '' ) {
		jQuery('.echbay-widget-price-title div').html( jQuery('.echbay-product-price-between a[data-price="' + a + '"]').html() );
	}
	
}
___eb_set_url_for_search_price_in_button();




// tìm theo thuộc tính
function ___eb_set_url_for_search_advanced_button ( clat, inner_clat, go_to_url ) {
	
	// hiển thị nút go to nếu go_to_url = false, mặc định là nhảy URL luôn
	/*
	if ( typeof go_to_url == 'undefined' ) {
		if ( cf_search_advanced_auto_submit == 1 ) {
			go_to_url = true;
		}
		else {
			go_to_url = false;
		}
	}
	*/
	
	// chỉ tìm ở trang danh sách sản phẩm
	if ( typeof switch_taxonomy == 'undefined' || switch_taxonomy != 'category' ) {
		if ( cf_tester_mode == 1 ) console.log('search advanced is active, but run only category page -> STOP.');
		return false;
	}
	
	//
	if ( typeof clat == 'undefined' || clat == '' ) {
		clat = '.widget-search-advanced .widget_echbay_category';
	}
	
	//
	if ( jQuery(clat).length == 0 ) {
		if ( cf_tester_mode == 1 ) console.log('search advanced is active, but element ' + clat + ' not found -> STOP.');
		return false;
	}
//	console.log(jQuery(clat).length);
	console.log('set search advanced multi (v2) for ' + clat);
	
	// tạo nút tìm kiếm nếu chưa có
	if ( jQuery(clat + ' a.click-to-search-advanced').length == 0 ) {
		if ( typeof inner_clat == 'undefined' || inner_clat == '' ) {
			inner_clat = '.widget-search-advanced';
		}
		jQuery(inner_clat).append( '<div class="global-button-for-seach-advanced"><a href="javascript:;" class="click-to-search-advanced search-advanced-btn d-none whitecolor"><i class="fa fa-search"></i> <span>Lọc sản phẩm</span></a></div>' );
	}
	
	//
	___eb_set_base_url_for_search_advanced();
	
	// Tạo thẻ xem tất cả sản phẩm
//	if ( jQuery(clat + ' ul').length > 0 ) {
		jQuery(clat + ' ul').each(function() {
			var data_node_id = jQuery('li:first a', this).attr('data-node-id') || '';
			
			//
			if ( data_node_id != '' ) {
				var data_parent = jQuery('li:first a', this).attr('data-parent') || 0,
					text = jQuery('#' + data_node_id + ' .echbay-widget-title div').html() || '';
				
				//
				if ( text != '' ) {
					text = 'Tất cả ' + text;
					
					jQuery('li:first', this).before('<li style="order:9999999999;"><div><a data-parent="' + data_parent + '" data-node-id="' + data_node_id + '" title="' + text + '" href="javascript:;">' + text + '</a></div></li>');
				}
			}
		});
//	}
	
	//
	jQuery(clat + ' a').each(function() {
		var tax = jQuery(this).attr('data-taxonomy') || '';
		
		//
		if ( tax != 'category' ) {
			jQuery(this).attr({
				'data-href' : jQuery(this).attr('data-href') || jQuery(this).attr('href') || 'javascript:;',
				'href' : 'javascript:;'
			});
		}
//	}).attr({
//		'href' : 'javascript:;'
	}).off('click').click(function () {
		var cha = jQuery(this).attr('data-parent') || 0,
			con = jQuery(this).attr('data-id') || 0,
			filter_category = '',
			filter_options = '',
			node_id = jQuery(this).attr('data-node-id') || '',
			this_tax = jQuery(this).attr('data-taxonomy') || '';
		
		//
		if ( node_id != '' ) {
			node_id = '#' + node_id + ' .echbay-widget-title div';
			
			jQuery(node_id).html( jQuery(this).attr('title') || '' );
		}
		
		//
		jQuery(clat + ' a[data-parent="' + cha + '"]').removeClass('selected');
		
		// Chỉ add class select cho nhóm con, không add cho nhóm tất cả
		if ( con != 0 ) {
			jQuery(this).addClass('selected');
		}
		
		
		// nếu là auto click -> chỉ cần set class selected cho thuộc tính thôi
		if ( search_advanced_auto_click == 1 ) {
			return false;
		}
		// nếu là category -> chuyển URL luôn
		else if ( this_tax == 'category' ) {
			if ( cf_tester_mode == 1 ) console.log('search advanced not run if taxonomy == category');
			return true;
		}
		
		
		//
		jQuery(clat + ' a.selected').each(function() {
			var tax = jQuery(this).attr('data-taxonomy') || '',
				j = jQuery(this).attr('data-id') || 0;
			
			if ( tax == 'category' ) {
				filter_category += ',' + j;
			}
			else if ( tax == 'post_options' ) {
				filter_options += ',' + j;
			}
//			console.log( filter_category );
//			console.log( filter_options );
		});
		
		//
		___eb_search_advanced_go_to_url( {
			'post_options': filter_options,
			'category': filter_category
		} );
		
		// V1
		/*
		var new_url = '';
		// category -> chuyển link luôn -> bỏ qua phần search nâng cao ở đây
		if ( filter_category != '' ) {
			new_url += '&filter_cats=' + filter_category.substr( 1 );
		}
		if ( filter_options != '' ) {
			new_url += '&filter=' + filter_options.substr( 1 );
		}
		if ( cf_tester_mode == 1 ) console.log( url_for_advanced_search_filter + new_url );
		
		// nếu lệnh chuyển URL chuyển URL
		if ( go_to_url == true ) {
			window.location = url_for_advanced_search_filter + new_url;
		} else {
			jQuery('.click-to-search-advanced').attr({
				href : url_for_advanced_search_filter + new_url
			}).css({
				display : 'inline-block'
			});
		}
		*/
		
		//
		return false;
	});
	
	
	// không cho chuyển URL khi click tự động
//	search_advanced_auto_click = 1;
	
	// đanh dấu dữ liệu cũ đã được chọn
	if ( seach_advanced_value != '' ) {
		___eb_auto_click_for_search_advanced( clat, seach_advanced_value.split(',') );
	}
	if ( seach_advanced_value != '' ) {
		___eb_auto_click_for_search_advanced( clat, seach_advanced_by_cats.split(',') );
	}
	if ( cid > 0 ) {
		___eb_auto_click_for_search_advanced( clat, [cid] );
	}
	
	// reset lại lệnh -> cho phép chuyển link
	search_advanced_auto_click = 0;
	
}
___eb_set_url_for_search_advanced_button();


// thuộc tính mở rộng khung tìm kiếm
(function () {
	jQuery('.span-search-icon').click(function () {
		var a = jQuery(this).attr('data-active') || '';
		
		if ( a != '' ) {
			jQuery('.' + a + ' .div-search').toggleClass('active');
			jQuery('.' + a + ' input[type="search"]').focus();
		}
	});
})();



// nhảy đến 1 ID đã được xác định (tương tự như thẻ A name)
(function () {
	jQuery('a').each(function() {
		var a = jQuery(this).attr('href') || '';
//		console.log(a);
		
		if ( a != '' ) {
			// Chế độ nhảy đến link
			if ( a.substr( 0, 1 ) == '#' ) {
//				console.log(a);
				a = a.split('#')[1];
				
				if ( a != '' ) {
					jQuery(this).on('click', function () {
						var goto = 0;
						if ( jQuery('.' + a).length > 0 ) {
							goto = jQuery('.' + a).offset().top;
						}
						else if ( jQuery('#' + a).length > 0 ) {
							goto = jQuery('#' + a).offset().top;
						}
						else if ( jQuery('a[name="' + a + '"]').length > 0 ) {
							goto = jQuery('a[name="' + a + '"]').offset().top;
						}
						
						if ( goto > 90 ) {
//							window.scroll( 0, goto - 110 );
							jQuery('body,html').animate({
								scrollTop: goto - 110
							}, 800);
							
							window.location.hash = a;
							
							return false;
						}
					});
				}
			}
			else if ( a.split('//').length > 1 ) {
				a = a.split('//')[1].split('/')[0];
				
				if ( a != document.domain ) {
					jQuery(this).attr({
						target: '_blank',
						rel: ' nofollow'
					});
				}
			}
		}
	});
	
	
	jQuery('.ebe-currency-format').each(function() {
		var a = jQuery(this).attr('data-num') || '';
		
		if ( a != '' ) {
			jQuery(this).html( g_func.money_format( a ) );
		}
	});
})();



// đánh dấu sản phẩm yêu thích
function WGR_click_add_product_to_favorite () {
	var cookie_name = 'wgr_product_id_user_favorite',
		limit_save = 30;
	
	//
	var str_favorite = g_func.getc(cookie_name);
	if ( str_favorite == null || str_favorite == '' ) {
		str_favorite = '';
	}
	
	// Khi người dùng bấm vào lưu sản phẩm yêu thích
	jQuery('.add-to-favorite').click(function() {
		var a = jQuery(this).attr('data-id') || pid;
		var b = ___wgr_set_product_id_cookie( cookie_name, a, 50, limit_save );
		
		// nếu add không thành công -> đã có -> xóa sản phẩm khỏi favorite
		if ( b == false ) {
//			jQuery(this).removeClass('selected');
//			jQuery('.add-to-favorite[data-id="' + a + '"]').removeClass('selected').removeClass('fa-heart').addClass('fa-heart-o');
			jQuery('.add-to-favorite[data-id="' + a + '"]').removeClass('selected');
			
			// lấy lại cookie
			b = g_func.getc(cookie_name);
			
			// không có thì thoát luôn
			if ( b == null || b == '' ) {
				return false;
			}
			
			// có thì xóa khỏi cookie luôn
			b = b.replace('[' + a + ']', '');
//			console.log(str_favorite);
			g_func.setc(cookie_name, b, 0, limit_save);
		}
		// nếu không -> thêm class đánh dấu cho sản phẩm vừa chọn
		else {
//			jQuery(this).addClass('selected');
//			jQuery('.add-to-favorite[data-id="' + a + '"]').addClass('selected').removeClass('fa-heart-o').addClass('fa-heart');
			jQuery('.add-to-favorite[data-id="' + a + '"]').addClass('selected');
		}
		
		// nếu người dùng đang đăng nhập
		if ( isLogin > 0 ) {
			// lưu cookie vào database cho người dùng
//			ajaxl('');
		}
	});
	
	//
	if ( str_favorite == '' ) {
		return false;
	}
	var check_favorite = str_favorite.split('][');
//	console.log(check_favorite);
	
	// chạy vòng lặp và tạo hiệu ứng select cho các sản phẩm đã lưu
	for ( var i = 0; i < check_favorite.length; i++ ) {
		check_favorite[i] = check_favorite[i].replace(/\[|\]/, '');
//		check_favorite[i] = parseInt( check_favorite[i], 10 );
//		console.log(check_favorite[i]);
		
		//
//		jQuery('.add-to-favorite[data-id="' + check_favorite[i] + '"]').addClass('selected').removeClass('fa-heart-o').addClass('fa-heart');
		jQuery('.add-to-favorite[data-id="' + check_favorite[i] + '"]').addClass('selected');
	}
}
WGR_click_add_product_to_favorite();



//
/*
if ( jQuery('.quick-register-email').length > 0 ) {
	jQuery('form[name="frm_dk_nhantin"] input[name="t_email"]').click(function() {
		_global_js_eb.add_primari_iframe();
	});
}
*/



// social function /////////////////////////////////////////////////////////////////


// remove function
function ___eb_add_href_for_fb () {
	console.log( '___eb_add_href_for_fb has been remove' );
}
function ___eb_load_social_module () {
	console.log( '___eb_load_social_module has been remove' );
}



// chức năng thêm khung chat của fb vào web, sử dụng thì bỏ comment hàm gọi function đi là được
function add_fb_messages_for_page () {
	// thêm style cho khung chat
	jQuery('body').append('\
	<div id="cfacebook"> <a href="javascript:;" class="chat_fb"><i class="fa fa-facebook-square"></i> Hỗ trợ trực tuyến</a>\
		<div class="fchat each-to-facebook">\
			<div class="fb-page" data-tabs="messages" data-href="" data-width="250" data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>\
		</div>\
	</div>');
	
	//
	jQuery(".chat_fb").click(function() {
		jQuery('.fchat').toggle('slow');
	});
}
//add_fb_messages_for_page();


// module mạng xã hội add xuống cuối file để ưu tiên giao diện chính của web được chạy trước


// tạo href cho facebook
(function () {
	
	var f = function(lnk, clat) {
			if (lnk != '') {
				jQuery('.' + clat + ' div').attr({
					'data-href': lnk
				}).each(function() {
					var w = jQuery(this).attr('data-width') || jQuery(this).width() || 0;
					if ( w == 0 ) {
						w = 180;
					} else {
						w = Math.ceil(w) - 1;
					}
					
					jQuery(this).attr({
//						'data-href': lnk,
						'data-width': w
					});
				});
			}
		},
		al = function(lnk, clat) {
			if (lnk != '') {
				jQuery('.' + clat).attr({
					href: lnk
					/*
				}).each(function() {
					jQuery(this).attr({
						href: lnk
					});
					*/
				});
			}
		};
	
	// data-href
	f(cf_facebook_page, 'each-to-facebook');
	f(cf_google_plus, 'each-to-gooplus');
	// href
	al(cf_facebook_page, 'ahref-to-facebook');
	al(cf_instagram_page, 'ahref-to-instagram');
	al(cf_google_plus, 'ahref-to-gooplus');
	al(cf_youtube_chanel, 'each-to-youtube-chanel');
	al(cf_twitter_page, 'each-to-twitter-page');
	
})();





// load các module mạng xã hội
(function () {
	
	jQuery(document).ready(function() {
		window.___gcfg = {
			lang: 'vi'
		};
		
		/*
		* G+ button
		*/
		var po = document.createElement('script');
		po.type = 'text/javascript';
		po.async = true;
		po.src = 'https://apis.google.com/js/platform.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(po, s);
		
		
		/*
		* G+ Comment
		*/
		jQuery('.g-comments').each(function() {
			jQuery(this).attr({
				'data-width' : jQuery(this).width()
			});
		});
		
		//
		if ( jQuery('.g-comments').length > 0 ) {
			po = document.createElement('script');
			po.type = 'text/javascript';
	//		po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(po, s);
		}
		
		
		
		if ( __global_facebook_id != '' ) {
			
			//
			if ( cf_tester_mode == 1 ) console.log( 'FB app ID: ' + __global_facebook_id );
			
			// căn lại chiều rộng cho fb plugin
			jQuery('.fb-like, .fb-comments').each(function () {
				jQuery(this).attr({
					'data-width' : Math.ceil( jQuery(this).width() || 250 )
				});
			});
			
			
			//
			var fb_src = (function() {
				var lang = jQuery('html').attr('lang') || navigator.language || navigator.userLanguage || '';
				if (lang != '') {
					lang = lang.split('_')[0].split('-')[0].toLowerCase();
//					console.log( lang );
					if (lang == 'vi') {
						return 'vi_VN';
					}
				}
				return 'en_US';
			})();
//			console.log( fb_src );
			
			//
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/" + fb_src + "/sdk.js#xfbml=1&version=v2.9&appId=" + __global_facebook_id;
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			
			
			
			//
			/*
			window.fbAsyncInit = function() {
				FB.init({
					appId: __global_facebook_id,
					xfbml: true,
					version: 'v2.0'
				});
			};
			
			
			//
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {
					return;
				}
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/" + fb_src + "/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			*/
		}
	
	});
	
})();

// end social function /////////////////////////////////////////////////////////////////







// Thêm link bản quyền cho theme
jQuery('.powered-by-echbay a').attr({
	href: 'https://www.echbay.com/'
});

// kiểm tra phiên bản HTML mới hay cũ
setTimeout(function () {
//	if ( jQuery('title').length != 1 ) {
	if ( jQuery('head title').length != 1 ) {
		alert('Lỗi HTML! vui lòng kiểm tra lại (HTML ERROR!)');
		console.log('Reinstall theme or call to +84984533228');
	}
}, 1200);





// xử lý với video youtube
___eb_click_open_video_popup();




//
//jQuery('.fa').addClass('fas').removeClass('fa');



