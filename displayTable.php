<?php
require_once 'CreateTables.php';

if(isset($_POST['tableNumber'])){

    $createTables = new CreateTables();
    $tableNumber = $_POST['tableNumber'];

    if($tableNumber == 'One') {
        $result = "
        <div id='dispTableOne' class='storage1table'>
        <p>1-es raktár</p>
        <table>";
        $result .= $createTables->createTable('1');
        $result .= "</table>
        <form method='POST'>
            <input type='submit' id='newColumnOne' name='newColumnOne' value='Új polcsor hozzáadása'></input>
        </form>
        </div>";
    }
    else if ($tableNumber == 'Two') {
        $result = "
        <div id='dispTableTwo' class='storage2table'>
        <p>2-es raktár</p>
        <table>";
        $result .= $createTables->createTable('2');
        $result .= "</table>
        <form method='POST'>
            <input type='submit' id='newColumnTwo' name='newColumnTwo' value='Új polcsor hozzáadása'></input>
        </form>
        </div>";
    }

    echo $result;
}