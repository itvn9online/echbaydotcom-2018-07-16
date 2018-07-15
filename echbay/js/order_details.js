


var arr_global_js_order_details = [],
	arr_global_js_order_customter = {};

function ___eb_admin_update_order_details () {
	
	//
	console.log( arr_global_js_order_details );
	$('#order_products').val( escape( JSON.stringify( arr_global_js_order_details ) ) );
	
	//
//	console.log( arr_global_js_order_customter );
	arr_global_js_order_customter['hd_ten'] = $('#oi_hd_ten').val() || '';
	arr_global_js_order_customter['hd_dienthoai'] = $('#oi_hd_dienthoai').val() || '';
	arr_global_js_order_customter['hd_diachi'] = $('#oi_hd_diachi').val() || '';
	arr_global_js_order_customter['hd_admin_ghichu'] = $('#hd_admin_ghichu').val() || '';
	console.log( arr_global_js_order_customter );
	$('#order_customer').val( escape( JSON.stringify( arr_global_js_order_customter ) ) );
	
	return true;
}


//
(function () {
	
	// đồng bộ hóa v1 với v2
	if ( $('#order_old_type').val() > 0
	&& order_details_arr_cart_product_list == ''
	&& typeof order_details_arr_cart_product_list_v1 == 'object' ) {
		
		//
		console.log( 'conver oder v1 to v2' );
		
		//
//		console.log( order_details_arr_cart_product_list_v1 );
//		console.log( typeof order_details_arr_cart_product_list_v1 );
		
		//
		order_details_arr_cart_product_list = [];
		order_details_arr_cart_customer_info = {};
		
		//
		var arr = order_details_arr_cart_product_list_v1;
		for ( var i = 0; i < arr.length; i++ ) {
//			console.log(arr[i]);
			
			//
			if ( typeof arr[i].__eb_hd_customer_info != 'undefined' ) {
				var arr2 = arr[i];
				
				for ( var x in arr2 ) {
					order_details_arr_cart_customer_info[x.replace('__eb_', '')] = arr2[x];
				}
				
				// thông tin khách hàng (dùng để kiểm soát)
				var custom_info = arr[i].__eb_hd_customer_info;
//				console.log(custom_info);
				custom_info = custom_info.replace( /\&quot\;/g, '"' );
//				console.log(custom_info);
				custom_info = eval( '[' + custom_info + ']' );
				custom_info = custom_info[0];
//				console.log(custom_info);
				
				//
				for ( var x in custom_info ) {
					order_details_arr_cart_customer_info[x] = custom_info[x];
				}
			}
			else {
				order_details_arr_cart_product_list.push( arr[i] );
			}
		}
		console.log( order_details_arr_cart_product_list );
		console.log( order_details_arr_cart_customer_info );
		
		// tự động cập nhật lại
		setTimeout(function () {
			___eb_admin_update_order_details();
			
			//
			if ( $('#order_products').val().length > 100 && $('#order_customer').val().length > 100 ) {
				console.log( 'auto update old order' );
				document.frm_invoice_details.submit();
			}
			else {
				console.log( 'auto update STOP, because content too short!' );
			}
		}, 1200);
		
	}
	
	//
	var arr = order_details_arr_cart_product_list,
		cus = order_details_arr_cart_customer_info;
	
//	console.log(arr);
	if ( typeof arr != 'object' ) {
		arr = $.parseJSON( unescape( arr ) );
		
		// kiểm tra lại mà vẫn thế -> lỗi
		if ( typeof arr != "object" ) {
			console.log( "cart value not found" );
			return false;
		}
	}
	console.log(arr);
//	console.log(arr.length);
	
	//
	arr_global_js_order_details = arr.slice();
	
	//
	for ( var i = 0; i < arr.length; i++ ) {
//		console.log(arr[i]);
		
		//
		if ( arr[i].color != '' ) {
			arr[i].color = $.trim( arr[i].color );
			if ( arr[i].color.substr( 0, 1 ) != '-' ) {
				arr[i].color = '- ' + arr[i].color;
			}
			
			arr[i].color = ' ' + arr[i].color;
		}
		
		if ( arr[i].size != '' ) {
			arr[i].size = $.trim( arr[i].size );
			if ( arr[i].size.substr( 0, 1 ) != '(' ) {
				arr[i].size = '(Size: ' + arr[i].size + ')';
			}
			
			arr[i].size = ' ' + arr[i].size;
		}
		
		//
		$('.order-danhsach-sanpham').append('\
		<tr>\
			<td>' + arr[i].id + '</td>\
			<td><a href="' + web_link + '?p=' + arr[i].id + '" target="_blank">' + arr[i].name + '</a>' + arr[i].color + arr[i].size + '</td>\
			<td>' + g_func.money_format( arr[i].price ) + '</td>\
			<td><input type="number" value="' + arr[i].quan + '" data-id="' + arr[i].id + '" class="change-update-cart-quantity s" size="5" maxlength="10" /></td>\
			<td>' + g_func.money_format( arr[i].price * arr[i].quan ) + '</td>\
		</tr>');
		
	}
	
	//
	$('.change-update-cart-quantity').change(function() {
		
		var oi = $(this).attr('data-id') || '',
			a = $(this).val();
		
		//
		for ( var i = 0; i < arr_global_js_order_details.length; i++ ) {
			if ( typeof arr_global_js_order_details[i].id != 'undefined'
			&& arr_global_js_order_details[i].id == oi ) {
				arr_global_js_order_details[i].quan = a;
			}
		}
		
		//
		___eb_admin_update_order_details();
		
	});
	
	
	
	
	//
//	console.log(cus);
	if ( typeof cus != 'object' ) {
		cus = $.parseJSON( unescape( cus ) );
		
		// kiểm tra lại mà vẫn thế -> lỗi
		if ( typeof cus != "object" ) {
			cus = {};
		}
	}
	console.log(cus);
	
	//
	arr_global_js_order_customter = cus;
	
	//
	$('#oi_hd_ten').val( cus['hd_ten'] );
	$('#oi_hd_dienthoai').val( cus['hd_dienthoai'] );
	$('#oi_hd_diachi').val( cus['hd_diachi'] );
	$('#oi_ghi_chu_cua_khach').html( cus['hd_ghichu'] );
	if ( typeof cus['hd_admin_ghichu'] != 'undefined' ) {
		$('#hd_admin_ghichu').val( cus['hd_admin_ghichu'] );
	}
	
	
	
	//
	var arr_dich = {
		'hd_url' : 'URL',
		'hd_referrer' : 'Nguồn',
		'hd_title' : 'Tiêu đề',
		'hd_timezone' : 'Múi giờ',
		'hd_lang' : 'Ngôn ngữ',
		'hd_usertime' : 'Giờ máy trạm',
		'hd_window' : 'Kích thước trình duyệt',
		'hd_document' : 'Kích thước văn bản',
		'hd_screen' : 'Màn hình/ Hệ điều hành',
		'hd_agent' : 'Trình duyệt',
	};
	
	for ( var x in arr_dich ) {
		if ( typeof cus[x] != 'undefined' ) {
			var a = cus[x];
			
			//
			if ( x == 'hd_usertime' ) {
//				if ( typeof cus[x] == 'string' ) {
				if ( cus[x].toString().split('1970').length > 1 ) {
					console.log( typeof cus[x] );
					cus[x] = $('.order-time-server').attr('data-time') || 0;
				}
				
				a = _date( 'd-m-Y H:i', cus[x] );
			}
			else if ( ( x == 'hd_url' || x == 'hd_referrer' ) && a != '' ) {
				a = '<a href="' + a + '" target="_blank" rel="nofollow">' + a + '</a>';
			}
			
			//
			$('.dulieu-thamkhao').append( '\
			<tr>\
				<td class="t">' + arr_dich[x] + '</td>\
				<td class="i">' + a + '</td>\
			</tr>' );
		}
	}
	
})();




//
$('.show-if-js-enable').show();
//dog('eb_cart_submit').disabled = false;

//dog('eb_cart_print').disabled = false;
$('#eb_cart_print').click(function () {
	window.open( web_link + 'billing_print?order_id=' + order_id, '_blank' );
});

//dog('eb_vandon_print').disabled = false;
$('#eb_vandon_print').click(function () {
	window.open( web_link + 'billing_print?order_id=' + order_id + '&f=print_van_don', '_blank' );
});



