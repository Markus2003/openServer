$('.chip').click(function () { $(this).toggleClass('active'); });

$('.switch').click(function () { if ( $(this).hasClass('on') ) $(this).attr('aria-checked', 'false'); else $(this).attr('aria-checked', 'true'); $(this).toggle('on'); });