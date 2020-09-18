<?php

$input = json_decode(file_get_contents('php://input'), true);

$topic = $input['params']['topic'];

$xml = 'https://news.google.com/rss/search?q='.$topic.'&hl=it&gl=IT&ceid=IT:it';

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

$returnValues = array();

//get elements from "<channel>"
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
$channel_title = $channel->getElementsByTagName('title')
->item(0)->childNodes->item(0)->nodeValue;
$channel_link = $channel->getElementsByTagName('link')
->item(0)->childNodes->item(0)->nodeValue;
$channel_desc = $channel->getElementsByTagName('description')
->item(0)->childNodes->item(0)->nodeValue;

$x=$xmlDoc->getElementsByTagName('item');
$i=0;


for ($i=0; $i<=20; $i++) {
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue;

  $returnValues[$i]['title'] = $item_title;
  $returnValues[$i]['link'] = $item_link;
  $returnValues[$i]['description'] = $item_desc;
  
  $i++;
  
}

echo json_encode($returnValues, JSON_FORCE_OBJECT);

?>