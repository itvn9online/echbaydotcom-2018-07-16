<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">User log</a></div>
<br>
<?php





$a = _eb_get_log_user( " LIMIT 0, 100 " );
//print_r($a);


echo '<ol>';

foreach ( $a as $v ) {
	echo '<li>' . $v->meta_value . '</li>';
}

echo '</ol>';




