

//
//console.log( typeof jQuery );
if ( typeof jQuery != 'function' ) {
	console.log( 'jQuery not found' );
}

//
//console.log( typeof $ );
if ( typeof $ != 'function' ) {
	$ = jQuery;
}




//
if ( cf_chu_de_chinh != '' ) {
	jQuery('#menu-posts .wp-menu-name').html( cf_chu_de_chinh );
}




// chức năng xử lý cho product size
var eb_global_product_size = '',
	eb_inner_html_product_size = '';

function eb_func_add_nut_product_size ( str, i ) {
	if ( typeof str == 'undefined' ) {
		str = '';
	}
	if ( typeof i == 'undefined' ) {
		i = 0;
	}
	
	//
	return '\
	<div class="eb-admin-product-size">\
		<ul class="cf">\
			' + str + '\
			<li data-parent="' + i + '" data-add="1" title="Thêm size mới"><i class="fa fa-plus"></i></li>\
		</ul>\
	</div>';
}

function eb_func_show_product_size () {
	
	// nếu mảng size chưa được tạo -> tìm và tạo từ string
	if ( typeof eb_global_product_size != 'object' ) {
		
		// TEST
		/*
		console.log('TEST');
		if ( $('#_eb_product_size').val() == '' ) {
			$('#_eb_product_size').val(',{name:"800x1200",val:"1554000"},{name:"1000x1200",val:"1849000"},{name:"1200x1500",val:"2432000"},{name:"1200x1600",val:"2566000"},{name:"1200x1800",val:"2814000"},{name:"1200x2000",val:"2981000"},{name:"1200x2200",val:"3239000"},{name:"1200x2400",val:"3496000"}');
		}
		*/
		
		//
		eb_global_product_size = $('#_eb_product_size').val() || '';
//		console.log( eb_global_product_size );
		if ( eb_global_product_size != '' ) {
			
			// xử lý với các dữ liệu cũ đang bị lệch sóng
			if ( eb_global_product_size.substr(0, 1) == ',' ) {
				eb_global_product_size = eb_global_product_size.substr(1);
			}
			
			if ( eb_global_product_size.substr(0, 1) != '[' ) {
				eb_global_product_size = "[" + eb_global_product_size + "]";
			}
//			console.log( eb_global_product_size );
			
			// chuyển từ string sang object
			eb_global_product_size = eval( eb_global_product_size );
			
		} else {
			eb_global_product_size = [];
		}
//		console.log( JSON.stringify( eb_global_product_size ) );
		
		// nếu mảng số 0 tồn tại tham số name -> kiểu dữ liệu cũ -> convert sang dữ liệu mới
		if ( typeof eb_global_product_size[0] != 'undefined' ) {
			if ( typeof eb_global_product_size[0][0] == 'undefined' ) {
				var eb_global_product_size_v2 = eb_global_product_size.slice();
//				console.log( eb_global_product_size );
//				console.log( eb_global_product_size_v2 );
				
				eb_global_product_size = [];
				eb_global_product_size[0] = eb_global_product_size_v2;
//				console.log( JSON.stringify( eb_global_product_size ) );
			}
		}
		
	}
//	console.log( eb_global_product_size );
//	console.log( eb_global_product_size.length );
	
	var str_size = '';
	if ( eb_global_product_size.length > 0 ) {
		for ( var i = 0; i < eb_global_product_size.length; i++ ) {
//			console.log( i );
			
			var str_node_size = (function ( arr ) {
//				console.log( arr );
				
				var str = '';
				
				if ( typeof arr == 'object' ) {
					for ( var j = 0; j < arr.length; j++ ) {
						str += '<li data-parent="' + i + '" data-node="' + j + '" data-size="' + arr[j].name + '" data-quan="' + arr[j].val + '" title="Size: ' + arr[j].name + '/ Số lượng: ' + arr[j].val + '">' + arr[j].name + '/ ' + arr[j].val + '</li>';
					}
				}
				
				return str;
			})( eb_global_product_size[i] );
			
			//
			if ( str_node_size != '' ) {
				str_size += eb_func_add_nut_product_size( str_node_size, i );
			}
		}
	} else {
		str_size += eb_func_add_nut_product_size();
	}
	
	//
//	console.log(eb_inner_html_product_size);
	$('#' + eb_inner_html_product_size).html( str_size );
	$('#' + eb_inner_html_product_size + ' ul:last li:last').after('<li data-add="group" title="Thêm nhóm size mới (một số theme mới hỗ trợ tính năng này)"><i class="fa fa-plus"></i> <i class="fa fa-plus"></i></li>');
	
	// chuyển từ object sang string
	/*
	eb_global_product_size = JSON.parse(eb_global_product_size);
	eb_global_product_size = $.parseJSON(eb_global_product_size);
	console.log( eb_global_product_size );
	console.log( eb_global_product_size.length );
	*/
	
	// gán trở lại để còn lưu dữ liệu
	if ( eb_global_product_size.length > 0 ) {
		$('#_eb_product_size').val( JSON.stringify( eb_global_product_size ) );
	} else {
		$('#_eb_product_size').val('');
	}
	
}

function check_eb_input_edit_product_size () {
	$('.eb-input-edit-product-size button').click();
	return false;
}

// kiểm tra và tạo size
function eb_func_global_product_size () {
	
	// nếu có module size -> chỉ sản phẩm mới có
	var kk = '_eb_product_size';
	
	if ( dog(kk) == null ) {
		return false;
	}
//	alert(1);
	
	//
	/*
	console.log('TEST');
	$('#' + kk).attr({
		type : 'text'
	});
	*/
	
	// tạo khung để sử dụng chức năng add size
	eb_inner_html_product_size = 'oi' + kk;
	
	// nếu chưa có HTML để tạo hiệu ứng -> tạo
//	if ( dog(eb_inner_html_product_size) == null ) {
	if ( $('#' + eb_inner_html_product_size).length == 0 ) {
		
		$('tr[data-row="_eb_product_color"]').after('\
		<tr data-row="' + kk + '">\
			<td class="t bold">Kích thước</div></td>\
			<td id="' + eb_inner_html_product_size + '" class="i"></td>\
		</tr>');
		
		// thêm chức năng sửa size
//		$('body').append('\');
		
	}
	
	//
	eb_func_show_product_size();
	eb_func_click_modife_product_size();
	
}

// các hiệu ứng khi click ào thẻ LI
function eb_func_click_modife_product_size () {
	
	$('#' + eb_inner_html_product_size + ' li').off('click').click(function () {
//		console.log(1);
		
		$('#' + eb_inner_html_product_size + ' li').removeClass('redcolor').removeClass('selected');
		
		//
		var a = $(this).attr('data-add') || '';
		
		// sửa size
		if ( a == '' ) {
			$(this).addClass('redcolor').addClass('selected');
		}
		else {
			// thêm nhóm size
			if ( a == 'group' ) {
				if ( typeof eb_global_product_size[0] != 'undefined' ) {
					var add_new_group_size = eb_global_product_size[0].slice();
					
//					eb_global_product_size[ eb_global_product_size.length ] = [];
					eb_global_product_size.push( add_new_group_size );
				} else {
					alert('First object not found');
					return false;
				}
			}
			// thêm size
			else {
				
				//
				var size_parent = $(this).attr('data-parent') || 0;
				
				if ( typeof eb_global_product_size[size_parent] == 'undefined' ) {
					eb_global_product_size[size_parent] = [];
				}
				
				eb_global_product_size[ size_parent ].push( {
					name : "",
					val : ""
				});
//				console.log( eb_global_product_size[ size_parent ] );
				
//				$(this).prev().addClass('redcolor').addClass('selected');
				setTimeout(function () {
					$('.eb-admin-product-size li[data-add="1"]').prev().addClass('redcolor').addClass('selected').click();
				}, 200);
				
			}
			
			//
			eb_func_global_product_size();
		}
		
		//
		if ( a == '' ) {
			var current_select = '#' + eb_inner_html_product_size + ' li.selected';
			if ( $( current_select ).length > 0 ) {
				$('.eb-input-edit-product-size').css({
					top : $(current_select).offset().top + $(current_select).height(),
					left : $(current_select).offset().left
				}).show();
				
				//
				var a_parent = $(current_select).attr('data-parent') || 0,
					a_node = $(current_select).attr('data-node') || 0;
//				console.log( a_parent );
//				console.log( a_node );
				
				if ( typeof eb_global_product_size[ a_parent ][ a_node ] == 'undefined' ) {
					alert('Object value (node) not found');
					return false;
				}
				
				$('.eb-input-edit-product-size input[name="eb_input_edit_product_size_size"]').val( eb_global_product_size[ a_parent ][ a_node ].val );
				$('.eb-input-edit-product-size input[name="eb_input_edit_product_size_name"]').val( eb_global_product_size[ a_parent ][ a_node ].name ).focus();
				
				$('.eb-input-edit-product-size button').off('click').click(function () {
					var a = $(this).attr('data-action') || '';
					
					if ( a == 'save' ) {
						var ten = $('.eb-input-edit-product-size input[name="eb_input_edit_product_size_name"]').val() || '',
							sai = $('.eb-input-edit-product-size input[name="eb_input_edit_product_size_size"]').val() || '';
						
						eb_global_product_size[ a_parent ][ a_node ] = {
							name : ten,
							val : sai
						};
						
						//
						eb_func_global_product_size();
					}
					
					//
					$('.eb-input-edit-product-size').hide();
				});
			}
		}
	});
}



// chức năng đồng bộ nội dung website theo chuẩn chung của EchBay
function click_remove_style_of_content () {
	
	//
	$('.click_remove_content_style').click(function () {
		
		// hủy check ngay và luôn
		$(this).prop({
			checked : false
		});
		
		//
		var content_id = $(this).attr('data-editer') || 'content_ifr';
		
		// tên đầy đủ của text editter
//		content_id += 'wysiwyg';
		
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
			'font',
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
		$( content_id ).contents().find( 'img' ).each(function() {
			var a = $(this).attr('alt') || '';
			
			if ( a != '' ) {
				$(this).attr({
					alt : $('#title').val() || ''
				});
			}
		}).removeAttr('style').removeAttr('longdesc');
		
		
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



// chức năng đồng bộ hình ảnh trong nội dung website theo chuẩn chung của EchBay
function click_remove_style_of_img_content () {
	
	//
	$('.click_remove_content_img_style').click(function () {
		
		// hủy check ngay và luôn
		$(this).prop({
			checked : false
		});
		
		//
		var content_id = $(this).attr('data-editer') || 'content_ifr';
		
		// tên đầy đủ của text editter
//		content_id += 'wysiwyg';
		
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




// tạo url chung cho các module
//$(document).ready(function() {
(function ( admin_body_class ) {
	
	
	//
//	$('body').addClass('folded');
//	$('#adminmenu').addClass('cf');
	
	//
//	console.log( typeof jQuery );
//	console.log( typeof $ );
	
	
	//
	var win_href = window.location.href;
	
	//
	$('.admin-set-reload-url').attr({
		href : win_href
	});
	
	
	
	
	// đánh dấu các tab đang được xem
	$('.eb-admin-tab a').each(function () {
		var a = $(this).attr('href') || '';
//		console.log(a);
		
		if ( a != '' ) {
			a = a.split('&tab=');
			
			if ( a.length > 1 ) {
				a = a[1].split('&')[0];
				
				$(this).attr({
					'data-tab' : a
				});
			}
		}
	});
	
	// đánh dấu tab
	var a = win_href.split('&tab=');
	if ( a.length > 1 ) {
		a = a[1].split('&')[0];
		console.log(a);
		
		$('.eb-admin-tab a[data-tab="' +a+ '"]').addClass('selected');
	} else {
		$('.eb-admin-tab li:first a').addClass('selected');
	}
	
	
	
	
	// post size (product size)
	// nếu đang trong phần sửa bài viết
	if ( win_href.split('post.php?post=').length > 1 ) {
		
		
		
		
		//
		/*
		if ( win_href.split('www.webgiare.org').length > 1 ) {
			$(document).ready(function() {
				setTimeout(function () {
					$('#click_remove_content_style').click();
				}, 2000);
			});
			
			//
			$('#excerpt').val( $('#excerpt').val().replace( /\&nbsp\;/gi, ' ' ) );
		}
		*/
		
		
		
		eb_func_global_product_size();
		
		
		
		// gán ảnh đại diện
		(function () {
			
			
			
			// chuyển định dạng số cho phần giá
			$('#_eb_product_oldprice, #_eb_product_price').change(function () {
				var a = $(this).val() || 0;
				
				a = g_func.number_only( a );
				
				if ( a == '' ) {
					a = 0;
				}
				
				console.log(a);
				$(this).val(a);
			});
			
			
			
			// tạo hiệu ứng cho textarea
			if ( $('textarea[id="excerpt"]').length > 0 ) {
				$('textarea[id="excerpt"]').addClass('fix-textarea-height');
			}
			
			
			//
			var a = $('#_eb_product_avatar').val() || '',
				b = $('tr[data-row="_eb_product_avatar"]').length;
			if ( a != '' && b > 0 ) {
				
				// xử lý hình ảnh lỗi cho xwatch cũ
				a = a.replace( '/home/pictures/', '/Home/Pictures/' );
				$('#_eb_product_avatar').val( a );
				
				//
				$('tr[data-row="_eb_product_avatar"]').after( '\
				<tr>\
					<td class="t">&nbsp;</td>\
					<td class="i"><img src="' + a + '" height="110" /></td>\
				</tr>' );
			}
			
			
			// xử lý hình ảnh lỗi cho xwatch cũ
			setTimeout(function () {
				if ( $("#_eb_product_gallery_ifr").length > 0 ) {
					$("#_eb_product_gallery_ifr").contents().find('img').each(function() {
						var a = $(this).attr('src') || '',
							b = a;
						if (a != '') {
							a = a.replace( '/home/pictures/', '/Home/Pictures/' );
							
							$(this).attr({
								src : a,
								'data-old-src' : b
							});
						}
					});
				}
			}, 2000);
			
			
			
			
			// tạo chức năng chỉnh sửa nội dung, đưa hết về 1 định dạng chuẩn
			var str = '\
			<div style="padding-top:8px;">\
				<input type="checkbox" id="click_remove_content_style" class="click_remove_content_style" />\
				<label for="click_remove_content_style">Loại bỏ toàn bộ các style tĩnh để chuẩn hóa style cho bài viết theo một thiết kế chung.</label>\
			</div>';
			
			$('#postdivrich').after(str);
			
			//
			click_remove_style_of_content();
			
			
			
		})();
		
		
		
		//
		var check_and_set_height_for_img_content = function ( iff_id, default_h, fix_height ) {
			
			// Khung nội dung chính của wordpress thì hạn chế can thiệp vào ảnh -> để người dùng có thể tự ý điều chỉnh size
			if ( typeof fix_height == 'undefined' ) {
				fix_height = 1;
			}
			
			//
			if ( $('#' + iff_id).length > 0 ) {
//				console.log(iff_id);
				$('#' + iff_id).contents().find( 'img' ).each(function() {
					// current style
					var cs = $(this).attr('style') || '',
						// height
						h = $(this).attr('height') || '',
						// width
						w = $(this).attr('width') || default_h;
					
					if ( cs != '' ) {
						$(this).removeAttr('style').removeAttr('data-mce-src');
					}
					
					// nếu không tìm thấy chiều cao
					if ( h == '' ) {
						// rết lại toàn bộ size ảnh
						$(this).removeAttr('width').removeAttr('height').width('auto').height('auto');
//						$(this).removeAttr('width').removeAttr('height');
						
						// tìm chiều cao mặc định
						h = $(this).height() || 0;
						
						// khi nào tìm được mới thôi
						if ( h > 0 ) {
							w = $(this).width() || 0;
							
							//
							$(this).attr({
								'width' : Math.ceil( w ),
								'height' : h
							});
						}
					}
					// có chiều cao -> set thuộc tính mới luôn
					else if ( h > default_h && fix_height == 1 ) {
						var dh = $(this).attr('data-height') || h,
							dw = $(this).attr('data-width') || w;
						
						
						var nw = dh/ default_h;
//						console.log(nw);
						nw = dw/ nw;
//						console.log(nw);
						
						//
						$(this).attr({
							'data-width' : dw,
							'data-height' : dh,
							'width' : Math.ceil( nw ),
							'height' : default_h
						});
					}
				});
			}
		};
		
		
		
		// chỉnh lại ảnh của phần gallery để nhìn cho dễ
		setInterval(function () {
			check_and_set_height_for_img_content('content_ifr', 300, 0);
			check_and_set_height_for_img_content('_eb_product_gallery_ifr', 120);
			check_and_set_height_for_img_content('_eb_product_list_color_ifr', 90);
		}, 2000);
		
		//
		setTimeout(function () {
			$('#_eb_product_list_color_ifr').height( 250 );
			
			setTimeout(function () {
				$('#_eb_product_list_color_ifr').height( 250 );
				
				setTimeout(function () {
					$('#_eb_product_list_color_ifr').height( 250 );
				}, 2000);
			}, 2000);
		}, 2000);
		
		
		//
		$('#publish').css({
			'position' : 'fixed',
			'bottom': '20px',
			'right' : '20px',
			'z-index' : 99
		});
		
		
		
		//
		$(window).on('load', function () {
			if ( dog('postexcerpt-hide').checked == false ) {
				$('#postexcerpt-hide').click();
				if ( dog('postexcerpt-hide').checked == false ) {
					dog('postexcerpt-hide').checked = true;
				}
			}
			
			//
			var str_excerpt = $('#excerpt').val() || '',
				des = '';
			// Yoast SEO
			if ( $('#snippet-editor-meta-description').length > 0 ) {
				des = $('#snippet-editor-meta-description').val() || '';
				
				if ( des == '' && str_excerpt != '' ) {
					$('#snippet-editor-meta-description').val( str_excerpt );
				}
			}
			console.log(str_excerpt);
			console.log(des);
			
			//
			if ( str_excerpt == '' && des != '' ) {
				$('#excerpt').val( des );
			}
		});
		
	}
	// danh sách post, page, custom post type
	else if ( win_href.split('/edit.php').length > 1 ) {
		// nếu là post
		if ( win_href.split('post_type=').length == 1
		|| win_href.split('post_type=post').length > 1 ) {
			$('table.wp-list-table').width( '150%' );
		}
	}
	// danh sách đơn hàng
	else if ( win_href.split('?page=eb-order').length > 1 ) {
		// thu gọn menu của wp
//		$('body').addClass('folded');
	}
	// thêm tài khoản thành viên
	else if ( win_href.split('/user-new.php').length > 1 ) {
		$('#createuser .form-table tr:last').after('\
		<tr class="form-field">\
			<th>&nbsp;</th>\
			<td>' + ( $('#echbay_role_user_note').html() || 'DIV #echbay_role_user_note not found' ) + '</td>\
		</tr>');
	}
	// thêm tài khoản thành viên
	else if ( win_href.split('/user-edit.php').length > 1 ) {
		$('.user-role-wrap').after('\
		<tr class="form-field">\
			<th>&nbsp;</th>\
			<td>' + ( $('#echbay_role_user_note').html() || 'DIV #echbay_role_user_note not found' ) + '</td>\
		</tr>');
	}
	// không cho người dùng chỉnh sửa kích thước ảnh thumb -> để các câu lệnh dùng thumb sẽ chính xác hơn
	else if ( win_href.split('/options-media.php').length > 1 ) {
		$('#wpbody-content .form-table tr:first td:last').addClass('disable-edit-thumb-small').append('<div class="div-edit-thumb-small">&nbsp;</div>');
	}
	// chuyển rule wordpress sang nginx cho nó mượt
	else if ( win_href.split('/options-permalink.php').length > 1 ) {
//		console.log( arr_wordpress_rules.length );
		console.log( arr_wordpress_rules );
		
		var str = '';
		for ( var x in arr_wordpress_rules ) {
			var rule = x,
				rewrite = arr_wordpress_rules[x];
			
			if ( rule.substr( rule.length - 1 ) != '$' ) {
				rule += '$';
			}
			if ( rule.substr( 0, 1 ) != '^' ) {
				rule = '^' + rule;
			}
			
			if ( rewrite.substr( 0, 1 ) != '/' ) {
				rewrite = '/' + rewrite;
			}
			
			str += 'rewrite ' + rule + ' ' + rewrite + ';' + "\n";
		}
		
		// Thay tham số của wordpress bằng tham số nginx
		str = str.replace( /\$matches\[1\]/gi, '$1' );
		str = str.replace( /\$matches\[2\]/gi, '$2' );
		str = str.replace( /\$matches\[3\]/gi, '$3' );
		str = str.replace( /\$matches\[4\]/gi, '$4' );
		str = str.replace( /\$matches\[5\]/gi, '$5' );
		str = str.replace( /\$matches\[6\]/gi, '$6' );
		str = str.replace( /\$matches\[7\]/gi, '$7' );
		str = str.replace( /\$matches\[8\]/gi, '$8' );
		str = str.replace( /\$matches\[9\]/gi, '$9' );
		str = str.replace( /\$matches\[10\]/gi, '$10' );
		
//		str = str.replace( /\{1\,\}/gi, '{1,10}' );
		str = str.replace( /\{1\,\}/gi, '?' );
		str = str.replace( /\{4\}/gi, '(4)' );
		str = str.replace( /\{1,2\}/gi, '(1,2)' );
		str = str.replace( /\{4\}/gi, '(4)' );
		str = str.replace( /\{4\}/gi, '(4)' );
		str = str.replace( /\{4\}/gi, '(4)' );
		
//		console.log(str);
		
		$('form[name="form"]').after( '<textarea style="width:99%;height:600px;">' + str + '</textarea>' );
	}
	
	
	
	
	//
	if ( win_href.split('localhost:').length > 1 ) {
		$('#target_eb_iframe').height(600).css({
			position: 'relative',
			top: 0,
			left: 0,
			height : '600px'
		});
	}
	
	
	
	//
	$('input[id="_eb_category_order"]').width( 90 );
	
	
	//
	fix_textarea_height();
	
	
	
	
	// fix chiều cao cho cột mô tả -> vì nó dài quá
	if ( admin_body_class.split('edit-tags-php').length > 1 ) {
		$('#the-list').addClass('eb-hide-description');
		
		$('#the-list .column-description').each(function(index, element) {
			var a = $(this).html() || '';
			if ( a != '' ) {
				$(this).html( '<div class="eb-fixed-content-height">' + a + '</div>' );
			}
		}).addClass('show-column-description');
	}
	
	
//});
})( $('body').attr('class') || '' );


