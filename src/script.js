console.log('Server Scripts (JavaScript) Enabled');

var isSideBarOpen = false;
//var prevScrollpos = window.pageYOffset;

function openNavBar ( ctx ) {

    ctx.classList.toggle("change");
    document.getElementById("sideNavBar").style.width = "275px";
    document.getElementById("main").style.marginLeft = "235px";
    document.getElementById("header").style.left = "255px";
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
    if ( confirm('Are you sure you want to uninstall \'' + appName + '\'?\nThis operation will be irreversible!' ) ) {
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

function downloadApp ( appName ) {
    alert('App download not implemented yet...');
}

$('#installButton').click(function () {
    if ( confirm( 'Do you want to install a new app?\nYou will be redirected to the setup page' ) )
        window.location.replace("/Applications/setupApp.php");
});

$('form#uploadPackage').submit(function (e) {
    $('#uploadPackage').after('<img src=\'/src/icons/loadingMini.svg\' />Uploading and Installing...')
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: '/src/API/installApp.php',
        type: 'POST',
        data: formData,
        success: function (data) {
            alert( data + '\nYou will be now redirected' );
            window.location.replace("/Applications/");
        },
        cache: false,
        contentType: false,
        processData: false
    });
});