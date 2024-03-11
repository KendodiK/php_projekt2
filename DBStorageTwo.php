<?php
require_once 'DB.php';
require_once 'CsvTools.php';

class DBStorageTwo extends DB {
    function createTable() {
        $query = 'CREATE TABLE IF NOT EXISTS storagetwo(id int, name varchar(35), quantity int, max int, shelfColumn int, shelfRow int)';
        return $this->mysqli->query($query);
    }

    function fillTable($fileName) {
        $this->createTable();
        $csvtools = new CsvTools();
        $data = $csvtools->getCsvData($fileName);
        
        $result = $this->mysqli->query("SELECT * FROM storagetwo");
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
                if ($row[6] == 2) {
                    $insert = $this->mysqli->query("INSERT INTO storagetwo (id, name, quantity, max, shelfColumn, shelfRow) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]')");
                    if (!$insert) {
                        $errors[] = $row[0];
                    }
                    echo $row[1];
                }
            }
        }
    }

    function getAll() {
        $resoult = $this->mysqli->query("SELECT * FROM storagetwo");

        return $resoult->fetch_all(MYSQLI_ASSOC);
    }
}