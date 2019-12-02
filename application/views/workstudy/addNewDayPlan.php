<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/23/2019-->
<!-- * Time: 9:05 AM-->
<!-- */-->


<!-- Main content -->
<div class="content-wrapper">

  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
      <div class="page-title d-flex">
        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Day-Plan</span> - Add
        </h4>
        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
      </div>

      <div class="header-elements d-none">
        <div class="d-flex justify-content-center">
          <a href="#" class="btn btn-link btn-float text-default"><i
            class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
            <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i>
              <span>Invoices</span></a>
              <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i>
                <span>Schedule</span></a>
              </div>
            </div>

            <!--            --><?php //print_r($userGroups);?>

          </div>

          <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
              <div class="breadcrumb">
                <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="<?php echo base_url('Workstudy_con') ?>" class="breadcrumb-item">DayPlan-List</a>
                <span class="breadcrumb-item active">Add Day Plan</span>
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
              <h5 class="card-title">Day Plan Form</h5>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                </div>
              </div>
            </div>

            <div class="card-body">
              <form action="<?php echo base_url('Workstudy_con/saveDayPlan') ?>" method="post">
                <fieldset class="mb-3">
                  <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                  <div class="form-group row">
                    <label class="col-form-label col-md-1">Team :</label>
                    <div class="col-md-3">
                      <select id="line" name="line" class="form-control select-search"
                      onchange="checkLineIsRunning(this);resetTextField('team');" data-fouc required>
                      <option value="">--- Select Line ----</option>
                      <?php foreach ($prdocLine as $row) {
                        ?>
                        <option value="<?php echo $row->line_id; ?>" <?php echo set_select('line', $row->line_id); ?> > <?php echo $row->line; ?> </option>
                        <?php
                      } ?>
                    </select>
                    <span class="error" id="error" ><?php echo form_error('line'); ?></span>
                    <span class="error" id="errorLineRunnig" style="color:orange;"></span>
                  </div>
                  <label class="col-form-label col-md-1">Type :</label>
                  <div class="col-md-3">
                    <select id="dayPlanType" name="dayPlanType" class="form-control select" data-placeholder="Select a Day Plan type"
                    onchange="asDayPlanType();" data-fouc required>

                  </select>
                  <span class="error" id="error"><?php echo form_error('dayPlanType'); ?></span>

                </div>
                  <label class="col-form-label col-md-1">Time Template :</label>
                  <div class="col-md-3">
                    <select id="timeTempl" name="timeTempl" class="form-control select-search" data-fouc required>
                      <option value="">--- Select Time Template ----</option>
                      <?php foreach ($timeTempl as $row) {
                        ?>
                        <option value="<?php echo $row->id; ?>" <?php echo set_select('line', $row->id); ?> > <?php echo $row->templateCode.' - '. $row->templateName; ?> </option>
                        <?php
                      } ?>
                    </select>
                    <span class="error" id="error"><?php echo form_error('timeTempl'); ?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-form-label col-md-1">Style :</label>
                  <div class="col-md-3">
                    <select id="style" name="style" class="form-control select-search"
                    onchange="getDelivery(this);getPlannedQty();getStyleRunDays();" data-fouc required>
                    <option value="">--- Select Style ----</option>
                    <?php foreach ($style as $row) {
                      ?>
                      <option value="<?php echo $row->styleNo; ?>" <?php echo set_select('style', $row->styleNo); ?> > <?php echo $row->styleNo . ' - ' . $row->scNumber; ?> </option>
                      <?php
                    } ?>
                  </select>
                  <span class="error" id="error"><?php echo form_error('style'); ?></span>
                </div>

                <label class="col-form-label col-md-1">Delivery :</label>
                <div class="col-md-3">
                  <select id="delivery" name="delivery" class="form-control select-search"
                  onchange="getOrderQty(this);getPlannedQty();" data-fouc
                  required>
                  <option value="">--- Select Delivery ----</option>
                </select>
                <span class="error" id="error"><?php echo form_error('delivery'); ?></span>
              </div>

              <label class="col-form-label col-md-1">Order QTY :</label>
              <div class="col-md-3">
                <input id="orderQty" name="orderQty" type="text" class="form-control"
                value="<?php echo set_value('orderQty'); ?>" readonly>
                <span class="error" id="error"><?php echo form_error('orderQty'); ?></span>
              </div>

            </div>


            <div class="form-group row">
              <label class="col-form-label col-md-1">Plan % :</label>
              <div class="col-md-2">
                <input id="planPer" name="planPer" type="text" class="form-control"
                value="<?php echo set_value('planPer'); ?>" min="0" onkeyup="getPlannerQty();"
                required>
                <span class="error" id="error"><?php echo form_error('planPer'); ?></span>
              </div>

              <div class="col-md-1"></div>
              <label class="col-form-label col-md-1">Planner QTY :</label>
              <div class="col-md-2">
                <input id="plannerQty" name="plannerQty" type="number" class="form-control"
                value="<?php echo set_value('plannerQty'); ?>" min="0" readonly required>
                <span class="error" id="error"><?php echo form_error('plannerQty'); ?></span>
              </div>

              <div class="col-md-1"></div>
              <label class="col-form-label col-md-1">Hrs:</label>
              <div class="col-md-2">
                <input id="workingHrs" name="workingHrs" type="text" class="form-control"
                value="<?php echo set_value('workingHrs'); ?>" min="0" max="24"
                onkeyup="getPlannedQty();setInceHour();" required>
                <span class="error" id="error"><?php echo form_error('workingHrs'); ?></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-md-1">SMV :</label>
              <div class="col-md-2">
                <input id="smv" name="smv" type="text" class="form-control"
                value="<?php echo set_value('smv'); ?>" min="0"
                onblur="getPlannedQty();getStyleRunDays();" required>
                <span class="error" id="error"><?php echo form_error('smv'); ?></span>
              </div>
              <div class="col-md-1"></div>

              <label class="col-form-label col-md-1">Workers:</label>
              <div class="col-md-2">
                <input id="noOfWorkser" name="noOfWorkser" type="number" step="any" min="0" class="form-control"
                value="<?php echo set_value('noOfWorkser'); ?>" onkeyup="getPlannedQty();"
                required min="0">
                <span class="error" id="error"><?php echo form_error('noOfWorkser'); ?></span>
              </div>
              <div class="col-md-1"></div>

              <label class="col-form-label col-md-1">Day Plan Qty :</label>
              <div class="col-md-2">
                <input id="planQty" name="planQty" type="number" class="form-control"
                value="<?php echo set_value('planQty'); ?>" min="0" required>
                <span class="error" id="error"><?php echo form_error('planQty'); ?></span>
              </div>

            </div>

            <div class="form-group row">
              <label class="col-form-label col-md-1">Inc.Hour :</label>
              <div class="col-md-1">
                <input id="ince_hour" name="ince_hour" type="text" class="form-control"
                value="<?php echo set_value('ince_hour'); ?>" min="0" max="24" required>
                <span class="error" id="error"><?php echo form_error('ince_hour'); ?></span>
              </div>
              <div class="col-md-2"></div>
              <label class="col-form-label col-md-1">Inc.Efficiency :</label>
              <div class="col-md-2">
                <input id="efficiency" name="efficiency" type="number" class="form-control"
                value="<?php echo set_value('efficiency'); ?>" min="0" required>
                <span class="error" id="error"><?php echo form_error('efficiency'); ?></span>
              </div>
              <div class="col-md-1"></div>
              <label class="col-form-label col-md-1">Forecast Efficiency :</label>
              <div class="col-md-2">
                <input id="forecastEffi" name="forecastEffi" type="number" class="form-control"
                value="<?php echo set_value('forecastEfficiency'); ?>" min="0" required>
                <span class="error" id="error"><?php echo form_error('forecastEfficiency'); ?></span>
              </div>

              <input type="hidden" id="efficiency_hid" name="efficiency_hid" value="">

            </div>

            <div class="form-group row " style="display: none;">
              <label class="col-form-label col-md-1">Status:</label>
              <div class="col-md-4">
                <div class="form-check form-check-inline form-check-right">
                  <label class="form-check-label">
                    Run
                    <input type="radio" id="run" class="form-check-input-styled" name="status" onclick="changStatus();"
                    value="1" checked data-fouc>
                  </label>
                </div>

                <div class="form-check form-check-inline form-check-right">
                  <label class="form-check-label">
                    Hold
                    <input type="radio" id="hold" class="form-check-input-styled" name="status" onclick="changStatus();"
                    value="2" data-fouc>
                  </label>
                </div>

                <div class="form-check form-check-inline form-check-right">
                  <label class="form-check-label">
                    Feeding
                    <input type="radio" id="feeding" class="form-check-input-styled"name="status" onclick="changStatus();"
                    value="4" data-fouc>
                  </label>
                </div>
              </div>
              <div class="col-md-7">
                <span class="msg" id="msg" style="color:blue;"></span>
              </div>
            </div>

            <input type="hidden" name="scNumber" id="scNumber">

            <div class="form-group row">
              <div id="tempDiv" class="col-md-3">
              </div>

              <label id="feedingLbl" class="col-form-label col-md-1" style="display: none;">Feeding Hrs
                :</label>
                <div id="feedingInputDiv" class="col-md-2" style="display: none;">
                  <input id="feedHours" name="feedHours" type="number" class="form-control "
                  value="<?php if (set_value('feedHours') == '') {
                    echo '0';
                  } else {
                    echo set_value('feedHours');
                  } ?>" placeholder="Feeding Hours" min="0" >
                  <span class="error" id="error"><?php echo form_error('feedHours'); ?></span>
                </div>
                <div class="col-md-9">
                  <div class="text-right">
                    <button type="submit" id="save" name="save" class="btn btn-primary">Save<i
                      class="icon-paperplane ml-2"></i></button>
                      <button type="reset" class="btn btn-warning">Reset<i class="icon-reset ml-2"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
        <!-- /form inputs -->

      </div>
      <!-- /content area -->

      <script>

      $(document).ready(function(){
        if($('#line').val()!=''){
          getDayPlanTypes();
        }
      });

        function getDelivery(style) {
          var style = $(style).val();
          if (style != '') {
            $.ajax({
              url: '<?php echo base_url("index.php/Workstudy_con/getDelivery")?>', //This is the current doc
              type: "POST",
              data: ({
                style: style,
              }),
              success: function (data) {
                var html = "<option value='' selected=\"selected\">&nbsp;</option>";
                var json_value = JSON.parse(data);
                for (var i = 0; i < json_value.length; i++) {
                  html += "<option value='" + json_value[i]['deliveryNo'] + "'>" + json_value[i]['deliveryNo'] + "</option>";
                }
                $('#delivery').empty().append(html);
              }
            });
          } else {


          }
        }

        function getOrderQty(delivery) {

          var delivery = $(delivery).val();
          var style = $('#style').val();
          if (delivery != '') {
            $.ajax({
              url: '<?php echo base_url("Workstudy_con/getOrderQty")?>', //This is the current doc
              type: "POST",
              data: ({
                deliveryNo: delivery,
                style: style,
              }),
              success: function (data) {
                var json_value = JSON.parse(data);
                $('#orderQty').val(json_value[0]['orderQty']);
                $('#scNumber').val(json_value[0]['scNumber']);

                getPlannedQty();
                getPlannerQty();
              }
            });
          } else {
            $('#orderQty').val('');
            $('#plannerQty').val('');
          }
        }

        function checkLineIsRunning(selectLine) {
          var selectLine = $(selectLine).val();
          if (selectLine != '') {
            $.ajax({
              url: '<?php echo base_url("Workstudy_con/checkLineIsRunning")?>', //This is the current doc
              type: "POST",
              data: ({
                line: selectLine
              }),
              success: function (data) {
                if (data != 'notRunning') {
                  $('#errorLineRunnig').text("This line is currently running style '" + data + "'");
                  //
                  $('#run').removeAttr('checked', 'checked');
                  $('#run').parents('span').removeClass('checked');
                  $('#run').attr('Disabled', 'Disabled');

                  $('#hold').parents('span').addClass('checked');
                  $('#hold').attr('checked', 'checked');

                  $('#feeding').removeAttr('checked', 'checked');
                  $('#feeding').parents('span').removeClass('checked');
                  getDayPlanTypes('notNew');
                } else if (data == 'notRunning') {
                  $('#errorLineRunnig').text("");
                  $('#run').parents('span').addClass('checked');
                  $('#run').attr('checked', 'checked');
                  $('#run').removeAttr('Disabled', 'Disabled');

                  $('#feeding').parents('span').addClass('checked');
                  $('#feeding').removeAttr('checked', 'checked');
                  $('#feeding').parents('span').removeClass('checked');

                  $('#hold').parents('span').removeClass('checked');
                  $('#hold').removeAttr('checked', 'checked');
                  getDayPlanTypes('new');
                }
              }
            });
          }
        }

        function getDayPlanTypes(isNewPlan) {
            var html="";
          if(isNewPlan=='new'){
            html += '<option></option>';
            html += '<option value="1">Normal</option>';
            html += '<option value="2">Feeding</option>';
          }else{
            html += '<option></option>';
            html += '<option value="2">Feeding</option>';
            html += '<option value="3">Two Style - Split Team</option>';
            html += '<option value="4">Two Style & Same SMV- All Workers </option>';
          }
          $('#dayPlanType').empty().append(html);
        }

        function getStyleRunDays() {
          var style = $('#style').val();
          var line = $('#line').val();
          var smv = $('#smv').val();
          var dayPlanType = $('#dayPlanType').val();

          if (style != '' && line != '') {
            $.ajax({
              url: '<?php echo base_url("Workstudy_con/getStyleRunDays")?>', //This is the current doc
              type: "POST",
              data: ({
                style: style,
                line: line,
                smv: smv
              }),
              success: function (data) {
                var date = '-'
                var StyleRunDays = 0;
                if (data != 0) {
                  var json_value = JSON.parse(data);
                  if (json_value[0]['lastRunDate'] != null) {
                    date = json_value[0]['lastRunDate'];
                  }
                  StyleRunDays = json_value[0]['styleRunDays'];
                  if(dayPlanType != '4'){
                    $('#efficiency').val(json_value[0]['efficiency']);
                    $('#efficiency_hid').val(json_value[0]['efficiency']);

                    $('#forecastEffi').val(json_value[0]['efficiency']);
                    $('#forecastEffi_hid').val(json_value[0]['efficiency']);
                  }

                } else {

                }
                $('#msg').html('<b>Note :</b>  This  <b>' + style + '</b> style have run this line in <b>' + StyleRunDays + '</b> days. Last days is/was <b>' + date + '</b>');
              }
            });
          } else {
            $('#msg').html('');
          }

        }

        function getPlannedQty() {
          var hrs = $('#workingHrs').val();
          var smv = $('#smv').val();
          var workers = $('#noOfWorkser').val();
          var line = $('#line').val();
          var style = $('#style').val();

          if (style != '' && line != '' && smv != '' && hrs != '' && workers != '') {
            $.ajax({
              url: '<?php echo base_url("Workstudy_con/getPlannedQty")?>', //This is the current doc
              type: "POST",
              data: ({
                hrs: hrs,
                smv: smv,
                workers: workers,
                line: line,
                style: style,
              }),
              success: function (data) {
                $('#planQty').val(data);
              }
            });
          } else {
            $('#planQty').val('');
          }

        }

        function getPlannerQty() {
          var orderQty = parseInt($('#orderQty').val());
          var planPer = parseFloat($('#planPer').val());
          var PlannerQty = orderQty;

          if (planPer != '' && orderQty != '' && planPer != 0) {
            PlannerQty += parseInt(orderQty * (planPer / 100));

            $('#plannerQty').val(PlannerQty);
          } else {
            $('#plannerQty').val(PlannerQty);
          }

        }

        function resetTextField(selectWht) {

          if (selectWht == 'team') {
            $('#style').val(null).trigger('change');
            $('#delivery').val(null).trigger('change');
            $('#orderQty').val('');
            $('#planPer').val('');
            $('#plannerQty').val('');
            $('#workingHrs').val('');
            $('#smv').val('');
            $('#noOfWorkser').val('');
            $('#planQty').val('');
            $('#efficiency').val('');
            $('#forecastEffi').val('');
          }
        }

        function asDayPlanType(){
          var dayPlanType = $('#dayPlanType').val();
          if(dayPlanType == '1'){
            $( "#run" ).trigger( "click" );
          }else if(dayPlanType == '2'){
            $( "#feeding" ).trigger( "click" );
            resetAfterSelectDayPlanType()
          }else if(dayPlanType == '3' ){
            $( "#hold" ).trigger( "click" );
            resetAfterSelectDayPlanType()
          }else if(dayPlanType == '4'){
            $( "#hold" ).trigger( "click" );
            loadPreRunnigDayPlan();
          }

          changStatus();
        }

        function changStatus() {
          var status =  $("input[name=status]:checked").val();

          if(status == '4'){
            $('#tempDiv').css('display','none');
            $('#feedingLbl').css('display','block');
            $('#feedingInputDiv').css('display','block');
            $('#feedHours').val('1');
            $('#feedHours').attr('Required','Required');
          }else{
            $('#feedingLbl').css('display','none');
            $('#feedingInputDiv').css('display','none');
            $('#tempDiv').css('display','block');
            $('#feedHours').val('0');
            $('#feedHours').removeAttr('Required','Required');
          }
        }

        function loadPreRunnigDayPlan() {
          var lineId =   $('#line').val();

          if(lineId !=''){
            // loaderOn();
            $.ajax({
              url: '<?php echo base_url("Workstudy_con/getPreRunnigDayPlan")?>',
              type: "POST",
              data: ({
                lineId: lineId,
              }),
              success: function (data) {
                if (data != 'noPreDayPlan') {
                  var json_value = JSON.parse(data);
                  $('#timeTempl').val(json_value[0]['timeTemplate']).trigger('change');
                  $('#workingHrs').val(json_value[0]['hrs']);
                  $('#smv').val(json_value[0]['smv']);
                  $('#noOfWorkser').val(json_value[0]['noOfwokers']);
                  $('#efficiency').val(json_value[0]['incenEffi']);
                  $('#efficiency_hid').val(json_value[0]['sysEffi']);
                  $('#forecastEffi').val(json_value[0]['forecastEffi']);
                  $('#forecastEffi_hid').val(json_value[0]['sysEffi']);

                  // $('#timeTempl').attr('Disabled','Disabled');
                  $('#timeTempl').select2('readonly',true);
                  $('#workingHrs').attr('readonly','readonly');
                  $('#smv').attr('readonly','readonly');
                  $('#noOfWorkser').attr('readonly','readonly');
                  $('#efficiency').attr('readonly','readonly');
                  $('#forecastEffi').attr('readonly','readonly');

                }else{
                  alert("no Previous Day Plan");
                }
              }
            });
            // loaderOff();
          }
        }

        function resetAfterSelectDayPlanType() {
          $('#timeTempl').val(null).trigger('change');
          $('#workingHrs').val('');
          $('#smv').val('');
          $('#noOfWorkser').val('');
          $('#efficiency').val('');
          $('#efficiency_hid').val('');
          $('#forecastEffi').val('');
          $('#forecastEffi_hid').val('');

          $('#timeTempl').removeAttr('Disabled','Disabled');
          $('#workingHrs').removeAttr('readonly','readonly');
          $('#smv').removeAttr('readonly','readonly');
          $('#noOfWorkser').removeAttr('readonly','readonly');
          $('#efficiency').removeAttr('readonly','readonly');
          $('#forecastEffi').removeAttr('readonly','readonly');
        }

        function setInceHour(){
        var workingHour = $('#workingHrs').val();
        $('#ince_hour').val(workingHour);
        }

      </script>
