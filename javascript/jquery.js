


//
console.log( typeof $ );
if ( typeof jQuery == 'function' ) {
	$ = jQuery;
}
else {
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = jquery_mod_by_echbay_path;
	head.appendChild(script);
}
console.log( typeof $ );
console.log( typeof jQuery );





