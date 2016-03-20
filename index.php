<?php

try {
  $deal = fetch_deal();
  $textResponse = sprintf("Today's deal is a %s for only %s dollars", $deal['product'], $deal['price']);

} catch (Exception $e) {
  $textResponse = "unable to connect to meh, i blame shawn";
}

$speach = [
  'type' => 'PlainText',
  'text' => $textResponse
];

$response = [
  'version' => '0.1',
  'response' => ['outputSpeech' => $speach],
  'shouldEndSession' => true
];


header('Content-Type: application/json');
print json_encode($response);


function fetch_deal() {
  set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, $severity, $severity, $file, $line);
  });

  $mehKey = $_SERVER['meh_api_key'];
  $meh = json_decode(file_get_contents("https://api.meh.com/1/current.json?apikey=$mehKey"));

  return [
    'product' => $meh->deal->title,
    'price' => $meh->deal->items[0]->price
  ];
}
