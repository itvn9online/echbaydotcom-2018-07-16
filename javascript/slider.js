


var jEBE_slider_cache_option = {};

function jEBE_slider ( jd, conf ) {
	
	// kiểm tra và nạp jQuery
	if ( typeof jQuery != 'function' ) {
		console.log('jQuery not found');
		return false;
	}
	if ( typeof $ != 'function' ) {
		$ = jQuery;
	}
	
	//
	if ( typeof jd == 'undefined' || jd == '' || $(jd).length == 0 ) {
		console.log( jd + ' not found' );
		return false;
	}
	var jd_to_class = '.' + jd.substr( 1 ).replace( /\.|\#|\s/g, '-' );
	var jd_class = jd_to_class.substr(1);
	
	
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
	}
	var inner_css = function ( str ) {
		if ( document.getElementById('jEBE_slider_css') == null ) {
//			$('head').append('<style id="jEBE_slider_css"></style>');
			$('link').after('<style id="jEBE_slider_css"></style>');
		}
		
		if ( typeof str == 'undefined' || str == '' ) {
			return false;
		}
		str = str.split("\n");
		var new_str = '';
		for ( var i = 0; i < str.length; i++ ) {
			str[i] = $.trim( str[i] );
			if ( str[i] != '' ) {
				new_str += str[i] + "\n";
			}
		}
		
		$('#jEBE_slider_css').append( $.trim( new_str ) );
	};
	
	// mặc định là ẩn nếu không có LI nào
	set_default_conf( 'hide_if_null', true );
	
	// kích thước
	set_default_conf( 'width', 1 );
	set_default_conf( 'height', 1 );
	// tỷ lệ giữa chiều cao và chiều rộng
	set_default_conf( 'size', conf['height'] + '/' + conf['width'] );
	
	// tự động chạy
	set_default_conf( 'autoplay', false );
	// tốc độ chuyển slide ( mini giây )
	set_default_conf( 'speed', 800 );
	conf['speed'] = conf['speed']/ 1000;
	// giãn cách chuyển slide (mini giây)
	set_default_conf( 'speedNext', 5000 );
	
	// nút bấm chuyển ảnh
	set_default_conf( 'buttonListNext', true );
	
	// thumbnail -> vì là lấy hình ảnh làm thumbnail -> cần class chứa URL ảnh (src hoặc data-img)
	set_default_conf( 'thumbnail', false );
	// kích thước của thumbnail
	set_default_conf( 'thumbnailWidth', 90 );
	set_default_conf( 'thumbnailHeight', conf['thumbnailWidth'] );
	
	console.log( conf );
	
	
	// kiểm tra có li nào ở trong không
	var len = $(jd + ' li').length || 0;
	if ( len == 0 ) {
		if ( conf['hide_if_null'] == true ) {
			$(jd).hide();
		}
		return false;
	}
	
	
	// chỉ có 1 ảnh -> thoát
	if ( len == 1 ) {
		return false;
	}
	
	
	// chiều cao cho slide
	var wit = $(jd).width(),
		hai = wit * eval( conf['size'] ) - 1;
	
	$(jd).height( hai ).css({
		'line-height' : hai + 'px'
	});
	$(window).resize(function(e) {
		// chỉnh lại chiều cao cho slide
		$(jd).height( hai ).css({
			'line-height' : hai + 'px'
		});
	});
	
	
	//
	if ( conf['thumbnail'] != false ) {
		var str_btn = '',
			i = 0;
		$(jd + ' ' + conf['thumbnail']).each(function() {
			var img = $(this).attr('data-img') || $(this).attr('src') || '';
			if ( img != '' ) {
				img = get_thumbnail( img );
			}
			
			str_btn += '<li data-i="' +i+ '" data-src="' + img + '"><div style="background-image: url(\'' + img + '\');">&nbsp;</div></li>';
			
			i++;
		});
		$(jd).after('<div class="' + jd_class + '"><div class="jEBE_slider-thumbnail"><ul class="cf">' + str_btn + '</ul></div></div>');
		
		// tạo css cho thumbmail
		inner_css( '\
' + jd_to_class + ' .jEBE_slider-thumbnail {\
	text-align: center;\
	margin-top: 5px;\
}\
' + jd_to_class + ' .jEBE_slider-thumbnail li {\
	display: inline-block;\
	cursor: pointer;\
}\
' + jd_to_class + ' .jEBE_slider-thumbnail div {\
	width: ' + conf['thumbnailWidth'] + 'px;\
	height: ' + conf['thumbnailHeight'] + 'px;\
	background: #ccc center no-repeat;\
	background-size: auto 100%;\
	margin: 0 5px 5px 0;\
}\
		' );
	}
	
	
	// cái này phải nằm sau lệnh thumbnail thì nó mới lên trước được
	if ( conf['buttonListNext'] == true ) {
		var str_btn = '';
		for ( var i = 0; i < len; i++ ) {
			str_btn += '<li data-i="' +i+ '"><i class="fa fa-circle"></i></li>';
		}
		$(jd).after('<div class="' + jd_class + '"><div class="big-banner-button"><ul>' + str_btn + '</ul></div></div>');
	}
	
	// tạo css cho slider
	inner_css( '\
' + jd + ' {\
	position: relative;\
	overflow: hidden;\
}\
' + jd + ' ul {\
	position: absolute;\
	left: 0;\
	width: ' + ( len * 100 ) + '%;\
	-moz-transition: all ' + conf['speed'] + 's ease;\
	-o-transition: all ' + conf['speed'] + 's ease;\
	-webkit-transition: all ' + conf['speed'] + 's ease;\
	transition: all ' + conf['speed'] + 's ease;\
}\
' + jd + ' li {\
	float: left;\
	width: ' + ( 100/ len ) + '%;\
}\
	' );
	
	
	// hiệu ứng khi click vào thẻ LI
	var  i =0;
	$(jd + ' li').each(function() {
		$(this).attr({
			'data-i' : i
		});
		
		i++;
	}).click(function () {
		var i = $(this).attr('data-i') || 0;
		
		$(jd + ' ul').css({
			left: ( 0 - i * 100 ) + '%'
		});
		
		$(jd).attr({
			'data-i' : i
		});
		
		//
		$('.' + jd_class + ' li').removeClass('selected');
		$('.' + jd_class + ' li[data-i="' + i + '"]').addClass('selected');
	});
	
	
	//
	$('.' + jd_class + ' li').click(function () {
		var i = $(this).attr('data-i') || 0;
		console.log(i);
		console.log(jd);
		
		if ( $(jd + ' li[data-i="' + i + '"]').length == 0 ) {
			i = 0;
		}
		
		$(jd + ' li[data-i="' + i + '"]').click();
		
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
				var i = $(jd).attr('data-i') || 0;
				i -= -1;
//				console.log(i);
//				console.log(jd);
				
				if ( $(jd + ' li[data-i="' + i + '"]').length == 0 ) {
					i = 0;
				}
				
				$(jd + ' li[data-i="' + i + '"]').click();
			}
		}, conf['speedNext']);
	}
	
}



