<style>
    th{
        text-align: center;
    }
    td{
        font-weight:bold;
    }
    .width-15{
        width:75px;
    }
</style>

<!-- Main content -->
<div class="content-wrapper animated zoomIn">

    <!-- Content area -->
    <div class="content">

        <div class=".se-pre-con"> </div>

        <!-- Form inputs -->
        <div class="card">
            <div class="card-header header-elements-block justify-content-center align-items-center" STYLE="padding-bottom: 0px;padding-top: 10px;">
                <h2>Worker Hourly Out</h2>
            </div>

            <div class="card-body">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                    <form>
                        <div class="form-group row">
                            <label class="col-form-label-lg col-2">Hour :</label>
                            <div class="col-3">
                                <select id="hour" name="hour" class="form-control form-control-lg select " data-container-css-class="select-lg" data-placeholder="Select Style" onchange="getEmps();enableSaveBtn()"  data-fouc required >
                                    <option></option>
                                    <?php for($i=1;$i<=12;$i++) {
                                        ?>
                                        <option value="<?php echo $i; ?>"> <?php echo  $i ?> </option>
                                        <?php
                                    } ?>
                                </select>
                            </div>
                            <label class="col-form-label-lg col-2">Emp :</label>
                            <div class="col-5">
                                <select id="epfNo" name="epfNo" class="form-control form-control-lg select" data-container-css-class="select-lg" data-placeholder="Select Emp" onchange="enableSaveBtn()"  data-fouc required >
                                    <option></option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label-lg col-2">Qty :</label>
                            <div class="col-3">
                                <input id="qty" name="qty" type="number" class="form-control form-control-lg" onkeyup="enableSaveBtn();">
                            </div>
                            <div class="col-2"></div>
                            <div class="col-3">
                                <div class="form-group">
                                    <button id="btnSave" type="button" class="btn bg-primary btn-lg"  onclick="setWorkerHourlyOut();" disabled>Save <i class="icon-paperplane ml-2"></i> </button>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <!-- <th style="width: 10%">No</th> -->
                                        <th style="width: 10%">Epf.No</th>
                                        <th style="width: 40%">Name</th>
                                        <th style="width: 30%">Oparetion</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="hourlyDataTbl">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
        <!-- /form inputs -->
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="fale">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-grey-800" >
                    <h4 class="modal-title"><i class="icon-pencil7 mr-1"></i>Edit</h4>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Hour:</label>
                                <input id="editHour" type="text" placeholder="" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="form-group">
                                <label>Emp Name:</label>
                                <input id="editEmpName" type="text" placeholder="" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Qty:</label>
                                <input id="editQty" type="number"  placeholder="Qty" class="form-control">
                            </div>
                        </div>
                    </div>
                    <input id="editId" type="hidden" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="editEmpQty();">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <script type="text/javascript">

        function sweetAlert(title,text,icon) {
            swal({
                title: title,
                text: text,
                icon: icon,
            });
        }


        function getEmps() {
            var hour = $('#hour').val();
            $('#epfNo').empty();
            var html = "<option value='' selected=\"selected\">&nbsp;</option>";
            loaderOn();
            if(hour !=''){
                $.ajax({
                    url:"<?php echo base_url('app/Worker_Hourly_Out_Con/getEmps');?>",
                    type:"POST",
                    data:{
                        'hour':hour,
                    },
                    success:function (data) {
                        if($.trim(data)!='noData'){

                            var json_value = JSON.parse(data);
                            for (var i = 0; i < json_value.length; i++) {
                                html += "<option value='" + json_value[i]['id'] + "'>" + json_value[i]['emp_no']+' -'+ json_value[i]['emp_name']+ "</option>";
                            }
                        }else{

                        }
                        $('#epfNo').empty().append(html);
                        getSavedHourlyData();
                        loaderOff();
                    },
                    error:function (data) {
                        loaderOff();
                        sweetAlert('Network Error','Please check the network connection','warning');
                    }
                })
            }
        }

        function getSavedHourlyData(){
            var hour = $('#hour').val();
            if(hour !=''){
                $.ajax({
                    url:"<?php echo base_url('app/Worker_Hourly_Out_Con/getSavedHourlyData');?>",
                    type:"POST",
                    data:{
                        'hour':hour,
                    },
                    success:function (data) {
                        loaderOff();

                        if(data != 'noData'){
                            var html = "";

                            var json_value = JSON.parse(data);

                            for (var i = 0; i < json_value.length; i++) {
                                html += "<tr>";
                                // html += "<td style='text-align: center'>" + (parseInt(i)+1) + "</td>";
                                html += "<td>" + json_value[i]['epf_no'] + "</td>";
                                html += "<td>" + json_value[i]['emp_name'] + "</td>";
                                html += "<td>" + json_value[i]['operation'] + "</td>";
                                html += "<td style='text-align: center'>" + json_value[i]['qty'] + "</td>";
                                html += "<td style='text-align: center'><button type='button' class='btn btn-danger btn-sm btn-icon' data-empname='"+json_value[i]['emp_name']+"' data-qty='"+json_value[i]['qty']+"' onclick='edit("+json_value[i]['id']+",this)'><i class='icon-pencil7'></i></button></td>";
                                html += "</tr>";
                            }

                            $('#hourlyDataTbl').empty().append(html);

                        }else{
                            $('#hourlyDataTbl').empty();
                        }
                    },
                    error:function (data) {
                        sweetAlert('Network Error','Please check the network connection','warning');
                    }
                })
            }

        }

        function setWorkerHourlyOut(){
            var workerInTeamTblId = $('#epfNo').val();
            var hour = $('#hour').val();
            var qty = $('#qty').val();

            if(workerInTeamTblId !='' && hour != '' && qty != ''){
                loaderOn();
                $.ajax({
                    url:"<?php echo base_url('app/Worker_Hourly_Out_Con/setWorkerHourlyOut');?>",
                    type:"POST",
                    data:{
                        'workerInTeamTblId':workerInTeamTblId,
                        'hour':hour,
                        'qty':qty,
                    },
                    success:function (data) {
                        loaderOff();
                        if(data=='success'){
                            sweetAlert('Saved','','success');
                            reset();
                            getEmps();
                        }else {
                            sweetAlert('Error!','Please Try Again','warning');
                        }

                    },
                    error:function (data) {
                        loaderOff();
                        sweetAlert('Network Error','Please check the network connection','warning');
                    }
                })
            }
        }

        function enableSaveBtn() {
            var workerInTeamTblId = $('#epfNo').val();
            var hour = $('#hour').val();
            var qty = $('#qty').val();

            if(workerInTeamTblId !='' && hour != '' && qty != '') {
                $('#btnSave').removeAttr('Disabled','Disabled');
            }else{

            }

        }

        function edit(id,em) {
            var empName = $(em).data( "empname" );
            var qty = $(em).data( "qty" );
            var hour = $('#hour').val();
            $('#editEmpName').val(empName);
            $('#editHour').val(hour);
            $('#editQty').val(qty);
            $('#editId').val(id);

            $('#editModal').modal('show');
        }

        function reset() {
            $('#qty').val('');
            $('#epfNu').val('');
            $('#epfNu').select2().trigger('change');

            $('#btnSave').attr('Disabled','Disabled');

        }

        function editEmpQty(){
            var editQty = $('#editQty').val();
            var editId = $('#editId').val();

            if( qty != '' && editId !='' ){
                loaderOn();

                $.ajax({
                    url:"<?php echo base_url('app/Worker_Hourly_Out_Con/editEmpQty');?>",
                    type:"POST",
                    data:{
                        'id':editId,
                        'qty':editQty,
                    },
                    success:function (data) {
                        loaderOff();
                        if(data=='success'){
                            sweetAlert('Successfully Updated','','success');
                            $('#editModal').modal('toggle');
                            getSavedHourlyData();
                        }else {
                            sweetAlert('Error!','Please Try Again','warning');
                        }

                    },
                    error:function (data) {
                        loaderOff();
                        sweetAlert('Network Error','Please check the network connection','warning');
                    }
                })
            }
        }

    </script>
