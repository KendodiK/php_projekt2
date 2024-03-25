function openOpcions(selectedId) {
    $.ajax({
        url: 'openModify.php',
        type: 'POST',
        data: {selectedId: selectedId},
        success: function (result) {
            $('#modify').html(result);
        }
    })
}

function displayTable(tableNumber) {
    $.ajax({
        url: 'displayTable.php',
        type: 'POST',
        data: {tableNumber: tableNumber},
        success: function (result) {
            $('#dispTable'+tableNumber).html(result);
        }
    })
}


function changeStorage(currentStorage) {
    if (currentStorage == 1) {
        changeStorageOne(currentStorage);
    }
    else if (currentStorage == 2) {
        changeStorageTwo(currentStorage);
    }
} 

var storageOne = 2;
function changeStorageOne(currentStorage) {
    var toPhp;
    if (storageOne == currentStorage) {
        toPhp = currentStorage;
        storageOne = 2;
    }
    else {
        toPhp = storageOne;
        storageOne = 1;
    }
    currentStorage = toPhp;
    $.ajax({
        url: 'changeColumn.php',
        type: 'POST',
        data: {currentStorage: currentStorage},
        success: function (result) {
            $('#newColumn').html(result);
        }
    })
}

var storageTwo = 1;
function changeStorageTwo(currentStorage) {
    var toPhp;
    if (storageTwo == currentStorage) {
        toPhp = currentStorage;
        storageTwo = 1;
    }
    else {
        toPhp = storageTwo;
        storageTwo = 2;
    }
    currentStorage = toPhp;
    $.ajax({
        url: 'changeColumn.php',
        type: 'POST',
        data: {currentStorage: currentStorage},
        success: function (result) {
            $('#newColumn').html(result);
        }
    })
}

function changeColumn(changedColumn, storage) {
    changed = changedColumn.value;
    $.ajax({
        url: 'changeRow.php',
        type: 'POST',
        data: {
            changed: changed,
            storage: storage
        },
        success: function (result) {
            $('#newRow').html(result);
        }
    })
}