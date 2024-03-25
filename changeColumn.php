<?php
require_once 'DBStorageOne.php';
require_once 'DBStorageTwo.php';

if(isset($_POST['currentStorage'])) {
    $dbstorageOne = new DBStorageOne();
    $dbstorageTwo = new DBStorageTwo();
    $currentStorage = $_POST['currentStorage'];

    $storage = $currentStorage;
    

    $result = "";
    if($storage == 1) {
        $numOfColumns = $dbstorageOne->getColumnNum();
        for($i = 0; $i < $numOfColumns['countOfColumn']; $i++) {
            $value = $i + 1;
            $result .= "<option value='{$value}'>{$value}</option>";

      } 
    }
    else {
        $numOfColumns = $dbstorageTwo->getColumnNum();
        for($i = 0; $i < $numOfColumns['countOfColumn']; $i++) {
            $value = $i + 1;
            $result .= "<option value='{$value}'>{$value}</option>";
      } 
    }
    
    echo $result;
}