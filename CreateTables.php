<?php
    require_once 'DBStorageOne.php';
    require_once 'DBStorageTwo.php';

    class CreateTables {

        private $dbstorageOne;
        private $dbstorageTwo;
        private $storageOne;
        private $storageTwo;

        function __construct(){
            $this->dbstorageOne = new DBStorageOne();
            $this->dbstorageTwo = new DBStorageTwo();

            $this->storageOne = $this->dbstorageOne->getAll();
            $this->storageTwo = $this->dbstorageTwo->getAll();
        }

        function whichClass($quality, $max) {
            if ($max == 0) {
                return "empty";
            }
            $result = $quality / $max * 100;
                    switch($result){
                        case ($result < 30):
                            return "almostEmpty";
                        case ($result < 80):
                            return "enough";
                        case ($result >= 100):
                            return "full";
                        default:
                            return "almostFull";
                    }
        }

        function createTable($tableNum) {
            if($tableNum == 1) {
                $table = $this->storageOne;
                $numberOfShelfs = $this->dbstorageOne->getColumnNum();
            } 
            elseif ($tableNum == 2) {
                $table = $this->storageTwo;
                $numberOfShelfs = $this->dbstorageTwo->getColumnNum();
            }
            
            $result = "";
            for($i = 0; $i < count($table)/$numberOfShelfs['countOfColumn']; $i++){
                $result .= "<tr>";
                    for($j = 0; $j < $numberOfShelfs['countOfColumn']; $j++) {
                        $shelfStepper = count($table)/$numberOfShelfs['countOfColumn']*$j;
                        $classForCss = $this->whichClass($table[$i+$shelfStepper]['quantity'], $table[$i+$shelfStepper]['max']);
                        $id = $table[$i+$shelfStepper]['id'];
                        $value = $table[$i+$shelfStepper]['name'];
                        $result .= "<td><button onclick='openOpcions(\"{$id}\")' class='{$classForCss}' id='btn-open-{$id}'>{$value}</button></td>";
                    }
                $result .= "</tr>";
                if ($i == count($table)/$numberOfShelfs['countOfColumn']-1) {
                    $result .= "<tr>";
                        for($j = 0; $j < $numberOfShelfs['countOfColumn']; $j++) {
                            $columnNum = $j+1;
                            $result .= "<td><form method='POST'>
                                <input type='hidden' id='deletableColumnStorage' name='deletableColumnStorage' value='{$tableNum}'></input>
                                <input type='hidden' id='deletableColumnNum' name='deletableColumnNum' value='{$columnNum}'></input>
                                <input type='submit' id='btn-deleteColumn' name='btn-deleteColumn' value='polcsor törése'></input>
                                </from></td>";
                        }
                    $result .= "</tr>";
                }
            }

            return $result;
        }
    }