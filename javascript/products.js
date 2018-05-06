


function WGR_admin_quick_edit_select_menu () {
	
	//
	$('.set-url-post-post-type').each(function() {
		var a = $(this).attr('data-type') || 'post';
		
		$(this).attr({
			href: window.location.href.split('&by_post_type=')[0].split('&by_taxonomy=')[0] + '&by_post_type=' + a
		});
	});
	
	//
	$('.set-url-taxonomy-category').each(function(index, element) {
		var a = $(this).attr('data-type') || 'post';
		
		$(this).attr({
			href: window.location.href.split('&by_post_type=')[0].split('&by_taxonomy=')[0] + '&by_taxonomy=' + a
		});
	});
	
	//
	if ( window.location.href.split('&by_taxonomy=').length > 1 ) {
		$('.set-url-taxonomy-category[data-type="' + by_taxonomy + '"]').addClass('bold');
	}
	/*
	else if ( window.location.href.split('&check_post_name=').length > 1 ) {
		$('.check-post-name').addClass('bold');
	}
	*/
	else {
		$('.set-url-post-post-type[data-type="' + by_post_type + '"]').addClass('bold');
	}
}




//
function WGR_click_open_quick_edit_seo () {
	
	//
	if ( dog('oi_eb_products') == null ) {
		$('#rAdminME').after('<div id="oi_eb_products" class="hide-if-press-esc"></div>');
	}
	
	//
	$('.click-open-quick-edit-seo').off('click').click(function () {
		
		// không cho bấm liên tiếp
		if ( waiting_for_ajax_running == true ) {
			console.log('waiting_for_ajax_running');
			return false;
		}
		waiting_for_ajax_running = true;
		
		//
		var a = $(this).attr('data-id') || '';
		
		if ( a == '' ) {
			return false;
		}
//		console.log(a);
		
		//
		$('#rAdminME').css({
			opacity: 0.2
		});
		$('#oi_eb_products').show();
		$('body').addClass('ebdesign-no-scroll');
		
		//
		ajaxl( 'products_seo&id=' + a + '&type=' + js_for_tax_or_post, 'oi_eb_products', 1, function () {
			$('#rAdminME').css({
				opacity: 1
			});
			
			waiting_for_ajax_running = false;
		});
	});
	
}



