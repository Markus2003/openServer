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
                //alert( data + '\nPage will now reload' );
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
    //if ( confirm( 'Do you want to upload a new File in the \'' + section + '\' Section?\nYou will be redirected to the dedicatd page' ) )
        window.location.href = '/src/API/uploadHandler.php?path=' + path;
}

function createFolder ( path ) {
    if ( folderName = prompt('Enter the name of the new Folder:') )
        $.ajax({
            url: '/src/API/createFolder.php?path=' + path + '&folderName=' + folderName,
            type: 'GET',
            success: function (data) {
                //alert( data + '\nPage will now reload' );
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
                //alert( data + '\nPage will now reload' );
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
    $('#uploadPackage').after('<div class=\'uploader\'><img src=\'/src/icons/loadingMini.svg\' />Uploading and Installing...</div>');
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: '/src/API/installApp.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            if ( data.includes('Error') )
                alert( data + '\nYou will be now redirected' );
            window.location.href = "/Applications/";
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$('form#uploadFile').submit(function (e) {
    e.preventDefault();
    $('#uploadFile').after('<div id=\'uploadStatus\' class=\'uploader\'><img src=\'/src/icons/loading.svg\' width=\'24px\' height=\'24px\' />Uploading File...</div>')
    var formData = new FormData(this);
    $('#file').attr('disabled', true);
    $('#submit').attr('disabled', true);
    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    $('#submit').val('Upload at ' + percentComplete + '%');
                }
            }, false);

            return xhr;
        },
        url: '/src/API/uploadFile.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            if ( data.includes('Error') )
                alert( data + '\nYou will be now redirected' );
            //window.location.href = $('#sourcePath').val();
            history.back();
        },
        error: function () {
            $('#file').removeAttr('disabled');
            $('#submit').removeAttr('disabled');
            $('#uploadStatus').remove();
            window.alert('Something went wrong, file was not uploaded...');
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

$('.revealPassword').click(function () {
    switch ( $(this).attr('src') ) {
        case '/src/icons/visibilityOn.svg':
            $('.password').attr('type', 'text');
            $('.revealPassword').attr('src', '/src/icons/visibilityOff.svg');
        break;

        case '/src/icons/visibilityOff.svg':
            $('.password').attr('type', 'password');
            $('.revealPassword').attr('src', '/src/icons/visibilityOn.svg');
        break;
    }
});

function removeExtensionFromFile ( rawName ) {
    rawName = rawName.split('.');
    rawName.pop();
    if ( rawName.length > 1 ) {
        var result = '';
        for ( var i = 0; i != rawName.length; i++ )
            if ( i == rawName.length - 1 )
                result += rawName[i];
            else
                result += rawName [i] + '.';
        return result;
    } else
        return rawName[0];
}

function downloadApp ( appName ) {
    //$.ajax({
    //    url: '/src/API/downloadApp.php?appName=' + appName,
    //    type: 'GET',
    //    success: function (data) {
    //        console.log( data );
    //    },
    //    cache: false,
    //    contentType: false,
    //    processData: false
    //});
    window.location.href = '/src/API/downloadApp.php?appName=' + appName;
}

function getTVSeriesName ( rawName ) {
    rawName = removeExtensionFromFile( rawName );
    result = rawName.split(' - ');
    return result[0];
}

function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function snackbarNotification (text, img='') {
    if (img!='')
        img = '/src/icons/' + img;
    $('#snackbar').empty();
    $('#snackbar').prepend('<span><img src=\'' + img + '\' />' + text + '</span>');
    $('#snackbar').toggleClass('show');
    setTimeout(function () {
        $('#snackbar').toggleClass('show');
    }, 3000);
}

$('.getFolderSize').click(function () {
    $(this).html("<img src='/src/icons/loading.svg' />Calculating...");
    object = $(this);
    $.ajax({
        url: '/src/API/getSize.php?type=folder&location=' + $(this).attr('location'),
        type: 'GET',
        success: function (data) {
            object.html("<img src='/src/icons/spaceUsage.svg' />" + data);;
        },
        error: function () {
            object.html("<img src='/src/icons/error.svg' />Error");
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$('.getFileSize').click(function () {
    $(this).html("<img src='/src/icons/loading.svg' />Calculating...");
    object = $(this);
    $.ajax({
        url: '/src/API/getSize.php?type=file&location=' + $(this).attr('location'),
        type: 'GET',
        success: function (data) {
            object.html("<img src='/src/icons/spaceUsage.svg' />" + data);;
        },
        error: function () {
            object.html("<img src='/src/icons/error.svg' />Error");
        },
        cache: false,
        contentType: false,
        processData: false
    });
});