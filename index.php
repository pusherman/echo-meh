<?php

set_error_handler(function($severity, $message, $file, $line) {
  throw new ErrorException($message, $severity, $severity, $file, $line);
});

$mehKey = $_SERVER['meh_api_key'];

try {
  $meh = json_decode(file_get_contents("https://api.meh.com/1/current.json?apikey=$mehKey"));

} catch (Exception $e) {
  echo "Unable to access meh frown face\n";

}

print_r($meh->deal->title);
