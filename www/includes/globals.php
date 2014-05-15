<?php
include_once(__DIR__ . '/../vendor_class/autoload.php');
Config::init();
//passes globals from php to js
?>
<script>
    var GLOBALS = {
        'center_lat': <?php echo Config::$CENTER_LAT; ?>,
        'center_lng': <?php echo Config::$CENTER_LNG; ?>
    };
</script>