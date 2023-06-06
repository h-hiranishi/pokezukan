<?php

require_once __DIR__ . "/get_pokemon_details.php";

function get_pokemon_list($limit, $offset) {
    $start = $limit * $offset + 1;
    $end = $start + $limit;
    $pokemons = [];
    $max = 1010;
    for ( $i = $start; $i < $end; $i++ ) {
        if ( $max < $i ) {
            break;
        }
        $pokemon = get_pokemon_details($i);
        array_push($pokemons, $pokemon);
    }

    return $pokemons;
}

