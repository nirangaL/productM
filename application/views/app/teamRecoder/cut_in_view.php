<style>
    th{
        text-align: center;
    }
    td{
        text-align: center;
        font-weight:bold;
    }
    .width-15{
        width:75px;
    }

label {
    display: inline-block;
    margin-top: 9px;
}

input[type=number]{
    text-align: right;
}
</style>

<!-- Main content -->
<div class="content-wrapper animated zoomIn">
    <!-- Content area -->
    <div class="content">
        <div class=".se-pre-con"> </div>
        <!-- Form inputs -->
        <div class="card">
            <div class="card-header header-elements-block text-center" style="padding-bottom: 0px;padding-top: 10px;">
               <h4>Line In</h4>
            </div>

            <div class="card-body">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                    <div class="form-group row">
                        <label class="form-label-sm col-2">Style :</label>
                        <div class="col-10">
                            <select id="style" name="style" class="form-control-lg  select-search" data-container-css-class="select-lg" data-placeholder="Select Style" onchange="getDelv();" data-fouc required >
                                <option></option>
                                <?php foreach ($style as $row) {
                                    ?>
                                    <option value="<?php echo $row->styleNo; ?>" <?php echo set_select('dayType', $row->styleNo); ?> > <?php echo $row->styleNo.' - '.$row->scNumber; ?> </option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-2">
                            <input id="scNumber" name="scNumber" type="hidden" class="form-control form-control-sm" placeholder="SC Number" readonly>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="form-label-sm col-2">Del/PO:</label>
                        <div class="col-6">
                            <select id="delv" name="delv" class="form-control-lg select" data-container-css-class="select-lg" data-placeholder="Select Delivery" onchange="getColor();" data-fouc required Disabled>
                                <option></option>
                            </select>
                        </div>
                        <label class="form-label-sm col-2">Odr/Qty :</label>
                        <div class="col-2">
                        <input id="ord_qty" name="ord_qty" type="number" class="form-control form-control-lg" placeholder="Order Qty" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                      <label class="form-label-sm col-2">Color :</label>
                      <div class="col-4">
                          <select id="color" name="color" class="form-control-lg  select" data-container-css-class="select-lg" data-placeholder="Select Color" onchange="getSize();" data-fouc required Disabled>
                              <option></option>
                          </select>
                      </div>
                      <label class="form-label-sm col-2">Size :</label>
                      <div class="col-4">
                        <select id="size" name="size" class="form-control form-control-lg  select" data-container-css-class="select-lg" data-placeholder="Select Size" onchange="" data-fouc required Disabled>
                          <option></option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                    <label class="form-label-sm col-2">Qty :</label>
                      <div class="col-4">
                        <input id="qty" name="qty" type="number" class="form-control form-control-lg" placeholder="Qty">
                      </div>
                      <div class="col-2">
                        <button class="btn btn-primary btn-lg" onclick="saveInput()"><i class="icon-paperplane"></i> Save</button>
                      </div>
                      <label class="form-label-sm col-2">Order Balance :</label>
                      <div class="col-2">
                        <input id="orderBalance" name="orderBalance" type="number" class="form-control form-control-lg" placeholder="Order Balance" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Size</th>
                                        <th style="width: 40%">Input</th>
                                        <!-- <th style="width: 20%">Total</th> -->
                                        <th style="width: 10%">Edit</th>
                                    </tr>
                                </thead>
                                <tbody id="inputTbl">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </fieldset>

                <input type="hidden" id="empTbId" value="">
                <input type="hidden" id="workerInOutCon" value="0">
                <input type="hidden" id="workerTbId" value="">
            </div>
        </div>
        <!-- /form inputs -->
    </div>

    <div class="modal fade" id="appModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-400" >
                    <h4 class="modal-title"><i class="icon-envelop4 mr-1"></i>Message</h4>
                </div>
                <div class="modal-body ">
                    <center><p id="appModalMsg"></p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="editModal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="fale">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-grey-800" >
                    <h4 class="modal-title"><i class="icon-pencil7 mr-1"></i>Edit Size :<span id="editSize"></span> </h4>
                </div>
                <div class="modal-body ">
                  <div class="form-group row">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th style="width: 50%">Date Time</th>
                                      <th style="width: 50%">Input</th>
                                  </tr>
                              </thead>
                              <tbody id="inputEditTbl">

                              </tbody>
                          </table>
                      </div>
                  </div>
                    <input id="lastInputId" type="hidden" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="editInput();">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <script type="text/javascript">

        $(document).ready(function () {
        });


        function getDelv(){
           resetAll();
            var style  = $('#style').val();
            if(style != ''){
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/getDelv")?>',
                    type:'POST',
                    data:{
                        'style':style,
                    },
                    success:function (data) {
                        if(data != ''){
                            var html = "<option value='' selected=\"selected\">&nbsp;</option>";

                            var json_value = JSON.parse(data);

                            for (var i = 0; i < json_value.length; i++) {
                                html += "<option value='" + json_value[i]['deliveryNo'] + "'>" + json_value[i]['deliveryNo'] + "</option>";
                            }
                            $('#scNumber').val(json_value[0]['scNumber']);
                            $('#delv').empty().append(html);
                            $('#delv').removeAttr('Disabled', 'Disabled');
                            $('#ord_qty').val('');
                            
                        }
                    },
                    error:function (data){
                        sweetAlert('Something Went Wrong','','warning');
                    }
                });
            }
        }
        function getColor(){
          $('#color').empty();
            var style  = $('#style').val();
            var delv  = $('#delv').val();
            if(style != '' && delv != '' ){
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/getColor")?>',
                    type:'POST',
                    data:{
                        'style':style,
                        'delv':delv,
                    },
                    success:function (data) {
                        if(data != ''){
                            var html = "<option value='' selected=\"selected\">&nbsp;</option>";

                            var json_value = JSON.parse(data);

                            for (var i = 0; i < json_value.length; i++) {
                                html += "<option value='" + json_value[i]['color'] + "'>" + json_value[i]['color'] + "</option>";
                            }
                            $('#color').empty().append(html);
                            $('#color').removeAttr('Disabled', 'Disabled');
                            $('#ord_qty').val(json_value[0]['orderQty']);
                            getSaveInputTotal();
                        }
                    },
                    error:function (data){
                        sweetAlert('Something Went Wrong','','warning');
                    }
                });
            }
        }
        function getSize(){
          $('#size').empty();
            var style  = $('#style').val();
            var delv  = $('#delv').val();
            var color  = $('#color').val();

            if(style != '' && delv != '' && color != '' ){
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/getSize")?>',
                    type:'POST',
                    data:{
                        'style':style,
                        'delv':delv,
                    },
                    success:function (data) {
                        if(data != ''){
                            var html = "<option value='' selected=\"selected\">&nbsp;</option>";
                            var json_value = JSON.parse(data);
                            for (var i = 0; i < json_value.length; i++) {
                                html += "<option value='" + json_value[i]['size'] + "'>" + json_value[i]['size'] + "</option>";
                            }
                            $('#size').empty().append(html);
                            $('#size').removeAttr('Disabled', 'Disabled');
                            getSavedInput();
                        }
                    },
                    error:function (data){
                        sweetAlert('Something Went Wrong','','warning');
                    }

                });
            }
        }


        function getSaveInputTotal(){
            var style = $('#style').val();
            var delv = $('#delv').val();
            var orderQty = $('#ord_qty').val();
            //  $('#orderBalance').val(0);
            if(orderQty ==''){
                orderQty =  0;
            }else{
                orderQty = parseInt(orderQty);
            }

            if(style != '' && delv != ''){
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/savedInputTotal")?>',
                    type:'POST',
                    data:{
                        'style':style,
                        'delv':delv
                    },
                    success:function (data) {
                       
                        if(data !=''){
                            var json_value = JSON.parse(data);
                            if(json_value.length>0){                         
                            $('#orderBalance').val(orderQty- parseInt(json_value[0]['total_input']));
                            }else{
                            $('#orderBalance').val(orderQty);
                            }
                        }else{
                            $('#orderBalance').val(orderQty);
                        }
                        

                    },
                    error:function (data){
                    }

                });
        }
    }

        function saveInput() {
            var style = $('#style').val();
            var delv = $('#delv').val();
            var color = $('#color').val();
            var size = $('#size').val();
            var qty = $('#qty').val();
            var scNumber = $('#scNumber').val();
            
            if(style != '' && delv != '' && color != '' && size != '' && qty != '' ){
                loaderOn();
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/saveInput")?>',
                    type:'POST',
                    data:{
                        'style':style,
                        'delv':delv,
                        'color':color,
                        'size':size,
                        'qty':qty,
                        'scNumber':scNumber
                    },
                    success:function (data) {
                        loaderOff();
                        if(data=='success'){                         
                            sweetAlert('Successfully Saved','','success');
                            reset();
                            getSavedInput();
                        }else{
                            sweetAlert('Data Not Saved','','warning');    
                        }

                    },
                    error:function (data){
                        loaderOff();
                        sweetAlert('Data Is Not saved.Check the connection','','warning');
                    }

                });

            }else{
                sweetAlert('Please fill out the all data','','warning');
            }
        }
        function getSavedInput() {
            var style  = $('#style').val();
            var delv  = $('#delv').val();
            var color  = $('#color').val();
            var size = '';

            if(style != '' && delv != '' && color != '' ){
                loaderOn();
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/getSavedInput")?>',
                    type:'POST',
                    data:{
                        'style':style,
                        'delv':delv,
                        'color':color,
                    },
                    success: function (data) {
                        if (data != 'noInput') {
                            var html = "";
                            var json_value = JSON.parse(data);
                            var totalQty = 0;

                            for (var i = 0; i < json_value.length; i++) {

                                  var size = json_value[i]['size'].toString();
                                  var qty = json_value[i]['qty'].toString();

                                    html += "<tr>";
                                    html += "<td style='text-align: center'>" + size + "</td>";
                                    html += "<td>" + qty + "</td>";
                                    html += "<td style='text-align: center'><button type='button' class='btn btn-danger btn-sm btn-icon' data-size='" + size + "' onclick='getSizeInputToEdit(this)'><i class='icon-pencil7'></i></button></td>";
                                    html += "</tr>";
                                totalQty += parseInt(json_value[i]['qty']);
                                getSaveInputTotal();
                            }
                            $('#inputTbl').empty().append(html);

                        } else {
                            $('#inputTbl').empty();
                        }
                        loaderOff();
                    },
                    error:function (data){
                        loaderOff();
                        sweetAlert('Something Went Wrong','','warning');
                    }

                });
            }
        }
        function getSizeInputToEdit(size){
          var style  = $('#style').val();
          var delv  = $('#delv').val();
          var color  = $('#color').val();
          var size = $(size).data( "size" );

          if(size != '' && style != '' && delv != '' && color != '' ){
              loaderOn();
              $.ajax({
                  url:'<?php echo base_url("app/Cut_In_Con/getLastEnterSizeInput")?>',
                  type:'POST',
                  data:{
                      'style':style,
                      'delv':delv,
                      'color':color,
                      'size':size,
                  },
                  success: function (data) {

                      if (data != 'noInput') {
                        var html='';
                        var json_value = JSON.parse(data);

                          for (var i = 0; i < json_value.length; i++) {

                                  html += "<tr>";
                                  html += "<td style='text-align: center'>" + json_value[i]['createDate'] + "</td>";

                                  if( i ==(parseInt(json_value.length) -1)){
                                    html += "<td><input name='editQtyLast' id='editQtyLast' type='number' class='form-control' value='"+json_value[i]['qty'] +"'></td>";
                                    $('#lastInputId').val(json_value[i]['id']);
                                  }else{
                                    html += "<td><input name='editQty' id='editQty' class='form-control' type='number' value='"+json_value[i]['qty'] +"' Disabled></td>";
                                  }

                                  html += "</tr>";
                          }
                          $('#editSize').text(size);
                          $('#inputEditTbl').empty().append(html);
                          $('#editModal').modal('show');

                      } else {
                          $('#inputEditTbl').empty();
                      }
                      loaderOff();
                  },
                  error:function (data){
                      loaderOff();
                      sweetAlert('Something Went Wrong','','warning');
                  }

              });
          }

        }
        function editInput(){
          var id = $('#lastInputId').val();
          var editQtyLast = $('#editQtyLast').val();

          if(editQtyLast== '' || editQtyLast < 0){
            editQtyLast = 0;
          }

          if(id!=''){
                loaderOn();
                $.ajax({
                    url:'<?php echo base_url("app/Cut_In_Con/editInput")?>',
                    type:'POST',
                    data:{
                        'id':id,
                        'qty':editQtyLast,
                    },
                    success:function (data) {
                        loaderOff();
                        if(data == 'success'){
                            sweetAlert('Successfully Updated','','success');
                            getSavedInput();
                              $('#editModal').modal('hide');
                        }

                    },
                    error:function (data){
                        loaderOff();
                        sweetAlert('Data Is Not updated.Check the connection','','warning');
                    }

                });

            }else{
                sweetAlert('Please fill out the all data','','warning');
            }
          }
        function reset() {
            $('#qty').val('');
            $('#size').val('');
            $('#size').select2().trigger('change');
        }



    function resetAll(){
      $('#inputTbl').empty();
      $('#delv').empty('');
      $('#color').empty('');
      $('#qty').val('');
      $('#balance').val('');
      $('#size').empty();
    }



    </script>
