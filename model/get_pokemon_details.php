<?php

require_once __DIR__ . "/get_contents.php";

function get_pokemon_details($id) {
    $url = "https://pokeapi.co/api/v2/pokemon/{$id}/";
    $data = get_contents($url);

    $pokemon = [];
    $pokemon["name"] = $data["name"];
    $pokemon["img_url"] = $data["sprites"]["front_default"];
    $pokemon["height"] = $data["height"];
    $pokemon["weight"] = $data["weight"];
    $types = [];
    foreach ( $data["types"] as $type ) {
        array_push($types, $type["type"]["name"]);
    }
    $pokemon["types"] = $types;

    return $pokemon;
}

