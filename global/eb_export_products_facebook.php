<?php



echo '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
	<channel>
		<title>' . web_name . '</title>
		<link>' . web_link . '</link>
		<description>' . $__cf_row['cf_description'] . '</description>';


//
$rss_brand = explode( '.', $_SERVER['HTTP_HOST'] );
$rss_brand = $rss_brand[0];



foreach ( $sql as $v ) {
	$p_link = _eb_p_link( $v->ID );
	
echo '<item>
	<g:id>' . $v->ID . '</g:id>
	<g:availability>' . ( _eb_get_post_object( $v->ID, '_eb_product_buyer', 0 ) < _eb_get_post_object( $v->ID, '_eb_product_quantity', 0 ) ? 'in stock' : 'out of stock' ) . '</g:availability>
	<g:condition>new</g:condition>
	<g:description><![CDATA[' . $v->post_excerpt . ']]></g:description>
	<g:image_link>' . _eb_get_post_img( $v->ID ) . '</g:image_link>
	<g:link>' . $p_link . '</g:link>
	<g:title><![CDATA[' . $v->post_title . ']]></g:title>
	<g:price>' . _eb_float_only( _eb_get_post_object( $v->ID, '_eb_product_price', 0 ) ) . ' VND</g:price>
	<g:brand>' . $rss_brand . '</g:brand>
</item>';


}



echo '</channel>
</rss>';



