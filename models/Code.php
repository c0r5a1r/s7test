<?php


class Code {
    public static function setCodes(){


        $db = Db::getConnection();
        $size = 9;
        $codes = array();

        do {
            $codes = array_merge($codes, self::uniqueRand(10,50,10));
            $result = array();
            $sql1 = "SELECT * FROM codes_testexercise WHERE f_code IN (?)";
            $sth = $db->prepare($sql1);
            foreach ($codes as $code){
                $sth->execute(array($code));

                if (!empty($sth->fetch())) {
                    echo 'code '.$code.' does exist<br>';
                    $result[] = $code;
                } else {
                    echo 'code does not exist<br>';
                };
            }

            $codes = array_diff($codes, $result);
            $size = $size - count($codes);
        } while($size === 0);

        $sql = "INSERT INTO codes_testexercise (f_code, h_datetime) VALUES (?, ?)";
        $xor = $db->prepare($sql);
        foreach ($codes as $code) {
            $xor->execute(array($code, date('Y-m-d H:i:s', time())));
        }

        return $result;
    }

    public static function getCodes(){
        $db = Db::getConnection();
        $result = $db->query("SELECT h_id AS 'id', f_code AS 'code', h_datetime AS 'date' FROM codes_testexercise");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $newresult = $result->fetchAll();
        $codes = array();
        foreach ($newresult as $value) {
            $codes[] = $value['code'];
        }
        return $newresult;
    }

    public static function removeCodes($data){
        $data = explode(' ', $data);
        $codesInBase = self::_checkIfExist($data);
//        $codesOutBase =array_diff($data, $codesInBase);

        if(isset($codesInBase)){


//            $codesInBase = implode("','", $data);
            $sql = "DELETE FROM codes_testexercise WHERE f_code IN (?)";
            $db = Db::getConnection();

            $result = $db->prepare($sql);
            foreach ($codesInBase as $value){
                $result->execute(array($value));
            }
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
            return $codesInBase;
        } else {

        }

    }
    private static function _checkIfExist($codes){
        $codesString = implode("','", $codes);
        $sql = "SELECT f_code FROM codes_testexercise WHERE f_code IN ('$codesString')";
        $db = Db::getConnection();
        $result = $db->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $value){
            $onlyCodes[] = $value['f_code'];
        }
        $repeatedCods = array_intersect($codes,$onlyCodes);
        return $repeatedCods;

    }
    private static function _generateRandom($size){
        for ($i = 0; $i <= $size; $i++) {
            $codes[$i] = rand(10,50);
        }
        $unCodes = array_unique($codes);

        return $unCodes;
    }
    static function uniqueRand($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}