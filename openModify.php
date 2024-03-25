<?php
require_once 'DBStorageOne.php';
require_once 'DBStorageTwo.php';
if(isset($_POST['selectedId'])) {
    $selectedId = $_POST['selectedId'];
    
    $dbstorageOne = new DBStorageOne();
    $dbstorageTwo = new DBStorageTwo();

    $selected = $dbstorageOne->getById($selectedId);
    $storage = 1;
    if(!isset($selected)) {
        $selected = $dbstorageTwo->getById($selectedId);
        $storage = 2;
    }
    
    echo"<div class='modify'>
        <h2>Kiválasztott elem adatai:</h2>
        <form method='post'>
            <input type='hidden' id='modifyId' name='modifyId' value='{$selectedId}'></input>
            <p>Megnevezés:
                <input id='newName' name='newName' type='text' value='{$selected['name']}'></input></p>
            <p>Raktár: 
                <select onchange='changeStorage(\"{$storage}\")' id='newStorage' name='newStorage'>";
                    if($storage == 1) {
                        echo"<option value='one' selected='true'>1-es raktár</option>
                             <option value='two'>2-es raktár</option>";
                    }
                    else {
                        echo"<option value='one'>1-es raktár</option>
                             <option value='two' selected='true'>2-es raktár</option>";
                    }
                    
                echo"</select></p>
            <p><input id='isClear' name='isClear' type='checkbox'>Polc kiürítése</input></p>
            <p>Sor:
                <select onchange='changeColumn(this,\"{$storage}\")' id='newColumn' name='newColumn'>";
                if($storage == 1) {
                    $numOfColumns = $dbstorageOne->getColumnNum();
                    for($i = 0; $i < $numOfColumns['countOfColumn']; $i++) {
                        $value = $i + 1;
                        if($selected['shelfColumn']-1 == $i) {
                            echo"<option value='{$value}' selected='true'>{$value}</option>";
                        }
                        else {
                            echo"<option value='{$value}'>{$value}</option>";
                        }
                  } 
                }
                else {
                    $numOfColumns = $dbstorageTwo->getColumnNum();
                    for($i = 0; $i < $numOfColumns['countOfColumn']; $i++) {
                        $value = $i + 1;
                        if($selected['shelfColumn']-1 == $i) {
                            echo"<option value='{$value}' selected='true'>{$value}</option>";
                        }
                        else {
                            echo"<option value='{$value}'>{$value}</option>";
                        }
                  } 
                } 
                echo"</select></p>
            </p>
            <p><input id='isNewShelf' name='isNewShelf' type='checkbox'>Új polcsor hozzáadása</input></p>
            <p>Polc:
                <select id='newRow' name='newRow'>";   
                    if($storage == 1) {
                        $numOfShelfs = $dbstorageOne->getRowNum();
                        for($i = 0; $i < $numOfShelfs['countOfRow']; $i++) {
                            $value = $i + 1;
                            $selectable = $dbstorageOne->getByColumnAndRow($selected['shelfColumn'], $value);
                            if($selected['shelfRow']-1 == $i) {
                                echo"<option value='{$value}' selected='true'>{$value}</option>";
                            }
                            else {
                                if($selectable['name'] == 'üres'){
                                    echo"<option value='{$value}'>{$value}</option>";
                                }                        
                            }                       
                        }  
                    }
                    else if ($storage == 2) {
                        $numOfShelfs = $dbstorageTwo->getRowNum();
                        for($i = 0; $i < $numOfShelfs['countOfRow']; $i++) {
                            $value = $i + 1;
                            $selectable = $dbstorageTwo->getByColumnAndRow($selected['shelfColumn'], $value);
                            if($selected['shelfRow']-1 == $i) {
                                echo"<option value='{$value}' selected='true'>{$value}</option>";
                            }
                            else {
                                if($selectable['name'] == 'üres'){
                                    echo"<option value='{$value}'>{$value}</option>";
                                }                        
                            }                       
                        }  
                    }
                    
                echo"</select></p>
            </p>
            <p>Darabszám:";
                if($selected['name'] == 'üres'){
                    echo"<input id='newQuantity' name='newQuantity' type='number' value='{$selected['quantity']}'></input>/<input id='newMax' name='newMax' type='number' value='{$selected['max']}'></input>";
                }
                else {
                    echo"<input id='newQuantity' name='newQuantity' type='number' value='{$selected['quantity']}'></input><input id='max' name='max' type='hidden' value='{$selected['max']}'></input>/{$selected['max']}";
                }
            echo"</p>
                <input type='submit' id='btn-modify' name='btn-modify' value='Módosítás'></input><input";
        echo"</form>";
}