$(document).ready(function(){

    if (typeof(megaslider_speed) == 'undefined')
        megaslider_speed = 500;
    if (typeof(megaslider_pause) == 'undefined')
        megaslider_pause = 3000;
    if (typeof(megaslider_loop) == 'undefined')
        megaslider_loop = true;
    if (typeof(megaslider_width) == 'undefined')
        megaslider_width = 878;
    if (typeof(megaslider_height) == 'undefined')
        megaslider_width = 619;


    if (!!$.prototype.iView)
        $('#megaslider').iView({
            fx: 'random',
            pauseTime: megaslider_pause,
            pauseOnHover: true,
            directionNavHoverOpacity: 0,
            timer: "Bar",
            timerDiameter: "30%",
            timerPadding: 0,
            timerStroke: 7,
            timerBarStroke: 0,
            timerColor: "#FFF",
            timerPosition: "bottom-left"
        });

    $('.megaslider-description').click(function () {
        window.location.href = $(this).prev('a').prop('href');
    });

    if ($('#htmlcontent_top').length > 0)
        $('#homepage-slider').addClass('col-xs-8');
    else
        $('#homepage-slider').addClass('col-xs-12');
});