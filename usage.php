<?php

// Include the Steam API
require 'steam-api.inc.php';

// Grab the API Key
require 'key.inc.php';

// Create a new instance
$api = new steamAPI(APIKEY);

echo '<pre>';
print_r($api->getFriendsList('76561198067518616', 'friend'));
echo '</pre>';