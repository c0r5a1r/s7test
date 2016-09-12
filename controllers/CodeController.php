<?php

include_once (ROOT.'/models/Code.php');
include_once (ROOT.'/views/View.php');
class CodeController {

    function actionOpcja1() {
        $codes = array();
        $codes = Code::setCodes();
//        echo 'hi from controller action1';
//        print_r($codes);
    }

    function actionOpcja2() {
        $data = Code::getCodes();
        View::showPage('add', $data);
//        echo 'hi from controller action2';
    }

    function actionOpcja3() {
        if(empty($_POST)){
            View::show('remove');
        } else {
            $data = $_POST['message'];
            $data = Code::removeCodes($data);
            View::showPage('removenotise', $data);
        }


    }


}
