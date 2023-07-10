<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
$res = $client->request('GET', 'https://rickandmortyapi.com/api/character/');

$data = json_decode($res->getBody(), true);

foreach ($data['results'] as $character) {
    echo 'Name: ' . $character['name'] . PHP_EOL;
    echo 'Species: ' . $character['species'] . PHP_EOL;
    echo 'Origin: ' . $character['origin']['name'] . PHP_EOL;
    echo 'Image: ' . $character['image'] . PHP_EOL;
    echo 'Episodes: ' . PHP_EOL;
    foreach ($character['episode'] as $episode) {
        echo ' - ' . $episode . PHP_EOL;
    }
    echo '-----------------------' . PHP_EOL;
}
?>
