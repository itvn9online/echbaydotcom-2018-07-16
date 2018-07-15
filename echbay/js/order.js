//console.log( typeof $ );


//
function post_excerpt_to_prodcut_list (arr, cus) {
//	console.log( typeof $ );
//	console.log( typeof jQuery );
	
//	console.log(arr);
	if ( typeof arr != 'object' ) {
		if ( arr == '' ) {
			console.log('arr not found');
			return false;
		}
		
		arr = $.parseJSON( unescape( arr ) );
		
		// kiểm tra lại mà vẫn thế -> lỗi
		if ( typeof arr != "object" ) {
			console.log( "cart value not found" );
			return false;
		}
	}
//	console.log(arr);
	
	if ( typeof cus != 'object' ) {
		if ( cus == '' ) {
			console.log('cus not found');
			return false;
		}
		
		try {
			cus = $.parseJSON( unescape( cus ) );
		} catch (e) {
			arr = {};
		}
	}
//	console.log(cus);
	
	//
	var f_tr = $('tr.eb-set-order-list-info:first');
	
	//
	for ( var i = 0; i < arr.length; i++ ) {
		
		if ( arr[i].color != '' ) {
			arr[i].color = $.trim( arr[i].color );
			if ( arr[i].color.substr( 0, 1 ) != '-' ) {
				arr[i].color = '- ' + arr[i].color;
			}
			
			arr[i].name += ' ' + arr[i].color;
		}
		
		if ( arr[i].size != '' ) {
			arr[i].size = $.trim( arr[i].size );
			if ( arr[i].size.substr( 0, 1 ) != '(' ) {
				arr[i].size = '(Size: ' + arr[i].size + ')';
			}
			
			arr[i].name += ' ' + arr[i].size;
		}
		
		//
		f_tr.find('.eb-to-product').append( '<div><a href="' + web_link + '?p=' + arr[i].id + '" target="_blank">- ' + arr[i].name + ' x ' + arr[i].quan + ' <i class="fa fa-eye bluecolor"></i></a></div>' );
		
	}
	
	//
	f_tr.find('.eb-to-adress').html( cus['hd_diachi'] );
	f_tr.find('.eb-to-phone').html( cus['hd_dienthoai'] );
	
	// xong là xóa luôn ông tr này đi
	f_tr.removeClass('eb-set-order-list-info');
	
	//
//	document.write( '<div><a href="' + web_link + '?p=' + arr.id + '" target="_blank">' + arr.name + '</a></div>' );
}


function post_excerpt_to_prodcut_list_v1 (arr) {
//	console.log( typeof $ );
//	console.log( typeof jQuery );
	
	if ( typeof arr != 'object' ) {
		return false;
	}
//	console.log(arr);
	
	//
	var f_tr = $('tr.eb-set-order-list-info:first');
	
	//
	for ( var i = 0; i < arr.length; i++ ) {
		if ( typeof arr[i].__eb_hd_customer_info != 'undefined' ) {
			f_tr.find('td.eb-to-adress').html( arr[i].__eb_hd_diachi );
			f_tr.find('td.eb-to-phone').html( arr[i].__eb_hd_dienthoai );
		} else {
			f_tr.find('td.eb-to-product').append( '<div><a href="' + web_link + '?p=' + arr[i].id + '" target="_blank">' + arr[i].name + '</a></div>' );
		}
		
		// xong là xóa luôn ông tr này đi
		f_tr.removeClass('eb-set-order-list-info');
	}
	
	//
//	document.write( '<div><a href="' + web_link + '?p=' + arr.id + '" target="_blank">' + arr.name + '</a></div>' );
}



function invoice_func_check_search () {
	var f = document.frm_search_invoice;
	
	if ( f.invoice_key.value == '' ) {
		f.invoice_key.focus();
		return false;
	}
	
	// chuyển sang viết HOA nếu là tìm theo mã đơn
	if ( f.type_search.value == 'id' ) {
		f.invoice_key.value = f.invoice_key.value.toUpperCase();
	}
	
	// chuẩn định dạng trước khi submit
	f.invoice_key.value = escape( unescape( f.invoice_key.value ) );
	
	//
	return true;
}



function click_set_search_order_by_type () {
	$('.click-search-by-type a').off('click').click(function () {
		var a = $(this).attr('data-type') || '';
		
		if ( a != '' ) {
			var f = document.frm_search_invoice;
			
			// gán giá trị mới, và lưu cookie để sử dụng lần sau
			f.type_search.value = a;
			g_func.setc('eb_admin_order_type_search', a, 0, 7);
			
			if ( invoice_func_check_search() == true ) {
				f.submit();
			}
			else {
				$('.click-search-by-type a').removeClass('bold');
				$(this).addClass('bold');
			}
		}
	});
	
	//
	var f = document.frm_search_invoice;
	
	//
//	console.log( f.invoice_key.value );
	if ( f.invoice_key.value != '' ) {
		// hiển thị định dạng gốc cho người dùng còn nhìn
		f.invoice_key.value = unescape( f.invoice_key.value );
	}
//	console.log( f.invoice_key.value );
	
	//
	if ( f.type_search.value == '' ) {
		$('.click-search-by-type a:first').addClass('bold');
	}
	else {
		$('.click-search-by-type a[data-type="' + f.type_search.value + '"]').addClass('bold');
	}
}


//
setTimeout(function () {
	$('.each-to-count-tab').each(function() {
		var a = $(this).attr('data-id') || '',
			c = $(this).html();
		if ( c != '0') {
			if ( c.toString().length > 3 ) {
				c = g_func.number_format(c);
			}
			
			//
			$('#show_count_order_by' + a).html( c ).attr({
				'data-value' : c
			});
		}
	});
}, 200);


