<?php

function get_img($url) {
    $cache_limit = 86400;
    $cache_path = __DIR__ . "/cache_img/";

    $file_name = md5($url) . ".png";
    $cache_file_path = $cache_path . $file_name;
    if ( file_exists($cache_file_path) && time() < filemtime($cache_file_path) + $cache_limit ) {
        return $file_name;
    }
    $response = file_get_contents($url);
    file_put_contents($cache_file_path, $response);
    return $file_name;
}
