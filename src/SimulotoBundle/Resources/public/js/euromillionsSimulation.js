/**
 * execute an ajax call
 * @param uNumbers array: numbers selected by user from checkboxes
 * @param countGames array: count how many draw simulation has to do
 **/

function sendUNumbers(uNumbers, uStars, countGames) {

    /** creating ajax request **/
    var url = Routing.generate('execute_euromillions_simulation');

    $.post(
            url,
            {uNumbers: uNumbers, uStars: uStars, countGames: countGames},
            function (response) {
                if (response.code == 100 && response.success) {
                    window.console.log(response);
                    if (response.message == "none") {
                        var score = response.score;
                        var simulationDetails = response.arrSimulationDetails;
                        var countGames = response.countGames;

                        /**  build HtmlTable score  **/
                        var $htmlTable = buildHtmlTable(score);

                        /** empty previous content  **/
                        $('#score, #scoreDetails, #details').empty();
                        $('#p_details').remove();

                        $('#score').append($htmlTable);

                        /**  build Html Table details simulation   **/
                        //TODO attach it to the dom: create <div> after div#score
                        var $htmlTableDetails = buildSimulationDetails(simulationDetails, countGames);

                        $('#scoreDetails').append('<button id="p_details" class="btn btn-primary">Afficher les tirages</button>');
                        $('#p_details').on({
                            click: function () {
                                $('#details').slideToggle('normal', 'linear', function () {
                                    $(this).append($htmlTableDetails);
                                });
                            }
                        })
                    } else {
                        /** creating div alert error  **/
                        var $div = $("<div>");
                        $div.addClass('alert alert-danger customAlert').html('<strong>' + response.message + '<strong>');
                        /** add div alert error to the dom **/
                        $('#details').append($div);

                    }
                }

            }, 'json');
}

/**
 * disable all unchecked balls
 * this function is used when when selectedBalls.length >= 10
 * **/
function disableUnchecked($allBalls) {
    $allBalls.each(function (k, v) {
        if (!$(this).attr('checked')) {
            /** needs to add class 'disabled to div parent to set "grey effect" on disable checkbox '**/
            $(this).attr('disabled', true).closest('div').addClass('disabled');
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
        }
    })
}

/**
 *  build an html table representing euromillions score
 *  and attach it to the dom !
 *  
 *  @param jsonObject score
 *  
 *  @return objectHTML <table>
 */
function buildHtmlTable(score) {

    var $table = $('<table>');
    var $thead = $('<thead>');
    var $tbody = $('<tbody>');
    var $tr, $td, $th;

    /** building thead **/
    $tr = $('<tr>');
    var $th1 = $('<th>').html('Bon numéros');
    var $th2 = $('<th>').html('Votre Score');
    $tr.append($th1);
    $tr.append($th2);
    $thead.append($tr);
    $table.append($thead);

    /** building tbody **/
    $.each(score, function (k, v) {
        var $td1 = $('<td>');
        var $td2 = $('<td>');
        $tr = $('<tr>');
        $td1.html(replaceKey(k));
        $td2.html(v);
        $tr.append($td1).append($td2);
        $tbody.append($tr);
        $table.append($tbody);
    })

    /** add style to table **/
    $table.addClass("table table-striped");
    return $table;
}

/**
 * replace key of jsonObject var score key -> key  O = 6 good numbers, key 1 = 5+ good numbers , etc
 * @param int key
 * @return string
 * **/
function replaceKey(key) {

    var result;
    // -1 because key begin with 1 in json object
    switch (parseInt(key)) {
        case 1:
            result = "5 + 2";
            break;
        case 2:
            result = "5 + 1";
            break;
        case 3:
            result = "5";
            break;
        case 4:
            result = "4 + 2";
            break;
        case 5:
            result = "4 + 1";
            break;
        case 6:
            result = "4";
            break;
        case 7:
            result = "3 + 2";
            break;
        case 8:
            result = "2 + 2";
            break;
        case 9:
            result = "3 + 1";
            break;
        case 10:
            result = "3 + 0";
            break;
        case 11:
            result = "1 + 2";
            break;
        case 12:
            result = "2 + 1";
            break;

        case 13:
            result = "2 + 0";
            break;
    }

    return result;
}

/**
 *  build an html table representing detailled simulation result
 *  @param simulationDetails json object
 *
 *  @return objectHTML <table>
 */
function buildSimulationDetails(simulationDetails, countGames) {
//    window.console.log();
//    window.console.log(simulationDetails);
    var arrDraw = simulationDetails.draw;
    var arrDrawStars = simulationDetails.drawStars;
    var arrUnumbers = simulationDetails.uNumbers;
    var arrUStars = simulationDetails.uStars;
    var arrCountGoodBalls = simulationDetails.goodBalls;
    var arrCountGoodStars = simulationDetails.goodStars;

    var $table = $('<table>');
    var $thead = $('<thead>');
    var $tbody = $('<tbody>');
    var $tr, $td, $th;

    /** building thead **/
    $tr = $('<tr>');
    var $th1 = $('<th>').html('Tirage');
    var $th2 = $('<th>').html('Tirage étoiles');
    var $th3 = $('<th>').html('Vos numéros');
    var $th4 = $('<th>').html('Vos étoiles');
    var $th5 = $('<th>').html('Bons numéros');
    var $th6 = $('<th>').html('Bonnes étoiles');

    $tr.append($th1);
    $tr.append($th2);
    $tr.append($th3);
    $tr.append($th4);
    $tr.append($th5);
    $tr.append($th6);
    $thead.append($tr);
    $table.append($thead);

    /** building tbody  **/
    for (var i = 0; i < countGames; i++) {
        $tr = $('<tr>');
        var $td1 = $('<td>');
        var $td2 = $('<td>');
        var $td3 = $('<td>');
        var $td4 = $('<td>');
        var $td5 = $('<td>');
        var $td6 = $('<td>');

        var drawToParse = arrDraw[i];
        var drawStarsToParse = arrDrawStars[i];
        var uNumbersToParse = arrUnumbers[i];
        var uStarsToParse = arrUStars[i];
        var goodBallsToParse = arrCountGoodBalls[i];
        var goodStarsToParse = arrCountGoodStars[i];


        var s = ''; // the string to add into each <td>
        var drawLength = Object.keys(drawToParse).length;

        /** parse draw numbers **/
        $.each(drawToParse, function (k, v) {
            s += v + ' - ';
        });
        // delete white space at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td1.append(s);
        $tr.append($td1);
        s = '';

        /** parse draw stars **/
        $.each(drawStarsToParse, function (k, v) {
            s += v + ' - ';
        });
        // delete white space at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td2.append(s);
        $tr.append($td2);
        s = '';


        /** parse uNumbers **/
        $.each(uNumbersToParse, function (k, v) {
            s += v + ' - ';
        });
        // delete white space at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td3.append(s);
        $tr.append($td3);
        s = '';


        /** parse uStars **/
        $.each(uStarsToParse, function (k, v) {
            s += v + ' - ';
        });
        // delete white aspace at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td4.append(s);
        $tr.append($td4);
        s = '';


        /** parse goodBalls **/
        $.each(goodBallsToParse, function (k, v) {
            s += v + ' - ';
        });
        // delete white aspace at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td5.append(s);
        $tr.append($td5);
        s = '';


        /** parse goodStars **/
        $.each(goodStarsToParse, function (k, v) {
            s += v + ' - ';
        });
        // delete white aspace at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td6.append(s);
        $tr.append($td6);
        s = '';

        //now I can append <tr> on <tbody>
        $tbody.append($tr);

    }

    $table.append($tbody);

    /** add style to table **/
    $table.addClass("table table-striped");
    return $table;

}

/** convert stars value 51 will be 1, 52 will be 2, . . . **/
function convertStarsValue(num) {
    switch (parseInt(num)) {

        case 51:
            num = 1;
            break;
        case 52:
            num = 2;
            break;
        case 53:
            num = 3;
            break;
        case 54:
            num = 4;
            break;
        case 55:
            num = 5;
            break;
        case 56:
            num = 6;
            break;
        case 57:
            num = 7;
            break;
        case 58:
            num = 8;
            break;
        case 59:
            num = 9;
            break;
        case 60:
            num = 10;
            break;
        case 61:
            num = 11;
            break;
    }
    return num;
}


/**
 * Replace stars value ex 51 will be 1, 52 will be 2
 */
function replaceStarsValue() {
    var $labelsCollect = $('label.btn');

    $labelsCollect.each(function (k) {
        /* balls or stars num */
        var num = $(this).html();
        if ($(this).html() >= 51 && $(this).html() <= 61) {
            num = convertStarsValue(num);
            $(this).html(num);
        }
    })
}

$(function () {


    //replaceStarsValue();
    /** form submit prevent default (it uses ajax to send data) **/
    $('form').on({
        submit: function () {
            return false;
        }
    });
    /** using http://www.bootstraptoggle.com/ **/
    var countBalls = 0; // how many balls are selected by user (min 6, max 10)
    var countStars = 0;


    var minBalls = 5; // user must select min 6 balls
    var maxBalls = 10; // user must select max 10 balls

    var minStars = 2;
    var maxStars = 11;

    var $allBalls = $('.ballsCheckBox'); // collection of Lotto balls
    var $allStars = $('.starsCheckBox');

    var selectedBalls = []; // value of user's selected balls ex:[4, 17, 22, 29, 36, 45]
    var selectedStars = [];

    var countGames;


    /** balls and stars config and style  **/
    $('.toggle-on').each(function (k, v) {
        k = convertStarsValue(k + 1);
        $(this).html(k);
//        $(this).bootstrapToggle({
//            on: (k + 1),
//            off: (k + 1),
//            onstyle: 'success',
//            offstyle: 'danger',
//        })
    })

    /** balls and stars config and style  **/
    $('.toggle-off').each(function (k, v) {
        k = convertStarsValue(k + 1);
        $(this).html(k);
//        $(this).bootstrapToggle({
//            on: (k + 1),
//            off: (k + 1),
//            onstyle: 'success',
//            offstyle: 'danger',
//        })
    })

    $('.ios').css({
        "border-radius": '25px'
    })

    /** disable form submit button **/
    $('#form_Simuler').attr('disabled', true);

    /** retrieves user selected balls **/
    $allBalls.each(function (k, v) {
        $(this).on({
            change: function () {
                var ball = parseInt($(this).val());
                //if ball already present in selectedBalls then remove it from that array
                if ($.inArray(ball, selectedBalls) != -1) {
                    $(this).attr('checked', false);
                    selectedBalls.splice(selectedBalls.indexOf(ball), 1);
                    countBalls--;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedStars.length = " + selectedStars.length);

                    if (selectedBalls.length == 9) {
                        enableDisabled($allBalls);
                    }

                    if (selectedBalls.length == 4) {
                        $("#form_Simuler").attr('disabled', true);
                    }

                } else {
                    //if ball not present in selectedBalls array
                    $(this).attr('checked', true);
                    selectedBalls.push(parseInt(ball));
                    countBalls++;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedStars.length = " + selectedStars.length);

                    if (selectedBalls.length >= 5 && selectedBalls.length <= 10 && selectedStars.length > 1) {
                        window.console.log("oui");
                        $("#form_Simuler").removeAttr('disabled');

                    }
                    if (selectedBalls.length >= 10) {
                        disableUnchecked($allBalls);
                    }
                }
            }
        })
    })

    /** retrieves user selected stars **/
    $allStars.each(function (k, v) {
        $(this).on({
            change: function () {
                var star = $(this).val();
                star = convertStarsValue(star);

                //if ball already present in selectedBalls then remove it from that array
                if ($.inArray(star, selectedStars) != -1) {
                    $(this).attr('checked', false);
                    selectedStars.splice(selectedStars.indexOf(star), 1);
                    countStars--;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedStars.length = " + selectedStars.length);

                    if (selectedStars.length == 1) {
                        window.console.log("aaaaa");
                        $("#form_Simuler").attr('disabled', true);
                    }

                } else {
                    //if ball not present in selectedBalls array
                    $(this).attr('checked', true);
                    selectedStars.push(parseInt(star));
                    countStars++;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedStars.length = " + selectedStars.length);

                    if (selectedBalls.length >= 5 && selectedBalls.length <= 10 && selectedStars.length > 1) {
                        window.console.log("zzz");
                        $("#form_Simuler").removeAttr('disabled');
                    }

                }
            }
        })
    })



    /** add eventListener on button sumbit to send ajax **/
    $('#form_Simuler').on({
        click: function (e) {
            e.preventDefault();
            countGames = $('#form_Nombre_de_tirages').val();
            window.console.log('ok japan !');
            if (countBalls >= 5 && countBalls <= 10 && countStars >= 2) {
                window.console.log('ok usa !');
                window.console.log(countGames);
                window.console.log(selectedBalls);
                window.console.log(selectedStars);
                /** retrives countGames before ajax process **/
                countGames = $('#form_Nombre_de_tirages').val();
                sendUNumbers(selectedBalls, selectedStars, countGames);

            }
        }
    })

});