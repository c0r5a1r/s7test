<?php


class Code {
    public static function putCodesIntoDB(){
        $codes = array();
        for ($i = 0; $i <= 10; $i++) {
            $codes[$i] = rand(999,10000);
        }
        $db = Db::getConnection();

//        $result = $db->query('INSERT INTO codes_testexercise (f_code, h_datetime) VALUES');

        $sql = 'INSERT INTO codes_testexercise (f_code, h_datetime) VALUES ';
        $insertQuery = array();
        $insertData = array();
        foreach ($codes as $row) {
            $insertQuery[] = '(?, ?)';

            $insertData[] = $row;
            $insertData[] = date('H:i:s', time());
        }

        if (!empty($insertQuery)) {
            $sql .= implode(', ', $insertQuery);
            $stmt = $db->prepare($sql);
            $stmt->execute($insertData);
        }

        return $insertQuery;

    }

    public static function getCodesfromDB(){
        $db = Db::getConnection();
        $codesList = array();

        $result = $db->query('SELECT h_id, f_code, h_datetime  FROM codes_testexercise');

        $i = 0;
        while($row = $result->fetch()) {
            $codesList[$i]['id'] = $row['h_id'];
            $codesList[$i]['code'] = $row['f_code'];
            $codesList[$i]['date'] = $row['h_datetime'];
            $i++;
        }

        return $codesList;
    }

    public static function removeCodesfromDB(){

    }
}