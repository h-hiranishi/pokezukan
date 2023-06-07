<?php

function get_contents($url) {
    $cache_path = __DIR__ . "/cache_contents/";
    $cache_limit = 864000;

    $file_name = md5($url) . ".json";
    $cache_file_path = $cache_path . $file_name;
    if ( file_exists($cache_file_path) && time() < filemtime($cache_file_path) + $cache_limit ) {
        $file_handler = fopen($cache_file_path, "r");
        $data = fread($file_handler, filesize($cache_file_path));
        fclose($file_handler);
        return json_decode($data, true);
    }
    $response = file_get_contents($url);
    $file_handler = fopen($cache_file_path, "w");
    fputs($file_handler, $response);
    fclose($file_handler);
    return json_decode($response, true);
}