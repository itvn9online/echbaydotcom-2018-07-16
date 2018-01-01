


function WGR_admin_quick_edit_select_menu () {
	
	//
	$('.set-url-post-post-type').each(function(index, element) {
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
	else {
		$('.set-url-post-post-type[data-type="' + by_post_type + '"]').addClass('bold');
	}
}



