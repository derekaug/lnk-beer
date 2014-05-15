<?php
include_once(__DIR__ . '/../vendor_class/autoload.php');
Config::init();
$main_cb = filemtime(Config::$root . '/css/main.' . Config::$asset_type . '.css');
$main_css = '/css/main.' . Config::$asset_type . '.css?cb=' . $main_cb;
?>
<base href="<?php echo Config::$base_url; ?>" target="_self">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo $main_css; ?>">
<script src="/js/vendor/modernizr.js"></script>