<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Admin log</a></div>
<br>
<?php





$a = _eb_get_log_admin( " LIMIT 0, 100 " );
//print_r($a);


echo '<ol>';

foreach ( $a as $v ) {
	echo '<li>' . $v->meta_value . '</li>';
}

echo '</ol>';




