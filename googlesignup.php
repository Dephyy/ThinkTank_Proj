<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientID("114939517340-q6q506u2ijblohf6a0m5sinfvvhkptek.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/Thinktank/home.html");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();