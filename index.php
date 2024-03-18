<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./script.js"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>
<body>
    <?php
    require_once 'DBStorageOne.php';
    require_once 'DBStorageTwo.php';
    require_once 'CreateTables.php';

    $dbstorageOne = new DBStorageOne();
    $dbstorageOne->fillTable('raktaron.csv');
    $dbstorageTwo = new DBStorageTwo();
    $dbstorageTwo->fillTable('raktaron.csv');
    $createTables = new CreateTables();

    $storageOne = $dbstorageOne->getAll();
    $storageTwo = $dbstorageTwo->getAll();

    /*echo"<div class='uj'>
        <h2>Új adat rögzítése</h2>
        <form method='post'>
            <p>Megnevezés:
                <input id='newName' type='text'></input></p>
            <p>Válassza ki melyik raktárban kívánja tárolni: 
                <select id='newStorage' name='newStorage'>
                    <option value='one'>1-es raktár</option>
                    <option value='two'>2-es raktár</option>
                </select></p>
            <p>Válasza ki hogy a raktár hányadik sorára szetetné tenni:
                <select id='newColumn' name='newColumn'>";
                  $numOfColumns = $dbstorageOne->getColumnNum();
                  for($i = 0; $i < $numOfColumns['countOfColumn']; $i++) {
                    echo"<option value='{$i}'>" . $i+1 . "</option>";
                  }  
                echo"</select></p>
            </p>
            <p>Válassza ki hogy hányadik polcra akarja tenni a sorban:
                <select id='newRow' name='newRow'>";    
                    $numOfShelfs = $dbstorageOne->getRowNum();
                    for($i = 0; $i < $numOfShelfs['countOfRow']; $i++) {
                        $selectable = $dbstorageOne->getByColumnAndRow(1, $i+1);
                        if($selectable['name'] == 'üres'){
                            echo"<option value='{$i}'>" . $i+1 . "</option>";
                        }
                    }  
                echo"</select></p>
            </p>
            <input type='submit' value='Felvétel'></input>
        </form>";*/

    echo"</div";

    echo "<div class='storage2table'>
    <p>2-es raktár</p>
    <table>";
        $createTables->createTable('2');
    echo"</table>
    </div>";

    echo "<div class='storage1table'>
    <p>1-es raktár</p>
    <table>";
        $createTables->createTable('1');
    echo"</table>
    </div>";
    ?>
    <div><label for='modify'><p id='modify'></p></label></div>
</body>
</html>