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
    $pokemon["flavor_text"] = get_jp_flavor($data_sp["flavor_text_entries"]);
    $pokemon["img_name"] = get_img($data["sprites"]["front_default"]);
    $pokemon["pokemon_color"] = $data_sp["color"]["name"];
    $pokemon["height"] = $data["height"];
    $pokemon["weight"] = $data["weight"];
    $pokemon["types"] = get_types($data["types"]);

    return $pokemon;
}


function get_jp_flavor($flavor_array) {
    foreach ( $flavor_array as $flavor_object ) {
        if ( $flavor_object["language"]["name"] == "ja" ) {
            return $flavor_object["flavor_text"];
        }
    }
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

