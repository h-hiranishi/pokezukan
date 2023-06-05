<?php

require_once __DIR__ . "/get_pokemon_details.php";

function get_pokemon_list($limit, $offset) {
    $start = $limit * $offset + 1;
    $end = $start + $limit;
    $pokemons = [];
    for ( $i = $start; $i < $end; $i++ ) {
        $pokemon = get_pokemon_details($i);
        array_push($pokemons, $pokemon);
    }

    return $pokemons;
}

