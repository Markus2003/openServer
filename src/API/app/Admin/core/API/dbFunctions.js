function getSelectedRow () {
    var rowSelected = [];
    var result = [];
    $('.checkboxRow:checked').each(function () {
        rowSelected.push($(this).attr('rowId'));
    });
    if ( rowSelected.length > 0 ) {
        for ( i = 0; i != rowSelected.length; i++ ) {
            var row = document.getElementsByClassName( rowSelected[i] );
            var partialResult = [];
            for ( o = 0; o != fields.length; o++ )
                partialResult.push( row[o].innerHTML );
            result.push( partialResult );
        }
    }
    return result;
};

$('.canCopy').click(function () {
    var $temp = $('<input>');
    $('body').append($temp);
    $temp.val($(this).text()).select();
    document.execCommand('copy');
    $temp.remove();
    snackbarNotification('String copied to clipboard!', 'copy.svg');
});

function inputRowIsValid ( inputRow ) {
    var counter = 0;
    inputRow.forEach(col => { if ( col != '' && col != null ) counter++ });
    return counter > 0;
}

function addNewRow ( table, fields ) {
    var newDatas = [];
    fields.forEach(field => {
        newDatas.push( prompt('Enter Data for field \'' + field + '\':\nLeave everything blank to abort') );
    });
    if ( inputRowIsValid( newDatas ) )
        $.ajax({
            url: 'core/API/sqlOnTheFly.php?datas=' + JSON.stringify({"table": table, "data": newDatas, "fields": fields}) + '&type=INSERT',
            type: 'GET',
            success: function (data) {
                if ( data )
                    snackbarNotification(data, 'hexError.svg');
            },
            error: function (data) {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
}

function editRows ( table, fields, datas ) {
    if ( confirm("You are going to edit " + datas.length + " rows, are you sure to continue?") )
        datas.forEach(row => {
            var data = [];
            for ( var i = 0; i != fields.length; i++ )
                data.push(prompt("Insert new value for column '" + fields[i] + "'\nOld value was '" + row[i] + "'\nLeave blank to abort row edit"));
            if ( inputRowIsValid( data ) )
                $.ajax({
                    url: 'core/API/sqlOnTheFly.php?datas=' + JSON.stringify({"table": table, "oldData": row, "data": newDatas, "fields": fields}) + '&type=UPDATE',
                    type: 'GET',
                    success: function (data) {
                        if ( data )
                            snackbarNotification(data, 'hexError.svg');
                    },
                    error: function (data) {
                        snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
        });
}

function deleteRows ( table, fields, datas ) {
    if ( confirm("Are you sure you want to delete " + datas.length + " rows from table '" + table + "'?\nThis operation will be irreversible") )
        datas.forEach(row => {
            $.ajax({
                url: 'core/API/sqlOnTheFly.php?datas=' + JSON.stringify({"table": table, "data": row, "fields": fields}) + '&type=DELETE',
                type: 'GET',
                success: function (data) {
                    if ( data )
                        snackbarNotification(data, 'hexError.svg');
                },
                error: function (data) {
                    snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
}