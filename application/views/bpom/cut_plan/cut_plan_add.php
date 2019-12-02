<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: nirangal-->
<!-- * Date: 01/23/2019-->
<!-- * Time: 9:05 AM-->
<!-- */-->

<style>
th,td{
  text-align: center;
}
.wid-200{
  width: 200px;
}
.wid-150{
  width: 150px;
}
.wid-75{
  width: 75px;
}
</style>


<!-- Main content -->
<div class="content-wrapper">

  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
      <div class="page-title d-flex">
        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Cut-Plan</span> - Add
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
            <!-- <div class="card-header header-elements-inline">
              <h5 class="card-title">Add Cut Plan</h5>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                  <a class="list-icons-item" data-action="reload"></a>
                  <a class="list-icons-item" data-action="remove"></a>
                </div>
              </div>
            </div> -->

            <div class="card-body">
              <!-- <legend class="text-uppercase font-size-sm font-weight-bold"></legend> -->

              <div class="form-group row">
                <label class="col-form-label col-sm-1">Style :</label>
                <div class="col-sm-4">
                  <select id="style" name="style" class="form-control select-search" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-placeholder="Select a Style" onchange="getSeason();getCTplanTableData();" data-fouc required>
                    <option value=""></option>
                    <?php foreach ($style as $row) {
                      ?>
                      <option value="<?php echo $row->style_name; ?>" > <?php echo $row->style_name.' - '.$row->sc ; ?> </option>
                      <?php
                    } ?>
                  </select>
                  <span id="error" class="error"></span>
                </div>

                <label class="col-form-label col-sm-1">Season :</label>
                <div class="col-sm-3">
                  <input id="season" name="season" type="text" class="form-control bg-slate-600 border-slate-600 border-1" readonly>
                </div>
              </div>

              <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
              <div class="table-responsive">
                <table  class="table table-dark bg-slate-600">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Cut-Plan Name</th>
                      <th>Total Qty</th>
                      <th>Remark</th>
                      <th>Pocced Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="cutPlans">

                  </tbody>
                </table>
              </div>

              <div class="col-sm-12 text-right" style="margin-top:20px;">
                <button class="btn btn-primary" onclick="addCutPlan();"><i class="icon-ungroup"></i> Add Cut Plan</button>
              </div>
            </div>
          </div>
          <!-- /card  -->
        </div>
        <!-- /content area -->

        <!-- Add Cut plan modal -->
        <div id="addCutPlanModel" class="modal fade" tabindex="-1" data-toggle="modal" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-full">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add New Cut Plan</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="resetModel();">&times;</button>
              </div>
              <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
              <div class="modal-body">

                <div class="form-group row">
                  <label class="col-form-label col-sm-2">Cut Plan Date :</label>
                  <div class="col-sm-2">
                    <input id="date" name="date" type="text" class="form-control datepick bg-slate-600 border-slate-600 border-1" value="<?php echo date('Y-m-d');?>" placeholder="Select a date …">
                  </div>
                  <div class="col-sm-1"></div>
                  <label class="col-form-label col-sm-2">Cut Plan Number :</label>
                  <div class="col-sm-2">
                    <input id="cutPlanName" name="cutPlanName" type="text" class="form-control bg-slate-600 border-slate-600 border-1" readonly>
                  </div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-2">
                  <section class="proceeded" hidden>
                      <img src="<?php echo base_url('assets/images/proceed lbl.jpg');?>" alt="This Cut Plan is Proceed" class="proceedLbl">
                  </section>
                  </div>

                </div>
                <div class="form-group row">
                  <label class="col-form-label col-sm-2">Remarks :</label>
                  <div class="col-sm-3">
                    <textarea id='remark' class="form-control bg-slate-600 border-slate-600 border-1" style="height:50px;"></textarea>
                  </div>

                    <label class="col-form-label col-sm-2 proceeded"  hidden>Cutting Cut-Plan Nu :</label>
                    <div class="col-sm-2 proceeded" hidden>
                      <input id="cutting_cp_no" name="cutting_cp_no" type="text" class="form-control bg-slate-600 border-slate-600 border-1 " readonly>
                    </div>
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


                <div class="col-sm-12 text-left" style="margin-top:10px;">
                  <section class="proceedPending">
                    <button type="button" class="btn btn-success" onclick="addLine()">Add Line</button>
                  </section>
                </div>
              </div>

              <div class="col-sm-12 text-right" style="padding-bottom:20px;">
                <section class="proceedPending">
                  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="resetModel();">Close</button>
                  <button type="button" id="btn_sv" class="btn bg-primary" onclick="setCutPlan();">Save <i class="icon-paperplane ml-2"></i></button>
                  <button type="button" id="btn_upd" class="btn bg-purple" onclick="UpdateCutPlan();" hidden>Update <i class="icon-rotate-cw3 ml-2" ></i></button>
                </section>
                <section class="proceeded" hidden>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="resetModel();">Close</button>
                </section>
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

        var sizeNames  = '';
        $(document).ready(function () {
          $('.datepick').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
          })


        var dataTbl =  $('#cutPlanTbl').DataTable( {
            "scrollX": true
          } );
        });


        function resetModel(){
          var today = new Date();
          var dd = String(today.getDate()).padStart(2, '0');
          var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
          var yyyy = today.getFullYear();
          today = yyyy + '/' + mm + '/' + dd;
          var picker = $('.datepick').pickadate('picker').set('select', today);
          $('#remark').val();
          $('#rowCount').val(1);
          $('#noOfSize').val(0);
          $('#sc').val();


        }
        //// Fire when change style ////
        function getSeason(){
          var style = $('#style').val();

          if(style != ''){
            $("#error").empty();
            $.ajax({
              url: '<?php echo base_url("bpom/Cut_Plan_Con/getSeason")?>',
              type: "POST",
              data: ({
                'style': style,
              }),
              success: function (data) {
                if(data!='noData'){
                    var json_value = JSON.parse(data);

                  $('#season').val(json_value[0]['season']);
                  $('#sc').val(json_value[0]['sc']);
                }
              }
            });
          }
        }
        function getCTplanTableData() {
          var style = $('#style').val();
          $('#cutPlans').empty();
          if (style != '') {
            $.ajax({
              url: '<?php echo base_url("bpom/Cut_Plan_Con/getCTplanTableData")?>', //This is the current doc
              type: "POST",
              data: ({
                'style': style,
              }),
              success: function (data) {
                if(data!=''){
                var html='';
                var json_value = JSON.parse(data);


                for (var i = 0; i < json_value.length; i++) {

                  html += "<tr>";
                  html += "<td>" + json_value[i]['cutPlanDate'] + "</td>";
                  html += "<td>"  + json_value[i]['cutPlanName'] +"</td>";
                  html += "<td>"  + json_value[i]['totalQty'] +"</td>";
                  html += "<td>"  + json_value[i]['remark'] +"</td>";
                  if(json_value[i]['proceed']=='1'){
                      html += "<td><span class='badge bg-success'>Proceed</span></td>";
                  }else{
                      html += "<td><span class='badge bg-danger-400'>Pending</span></td>";
                  }
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning btn-sm' onclick='editCutPlan("+ json_value[i]['id'] +");' >View & Edit</td>";
                  html += "</tr>";
                }

                $('#cutPlans').empty().append(html);
                dataTbl();
              }else{
                $('#cutPlans').empty();
              }
              },
              error:function (data){
                sweetAlert('Oops!.There is an issue in Network!', 'Try again or get IT Support', 'error');
              }
            });
          }
        }
        function getCutPlanNumber() {
          var style = $('#style').val();
          $.ajax({
            url: '<?php  echo base_url("bpom/Cut_Plan_Con/getCutPlanNumber")?>',
            type: "POST",
            data: ({
              'style': style,
            }),
            success: function (data) {
              if(data!=''){
                $('#cutPlanName').val(data);
              }
            }
          });
        }
        ///// Cut plan set table as sizes
        function addCutPlan(){
          var style = $('#style').val();

          if(style != ''){

            $.ajax({
              url: '<?php echo base_url("bpom/Cut_Plan_Con/getStyleData") ?>', //This is the current doc
              type: "POST",
              data: ({
                'style': style,
              }),
              success: function (data) {
                if(data != ''){

                  var json_value = JSON.parse(data);

                  //// set number of size to input hidden text field - Need when Add new line ////
                  $('#noOfSize').val(json_value.length);
                  sizeNames = json_value;

                  //// set table header element /////
                  var htmlForTbHead = "";
                  htmlForTbHead += "<tr>";
                  htmlForTbHead += "<th>PO</th>";
                  htmlForTbHead += "<th>Color</th>";

                  for (var i = 0; i < json_value.length; i++) {
                    htmlForTbHead += "<th>"  + json_value[i]['size'] +"</th>";
                  }
                  htmlForTbHead += "<th>Total</th>";
                  htmlForTbHead += "<th>Action</th>";
                  htmlForTbHead += "</tr>";

                  /// set table body elemets ///
                  var html='';
                  html += "<tr id='tr1'>";
                  html += "<td><select id='delv1' class='form-control select-search-tbl wid-200 po' data-placeholder='Select a po' onchange='getColor(1)'></select></td>";
                  html += "<td><select id='color1' class='form-control select-search-tbl wid-150 color' data-placeholder='Select a color' onchange='getOrderQtyEachSize(1)'></select></td>";
                  for (var i = 0; i <json_value.length; i++) {
                    html += "<td><input id='size"+(i+1)+"' data-sizeName='"+json_value[i]['size']+"' type='text' class=' size size1 form-control wid-75 rowSize1' onkeyup='getTotal(1);' onkeydown='isNumber(event);'></td>";
                  }
                  html += "<td id='total1'></td>";
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteLine(1)' ><i class='icon-bin'></i> </button></td>";
                  html += "</tr>";


                  getCutPlanNumber();
                  $('#remark').val('');
                  $('#tblHeadNewCutPlan').empty().append(htmlForTbHead);
                  $('#tblBodyNewCutPlan').empty().append(html);
                  getDelivery(1);
                  $('#btn_sv').removeAttr('hidden','hidden');
                  $('#btn_upd').attr('hidden','hidden');
                  $('.select-search-tbl').select2({ width: 'resolve' });
                  $('#addCutPlanModel').modal('show');
                }else{
                  $('#tblHeadNewCutPlan').empty();
                }
              },
              error:function (data){

              }
            });
          }else{
            html = "<p>Please Select a Style</p>"
            $("#error").empty().append(html);
            $("#style").focus();
          }
        }
        function addLine(){
            /// new row number ///
            var newRowNum = parseInt($('#rowCount').val())+1;

            /// get nombers of size ///
            var noOfSizes = parseInt($('#noOfSize').val())

            var html='';
            html += "<tr id='tr"+(newRowNum)+"'>";
            html += "<td><select id='delv"+(newRowNum)+"' class='form-control select-search-tbl wid-200 po' data-placeholder='Select a po' onchange='getColor("+newRowNum+")'></select></td>";
            html += "<td><select id='color"+(newRowNum)+"' class='form-control select-search-tbl wid-150 color' data-placeholder='Select a color' onchange='getOrderQtyEachSize("+newRowNum+");'></select></td>";


            for (var i = 0; i < sizeNames.length; i++) {
              html += "<td><input id='size"+(i+1)+"' data-sizename='"+sizeNames[i]['size']+"' type='text' class='size size"+(newRowNum)+" form-control wid-75 rowSize"+(newRowNum)+"' onkeyup='getTotal("+newRowNum+");' onkeydown='isNumber(event);'></td>";
            }
            html += "<td id='total"+(newRowNum)+"'></td>";
            html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteLine("+(newRowNum)+")' ><i class='icon-bin'></i> </button></td>";
            html += "</tr>";

            $('#tblBodyNewCutPlan').append(html);
            $('#rowCount').val(newRowNum);
            getDelivery(newRowNum);
            $('.select-search-tbl').select2({ width: 'resolve' });

        }
        function editCutPlan(cutPlanId){

          if(cutPlanId != ''){
            $.ajax({
              url: '<?php echo base_url("bpom/Cut_Plan_Con/editCutPlan") ?>', //This is the current doc
              type: "POST",
              data: ({
                'cutPlanId': cutPlanId,
              }),
              success: function (data) {
                if(data != ''){

                  var json_value = JSON.parse(data);

                  //// set number of size to input hidden text field - Need when Add new line ////
                  $('#noOfSize').val(Object.keys(json_value[0]).length);
                  sizeNames = json_value[0];

                  //// set table header element /////
                  $('#date').val(json_value[0][0]['cutPlanDate']);
                  $('#cutPlanName').val(json_value[0][0]['cutPlanName']);
                  $('#remark').val(json_value[0][0]['remark']);
                  $('#cutPlanIdTOEdif').val(cutPlanId);
                  $('#cutting_cp_no').val(json_value[0][0]['cuttingCutPlanNum']);

                  var proceed = json_value[0][0]['proceed'];

                  if(proceed==1){
                    $('.proceeded').removeAttr('hidden','hidden');
                    $('.proceedPending').attr('hidden','hidden');
                  }else{
                    $('.proceeded').attr('hidden','hidden');
                    $('.proceedPending').removeAttr('hidden','hidden');
                  }

                  var htmlForTbHead = "";
                  htmlForTbHead += "<tr>";
                  htmlForTbHead += "<th>PO</th>";
                  htmlForTbHead += "<th>Color</th>";

                  for (var i = 0; i < json_value[0].length; i++) {
                    htmlForTbHead += "<th>"  + json_value[0][i]['size'] +"</th>";
                  }
                  htmlForTbHead += "<th>Total</th>";

                  if(proceed!=1){
                    htmlForTbHead += "<th>Action</th>";
                  }
                  htmlForTbHead += "</tr>";

                  var html='';

                  /// Row count ////
                  var poCount = Object.keys(json_value).length;
                  $('#rowCount').val(poCount);

                for(var y = 0; y < poCount; y++){
                  html += "<tr id='tr"+(y+1)+"'>";
                  html += "<td><select id='delv"+(y+1)+"' class='form-control select-search-tbl wid-200 po' data-placeholder='Select a po' onchange='getColor("+(y+1)+")'><option value='"+json_value[y][0]['po']+"' selected >"+json_value[y][0]['po']+"</option></select></td>";
                  html += "<td><select id='color"+(y+1)+"' class='form-control select-search-tbl wid-150 color' data-placeholder='Select a color' onchange='getOrderQtyEachSize("+(y+1)+")'><option value='"+json_value[y][0]['color']+"' selected>"+json_value[y][0]['color']+"</option></select></td>";
                  var total = 0;
                  for (var i = 0; i <json_value[y].length; i++) {
                    html += "<td><input id='size"+(i+1)+"' value='"+json_value[y][i]['qty']+"' data-sizeName='"+json_value[y][i]['size']+"' type='text' class='size size"+(y+1)+" form-control wid-75 rowSize"+(y+1)+"' onkeyup='getTotal(1);' onkeydown='isNumber(event);'></td>";
                    total += parseInt(json_value[y][i]['qty']);
                  }
                  html += "<td id='total"+(y+1)+"'>"+total+"</td>";
                  if(proceed!=1){
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteLine("+(y+1)+")' ><i class='icon-bin'></i> </button></td>";
                  }
                  html += "</tr>";
                  getTotal((y+1));
                }

                  $('#remark').val('');
                  $('#tblHeadNewCutPlan').empty().append(htmlForTbHead);
                  $('#tblBodyNewCutPlan').empty().append(html);
                  $('.select-search-tbl').select2({ width: 'resolve' });

                  $('#btn_sv').attr('hidden','hidden');
                  $('#btn_upd').removeAttr('hidden','hidden');
                  $('#addCutPlanModel').modal('show');
                }else{
                  $('#tblHeadNewCutPlan').empty();
                }
              },
              error:function (data){

              }
            });
          }else{
            html = "<p>Please Select a Style</p>"
            $("#error").empty().append(html);
            $("#style").focus();
          }
        }

        //// Fire in cutplan add modal ////
        function getDelivery(rowId) {
          // $('#delv'+ rowId +'').empty();
          $('#color'+ rowId +'').empty();
          var style = $('#style').val();
          if (style != '') {
            $.ajax({
              url: '<?php echo base_url("bpom/Cut_Plan_Con/getDelivery")?>', //This is the current doc
              type: "POST",
              data: ({
                'style': style,
              }),
              success: function (data) {
                var html = "<option value=''></option>";
                if(data!='noDelv'){
                  var json_value = JSON.parse(data);

                  for (var i = 0; i < json_value.length; i++) {
                    var rowCount = $('#rowCount').val();
                    var poAlreadySelect = false;
                    for(var x=1;x<=rowCount;x++){
                      if(json_value[i]['po'] == $('#delv'+ x +'').val()){
                        poAlreadySelect = true;
                      }
                    }

                    if(!poAlreadySelect){
                        html += "<option value='" + json_value[i]['po'] + "'>" + json_value[i]['po'] + "</option>";
                    }
                  }
                  $('#delv'+ rowId +'').empty().append(html);
                }else{
                  $('#delv'+ rowId +'').empty();
                }
              }
            });
          }
        }
        function getColor(rowId) {

          if(rowId!=''){
            var style = $('#style').val();
            var delv = $('#delv'+ rowId +'').val();

            if(delv != ''){
              $('#color').empty();
              //// check same Po/Delv is Selecte ////
              var rowCount = $('#rowCount').val();
              var poAlreadySelect = false;
              for(var x=1;x<=rowCount;x++){

                if(rowId != x){
                  if($('#delv'+ rowId +'').val() == $('#delv'+ x +'').val()){
                    poAlreadySelect = true;
                  }
                }
              }

              if(poAlreadySelect){
                swal ( "Oops" ,  "This "+delv+" PO/Del already Selected!" ,  "error" );
                getDelivery(rowId);
                return ;
              }
            }


            if (style != '' &&  poAlreadySelect==false) {
              $.ajax({
                url: '<?php echo base_url("bpom/Cut_Plan_Con/getColor")?>', //This is the current doc
                type: "POST",
                data: ({
                  'style': style,
                  'delv': delv,
                }),
                success: function (data) {
                  var html = "<option value='' selected=\"selected\">&nbsp;</option>";
                  if(data != 'noColor'){
                    var json_value = JSON.parse(data);
                    for (var i = 0; i < json_value.length; i++) {
                      html += "<option value='" + json_value[i]['color'] + "'>" + json_value[i]['color'] + "</option>";
                    }
                    $('#color'+ rowId +'').empty().append(html);
                  }else{
                    $('#color'+ rowId +'').empty();
                  }
                }
              });
            }
          }

        }

        ///  get po and color size wise order qty or balance cut qty /////
        function getOrderQtyEachSize(rowNum){
          var style =  $('#style').val();
          var delv =   $('#delv'+ rowNum +'').val();
          var color =  $('#color'+ rowNum +'').val();

          if(style !=''  && delv !='' && color !=''){
            $.ajax({
              url: '<?php  echo base_url("bpom/Cut_Plan_Con/getOrderQtyEachSize")?>',
              type: "POST",
              data: ({
                'style': style,
                'delv': delv,
                'color': color,
              }),
              success: function (data) {
                if(data!=''){
                  var json_value = JSON.parse(data);

                  for (var i = 0; i < json_value.length; i++) {
                  var sizeName =   $('#tr'+rowNum+' #size'+(i+1)+'').data("sizename");

                  if(sizeName == json_value[i]['cutSize']){
                    var balancQty = 0;
                    if(json_value[i]['balance'] > 0){
                      balancQty = json_value[i]['balance'];
                    }
                     $('#tr'+rowNum+' #size'+(i+1)+'').val(balancQty);
                  }
                }
                  getTotal(rowNum);

                }
              }
            });
          }

        }
        function getTotal(rowNum){
          var total = 0;
          $('.rowSize'+ rowNum +'').each(function(){
            if(this.value !=''){
                total = total + parseInt(this.value) ;
            }
          });

          $('#total'+ rowNum +'').text(total);

        }
        function deleteLine(rowIdB) {
          $('#tr'+rowIdB+' #delv'+rowIdB+'').empty();
          $('#tr'+rowIdB+' #color'+rowIdB+'').empty();
          $('#tr'+rowIdB+' .size'+rowIdB+'').val('');
          $('#tr'+rowIdB+' #total'+rowIdB+'').text('');
          $('#tr'+rowIdB+'').fadeOut();
        }

        function setCutPlan(){
          var style = $('#style').val();
          var cutPlanDate = $('#date').val();
          var cutPlanName = $('#cutPlanName').val();
          var remark = $('#remark').val();
          var sc = $('#sc').val();
          var season = $('#season').val();

          var rowCount = $('#rowCount').val();
          var sizeCount = $('#noOfSize').val();

          var rowData=[];

          var gridDataIsFill = false;
          for(var i=1;i<=rowCount;i++){
            if($('#delv'+i+'').val() =='' || $('#color'+i+'').val() == ''){
              continue;
            }

            var sizeName=[];
            var sizeQty=[];

            for(var x=1;x<=sizeCount;x++){
              sizeName.push($('#tr'+i+' #size'+x+'').data("sizename"));
              sizeQty.push($('#tr'+i+' #size'+x+'').val());
            }

            rowData.push({
              'delv':$('#delv'+i+'').val(),
              'color':$('#color'+i+'').val(),
              'sizeName':sizeName,
              'size':sizeQty,
            });

            gridDataIsFill = true;
          }

          // alert(JSON.stringify(rowData));

          var allData = {
            'style': style,
            'sc': sc,
            'cutPlanData':cutPlanDate,
            'cutPlanName':cutPlanName,
            'season':season,
            'remark':remark,
            'rowData':rowData,
          }

          var data = JSON.stringify(allData);
            // var data = $.param(allData);

          if (style != '' &&  cutPlanDate!='' && cutPlanName != '' && gridDataIsFill == true) {
            $.ajax({
              url: '<?php  echo base_url("bpom/Cut_Plan_Con/setCutPlan")?>', //This is the current doc
              type: "POST",
              data: ({
                'allData':data,
              }),
              success: function (data) {
                  if(data =='Saved'){
                    sweetAlert('Succesfully Saved', '', 'success',{
                      timer: 2000,
                      });
                      $('#addCutPlanModel').modal('hide');
                      resetModel();
                      getCTplanTableData();
                  }else{
                      sweetAlert('Oops!.something went wrong!', 'Try again or get IT Support', 'error');
                  }
              }
            });
          }

        }
        function UpdateCutPlan(){
          var cutPlanId = $('#cutPlanIdTOEdif').val();
          var style = $('#style').val();
          var cutPlanDate = $('#date').val();
          var remark = $('#remark').val();
          var sc = $('#sc').val();
          var season = $('#season').val();

          var rowCount = $('#rowCount').val();
          var sizeCount = $('#noOfSize').val();

          var rowData=[];

          for(var i=1;i<=rowCount;i++){

            if($('#delv'+i+'').val() =='' || $('#color'+i+'').val() == ''){
              continue;
            }

            var sizeName=[];
            var sizeQty=[];

            for(var x=1;x<=sizeCount;x++){
              sizeName.push($('#tr'+i+' #size'+x+'').data("sizename"));
            }

            for(var x=1;x<=sizeCount;x++){
              sizeQty.push($('#tr'+i+' #size'+x+'').val());
            }

            rowData.push({
              'delv':$('#delv'+i+'').val(),
              'color':$('#color'+i+'').val(),
              'sizeName':sizeName,
              'size':sizeQty,
            })
          }

          // alert(JSON.stringify(rowData));

          var allData = {
            'cutPlanId':cutPlanId,
            'cutPlanData':cutPlanDate,
            'remark':remark,
            'rowData':rowData,
          }

          var data = JSON.stringify(allData);
            // var data = $.param(allData);

          if (style != '' &&  cutPlanDate!='' && cutPlanName != '') {
            $.ajax({
              url: '<?php  echo base_url("bpom/Cut_Plan_Con/updateCutPlan")?>', //This is the current doc
              type: "POST",
              data: ({
                'allData':data,
              }),
              success: function (data) {
                  if(data =='Updated'){
                    sweetAlert('Succesfully Updated', '', 'success',{
                      timer: 2000,
                      });
                      $('#addCutPlanModel').modal('hide');
                      resetModel();
                      getCTplanTableData();
                  }else{
                      sweetAlert('Oops!.something went wrong!', 'Try again or get IT Support', 'error');
                  }
              }
            });
          }

        }



</script>
