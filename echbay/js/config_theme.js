



show_note_for_checkbox_config( 'cf_using_top_default' );
show_note_for_checkbox_config( 'cf_using_footer_default' );

$('#cf_using_top_default').click(function () {
	if ( dog('cf_using_top_default').checked == true ) {
		$('.show-if-using-top-default').show();
	} else {
		$('.show-if-using-top-default').hide();
	}
});
if ( dog('cf_using_top_default').checked == true ) {
	$('.show-if-using-top-default').show();
} else {
	$('.show-if-using-top-default').hide();
}

$('#cf_using_footer_default').click(function () {
	if ( dog('cf_using_footer_default').checked == true ) {
		$('.show-if-using-footer-default').show();
	} else {
		$('.show-if-using-footer-default').hide();
	}
});
if ( dog('cf_using_footer_default').checked == true ) {
	$('.show-if-using-footer-default').show();
} else {
	$('.show-if-using-footer-default').hide();
}




// đổi hiệu ứng slected khi người dụng chọn design
$('.click-add-class-selected').click(function () {
	var a = $(this).attr('data-key') || '',
		img = $(this).attr('data-img') || '',
		val  = $(this).attr('data-val ') || '',
		size = $(this).attr('data-size') || '';
	if ( a != '' ) {
		$('.click-add-class-selected[data-key="' + a + '"]').removeClass('selected');
		$(this).addClass('selected');
		
		//
		var jPro = $('.click-to-change-file-design[data-key="' + a + '"]');
		
		jPro.css({
			'background-image' : 'url(\'' + img + '\')'
		});
		
		if ( val == '' && img == '' ) {
			jPro
//			.hide()
			.html( $(this).attr('title') )
			.height('auto')
			;
		}
		else {
			jPro
//			.show()
			.html( '&nbsp;' )
			;
			
			if ( size != '' ) {
				jPro.height( jPro.width() * eval(size) );
			}
		}
	}
});

$('.click-add-class-selected').each(function () {
	var a = $('input[type="radio"]', this).attr('id') || '';
	if ( a != '' ) {
		if ( dog( a ).checked == true ) {
			$(this).click();
		}
	}
});




//
$('.click-to-exit-design').click(function () {
	$('.change-eb-design-fixed').hide();
});

$(document).keydown(function(e) {
	if (e.keyCode == 27) {
		$('.click-to-exit-design').click();
	}
});



// click hiển thị khung chọn file design
$('.click-to-change-file-design').click(function () {
	var key = $(this).attr('data-key') || '',
		text = g_func.text_only(key);
//	console.log(key);
//	console.log(text);
	
	$('.change-eb-design-fixed').hide();
	$('.change-eb-design-fixed[data-key="' + text + '"]').show().addClass('selected');
	
	// Căn chỉnh lại size cho phần chọn thiết kế
	$('.preview-in-ebdesign').hide();
	$('.preview-in-ebdesign[data-key="' + key + '"]').show();
	$('.preview-in-ebdesign').each(function(index, element) {
		var a = $(this).attr('data-size') || '';
		if ( a != '' ) {
			$(this).height( $(this).width() * eval(a) );
		}
	});
	
	// xóa class định hình sau khi xong việc
	setTimeout(function () {
		$('.change-eb-design-fixed').removeClass('selected');
	}, 600);
});



