<?php



//
//phpinfo();

//
//print_r( $_SERVER );

//
echo '<table border="0" cellpadding="0" cellspacing="0" class="eb-public-table">';

//
foreach ( $_SERVER as $k => $v ) {
	if ($k == 'HTTP_COOKIE') {
		$v = '<strong>F12</strong>';
	}
	
	//
	echo '
	<tr>
		<td class="t">' . $k . '</td>
		<td class="i">' . $v . '</td>
	</tr>';
}



//
echo '</table>';


