<?php

function get_pokemon_details($id) {
    $url = "https://pokeapi.co/api/v2/pokemon/{$id}/";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $pokemon = [];
    $pokemon["name"] = $data["name"];
    $pokemon["img_url"] = $data["sprites"]["front_default"];
    $pokemon["height"] = $data["height"];
    $pokemon["weight"] = $data["weight"];
    $types = [];
    foreach ( $data["types"] as $types ) {
        array_push($types, $types["type"]["name"]);
    }
    $pokemon["types"] = $types;

    return $pokemon;
}

