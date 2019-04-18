<?php


require 'vendor/autoload.php';

$client = new GuzzleHttp\Client([
        'base_uri' => 'https://easteregg.wildcodeschool.fr/api ',
    ]
);

$response = $client->request('GET', 'eggs');
$body=$response->getBody();
$content=$body->getContents();
var_dump($content);

