<?php

require_once __DIR__ . "/get_pokemon_details.php";

function get_pokemons($limit, $offset) {
    $start = $limit * $offset + 1;
    $end = $start + $limit - 1;
    $pokemons = [];
    for ( $i = $start; $i < $end; $i++ ) {
        $pokemon = get_pokemon_details($i);
        array_push($pokemons, $pokemon);
    }
    foreach ( $pokemons as $pokemon ) {
        var_dump($pokemon);
        echo "<br>";
    }
}

