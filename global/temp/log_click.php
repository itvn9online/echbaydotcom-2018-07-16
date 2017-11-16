<?php



$a = _eb_getCucki('eb_wgr_log_click');
//echo $a;


if ( $a != '' ) {
	_eb_log_click($a);
}


