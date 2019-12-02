<!-- Main content -->
<div class="content-wrapper">
  <!-- Page header -->
  <div class="page-header page-header-light">
      <div class="page-header-content header-elements-md-inline">
          <div class="page-title d-flex">
              <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Style Information</span> - Add
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
                  <a href="<?php echo base_url('Location_Dashboard_Con');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                  <span class="breadcrumb-item active">style_info</span>
              </div>
              <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
          </div>

      </div>
  </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">
          <div class="card">
            <div class="card-header bg-white header-elements-inline">
              <h6 class="card-title">Select Buyer Information</h6>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                  <a class="list-icons-item" data-action="reload"></a>
                  <a class="list-icons-item" data-action="remove"></a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form class="wizard-form steps-state-saving wizard clearfix"   data-fouc="" id="steps-uid-2" role="application">
                <div class="steps clearfix"></div>
                <div class="content clearfix">
                  <fieldset id="steps-uid-2-p-0" role="tabpanel" aria-labelledby="steps-uid-2-h-0" class="body current" aria-hidden="false" style="">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Buyer Name</label>
                          <select id="id_buyer" name="id_buyer" class="form-control select select-search" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-fouc data-placeholder="Select Style Name" onChange="getSeason();">
                            <option value=""></option>
                            <?php foreach($buyer as $row){
                              ?>
                              <option value="<?php echo $row->buyer; ?>"> <?php echo $row->buyer; ?> </option>
                              <?php
                            }?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Season Name</label>
                          <select id ="id_season" name="id_season" class="form-control select" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-fouc data-placeholder="Select Season Name" onChange="getStyle();enable_fields();">
                          </select>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-header bg-white header-elements-inline">
              <h6 class="card-title">Enter Style Information</h6>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                  <a class="list-icons-item" data-action="reload"></a>
                  <a class="list-icons-item" data-action="remove"></a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form class="wizard-form steps-state-saving wizard clearfix"   data-fouc="" id="steps-uid-2" role="application">
                <div class="steps clearfix"></div>
                <div class="content clearfix">
                  <fieldset id="steps-uid-2-p-0" role="tabpanel" aria-labelledby="steps-uid-2-h-0" class="body current" aria-hidden="false" style="">
                    <div class="row">

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Style Name</label>
                          <select class="enable_fields1 form-control select select-search" id="s_name" name="s_name" disabled="" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-fouc data-placeholder="Select Style Name" onChange="getSC_and_Delivery()">
                          </select>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>SC Number</label>
                          <input type="text" name="sc" id="sc"  disabled="" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="SC Number" >
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Merchant</label>
                          <input type="text" name="merchant" id="merchant" class="enable_fields1 form-control bg-slate-600 border-slate-600 border-1" placeholder="Merchant" readonly>
                        </div>
                      </div>

                    </div>

                  </fieldset>

                  <fieldset id="steps-uid-2-p-0" role="tabpanel" aria-labelledby="steps-uid-2-h-0" class="body current" aria-hidden="false" style="">
                    <div class="row">

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>PO Number</label>
                          <select class="enable_fields1 form-control select" id="po" name="po" disabled="" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-fouc data-placeholder="Select PO Numner" onChange=getDelvDateAndColor();getStyleData();>

                          </select>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Delivery Date</label>
                          <input type="date" name="delDate" id="delDate" readonly class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Delivery Date" >
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Colour</label>
                          <select class="enable_fields1 form-control select" id="color" name="color" disabled="" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-fouc data-placeholder="Select Color" onChange=getSizeAndOrderQty()>

                          </select>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Color Order Qty</label>
                          <input type="text" name="orderQty" id="orderQty"  readonly="" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Color Order Qty" >
                        </div>
                      </div>

                      <div class="col-md-1">
                        <div class="form-group">
                          <label>Size</label>
                          <select class="enable_fields1 form-control select" id ="id_size" name="id_size" disabled="" data-container-css-class="bg-slate" data-dropdown-css-class="bg-slate" data-fouc data-placeholder="Select Size" onChange="getQtyAndAccellerId();">

                          </select>
                        </div>
                      </div>

                      <div class="col-md-1">
                        <div class="form-group">
                          <label>QTY</label>
                          <input type="text" id="qtyID" name="qtyID" readonly="" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="QTY" >
                        </div>
                      </div>
                    </div>

                    <div class="text-right">
                      <button type="button" id="save" name="save" class="btn btn-primary" onClick="saveData();">Save<i class="icon-paperplane ml-2"></i> </button>
                      <button type="reset" class="btn btn-warning">Reset<i class="icon-reset ml-2"></i> </button>
                    </div>
                  </fieldset>
                </div>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-header header-elements-inline">
              <h5 class="card-title"></h5>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                  <a class="list-icons-item" data-action="reload"></a>
                  <a class="list-icons-item" data-action="remove"></a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <fieldset class="mb-3">
                  <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                  <table class="table datatable-basic">
                      <thead>
                      <tr>
                          <th>Buyer</th>
                          <th>Season</th>
                          <th>Style</th>
                          <th>SC</th>
                          <th>PO</th>
                          <th>Color</th>
                          <th>Size</th>
                          <th>Qty</th>
                          <th>Merchant</th>
                          <th class="text-center">Actions</th>
                      </tr>
                      </thead>
                      <tbody id="stylInfo">

                      </tbody>
                  </table>
              </fieldset>
            </div>
          </div>

          <input type="hidden" id="delvType" name="delvType" value="">
          <input type="hidden" id="csrNo" name="csrNo" value="">
          <input type="hidden" id="accllerId" name="accllerId">
        </div>

        <script>
        //
        $('.dataTableCus').DataTable( {
          "ordering": false,
          "scrollX": true
        });

        function resetAllStyleInfo(){
          $('#s_name').empty();
          $('#sc').val('');
          $('#merchant').val('');
          $('#po').empty();
          $('#delDate').val('');
          $('#color').empty('');
          $('#colorOrderQty').val('');
          $('#id_size').empty();
          $('#qtyID').val('');
        }

        function getSeason(){
          var name_buyer=$('#id_buyer').val();

          resetAllStyleInfo();

          $('#id_season').empty();

          if(id_buyer !=''){
            $.ajax({
              url:'<?php echo base_url("bpom/Style_info_Con/getSeason_con")?>',
              type:'POST',
              data:{
                'mod_name_buyer':name_buyer
              },
              success:function(respons){
                if(respons != 'noSeason'){
                  var html = "<option value='' selected=\"selected\">&nbsp;</option>";

                  var json_value = JSON.parse(respons);

                  for (var i = 0; i < json_value.length; i++) {
                    html += "<option value='" + json_value[i]['season'] + "'>" + json_value[i]['season'] + "</option>";
                  }
                  $('#id_season').empty().append(html);
                }
              },
              error:function(error){
                alert('this is the error');
              }
            });
          }
        }

        function getStyle(){
          var buyer=$('#id_buyer').val();
          var season=$('#id_season').val();

          resetAllStyleInfo();

          if(buyer!="" && season!=""){
            $.ajax({
              url:'<?php echo base_url("bpom/Style_info_Con/getStyle")?>',
              type:'POST',
              data:{
                'buyer':buyer,
                'season':season,
              },
              success:function(respons){
                if(respons != 'noStyle'){
                  var html = "<option value='' selected=\"selected\">&nbsp;</option>";

                  var json_value = JSON.parse(respons);

                  for (var i = 0; i < json_value.length; i++) {
                    html += "<option value='" + json_value[i]['style'] + "'>" + json_value[i]['style'] + "</option>";
                  }
                  $('#s_name').empty().append(html);
                }
              },
              error:function(error){
                alert('this is the error');
              }
            });
          }
        }

        function getSC_and_Delivery(){
          $('#sc').val('');
          $('#merchant').val('');
          $('#po').empty();
          $('#delDate').val('');
          $('#color').empty('');
          $('#orderQty').val('');
          $('#id_size').empty();
          $('#qtyID').val('');

          var style=$('#s_name').val();
          if(style!=""){
            $.ajax({
              url:'<?php echo base_url("bpom/Style_info_Con/getSC_and_Delivery_con")?>',
              type:'POST',
              data:{
                'style_name_view':style
              },
              success:function(respons){
                if(respons != 'noData'){
                  var html = "<option value='' selected=\"selected\">&nbsp;</option>";

                  var json_value = JSON.parse(respons);

                  for (var i = 0; i < json_value.length; i++) {
                    html += "<option value='" + json_value[i]['po'] + "'>" + json_value[i]['po'] + "</option>";
                  }
                  $('#csrNo').val(json_value[0]['csrNo']);
                  $('#sc').val(json_value[0]['sc']);
                  $('#merchant').val(json_value[0]['merchant']);
                  $('#po').empty().append(html);
                }
              },
              error:function(error){
                alert('this is the error');
              }
            });
          }
        }

        // ---------------------------enable fields----------------------------------------------------------------
        function enable_fields(){
          $('.enable_fields1').removeAttr('disabled','disabled')
        }
        // ---------------------------enable fields----------------------------------------------------------------

        function getDelvDateAndColor(){

          $('#delDate').val('');
          $('#color').empty('');
          $('#orderQty').val('');
          $('#id_size').empty();
          $('#qtyID').val('');

          var style=$('#s_name').val();
          var po=$('#po').val();

          if(style!="" && po!=""){
            $.ajax({
              url: '<?php echo base_url("bpom/Style_info_Con/getDelvDateAndColor")?>',
              type:'POST',
              data:{
                'style_name_view':style,
                'po':po,
              },
              success:function(respons){
                if(respons != 'noData'){
                  var html = "<option value='' selected=\"selected\">&nbsp;</option>";
                  var json_value = JSON.parse(respons);
                  for (var i = 0; i < json_value.length; i++) {
                    html += "<option value='" + json_value[i]['color'] + "'>" + json_value[i]['color'] + "</option>";
                  }delvType
                  $('#delDate').val(json_value[0]['delvDate']);
                  $('#delvType').val(json_value[0]['delvType']);
                  $('#color').empty().append(html);
                }
              },
              error:function(error){
                alert('this is the error');
              }
            });
          }
        }

        function getSizeAndOrderQty(){
          $('#orderQty').val('');
          $('#id_size').empty();
          $('#qtyID').val('');

          var style=$('#s_name').val();
          var po=$('#po').val();
          var color=$('#color').val();

          if (color!=""){
            $.ajax({
              url: '<?php echo base_url("bpom/Style_info_Con/getSizeAndOrderQty")?>',
              type:'POST',
              data:{
                'style_name_view':style,
                'po':po,
                'color':color,
              },
              success:function(respons){

                if(respons != 'noData'){
                  var html = "<option value='' selected=\"selected\">&nbsp;</option>";

                  var json_value = JSON.parse(respons);

                  for (var i = 0; i < json_value.length; i++) {
                    html += "<option value='" + json_value[i]['size'] + "'>" + json_value[i]['size'] + "</option>";
                  }
                  $('#orderQty').val(json_value[0]['orderQty']);
                  $('#id_size').empty().append(html);

                }
              },
              error:function(error){
                alert('this is the error');
              }
            })
          }

        }

        function getQtyAndAccellerId(){
          $('#qtyID').val('');

          var style=$('#s_name').val();
          var po=$('#po').val();
          var color=$('#color').val();
          var size=$('#id_size').val();

          if (size!=""){
            $.ajax({
              url: '<?php echo base_url("bpom/Style_info_Con/getQtyAndAccellerId")?>',
              type:'POST',
              data:{
                'style_name_view':style,
                'po':po,
                'color':color,
                'size':size,
              },
              success:function(respons){

                if(respons != 'noData'){
                  var json_value = JSON.parse(respons);
                  $('#qtyID').val(json_value['0']['qty']);
                  $('#accllerId').val(json_value['0']['id']);
                }
              },
              error:function(error){
                alert('this is the error');
              }
            })
          }

        }

        // --------------------------------------------------- add Style not conpleate---------------------------------------------------------------------

        function saveData(){
          var accllerId = $('#accllerId').val();
          var buyer = $('#id_buyer').val();
          var season = $('#id_season').val();
          var style=$('#s_name').val();
          var sc=$('#sc').val();
          var po=$('#po').val();
          var color=$('#color').val();
          var orderQty=$('#orderQty').val();
          var size=$('#id_size').val();
          var qty = $('#qtyID').val();
          var delDate = $('#delDate').val();
          var delType = $('#delvType').val();
          var csrNo = $('#csrNo').val();
          var merchant = $('#merchant').val();

          if(id_buyer!='' && season !='' && style!='' && po !='' && color!='' && size !=''){

            $.ajax({
              url:'<?php echo base_url("bpom/Style_info_Con/insertData")?>',
              type:'POST',
              data:{
                'accllerId':accllerId,
                'buyer': buyer,
                'season':season,
                's_name':style,
                'sc':sc,
                'po':po,
                'color':color,
                'orderQty':orderQty,
                'size':size,
                'qty':qty,
                'delDate': delDate,
                'delType':delType,
                'csrNo':csrNo,
                'merchant':merchant,
              },
              success:function(data){
                if(data=="added"){
                  sweetAlert('Saved', '', 'success');
                  getSizeAndOrderQty();
                  getStyleData();
                }else{
                  sweetAlert('Oops!. Not Saved.Try Again!', '', 'warning');
                }
              },
              error:function(data){
              sweetAlert('Oops!. There is network problem', '', 'error');
              }
            });
          }else{
            sweetAlert('Please Fill the all textbox', '', 'warning');
          }
        }

        function getStyleData() {
          var style=$('#s_name').val();
          var po=$('#po').val();
          $.ajax({
            url:'<?php echo base_url("bpom/Style_info_Con/getTableData")?>',
            type:'POST',
            data:{
              'style':style,
              'po':po
            },
            success:function(data){

              if(data != ''){
                var html = "";
                var json_value = JSON.parse(data);

                for (var i = 0; i < json_value.length; i++) {
                  html += "<tr>";
                  html += "<td>" + json_value[i]['buyer'] + "</td>";
                  html += "<td>"  + json_value[i]['season'] +"</td>";
                  html += "<td>"  + json_value[i]['style_name'] +"</td>";
                  html += "<td>"  + json_value[i]['sc'] +"</td>";
                  html += "<td>"  + json_value[i]['po'] +"</td>";
                  html += "<td>"  + json_value[i]['color'] +"</td>";
                  html += "<td>"  + json_value[i]['size'] +"</td>";
                  html += "<td>"  + json_value[i]['qty'] +"</td>";
                  html += "<td>"  + json_value[i]['merchant'] +"</td>";
                  html += "<td style='text-align:center;'><button type='button' class='btn btn-warning' onclick='deleteRowConfirm("+json_value[i]['id']+")' ><i class='icon-bin'></i> </button></td>";
                  html += "</tr>";
                }

                $('#stylInfo').empty().append(html);
              }else{
                $('#stylInfo').empty();
              }
            },
            error:function(data){
              alert("loss connection");
            }
          });
        }

        function deleteRowConfirm(id){
          swal("Are You sure to delete this row ?", {
            buttons: {
              cancel: "No!",
              catch: {
                text: "Yes!",
                value: "delete",
              },
            },
          })
          .then((value) => {
            switch (value) {
              case "delete":
              deleteRow(id);
              break;
            }
          });

        }

        function deleteRow(id){

          if (id!=""){
            $.ajax({
              url: '<?php echo base_url("bpom/Style_info_Con/deleteRow")?>',
              type:'POST',
              data:{
                'id':id,
              },
              success:function(respons){

                if(respons == 'deleted'){
                  sweetAlert('Succesfully Deleted', '', 'success',{
                    timer: 2000,
                    });
                  getSizeAndOrderQty();
                  getStyleData();
                }else{
                  sweetAlert('Oops!. Not Deleted.Try Again!', '', 'warning');
                }
              },
              error:function(error){
                  sweetAlert('Oops!. Thare is a NetworK problem!', '', 'error');
              }
            })
          }

        }


        </script>
