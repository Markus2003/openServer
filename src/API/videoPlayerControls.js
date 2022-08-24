$('#previousFile').click(function () {
    if ( files.indexOf( $('#sourcePath').attr('currentFile') ) > 0 ) {
        $('#videoTitle').html( removeExtensionFromFile( files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ] ) );
        $('#sourcePath').attr('src', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ]);
        $('#quickDownload').attr('href', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ]);
        $('#sourcePath').attr('currentFile', files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ] );
        $('#videoPlayer')[0].load();
    }
});

$('#nextFile').click(function () {
    if ( files.indexOf( $('#sourcePath').attr('currentFile') ) < files.length - 1 ) {
        $('#videoTitle').html( removeExtensionFromFile( files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ] ) );
        $('#sourcePath').attr('src', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ]);
        $('#sourcePath').attr('currentFile', files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ] );
        $('#quickDownload').attr('href', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ]);
        $('#videoPlayer')[0].load();
    }
});