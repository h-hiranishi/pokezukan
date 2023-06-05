<?php

$cache_path = __DIR__ . "/cache/";
$cache_limit = 86400;

function get_contents($url) {
    global $cache_limit;
    global $cache_path;
    $file_name = md5($url);
    $cache_file_path = $cache_path . $file_name;
    if ( file_exists($cache_path) && time() < filemtime($cache_file_path) + $cache_limit ) {
        $file_handler = fopen($cache_file_path, "r");
        $data = fread($file_handler, filesize($cache_file_path));
        fclose($file_handler);
        return json_decode($data, true);
    }
    $response = file_get_contents($url);
    $file_handler = fopen($cache_file_path, "w");
    fwrite($file_handler, $response);
    return json_decode($response, true);
}