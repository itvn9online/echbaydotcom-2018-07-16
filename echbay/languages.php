<?php



//
global $___eb_lang;


//
//print_r( $___eb_lang );




?>

<div class="wrap">
	<h1>Bản dịch</h1>
</div>
<p>* Bạn có thể thay đổi các bản dịch, cụm từ trên website sang nội dung khác phù hợp với website của bạn hơn. Bấm đúp chuột vào cụm từ cần thay đổi, nhập từ mới rồi enter.</p>
<table border="0" cellpadding="0" cellspacing="0" width="99%" class="table-list">
	<tr class="table-list-title">
		<td width="20%">Key</td>
		<td width="80%">Value</td>
	</tr>
	<?php
	foreach ( $___eb_lang as $k => $v ) {
		echo '
		<tr>
			<td>' . str_replace( eb_key_for_site_lang, '', $k ) . '</td>
			<td id="' . $k . '" class="click-to-update-url-lang cur">' . $v . '</td>
		</tr>';
	}
	?>
</table>
<br>
<br>
<script type="text/javascript">

//
var cache_for_current_lang_edit = '';

function EBE_click_to_update_site_lang () {
	$('.click-to-update-url-lang').off('dblclick').dblclick(function () {
		var a = $(this).html() || '',
			b = $(this).attr('id') || '',
			c = '';
		cache_for_current_lang_edit = a;
		
		//
		if ( b != '' ) {
			
			//
			c = prompt( 'Translate:', a );
//			console.log(c);
			
			//
			if ( c != null && c != cache_for_current_lang_edit ) {
	//			console.log('ajax update');
				ajaxl('languages_update&text=' + encodeURIComponent( c ) + '&key=' + b + '&no_echo=1', b, 1);
			}
		}
	});
}

//
EBE_click_to_update_site_lang();

</script> 
