


(function ( u ) {
	if ( act != '404' ) {
		return false;
	}
	
	var num = function (n) {
		return n.toString().replace(/[^0-9]/g, '');
	};
	
	var a = u.split('-'),
		new_url = '',
		b = 0;
	a = a[ a.length - 1 ];
	
	if ( a.split('.htm').length > 1 ) {
		var a0 = a.split('.')[0];
//		console.log(a0);
		
		if ( a0.substr(0, 1) == 'c' || a0.substr(0, 1) == 's' || a0.substr(0, 1) == 'f' ) {
			b = num(a0);
//			console.log(a0);
			
			if ( b > 0 ) {
				window.location = u.replace(/\-\-/gi, '-').replace( '-' + a, '' );
				return false;
			}
		}
		
		//
//		else {
			a = u.split('//')[1].split('/');
			a0 = a[1].substr(0, 1);
//			console.log(a0);
			
			if ( a0 == 'p' ) {
				b = num(a[1]);
//				console.log(b);
				
				if ( b > 0 ) {
//					a[1] = '';
//					new_url = 'https://' + a.join('/').replace('//', '/').replace('.html', '-p' + b + '.html');
					new_url = web_link + '?p=' + b;
				}
			}
			else if ( a0 == 'c' || a0 == 's' || a0 == 'f' ) {
				b = num(a[1]);
//				console.log(b);
				
				if ( b > 0 ) {
					a[1] = '';
					new_url = 'https://' + a.join('/').replace('//', '/').split('.htm')[0];
				}
			}
//		}
		
		if ( new_url != '' ) {
			console.log(new_url);
			window.location = new_url + '#jsredirect=1';
		}
	}
	/*
	else if ( u.split('/actions/thread&cid=').length > 1 ) {
		window.location = web_link + '?cat=' + u.split('/actions/thread&cid=')[1].split('&')[0] + '#jsredirect=1';
	}
	*/
}( window.location.href.split('?')[0] ));


