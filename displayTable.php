<?php
require_once 'CreateTables.php';

if(isset($_POST['tableNumber'])){

    $createTables = new CreateTables();
    $tableNumber = $_POST['tableNumber'];

    if($tableNumber == 'One') {
        $result = "<label for='dispTableOne'>
        <div id='dispTableOne' class='storage1table'>
        <p>1-es raktár</p>
        <table>";
        $result .= $createTables->createTable('1');
        $result .= "</table>
        </div>
        </label>";
    }
    else if ($tableNumber == 'Two') {
        $result = "<label for='dispTable'>
        <div id='dispTableTwo' class='storage2table'>
        <p>2-es raktár</p>
        <table>";
        $result .= $createTables->createTable('2');
        $result .= "</table>
        </div>
        </label>";
    }

    echo $result;
}