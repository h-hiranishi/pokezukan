<?php

require_once __DIR__ . "/get_contents.php";
require_once __DIR__ . "/get_img.php";

function get_pokemon_details($id) {
    $url = "https://pokeapi.co/api/v2/pokemon/{$id}/";
    $url_sp = "https://pokeapi.co/api/v2/pokemon-species/{$id}";
    $data = get_contents($url);
    $data_sp = get_contents($url_sp);

    $pokemon = [];
    $pokemon["id"] = $data["id"];
    $pokemon["name"] = $data_sp["names"][0]["name"];
    $pokemon["flavor_text"] = get_flavor($data_sp["flavor_text_entries"]);
    // $pokemon["img_name"] = get_img($data["sprites"]["front_default"]);
    $pokemon["img_name"] = get_img($data["sprites"]["other"]["official-artwork"]["front_default"]);
    $pokemon["pokemon_color"] = $data_sp["color"]["name"];
    $pokemon["height"] = $data["height"] * 0.1;
    $pokemon["weight"] = $data["weight"] * 0.1;
    $pokemon["types"] = get_types($data["types"]);
    $move_info = get_move($data["moves"]);
    $pokemon["move"] = $move_info["name"];
    $pokemon["move_type"] = $move_info["type"];
    $pokemon["move_power"] = $move_info["power"];

    return $pokemon;
}

function get_move($moves) {
    $index = rand(1, count($moves)-1);
    $url = $moves[$index]["move"]["url"];
    $json = get_contents($url);
    $move = [];
    $file_name = __DIR__ . "/local_data/type_color.json";
    $file_handler = fopen($file_name, "r");
    $json_data = fread($file_handler, filesize($file_name));
    $type_colors = json_decode($json_data, true);
    $type = $json["type"]["name"];
    $move["type"] = $type_colors[$type];
    // $move["type"] = $json["type"]["name"];
    
    $move["power"] = $json["power"];
    foreach ( $json["names"] as $move_info ) {
        if ( $move_info["language"]["name"] == "ja" ) {
            $move["name"] = $move_info["name"];
            return $move;
        }
    }
}


function get_flavor($flavor_array) {
    foreach ( $flavor_array as $flavor_object ) {
        if ( $flavor_object["language"]["name"] == "ja" ) {
            return $flavor_object["flavor_text"];
        }
    }
    return "データがありません.....🙇🙇‍♂️🙇‍♀️";
}


function get_types($type_array) {
    $types = [];
    foreach ( $type_array as $type_object ) {
        $url = $type_object["type"]["url"];
        $type_json = get_contents($url);
        foreach ( $type_json["names"] as $type ) {
            if ( $type["language"]["name"] == "ja" ) {
                array_push($types, $type["name"]);
            }
        }
    }
    return $types;
}

