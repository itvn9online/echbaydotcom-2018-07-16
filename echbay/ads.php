<?php


//echo admin_url() . 'edit.php?post_type=ads';

//header('Location: ' . admin_url() . 'edit.php?post_type=ads', true, 301);


die('<script type="text/javascript">
window.location = "' . admin_url() . 'edit.php?post_type=ads";
</script>');



