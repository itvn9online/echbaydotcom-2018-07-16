


var arr_global_js_order_details = [];

function ___eb_admin_update_order_details () {
	if ( arr_global_js_order_details.length == 0 ) {
		return false;
	}
	
	// gán thông tin cho khách hàng từ form
//	console.log( arr_global_js_order_details );
	var custom_info = arr_global_js_order_details[ arr_global_js_order_details.length - 1 ];
//	console.log( custom_info );
	custom_info['__eb_hd_ten'] = $('#oi_hd_ten').val();
	custom_info['__eb_hd_dienthoai'] = $('#oi_hd_dienthoai').val();
	custom_info['__eb_hd_diachi'] = $('#oi_hd_diachi').val();
//	console.log( custom_info );
	
	// lưu lại
	arr_global_js_order_details[ arr_global_js_order_details.length - 1 ] = custom_info;
//	console.log( arr_global_js_order_details );
	
	//
	$('#oi_post_excerpt').val( JSON.stringify( arr_global_js_order_details ) );
	
	//
//	console.log('TEST');
	return true;
}


//
(function ( arr ) {
	if ( typeof arr != 'object' ) {
		return false;
	}
	console.log(arr);
//	console.log(arr.length);
	
	//
	arr_global_js_order_details = arr.slice();
	
	//
	for ( var i = 0; i < arr.length; i++ ) {
		console.log(arr[i]);
		
		//
		if ( typeof arr[i].__eb_hd_customer_info != 'undefined' ) {
			
			//
			window.ebe_arr_cart_customer_info = arr[i];
			
			//
			$('#oi_hd_ten').val( arr[i].__eb_hd_ten );
			$('#oi_hd_dienthoai').val( arr[i].__eb_hd_dienthoai );
			$('#oi_hd_diachi').val( arr[i].__eb_hd_diachi );
			
			//
			$('#oi_ghi_chu_cua_khach').html( arr[i].__eb_hd_ghichu );
			
			//
			$('.dulieu-thamkhao').append( '\
			<tr>\
				<td title="IP">IP</td>\
				<td>' + arr[i].__eb_hd_ip + '</td>\
			</tr>' );
			
			// thông tin khách hàng (dùng để kiểm soát)
			var custom_info = arr[i].__eb_hd_customer_info;
			//console.log(custom_info);
			custom_info = custom_info.replace( /\&quot\;/g, '"' );
			//console.log(custom_info);
			custom_info = eval( '[' + custom_info + ']' );
			custom_info = custom_info[0];
//			console.log(custom_info);
			
			//
			var arr_dich = {
				'hd_url' : 'URL',
				'hd_title' : 'Tiêu đề',
				'hd_timezone' : 'Múi giờ',
				'hd_lang' : 'Ngôn ngữ',
				'hd_usertime' : 'Giờ máy trạm',
				'hd_window' : 'Kích thước trình duyệt',
				'hd_document' : 'Kích thước văn bản',
				'hd_screen' : 'Màn hình/ Hệ điều hành',
				'hd_agent' : 'Trình duyệt',
			};
			
			//
			for ( var x in custom_info ) {
				if ( x == 'hd_usertime' ) {
					custom_info[x] = _date( 'd-m-Y H:i', custom_info[x] );
				}
				
				//
				$('.dulieu-thamkhao').append( '\
				<tr>\
					<td title="' + arr_dich[x] + '">' + arr_dich[x] + '</td>\
					<td>' + custom_info[x] + '</td>\
				</tr>' );
			}
		} else {
			
			window.ebe_arr_cart_product_list.push( arr[i] );
			
			//
			if ( arr[i].color != '' ) {
				arr[i].color = ' - ' + arr[i].color;
			}
			if ( arr[i].size != '' ) {
				arr[i].size = ' (Size: ' + arr[i].size + ')';
			}
			
			//
			$('.order-danhsach-sanpham').append('\
			<tr>\
				<td>' + arr[i].id + '</td>\
				<td><a href="day-lung-nam-mat-audi-da-bo-khoa-tu-dong-vas36095-p39352.html" target="_blank">' + arr[i].name + '</a>' + arr[i].color + arr[i].size + '</td>\
				<td>' + g_func.money_format( arr[i].price ) + '</td>\
				<td><input type="number" value="' + arr[i].quan + '" data-id="' + arr[i].id + '" class="change-update-cart-quantity" size="5" maxlength="10" /></td>\
				<td>' + g_func.money_format( arr[i].price * arr[i].quan ) + '</td>\
			</tr>');
		}
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
		console.log( arr_global_js_order_details );
	});
	
	
	//
	console.log( window.ebe_arr_cart_product_list );
	console.log( window.ebe_arr_cart_customer_info );
	
})( order_details_arr_cart_product_list );



