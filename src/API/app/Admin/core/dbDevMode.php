<div class='sectionTitle'><img src='src/icons/developerMode.svg' alt='Database Settings Icon' />Database Settings</div><hr>
<style>
    #submitQuery > .input {
        width: -webkit-fill-available;
    }

    #submitQuery > div {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .button {
        margin: 10px 10px 10px 0px;
    }

    #queryField {
        resize: none;
        height: auto;
    }
</style>
<?php include '../src/include/customFunctions.inc.php' ?>
<form id='submitQuery' method='POST' enctype='multipart/form-data'>
    <textarea id='queryField' class='input' name='query' rows='10'></textarea>
    <!--<input type='text' id='queryField' class='input' name='query'>-->
    <div>
        <button type='submit' class='button'><img src='src/icons/runIcon.svg' alt='Run Query Icon' />Run Query</button>
        <button type='button' id='clearQueryField' class='button'><img src='src/icons/resetQuery.svg' alt='Clear Query Field' />Clear Query Field</button>
        <button type='button' id='deleteResult' class='button'><img src='src/icons/deleteForever.svg' alt='Delete Results' />Delete Results</button>
    </div>
</form>
<div id='printResult'>
</div>
<button type='button' id='resetDatabase' class='button'><img src='src/icons/deleteForever.svg' alt='Reset Database' />Reset Database</button>
<script>
    //var fields = [ <?php foreach ( $fields as $field ) echo '\'' . $field . '\', '; ?> ];
</script>
<script src='core/API/dbFunctions.js'></script>
<script>
    var ovveride_createTable = false;
    var ovveride_dropTable = false;
    var ovveride_createDatabase = false;
    //var ovveride_dropDatabase = false;

    $('.canCopy').click(function () {
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val($(this).text()).select();
        document.execCommand('copy');
        $temp.remove();
        snackbarNotification('String copied to clipboard!', 'copy.svg');
    });

    function checkQuery ( query ) {
        var noticedTimes = 0;
        var agreed = 0;

        if ( query.toUpperCase().includes('CREATE TABLE') && !ovveride_createTable ) {
            ovveride_createTable = confirm("We found in your Query an operation of 'CREATE TABLE'.\nAre you sure you want to continue?\nYour full Query is: " + query);
            noticedTimes++;
            if ( ovveride_dropTable ) {
                agreed++;
                alert("You can now run Query for Creating Tables");
            }
        }

        if ( ( query.toUpperCase().includes('DROP TABLE') && !ovveride_dropTable ) || ( query.toUpperCase().includes('TRUNCATE TABLE') && !ovveride_createTable ) ) {
            ovveride_dropTable = confirm("We found in your Query an operation of 'DROP TABLE'/'TRUNCATE TABLE'.\nAre you sure you want to continue?\nYour full Query is: " + query);
            noticedTimes++;
            if ( ovveride_dropTable ) {
                agreed++;
                alert("You can now run Query for Dropping and Truncating Tables");
            }
        }
        
        if ( query.toUpperCase().includes('CREATE DATABASE') && !ovveride_createDatabase ) {
            ovveride_createDatabase = confirm("We found in your Query an operation of 'CREATE DATABASE'.\nAre you sure you want to continue?\nYour full Query is: " + query);
            noticedTimes++;
            if ( ovveride_createDatabase ) {
                agreed++;
                alert("You can now run Query for Creating Databases");
            }
        }

        //if ( query.toUpperCase().includes('DROP DATABASE') && !ovveride_dropDatabase ) {
        if ( query.toUpperCase().includes('DROP DATABASE') ) {
            alert("We found in your Query an operation of 'DROP DATABASE'.\nThis operation cannot continue, use the button below to do this critical action!");
            return false;
            //ovveride_dropDatabase = confirm("We found in your Query an operation of 'DROP DATABASE'.\nAre you sure you want to continue?\nYour full Query is: " + query);
            //noticedTimes++;
            //if ( ovveride_dropDatabase ) {
            //    agreed++;
            //    alert("You can now run Query for Dropping Databases");
            //}
        }

        return noticedTimes == agreed;
    }

    $('form#submitQuery').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ( checkQuery( $('#queryField').val() ) && $('#queryField').val() != '' )
            $.ajax({
                url: 'core/API/sqlProcessor.php',
                type: 'POST',
                data: formData,
                success: function (data) {
                    $('#printResult').html(data);
                },
                error: function (data) {
                    snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
                },
                cache: false,
                contentType: false,
                processData: false
            })
    });

    $('#clearQueryField').click(function () {
        $('#queryField').val('');
    });

    $('#deleteResult').click(function () {
        $('#printResult').empty();
    })

    $('#resetDatabase').click(function () {
        var defaultDB = '';
        var username = '';
        var password = '';
        var confirmPassword = '';
        var temp = '';
        if ( confirm("WARNING!\nYou pressed the button to reset the entire Database!\nThis means that every Table, every Data stored in this Database will be lost forever!\nAre you sure you want to continue?") ) {
            alert("For safety reason this process will be annoying to make sure you REALLY want to reset the Database");
            defaultDB = prompt('To make sure you want to reset the Database, please, input the correct Database name:');
            username = prompt('Now input the username you inserted in the Settings Screen:');
            password = prompt('Please input the password associated to the username you previously inserted:');
            confirmPassword = prompt('Input again the password for confirmation:');
            temp = prompt("WARNING!\nThis is the last Warning you will receive!\nAre you really sure you want to reset the Database?\nIf you continue we will perform a check on the data you have inserted to make sure they are valid and then we will proceed to reset the Database.\nType: 'YES, I AM ABSOLUTELY SURE TO RESET THE DATABASE' to continue, anything to abort");
            if ( temp.toUpperCase() == 'YES, I AM ABSOLUTELY SURE TO RESET THE DATABASE' ) {
                alert("For extremely safety reason this process is disabled for now");
            } else {
                alert('Database Reset operation aborted');
            }
        }
    });
</script>