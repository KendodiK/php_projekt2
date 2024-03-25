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

    function getColumnNum() {
        $resoult = $this->mysqli->query("SELECT COUNT(DISTINCT shelfColumn) AS countOfColumn FROM storagetwo");

        return $resoult->fetch_assoc();
    }

    function getRowNum() {
        $resoult = $this->mysqli->query("SELECT COUNT(DISTINCT shelfRow) AS countOfRow FROM storagetwo");

        return $resoult->fetch_assoc();
    }

    function getByColumnAndRow($column, $row) {
        $resoult = $this->mysqli->query("SELECT * FROM storagetwo WHERE shelfColumn = '$column' AND shelfRow = '$row'");

        return $resoult->fetch_assoc();
    }

    function getById($id) {
        $resoult = $this->mysqli->query("SELECT * FROM storagetwo WHERE id = '$id'");

        return $resoult->fetch_assoc();
    }

    function modify() {
        $id = $_POST['modifyId'];
        $newName = $_POST['newName'];
        $newColumn = $_POST['newColumn'];
        $newRow = $_POST['newRow'];
        $newQuantity = $_POST['newQuantity'];
        $max = $_POST['max'];
        if(isset($_POST['isClear'])) {
            $this->mysqli->query("UPDATE storagetwo SET name = 'üres', quantity = '0', max = '0' WHERE id = '$id'");
            echo '<script>displayTable("Two")</script>;';
            return null;
        }
        if(isset($_POST['newMax'])) {
            $newMax = $_POST['newMax'];
            $this->mysqli->query("UPDATE storagetwo SET name = '$newName', shelfColumn = '$newColumn', shelfRow = '$newRow', quantity = '$newQuantity', max = '$newMax' WHERE id = '$id'");
            echo '<script>displayTable("Two")</script>;'; 
        }
        else {
            $this->mysqli->query("UPDATE storagetwo SET name = '$newName', shelfColumn = '$newColumn', shelfRow = '$newRow', quantity = '$newQuantity' WHERE id = '$id'");
            echo '<script>displayTable("Two")</script>;';
        }

        $oldColumn = $this->mysqli->query("SELECT shelfColumn FROM storagetwo WHERE id = '$id'")->fetch_assoc();
        $oldRow = $this->mysqli->query("SELECT shelfRow FROM storagetwo WHERE id = '$id'")->fetch_assoc();
        if($oldColumn['shelfColumn'] != $newColumn || $oldRow['shelfRow'] != $newRow) {
            $newColumnId = $this->mysqli->query("SELECT id FROM storagetwo WHERE shelfColumn = '$newColumn' AND shelfRow = '$newRow'")->fetch_assoc();
            $this->mysqli->query("UPDATE storagetwo SET name = '$newName', quantity = '$newQuantity', max = '$max' WHERE id = '" . $newColumnId['id'] ."'");
            $this->mysqli->query("UPDATE storagetwo SET name = 'üres', quantity = '0', max = '0' WHERE id = '$id'");
        }

        unset($_POST);
    }
}