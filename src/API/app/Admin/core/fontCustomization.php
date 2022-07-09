<div class='sectionTitle'><img src='src/icons/font.svg' alt='Font Customization' />Font Customization</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>

<style>
    #fontOptions {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        row-gap: 25px;
    }

    #font-snippet {
        background-color: var( --grey-Dark );
        padding: var( --m3-inputText-padding );
        border-radius: var( --m3-inputText-borderRadius );
        width: fit-content;
        margin: 10px 0px;
    }

    #fontUpload {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        column-gap: 10px;
    }

    #fontList {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        row-gap: 5px;
        margin-top: 5px;
    }

    #fontList > div {
        display: flex;
        flex-direction: row;
        align-items: center;
        background-color: var( --grey-Dark );
        border-radius: var( --m3-standard-borderRadius );
        padding: var( --m3-inputText-padding );
    }
</style>

<div id='fontOptions'>
    <div>
        Choose your custom Font from the Dropdown List:
        <div id='font-snippet'>
            <code>
            @font-face {<br>
            &nbsp;&nbsp;&nbsp;&nbsp;font-family: 'Server Font';<br>
            &nbsp;&nbsp;&nbsp;&nbsp;src: url('/src/res/<select id='fontSelection'><?php foreach ( scandir( $_SERVER["DOCUMENT_ROOT"] . '/src/res/' ) as $file ) if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/src/res/' . $file ) and in_array( 'ttf', explode( '.', $file ) ) ) echo "<option id='" . $file . "' value='" . $file . "'>" . $file . "</option>"; ?></select>');<br>
            }
            </code>
        </div>
        <button type='submit' id='applyFont' class='button'><img src='src/icons/saveFloppy.svg' />Apply Font</button>
    </div>
    <div>
        Upload your custom Font:
        <form id='fontUpload' method='POST' enctype='multipart/form-data'>
            <input type='file' name='file' id='file' class='button primaryColor' accept='.ttf' required />
                <input type="hidden" id="sourcePath" name="path" value="/src/res/">
            <input type='submit' id='submit' class='button primaryColor' value='Upload Font' />
        </form>
    </div>
    <div>
        List of installed custom Font:
        <div id='fontList'>
            <?php
                $rawFolder = scandir( $_SERVER["DOCUMENT_ROOT"] . '/src/res/' );
                $fonts = [];
                foreach ( $rawFolder as $chunk )
                    if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/src/res/' . $chunk ) and in_array( 'ttf', explode( '.', $chunk ) ) )
                        array_push( $fonts, $chunk );
                sort( $fonts );
                if ( count( $fonts ) )
                    foreach ( $fonts as $font )
                        if ( $font == file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/defaultFont' ) )
                            echo "<div>" . $font . "<a href='/src/res/" . $font . "'><button type='button' class='button iconStyle primaryColor' title='Download Custom Font'><img src='src/icons/download.svg' /></button></a></div>";
                        else
                            echo "<div>" . $font . "<a href='/src/res/" . $font . "'><button type='button' class='button iconStyle primaryColor' title='Download Custom Font'><img src='src/icons/download.svg' /></button></a><button type='button' class='button iconStyle primaryColor deleteCustomFont' name='" . $font . "' title='Delete this Custom Font'><img src='src/icons/remove.svg' /></button></div>";
                else
                    echo "<div>No Custom Font installed<div>";
            ?>
        </div>
    </div>
</div>

<script>
    $('#applyFont').click(function () {
        console.log( $('#fontSelection').children("option:selected").val() );
        $.ajax({
            url: 'core/API/updateFont.php?font=' + $('#fontSelection').children("option:selected").val(),
            type: 'GET',
            success: function (data) {
                location.reload();
            },
            error: function () {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('.deleteCustomFont').click(function () {
        $.ajax({
            url: '/src/API/deleteFile.php?path=/src/res/&fileName=' + $(this).attr('name'),
            type: 'GET',
            success: function (data) {
                updateView('fontCustomization.php');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('form#fontUpload').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/src/API/uploadFile.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                if ( data == 'Success: File Uploaded' ) {
                    snackbarNotification('Font Upload Complete, you can now select it from the dropdown menu', 'info.svg');
                    updateView('fontCustomization.php');
                } else {
                    snackbarNotification('Error while uploading the custom Font', 'hexError.svg');
                }
            },
            error: function () {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>