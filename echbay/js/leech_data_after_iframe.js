


function WGR_leech_data_run_in_iframe ( i ) {
	if ( typeof i != 'number' ) {
		i = 5;
	}
	else if ( i < 0 ) {
		top.WGR_leech_data_after_load_iframe();
		
		return true;
	}
	console.log('Scroll to bottom iframe: ' + i);
	
	jQuery('body,html').animate({
		scrollTop: jQuery(document).height()
	}, 800);
	
	setTimeout(function () {
		WGR_leech_data_run_in_iframe( i - 1 );
	}, 1200);
	
	return false;
}



if ( top != self ) {
	if ( typeof jQuery == 'function' ) {
		WGR_leech_data_run_in_iframe();
	}
	else {
		top.WGR_leech_data_after_load_iframe();
	}
}



