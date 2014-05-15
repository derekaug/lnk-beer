<?php
include_once(__DIR__ . '/../vendor_class/autoload.php');
Config::init();
// get checkins either from cache or API
$key = 'get_checkins';
$checkins = null;
$cache = new Cache(__DIR__ . '/../cache');
$cached = $cache->retrieve($key);
if(empty($cached)){
    // cache miss, retrieve old
    $untappd = new Untappd(Config::$API_UNTAPPD_KEY, Config::$API_UNTAPPD_SECRET);
    $checkins = $untappd->thePubLocal(array('lat'=>Config::$CENTER_LAT, 'lng'=>Config::$CENTER_LNG));
    $checkins = json_encode($checkins);
    $cache->add($key, $checkins, Config::$CACHE_UNTAPPD_TTL);
}
else {
    // cache hit
    $checkins = $cached;
}
// need some type of browser caching here
header('Content-type: application/json');
echo $checkins;
exit();