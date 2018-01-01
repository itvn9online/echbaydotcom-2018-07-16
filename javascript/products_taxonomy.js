

//
WGR_admin_quick_edit_select_menu();

//
function WGR_admin_quick_edit_taxonomy ( connect_to, url_request, parameter ) {
	
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
	WGR_admin_quick_edit_taxonomy( 'products', $(this).attr('data-ajax') || '' );
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
	WGR_admin_quick_edit_taxonomy( 'products', $(this).attr('data-ajax') || '', a );
});




/*
* Thêm nhiều nhóm 1 lúc
*/
eb_drop_menu('oiAnt');

function WGR_check_create_taxonomy () {
	if ( $.trim( $('#t_multi_taxonomy').val() ) == '' ) {
		$('#t_multi_taxonomy').focus();
		alert('Nhập danh sách nhóm cần thêm');
		return false;
	}
	
	return true;
}

function WGR_after_create_taxonomy ( m ) {
	$('#create_taxonomy_result').append( m + '<br>' );
}

$('.click-show-quick-add-taxonomy').click(function () {
	$('.show-quick-add-taxonomy').toggle('slow');
	$('#t_multi_taxonomy').focus();
});




