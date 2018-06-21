

//
WGR_admin_quick_edit_select_menu();

//
function WGR_admin_quick_edit_products ( connect_to, url_request, parameter ) {
	
	// kiểm tra dữ liệu đầu vào
	if ( typeof connect_to == 'undefined' || connect_to == '' ) {
		console.log('not set connect to');
		return false;
	}
	if ( typeof url_request == 'undefined' || url_request == '' ) {
		console.log('URL for request is NULL');
		return false;
	}
	
	// các tham số khác
	if ( typeof parameter == 'undefined' ) {
		parameter = '';
	}
	
	// không cho bấm liên tiếp
	if ( waiting_for_ajax_running == true ) {
		console.log('waiting_for_ajax_running');
		return false;
	}
	waiting_for_ajax_running = true;
	
	//
	$('#rAdminME').css({
		opacity: 0.2
	});
	
	ajaxl( connect_to + url_request + parameter, 'rAdminME', 9, function () {
		$('#rAdminME').css({
			opacity: 1
		});
		
		waiting_for_ajax_running = false;
	});
}

//
$('.click-order-thread').off('click').click(function () {
	WGR_admin_quick_edit_products( 'products', $(this).attr('data-ajax') || '' );
});



//
$('.change-update-new-stt').off('change').change(function () {
	var a = $(this).val() || 0;
	a = g_func.number_only(a);
	if ( a < 0 ) {
		a = 0;
	}
//	console.log( a );
	
	// giảm đi 1 đơn vị -> vì sử dụng lệnh của chức năng UP
	a--;
//	console.log( a );
	
	//
	WGR_admin_quick_edit_products( 'products', $(this).attr('data-ajax') || '', a );
});



// thay đổi số lượng bài viết sẽ hiển thị
(function () {
	var arr = [
		3,
		10,
		20,
		30,
		50,
		100,
		200,
		500,
		800
	];
	
	var str = '',
		sl = '';
	
	for ( var i = 0; i < arr.length; i++ ) {
		sl = '';
		if ( arr[i] == threadInPage ) {
			sl = ' selected="selected"';
		}
		
		//
		str += '<option value="' +arr[i]+ '"' + sl + '>' +arr[i]+ '</option>';
	}
	
	$('#change_set_thread_show_in_page').html( '<option value="">---</option>' + str ).off('change').change(function () {
		var a = $(this).val() || '';
		if ( a == '' ) {
			a = 68;
		}
		
		//
		g_func.setc('quick_edit_per_page', a, 0, 30);
		
		//
		$('body').css({
			opacity: .2
		});
		
		//
		setTimeout(function () {
			window.location = strLinkPager;
		}, 600);
	});
})();




// bấm vào để chỉnh sửa giá nhanh
$('.click-quick-edit-price').off('click').click(function  () {
	var id = $(this).attr('data-id') || '',
		old_price = $(this).attr('data-old-price') || '',
		new_price = $(this).attr('data-new-price') || '';
	
	if ( old_price == '' ) {
		old_price = 0;
	}
	
	if ( new_price == '' ) {
		new_price = 0;
	}
	
	if ( old_price == 0 && new_price > 0 ) {
		old_price = new_price;
	}
	
	//
//	console.log( id );
//	console.log( old_price );
//	console.log( new_price );
	
	//
	var f = document.frm_quick_edit_price;
	f.t_product_id.value = id;
	f.t_old_price.value = g_func.money_format( old_price );
	f.t_new_price.value = g_func.money_format( new_price );
	
	//
	$('#frm_quick_edit_price').show();
	
	//
	f.t_new_price.focus();
});


//
$('#quick_edit_new_price').off('change').change(function () {
	var a = $(this).val() || '',
		b = $('#quick_edit_old_price').val() || '';
	
	//
	if ( a == '' ) {
		return false;
	}
	a = a.toLowerCase();
	b = b.toLowerCase();
	
	// tính theo % của giá cũ
	if ( a.split('%').length > 1 ) {
		// nếu giá cũ không có giá trị gì -> lấy theo giá mới, sau đó mới gán lại giá trị cho giá mới
		if ( b == '' || b == 0 ) {
			b = $('.click-quick-edit-price[data-id="' + document.frm_quick_edit_price.t_product_id.value + '"]').attr('data-new-price') || '';
			$('#quick_edit_old_price').val( b );
		}
		
		// Kiểm tra lại, vẫn thế -> hủy luôn
		if ( b == '' || b == 0 ) {
			$('#quick_edit_old_price').val( 0 );
			a = 0;
		}
		else {
			b = g_func.only_number( b );
			
			// nếu là 0% -> gán bằng giá cũ luôn
			if ( g_func.only_number( a ) == 0 ) {
				a = b;
			}
			else {
				// giảm theo số %
				if ( a.split('-').length > 1 ) {
					a = b/ 100 * g_func.only_number( a );
					a = b + a;
				}
				// bằng số %
				else {
					a = b/ 100 * g_func.only_number( a );
				}
			}
		}
		
		//
		$(this).val( g_func.money_format( a ) );
	}
	// đơn vị k -> nhân thêm 1000
	else if ( a.split('k').length > 1 ) {
		a = g_func.only_number( a );
		$(this).val( g_func.money_format( a * 1000 ) );
	}
	// lấy giá trực tiếp theo số liệu nhập vào
	else {
		$(this).val( g_func.money_format( a ) );
	}
	
	//
	return false;
});

//
$('#quick_edit_old_price').off('change').change(function () {
	var a = $(this).val() || '';
	
	// đơn vị k -> nhân thêm 1000
	if ( a.split('k').length > 1 ) {
		a = g_func.only_number( a );
		$(this).val( g_func.money_format( a * 1000 ) );
	}
	// lấy giá trực tiếp theo số liệu nhập vào
	else {
		$(this).val( g_func.money_format( a ) );
	}
	
	//
	return false;
});

//
function WGR_check_quick_edit_price () {
	var f = document.frm_quick_edit_price;
	var a = g_func.only_number( f.t_old_price.value ),
		b = g_func.only_number( f.t_new_price.value );
	
	//
//	if ( a <= b ) {
	if ( a == b ) {
		a = 0;
	}
	
	//
	var trang = $('.admin-part-page strong').html() || 1,
		uri = '&post_id=' + f.t_product_id.value + '&by_post_type=post&trang=' + trang + '&t=update_price&old_price=' + a + '&new_price=' + b;
//	console.log( uri );
	
	//
	WGR_admin_quick_edit_products( 'products', uri );
	
	//
	return false;
}




// Chỉnh sửa SEO nhanh
WGR_click_open_quick_edit_seo();


jQuery('.ebe-currency-format').each(function() {
	var a = jQuery(this).html() || '';
	
	if ( a != '' && a != '0' ) {
		jQuery(this).html( g_func.money_format( a ) );
	}
});




