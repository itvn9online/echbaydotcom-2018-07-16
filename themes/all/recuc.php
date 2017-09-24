<?php 
/*
* alias tới theme mà mình muốn dùng cho recuc
*/
$theme_alias_name = 'estyle';

include EB_THEME_PLUGIN_INDEX . 'themes/all/' . $theme_alias_name . '.php';

$eb_all_themes_support["recuc"] = $eb_all_themes_support["estyle"];
