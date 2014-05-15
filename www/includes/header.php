<?php
include_once(__DIR__ . '/../vendor_class/autoload.php');
Config::init();
$cache = new Cache(__DIR__ . '/../cache');
$updated_at = date('c', $cache->created('get_checkins'));
?>
<header>
    <h1>#LNK Beer</h1>

    <p>
        Click on pint for more details. Check-ins courtesy of <a href="http://untappd.com/" target="_blank">Untappd</a>.
    </p>
    <span class="last-update">
        Last Update:
        <span id="update-time"><?php echo $updated_at; ?></span>
    </span>
</header>
<div id="loading">
    <img src="/img/loading.gif" alt="Loading..." />
</div>