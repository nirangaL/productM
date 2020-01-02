window.setInterval(function() {
    timeCountDown();
}, 1000);



$(document).ready(function() {
    $('#canvas').delay((60000 * 1.5)).fadeOut();
    // $('body').delay(500000).fadeIn();
    getTeamData();
    // $('body').flurry({
    //     character: "❆",
    //     // character: "•",
    //     color: "white",
    //     frequency: 100,
    //     speed: 10000,
    //     small: 4,
    //     large: 20,
    //     wind: 40,
    //     windVariance: 10,
    //     rotation: 90,
    //     rotationVariance: 180,
    //     startOpacity: 1,
    //     endOpacity: 0,
    //     opacityEasing: "cubic-bezier(1,.3,.6,.74)",
    //     blur: true,
    //     overflow: "hidden",
    //     zIndex: 9999
    // });

});

window.setInterval(function() {
    getTeamData();
}, 3000);

window.setInterval(function() {
    clipRotate();
}, 10000);


// var myVar = setInterval(clipRotate, 1000);

function clipRotate() {
    // alert('ffff');
    $('.clip').toggleClass("is-flipped");
}



function getTeamData() {
    var getTeamDataUrl = $('#getTeamDataUrl').val();
    $.ajax({
        url: getTeamDataUrl, //This is the current doc
        type: "POST",
        data: ({}),
        success: function(data) {
            var json_data = JSON.parse(data);
            if (json_data.length != 0) {
                var short_exceed_qty = 0;
                $('#tb-style').text(json_data['teamData']['style']);
                $('#tb-run-days').text(json_data['teamData']['styleRunDays']);
                $('#tb-worksers').text(json_data['teamData']['noOfwokers']);
                ///// team up Down ///////
                var planQtyHr = parseInt(json_data['teamData']['needOutQtyHr']);
                var actOurQtyHr = parseInt(json_data['teamData']['teamHrsOutQty']);
                if (!isNaN(planQtyHr) && !isNaN(actOurQtyHr)) {
                    if (planQtyHr >= actOurQtyHr) {
                        short_exceed_qty = planQtyHr - actOurQtyHr;
                        $('#th-short-exceed').text('Short.QTY/H');
                        $('#status').html('<i class="icon-arrow-down16 mr-3 icon-2x down-icon"></i>');
                    } else if (planQtyHr < actOurQtyHr) {
                        short_exceed_qty = actOurQtyHr - planQtyHr;
                        $('#th-short-exceed').text('Exceed.QTY/H');
                        $('#status').html('<i class="icon-arrow-up16 mr-3 icon-2x up-icon"></i>');
                    } else {
                        $('#th-short-exceed').text('Short.QTY/H');
                        $('#status').html('-');
                    }

                    $('#tb-short-exceed-qty').text(short_exceed_qty);
                }

                if (!isNaN(planQtyHr)) {
                    $('#tb-plan-qty-hr').text(planQtyHr);
                }

                if (!isNaN(actOurQtyHr)) {
                    $('#tb-out-qty-hr').text(actOurQtyHr);
                }



                $('#tile-plan-qty').text(json_data['teamData']['dayPlanQty']);
                $('#tile-out-qty').text(json_data['teamData']['lineOutQty']);
                $('#tile-hour').text(json_data['teamData']['currentHr']);
                $('#tile-last-hour-qty').text(json_data['teamData']['preHourPassQty']);
                $('#tile-target-effi').html(json_data['teamData']['ForEff'] + '<span class="prasentage">%</span>');
                $('#tile-actual-effi').html(json_data['teamData']['actEff'] + '<span class="prasentage">%</span>');
                $('#tile-rework-qty').text(json_data['teamData']['rejectQty']);
                $('#tile-total-rework-qty').text(json_data['teamData']['allDefectQty']);
                $('#tile-remake-qty').text(json_data['teamData']['remakeQty']);

                var needQrLevel = json_data['teamData']['needQrLvl'];
                var actualQrLevel = json_data['teamData']['actualQrLevel'];

                if (actualQrLevel < needQrLevel) {
                    $('#tile-qr-level').removeClass('f-green');
                    $('#tile-qr-level').addClass('f-red');
                } else {
                    $('#tile-qr-level').removeClass('f-red');
                    $('#tile-qr-level').addClass('f-green');
                }

                $('#tile-qr-level').html(actualQrLevel + '<span class="prasentage">%</span>');
                $('#tile-incentive').text(json_data['teamData']['incentive']);
                // $('#tile-incentive').text('265');

                $('#timeForTimeCountDown').val(json_data['teamData']['timeForTimeCountDown']);
                $('#startHour').val(json_data['teamData']['hourStartTime']);
            }


        }
    });
}

function timeCountDown() {

    var hour = $('#tile-hour').text();
    var preHour = $('#countDownHour').val();

    if (preHour == hour) {

        var startTime = 'Jan 5,1960 ' + $('#startHour').val();
        var endTime = $('#timeForTimeCountDown').val();

        // alert(endTime);

        // Get todays date and time
        // var start = new Date(startTime).getTime();
        var end = new Date(endTime).getTime();
        // var end = new Date('Oct 2, 2019 17:50:00').getTime();

        // alert(end);

        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = end - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        // document.getElementById("demo").innerHTML = days + "d " + hours + "h "+ minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            hours = 0;
            minutes = 0;
            seconds = 0;
        }


        if (hours < 10) {
            hours = '0' + hours;
        }
        if (minutes < 10) {
            minutes = '0' + minutes;
        }
        if (seconds < 10) {
            seconds = '0' + seconds;
        }

        if (isNaN(hours) && isNaN(minutes) && isNaN(seconds)) {
            hours = '00';
            minutes = '00';
            seconds = '00'
        }

        var timeCountDown = hours + ":" + minutes + ":" + seconds;
        $('#tile-time-count').text(timeCountDown);

    } else {
        $('#countDownHour').val(hour);
    }

}