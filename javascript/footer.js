





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
}



// tự động đánh dấu các thuộc tính đang được chọn
function ___eb_auto_click_for_search_advanced ( clat, a ) {
//	console.log(a);
	
	//
	for ( var i = 0; i < a.length; i++ ) {
		a[i] = g_func.only_number( a[i] );
		
		if ( a[i] > 0 ) {
			
			// cho thẻ A
			$(clat + ' a[data-id="' + a[i] + '"]').click();
			
			// ẩn nút tạo link đi -> vì đây chỉ tự động check
			$('.click-to-search-advanced').hide();
			
		}
	}
}



// tìm theo khoảng giá
function ___eb_set_url_for_search_price_in_button ( clat ) {
	
	// chỉ tìm ở trang danh sách sản phẩm
	if ( typeof switch_taxonomy == 'undefined' || switch_taxonomy != 'category' ) {
		console.log('search price is active, but run only category page -> STOP.');
	}
	
	//
	if ( typeof clat == 'undefined' || clat == '' ) {
		clat = '.echbay-product-price-between';
	}
	
	// nếu không có class này thì hủy chức năng luôn
	if ( $(clat).length == 0 ) {
		console.log('search price is active, but element ' + clat + ' not found -> STOP.');
		return false;
	}
	
	//
	___eb_set_base_url_for_search_advanced();
	
	// nếu có -> tìm vào dựng URL choc ác thẻ A
	$(clat + ' a').each(function() {
		var a = $(this).attr('data-price') || '';
		
		if ( a != '' ) {
			$(this).attr({
				href : url_for_advanced_search_filter + '&price_in=' + a
			});
		}
		else {
			$(this).attr({
				href : url_for_advanced_search_filter
			});
		}
	});
	
	//
//	$(clat + ' a:first').before( '<li><a href="' + eb_this_current_url + '">Tất cả khoảng giá</a></li>' );
	
}
___eb_set_url_for_search_price_in_button();




// tìm theo thuộc tính
function ___eb_set_url_for_search_advanced_button ( clat, inner_clat, go_to_url ) {
	
	// hiển thị nút go to nếu go_to_url = false, mặc định là nhảy URL luôn
	if ( typeof go_to_url == 'undefined' ) {
		go_to_url = true;
	}
	
	// chỉ tìm ở trang danh sách sản phẩm
	if ( typeof switch_taxonomy == 'undefined' || switch_taxonomy != 'category' ) {
		console.log('search advanced is active, but run only category page -> STOP.');
	}
	
	//
	if ( typeof clat == 'undefined' || clat == '' ) {
		clat = '.widget-search-advanced .widget_echbay_category';
	}
	
	//
	if ( $(clat).length == 0 ) {
		console.log('search advanced is active, but element ' + clat + ' not found -> STOP.');
		return false;
	}
//	console.log($(clat).length);
	console.log('set search advanced multi (v2) for ' + clat);
	
	// tạo nút tìm kiếm nếu chưa có
	if ( $(clat + ' a.click-to-search-advanced').length == 0 ) {
		if ( typeof inner_clat == 'undefined' || inner_clat == '' ) {
			inner_clat = '.widget-search-advanced';
		}
		$(inner_clat).append( '<div class="global-button-for-seach-advanced"><a href="javascript:;" class="click-to-search-advanced search-advanced-btn d-none fa fa-search whitecolor"> </a></div>' );
	}
	
	//
	___eb_set_base_url_for_search_advanced();
	
	//
	$(clat + ' a').each(function() {
		var tax = $(this).attr('data-taxonomy') || '';
		
		//
		if ( tax != 'category' ) {
			$(this).attr({
				'data-href' : $(this).attr('data-href') || $(this).attr('href') || 'javascript:;',
				'href' : 'javascript:;'
			});
		}
//	}).attr({
//		'href' : 'javascript:;'
	}).off('click').click(function () {
		var cha = $(this).attr('data-parent') || 0,
			filter_category = '',
			filter_options = '',
			node_id = $(this).attr('data-node-id') || '',
			this_tax = $(this).attr('data-taxonomy') || '';
		
		//
		if ( node_id != '' ) {
			node_id = '#' + node_id + ' .echbay-widget-title div';
			
			$(node_id).html( $(this).attr('title') || '' );
		}
		
		//
		$(clat + ' a[data-parent="' + cha + '"]').removeClass('selected');
		$(this).addClass('selected');
		
		
		// nếu là auto click -> chỉ cần set class selected cho thuộc tính thôi
		if ( search_advanced_auto_click == 1 ) {
			return false;
		}
		// nếu là category -> chuyển URL luôn
		else if ( this_tax == 'category' ) {
			return true;
		}
		
		
		//
		$(clat + ' a.selected').each(function() {
			var tax = $(this).attr('data-taxonomy') || '',
				j = $(this).attr('data-id') || 0;
			
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
		var new_url = '';
		/* category -> chuyển link luôn -> bỏ qua phần search nâng cao ở đây
		if ( filter_category != '' ) {
			new_url += '&filter_cats=' + filter_category.substr( 1 );
		}
		*/
		if ( filter_options != '' ) {
			new_url += '&filter=' + filter_options.substr( 1 );
		}
//		console.log( url_for_advanced_search_filter + new_url );
		
		// nếu lệnh chuyển URL chuyển URL
		if ( go_to_url == true ) {
			window.location = url_for_advanced_search_filter + new_url;
		} else {
			$('.click-to-search-advanced').attr({
				href : url_for_advanced_search_filter + new_url
			}).css({
				display : 'inline-block'
			});
		}
		
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
	$('body').append('\
	<div id="cfacebook"> <a href="javascript:;" class="chat_fb"><i class="fa fa-facebook-square"></i> Hỗ trợ trực tuyến</a>\
		<div class="fchat each-to-facebook">\
			<div class="fb-page" data-tabs="messages" data-href="" data-width="250" data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>\
		</div>\
	</div>');
	
	//
	$(".chat_fb").click(function() {
		$('.fchat').toggle('slow');
	});
}
//add_fb_messages_for_page();


// module mạng xã hội add xuống cuối file để ưu tiên giao diện chính của web được chạy trước


// tạo href cho facebook
(function () {
	
	var f = function(lnk, clat) {
			if (lnk != '') {
				$('.' + clat + ' div').each(function() {
					var w = $(this).attr('data-width') || $(this).width() || 0;
					if ( w > 0 ) {
						w = Math.ceil(w) - 1;
						$(this).attr({
							'data-width': w,
							'data-href': lnk
						});
					}
				});
			}
		},
		al = function(lnk, clat) {
			if (lnk != '') {
				$('.' + clat).each(function() {
					$(this).attr({
						href: lnk
					});
				});
			}
		};
	
	// data-href
	f(cf_facebook_page, 'each-to-facebook');
	f(cf_google_plus, 'each-to-gooplus');
	// href
	al(cf_facebook_page, 'ahref-to-facebook');
	al(cf_google_plus, 'ahref-to-gooplus');
	al(cf_youtube_chanel, 'each-to-youtube-chanel');
	al(cf_twitter_page, 'each-to-twitter-page');
	
})();





// load các module mạng xã hội
(function () {
	
	$(document).ready(function() {
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
		$('.g-comments').each(function() {
			$(this).attr({
				'data-width' : $(this).width()
			});
		});
		
		//
		if ( $('.g-comments').length > 0 ) {
			var po = document.createElement('script');
			po.type = 'text/javascript';
	//		po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(po, s);
		}
		
		
		
		if (__global_facebook_id != '') {
			// căn lại chiều rộng cho fb plugin
			$('.fb-like, .fb-comments').each(function () {
				$(this).attr({
					'data-width' : $(this).width() || 250
				});
			});
			
			
			//
			var fb_src = $('html').attr('lang') || (function(lang) {
				if (lang != '') {
					lang = lang.split('_')[0].split('-')[0].toLowerCase();
					if (lang == 'vi') {
						return 'vi_VN';
					}
				}
				return 'en_US';
			})(navigator.language || navigator.userLanguage || '');
			
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






