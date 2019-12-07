$(document).ready(function() {
    $(".select").select2({
        dropdownParent: $("#style-config-modal"),
        width: 'resolve',
        minimumInputLength: 0
    });
    select2NonSearch();
    disableBtn();
    getStyle();
});


Notiflix.Notify.Init({
    width: '400px',
    fontSize: '20px',
    timeout: 4000,
    messageMaxLength: 200,
});

function loaderOn() {
    $("body").prepend('<div class="loading"></div>');
}

function loaderOff() {
    $(document).ready(function() {
        $(".loading").remove();
    });
}

function select2NonSearch() {
    $(".select-nonsearch").select2({
        minimumResultsForSearch: -1
    });
}

function styleConfigStart() {
    var selectedStyle = $('#hid_style').val();
    if (selectedStyle != "") {
        getStyle();
        getDelv();

    }

}


function getStyle() {

    var selectedStyle = $('#hid_style').val();

    $.ajax({
        data: {},
        type: 'post',
        url: $('#getStyleLink').val(),
    }).done(function(data) {
        var json_val = JSON.parse(data);
        var html = "<option></option>";
        for (var i = 0; i < json_val.length; i++) {
            if (selectedStyle != "" && json_val[i]['style'] == selectedStyle) {
                html += "<option value='" + json_val[i]['style'] + "' selected>" + json_val[i]['style'] + "</option>";
            } else {
                html += "<option value='" + json_val[i]['style'] + "' >" + json_val[i]['style'] + "</option>";
            }

        }
        $('#style').empty().append(html);
        $('#style').removeAttr('disabled', 'disabled');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        Notiflix.Report.Failure('Connection issue', '"Please check the your wifi connection"', 'Noted')
    });
}


function getDelv() {
    var style = $('#style').val();
    $('#log').empty();
    if (style == '') {
        return;
    }
    $('#delivery').empty();
    $('#color').empty();
    $('.size-panal').empty();
    disableBtn();

    var selectedDel = $('#hid_del').val();
    $.ajax({
        data: {
            'style': style
        },
        type: 'post',
        url: $('#getDelvLink').val(),
    }).done(function(data) {
        var json_val = JSON.parse(data);
        var html = "<option></option>";
        for (var i = 0; i < json_val.length; i++) {
            if (selectedDel != "" && json_val[i]['delv'] == selectedDel) {
                html += "<option value='" + json_val[i]['delv'] + "' selected>" + json_val[i]['delv'] + "</option>";
                getColor();
            } else {
                html += "<option value='" + json_val[i]['delv'] + "'>" + json_val[i]['delv'] + "</option>";
            }
        }
        if (json_val.length < 10) {
            $('#delivery').removeClass('select');
            $('#delivery').addClass('select-nonsearch');
            select2NonSearch();
        }
        $('#scNumber').val(json_val[0]['scNumber'])
        $('#delivery').empty().append(html);
        $('#delivery').removeAttr('disabled', 'disabled');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        Notiflix.Report.Failure('Connection issue', '"Please check the your wifi connection"', 'Noted')
    });



}

function getColor() {
    var style = $('#style').val();
    var selectedColor = $('#hid_color').val();
    if ($('#delivery').val() == "" || $('#delivery').val() == undefined) {
        var delivery = $('#hid_del').val();
    } else {
        var delivery = $('#delivery').val();
    }

    if (style == "" || delivery == "") {
        return;
    }
    $('#color').empty();
    $('.size-panal').empty();
    disableBtn();


    $.ajax({
        data: {
            'style': style,
            'delivery': delivery,
        },
        type: 'post',
        url: $('#getColorLink').val(),
    }).done(function(data) {
        var json_val = JSON.parse(data);
        var html = "<option></option>";
        for (var i = 0; i < json_val.length; i++) {
            if (selectedColor != "" && json_val[i]['color'] == selectedColor) {
                html += "<option value='" + json_val[i]['color'] + "' selected>" + json_val[i]['color'] + "</option>";
                getSize();
            } else {
                html += "<option value='" + json_val[i]['color'] + "'>" + json_val[i]['color'] + "</option>";
            }
        }
        $('#color').empty().append(html);
        $('#color').removeAttr('disabled', 'disabled');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        Notiflix.Report.Failure('Connection issue', '"Please check the your wifi connection"', 'Noted')
    });
}

function configStyle() {
    var style = $('#style').val();
    var delivery = $('#delivery').val();
    var color = $('#color').val();
    disableBtn();
    sizeBoxClear();

    if (styleConfigedValidate(style, delivery, color)) {
        $('#item-style').text(style);
        $('#item-delivery').text(delivery);
        $('#item-color').text(color);
        $('#style-config-modal').modal('hide');

        $('#hid_style').val(style);
        $('#hid_del').val(delivery);
        $('#hid_color').val(color);

        getCountFormLog(style, delivery, color);

    } else {
        return;
    }
}

function getSize() {
    loaderOn();
    var style = $('#style').val();

    if ($('#color').val() == "" || $('#color').val() == undefined) {
        var color = $('#hid_color').val();
    } else {
        var color = $('#color').val();

    }

    $('.size-panal').empty();
    $.ajax({
        type: 'post',
        url: $('#getSizeLink').val(),
        data: {
            'style': style,
            'color': color
        }
    }).done(function(data) {
        var json_val = JSON.parse(data);
        var html = '';
        for (var i = 0; i < json_val.length; i++) {
            html += "<button class='size-box' onclick='clickedSizeBox(this)'>";
            html += "<span class='size-name'>" + json_val[i]['size'] + "</span>";
            html += "</button>";
        }
        if (json_val.length > 8) {
            $('.size-panal').css({ 'justify-content': 'unset' });
        } else {
            $('.size-panal').css({ 'justify-content': 'center' });
        }
        $('.size-panal').append(html);

    }).fail(function(jqXHR, textStatus, errorThrown) {
        Notiflix.Report.Failure('Connection issue', '"Please check the your wifi connection"', 'Noted')
    });

    loaderOff();

}

function getCountFormLog(style) {
    loaderOn();
    $.ajax({
        data: {
            'style': style
        },
        type: 'post',
        url: $('#getCountFromLogUrl').val(),
    }).done(function(data) {
        if (data != '') {
            var json_val = JSON.parse(data);
            $('#btn-pass').find('.count').text(json_val[0]['passQty']);
            $('#btn-defect').find('.count').text(json_val[0]['defectQty']);
            $('#btn-remake').find('.count').text(json_val[0]['remakeQty']);
        }
        loaderOff();

    }).fail(function(jqXHR, textStatus, errorThrown) {
        loaderOff();
        Notiflix.Report.Failure('Connection issue', '"Please check the your wifi connection"', 'Noted')
        clearSelect();
    });

}

function clearSelect() {
    $('#style').val('').trigger('change');
    $('#delivery').empty();
    $('#color').empty();

    $('#item-style').text('');
    $('#item-delivery').text('');
    $('#item-color').text('');
    $('.tyle-config-error').text('');
    $('.size-panal').empty();


    $('#hid_style').val('');
    $('#hid_del').val('');
    $('#hid_color').val('');

    sizeBoxClear();
    defectReasonClear();
    clearCount();

}

function styleConfigedValidate(style, delivery, color) {

    if (style == '') {
        $('#style-error').text("Please select a Style");
        return false;
    } else {
        $('#style-error').text("");
    }

    if (delivery == '' || delivery == undefined) {
        $('#delivery-error').text("Please select a Delivery");
        return false;
    } else {
        $('#delivery-error').text("");
    }

    if (color == '' || color == undefined) {
        $('#color-error').text("Please select a Color");
        return false;
    } else {
        $('#color-error').text("");
    }

    return true;
}

function clickedSizeBox(box) {
    sizeBoxClear();
    $(box).addClass('size-box-clicked');
    $('#selectSize').val($(box).find('.size-name').text());
    allowBtn();
}

function sizeBoxClear() {
    $('.size-box').each(function() {
        $(this).removeClass('size-box-clicked');
    });
    $('#selectSize').val('');
}

function selectDefectReason(reason) {
    defectReasonClear();
    $(reason).addClass('defect-reason-clicked');
    $('#selectDefectReason').val($(reason).data('defectid'));
}

function defectReasonClear() {
    $('.defect-reason').each(function() {
        $(this).removeClass('defect-reason-clicked');
    });
    $('#selectDefectReason').val('');
}

function disableBtn() {
    $('.btn-box').attr('Disabled', 'Disabled');
    $('.btn-box').css('opacity', '0.2');
    $('.btn-box').find('.count').text('0');

}

function allowBtn() {
    $('.btn-box').removeAttr('Disabled', 'Disabled');
    $('.btn-box').css('opacity', '1');
}

//////// Pressing Buttons ////////////

function btnPress(btn) {
    var validate = true;
    var btnType = $(btn).data('btn');

    if (btnType == 'pass') {
        $(btn).find('.count').text(parseInt($(btn).find('.count').text()) + 1);
    }

    if (btnType == 'remake') {
        var defect = parseInt($('#btn-defect').find('.count').text());
        if (defect > 0) {
            defect = defect - 1;
            $('#btn-pass').find('.count').text(parseInt($('#btn-pass').find('.count').text()) + 1);
            $('#btn-defect').find('.count').text(parseInt($('#btn-defect').find('.count').text()) - 1);
            $('#btn-remake').find('.count').text(parseInt($(btn).find('.count').text()) + 1);
        } else {
            validate = false;
            Notiflix.Report.Failure('No Defect to Remake', '"Thare are no any defect to remake"', 'Noted')
        }
    }

    if (btnType == 'defect') {
        // alert(btnType);
        var defectReason = $('#selectDefectReason').val();
        if (defectReason != '') {
            $('#btn-defect').find('.count').text(parseInt($('#btn-defect').find('.count').text()) + 1);

            $('#defect-reasons-model').modal('hide');
        } else {
            validate = false;
            Notiflix.Notify.Warning("Please Select a Defect Reason");
            return;
        }
    }

    if (validate) {
        saveBtnPress(btn, btnType);
    }
}

function saveBtnPress(btn, btnType) {
    var style = $('#style').val();
    var scNumber = $('#scNumber').val();
    var delivery = $('#delivery').val();
    var color = $('#color').val();
    var size = $('#selectSize').val();

    var logId = Math.floor(Math.random() * 100001);

    var html = "<p id='log" + logId + "'><span>" + btnType + "</span> is progress....</p>";
    $('#log').prepend(html);

    if (btnType == "defect") {
        var defectReason = $('#selectDefectReason').val();
        var data = [{
            'style': style,
            'scNumber': scNumber,
            'delivery': delivery,
            'color': color,
            'size': size,
            'btn': btnType,
            'defectReason': defectReason
        }];
        defectReasonClear();
    } else {
        var data = [{
            'style': style,
            'scNumber': scNumber,
            'delivery': delivery,
            'color': color,
            'size': size,
            'btn': btnType
        }];
    }

    $.ajax({
        data: { 'data': data },
        type: 'GET',
        url: $('#saveBtnPressUrl').val(),
    }).done(function(data) {
        if (data === "needInput") {
            Notiflix.Report.Failure('No Input', '"You are going to exceed the input Qty"', 'Noted')
            if (btnType == "remake") {
                $('#btn-pass').find('.count').text(parseInt($('#btn-pass').find('.count').text()) - 1);
                $(btn).find('.count').text(parseInt($(btn).find('.count').text()) - 1);
            } else if (btnType == "defect") {
                $('#btn-defect').find('.count').text(parseInt($('#btn-defect').find('.count').text()) - 1);
            } else {
                $(btn).find('.count').text(parseInt($(btn).find('.count').text()) - 1);
            }

            html = "Need Input....";
            $('#log' + logId + '').addClass('warning');
            $('#log' + logId + '').html(html);

        } else if (data === "pass" || data === "defect" || data === "remake") {
            html = "<span>" + btnType + "</span> is successfully saved.";
            $('#log' + logId + '').addClass('success');
            $('#log' + logId + '').html(html);
        } else {
            Notiflix.Notify.Warning("Something went wrong!.Please get IT support");
        }

    }).fail(function(jqXHR, textStatus, errorThrown) {
        Notiflix.Report.Failure('Connection issue', '"Please check the your wifi connection"', 'Noted')
        if (btnType == "remake") {
            $('#btn-pass').find('.count').text(parseInt($('#btn-pass').find('.count').text()) - 1);
            $(btn).find('.count').text(parseInt($(btn).find('.count').text()) - 1);
            $('#btn-defect').find('.count').text(parseInt($('#btn-defect').find('.count').text()) + 1);
        } else if (btnType == "defect") {
            $('#btn-defect').find('.count').text(parseInt($('#btn-defect').find('.count').text()) - 1);
        } else {
            $(btn).find('.count').text(parseInt($(btn).find('.count').text()) - 1);
        }
        html = "<span>" + btnType + "</span> is NOT saved.";
        $('#log' + logId + '').addClass('error');
        $('#log' + logId + '').html(html);
        $('#log' + logId + '').focus();

    });

}

function getFrequentDefectReason() {
    var html = "";
    var style = $('#style').val();
    $.ajax({
        data: { 'style': style },
        type: 'GET',
        url: $('#getFrequentDefectReasonUrl').val(),
    }).done(function(data) {
        if (data != 'no result') {
            var json_val = JSON.parse(data);
            var html = '';
            for (var i = 0; i < json_val.length; i++) {
                html += "<div class='col-sm-6'>";
                html += "<div class='defect-reason' data-defectid = " + json_val[i]['id'] + " onclick='selectDefectReason(this)'>";
                html += "<span>" + json_val[i]['rejectReason'] + "</span>";
                html += "</div>";
                html += "</div>";
            }
            $('#frequentReason').empty().append(html);
            $('#frequentReason').focus();
        }

    }).fail(function(jqXHR, textStatus, errorThrown) {

    });
}

function clearCount() {
    $('#btn-pass').find('.count').text('0');
    $('#btn-defect').find('.count').text('0');
    $('#btn-remake').find('.count').text('0');
}