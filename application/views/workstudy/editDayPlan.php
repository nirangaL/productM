
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/23/2019-->
<!-- * Time: 5:09 PM-->
<!-- */-->


<!-- Main content -->
<div class="content-wrapper">

  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
      <div class="page-title d-flex">
        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Day-Plan</span> - Edit
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
          </div>

          <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
              <div class="breadcrumb">
                <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="<?php echo base_url('Workstudy_con')?>" class="breadcrumb-item">Day Plan-List</a>
                <span class="breadcrumb-item active">Edit Day Plan</span>
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
              <form action="<?php echo base_url('Workstudy_con/editDayPlan/').$dayPlanData[0]->id?> " method="post">
                <fieldset class="mb-3">
                  <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                  <div class="form-group row">
                    <label class="col-form-label col-md-1">Team :</label>
                    <div class="col-md-3">
                      <select id="line" name="line" class="form-control select-search" data-fouc disabled>
                        <option value="" >--- Select Line ----</option>
                        <?php foreach ($prdocLine as $row){
                          ?>
                          <option value="<?php echo $row->line_id;?>"<?php if($row->line_id == $dayPlanData[0]->line) {echo 'Selected';} echo set_select('line', $row->line_id);?> > <?php echo $row->line;?> </option>
                          <?php
                        }?>
                      </select>
                      <span class="error" id="error"><?php echo form_error('line'); ?>
                      <span class="error" id="errorLineRunnig"></span>
                   </div>

                  <label class="col-form-label col-md-1">Type :</label>
                      <div class="col-md-3">
                        <select id="dayPlanType" name="dayPlanType" class="form-control select" data-placeholder="Select a Day Plan type"
                        onchange="asDayPlanType();" data-fouc disabled>
                        <option value="1" <?php if($dayPlanData[0]->dayPlanType == '1'){echo 'selected';} ?> >Normal</option>
                        <option value="2" <?php if($dayPlanData[0]->dayPlanType == '2'){echo 'selected';} ?>>Feeding</option>
                        <option value="3" <?php if($dayPlanData[0]->dayPlanType == '3'){echo 'selected';} ?>>Two Style - Split Team</option>
                        <option value="4" <?php if($dayPlanData[0]->dayPlanType == '4'){echo 'selected';} ?>>Two Style & Same SMV- All Workers</option>
                      </select>
                      <span class="error" id="error"><?php echo form_error('dayPlanType'); ?></span>
                    </div>
                    <label class="col-form-label col-md-1">Time Table :</label>
                    <div class="col-md-3">
                      <select id="timeTempl" name="timeTempl" class="form-control select-search" data-fouc required disabled>
                        <option value="">--- Select Time Table ----</option>
                        <?php foreach ($timeTempl as $row) {
                          ?>
                          <option value="<?php echo $row->id; ?>" <?php if($row->id == $dayPlanData[0]->timeTemplate) {echo 'Selected';} echo set_select('line', $row->id);?> > <?php echo $row->templateCode.' - '. $row->templateName; ?> </option>
                          <?php
                        } ?>
                      </select>
                      <span class="error" id="error"><?php echo form_error('line'); ?></span>
                    </div>
                  </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-1">Style :</label>
                      <div class="col-md-3">
                        <select id="style" name="style" class="form-control select-search" data-fouc disabled>
                          <option value="" >--- Select Style ----</option>
                          <?php foreach ($style as $row){
                            ?>
                            <option value="<?php echo $row->styleNo;?>" <?php if($row->styleNo == $dayPlanData[0]->style) {echo 'Selected';}  echo set_select('style', $row->styleNo);?> > <?php echo $row->styleNo.' - '.$row->scNumber;?> </option>
                            <?php
                          }?>
                        </select>
                        <span class="error" id="error"><?php echo form_error('style'); ?></span>
                        <input type="hidden" id="style_hid" value="<?php echo $dayPlanData[0]->style; ?>">
                      </div>
                      <label class="col-form-label col-md-1">SMV :</label>
                      <div class="col-md-2">
                        <input id="smv" name="smv" type="text" class="form-control" value="<?php if(!empty($dayPlanData[0]->smv)){echo $dayPlanData[0]->smv; }else{ echo set_value('smv');}  ?>" min="0" onkeyup="getPlannedQty();" onblur="getStyleRunDays();"> 
                        <span class="error" id="error"><?php echo form_error('smv'); ?></span>
                      </div>
                      
                      <div class="col-md-1"></div>
                      <label class="col-form-label col-md-1">Workers:</label>
                      <div class="col-md-2">
                        <input id="noOfWorkser" name="noOfWorkser" type="number" step="any" min="0" class="form-control" value="<?php if(!empty($dayPlanData[0]->noOfwokers)){echo $dayPlanData[0]->noOfwokers; }else{ echo set_value('noOfWorkser');} ?>" min="1" onkeyup="getPlannedQty()">
                        <span class="error" id="error"><?php echo form_error('noOfWorkser'); ?></span>
                      </div>
                    </div>           
                    <div class="form-group row">
                      <label class="col-form-label col-md-1">Hours:</label>
                      <div class="col-md-2">
                        <input id="workingHrs" name="workingHrs" type="text" class="form-control" value="<?php if(!empty($dayPlanData[0]->hrs)){echo $dayPlanData[0]->hrs; }else{ echo set_value('workingHrs');} ?>" min="0" onkeyup="getPlannedQty();">
                        <span class="error" id="error"><?php echo form_error('workingHrs'); ?></span>
                      </div>
                      <div class="col-md-1"></div>
                      <label class="col-form-label col-md-1">Plan Qty :</label>
                      <div class="col-md-2">
                        <input id="planQty" name="planQty" type="number" class="form-control" value="<?php  if(!empty($dayPlanData[0]->dayPlanQty)){echo $dayPlanData[0]->dayPlanQty; }else{ echo set_value('planQty');} ?>" min="0">
                        <span class="error" id="error"><?php echo form_error('planQty'); ?></span>
                      </div>
                      <div class="col-md-1"></div>
                      <label class="col-form-label col-md-1">R. Day :</label>
                      <div class="col-md-1">
                        <input id="runDay" name="runDay" type="number" class="form-control"
                        value="<?php  if(!empty($dayPlanData[0]->dayPlanQty)){echo $dayPlanData[0]->runningDay; }else{ echo set_value('runDay');} ?>" min="1" onkeyup="copytoShowRunDay(this);getStyleRunDays();" required>
                        <span class="error" id="error"><?php echo form_error('runDay'); ?></span>
                      </div>
                      <label class="col-form-label col-md-1">Show R.Day :</label>
                      <div class="col-md-1">
                        <input id="showRunDay" name="showRunDay" type="number" class="form-control"
                        value="<?php  if(!empty($dayPlanData[0]->showRunningDay)){echo $dayPlanData[0]->showRunningDay; }else{ echo set_value('showRunDay');} ?>" min="1" onkeyup="copytoShowRunDay(this)" required>
                        <span class="error" id="error"><?php echo form_error('showRunDay'); ?></span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-1">Inc.Hour :</label>
                      <div class="col-md-2">
                        <input id="ince_hour" name="ince_hour" type="text" class="form-control"
                        value="<?php  if(!empty($dayPlanData[0]->incentiveHour)){echo $dayPlanData[0]->incentiveHour; }else{ echo set_value('ince_hour');} ?>"  min="0" max="24" required>
                        <span class="error" id="error"><?php echo form_error('ince_hour'); ?></span>
                      </div>
                      <div class="col-md-1"></div>
                      <label class="col-form-label col-md-1">Inc.Efficiency :</label>
                      <div class="col-md-2">
                        <input id="efficiency" name="efficiency" type="number" class="form-control" value="<?php  if(!empty($dayPlanData[0]->incenEffi)){echo $dayPlanData[0]->incenEffi; }else{ echo set_value('efficiency');} ?>" min="0">
                        <span class="error" id="error"><?php echo form_error('efficiency'); ?></span>
                      </div>
                      <div class="col-md-1"></div>
                      <label class="col-form-label col-md-1">Forecast Efficiency :</label>
                      <div class="col-md-2">
                        <input id="forecastEffi" name="forecastEffi" type="number" class="form-control" value="<?php  if(!empty($dayPlanData[0]->forecastEffi)){echo $dayPlanData[0]->forecastEffi; }else{ echo set_value('forecastEffi');} ?>" min="0">
                        <span class="error" id="error"><?php echo form_error('forecastEfficiency'); ?></span>
                      </div>
                      <input type="hidden" id="efficiency_hid" name="efficiency_hid" value="<?php echo $dayPlanData[0]->sysEffi?>">
                      <div class="col-md-1"></div>
                      <!-- <label class="col-form-label col-md-1">Add Workers :</label>
                      <div class="col-md-2">
                        <input name="addWorkers" id="addWorkers" type="text" value="0"  class="form-control touchspin-empty">
                      </div> -->
                    </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-1">Status:</label>
                      <div class="col-md-10">
                        <?php if ($dayPlanData[0]->status !='3'){?>
                          <div class="form-check form-check-inline form-check-right">
                            <label class="form-check-label">
                              Run
                              <input type="radio" id="run" class="form-check-input-styled" name="status" value="1" <?php if($dayPlanData[0]->status == '1'){echo 'checked';}?> data-fouc disabled>
                            </label>
                          </div>
                        <?php }?>

                        <?php if ($dayPlanData[0]->status !='3'){?>
                          <div class="form-check form-check-inline form-check-right">
                            <label class="form-check-label">
                              Hold
                              <input type="radio" id="hold" class="form-check-input-styled " name="status" value="2" <?php if($dayPlanData[0]->status == '2'){echo 'checked';}?> data-fouc disabled>
                            </label>
                          </div>
                          <div class="form-check form-check-inline form-check-right">
                            <label class="form-check-label">
                              Feeding
                              <input type="radio" id="feeding" class="form-check-input-styled " name="status" value="4" <?php if($dayPlanData[0]->status == '4'){echo 'checked';}?> data-fouc disabled>
                            </label>
                          </div>
                        <?php }?>
                        <div class="form-check form-check-inline form-check-right">
                          <label class="form-check-label">
                            Close
                            <input type="radio" id="" class="form-check-input-styled" name="status" value="3" <?php if($dayPlanData[0]->status == '3'){echo 'checked';}?> data-fouc >
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div id="tempDiv" class="col-md-3" <?php if($dayPlanData[0]->status == '4'){echo 'style="display: none"';}else{echo 'style="display: block;"';}?> >
                      </div>
                      <label id="feedingLbl" class="col-form-label col-md-1" <?php if($dayPlanData[0]->status == '4'){echo 'style="display: block;"';}else{echo 'style="display: none;"';}?> >Feeding Hrs
                        :</label>
                        <div id="feedingInputDiv" class="col-md-2" <?php if($dayPlanData[0]->status == '4'){echo 'style="display: block;"';}else{echo 'style="display: none;"';}?> >
                          <input id="feedHours" name="feedHours" type="number" class="form-control "
                          value="<?php if (set_value('feedHours') == '') {
                            echo $dayPlanData[0]->feedingHour;
                          } else {
                            echo set_value('feedHours');
                          } ?>" placeholder="Feeding Hours" min="0" readonly>
                          <span class="error" id="error"><?php echo form_error('feedHours'); ?></span>
                        </div>

                        <input type="hidden" name="scNumber" id="scNumber">
                        <div class="col-md-9">
                          <?php if ($dayPlanData[0]->status !='3'){?>
                            <div class="text-right">
                              <button type="submit" id="update" name="update"  class="btn bg-purple-400 ">Update<i class="icon-pencil7 ml-2"></i> </button>
                            </div>
                          <?php }else{
                            ?>
                            <div class="text-right">
                              <span class="error">This plan was Closed </span>
                            </div>
                            <?php
                          }?>
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

            $(document).ready(function () {
              checkLineIsRunning('<?php echo $dayPlanData[0]->line?>');
            });

            function copytoShowRunDay(runday){
            var runday = $(runday).val();
              $('#showRunDay').val(runday);  
            }

            $("input[name='addWorkers']").TouchSpin({
              min: -10000000000,
              max: 100,
              step: 0.5,
              decimals: 1,
              boostat: 5,
              maxboostedstep: 10,

            });
           function copytoShowRunDay(runday){
              var runday = $(runday).val();
              if( $('#showRunDay').val()==''){
                $('#showRunDay').val(runday);
              }
            }

            function getStyleRunDays() {
          var style = $('#style').val();
          var line = $('#line').val();
          var smv = $('#smv').val();
          var runDay = $('#runDay').val();
          var dayPlanType = $('#dayPlanType').val();
          $('#efficiency').val('');
          $('#efficiency_hid').val('');

          $('#forecastEffi').val('');
          $('#forecastEffi_hid').val('');
          if(runDay ==''){
            runDay ='';
          }

          if (style != '' && line != '' && smv !='') {
            $.ajax({
              url: '<?php echo base_url("Workstudy_con/getStyleRunDays") ?>', //This is the current doc
              type: "POST",
              data: ({
                style: style,
                line: line,
                smv: smv,
                dayPlanType:dayPlanType,
                runDay:runDay
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
                  $('#runDay').val(StyleRunDays);
                  $('#showRunDay').val(StyleRunDays);
                  if(dayPlanType != '4'){
                    $('#efficiency').val(json_value[0]['efficiency']);
                    $('#efficiency_hid').val(json_value[0]['efficiency']);

                    $('#forecastEffi').val(json_value[0]['efficiency']);
                    $('#forecastEffi_hid').val(json_value[0]['efficiency']);
                  }

                } else {

                }
                $('#msg').html('<b>Note :</b>  This  <b>' + (style-1) + '</b> style have run this line in <b>' + StyleRunDays + '</b> days. Last days is/was <b>' + date + '</b>');
              }
            });
          } else {
            $('#msg').html('');
          }

        }

            function checkLineIsRunning(selectLine) {
              var selectLine = selectLine;
              var style = selectLine;

              var radioValue = $("input[name='status']:checked").val();

              if(selectLine != ''){
                $.ajax({
                  url: '<?php echo base_url("Workstudy_con/checkLineIsRunning")?>', //This is the current doc
                  type: "POST",
                  data: ({
                    line:selectLine
                  }),
                  success: function (data) {
                    if(data != $('#style_hid').val()){
                      if (data != 'notRunning') {
                        $('#errorLineRunnig').text("This line is currently running style '" + data + "'");
                        $('#run').removeAttr('checked','checked');
                        $('#run').parents('span').removeClass('checked');
                        $('#run').attr('Disabled','Disabled');
                        // $('#hold').parents('span').addClass('checked');
                        // $('#hold').attr('checked','checked');
                      } else if (data == 'notRunning') {
                        // $('#errorLineRunnig').text("");
                        // $('#run').parents('span').addClass('checked');
                        // $('#run').attr('checked','checked');
                        // $('#run').removeAttr('Disabled', 'Disabled');
                        //
                        // $('#hold').parents('span').removeClass('checked');
                        // $('#hold').removeAttr('checked','checked');
                      }
                    }

                  }
                });
              }
            }

            $("input[name=status]").click(function () {
              var status =  $("input[name=status]:checked").val();

              if(status == '4'){
                $('#tempDiv').css('display','none');
                $('#feedingLbl').css('display','block');
                $('#feedingInputDiv').css('display','block');
                $('#feedHours').val('1');
              }else{
                $('#feedingLbl').css('display','none');
                $('#feedingInputDiv').css('display','none');
                $('#tempDiv').css('display','block');
                $('#feedHours').val('0');
              }
            });

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



            </script>
