console.log('Server Scripts (JavaScript) Enabled');

var isSideBarOpen = false;
//var prevScrollpos = window.pageYOffset;

function openNavBar ( ctx ) {

    ctx.classList.toggle("change");
    document.getElementById("sideNavBar").style.width = "325px";
    document.getElementById("main").style.marginLeft = "275px";
    document.getElementById("header").style.left = "295px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";

}

function closeNavBar ( ctx ) {

    ctx.classList.toggle("change");
    document.getElementById("sideNavBar").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    document.getElementById("header").style.left = "20px";
    document.body.style.backgroundColor = "white";

}

function sideBarToggler ( ctx ) {

    if ( isSideBarOpen ) {
        isSideBarOpen = false;
        closeNavBar( ctx );

    } else {
        isSideBarOpen = true;
        openNavBar( ctx );

    }

}

$('#login').click( function () {
    $('#registration').removeClass('active');
    $('#registrationForm').css('display', 'none');
    $('#login').addClass('active');
    $('#loginForm').css('display', 'block');
});

$('#registration').click( function () {
    $('#registration').addClass('active');
    $('#registrationForm').css('display', 'block');
    $('#login').removeClass('active');
    $('#loginForm').css('display', 'none');
});

function uninstallApp ( appName ) {
    if ( confirm( 'Are you sure you want to uninstall \'' + appName + '\'?\nThis operation will be irreversible!' ) ) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if ( this.readyState == 4 && this.status == 200 ) {
                alert( this.response );
                location.reload();
            }
        };
        xmlhttp.open("GET", "/src/API/uninstallApp.php?appName=" + appName, true);
        xmlhttp.send();
    } else {
        alert('Uninstall aborted');
    }
}

function deleteFile ( path, fileName ) {
    if ( confirm( 'Are you sure you want to delete this File?\nThis operation will be irreversible!' ) )
        $.ajax({
            url: '/src/API/deleteFile.php?path=' + path + '&fileName=' + fileName,
            type: 'GET',
            success: function (data) {
                alert( data + '\nPage will now reload' );
                window.location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    else
        alert( 'Operation aborted' );
}

function downloadApp ( appName ) {
    alert('App download not implemented yet...');
}

$('#installButton').click(function () {
    if ( confirm( 'Do you want to install a new app?\nYou will be redirected to the setup page' ) )
        window.location.href = "/Applications/setupApp.php";
});

function uploadFile ( section, path ) {
    if ( confirm( 'Do you want to upload a new File in the \'' + section + '\' Section?\nYou will be redirected to the dedicatd page' ) )
        window.location.href = '/src/API/uploadHandler.php?path=' + path;
}

function createFolder ( path ) {
    if ( folderName = prompt('Enter the name of the new Folder:') )
        $.ajax({
            url: '/src/API/createFolder.php?path=' + path + '&folderName=' + folderName,
            type: 'GET',
            success: function (data) {
                alert( data + '\nPage will now reload' );
                window.location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    else
        alert( 'Operation aborted' );
}

function deleteFolder ( path, folderName ) {
    if ( confirm( 'Are you sure you want to delete this Folder?\nThis operation will be irreversible!' ) )
        $.ajax({
            url: '/src/API/deleteFolder.php?path=' + path + '&folderName=' + folderName,
            type: 'GET',
            success: function (data) {
                alert( data + '\nPage will now reload' );
                window.location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    else
        alert( 'Operation aborted' );
}

$('form#uploadPackage').submit(function (e) {
    $('#uploadPackage').after('<img src=\'/src/icons/loadingMini.svg\' />Uploading and Installing...');
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: '/src/API/installApp.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            alert( data + '\nYou will be now redirected' );
            window.location.href = "/Applications/";
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$('form#uploadFile').submit(function (e) {
    $('#uploadFile').after('<img src=\'/src/icons/loadingMini.svg\' />Uploading File...')
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: '/src/API/uploadFile.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            alert( data + '\nYou will be now redirected' );
            //window.location.href = $('#sourcePath').val();
            history.back();
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

function renameFile ( directory, oldChunkName, extension ) {
    var newChunkName = prompt("Type your new chunk name for '" + oldChunkName + "':\nLeave blank to abort");
    if ( newChunkName != '' && newChunkName != null )
        $.ajax({
            url: '/src/API/rename.php?directory=' + directory + '&oldChunkName=' + oldChunkName + '&newChunkName=' + newChunkName + '.' + extension,
            type: 'GET',
            success: function (data) {
                window.location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
}

function renameFolder ( directory, oldChunkName ) {
    var newChunkName = prompt("Type your new chunk name for '" + oldChunkName + "':\nLeave blank to abort");
    if ( newChunkName != '' && newChunkName != null )
        $.ajax({
            url: '/src/API/rename.php?directory=' + directory + '&oldChunkName=' + oldChunkName + '&newChunkName=' + newChunkName,
            type: 'GET',
            success: function (data) {
                window.location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
}