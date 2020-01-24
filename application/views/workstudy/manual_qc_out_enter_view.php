<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/23/2019-->
<!-- * Time: 9:05 AM-->
<!-- */-->

<style>

    .item{
        color: #6D214F;
        margin-left: 10px;
        font-weight: bold;
    }
</style>

<!-- Main content -->
<div class="content-wrapper">

  <!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="<?php echo base_url('Workstudy_con') ?>" class="breadcrumb-item">DayPlan-List</a>
                <span class="breadcrumb-item active">Manual Entering Qc Out</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<!-- /page header -->
<!-- Content area -->
<div class="content">

    <!-- Form inputs -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Manual Entering QC Out</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <!-- <?php print_r($teams)?> -->

        <div class="card-body">
            <form id="manual_qc_out_form">
                <div class="form-group row">
                    <label class="col-form-label col-md-1">Date :</label>
                    <div class="col-md-3">
                        <input type="text" name="enterdDate " id="enterdDate" class="datepick form-control validateForFindQty" required>
                    </div>
                    <label class="col-form-label col-md-1">Team :</label>
                    <div class="col-md-3">
                        <select id="team" name="team" class="form-control select" data-placeholder="Select a team">
                            <option></option>
                            <?php
                            if(!empty($teams)){
                                foreach($teams as $team){
                                    ?>
                                    <option value="<?php echo $team->teamId ?>"> <?php echo $team->team ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <span id="error" class="error"></span>
                    </div>

                    <label class="col-form-label col-md-1">Style :</label>
                    <div class="col-md-3">
                        <select id="style" name="style" class="form-control select-search"
                            data-placeholder="Select a Style">
                            <option></option>
                            <?php
                            if(!empty($style)){
                                foreach($style as $item){
                                    ?>
                                    <option value="<?php echo $item->styleNo ?>"> <?php echo $item->styleNo.' - '.$item->scNumber ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <span id="error" class="error"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-1">SMV :</label>
                    <div class="col-md-2">
                        <input type="number" name="smv" id="smv" class="form-control tocal" step="any" min="0" value=""
                            required="" autocomplete="off">
                    </div>
                    <div class="col-md-1"></div>
                    <label class="col-form-label col-md-1">Workers :</label>
                    <div class="col-md-2">
                        <input id="noOfWorkser" name="noOfWorkser" type="number" class="form-control tocal" step="any" min="0"
                            value="" required="" autocomplete="off">
                    </div>
                    <div class="col-md-1"></div>

                    <label class="col-form-label col-md-1">Hour :</label>
                    <div class="col-md-2">
                        <input type="number" name="hours" id="hours" class="form-control tocal" step="any" min="0" value=""
                            required="" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-1">Plan Qty :</label>
                    <div class="col-md-2">
                        <input type="number" name="plan_qty" id="plan_qty" class="form-control tocal" step="any" min="0" value=""
                            required="" autocomplete="off">
                    </div>
                    <div class="col-md-1"></div>
                    <label class="col-form-label col-md-1">Run Days :</label>
                    <div class="col-md-2">
                        <input id="runDays" name="runDays" type="number" class="form-control tocal" step="any" min="0"
                            value="" required="" autocomplete="off">
                    </div>
                    <div class="col-md-1"></div>
                    <label class="col-form-label col-md-1">Incentive Hour :</label>
                    <div class="col-md-2">
                        <input type="number" name="incenHours" id="incenHours" class="form-control tocal" step="any" min="0" value=""
                            required="" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-1">Forcast Effi :</label>
                    <div class="col-md-2">
                        <input type="number" name="forecEff" id="forecEff" class="form-control tocal" step="any" min="0" value="" required=""
                            autocomplete="off">
                    </div>
                    <div class="col-md-1"></div>
                    <label class="col-form-label col-md-1">Incentve Effi :</label>
                    <div class="col-md-2">
                        <input id="incenEffi" name="incenEffi" type="number" class="form-control tocal" step="any" min="0"
                            value="" required="" autocomplete="off">
                    </div>
                    <div class="col-md-6"></div>
                </div>
                
                <h6 class="row pb-2 pt-2">Find Check Out QTY</h6>
                <div class="form-group row">
                    <label class="col-form-label col-md-1">From :</label>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar5"></i></span>
                                </span>
                                <input id="fromDate" name="fromDate" type="text" class="form-control datepick validateForFindQty" value=""
                                    placeholder="Select a date &hellip;" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-alarm"></i></span>
                                </span>
                                <input id="fromTime" name="fromTime" type="text"  class="form-control timepicker validateForFindQty" value="" placeholder="select Time" required>
                            </div> 
                        </div>
                    </div>
                    <label class="col-form-label col-md-1">To :</label>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar5"></i></span>
                                </span>
                                <input id="toDate" name="toDate" type="text" class="form-control datepick validateForFindQty" value=""
                                    placeholder="Select a date &hellip;" required>
                            </div>
                            <span class="error" id="error"><?php echo form_error('fromDate'); ?></span>
                        </div>
                        <div class="row">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-alarm"></i></span>
                                </span>
                                <input id="toTime" name="toTime" type="text"  class="form-control timepicker validateForFindQty" value="" placeholder="select Time" required>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input type="button" name="findQty" id="findQty" class="btn btn-primary" value="Find" >
                    </div>
                    <div class="col-sm-3 row">
                        <label class="col-form-label col-md-4">Pass Qty :</label>           
                        <div class="col-md-8">
                            <input type="number" name="passQty" id="passQty" class="form-control tocal" step="any" min="0" value=""
                               autocomplete="off" readonly>
                        </div>
                        <label class="col-form-label col-md-4">Defect Qty :</label>
                        <div class="col-md-8">
                            <input type="number" name="defectQty" id="defectQty" class="form-control tocal" step="any" min="0" value=""
                                autocomplete="off" readonly>
                        </div>
                    </div>
                    
                </div>

                <div class="row text-right">
                    <div class="col-md-12">
                        <input type="button" id="calbtn" class="btn btn-success " value="calculate">  
                    </div>
                </div>
            </form>
 <!-- /form inputs -->
            <hr>

            <div id="result">
                
            </div>


        </div>
       
    </div>
</div>
      <!-- /content area -->

<script>
    $('.datepick').pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'yyyy-mm-dd',
        max: true,
    });
    $('.timepicker').timepicker({
        timeFormat: 'H:mm',
        interval: 15,
        minTime: '00',
        maxTime: '23:55pm',
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });

    // Select2 select
    let data;

    $('#findQty').click(function() {
       let team =  $('#team').val();
       let style  = $('#style').val();
       let enterdDate = $('#enterdDate').val();
       let fromDate = $('#fromDate').val();
       let fromTime = $('#fromTime').val();
       let toDate = $('#toDate').val();
       let toTime = $('#toTime').val();


       if(team==''){
        $('#team').siblings('#error').text('This field is required');
        return false;
       }else{
        $('#team').siblings('#error').text('');
       }

       if(style==''){
        $('#style').siblings('#error').text('This field is required');
           return false;
       }else{
        $('#style').siblings('#error').text('');
       }

       if($(".validateForFindQty").valid()){
        let dataForGetQty=  {team:team,
                style:style,
                enterdDate:enterdDate,
                fromDate:fromDate,
                fromTime:fromTime,
                toDate:toDate,
                toTime:toTime,  
            };

        loaderOn();
        $.ajax({
            data: dataForGetQty,
            type:'POST',
            url: '<?php echo base_url("ManualQcOutEnter/getPassDefectQty") ?>'
        }).done(function(response) {

            if(response!=''){
                var json_data = JSON.parse(response);

                $('#passQty').val(json_data[0]['passQty']);
                $('#defectQty').val(json_data[0]['defectQty']);
            }
            loaderOff();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
            loaderOff();
        });


        
       }
    });


    $('#calbtn').click(function() {
        if($(".validateForFindQty").valid() && $(".tocal").valid() ){

            data = {
                team:$('#team').val(),
                style:$('#style').val(),
                smv:$('#smv').val(),
                workrs:$('#noOfWorkser').val(),
                hour: $('#hours').val(),
                planQty: $('#plan_qty').val(),
                runday: $('#runDays').val(),
                incenHour: $('#incenHours').val(),
                forcastEffi: $('#forecEff').val(),
                incentiveEffi: $('#incenEffi').val(),
                passQty: $('#passQty').val(),
                defectQty: $('#defectQty').val(),
                enterdDate:$('#enterdDate').val(),
            };

       loaderOn();

        let html='';
        $.ajax({
            data:data,
            type:'POST',
            url: '<?php echo base_url("ManualQcOutEnter/doCalculate") ?>'
        }).done(function(response) {

            if(response!=''){
            var json_data = JSON.parse(response);
            

            data['producedMin'] = json_data['producedMin'];
            data['usedMin'] = json_data['usedMin'];
            data['effi'] = json_data['effi'];
            data['qrLvl'] = json_data['qrLvl'];
            data['incentive'] = json_data['incentive'];

             html += '<div class="card">';
                html += '<div class="card-body p-4">';
                    html +='<div class="row">';
                        html +='<div class="col-md-6 ">';
                        html +='<h4 class="">Effected Other Day Plan</h4>';
                            html += '<h5>Pass Qty : <span class="item">'+json_data['old']['qty']+'</span> </h5>'
                            html += '<h5>Prpoduced Min : <span  class="item">'+json_data['old']['producedMin']+'</span> </h5>'
                            html += '<h5>Used Min : <span  class="item">'+json_data['old']['usedMin']+'</span> </h5>'
                            html += '<h5>Efficency : <span  class="item">'+json_data['old']['effi']+'%</span> </h5>'
                            html += '<h5>QR Level : <span  class="item">'+json_data['old']['qrLvl']+'%</span> </h5>'
                            html += '<h5>Incentive : <span  class="item">'+json_data['old']['incentive']+'</span> </h5>'
                        html += '</div>'
                        html +='<div class="col-md-6 text-right">';
                        html +='<h4>New Data</h4>';
                            html += '<h5>Pass Qty : <span  class="item">'+json_data['new']['qty']+'</span> </h5>'
                            html += '<h5>Prpoduced Min : <span  class="item">'+json_data['new']['producedMin']+'</span> </h5>'
                            html += '<h5>Used Min : <span  class="item">'+json_data['new']['usedMin']+'</span> </h5>'
                            html += '<h5>Efficency : <span  class="item">'+json_data['new']['effi']+'%</span> </h5>'
                            html += '<h5>QR Level : <span  class="item">'+json_data['new']['qrLvl']+'%</span> </h5>'
                            html += '<h5>Incentive : <span  class="item">'+json_data['new']['incentive']+'</span> </h5>'
                        html += '</div>'
                        html += '</div>'
                    html += '</div>'
                html +='<div class="card-footer text-right">';
                    html +='<input type="button" value="Save" class="btn btn-primary" onclick="setData()">';
                html+='</div>'
             html += '</div>'

            }

            $('#result').html(html);

        }).fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });


        loaderOff();
            


        }


    });


/* handle form validation */

    function setData(){
      
        console.log(data);
        
        if(team !='' && style!='' && enterdDate !=''){
            $.ajax({
            data: data,
            type:'POST',
            url: '<?php echo base_url("ManualQcOutEnter/setData") ?>'
        }).done(function(data) {

        }).fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });

        }
    }

</script>

