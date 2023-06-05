<?php

$file_path = __DIR__ . "/../tmpl/";
$api_path = __DIR__ . "/../../model/";
require_once "{$api_path}get_pokemon_lists.php";

$limit = 20;
$offset = 0;
$delimiter = 4;

view_main();

function view_main(){
    $tmpl = read_template_file("template.html");
    $cards = view_cards();
    $tmpl = str_replace("!cards!", $cards, $tmpl);
    echo $tmpl;
}
function view_cards() {
    global $limit;
    global $offset;
    global $delimiter;

    $card_tmpl = read_template_file("card.html");
    $row_tmpl = read_template_file("row_cards.html");

    $pokemon_lists = get_pokemon_list($limit, $offset);
    $len = count($pokemon_lists);
    if ( $len <= 0 ) {
        return "";
    }

    $cards = "";
    $row_cards = "";
    for ( $i = 0; $i < $len; $i++ ) {
        $row_cards .= make_card($pokemon_lists[$i], $card_tmpl);
        if ( ( $i != 0 && $i % $delimiter === 0 ) || $i + 1 == $len ) {
            $cards .= str_replace("!row_cards!", $row_cards, $row_tmpl);
            $row_cards = "";
        }
    }

    return $cards;
}

function make_card($pokemon, $card_tmpl) {
    foreach ( $pokemon as $key => $val ) {
        if ( $key != "types" ) {
            $card_tmpl = str_replace("!{$key}!", $val, $card_tmpl);
            continue;
        }
        $types = "";
        foreach ( $val as $type ) {
            $types .= "<div>$type</div>";
        }
        $card_tmpl = str_replace("!types!", $types, $card_tmpl);
    }
    return $card_tmpl;
}

function read_template_file($file_name) {
    global $file_path;
    $absolute_file_name = $file_path . $file_name;
    $file_handler = fopen($absolute_file_name, "r");
    $tmpl = fread($file_handler, filesize($absolute_file_name));
    fclose($file_handler);
    return $tmpl;
}

