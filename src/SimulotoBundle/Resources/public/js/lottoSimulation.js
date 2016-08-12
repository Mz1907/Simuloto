/** functions definitions **/


/**
 * execute an ajax call
 * @param uNumbers array: numbers selected by user from checkboxes
 * @param countGames array: count how many draw simulation has to do
 **/

function sendUNumbers(uNumbers, countGames) {

    /** creating ajax request **/
    var url = Routing.generate('execute_lotto_simulation');


    $.post(
            url,
            {uNumbers: uNumbers, countGames: countGames},
            function (response) {
                if (response.code == 100 && response.success) {//dummy check
                    window.console.log(response);
                    if (response.validation.message == "none") {

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
                        if ($('.customAlert')) {
                            $('.customAlert').remove();
                        }
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
            /** enable form submit button **/
            $("#form_Simuler").removeAttr('disabled');
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
            $("#form_Simuler").attr('disabled', true);
        }
    })
}

/**
 *  build an html table representing lotto score
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
            result = "6";
            break;
        case 2:
            result = "5+";
            break;
        case 3:
            result = "5";
            break;
        case 4:
            result = "4+";
            break;
        case 5:
            result = "4";
            break;
        case 6:
            result = "3+";
            break;
        case 7:
            result = "3";
            break;
        case 8:
            result = "2+";
            break;
    }

    return result;
}

/**
 *  build build an html table representing detailled simulation result 
 *  @param simulationDetails json object
 *  
 *  @return objectHTML <table>
 */
function buildSimulationDetails(simulationDetails, countGames) {
//    window.console.log();
//    window.console.log(simulationDetails);
    var arrDraw = simulationDetails.draw;
    var arrUnumbers = simulationDetails.uNumbers;
    var arrCountGoodBalls = simulationDetails.goodBalls;

    var $table = $('<table>');
    var $thead = $('<thead>');
    var $tbody = $('<tbody>');
    var $tr, $td, $th;

    /** building thead **/
    $tr = $('<tr>');
    var $th1 = $('<th>').html('Tirage');
    var $th2 = $('<th>').html('Vos numéros');
    var $th3 = $('<th>').html('Bons numéros');

    $tr.append($th1);
    $tr.append($th2);
    $tr.append($th3);
    $thead.append($tr);
    $table.append($thead);

    /** building tbody  **/
    for (var i = 0; i < countGames; i++) {
        $tr = $('<tr>');
        var $td1 = $('<td>');
        var $td2 = $('<td>');
        var $td3 = $('<td>');

        var drawToParse = arrDraw[i];
        var uNumbersToParse = arrUnumbers[i];
        var goodBallsToParse = arrCountGoodBalls[i];
        var s = ''; // the string to add into each <td>
        var drawLength = Object.keys(drawToParse).length;

        /** parse draw numbers to set to td1 **/
        $.each(drawToParse, function (k, v) {
            //comp number will be printed between parenthesis
            if (k == drawLength) {
                s += '(' + v + ')';
            } else
                s += v + ' - ';
        });
        // delete white space at the end
        s = s.trim();
        $td1.append(s);
        $tr.append($td1);
        s = '';


        /** parse uNumbers numbers to set to td2 **/
        $.each(uNumbersToParse, function (k, v) {
            s += v + '  - ';
        });
        // delete white aspace at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td2.append(s);
        $tr.append($td2);
        s = '';

        /** parse goodBalls numbers to set to td3 **/
        $.each(goodBallsToParse, function (k, v) {

            s += v + ' - ';
        });
        if (goodBallsToParse.length == 0) {
            s = '0-';
        }
        // delete white aspace at the end
        s = s.trim();
        s = s.substr(0, s.length - 1);
        $td3.append(s);
        $tr.append($td3);

        //now I can append <tr> on <tbody>
        $tbody.append($tr);

    }

    $table.append($tbody);

    /** add style to table **/
    $table.addClass("table table-striped");
    return $table;

}

function resetForm() {
    $('#form_reset').each(function () {
        $(this).toggle('off');
    })
}


/** Execution **/

$(function () {
    /** using http://www.bootstraptoggle.com/ **/
    var countBalls = 0; // how many balls are selected by user (min 6, max 10)
    var minBalls = 6; // user must select min 6 balls
    var maxBalls = 10; // user must select max 10 balls

    var $allBalls = $('.ballsCheckBox'); // collection of Lotto balls
    var selectedBalls = []; // value of user's selected balls ex:[4, 17, 22, 29, 36, 45]
    var countGames;
    window.executeOnchangeEventFlag = true;


    /** form submit prevent default (it uses ajax to send data) **/
    $('form').on({
        submit: function () {
            return false;
        }
    });

    /**
     * Implement onclick event on reset button
     */
    $('#form_Reset').on({
        click: function () {


            window.executeOnchangeEventFlag = false;

            //enable any disabled balls.
            enableDisabled($allBalls);

            $(':checkbox').each(function (k, v) {

                if ($(this).prop('checked')) {
                    $(this).bootstrapToggle('toggle');
                    $(this).removeAttr('checked');
                }

            })

            //set counter to zero
            countBalls = 0;
            selectedBalls = [];
            selectedBalls.length = 0;
            countGames = 0;

            window.executeOnchangeEventFlag = true;

        }
    })

    /** adding class active on menu_left link **/
    $('.linkLotto').addClass('active');

    /** balls config and style  **/
    $(':checkbox').each(function (k, v) {
        $(this).bootstrapToggle({
            on: (k + 1),
            off: (k + 1)
        })
    })

    $('.ios').css({
        "border-radius": '25px'
    })

    /** disable form submit button **/
    $('#form_Simuler').attr('disabled', true);





    $allBalls.each(function (k, v) {
        $(this).on({
            change: function () {
                if (window.executeOnchangeEventFlag) {
                    var ball = $(this).val();
                    //if ball already present in selectedBalls then remove it from that array
                    if ($.inArray(ball, selectedBalls) != -1) {
                        $(this).attr('checked', false);
                        selectedBalls.splice(selectedBalls.indexOf(ball), 1);
                        countBalls--;

                        window.console.log("selectedBalls.length = " + selectedBalls.length);

                        if (selectedBalls.length == 9) {
                            enableDisabled($allBalls);
                            $("#form_Simuler").removeAttr('disabled');
                        }

                        if (selectedBalls.length == 5) {
                            $("#form_Simuler").attr('disabled', true);
                        }

                    } else {
                        //if ball not present in selectedBalls array
                        $(this).attr('checked', true);
                        selectedBalls.push(ball);
                        countBalls++;

                        window.console.log("selectedBalls.length = " + selectedBalls.length);

                        if (selectedBalls.length == 6) {
                            $("#form_Simuler").removeAttr('disabled');
                        }
                        if (selectedBalls.length >= 10) {
                            disableUnchecked($allBalls);
                        }
                    }
                }
            }
        })
    })

    /** add eventListener on button sumbit to send ajax **/
    $('#form_Simuler').on({
        click: function (e) {
            e.preventDefault();
            window.console.log('ok japan !');
            if (countBalls >= 6 && countBalls <= 10) {
                window.console.log('ok usa !');
                window.console.log(selectedBalls);
                /** retrives countGames before ajax process **/
                countGames = $('#form_Nombre_de_tirages').val();
                sendUNumbers([selectedBalls], countGames);

            }
        }
    })

})

