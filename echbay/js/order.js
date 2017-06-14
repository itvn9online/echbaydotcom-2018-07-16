//console.log( typeof $ );

//
function post_excerpt_to_prodcut_list (arr, cus) {
//	console.log( typeof $ );
//	console.log( typeof jQuery );
	
	if ( typeof arr != 'object' ) {
		arr = $.parseJSON( unescape( arr ) );
		
		// kiểm tra lại mà vẫn thế -> lỗi
		if ( typeof arr != "object" ) {
			console.log( "cart value not found" );
			return false;
		}
	}
//	console.log(arr);
	
	if ( typeof cus != 'object' ) {
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
		f_tr.find('.eb-to-product').append( '<div><a href="' + web_link + '?p=' + arr[i].id + '" target="_blank">- ' + arr[i].name + '</a></div>' );
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


