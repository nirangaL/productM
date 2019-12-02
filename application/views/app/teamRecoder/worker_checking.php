<!-- Main content -->
<div class="content-wrapper animated zoomIn">

    <!-- Content area -->
    <div class="content">

        <div class=".se-pre-con"> </div>

        <!-- Form inputs -->
        <div class="card">
            <div class="card-header header-elements-block justify-content-center align-items-center" STYLE="padding-bottom: 0px;padding-top: 5px;">
                <center>
                    <span style="font-size: large;font-weight: 800;" id="currentDate"></span><br>
                    <span style="font-size: large;font-weight: 600;" id="currentTime"></span>
                </center>
            </div>

            <div class="card-body">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="form-group row">
                            <label class="col-form-label-lg col-3">Day Type :</label>
                            <div class="col-7">
                                <select id="dayType" name="dayType" class="form-control form-control-lg select" data-container-css-class="select-lg" data-placeholder="select Day Type" onchange=" workerInOutBtn();" data-fouc required >
                                    <option></option>
                                    <?php foreach ($dayType as $row) {
                                        ?>
                                        <option value="<?php echo $row->id; ?>" <?php echo set_select('dayType', $row->id); ?>  <?php if(get_cookie('dayTypeCookie') == $row->id){ echo 'selected';}?> > <?php echo $row->dayType; ?> </option>
                                        <?php
                                    } ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label-lg col-3">EPF Number :</label>
                            <div class="col-5">
                                <input id="epfNu" name="epfNu" class="form-control form-control-lg" type="number" pattern="[0-9]*" inputmode="numeric" onkeyup="enableVerifyBtn();">
                            </div>
                            <!-- <div class="col-1"></div> -->
                            <div class="col-4">
                                <button type="button" id="btnVerify" class="form-control btn bg-teal btn-lg" onclick="empVerify();" disabled><i class="icon-point-right"></i> Verify </button>
                            </div>
                        </div>

                        <div id="empDetilas" hidden>
                            <div id="" class="form-group row">
                                <label class="col-form-label-lg col-3">Emp.Name :</label>
                                <div class="col-9">
                                    <input id="empName" name="empName" class="form-control form-control-lg" type="text" readonly>
                                </div>
                            </div>
                            <div id="empDetilas" class="form-group row">
                                <label class="col-form-label-lg col-3">Emp.Designation :</label>
                                <div class="col-9">
                                    <input id="empDesig" name="empDesig" class="form-control form-control-lg" type="text" readonly>
                                </div>
                            </div>
                        </div>

                        <div id="empDetailsSpace" style="margin-top: 25%;" ></div>

                        <div class="form-group row" >
                            <label class="col-form-label-lg col-3">Operation :</label>
                            <div class="col-7">
                                <select id="operation" name="operation" class="form-control form-control-lg select-search" data-container-css-class="select-lg" data-placeholder="Select an Operation" onchange="workerInOutBtn();enableOpeChangeBtn();" data-fouc required >
                                    <option></option>
                                    <?php foreach ($operations as $row) {
                                        ?>
                                        <option value="<?php echo $row->id; ?>" <?php echo set_select('line', $row->id); ?> > <?php echo $row->operation; ?> </option>
                                        <?php
                                    } ?>
                                </select>
                                <input type="hidden" id="preSavedOp" value="">

                            </div>

                            <div class="col-2">
                                <button type="button" id="opeChangeBtn" class="form-control btn bg-purple-400 btn-lg" hidden onclick="opeChange();">Change</button>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-top: 10%;">
                            <div class="col-1"></div>
                           <div class="col-5">
                               <button id="workerIn" type="button" class="form-control btn bg-primary btn-lg" disabled onclick="workerInOut('in')"><i class=" icon-plus-circle2"></i> WORKER IN   </button>
                           </div>
                            <div class="col-1"></div>
                           <div class="col-5">
                               <button id="workerOut" type="button" class="form-control btn bg-warning btn-lg" disabled onclick="workerInOut('out')"><i class="icon-minus-circle2"></i> WORKER OUT   </button>
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

    <script type="text/javascript">

        $(document).ready(function () {
            display_c();
        });

        function display_c(){
            var refresh=1000; // Refresh rate in milli seconds
            mytime=setTimeout('display_ct()',refresh)
        }
        //// Time Countdown ////
        function display_ct() {
            var x = new Date();

            var Y =x.getFullYear();
            var mm = x.getMonth() + 1;
            var dd = x.getDate();
            var hh = x.getHours();
            var ii = x.getMinutes();
            var ss = x.getSeconds();

            if( dd<10)
            {
                dd='0'+ dd;
            }

            if(mm<10)
            {
                mm='0'+ mm;
            }

            if(hh<10)
            {
                hh ='0'+ hh;
            }

            if(ii<10)
            {
                ii='0'+ ii;
            }

            if(ss<10)
            {
                ss = '0'+ ss;
            }

            var d = Y + "-" + mm + "-" + dd;
            var t = hh + ":" + ii + ":" + ss;
            document.getElementById('currentDate').innerHTML = d;
            document.getElementById('currentTime').innerHTML = t;
            display_c();
        }

        ///// Verify btn enable and disabled /////
        function enableVerifyBtn() {
            $('#empDetilas').attr('Hidden','hidden');
            $('#empDetailsSpace').removeAttr('Hidden','hidden');
            var epfNo = $('#epfNu').val();
            if((epfNo.length) > 0){
                $('#btnVerify').removeAttr('Disabled','Disabled');
            }else{
                $('#btnVerify').attr('Disabled','Disabled');
                $('#empDetilas').attr('Hidden','hidden');
            }

            $('#empDetilas').attr('Hidden','hidden');
            $('#empDetailsSpace').removeAttr('Hidden','hidden');
            $('#empName').val('');
            $('#empDesig').val('');
            $('#empTbId').val('');
            $('#operation').val('');
            $('#operation').select2().trigger('change');
            $('#workerInOutCon').val('0');
            $('#workerIn').attr('Disabled','Disabled');
            $('#workessrOut').attr('Disabled','Disabled');
        }

        ///// employee verify //////
        function empVerify() {
            var epfNo = $('#epfNu').val();
            loaderOn();
            if(epfNo != '') {
                $.ajax({
                    url: '<?php echo base_url("app/App_TeamRecorder_Con/verifyEmp")?>', //This is the current doc
                    type: "POST",
                    data: ({
                        epfNo:epfNo,
                    }),
                    success: function (data) {
                        if(data == 'noEmp'){
                            loaderOff();
                            sweetAlert('Incorrect Or Unregistered EPF Number. Check Again!', '', 'warning');

                        }else{
                            var json_value = JSON.parse(data);
                            if(json_value['status'] == 'notAssign'){
                                $('#workerTbId').val(json_value['id']);
                                $('#empDetilas').addClass('animated jello');
                                $('#empDetilas').removeAttr('Hidden','hidden');
                                $('#empDetailsSpace').attr('Hidden','hidden');
                                $('#empName').val(json_value['empName']);
                                $('#empDesig').val(json_value['empDesig']);
                                $('#empTbId').val(json_value['empTbId']);
                                $('#workerInOutCon').val('1');
                                workerInOutBtn();
                            }
                            else if(json_value['status'] == 'workingCurrentTeam'){
                                $('#workerTbId').val(json_value['id']);
                                $('#empDetilas').removeAttr('Hidden','hidden');
                                $('#empDetailsSpace').attr('Hidden','hidden');
                                $('#empName').val(json_value['empName']);
                                $('#empDesig').val(json_value['empDesig']);
                                $('#empTbId').val(json_value['empTbId']);

                                $('#operation').val(json_value['operation_id']);
                                $('#operation').select2().trigger('change');
                                $('#preSavedOp').val(json_value['operation_id']);

                                $('#dayType').val(json_value['locationShift']);
                                $('#dayType').select2().trigger('change');

                                $('#workerInOutCon').val('2');
                                workerInOutBtn();

                            }else if(json_value['status'] == 'workerOut'){
                                $('#workerTbId').val(json_value['id']);
                                $('#empDetilas').removeAttr('Hidden','hidden');
                                $('#empDetailsSpace').attr('Hidden','hidden');
                                $('#empName').val(json_value['empName']);
                                $('#empDesig').val(json_value['empDesig']);
                                $('#empTbId').val(json_value['empTbId']);

                                $('#workerInOutCon').val('1');
                                workerInOutBtn();
                            }else if(json_value['status'] == 'working'){
                                var team = json_value['team'];
                                sweetAlert('EPF No:'+epfNo + ' Currently Working On Team '+ team);
                            }
                        }
                        loaderOff();
                    },
                    error:function (data){
                        sweetAlert('Network Connection is Lost', '', 'warning');
                        reset();
                        loaderOff();
                    }
                });
            }

        }

        function workerInOutBtn(){
            var opeId =  $('#operation').val();
            var epfNo = $('#epfNu').val();
            var workerInOutCon = $('#workerInOutCon').val();
            var dayType = $('#dayType').val();
            if(opeId != '' && epfNo != '' && dayType != ''){

                if(workerInOutCon =='1'){
                    $('#workerIn').removeAttr('Disabled','Disabled');
                }else{
                    $('#workerIn').attr('Disabled','Disabled');
                }
                if(workerInOutCon =='2'){
                    $('#workerOut').removeAttr('Disabled','Disabled');
                }else{
                    $('#workerOut').attr('Disabled','Disabled');
                }
            }else{
                $('#workerIn').attr('Disabled','Disabled');
                $('#workerOut').attr('Disabled','Disabled');
            }
        }

        function workerInOut(inOut) {
            loaderOn();
            var empTbId = $('#empTbId').val();
            var epfNu = $('#epfNu').val();
            var operation = $("#operation").val();
            var workerTbId =  $("#workerTbId").val();
            var dayType =  $("#dayType").val();

            if(workerTbId == null){
                workerTbId = '';
            }

            if(empTbId != '' ){
                    $.ajax({
                        url: '<?php echo base_url("app/App_TeamRecorder_Con/assignEmpToTeam")?>', //This is the current doc
                        type: "POST",
                        data: ({
                            empTbId:empTbId,
                            epfNu:epfNu,
                            operation:operation,
                            workerTbId:workerTbId,
                            dayType:dayType,
                            inOut:inOut,
                        }),
                        success: function (data) {
                            if(data =='success'){

                                if(inOut == 'in'){
                                    sweetAlert('Success','EPF No. ' +epfNu +' Worker is Assign To The Your Team','success');
                                    reset();
                                }

                                if(inOut == 'out'){
                                    sweetAlert('Success','EPF No. ' + epfNu +' Worker is Left From Your Team','success');
                                    reset();
                                }
                            }

                            if(data == 'failure'){
                                sweetAlert('Oops! Something Went wrong','Query is not execute','warning');
                            }

                        loaderOff();

                        },
                        error:function (data){
                            sweetAlert('Network Connection is Lost', '', 'warning');
                            reset();
                            loaderOff();
                        }
                    });
                }
            }

        function sweetAlert(title,text,icon) {
            swal({
                title: title,
                text: text,
                icon: icon,
            });
        }

        function reset() {
            $('#epfNu').val('')
            $('#empDetilas').attr('Hidden','hidden');
            $('#empDetailsSpace').removeAttr('Hidden','hidden');
            $('#empName').val('');
            $('#empDesig').val('');
            $('#empTbId').val('');
            $('#operation').val('');
            $('#operation').select2().trigger('change');
            $('#opeChangeBtn').attr('Hidden','hidden');
            $('#workerInOutCon').val('0');

            $('#btnVerify').attr('Disabled','Disabled');
            $('#workerIn').attr('Disabled','Disabled');
            $('#workerOut').attr('Disabled','Disabled');
        }

        function enableOpeChangeBtn() {
           var workerInOutCon = $('#workerInOutCon').val();
           var preSavedOp = $("#preSavedOp").val();

            if(workerInOutCon =='2' && (preSavedOp != $('#operation').val() ) ){
                $('#opeChangeBtn').removeAttr('Hidden','Hidden');
            }else{
                $('#opeChangeBtn').attr('hidden','hidden');
            }
        }

        function opeChange() {
            loaderOn();
            var workerOpTbId = $('#workerTbId').val();
            var operationId = $('#operation').val();
            var preSavedOp = $("#preSavedOp").val();

            if(workerOpTbId != '' && operationId !=''){
                $.ajax({
                    url: '<?php echo base_url("app/App_TeamRecorder_Con/opeChange")?>', //This is the current doc
                    type: "POST",
                    data: ({
                        workerOpTbId:workerOpTbId,
                        operationId:operationId,
                    }),
                    success: function (data) {
                        if (data == 'success') {
                            sweetAlert('Operation is Changed', '', 'success');
                            reset();
                            $('#opeChangeBtn').attr('hidden','hidden');
                        } else if(data == 'failure') {
                            $('#operation').val(preSavedOp);
                            $('#operation').select2().trigger('change');
                            sweetAlert('Oops!. Operation is not Changed', '', 'warning');
                        }
                        loaderOff();
                    },
                    error:function (data){
                        sweetAlert('Network Connection is Lost', '', 'warning');
                        reset();
                        loaderOff();
                    }
                });
            }
        }

        // function setDayTypeCookie(dayType){
        //     $.cookie("dayTypeCookie", dayType, { expires : 1 });
        // }


    </script>
