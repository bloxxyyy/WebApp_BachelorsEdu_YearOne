<?php

// start van het project.

// helper func laden van files.
function load(string $name) : bool {
    if (file_exists($name. '.php')) {
        require_once ("{$name}.php");
        return true;
    }

    return false;
}

// als een standard file niet bestaat gooi 404.
if (!load('App') || !load('Controller') || !load('Model') || !load('Authorization')) {
    header("HTTP/1.0 404 Not Found");
    if (!load('404')) echo "404";
    die;
}

session_start(); // start de sessie.

// Snij de url in stukken.
$url = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($url);
$parsedUrlParts = explode("/", $parsedUrl['path']);

// voor de grote van het pad. Voeg extra directory traversal toe zodat bestanden overal goed laden.
$path = "../../";
if (count($parsedUrlParts) > 3) {
    $amount = count($parsedUrlParts) - 3;
    for ($i = 0; $i < $amount; $i++) {
        $path .= "../";
    }
}

define('ROOT', $path); // zet ROOT voor het makkelijk laden van bestanden.

// remove the first key since it is always empty.
array_shift($parsedUrlParts);

// Set the controller.
$controller = $parsedUrlParts[0];
if ($controller === '') $controller = 'Home';

array_shift($parsedUrlParts);

// Set the method.
$method = '';
if (sizeof($parsedUrlParts) > 0) $method = $parsedUrlParts[0];
if ($method == '') $method = 'Pagina';

$args=[]; // zet de args in de $args var.
if (sizeof($parsedUrlParts) > 0) {
  array_shift($parsedUrlParts);

  if (sizeof($parsedUrlParts) > 0){
    $args=$parsedUrlParts;
  }
}

// Roep App aan.
new App($controller, $method, $args);
