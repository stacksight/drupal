<?php

define('stacksight_logs_title', 'Include Logs (<i>Beta</i>)');
$logs_text = <<<HTML
    <div>Real time logging information of warnings and errors</div>
HTML;
define('stacksight_logs_text', $logs_text);


define('stacksight_health_title', 'Include Health');
$health_text = <<<HTML
    <div>Build a complete health profile</div>
HTML;
define('stacksight_health_text', $health_text);


define('stacksight_inventory_title', 'Include Inventory');
$inventory_text = <<<HTML
    <div>Collects the list of plugins, modules and packagesy</div>
HTML;
define('stacksight_inventory_text', $inventory_text);


define('stacksight_events_title', 'Include Events');
$events_text = <<<HTML
    <div>Watch users and application events at real time</div>
HTML;
define('stacksight_events_text', $events_text);


define('stacksight_updates_title', 'Include Updates');
$updates_text = <<<HTML
    <div>Show aviliabilty of new software updates</div>
HTML;
define('stacksight_updates_text', $updates_text);