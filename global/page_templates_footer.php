<?php

// get custom content
$main_content = ob_get_contents();

//
ob_end_clean();

// show content
include_once EB_THEME_URL . 'index.php';
