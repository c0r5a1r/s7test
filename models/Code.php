<?php


class Code {
    public static function setCodes(){


        $db = Db::getConnection();
        $size = 10;
        $codes = array();

        do {
            $codes = array_merge($codes, self::_generateRandom($size));
            $codesString = implode(',', $codes);

            $sql1 = "SELECT f_code FROM codes_testexercise WHERE f_code IN (?)";
            $result = $db->prepare($sql1);

            $result = $result->fetchAll();;
            $codes = array_diff($codes, $result);
            $size = $size - count($codes);
        } while($size === 0);

//        $values = array();
//        foreach ($codes as $code){
//            $values[] = '(' . $code . ',' . date('H:i:s', time()) . ')';
//
//        }
//        $valuesString = implode(',', $values);
        $sql = "INSERT INTO codes_testexercise (f_code, h_datetime) VALUES (?, ?)";
        $xor = $db->prepare($sql);
        foreach ($codes as $code) {
            $xor->execute(array($code, date('Y-m-d H:i:s', time())));
        }

        $dor = $xor->fetch();
        return $dor;
    }

    public static function getCodes(){
        $db = Db::getConnection();
        $result = $db->query("SELECT h_id AS 'id', f_code AS 'code', h_datetime AS 'date' FROM codes_testexercise");

        return $result->fetch();
    }

    public static function removeCodes(){

    }
    private static function _checkIfExist($codes){

    }
    private static function _generateRandom($size){
        for ($i = 0; $i <= $size; $i++) {
            $codes[$i] = rand(999,10000);
        }
        return $codes;
    }
}