<?php
require_once 'DB.php';
require_once 'CsvTools.php';

class DBStorageOne extends DB {
    function createTable() {
        $query = 'CREATE TABLE IF NOT EXISTS storageone(id int, name varchar(35), quantity int, max int, shelfColumn int, shelfRow int)';
        return $this->mysqli->query($query);
    }

    function fillTable($fileName) {
        $this->createTable();
        $csvtools = new CsvTools();
        $data = $csvtools->getCsvData($fileName);
        
        $result = $this->mysqli->query("SELECT * FROM storageone");
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
                if ($row[6] == 1) {
                    $insert = $this->mysqli->query("INSERT INTO storageone (id, name, quantity, max, shelfColumn, shelfRow) VALUES ('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]')");
                    if (!$insert) {
                        $errors[] = $row[0];
                    }
                    echo $row[1];
                }
            }
        }
    }

    function getAll() {
        $resoult = $this->mysqli->query("SELECT * FROM storageone");

        return $resoult->fetch_all(MYSQLI_ASSOC);
    }

    function getColumnNum() {
        $resoult = $this->mysqli->query("SELECT COUNT(DISTINCT shelfColumn) AS countOfColumn FROM storageone");

        return $resoult->fetch_assoc();
    }

    function getRowNum() {
        $resoult = $this->mysqli->query("SELECT COUNT(DISTINCT shelfRow) AS countOfRow FROM storageone");

        return $resoult->fetch_assoc();
    }

    function getByColumnAndRow($column, $row) {
        $resoult = $this->mysqli->query("SELECT * FROM storageone WHERE shelfColumn = '$column' AND shelfRow = '$row'");

        return $resoult->fetch_assoc();
    }

    function getById($id) {
        $resoult = $this->mysqli->query("SELECT * FROM storageone WHERE id = '$id'");

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
            $this->mysqli->query("UPDATE storageone SET name = 'üres', quantity = '0', max = '0' WHERE id = '$id'");
            echo '<script>displayTable("One")</script>;';
            return null;
        }
        if(isset($_POST['newMax'])) {
            $newMax = $_POST['newMax'];
            $this->mysqli->query("UPDATE storageone SET name = '$newName', quantity = '$newQuantity', max = '$newMax' WHERE id = '$id'");
            echo '<script>displayTable("One")</script>;';                       
        }
        else {
            $this->mysqli->query("UPDATE storageone SET name = '$newName', quantity = '$newQuantity' WHERE id = '$id'");
            echo '<script>displayTable("One")</script>;';           
        }

        $oldColumn = $this->mysqli->query("SELECT shelfColumn FROM storageone WHERE id = '$id'")->fetch_assoc();
        $oldRow = $this->mysqli->query("SELECT shelfRow FROM storageone WHERE id = '$id'")->fetch_assoc();
        if($oldColumn['shelfColumn'] != $newColumn || $oldRow['shelfRow'] != $newRow) {
            $newColumnId = $this->mysqli->query("SELECT id FROM storageone WHERE shelfColumn = '$newColumn' AND shelfRow = '$newRow'")->fetch_assoc();
            $this->mysqli->query("UPDATE storageone SET name = '$newName', quantity = '$newQuantity', max = '$max' WHERE id = '" . $newColumnId['id'] ."'");
            $this->mysqli->query("UPDATE storageone SET name = 'üres', quantity = '0', max = '0' WHERE id = '$id'");
        }

        unset($_POST);
    }

    function addColumn() {
        $resoultOfGetIdMax = $this->mysqli->query("SELECT MAX(id) AS maxId FROM ( SELECT id FROM storageone UNION All SELECT id FROM storagetwo) AS combinated_id");
        $maxId = $resoultOfGetIdMax->fetch_assoc();
        $numOfRow = $this->getRowNum();
        $numOfColumn = $this->getColumnNum();
        for($i = 0; $i < $numOfRow['countOfRow']; $i++) {
            $id = $maxId['maxId']+$i+1;
            $newColumn = $numOfColumn['countOfColumn']+1;
            $newRow = $i+1;
            $this->mysqli->query("INSERT INTO storageone (id, name, quantity, max, shelfColumn, shelfRow) VALUES ('$id', 'üres', '0', '0', '$newColumn', '$newRow')");
        }
        echo '<script>displayTable("One")</script>;';
    }

    function deleteColumn($columnNum) {
        $this->mysqli->query("DELETE FROM storageone WHERE shelfColumn = '$columnNum'");
        echo '<script>displayTable("One")</script>;';
    }
}