/**
 * execute an ajax call
 * @param uNumbers array: numbers selected by user from checkboxes
 * @param countGames array: count how many draw simulation has to do
 **/

function sendUNumbers(uNumbers, uChance, countGames) {

    /** creating ajax request **/
    var url = Routing.generate('execute_lotoFr_simulation');

    $.post(
            url,
            {uNumbers: uNumbers, uChance: uChance, countGames: countGames},
            function (response) {
                if (response.code == 100 && response.success) {
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
 * mustDisabledBalls: check if so called "multiple grid" is valid
 * 
 * @param {int} ballsLength: how many selected balls 
 * @param {int} chanceLength: haow many selected stars
 * @returns {boolean}
 */
function mustDisableBalls(ballsLength, chanceLength) {


    if (chanceLength >= 1) {
        if (ballsLength >= 9) {
            return true;
        }
    }
    if (chanceLength >= 3) {
        if (ballsLength >= 8) {
            return true;
        }
    }
    if (chanceLength >= 8) {
        if (ballsLength >= 7) {
            return true;
        }
    }
    if (chanceLength >= 8) {
        if (ballsLength >= 7) {
            return true;
        }
    }
    if (chanceLength >= 10) {
        if (ballsLength >= 6) {
            return true;
        }
    }
    if(ballsLength >= 9){
        return true;
    }
    return false;
}

/**
 * 
 * @param {int} ballsLength
 * @param {int} chanceLength
 * @returns {boolean}
 */
function mustDisableChance(ballsLength, chanceLength) {
    if (ballsLength == 9) {
        if (chanceLength >= 1) {
            return true;
        }
    }
    if (ballsLength >= 8) {
        if (chanceLength >= 3) {
            return true;
        }
    }
    if (ballsLength >= 7) {
        if (chanceLength >= 8) {
            return true;
        }
    }
    return false;
}

/**
 * 
 * @param {int} ballsLength
 * @param {int} chanceLength
 * @returns {boolean}
 */
function enableSubmit(ballsLength, chanceLength) {
    var result = false;

    if (ballsLength == 5 || ballsLength == 6) {
        if (chanceLength >= 1) {
            return true;
        }
    }
    if (ballsLength == 7) {
        if (chanceLength >= 1 && chanceLength <= 8) {
            return true;
        }
    }
    if (ballsLength == 8) {
        if (chanceLength >= 1 && chanceLength <= 3) {
            return true;
        }
    }
    if (ballsLength == 9) {
        if (chanceLength == 1) {
            return true;
        }
    }
    return false;
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
            result = "5 + n&deg; chance";
            break;
        case 2:
            result = "5";
            break;
        case 3:
            result = "4";
            break;
        case 4:
            result = "3";
            break;
        case 5:
            result = "2";
            break;
        case 6:
            result = "N&deg; chance";
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
    var arrDrawChance = simulationDetails.drawChance;
    var arrUnumbers = simulationDetails.uNumbers;
    var arrUChance = simulationDetails.uChance;
    var arrCountGoodBalls = simulationDetails.goodBalls;
    var arrCountGoodChance = simulationDetails.goodChance;

    var $table = $('<table>');
    var $thead = $('<thead>');
    var $tbody = $('<tbody>');
    var $tr, $td, $th;

    /** building thead **/
    $tr = $('<tr>');
    var $th1 = $('<th>').html('Tirage');
    var $th2 = $('<th>').html('Tirage N&deg; chance');
    var $th3 = $('<th>').html('Vos numéros');
    var $th4 = $('<th>').html('Vos N&deg; chance');
    var $th5 = $('<th>').html('Bons numéros');
    var $th6 = $('<th>').html('Bons N&deg; chance');

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
        var drawChanceToParse = arrDrawChance[i];
        var uNumbersToParse = arrUnumbers[i];
        var uChanceToParse = arrUChance[i];
        var goodBallsToParse = arrCountGoodBalls[i];
        var goodChanceToParse = arrCountGoodChance[i];


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

        /** parse draw Chance **/
        $.each(drawChanceToParse, function (k, v) {
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


        /** parse uChance **/
        $.each(uChanceToParse, function (k, v) {
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


        /** parse goodChance **/
        $.each(goodChanceToParse, function (k, v) {
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

/** convert Chance value 51 will be 1, 52 will be 2, . . . **/
function convertChanceValue(num) {
    switch (parseInt(num)) {

        case 50:
            num = 1;
            break;
        case 51:
            num = 2;
            break;
        case 52:
            num = 3;
            break;
        case 53:
            num = 4;
            break;
        case 54:
            num = 5;
            break;
        case 55:
            num = 6;
            break;
        case 56:
            num = 7;
            break;
        case 57:
            num = 8;
            break;
        case 58:
            num = 9;
            break;
        case 59:
            num = 10;
            break;
        case 60:
            num = 11;
            break;
    }
    return num;
}


/**
 * Replace Chance value ex 51 will be 1, 52 will be 2
 */
function replaceChanceValue() {
    var $labelsCollect = $('label.btn');

    $labelsCollect.each(function (k) {
        /* balls or Chance num */
        var num = $(this).html();
        if ($(this).html() >= 51 && $(this).html() <= 61) {
            num = convertChanceValue(num);
            $(this).html(num);
        }
    })
}

$(function () {
    //replaceChanceValue();
    /** form submit prevent default (it uses ajax to send data) **/
    $('form').on({
        submit: function () {
            return false;
        }
    });
    /** using http://www.bootstraptoggle.com/ **/
    var countBalls = 0; // how many balls are selected by user (min 6, max 10)
    var countChance = 0;


    var minBalls = 5; // user must select min 6 balls
    var maxBalls = 10; // user must select max 10 balls

    var minChance = 2;
    var maxChance = 11;

    var $allBalls = $('.ballsCheckBox'); // collection of Lotto balls
    var $allChance = $('.chanceCheckBox');

    var selectedBalls = []; // value of user's selected balls ex:[4, 17, 22, 29, 36, 45]
    var selectedChance = [];

    var countGames;

    /** balls config and style  **/
    $(':checkbox').each(function (k, v) {
        k = convertChanceValue(k + 1);
        $(this).bootstrapToggle({
            on: (k),
            off: (k)
        })
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
                    window.console.log("selectedChance.length = " + selectedChance.length);

                     /** testing disable balls **/
                    var test = mustDisableBalls(selectedBalls.length, selectedChance.length);
                    window.console.log(test);

                    if (mustDisableBalls(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allBalls);
                        window.console.log("oui1A");

                    } else {
                        enableDisabled($allBalls);
                        window.console.log("eeeee");
                    }
                    if (mustDisableChance(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allChance);
                        window.console.log("oui1A");

                    } else {
                        enableDisabled($allChance);
                    }

                    if (enableSubmit(selectedBalls.length, selectedChance.length)) {
                        window.console.log("enable sumbit 2 !");
                        $("#form_Simuler").removeAttr('disabled');
                    } else {
                        $("#form_Simuler").attr('disabled', true);
                    }

                } else {
                                        //if ball not present in selectedBalls array
                    $(this).attr('checked', true);
                    selectedBalls.push(parseInt(ball));
                    countBalls++;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedChance.length = " + selectedChance.length);

                    /** testing disable balls **/
                    var test = mustDisableBalls(selectedBalls.length, selectedChance.length);
                    window.console.log(test);
                    
                    if (mustDisableBalls(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allBalls);
                        window.console.log("oui1");

                    } else {
                        enableDisabled($allBalls);
                        window.console.log('rrrr');
                    }

                    /** testing disable stars **/
                    if (mustDisableChance(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allChance);
                        window.console.log("oui2");
                    } else {
                        enableDisabled($allChance);
                        window.console.log('aaaa');
                    }

                    /** testing disable submit button **/
                    if (enableSubmit(selectedBalls.length, selectedChance.length)) {
                        window.console.log("bbbb");
                        $("#form_Simuler").removeAttr('disabled');
                    } else {
                        $("#form_Simuler").attr('disabled', true);
                    }
                }
            }
        })
    })

    /** retrieves user selected Chance **/
    $allChance.each(function (k, v) {
        $(this).on({
            change: function () {
                var chance = $(this).val();
                chance = convertChanceValue(chance);

                //if ball already present in selectedBalls then remove it from that array
                if ($.inArray(chance, selectedChance) != -1) {
                    $(this).attr('checked', false);
                    selectedChance.splice(selectedChance.indexOf(chance), 1);
                    countChance--;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedChance.length = " + selectedChance.length);

                                       /** testing disable balls **/
                    var test = mustDisableBalls(selectedBalls.length, selectedChance.length);
                    window.console.log(test);

                    /** testing disable balls **/
                    if (mustDisableBalls(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allBalls);
                        window.console.log("oui3");

                    } else {
                        enableDisabled($allBalls);
                    }

                    /** testing disable stars **/
                    if (mustDisableChance(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allChance);
                        window.console.log("oui4");
                    } else {
                        enableDisabled($allChance);
                    }

                    /** testing disable submit button **/
                    if (enableSubmit(selectedBalls.length, selectedChance.length)) {
                        window.console.log("oui5");
                        $("#form_Simuler").removeAttr('disabled');
                    } else {
                        $("#form_Simuler").attr('disabled', true);
                    }

                } else {
                    //if ball not present in selectedBalls array
                    $(this).attr('checked', true);
                    selectedChance.push(parseInt(chance));
                    countChance++;

                    window.console.log("selectedBalls.length = " + selectedBalls.length);
                    window.console.log("selectedChance.length = " + selectedChance.length);
                    
                    /** testing disable balls **/
                    var test = mustDisableBalls(selectedBalls.length, selectedChance.length);
                    window.console.log(test);

                    /** testing disable balls **/
                    if (mustDisableBalls(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allBalls);
                        window.console.log("oui6");

                    } else {
                        enableDisabled($allBalls);
                    }

                    /** testing disable stars **/
                    if (mustDisableChance(selectedBalls.length, selectedChance.length)) {
                        disableUnchecked($allChance);
                        window.console.log("oui7");
                    } else {
                        enableDisabled($allChance);
                    }

                    /** testing disable submit button **/
                    if (enableSubmit(selectedBalls.length, selectedChance.length)) {
                        window.console.log("oui8");
                        $("#form_Simuler").removeAttr('disabled');
                    } else {
                        $("#form_Simuler").attr('disabled', true);
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
            if (countBalls >= 5 && countBalls <= 10 && countChance >= 2) {
                window.console.log('ok usa !');
                window.console.log(countGames);
                window.console.log(selectedBalls);
                window.console.log(selectedChance);
                /** retrives countGames before ajax process **/
                countGames = $('#form_Nombre_de_tirages').val();
                sendUNumbers(selectedBalls, selectedChance, countGames);
            }
        }
    })

});