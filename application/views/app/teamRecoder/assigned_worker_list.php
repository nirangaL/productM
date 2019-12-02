<style>
    th{
        text-align: center;
    }
    td{
        text-align: left;
        font-weight:bold;
    }
    .width-15{
        width:75px;
    }
    .bigdrop {
    width: 600px !important;
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
               <h4>Today Workers List</h4>

            </div>

            <div class="card-body">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                    <div class="form-group row">
                      <div class="col-12 text-right">
                        <a href="<?php echo base_url('app/App_TeamRecorder_Con')?>" class="btn btn-primary btn-lg" onclick=""><i class="icon-paperplane" ></i> Add New</a>
                        <button class="btn btn-warning btn-lg" onclick="loadPreWorker()"><i class="icon-redo" ></i> Load Previos Day workers</button>
                      </div>
                    </div>

                    <div class="form-group row">
                        <div class="table-responsive">
                            <table id="workerListTbl" class="table dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 15%">Emp No</th>
                                        <th style="width: 25%">Name</th>
                                        <!-- <th style="width: 10%">Style</th> -->
                                        <th style="width: 30%">Ope</th>
                                        <th style="width: 20%">In Time</th>
                                        <th style="width: 5%">HeadCount</th>
                                    </tr>
                                </thead>
                                <tbody >
                                  <?php
                                  $i = 0;
                                  foreach ($workerList as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo ++$i; ?></td>
                                        <td><?php echo $row->emp_no; ?></td>
                                        <td><?php echo $row->emp_name; ?></td>
                                        <!-- <td style="widtd: 10%">Style</td> -->
                                        <td><?php echo $row->operation; ?></td>
                                        <td><?php echo $row->workerInTime; ?></td>
                                        <td><?php echo $row->headCount; ?></td>
                                    </tr>
                                    <?php
                                  }
                                  ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <!-- /form inputs -->
    </div>

    <div class="modal fade" id="loadPrevWorkerModal" data-backdrop="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="fale">
        <div class="modal-dialog modal-full modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-800">
                    <h4 class="modal-title"><i class="icon-people mr-1"></i>Load Workers</h4>
                    <center>
                        <span style="font-size: large;font-weight: 800;" id="currentDate"></span><br>
                        <span style="font-size: large;font-weight: 600;" id="currentTime"></span>
                    </center>
                </div>
                <div class="modal-body ">
                  <div class="form-group row">
                      <label class="col-form-label-lg col-2">Day Type :</label>
                      <div class="col-4">
                          <select id="dayType" name="dayType" class="form-control form-control-lg" >
                              <option value="0"> --Select a Daytype-- </option>
                              <?php foreach ($dayType as $row) {
                                  ?>
                                  <option value="<?php echo $row->id; ?>" <?php echo set_select('dayType', $row->id); ?>  <?php if(get_cookie('dayTypeCookie') == $row->id){ echo 'selected';}?> style="height:30px;"> <?php echo $row->dayType; ?> </option>
                                  <?php
                              } ?>
                          </select>
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th style="width:5%">EmpNo</th>
                                      <th style="width:50%">Name</th>
                                      <th style="width:100%">Operation</th>
                                      <th style="width:5%"><input type='checkbox' id="checkAll" checked></th>
                                  </tr>
                              </thead>
                              <tbody id="preWorker">

                              </tbody>
                          </table>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="addWorkers();">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!-- Disabled backdrop -->
    <div id="messageModal" class="modal" data-backdrop="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title">Message</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body" id="messageModalBody">
              <h3>Below Emplooyees is/are not save for following reasons,</h3>
              <h5>- Already assigned</h5>
              <h5>- Already assigned to an another team</h5>
              <h5>- Inactive </h5>
            </br>
            <h3>Emplooyees,</h3>
            <div id="messageModalWorkerList">

            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn bg-dark" data-dismiss="modal" onclick="window.location.reload();">OK</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /disabled backdrop -->


    <script type="text/javascript">
    $(document).ready(function () {
        display_c();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
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

    function sweetAlert(title,text,icon) {
      swal({
        title: title,
        text: text,
        icon: icon,
      });
    }

    $('#workerListTbl').dataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bInfo": false,
      "bAutoWidth": false
    });


    function loadPreWorker(){
      $.ajax({
        url:'<?php echo base_url("app/App_TeamRecorder_Con/getPreWorker")?>',
        type:'POST',
        data:{
        },
        success:function (data) {
          var json_value = JSON.parse(data);
          var html= '';
          for (var i = 0; i < json_value['worker'].length; i++) {

            html += "<tr>";
            html += "<td>" + json_value['worker'][i]['emp_no'] + "</td>";
            html += "<td>" + json_value['worker'][i]['emp_name'] + "</td>";

            html += "<td  style='width:70px;'>";
            html += "<div class='form-group'>";
            html += "<select id='"+json_value['worker'][i]['emp_no']+"' name='operation"+i+"' class='form-control'>"
            for (var x = 0; x < json_value['operation'].length; x++) {
              html +="<option value='"+json_value['operation'][x]['id']+"'>"+json_value['operation'][x]['operation']+"</option>";
            }
            html +="</select>"
            html += "</div>";
            html += "</td>";

            html += "<td style='text-align: center'><input type='checkbox' class='worker_in' value='"+json_value['worker'][i]['emp_no']+"'  checked ></td>";
            html += "</tr>";

          }

          $('#preWorker').empty().append(html);
          $('.select2').select2({
            dropdownParent: $('#loadPrevWorkerModal'),
            dropdownCssClass : 'bigdrop'
          });
          $('#loadPrevWorkerModal').modal('show');
        },
        error:function (data){
          sweetAlert('Something Went Wrong','','warning');
        }
      });

    }

    function addWorkers(){
      var dayType = $('#dayType').val();
      var workers = {};
      var html ='';

      if(dayType=='0'){
        sweetAlert('Please Select a Day Type','','warning');
        $('#dayType').focus();
      }else{
        $('.worker_in').each(function(){
          if($(this).is(":checked")){
          var operation = $('#'+$(this).val()+'').val();
              workers[$(this).val()] = operation;
              // workers['val'] = operation;
          }
        });

        if(isEmpty(workers)){
          sweetAlert('Please Select a Day Type','','warning');
        }else{
          var jsonText = JSON.stringify(workers);

          $.ajax({
            url:'<?php echo base_url("app/App_TeamRecorder_Con/setPrevWorkers")?>',
            type:'POST',
            data:{
              'jsonData':jsonText,
              'dayType':dayType
            },
            success:function(data) {
              if(data ==''){
              sweetAlert('Saved','','success');
              window.location.reload();
              }else{
                var json_value = JSON.parse(data);
                var html= '';
                for (var i = 0; i < json_value['unSavedWorkser'].length; i++) {
                  html +='<h5>'+json_value['unSavedWorkser'][i]['epfN0']+' - '+json_value['unSavedWorkser'][i]['name']+'</h5>'

                }
                $('#loadPrevWorkerModal').modal('hide');
                $('#messageModalWorkerList').empty().append(html);
                $('#messageModal').modal('show');

              }
            }
          });
        }

      }
    }

    $("#checkAll").click(function () {
     $('.worker_in').not(this).prop('checked', this.checked);
   });

    function isEmpty(obj) {
      for(var key in obj) {
        if(obj.hasOwnProperty(key))
        return false;
      }
      return true;
    }





    </script>
