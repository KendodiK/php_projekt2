function openOpcions(selectedId) {
    $.ajax({
        url: 'openModify.php',
        type: 'POST',
        data: {selectedId: selectedId},
        success: function (resoult) {
            $('#modify').html(resoult);
        }
    })
}