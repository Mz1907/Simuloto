




/** 
 * disable all unchecked balls 
 * this function is used when when selectedBalls.length >= 10
 * **/
function disableUnchecked($allBalls) {
    $allBalls.each(function (k, v) {
        if (!$(this).attr('checked')) {
            /** needs to add class 'disabled to div parent to set "grey effect" on disable checkbox '**/
            $(this).attr('disabled', true).closest('div').addClass('disabled');
            /** enable form submit button **/
            $("#form_Envoyer").removeAttr('disabled');
        }
    })
}

/**
 * enable all disabled balls
 * this function is used when user unselect a ball AND selectedBalls.length >= 10
 * **/
function enableDisabled($allBalls) {
    $allBalls.each(function () {
        if ($(this).attr('disabled')) {
            $(this).removeAttr('disabled').closest('div').removeClass('disabled');
            /** disable form submit button **/
            $("#form_Envoyer").attr('disabled', true);
        }
    })
}

$(function () {

    /** using http://www.bootstraptoggle.com/ **/
    var countBalls = 0; // how many balls are selected by user (min 6, max 10)
    var minBalls = 6; // user must select min 6 balls
    var maxBalls = 10; // user must select max 10 balls

    var $allBalls = $('.ballsCheckBox'); // collection of Lotto balls
    var selectedBalls = []; // value of user's selected balls ex:[4, 17, 22, 29, 36, 45]


    /** balls config and style  **/
    $(':checkbox').each(function (k, v) {
        $(this).bootstrapToggle({
            on: (k + 1),
            off: (k + 1),
            onstyle: 'success',
            offstyle: 'danger',
        })
    })

    $('.ios').css({
        "border-radius": "25px"
    })

    /** disable form submit button **/
    $("#form_Envoyer").attr('disabled', true);

    /** retrieves user selected balls **/
    $allBalls.each(function (k, v) {
        $(this).on({
            change: function () {
                var ball = $(this).val();
                //if ball already present in selectedBalls then remove it from that array
                if ($.inArray(ball, selectedBalls) != -1) {
                    $(this).attr('checked', false);
                    selectedBalls.splice(selectedBalls.indexOf(ball), 1);
                    countBalls--;
                    window.console.log(countBalls);
                    if (selectedBalls.length == 9) {
                        enableDisabled($allBalls);
                    }

                } else {
                    //if ball not present in selectedBalls array
                    $(this).attr('checked', true);
                    selectedBalls.push(ball);
                    countBalls++;
                    window.console.log(countBalls);
                    if (selectedBalls.length >= 10) {
                        disableUnchecked($allBalls);
                    }


                }
            }
        })
    })
})

