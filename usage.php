<?php

// Include the Steam API
require 'steam-api.inc.php';

// Grab the API Key
require 'key.inc.php';

// Create a new instance
$api = new steamAPI(APIKEY);

var_dump($api->getFriendsList('76561197960435530', 'friend'));