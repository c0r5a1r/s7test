<?php

include_once (ROOT.'/models/Code.php');

class CodeController {

    function actionOpcja1() {
        $codes = array();
        $codes = Code::putCodesIntoDB();
//        echo 'hi from controller action1';
        print_r($codes);
    }

    function actionOpcja2() {
        echo 'hi from controller action2';
    }

    function actionOpcja3() {
        echo 'hi from controller action3';
    }


}
