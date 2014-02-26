<?php

/**
 * This bootstrap file is the real starting point for the application.
 *
 * It is required from the public index.php, and is used as the backbone of the application.
 * Every request starts and ends in this file.
 */

# Super Primitive Router #

$request_uri = explode("?", $_SERVER["REQUEST_URI"]);
$request_uri = $request_uri[0];
$request_uri = trim($request_uri, "/");
$methodPath = $_SERVER["REQUEST_METHOD"] == "GET" ? "/pages/" : "/processing/";

$includePath = APP_ROOT . $methodPath . $request_uri;
if (is_dir($includePath)) $includePath .= "index";
$includePath .= ".php";
if (file_exists($includePath)) {
    require_once $includePath;
}
else {
    header("HTTP/1.1 404 Not Found");
    require_once APP_ROOT . "/pages/404.php";
}
