<?php
include_once(__DIR__ . '/vendor_class/autoload.php');
Config::init();
$beer_cb = filemtime(Config::$root . '/js/beer.' . Config::$asset_type . '.js');
$beer_js = '/js/beer.' . Config::$asset_type . '.js?cb=' . $beer_cb;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <?php include_once(Config::$root . '/includes/head.php'); ?>
    <title>LNK Beer</title>
</head>
<body>
<?php include_once(Config::$root . '/includes/header.php'); ?>
<div id="beer-map"></div>
<?php include_once(Config::$root . '/includes/footer.php'); ?>
<script src="<?php echo $beer_js; ?>"></script>
</body>
</html>