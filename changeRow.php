<?php
require_once 'DBStorageOne.php';
require_once 'DBStorageTwo.php';

if(isset($_POST['changed']) && isset($_POST['storage'])) {
    $dbstorageOne = new DBStorageOne();
    $dbstorageTwo = new DBStorageTwo();
    $changedRow = $_POST['changed'];
    $storage = $_POST['storage'];

    $result = "";
    if($storage == 1) {
        $numOfShelfs = $dbstorageOne->getRowNum();
        $selectable;
        if ($numOfShelfs['countOfRow'] < $changedRow) {
            $numOfShelfs = $dbstorageTwo->getRowNum();
        }
        for($i = 0; $i < $numOfShelfs['countOfRow']; $i++) {
            if ($numOfShelfs['countOfRow'] < $changedRow) {
                $selectable = $dbstorageTwo->getByColumnAndRow($changedRow, $value);
            }
            else {
                $selectable = $dbstorageOne->getByColumnAndRow($changedRow, $value);
            }
            $value = $i + 1;
            if($selectable['name'] == 'üres'){
                $result .= "<option value='{$value}'>{$value}</option>";
            }  
        }  
    }
    else if ($storage == 2) {
        $numOfShelfs = $dbstorageTwo->getRowNum();
        for($i = 0; $i < $numOfShelfs['countOfRow']; $i++) {
            $value = $i + 1;
            $selectable = $dbstorageTwo->getByColumnAndRow($changedRow, $value);
            if($selected['shelfRow']-1 == $i) {
                $result .= "<option value='{$value}' selected='true'>{$value}</option>";
            }
            else {
                if($selectable['name'] == 'üres'){
                    $result .= "<option value='{$value}'>{$value}</option>";
                }                        
            }                       
        }  
    } 

    echo $result;
}