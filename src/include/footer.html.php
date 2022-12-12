<dialog id='dialog'>
    <form method='dialog'>
        <div class='dialogHead'>
        </div>
        <div class='bottom'>
            <div class='text'>
            
            </div>
        </div>
    </form>
</dialog>

<div id='snackbar'></div>

<footer class='primaryColor'>
    <b><code>openServer</code></b><br>
    an open source program from <code>Marco Ricci</code><br>
    <a href='https://github.com/Markus2003'><img src='/src/icons/github.svg' /></a><br>
    <h5 id='version'>
        <code>openServer</code> version: <?php echo '<code>' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionName' ) . '</code> - <code>' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionStatus' ) . '-' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) . '</code>' ?>
    </h5>
</footer>

<script>
    function createDialog ( dialogType='alert', title='Window', text='', inputType='text', isRequired=false ) {
        $('#dialog > form > .bottom > .inputField').remove();
        $("#dialog > form > .bottom > button").remove();
        $('#dialog > form > .dialogHead').html(title);
        $('#dialog > form > .bottom > .text').html(text);
        switch ( dialogType ) {
            case 'alert':
                $('#dialog > form > .bottom').append($("<button type='submit' class='button primaryColor-Dark'></button>").html('OK'));
            break;

            case 'dialog':
                $('#dialog > form > .bottom').append($("<input type='text' class='inputField textInputs' name='result'>"));
                $('#dialog > form > .bottom > .inputField').attr('type', inputType);
                if ( isRequired ) $('#dialog > form > .bottom > .inputField').prop('required', true);
                else $('#dialog > form > .bottom > .inputField').prop('required', false);
                $('#dialog > form > .bottom').append($("<button type='submit' class='button primaryColor-Dark'></button>").html('OK'));
                $('#dialog > form > .bottom').append($("<button type='submit' class='button primaryColor-Dark'></button>").html('CANCEL'));
            break;

            case 'confirm':
                $('#dialog > form > .bottom').append($("<button type='submit' class='button primaryColor-Dark'></button>").html('OK'));
                $('#dialog > form > .bottom').append($("<button type='submit' class='button primaryColor-Dark'></button>").html('CANCEL'));
            break;
        }
        dialog.showModal();
    }
</script>