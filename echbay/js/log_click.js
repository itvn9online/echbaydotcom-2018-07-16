


(function() {
	var str = '',
		arr = arr_click_list.slice(),
		jmp = $('.jmp-for-tr tbody').html() || $('.jmp-for-tr').html() || '',
		str_jmp = function(str, arr) {
			for (var x in arr) {
				var t = '{jmp.' + x + '}';
				var a = str.split(t);
				for (var i = 0; i < a.length; i++) {
					str = str.replace(t, decodeURIComponent(arr[x]));
				}
			}
			return str;
		},
		total_5phut = 0,
		total_30phut = 0,
		ip_exist = {},
		a = null;
	
	//
//	console.log( arr );
	
	// tăng chiều rộng table xem cho dễ
	if (arr.length == 0) {
		return false;
	}
	$('.table-log-click').width('200%');
	
	//
	var inner = $('.table-log-click');
	if ( $('.table-log-click tbody').length > 0 ) {
		inner = $('.table-log-click tbody');
	}
	
	//
	for (var i = 0; i < arr.length; i++) {
		a = arr[i];
		
		//
//		console.log( a.ip );
//		console.log( a['ip'] );
		if ( typeof ip_exist[ a.ip ] == 'undefined' ) {
			ip_exist[ a.ip ] = 1;
			
			a['total_ip'] = '';
		}
		else {
			ip_exist[ a.ip ] ++;
			
			a['total_ip'] = ' (' + ip_exist[ a.ip ] + ')';
		}
		
		//
		inner.append( str_jmp(jmp, a) );
		
		//
		/*
		if ( date_time - arr.ngay < 1800 ) {
			if ( date_time - arr.ngay < 300 ) {
				total_5phut++;
			}
			
			total_30phut++;
		}
		*/
	}
//	console.log( ip_exist );
	/*
	var check_jmp = str.split('{');
	if (check_jmp.length > 1) {
		console.log(check_jmp.length);
		for (var i = 0; i < check_jmp.length; i++) {
			console.log(check_jmp[i].split('}')[0]);
		}
	}
	*/
	
//	$('#oi_show_5_phut').html( total_5phut );
//	$('#oi_show_5_phut').html( total_30phut );
	
	
	//
	$('.table-log-click tr').each(function() {
		var a = $(this).attr('data-rel') || '';
		if (a != '') {
			$('.title-by-rel', this).attr({
				title: a
			});
			$('.link-by-rel', this).attr({
//				href: encodeURIComponent(a)
				href: a
			});
		}
	}).removeClass('title-by-rel').removeClass('link-by-rel');
	
	//
	$('.table-log-click .host-to-short').each(function() {
		var a = $(this).attr('title') || '';
		if ( a != '' ) {
//			console.log(a);
			$(this).html( a.split('//')[1].split('/')[0] );
		}
	});
	
	
	
	
	//
	var arr_ref_to_source = [],
		url_check_source_too = web_link.split('//')[1].split('/')[0].replace('www.', '');
	
	
	
	//
	$('.table-log-click .ref-to-source').each(function() {
		var a_title = $(this).attr('title') || '',
			a = a_title,
			url = '',
			url_lnk = '',
			url_inner = '',
			rel = '',
			rel_lnk = '',
			rel_inner = '',
			str_for_site = '',
			w = '';
		
		//
		if (a != '') {
			url = a.split('&url=');
			if (url.length == 1) {
				url = a.split('&rurl=');
			}
			rel = a.split('&ref=');
			try {
				a = a.split('//')[1].split('/')[0];
			} catch (e) {
				a = decodeURIComponent(a);
				console.log(a);
				a = a.split('//')[1].split('/')[0];
			}
			w = a.replace('www.', '').replace(/\./g, '/');
			if (typeof arr_ref_to_source[w] == 'undefined') {
				arr_ref_to_source[w] = 0;
			}
			arr_ref_to_source[w] += 1;
			if (url.length > 1) {
				url = url[1].split('&')[0];
				if (url.split(url_check_source_too).length > 1) {} else {
					try {
						url_lnk = decodeURIComponent(url);
						
						str_for_site = url_lnk.split('//')[1].split('/')[0].replace('www.', '');
						
						url_inner = '<a title="' + url_lnk + '" href="' + current_admin_link + '&for_site=' + str_for_site + '">' + str_for_site + '</a> <a title="' + url_lnk + '" href="' + url_lnk + '" target="_blank" rel="nofollow" class="greencolor click-open-new-link"> &rArr; </a>';
					} catch (e) {
						console.log(url);
					}
				}
			}
			
			//
			if (rel.length > 1) {
				rel = rel[1].split('&')[0];
				try {
					rel_lnk = decodeURIComponent(rel);
					
					str_for_site = rel_lnk.split('//')[1].split('/')[0].replace('www.', '');
					
					rel_inner = '<a title="' + rel_lnk + '" href="' + current_admin_link + '&for_site=' + str_for_site + '">' + str_for_site + '</a> <a title="' + rel_lnk + '" href="' + rel_lnk + '" target="_blank" rel="nofollow" class="greencolor click-open-new-link"> &rArr; </a>';
				} catch (e) {
					console.log(rel);
				}
			}
			
			//
			$(this).html(rel_inner + url_inner + '<a title="' + a_title + '" href="' + current_admin_link + '&for_site=' + a + '">' + a + '</a>');
		}
	}).removeClass('ref-to-source');
	
	
	
	
	
	//
	var arr_check_keyword = ['utm_source=', 'utm_medium=', 'utm_campaign='];
	
	
	$('.table-log-click .url-to-campaign').each(function() {
		var a = $(this).attr('title') || '';
		if (a != '') {
			try {
				a = decodeURIComponent(a)
			} catch (e) {
				a = a.replace(/&amp;/g, '&')
			}
			for (var i = 0; i < arr_check_keyword.length; i++) {
				if (a.split(arr_check_keyword[i]).length > 1) {
					a = a.split(arr_check_keyword[i])[1].split('&')[0];
					$(this).html(a);
					break
				}
			}
		}
	}).removeClass('url-to-campaign');
	
	
	
	var arr_check_keyword = ['?q=', '&q='];
	var arr_check_p_keyword = ['?p=', '&p='];
	
	
	
	function tach_lay_tu_khoa_tim_kiem(a) {
		if (a.substr(0, 4) == 'http') {
			return ''
		}
		if (a.length > 5) {
			var max_len = 20;
			if (a.length > max_len) {
				var a_space = a.split(' ');
				a = '';
				for (var j = 0; j < a_space.length; j++) {
					a += a_space[j];
					if (a.length > max_len) {
						if (j + 1 < a_space.length) {
							a += '...'
						}
						break
					}
					a += ' '
				}
			}
		}
		return a
	}
	
	
	
	$('.table-log-click .ref-to-keyword').each(function() {
		var a = $(this).attr('title') || '',
			a_title = '';
		if (a != '') {
			try {
				a = decodeURIComponent(a)
			} catch (e) {
				a = fix___decodeURIComponent(a);
				console.log(a)
			}
			var tim_thay_tu_khoa = false;
			for (var i = 0; i < arr_check_keyword.length; i++) {
				if (a.split(arr_check_keyword[i]).length > 1) {
					a_title = a.split(arr_check_keyword[i])[1].split('&')[0].replace(/\+/g, ' ').toString();
					$(this).html(tach_lay_tu_khoa_tim_kiem(a_title)).attr({
						title: a_title
					});
					tim_thay_tu_khoa = true;
					break
				}
			}
			if (tim_thay_tu_khoa == false && a.split('yahoo.com').length > 1) {
				for (var i = 0; i < arr_check_p_keyword.length; i++) {
					if (a.split(arr_check_p_keyword[i]).length > 1) {
						a_title = a.split(arr_check_p_keyword[i])[1].split('&')[0].replace(/\+/g, ' ').toString();
						$(this).html(tach_lay_tu_khoa_tim_kiem(a_title)).attr({
							title: a_title
						});
						break
					}
				}
			}
		}
	}).removeClass('ref-to-keyword');
	
	
	//
	_time_date();
	
	
	
	
	// Hiển thị tổng số
	(function () {
		$('.table-log-click').css({
			opacity: 1
		});
		
		//
		$('#oi_show_total_new').html( $('.table-log-click tr[data-return="0"]').length );
		$('#oi_show_total_return').html( $('.table-log-click tr[data-return="1"]').length );
		$('#oi_show_total_iframe').html( $('.table-log-click tr[data-iframe="1"]').length );
	})();



})();


