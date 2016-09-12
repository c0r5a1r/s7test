<?php

class View {
    public static function show($page){
        include($page.'.php');
    }

    public static function showPage($page, $data){
        include($page . '.php');
    }
    public static function renderJson($data){
        echo json_encode($data);
    }

}