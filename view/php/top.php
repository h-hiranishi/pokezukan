<?php

$file_path = __DIR__ . "/../tmpl/";
$api_path = __DIR__ . "/../../model/";
require_once "{$api_path}get_pokemon_lists.php";

$limit = 4;
$offset = 0;

view_main();

function view_main(){
    global $file_path;
    $file_name = "{$file_path}template.html";
    $file_handler = fopen($file_name, "r");
    $tmpl = fread($file_handler, filesize($file_name));
    fclose($file_handler);

    $cards = view_cards();
    $tmpl = str_replace("!cards!", $cards, $tmpl);
    echo $tmpl;
}

function view_cards() {
    global $limit;
    global $offset;

    global $file_path;

    $file_name = "{$file_path}card.html";
    $file_handler = fopen($file_name, "r");
    $tmpl = fread($file_handler, filesize($file_name));
    fclose($file_handler);

    $cards = "";
    $pokemon_lists = get_pokemon_list($limit, $offset);
    foreach ( $pokemon_lists as $pokemon ) {
        $card = $tmpl;
        foreach ( $pokemon as $key => $val ) {
            if ( $key != "types" ) {
                $card = str_replace("!{$key}!", $val, $card);
                continue;
            }
            $types = "";
            foreach ( $val as $type ) {
                $types .= "<div>$type</div>";
            }
            $card = str_replace("!types!", $types, $card);
        }
        $cards .= $card;
    }

    return $cards;
}

