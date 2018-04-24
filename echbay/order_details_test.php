<?php

// TEST
echo '<!--' . "\n";

print_r( $sql );

/*
$strsql = _eb_q("SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		post_author = " . $sql->post_author . "
	ORDER BY
		ID DESC" );
if ( count($strsql) > 0 ) {
	$strsql = $strsql[0];
	print_r( $strsql );
	
	// lấy thời gian gửi đơn hàng trước đó, mỗi đơn cách nhau tầm 5 phút
	$lan_gui_don_truoc = strtotime( $strsql->post_date );
	echo date( 'r', $lan_gui_don_truoc ) . "\n";
	echo date_time - $lan_gui_don_truoc . "\n";
}
*/

echo "\n" . '-->';
// END TEST
