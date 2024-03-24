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