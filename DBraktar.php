<?php
require_once 'DB.php';
require_once 'CsvTools.php';

class DBRaktar extends DB {
    function createTables() {
        $query = 'CREATE TABLE IF NOT EXISTS inStorage(id int, name varchar(35), quantity int, max int, shelfColumn int, shelfRow int, storageNum int)';
        return $this->mysqli->query($query);
    }

    function fillTable($fileName) {
        $this->createTables();
        $csvtools = new CsvTools();
        $data = $csvtools->getCsvData($fileName);
        
        $result = $this->mysqli->query("SELECT * FROM inStorage");
        $inIt = $result->fetch_array(MYSQLI_NUM);
        $errors = [];
        $isFirst = true;
        $id = 0;
        if (empty($inIt)) {
            foreach ($data as $row) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }
                $insert = $this->mysqli->query("INSERT INTO inStorage (id, name, quantity, max, shelfColumn, shelfRow, storageNum) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]', '$row[6]')");
                if (!$insert) {
                    $errors[] = $row[0];
                }
                echo $row[1];
            }
        }
    }
}