<style>
  th{
    text-align: center;
  }
  .tdInModel td{
      text-align: center;
  }

</style>

<!-- Main content -->
<div class="content-wrapper">

  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
      <div class="page-title d-flex">
        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Proceed Cut Plan</span>
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
                <!-- <a href="<?php // echo base_url('Workstudy_con') ?>" class="breadcrumb-item">DayPlan-List</a> -->
                <span class="breadcrumb-item active">Proceed Cut Plan</span>
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
            <div class="card-body">
              <!-- <legend class="text-uppercase font-size-sm font-weight-bold"></legend> -->
              <form action="<?php echo base_url('bpom/cutdep/Cutting_Cut_Plan_Con/findCutPlan');?>" method="post">
                <div class="form-group row">
                  <label class="col-form-label col-sm-1">Cut Plan Date :</label>
                  <div class="col-sm-3">
                    <input id="date" name="date" type="text" class="form-control datepick bg-slate-600 border-slate-600 border-1" value="<?php echo $date;?>" placeholder="Select a date …">
                  </div>
                  <div class="col-sm-4">
                    <button type="submit" id="btnFind" class="btn btn-primary"><i class="icon-search4"></i> Find</button>
                  </div>
                </div>
              </form>

              <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                <table id="proceedTbl" class="table table-hover display nowrap" style="width:100%">
                  <thead>
                    <tr>
                      <th>Cut-Plan-Num</th>
                      <th>Style</th>
                      <th>SC</th>
                      <th>Total Qty</th>
                      <th>Remark</th>
                      <th>Pocced Status</th>
                      <th>Pocced CP Num</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="cutPlans">
                    <?php

                    if(!empty($m_cut_plan[0]->id)){
                      foreach ($m_cut_plan as $row) {
                        ?>
                      <tr>
                        <td><?php echo $row->cutPlanName;?></td>
                        <td><?php echo $row->style;?></td>
                        <td><?php echo $row->sc;?></td>
                        <td><?php echo $row->total;?></td>
                        <td><?php echo $row->remark;?></td>
                        <?php
                        if($row->proceed=='1'){
                          ?>
                          <td class="text-center"><span class='badge bg-success'>Proceed</span></td>
                          <?php
                        }else{
                          ?>
                          <td class="text-center"><span class='badge bg-danger-400'>Pending</span></td>
                          <?php
                        }
                        ?>
                        <td><?php echo $row->cuttingCutPlanNum;?></td>
                        <td style='text-align:center;'><button type='button' class='btn btn-warning btn-sm' onclick='getCutPlanDetails(<?php echo $row->id;?>);' >View</td>
                      </tr>
                        <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>
            </div>
          </div>
          <!-- /card  -->
        </div>
        <!-- /content area -->

        <!-- Add Cut plan modal -->
        <div id="proceedCutPlan" class="modal fade" tabindex="-1" data-toggle="modal" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-full">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Proceed Cut Plan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
              <div class="modal-body">

                <div class="form-group row">
                  <label class="col-form-label col-sm-2">Cut Plan Date :</label>
                  <div class="col-sm-3">
                    <input id="date2" name="date2" type="text" class="form-control datepick bg-slate-600 border-slate-600 border-1" value="" disabled style="color:white;">
                  </div>

                  <label class="col-form-label col-sm-2">Merchant Cut Plan Number :</label>
                  <div class="col-sm-1">
                    <input id="cutPlanName" name="cutPlanName" type="text" class="form-control bg-slate-600 border-slate-600 border-1" readonly style="color:white;">
                  </div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-3 proceedLblDiv" hidden>
                    <img src="<?php echo base_url('assets/images/proceed lbl.jpg');?>" alt="This Cut Plan is Proceed" class="proceedLbl">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-form-label col-sm-2">Remarks :</label>
                  <div class="col-sm-3">
                    <textarea id='remark' class="form-control bg-slate-600 border-slate-600 border-1" style="height:50px;" readonly style="color:white;"></textarea>
                  </div>
                  <div class="col-sm-3"></div>

                </div>

                <div class="table-responsive">
                  <table  class="table table-dark bg-slate-600">
                    <thead id="tblHeadNewCutPlan">
                      <tr>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="tblBodyNewCutPlan">
                      <tr>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </div>
              <div class=" col-sm-12 " style="padding-bottom:20px;">
                <div class="form-group row proceedDiv">
                  <div class="col-sm-5"></div>
                  <label class="col-form-label col-sm-2">Cutting Cut Plan Number :</label>
                  <div class="col-sm-2">
                    <input id="cuttingCpNum" type="text" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="" >
                      <span id="error" class="error"></span>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" id="btn_sv" class="btn bg-primary" onclick="proceedCutPlan();">Proceed <i class="icon-paperplane ml-2"></i></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

                <div class="form-group row proceedLblDiv" hidden>

                  <div class="col-sm-12 text-right">
                      <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:20px;">Close</button>
                  </div>

                </div>


              </div>
            </div>
          </div>
        </div>

        <input id="rowCount" type="hidden" value="1">
        <input id="noOfSize" type="hidden" value="0">
        <input id="sc" type="hidden" value="">
        <input id="cutPlanIdTOEdif" type="hidden" value="0">
        <!-- /Add Cut Plan modal -->

        <script>
        $(document).ready(function () {
          $('.datepick').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
          })

          $('#proceedTbl').DataTable( {
            "scrollX": true
          } );
        });

        ///// Cut plan set table as sizes
        function getCutPlanDetails(cutPlanId){

          if(cutPlanId != ''){
            $.ajax({
              url: '<?php echo base_url("bpom/cutdep/Cutting_Cut_Plan_Con/getCutPlanDetails") ?>', //This is the current doc
              type: "POST",
              data: ({
                'cutPlanId': cutPlanId,
              }),
              success: function (data) {
                if(data != ''){

                  var json_value = JSON.parse(data);

                  //// set number of size to input hidden text field - Need when Add new line ////
                  $('#noOfSize').val(Object.keys(json_value[0]).length);


                  //// set table header element /////
                  $('#date2').val(json_value[0][0]['cutPlanDate']);
                  $('#cutPlanName').val(json_value[0][0]['cutPlanName']);
                  $('#remark').val(json_value[0][0]['remark']);
                  $('#cutPla2000nIdTOEdif').val(cutPlanId);

                  var htmlForTbHead = "";
                  htmlForTbHead += "<tr>";
                  htmlForTbHead += "<th>PO</th>";
                  htmlForTbHead += "<th>Color</th>";

                  for (var i = 0; i < json_value[0].length; i++) {
                    htmlForTbHead += "<th>"  + json_value[0][i]['size'] +"</th>";
                  }
                  htmlForTbHead += "<th>Total</th>";
                  htmlForTbHead += "</tr>";

                  var html='';

                  /// Row count ////
                  var poCount = Object.keys(json_value).length;
                  $('#rowCount').val(poCount);

                for(var y = 0; y < poCount; y++){
                  html += "<tr class='tdInModel' id='tr"+(y+1)+"'>";
                  html += "<td>"+json_value[y][0]['po']+"</td>";
                  html += "<td>"+json_value[y][0]['color']+"</td>";
                  var total = 0;
                  for (var i = 0; i <json_value[y].length; i++) {
                    html += "<td>"+json_value[y][i]['qty']+"</td>";
                    total += parseInt(json_value[y][i]['qty']);
                  }
                  html += "<td id='total"+(y+1)+"' class='font-weight-bold'>"+total+"</td>";
                  html += "</tr>";
                }

                  if(json_value[0][0]['proceed'] == 1){
                    $('.proceedDiv').hide();
                    $('.proceedLblDiv').removeAttr('hidden','hidden');
                  }

                  $('#tblHeadNewCutPlan').empty().append(htmlForTbHead);
                  $('#tblBodyNewCutPlan').empty().append(html);
                  $('#proceedCutPlan').modal('show');
                }else{
                  $('#tblHeadNewCutPlan').empty();
                }
              },
              error:function (data){

              }
            });
          }else{
          }
        }


        function proceedCutPlan(){
          var cutPlanId = $('#cutPlanIdTOEdif').val();
          var cuttingCpNum = $('#cuttingCpNum').val();

          if(cuttingCpNum !=''){
            $.ajax({
              url: '<?php  echo base_url("bpom/cutdep/Cutting_Cut_Plan_Con/proceedCutPlan")?>',
              type: "POST",
              data: ({
                'cutPlanId': cutPlanId,
                'cuttingCutPlanNum': cuttingCpNum,
              }),
              success: function (data) {
                if(data == 'Proceed'){
                  sweetAlert('Succesfully Updated', '', 'success',{
                    timer: 2000,
                    });
                    $("#btnFind").trigger("click");
                }else{
                  sweetAlert('Oops!.something went wrong!', 'Try again or get IT Support', 'error');
                }
              }
            });
          }else{
            $('#error').text('Please Enter a Cutting Cut Plan Number!');
          }
        }


        </script>
