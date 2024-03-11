<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>
<body>
    <?php
    require_once 'DBStorageOne.php';
    require_once 'DBStorageTwo.php';

    $dbstorageOne = new DBStorageOne();
    $dbstorageOne->fillTable('raktaron.csv');
    $dbstorageTwo = new DBStorageTwo();
    $dbstorageTwo->fillTable('raktaron.csv');

    $storageOne = $dbstorageOne->getAll();
    $storageTwo = $dbstorageTwo->getAll();

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
                    default:
                        return "almostFull";
                }
    }

    echo"<div class='uj'>
        <h2>Új adat rögzítése</h2>
        <form method='post'>
            <p>Megnevezés:<input id='newName' type='text'></input></p>
        </form>";

    echo"</div";
    
    echo "<div class='storage2table'>
    <p>2-es raktár</p>
    <table>";
    for($i = 0; $i < count($storageTwo)/4; $i++){
        echo"<tr>
        <td><button class='".whichClass($storageTwo[$i]['quantity'], $storageTwo[$i]['max'])."' id='btn-open-{$storageTwo[$i]['id']}' onclick='openOpcions()'>{$storageTwo[$i]['name']}</button></td>
        <td><button class='".whichClass($storageTwo[$i+10]['quantity'], $storageTwo[$i+10]['max'])."' id='btn-open-{$storageTwo[$i+10]['id']}' onclick='openOpcions()'>{$storageTwo[$i+10]['name']}</button></td>
        <td><button class='".whichClass($storageTwo[$i+20]['quantity'], $storageTwo[$i+20]['max'])."' id='btn-open-{$storageTwo[$i+20]['id']}' onclick='openOpcions()'>{$storageTwo[$i+20]['name']}</button></td>
        <td><button class='".whichClass($storageTwo[$i+30]['quantity'], $storageTwo[$i+30]['max'])."' id='btn-open-{$storageTwo[$i+30]['id']}' onclick='openOpcions()'>{$storageTwo[$i+30]['name']}</button></td>
        </tr>";
    }
    echo"</table>
    </div>";

    echo "<div class='storage1table'>
    <p>1-es raktár</p>
    <table>";
    for($i = 0; $i < count($storageOne)/2; $i++){
        echo"<tr>
            <td><button class='".whichClass($storageOne[$i]['quantity'], $storageOne[$i]['max'])."' id='btn-open-{$storageOne[$i]['id']}' onclick='openOpcions()'>{$storageOne[$i]['name']}</button></td>
            <td><button class='".whichClass($storageOne[$i+15]['quantity'], $storageOne[$i+15]['max'])."' id='btn-open-{$storageOne[$i+15]['id']}' onclick='openOpcions()'>{$storageOne[$i+15]['name']}</button></td>
        </tr>";
    }
    echo"</table>
    </div>";
    ?>
</body>
</html>