<?php
require_once 'vendor/autoload.php';

$uri = 'mongodb+srv://kvtomi3:12345@kevlar.zxliddq.mongodb.net/';
$client = new MongoDB\Client($uri);

//$databases = $client->listDatabases();
$db = $client->sample_mflix;
//$collections = $db->listCollectionNames();
$moviesCollection = $db->movies;

/*$insert = $moviesCollection->insertOne([
    'title' => 'Az új filmem címe',
    'year' => date('Y'),
    'runtime' => 123
]);
var_dump($insert);
var_dump($insert->getInsertedCount());
var_dump($insert->getInsertedId());*/

$list = $moviesCollection->find(
            ['year' => ['$gte' => 2000], 'runtime' => ['$gte' => 100]], 
            [ 'projection' => ['title' => 1, 'year' => 1, 'runtime' => 1], 'limit' => 20 ]
        );
echo '<h2>Movies:</h2><ul>';
foreach($list as $item)
{
    echo '<li>'. $item->title .' ('. $item->year .') - '. $item->runtime .' min</li>';
}
echo '</ul>';

//_id: ObjectId('573a1392f29313caabcda1e3')
$id = new MongoDB\BSON\ObjectId('573a1392f29313caabcda619');
$item = $moviesCollection->findOne(['_id' => $id]);
echo '<h2>A keresett film:</h2>';
echo '<p>Címe: '. $item->title .'</p>';
echo '<p>Azonosítója: '. $item->_id .'</p>';