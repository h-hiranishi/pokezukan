<?php

    $file_path = __DIR__ . "../tmpl/";

    // プログラムの開始位置
    view_main();

    function view_main(){
        global $file_path;
        $file_name = "{$file_path}template.html";
        $file_handler = fopen($file_name, "r");
        $tmpl = fread($file_handler, filesize($file_name));
        fclose($file_handler);
        return $tmpl;
    }
