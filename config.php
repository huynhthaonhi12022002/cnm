<?php
// Load Google API client library
require './vendor/autoload.php';

// Add your client ID and Secret
$client_id = '806943956-5i3jnf20h8dh6ra8mvmluo9qbs23kjjn.apps.googleusercontent.com';
$client_secret = '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';

// Initialize Google client
$client = new Google\Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);

// Set redirection URI to login.php path
$redirect_uri = 'http://localhost/cnm/login.php';
$client->setRedirectUri($redirect_uri);

// Add required scopes for accessing email and profile information
$client->addScope("email");
$client->addScope("profile");