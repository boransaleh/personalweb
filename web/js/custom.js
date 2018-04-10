$(document).ready(function() {

    var HeaderHeight=$('nav').outerHeight();




    $('.mainmenue').click(function (e) {


        var linkHref = $(this).attr('href');

        var section=linkHref.replace('/','');

        $('html,body').animate({
            scrollTop: $(section).offset().top - HeaderHeight
        },500);
        e.preventDefault();
    });

});



$("#passwordclick").click(function(){

    $('#login_form').hide(1000);
    $('#forgetpass').show('slow');

});




$("#loginclick").click(function(){

    $('#forgetpass').hide(1000);
    $('#login_form').show('slow');

});



var url = window.location.href.toLowerCase();

$('#submenu a').each(function () {



    var $this = $(this);

    var href = $this.attr("href").toLowerCase();

    if(url.indexOf(href) > -1) {
        $this.addClass("activelink");
    }




});




$('#registration_form_plainPassword_first').keyup(function(e) {

    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{6,}).*", "g");


    if (false == enoughRegex.test($(this).val())) {

        $('#passwordChecker').removeClass('progress-bar-warning');
        $('#passwordChecker').removeClass('progress-bar-success');
        $('#passwordChecker').removeClass('progress-bar-info');
        $('#passwordChecker').addClass('progress-bar-danger');
        $('#passwordChecker').width('30%');
    } else if (strongRegex.test($(this).val())) {
        $('#passwordChecker').removeClass('progress-bar-info');
        $('#passwordChecker').removeClass('progress-bar-danger');

        $('#passwordChecker').addClass('progress-bar-success');
        $('#passwordChecker').width('100%');

    } else if (mediumRegex.test($(this).val())) {
        $('#passwordChecker').removeClass('progress-bar-success');
        $('#passwordChecker').removeClass('progress-bar-danger');
        $('#passwordChecker').addClass('progress-bar-info');
        $('#passwordChecker').width('70%');

    }
    return true;




});




$(document).ready(function() {

    // Basic usage
    $(".placepicker").placepicker();

    // Advanced usage
    $("#advanced-placepicker").each(function() {
        var target = this;
        var $collapse = $(this).parents('.form-group').next('.collapse');
        var $map = $collapse.find('.another-map-class');

        var placepicker = $(this).placepicker({
            map: $map.get(0),
            placeChanged: function(place) {
                console.log("place changed: ", place.formatted_address, this.getLocation());
            }
        }).data('placepicker');
    });

}); // END document.ready



