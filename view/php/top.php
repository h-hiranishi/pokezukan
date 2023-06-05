<?php

$file_path = __DIR__ . "/../tmpl/";
$api_path = __DIR__ . "/../../model/";
require_once "{$api_path}get_pokemon_lists.php";

$delimiter = 4;
$max = 1000;

view_main();

function view_main(){
    global $delimiter;
    global $max;
    $param = get_limit_and_offset();
    $tmpl = read_template_file("template.html");
    $cards = view_cards($param["limit"], $param["offset"], $delimiter);
    $tmpl = str_replace("!cards!", $cards, $tmpl);
    $pages = paging($param["limit"], $param["offset"], $max);
    $tmpl = str_replace("!paging!", $pages, $tmpl);
    echo $tmpl;
}

function view_cards($limit, $offset, $delimiter) {
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
        if ( ($i+1) % $delimiter === 0 || $i + 1 == $len ) {
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

function get_limit_and_offset() {
    $param = [];
    if ( isset($_GET["limit"]) ) {
        $param["limit"] = htmlentities($_GET["limit"], ENT_QUOTES, "utf-8");
    } else {
        $param["limit"] = 10;
    }
    if ( isset($_GET["offset"]) ) {
        $param["offset"] = htmlentities($_GET["offset"], ENT_QUOTES, "utf-8");
    } else {
        $param["offset"] = 0;
    }
    return $param;
}

function paging($limit, $offset, $max) {
    $view_range = define_range($limit, $offset, $max);
    $paging = "";
    for ( $i = $view_range["start"]; $i < $view_range["end"]; $i++ ) {
        if ( $i == $offset ) {
            $paging .= "<span>{$i}</span>";
        } else {
            $paging .= "<a href='top.php?offset={$i}'>{$i}</a>";
        }
    }
    return $paging;
}

function define_range($limit, $offset, $max) {
    $max_page = ceil($max / $limit);
    $data = [];
    $data["start"] = 0;
    $data["end"] = $max_page;

    if ( $max_page < 11 ) {
        return $data;
    }

    if ( $offset < 5 ) {
        $data["end"] = 11;
        return $data;
    }

    if ( $offset + 5 < $max_page ) {
        $data["start"] = $offset - 5;
        $data["end"] = $data["start"] + 11;
        return $data;
    }

    $data["end"] = $max_page;
    $data["start"] = $data["end"] - 11;
    return $data;
}