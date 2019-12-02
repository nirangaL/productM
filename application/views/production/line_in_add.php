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
        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Line In</span>
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
                <span class="breadcrumb-item active">Line In Data</span>
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
                  <select id="style" name="style" class="form-control select-search" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-placeholder="Select a Style" onchange="getSeason();getSavedData();" data-fouc required>
                    <option value=""></option>
                    <?php foreach ($style as $row) {
                      ?>
                      <option value="<?php echo $row->style; ?>" > <?php echo $row->style.' - '.$row->sc ; ?> </option>
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
                      <th>In Date</th>
                      <th>Team</th>
                      <th>Ref Number</th>
                      <th>Total Qty</th>
                      <th>Remark</th>
                      <th>Create D.T.</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="cutOut">

                  </tbody>
                </table>
              </div>

              <div class="col-sm-12 text-right" style="margin-top:20px;">
                <button class="btn btn-primary" onclick="addData();"><i class="icon-ungroup"></i> New Line In</button>
              </div>
            </div>
          </div>
          <!-- /card  -->
        </div>
        <!-- /content area -->

        <!-- Add Cut plan modal -->
        <div id="addDataTblModel" class="modal fade" tabindex="-1" data-toggle="modal" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-full">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">New Line In </h5>
                <button type="button" class="close" data-dismiss="modal" onclick="resetModel();">&times;</button>
              </div>
              <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
              <div class="modal-body">

                <div class="form-group row">
                  <label class="col-form-label col-sm-1">Line In Date :</label>
                  <div class="col-sm-3">
                    <input id="date" name="date" type="text" class="form-control datepick bg-slate-600 border-slate-600 border-1" value="<?php echo date('Y-m-d');?>" placeholder="Select a date …">
                  </div>
                  <!-- <div class="col-sm-1"></div> -->
                  <label class="col-form-label col-sm-1">Ref Number :</label>
                  <div class="col-sm-1">
                    <input id="refNumber" name="refNumber" type="text" class="form-control bg-slate-600 border-slate-600 border-1" readonly>
                  </div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-2">
                  <!-- <section class="proceeded" hidden>
                      <img src="<?php// echo base_url('assets/images/proceed lbl.jpg');?>" alt="This Cut Plan is Proceed" class="proceedLbl">
                  </section> -->
                  </div>

                </div>
                <div class="form-group row">
                  <label class="col-form-label col-sm-1">Remarks :</label>
                  <div class="col-sm-3">
                    <textarea id='remark' class="form-control bg-slate-600 border-slate-600 border-1" style="height:50px;"></textarea>
                  </div>

                  <label class="col-form-label col-sm-1">Team :</label>
                  <div class="col-sm-2">
                    <select id="teamId" name="teamId" class="form-control select-search" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-placeholder="Select a Team" onchange="getSeason();getSavedData();" data-fouc required>
                      <option value=""></option>
                      <?php foreach ($team as $row) {
                        ?>
                        <option value="<?php echo $row->line_id; ?>" > <?php echo $row->line; ?> </option>
                        <?php
                      } ?>
                    </select>
                      <span id="errorTeam" class="error"></span>
                  </div>

                    <!-- <label class="col-form-label col-sm-2 proceeded"  hidden>Cutting Cut-Plan Nu :</label>
                    <div class="col-sm-2 proceeded" hidden>
                      <input id="cutting_cp_no" name="cutting_cp_no" type="text" class="form-control bg-slate-600 border-slate-600 border-1 " readonly>
                    </div> -->
                </div>

                <div class="table-responsive">
                  <table  class="table table-dark bg-slate-600">
                    <thead id="tblHeadNew">
                      <tr>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="tblBodyNew">
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
                  <button type="button" id="btn_sv" class="btn bg-primary" onclick="setData();">Save <i class="icon-paperplane ml-2"></i></button>
                  <button type="button" id="btn_upd" class="btn bg-purple" onclick="updateData();" hidden>Update <i class="icon-rotate-cw3 ml-2" ></i></button>
                </section>
                <!-- <section class="proceeded" hidden>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="resetModel();">Close</button>
                </section> -->
              </div>



            </div>
          </div>
        </div>

        <input id="rowCount" type="hidden" value="1">
        <input id="noOfSize" type="hidden" value="0">
        <input id="sc" type="hidden" value="">
        <input id="editId" type="hidden" value="0">
        <!-- /Add Cut Plan modal -->


        <script>

        var sizeNames  = '';
        $(document).ready(function () {

          $('.datepick').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'yyyy-mm-dd',
          });

        // var dataTbl =  $('#cutPlanTbl').DataTable( {
        //     "scrollX": true
        //   } );
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
              url: '<?php echo base_url("production/Line_In_Con/getSeason")?>',
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

        function getSavedData() {
          var style = $('#style').val();
          $('#cutOut').empty();
          if (style != '') {
            $.ajax({
              url: '<?php echo base_url("production/Line_In_Con/getSavedData")?>', //This is the current doc
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
                  html += "<td>" + json_value[i]['proccedDate'] + "</td>";
                  html += "<td>" + json_value[i]['teamName'] + "</td>";
                  html += "<td>"  + json_value[i]['refNum'] +"</td>";
                  html += "<td>"  + json_value[i]['totalQty'] +"</td>";
                  html += "<td>"  + json_value[i]['remark'] +"</td>";
                  html += "<td>"  + json_value[i]['createDate'] +"</td>";
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning btn-sm' onclick='editData("+ json_value[i]['id'] +");' >View & Edit</td>";
                  html += "</tr>";
                }

                $('#cutOut').empty().append(html);
                // dataTbl();
              }else{
                $('#cutOut').empty();
              }
              },
              error:function (data){
                sweetAlert('Oops!.There is an issue in Network!', 'Try again or get IT Support', 'error');
              }
            });
          }
        }

        function getRefNumber() {
          var style = $('#style').val();
          $.ajax({
            url: '<?php  echo base_url("production/Line_In_Con/getRefNumber")?>',
            type: "POST",
            data: ({
              'style': style,
            }),
            success: function (data) {
              if(data!=''){
                $('#refNumber').val(data);
              }
            }
          });
        }

        ///// create table set as sizes
        function addData(){
          var style = $('#style').val();

          if(style != ''){

            $.ajax({
              url: '<?php echo base_url("production/Line_In_Con/getStyleData") ?>', //This is the current doc
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
                    html += "<td><input id='size"+(i+1)+"'  data-sizeName='"+json_value[i]['size']+"' type='text' class='size size1 form-control wid-75 rowSize1' onkeyup='getTotal(1);checkWithBalance(this);' onkeydown='isNumber(event);'></td>";
                  }
                  html += "<td id='total1'></td>";
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteLine(1)' ><i class='icon-bin'></i> </button></td>";
                  html += "</tr>";


                  getRefNumber();
                  $('#remark').val('');
                  $('#teamId').removeAttr('disabled','disabled');
                  $('#teamId').val(null).trigger('change');

                  $('#tblHeadNew').empty().append(htmlForTbHead);
                  $('#tblBodyNew').empty().append(html);
                  getDelivery(1);
                  $('#btn_sv').removeAttr('hidden','hidden');
                  $('#btn_upd').attr('hidden','hidden');
                  $('.select-search-tbl').select2({ width: 'resolve' });
                  $('#addDataTblModel').modal('show');
                }else{
                  $('#tblHeadNew').empty();
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
            html += "<td><select id='color"+(newRowNum)+"' class='form-control select-search-tbl wid-150 color' data-placeholder='Select a color' onchange='getOrderQtyEachSize("+newRowNum+")'></select></td>";


            for (var i = 0; i < sizeNames.length; i++) {
              html += "<td><input id='size"+(i+1)+"'  data-sizename='"+sizeNames[i]['size']+"' type='text' class='size size"+(newRowNum)+" form-control wid-75 rowSize"+(newRowNum)+"' onkeyup='getTotal("+newRowNum+");checkWithBalance(this);' onkeydown='isNumber(event);'></td>";
            }
            html += "<td id='total"+(newRowNum)+"'></td>";
            html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteLine("+(newRowNum)+")' ><i class='icon-bin'></i> </button></td>";
            html += "</tr>";

            $('#tblBodyNew').append(html);
            $('#rowCount').val(newRowNum);
            getDelivery(newRowNum);
            $('.select-search-tbl').select2({ width: 'resolve' });

        }

        function editData(id){

          if(id != ''){
            $.ajax({
              url: '<?php echo base_url("production/Line_In_Con/editData") ?>', //This is the current doc
              type: "POST",
              data: ({
                'id': id,
              }),
              success: function (data) {
                if(data != ''){
                  $('#remark').val('');
                  var json_value = JSON.parse(data);

                  //// set number of size to input hidden text field - Need when Add new line ////
                  $('#noOfSize').val(Object.keys(json_value[0]).length);
                  sizeNames = json_value[0];

                  //// set table header element /////
                  $('#date').val(json_value[0][0]['proccedDate']);
                  $('#refNumber').val(json_value[0][0]['refNum']);
                  $('#remark').val(json_value[0][0]['remark']);
                  $('#editId').val(id);

                  // $('#teamId').val();
                  // $("#teamId").select2("val", json_value[0][0]['teamId']);
                  $("#teamId").val(json_value[0][0]['teamId']).trigger('change');
                  $('#teamId').attr('disabled','disabled');

                  $('.select-search').select2();

                  // var proceed = json_value[0][0]['proceed'];
                  //
                  // if(proceed==1){
                  //   $('.proceeded').removeAttr('hidden','hidden');
                  //   $('.proceedPending').attr('hidden','hidden');
                  // }else{
                  //   $('.proceeded').attr('hidden','hidden');
                  //   $('.proceedPending').removeAttr('hidden','hidden');
                  // }

                  var htmlForTbHead = "";
                  htmlForTbHead += "<tr>";
                  htmlForTbHead += "<th>PO</th>";
                  htmlForTbHead += "<th>Color</th>";

                  for (var i = 0; i < json_value[0].length; i++) {
                    htmlForTbHead += "<th>"  + json_value[0][i]['size'] +"</th>";
                  }
                  htmlForTbHead += "<th>Total</th>";

                  // if(proceed!=1){
                    htmlForTbHead += "<th>Action</th>";
                  // }
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
                    html += "<td><input id='size"+(i+1)+"' value='"+json_value[y][i]['qty']+"'  data-sizeName='"+json_value[y][i]['size']+"' type='text' class='size size"+(y+1)+" form-control wid-75 rowSize"+(y+1)+"' onkeyup='getTotal(1);checkWithBalance(this);' onkeydown='isNumber(event);'></td>";
                    total += parseInt(json_value[y][i]['qty']);
                  }
                  html += "<td id='total"+(y+1)+"'>"+total+"</td>";
                  // if(proceed!=1){
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteLine("+(y+1)+")' ><i class='icon-bin'></i> </button></td>";
                  // }
                  html += "</tr>";

                  getOrderQtyEachSizeUpdate((y+1),json_value[y][0]['po'],json_value[y][0]['color']);
                  getTotal((y+1));
                }



                  $('#tblHeadNew').empty().append(htmlForTbHead);
                  $('#tblBodyNew').empty().append(html);
                  $('.select-search-tbl').select2({ width: 'resolve' });

                  $('#btn_sv').attr('hidden','hidden');
                  $('#btn_upd').removeAttr('hidden','hidden');
                  $('#addDataTblModel').modal('show');
                }else{
                  $('#tblHeadNew').empty();
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
              url: '<?php echo base_url("production/Line_In_Con/getDelivery")?>', //This is the current doc
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

              $('.size'+ rowId +'').val('');
              $('.size'+ rowId +'').removeAttr('data-balance');
              $('.size'+ rowId +'').attr('data-balance','0');
              $('.size'+ rowId +'').css('background-color','white');

              $('.size'+ rowId +'').removeAttr('data-validity');
              $('.size'+ rowId +'').attr('data-validity','true');
              $('.size'+ rowId +'').attr('data-balance','0');


            }


            if (style != '' &&  poAlreadySelect==false) {
              $.ajax({
                url: '<?php echo base_url("production/Line_In_Con/getColor")?>', //This is the current doc
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

        ///  get po and color size wise order qty and balance cut qty /////
        function getOrderQtyEachSize(rowNum){

          var style =  $('#style').val();
          var delv =   $('#delv'+ rowNum +'').val();
          var color =  $('#color'+ rowNum +'').val();


          if(style !=''  && delv !='' && color !=''){
            $.ajax({
              url: '<?php  echo base_url("production/Line_In_Con/getOrderQtyEachSize")?>',
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

                  if(sizeName == json_value[i]['size']){
                    var balancQty = 0;
                    if(json_value[i]['balance'] > 0){
                      balancQty = json_value[i]['balance'];
                    }
                     // $('#tr'+rowNum+' #size'+(i+1)+'').val(balancQty);
                     $('#tr'+rowNum+' #size'+(i+1)+'').attr('data-balance',balancQty);
                     // $('#tr'+rowNum+' #size'+(i+1)+'').data('balance',balancQty);
                  }
                }
                  // getTotal(rowNum);

                }
              }
            });
          }

        }

        function getOrderQtyEachSizeUpdate(rowNum,delv,color){
          var style =  $('#style').val();

          if(style !=''  && delv !='' && color !=''){
            $.ajax({
              url: '<?php  echo base_url("production/Line_In_Con/getOrderQtyEachSize")?>',
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
                  var savedQty =   parseInt($('#tr'+rowNum+' #size'+(i+1)+'').val());

                  if(sizeName == json_value[i]['size']){
                    var balancQty = 0;
                    if(json_value[i]['balance'] > 0){
                      balancQty = parseInt(json_value[i]['balance']);
                    }
                     // $('#tr'+rowNum+' #size'+(i+1)+'').val(balancQty);
                     $('#tr'+rowNum+' #size'+(i+1)+'').attr('data-balance',(balancQty+savedQty));
                     // $('#tr'+rowNum+' #size'+(i+1)+'').data('balance',balancQty);
                  }
                }
                  // getTotal(rowNum);

                }
              }
            });
          }
        }

        /// get total qty of eache po ///
        function getTotal(rowNum){
          var total = 0;
          $('.rowSize'+ rowNum +'').each(function(){
            if(this.value !=''){
                total = total + parseInt(this.value) ;
            }
          });

          $('#total'+ rowNum +'').text(total);

        }

        //// delete line/row in grid ////
        function deleteLine(rowIdB) {
          $('#tr'+rowIdB+' #delv'+rowIdB+'').empty();
          $('#tr'+rowIdB+' #color'+rowIdB+'').empty();
          $('#tr'+rowIdB+' .size'+rowIdB+'').val('');
          $('#tr'+rowIdB+' .size'+rowIdB+'').removeAttr('data-balance');
          $('#tr'+rowIdB+' .size'+rowIdB+'').removeAttr('data-validity');
          $('#tr'+rowIdB+' #total'+rowIdB+'').text('');
          $('#tr'+rowIdB+'').fadeOut();
        }

        ///save grid data ///
        function setData(){
          var style = $('#style').val();
          var date = $('#date').val();
          var refNumber = $('#refNumber').val();
          var remark = $('#remark').val();
          var sc = $('#sc').val();
          var season = $('#season').val();
          var teamId = $('#teamId').val();

          var rowCount = $('#rowCount').val();
          var sizeCount = $('#noOfSize').val();



          /// check the enterd qty is not grater than the cut qty! ///
          if(checkQtyValidity(rowCount,sizeCount)){

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

                if($('#tr'+i+' #size'+x+'').val() != ''){
                  gridDataIsFill = true;
                }
              }

              rowData.push({
                'delv':$('#delv'+i+'').val(),
                'color':$('#color'+i+'').val(),
                'sizeName':sizeName,
                'size':sizeQty,
              });
            }

            // alert(JSON.stringify(rowData));

            var allData = {
              'style': style,
              'sc': sc,
              'date':date,
              'refNumber':refNumber,
              'season':season,
              'teamId':teamId,
              'remark':remark,
              'rowData':rowData,
            }

            var data = JSON.stringify(allData);

            // var data = $.param(allData);

            if (teamId != ''){
              if (gridDataIsFill == true) {
                $.ajax({
                  url: '<?php  echo base_url("production/Line_In_Con/setData")?>', //This is the current doc
                  type: "POST",
                  data: ({
                    'allData':data,
                  }),
                  success: function (data) {
                    if(data =='Saved'){
                      sweetAlert('Succesfully Saved', '', 'success',{
                        timer: 2000,
                      });
                      $('#addDataTblModel').modal('hide');
                      resetModel();
                      getSavedData();
                    }else{
                      sweetAlert('Oops!.something went wrong!', 'Try again or get IT Support', 'error');
                    }
                  }
                });
              }
            }else{
              $('#errorTeam').text('Please Select a Team');
              $('#errorTeam').focus();
            }
          }else{
            sweetAlert('Opps!', 'You Can not enter the qty more than Cut qty!', 'error');
          }


        }

        ///// update grid data ///
        function updateData(){
          var editId = $('#editId').val();
          var style = $('#style').val();
          var date = $('#date').val();
          var remark = $('#remark').val();
          var sc = $('#sc').val();
          var season = $('#season').val();

          var rowCount = $('#rowCount').val();
          var sizeCount = $('#noOfSize').val();

          /// check the enterd qty is not grater than the cut qty! ///
          if(checkQtyValidity(rowCount,sizeCount)){
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
              'editId':editId,
              'date':date,
              'remark':remark,
              'rowData':rowData,
            }

            var data = JSON.stringify(allData);
            // var data = $.param(allData);

            if (style != '' &&  date!='') {
              $.ajax({
                url: '<?php  echo base_url("production/Line_In_Con/updateData")?>', //This is the current doc
                type: "POST",
                data: ({
                  'allData':data,
                }),
                success: function (data) {
                  if(data =='Updated'){
                    sweetAlert('Succesfully Updated', '', 'success',{
                      timer: 2000,
                    });
                    $('#addDataTblModel').modal('hide');
                    resetModel();
                    getSavedData();
                  }else{
                    sweetAlert('Oops!.something went wrong!', 'Try again or get IT Support', 'error');
                  }
                }
              });
            }

          }else{
            sweetAlert('Opps!', 'You Can not enter the qty more than Cut qty!', 'error');
          }

        }

        $('#teamId').change(function(){
          if($('#teamId').val!=''){
            $('#errorTeam').text('');
          }

        });

        ////// Check user enterd qty is not increase than cut qty ///////
        function checkWithBalance(txtField){
          var enterVal = $(txtField).val();
          var balance = $(txtField).data('balance');

          if(balance != undefined){
            if(enterVal > balance){
              // text field validate as false and fill background red ////
              $(txtField).css('background-color','red');
              $(txtField).attr('data-validity','false');
            }else{
                // text field validate as true and fill background default ////
              $(txtField).css('background-color','white');
              $(txtField).attr('data-validity','true');
            }
          }else{
            $(txtField).css('background-color','white');
            $(txtField).attr('data-validity','true');
          }

        }


        function checkQtyValidity(rowCount,sizeCount){
          var validity = true;

          for(var i=1;i<=rowCount;i++){
            for(var x=1;x<=sizeCount;x++){
              var validityCheck = $('#tr'+i+' #size'+x+'').data('validity');
              // alert(validityCheck);
                if(validityCheck != undefined){
                  if(validityCheck == false){
                   validity = false;
                  }
                }
            }
          }

          return validity;
        }

</script>
