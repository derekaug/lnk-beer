<?php
include_once(__DIR__ . '/../vendor_class/autoload.php');
Config::init();
$vendor_cb = filemtime(Config::$root . '/js/vendor.' . Config::$asset_type . '.js');
$vendor_js = '/js/vendor.' . Config::$asset_type . '.js?cb=' . $vendor_cb;
?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::$API_GOOGLE_MAPS; ?>&sensor=TRUE"></script>
    <script>
        if (!window.jQuery) {
            document.write('<script src="/js/vendor/jquery.min.js"><\/script>');
        }
    </script>
    <script src="<?php echo $vendor_js; ?>"></script>
<?php
include_once('globals.php');
include_once('templates.php');
?>