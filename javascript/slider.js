


var jEBE_slider_cache_option = {},
	jEBE_slider_dang_scroll = false;

/*
* jd: ID hoặc class của thẻ HTML cần tạo slider. Ví dụ: .slider1, #slider2
*
*
* conf: cấu hình riêng cho slider, các cấu hình mặc định sẽ được thiết lập nếu không có cấu hình cụ thể
* Danh sách các cấu hình:
*
// tự động chạy (true|false) nếu được set là true (mặc định false)
autoplay: true
// hiển thị nút bấm chuyển ảnh (true|false) nếu được set là true (mặc định true)
buttonListNext: true
// kích thước cố định (mặc định là tự động tính theo tham số size bên dưới)
width: 1
height: 1
// tỷ lệ giữa chiều cao và chiều rộng, thiets lập dưới dạng: height/width (thay height và width bằng các con số cụ thể)
size: "width/height"
// thiết lập chiều cao dòng cho phần slider (ít khi sử dụng vì nó sẽ được tự động tính toán)
lineHeight: ""
// ẩn (true|false) nếu không có LI nào được tìm thấy trong slider (mặc định false)
hide_if_null: true
// mặc định là điều khiển các thẻ LI làm slider, nếu muốn thẻ khác hãy đặt theo class hoặc ID. Ví dụ: .node1, #node2
for_class: li
// Nút bấm chuyển ảnh trên slider (true|false) (mặc định false)
sliderArrow: true
// Icon cho nút bấm, sử dụng Font Awesome: http://fontawesome.io/icons/
sliderArrowLeft: "fa-angle-left"
sliderArrowRight: "fa-angle-right"
// Kích thước cho nút bấm (font-size), tính theo pixel (px)
sliderArrowSize: 30
// Chiều rộng cố định cho nút bấm (mặc định là tự động thiết lập)
sliderArrowWidthLeft: "auto"
sliderArrowWidthRight: "auto"
speed: 0
speedNext: 5000
thumbnail: false
thumbnailHeight: 90
thumbnailSlider: true
thumbnailWidth: 90
// Số lượng thẻ LI muốn hiển thị trên mỗi loạt slider
visible: 1
*
*
*
* callBack: function sẽ được chạy sau khi tạo slider xong, thường dùng để xử lý các chức năng riêng ngoài việc tạo slider mặc định
*/
function jEBE_multi_slider ( jd, conf, callBack ) {
	
	if ( typeof conf != 'object' ) {
		conf = {};
	}
	
	//
	if ( typeof callBack != 'function' ) {
		callBack = null;
	}
	
	jd = jd.split( ',' );
	
	for ( var i = 0; i < jd.length; i++ ) {
		jEBE_slider ( jQuery.trim( jd[i] ), conf, callBack );
	}
	
}

function jEBE_slider ( jd, conf, callBack ) {
	
	//
	if ( typeof callBack != 'function' ) {
		callBack = null;
	}
	
	// kiểm tra và nạp jQuery
	if ( typeof jQuery != 'function' ) {
		console.log('jQuery not found');
		return false;
	}
	if ( typeof $ != 'function' ) {
		$ = jQuery;
	}
	
	//
	if ( typeof jd == 'undefined' || jd == '' || jQuery(jd).length == 0 ) {
		if ( cf_tester_mode == 1 ) console.log( 'jEBE_slider! ' + jd + ' not found' );
		return false;
	}
	if ( cf_tester_mode == 1 ) console.log('jEBE_slider! Create slider ' + jd);
	var jd_class = 'child-' + jd.substr( 1 ).replace( /\.|\#|\s/g, '-' );
	var jd_to_class = '.' + jd_class;
	
	
	if ( typeof conf != 'object' ) {
		conf = {};
	}
	
	
	// config mặc định
	var set_default_conf = function ( k, v ) {
		if ( typeof conf[k] == 'undefined' ) {
			conf[k] = v;
		}
	};
	var get_thumbnail = function ( img ) {
		if ( typeof ___eb_set_img_to_thumbnail == 'function' ) {
			return ___eb_set_img_to_thumbnail( img );
		}
		return img;
	};
	var remove_thumbnail = function ( img ) {
		if ( typeof ___eb_set_thumb_to_fullsize == 'function' ) {
			return ___eb_set_thumb_to_fullsize( img );
		}
		return img;
	};
	/*
	var inner_css = function ( str ) {
		if ( document.getElementById('jEBE_slider_css') == null ) {
//			jQuery('head').append('<style id="jEBE_slider_css"></style>');
			jQuery('link').after('<style id="jEBE_slider_css"></style>');
		}
		
		if ( typeof str == 'undefined' || str == '' ) {
			return false;
		}
		str = str.split("\n");
		var new_str = '';
		for ( var i = 0; i < str.length; i++ ) {
			str[i] = jQuery.trim( str[i] );
			if ( str[i] != '' ) {
				new_str += str[i] + "\n";
			}
		}
		
		jQuery('#jEBE_slider_css').append( jQuery.trim( new_str ) );
	};
	*/
	
	// mặc định là ẩn nếu không có LI nào
	set_default_conf( 'hide_if_null', true );
	set_default_conf( 'for_class', 'li' );
	
	// kích thước
	set_default_conf( 'width', 1 );
	set_default_conf( 'height', 1 );
	// tỷ lệ giữa chiều cao và chiều rộng
	set_default_conf( 'size', conf['height'] + '/' + conf['width'] );
	
	// tự động chạy
	set_default_conf( 'autoplay', false );
	// tốc độ chuyển slide ( mini giây )
	set_default_conf( 'speed', 0 );
	if ( conf['speed'] > 0 ) {
		conf['speed'] = conf['speed']/ 1000;
	}
	// giãn cách chuyển slide (mini giây)
	set_default_conf( 'speedNext', 5000 );
	
	// nút bấm chuyển ảnh
	set_default_conf( 'buttonListNext', true );
	
	// thumbnail -> vì là lấy hình ảnh làm thumbnail -> cần class chứa URL ảnh (src hoặc data-img)
	set_default_conf( 'thumbnail', false );
	set_default_conf( 'thumbnailSlider', true );
	// kích thước của thumbnail
	set_default_conf( 'thumbnailWidth', 90 );
	set_default_conf( 'thumbnailHeight', conf['thumbnailWidth'] );
	
	// Số LI hiển thị một lúc
	set_default_conf( 'visible', 1 );
	
	// Bấm chuyển ảnh trên slider
	set_default_conf( 'sliderArrow', false );
	// nút bấm
	set_default_conf( 'sliderArrowLeft', 'fa-angle-left' );
	set_default_conf( 'sliderArrowRight', 'fa-angle-right' );
	// font-size
	set_default_conf( 'sliderArrowSize', 30 );
	// Kích thước nút bấm slider
	set_default_conf( 'sliderArrowWidthLeft', 'auto' );
	set_default_conf( 'sliderArrowWidthRight', 'auto' );
	
	// conf['sliderArrow']
	if ( cf_tester_mode == 1 ) {
		console.log( jd );
		console.log( conf );
	}
	
	
	// kiểm tra có li nào ở trong không
	var len = jQuery(jd + ' ' + conf['for_class']).length || 0;
//	console.log( len );
	if ( len == 0 ) {
		if ( conf['hide_if_null'] == true ) {
			jQuery(jd).hide();
		}
		if ( cf_tester_mode == 1 ) console.log( 'slider has been STOP by LI length it zero' );
		return false;
	}
	
	
	// chiều cao cho slide
	var wit = jQuery(jd).width(),
		hai = '';
	
	// thêm chức năng cho chiều cao tự động (auto)
	if ( conf['size'] == '' ) {
		hai = jQuery(jd + ' li:first').height();
	}
	else if ( conf['size'] == 'auto' ) {
		// Nếu có class auto resize -> trước đó bị hàm khác chặn mất rồi -> add lại class mới để xử lý
		if ( jQuery(jd + ' .auto-size').length > 1 ) {
			jQuery(jd + ' .auto-size').addClass('ti-le-global').removeClass('auto-size');
		}
		
		// Nếu có nhiều hơn 1 ảnh -> tìm size thật
		if ( jQuery(jd + ' .ti-le-global').length > 1 ) {
			// xóa class để không cho nó còn được resize nữa
			jQuery(jd + ' .ti-le-global').addClass('ti-le-global-xoa').removeClass('ti-le-global');
			
			// lấy ảnh đầu tiên của slider -> ưu tiên ảnh mobile trước -> load cho nhẹ và nhanh
			var get_img_size = jQuery(jd + ' li:first .ti-le-global').attr('data-mobile-img') || jQuery(jd + ' li:first .ti-le-global').attr('data-table-img') || jQuery(jd + ' li:first .ti-le-global').attr('data-img') || '';
			console.log(get_img_size);
			
			//
			var new_jd = jd.replace( /\.|\#/g, '_' );
			jQuery(jd + ' li:first .ti-le-global').html('<img src="' + get_img_size + '" id="' + new_jd + '" width="' + wit + '" data-class="' + jd + '" />');
			
			jQuery('#' + new_jd).on('load', function () {
				console.log('TESTTTTTTTTTTTTTTTTTTTTT! add function for slider');
			});
			
//			jEBE_slider ( jd, conf, callBack );
		}
		
		// thoát luôn
		if ( cf_tester_mode == 1 ) console.log( 'slider has been RETURN size = auto' );
		
		//
		if ( typeof callBack == 'function' ) {
			if ( cf_tester_mode == 1 ) console.log(' call to callBack function before return');
			callBack();
		}
		
		//
		return false;
	}
	// lấy theo kích thước màn hình
	else if ( conf['size'] == 'full' ) {
		hai = jQuery(window).height();
		
		// thêm class khẳng định full size theo màn hình
		jQuery(jd).addClass('slider-window-size');
	}
	else {
		hai = wit * eval( conf['size'] )/ conf['visible'] - 1;
	}
	
	set_default_conf( 'lineHeight', hai + 'px' );
	
	jQuery(jd).height( hai ).attr({
		'data-size' : conf['size']
	}).css({
		'line-height' : conf['lineHeight']
	});
	
	// chỉ có 1 ảnh -> thoát
//	if ( len == 1 ) {
	if ( len <= conf['visible'] ) {
		if ( cf_tester_mode == 1 ) console.log( 'slider has been STOP by LI length < config visible' );
		return false;
	}
	
	//
	/*
	jQuery(window).resize(function(e) {
		// chỉnh lại chiều cao cho slide
		jQuery(jd).height( hai ).css({
			'line-height' : conf['lineHeight']
		});
	});
	*/
	
	
	//
	if ( conf['thumbnail'] != false ) {
		var str_btn = '',
			i = 0;
		jQuery(jd + ' ' + conf['thumbnail']).each(function() {
			var img = jQuery(this).attr('data-img') || jQuery(this).attr('data-src') || jQuery(this).attr('src') || '';
			if ( img != '' ) {
				img = get_thumbnail( img );
			}
			
			str_btn += '<li data-i="' +i+ '" data-src="' + img + '"><div style="background-image: url(\'' + img + '\');">&nbsp;</div></li>';
			
			i++;
		});
		jQuery(jd).after('<div class="' + jd_class + '"><div class="jEBE_slider-thumbnail"><ul class="cf">' + str_btn + '</ul></div></div>');
		
		// Tạo slider cho thumbnail
		if ( conf['thumbnailSlider'] == true ) {
			var j_id = '_' + Math.random().toString(32).replace('.', '_');
			
			jQuery(jd_to_class + ' .jEBE_slider-thumbnail').attr({
				id: j_id
			});
			
			/*
			// các option mặc định thì chuyển về false hết
			jEBE_slider( '#' + j_id, {
				visible: 4,
				buttonListNext: false,
				size : conf['thumbnailHeight'] + '/' + conf['thumbnailWidth']
			}, function () {
			});
			*/
			
			//
			jQuery('#' + j_id).addClass('jEBE_slider-child-thumbnail').height( conf['thumbnailHeight'] )
			/*
			.css({
				height: conf['thumbnailHeight'] + 'px'
			})
			*/
			;
			
			// mặc định là hiển thị 4 ảnh con, nếu nhiều hơn 4 ảnh -> hiển thị dưới dạng slide
			if ( jQuery('#' + j_id + ' li').length > 4 ) {
				
				// set chiều rộng mới cho UL, để tất cả các LI sẽ nằm trên 1 dòng
				jQuery('#' + j_id + ' ul').attr({
					'data-width': jQuery('#' + j_id + ' ul').width()
				}).width( jQuery('#' + j_id + ' li').length * ( jQuery('#' + j_id + ' ul').width()/ 4 ) );
				
				// tính toán chiều rộng cho các thẻ li
				jQuery('#' + j_id + ' li').width( ( 100/ jQuery('#' + j_id + ' li').length - 0.1 ) + '%' );
				
				//
				var str_for_thumb_row = '',
					j_id_left = j_id + '_left',
					j_id_right = j_id + '_right';
				
				str_for_thumb_row += '<div id="' + j_id_left + '" class="jEBE_slider-left-thumbnail ' + j_id + '-thumb-left"><i class="fa fa-angle-left"></i></div>';
				str_for_thumb_row += '<div id="' + j_id_right + '" class="jEBE_slider-right-thumbnail ' + j_id + '-thumb-right"><i class="fa fa-angle-right"></i></div>';
				
				//
				jQuery('#' + j_id).addClass('jEBE_slider-scroll-thumbnail').before('<div class="jEBE_slider-arrow-thumbnail ' + j_id + '-thumb-arrow">' + str_for_thumb_row + '</div>');
				
				//
				jQuery('#' + j_id_left + ', #' + j_id_right).height( conf['thumbnailHeight'] ).css({
					'line-height': conf['thumbnailHeight'] + 'px'
				});
				
				//
				jQuery('#' + j_id_left).click(function () {
					var a = jQuery('#' + j_id + ' ul').attr('data-scroll') || 0;
					a = a - 1;
					if ( a < 0 ) {
						a = 0;
					}
					
					jQuery('#' + j_id + ' ul').attr({
						'data-scroll': a
					}).css({
//						left: '-' + jQuery('#' + j_id + ' ul').attr('data-width') + 'px'
						left: '-' + ( a * 100 ) + '%'
					});
				});
				
				//
				jQuery('#' + j_id_right).click(function () {
					var a = jQuery('#' + j_id + ' ul').attr('data-scroll') || 0,
						max_li = jQuery('#' + j_id + ' li').length/ 4;
					a = a - (0 - 1);
					console.log(a);
					console.log(max_li);
					if ( a > max_li ) {
//						a = max_li;
						a = 0;
					}
//					console.log(a);
					
					jQuery('#' + j_id + ' ul').attr({
						'data-scroll': a
					}).css({
//						left: '-' + jQuery('#' + j_id + ' ul').attr('data-width') + 'px'
						left: '-' + ( a * 100 ) + '%'
					});
				});
				
			}
			else {
				jQuery('#' + j_id + ' li').width( '25%' );
			}
		}
		
		// tạo css cho thumbmail
		jQuery(jd_to_class + ' .jEBE_slider-thumbnail div').width( conf['thumbnailWidth'] ).height( conf['thumbnailHeight'] )
		/*
		.css({
			width: conf['thumbnailWidth'] + 'px',
			height: conf['thumbnailHeight'] + 'px'
		})
		*/
		;
	}
	
	
	// cái này phải nằm sau lệnh thumbnail thì nó mới lên trước được
	if ( conf['buttonListNext'] == true ) {
		var str_btn = '',
			listBtnLen = ( conf['visible'] > 1 ) ? Math.ceil( len/ conf['visible'] ) : len;
		for ( var i = 0; i < listBtnLen; i++ ) {
			str_btn += '<li data-i="' +i+ '"><i class="fa fa-circle"></i></li>';
		}
		jQuery(jd).after('<div class="' + jd_class + '"><div class="big-banner-button"><ul>' + str_btn + '</ul></div></div>');
	}
	
	// tạo css cho slider
	jQuery(jd)
	/*
	.scroll(function(e) {
		if ( jEBE_slider_dang_scroll == true ) {
			return false;
		}
		jEBE_slider_dang_scroll = true;
		
		var a = jQuery(this).attr('data-scroll') || 0,
			b = jQuery(this).scrollLeft(),
			i = jQuery(this).attr('data-i') || 0;
//		console.log( b );
		if ( a - b > 0 ) {
			i -= 1;
			console.log('left');
		} else {
			i -= -1;
			console.log('right');
		}
		console.log( i );
		jQuery(jd + ' li[data-i="' + i + '"]').click();
	})
	*/
	.addClass('jEBE_slider-position');
	
	/*
	jQuery(jd).css({
		position: 'relative',
		overflow: 'hidden'
	});
	*/
	
	jQuery(jd + ' ul').width( ( 100 * len/ conf['visible'] ) + '%' );
	if ( conf['speed'] > 0 ) {
		jQuery(jd + ' ul').css({
			'-moz-transition': 'all ' + conf['speed'] + 's ease',
			'-o-transition': 'all ' + conf['speed'] + 's ease',
			'-webkit-transition': 'all ' + conf['speed'] + 's ease',
			transition: 'all ' + conf['speed'] + 's ease'
		});
	}
	
	jQuery(jd + ' li').css({
//		width: ( 100/ len/ conf['visible'] ) + '%',
		width: ( 100/ len ) + '%'
	});
	
	
	// hiệu ứng khi click vào thẻ LI
	var  i = 0;
	jQuery(jd + ' li').each(function() {
		jQuery(this).attr({
			'data-i' : i
		});
		
		i += 1;
	}).click(function () {
		var i = jQuery(this).attr('data-i') || 0;
		if ( i * conf['visible'] >= jQuery(jd + ' li').length ) {
			i = 0;
		}
		
		jQuery(jd + ' ul').css({
			left: ( 0 - i * 100 ) + '%'
//			left: ( 0 - i * 100/ conf['visible'] ) + '%'
		});
		
		jQuery(jd)
//		.scrollLeft(0)
		.attr({
			'data-i' : i,
			'data-scroll' : i * jQuery(jd).width()
		});
		
		jEBE_slider_dang_scroll = false;
		
		//
		jQuery('.' + jd_class + ' li').removeClass('selected');
		jQuery('.' + jd_class + ' li[data-i="' + i + '"]').addClass('selected');
		
		
		
		// kiểm tra xem có video không -> có thì tự phát video thôi
		var vd = jQuery('div.banner-ads-media', this).attr('data-video') || '';
//		console.log(vd);
		
		// xóa các video trong cùng slide
		jQuery(jd + ' .banner-video-media').html('&nbsp;');
		
		//
		if ( vd.split('youtube.com').length > 1 ) {
			// xóa thẻ a
			jQuery('a', this).hide();
			
			// tính toán chiều rộng để tạo video
			var h = jQuery('div.banner-ads-media', this).height(),
//				w = h / youtube_video_default_size;
				w = '100%',
				w_video = jQuery(this).width(),
				h_video = '',
				t = 0;
//			console.log('W Video: ' + w_video);
			
			//
			h_video = w_video * youtube_video_default_size;
//			console.log('H Video: ' + h_video);
			
			//
			// chiều cao thực sự đang trình chiếu -> để điều chỉnh lại top cho slider -> làm cân slider
			if ( h_video > h ) {
				t = parseInt( ( h - h_video ) / 2, 10 );
			}
//			console.log('Top: ' + t);
			
			//
			jQuery('div.banner-ads-media', this)
			.addClass('banner-video-media')
			.html('<div style="top: ' + t + 'px">\
				<iframe width="' + w + '" height="' + h_video + '" src="' + vd + '?rel=0&autoplay=1&mute=1&html5=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>\
			</div>');
		}
		else if ( vd.split('.mp4').length > 1 ) {
			// xóa thẻ a
//			jQuery('a', this).hide();
			
			// tính toán chiều rộng để tạo video
			var h = jQuery('div.banner-ads-media', this).height(),
//			var h = '',
				w = '100%',
				w_video = jQuery(this).width(),
				h_video = '',
				t = 0;
//			console.log('W Video: ' + w_video);
//			console.log('H Slider: ' + h);
			
			// tính chiều cao của video dựa theo chiều rộng, tỉ lệ 16:9
			h_video = parseInt( w_video/ 16 * 9, 10 );
//			console.log('H Video: ' + h_video);
			
			// chiều cao thực sự đang trình chiếu -> để điều chỉnh lại top cho slider -> làm cân slider
			if ( h_video > h ) {
				t = parseInt( ( h - h_video ) / 2, 10 );
			}
//			console.log('Top: ' + t);
			
			// tạo video
			// https://www.w3schools.com/howto/howto_css_fullscreen_video.asp
			jQuery('div.banner-ads-media', this)
			.addClass('banner-video-media')
			.html('<video width="' + w + '" height="' + h_video + '" autoplay muted loop preload="auto" style="top: ' + t + 'px">\
				<source src="' + vd + '" type="video/mp4">\
			</video>');
		}
		
	});
	jQuery(jd + ' li[data-i="0"]').click();
	
	
	//
	jQuery('.' + jd_class + ' li').click(function () {
		var i = jQuery(this).attr('data-i') || 0;
//		console.log(i);
//		console.log(jd);
		
//		if ( jQuery(jd + ' li[data-i="' + i + '"]').length == 0 ) {
//		if ( i >= jQuery(jd + ' li').length ) {
//			i = 0;
//		}
		
		jQuery(jd + ' li[data-i="' + i + '"]').click();
		
		// tắt auto play
		if ( jEBE_slider_cache_option[jd]['autoplay'] == true ) {
			jEBE_slider_cache_option[jd]['autoplay'] = false;
			console.log('Stop autoplay for ' + jd);
		}
	});
	
	
	//
	if ( conf['autoplay'] == true ) {
		jEBE_slider_cache_option[jd] = {
			autoplay: true
		};
		
		setInterval(function () {
			if ( jEBE_slider_cache_option[jd]['autoplay'] == true ) {
				var i = jQuery(jd).attr('data-i') || 0;
				i -= -1;
//				i -= 0 - conf['visible'];
//				console.log(i);
//				console.log(jd);
				
//				if ( jQuery(jd + ' li[data-i="' + i + '"]').length == 0 ) {
				if ( i >= jQuery(jd + ' li').length ) {
					i = 0;
				}
				
				jQuery(jd + ' li[data-i="' + i + '"]').click();
			}
		}, conf['speedNext']);
	} else {
		jEBE_slider_cache_option[jd] = {
			autoplay: false
		};
	}
	
	
	//
	if ( conf['sliderArrow'] == true && len > conf['visible'] ) {
		jQuery(jd).before('<div class="' + jd_class + '"><div class="jEBE_slider-toCenter"><div class="jEBE_slider-toLeft"><i class="fa ' + conf['sliderArrowLeft'] + '"></i></div> <div class="jEBE_slider-toRight text-right"><i class="fa ' + conf['sliderArrowRight'] + '"></i></div></div></div>');
		
		
		//
		jQuery(jd_to_class + ' .jEBE_slider-toLeft').click(function () {
			var i = jQuery(jd).attr('data-i') || 0;
			i -= 1;
//			i -= conf['visible'];
//			console.log(i);
//			console.log(jd);
			
			if ( i < 0 ) {
				i = jQuery(jd + ' li').length - 1;
			}
			
			jQuery(jd + ' li[data-i="' + i + '"]').click();
		});
		
		jQuery(jd_to_class + ' .jEBE_slider-toRight').click(function () {
			var i = jQuery(jd).attr('data-i') || 0;
			i -= -1;
//			i -= 0 - conf['visible'];
//			console.log(i);
//			console.log(jd);
			
//			if ( jQuery(jd + ' li[data-i="' + i + '"]').length == 0 ) {
			if ( i >= jQuery(jd + ' li').length ) {
				i = 0;
			}
			
			jQuery(jd + ' li[data-i="' + i + '"]').click();
		});
		
		// tạo css cho nut next
		jQuery( jd_to_class + ' .jEBE_slider-toLeft, ' + jd_to_class + ' .jEBE_slider-toRight' ).css({
			'font-size': conf['sliderArrowSize'] + 'px',
			'line-height' : conf['lineHeight']
		}).height( hai );
		
		// tạo nút bấm chuyển ảnh ngay trên khung ảnh nếu:
		// người dùng đang xem trên màn ảnh rộng
		// hiển thì mỗi ảnh 1 cái
		if ( jQuery(window).width() > 750 || conf['visible'] == 1 ) {
			jQuery( jd_to_class + ' .jEBE_slider-toLeft' ).css({
				'width': conf['sliderArrowWidthLeft']
			});
			jQuery( jd_to_class + ' .jEBE_slider-toRight' ).css({
				'width': conf['sliderArrowWidthRight']
			});
		}
		
		
		// sử dụng swipe
		// https://github.com/mattbryson/TouchSwipe-Jquery-Plugin
		// http://labs.rampinteractive.co.uk/touchSwipe/demos/Basic_swipe.html
		/*
		jQuery(jd).swipe( {
			// Generic swipe handler for all directions
			swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
				if ( direction == 'left' ) {
					jQuery(jd_to_class + ' .jEBE_slider-toLeft').click();
				}
				else if ( direction == 'right' ) {
					jQuery(jd_to_class + ' .jEBE_slider-toRight').click();
				}
			},
			// Default is 75px, set to 0 for demo so any distance triggers swipe
			threshold:0
		});
		*/
		
		
		// https://www.w3schools.com/jquerymobile/jquerymobile_events_touch.asp
		/*
		if ( jQuery(window).width() < 750 ) {
			jQuery(jd_to_class + ' .jEBE_slider-toLeft, ' + jd_to_class + ' .jEBE_slider-toRight').on("swiperight", function() {
				jQuery(jd_to_class + ' .jEBE_slider-toLeft').click();
			}).on("swipeleft",function(){
				jQuery(jd_to_class + ' .jEBE_slider-toRight').click();
			});
		}
		*/
		
		
		
		// https://coderwall.com/p/bxxjfq/detecting-swipe-using-jquery
		/*
		if ( jQuery(window).width() < 750 ) {
			jQuery(jd_to_class + ' .jEBE_slider-toLeft, ' + jd_to_class + ' .jEBE_slider-toRight')
//			.on('mousedown touchstart', function (e) {
			.on('touchstart', function (e) {
//			.on('click', function (e) {
//			.click(function(e) {
//			.on('mousedown', function (e) {
//			.mousedown(function(e) {
//			.on('mouseover', function (e) {
//				console.log( e.originalEvent.touches[0] );
//				console.log("Start: (x,y) = (" + e.pageX + "," + e.pageY +")");
				xDown = e.pageX || 0;
				yDown = e.pageY || 0;
			})
//			.on('mouseup touchend',function (e) {
			.on('touchend',function (e) {
//			.touchend(function(e) {
//			.on('mouseup',function (e) {
//			.on('mouseout',function (e) {
//				console.log( e.originalEvent.changedTouches[0] );
//				console.log("End: (x,y) = (" + e.pageX + "," + e.pageY +")");
				xUp = e.pageX || 0;
				yUp = e.pageY || 0;
				
				var xDiff = xDown - xUp;
				var yDiff = yDown - yUp;
				
				// most significant
				if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {
//				if ( xDiff > yDiff ) {
					if ( xDiff > 0 ) {
						// left swipe
//						console.log('left');
						jQuery(jd_to_class + ' .jEBE_slider-toLeft').click();
					} else {
						// right swipe
//						console.log('right');
						jQuery(jd_to_class + ' .jEBE_slider-toRight').click();
					}
				} else {
					if ( yDiff > 0 ) {
						// up swipe
						console.log('up');
						jQuery(jd_to_class + ' .jEBE_slider-toLeft').click();
					} else { 
						// down swipe
						console.log('down');
						jQuery(jd_to_class + ' .jEBE_slider-toRight').click();
					}
				}
				
				//
//				jQuery(this)
//				.mouseout()
//				.mousedown()
//				.mouseover()
//				;
				
				return true;
				
			})
			;
		}
		*/
		
		
		//
		
	}
	
	
	//
	if ( typeof callBack == 'function' ) {
		if ( cf_tester_mode == 1 ) console.log(' call to callBack function');
		callBack();
	}
	
}



