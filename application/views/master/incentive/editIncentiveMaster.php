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
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Incentive</span> - Edit
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
                    <a href="<?php echo base_url('Location_Dashboard_Con');?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="<?php echo base_url('incentive_con');?>" class="breadcrumb-item">Master</a>
                    <span class="breadcrumb-item active">Add Incentive</span>
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
                <h5 class="card-title">Incentive Form</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="<?php echo base_url('Incentive_con/editIncentiveRenge/'.$lData[0]->id)?>" method="post">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Start SMV :</label>
                            <div class="col-lg-2">
                                <input id="startSmv" name="startSmv" type="number" step=".01" class="form-control" value="<?php echo $lData[0]->startSmv;?>" min="0" onblur="checkOutSmvRange();" required>
                                <span class="error" id="error"><?php echo form_error('startSmv'); ?></span>
                            </div>
                            <label class="col-form-label col-lg-2">End SMV :</label>
                            <div class="col-lg-2">
                                <input id="endSmv" name="endSmv" type="number" step=".01" class="form-control" value="<?php echo $lData[0]->endSmv;?>" min="0" onblur="checkOutSmvRange();" required>
                                <span class="error" id="error"><?php echo form_error('endSmv'); ?></span>
                            </div>
                            <div class="col-lg-4">
                                <span class="error" id="errorSmv"></span>
                            </div>
                        </div>

                        <input id='preStartSmv' type="hidden" value="<?php echo $lData[0]->startSmv;?>">
                        <input id='preEndSmv' type="hidden" value="<?php echo $lData[0]->endSmv;?>">

                        <div class="form-group row">
                            <div class="table-responsive">
                                <table class="table table-dark bg-slate-600" id="ladderTbl">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>Day</th>
                                        <th>Efficiency %</th>
                                        <th>Base Amount Rs.</th>
                                        <th>Increment %</th>
                                        <th>Increment Rs.</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                      <?php
                                      $i = 1;
                                      foreach ( $lData as $row) {
                                        ?>
                                        <tr id="trId<?php echo $i;?>" data-trcount="1">
                                            <td>
                                                <input id="day<?php echo $i;?>" style="width: 60%;text-align: center" name="day<?php echo $i;?>" type="text" class="form-control" value="<?php echo $row->day;?>" min="0" readonly>
                                                <span class="error" id="error"><?php echo form_error('day'.$i); ?></span>
                                            </td>
                                            <td>
                                                <input id="efficiency<?php echo $i;?>" name="efficiency<?php echo $i;?>" type="text" class="form-control" value="<?php echo $row->efficiency;?>"  onblur="addNewRow('<?php echo $i;?>');" min="0" max="100" maxlength="3">
                                                <span class="error" id="error"><?php echo form_error('efficiency'.$i); ?></span>
                                            </td>
                                            <td>
                                                <input id="baseAmount<?php echo $i;?>" name="baseAmount<?php echo $i;?>" type="text" class="form-control" value="<?php echo $row->base_amount;?>" min="0"  onblur="addNewRow('<?php echo $i;?>');">
                                                <span class="error" id="error"><?php echo form_error('baseAmount'.$i); ?></span>
                                            </td>
                                            <td>
                                                <input id="increPercent<?php echo $i;?>" name="increPercent<?php echo $i;?>" type="text" class="form-control" value="<?php echo $row->incre_percent;?>" onblur="addNewRow('<?php echo $i;?>');"  min="0" max="100"  maxlength="3"  >
                                                <span class="error" id="error"><?php echo form_error('incrPercnt'.$i); ?></span>
                                            </td>
                                            <td>
                                                <input id="increAmount<?php echo $i;?>" name="increAmount<?php echo $i;?>" type="number" class="form-control" value="<?php echo $row->incre_amount;?>" min="0"  onblur="addNewRow('<?php echo $i;?>');">
                                                <span class="error" id="error"><?php echo form_error('increAmount'.$i); ?></span>
                                            </td>
                                            <td class="text-center" style="text-align: center">
                                                <a href="" id="clearRow1" onclick="clearRowContent('<?php echo $i;?>')"> <span style="color: white;"><i class="icon-eraser ml-2"></i> </span></a>
                                            </td>
                                        </tr>

                                        <?php
                                        $i++;
                                      }
                                      ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <input type="hidden" id="tblRowCount" name="tblRowCount" value="<?php echo $i-1;?>">
                        <div class="text-right">
                            <button type="submit" id="update" name="update"  class="btn bg-purple-400 ">Update <i class="icon-pencil7 ml-2" ></i> </button>
                            <button type="reset" class="btn btn-warning">Reset<i class="icon-reset ml-2"></i> </button>
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
      var rowCount = parseInt($('#tblRowCount').val());
      addNewRow(rowCount);
    });

    function addNewRow(rowNum){
      var increPercnt  = $('#increPercnt'+rowNum+'').val();
      var increAmount  = $('#increAmount'+rowNum+'').val();
      var day  = $('#day'+rowNum+'').val();
      var efficiency  = $('#efficiency'+rowNum+'').val();
      var baseAmount  = $('#baseAmount'+rowNum+'').val();
      var tblRowCount  = $('#tblRowCount').val();

      if(increPercnt !='' && increAmount != '' && day !='' && efficiency!='' && baseAmount!='' && tblRowCount <= rowNum ){
        var num =parseInt(rowNum) + 1;
        var html = "<tr id='trId1"+num+"'>"
        + "<td><input id='day"+num+"' style='width: 60%;text-align: center' name='day"+num+"' type='text' class='form-control' value='"+(parseInt(day)+1)+"' min='0' readonly> </td>"
        + "<td><input id='efficiency"+num+"' name='efficiency"+num+"' type='text' class='form-control' value='' onblur='addNewRow("+num+")' min='0' max='100'  maxlength='3' > </td>"
        + "<td><input id='baseAmount"+num+"' name='baseAmount"+num+"' type='text' class='form-control' value='' onblur='addNewRow("+num+")' min='0' > </td>"
        + "<td><input id='increPercent"+num+"' name='increPercent"+num+"' type='text' class='form-control' value='0' onblur='addNewRow("+num+")' min='0' max='100'  maxlength='3'> </td>"
        + "<td><input id='increAmount"+num+"' name='increAmount"+num+"' type='number' class='form-control' value='0' onblur='addNewRow("+num+")' min='0' > </td>"
        + "<td class='text-center' style='text-align: center'> <a href='' id='clearRow1' onclick='clearRowContent("+num+")'> <span style='color: white;'><i class='icon-eraser ml-2'></i> </span></a> </td>"
        + "</tr>"

        $('#tblRowCount').val(num);
        $("#ladderTbl tbody").append(html);
      }

    }

    function clearRowContent(rowNum) {

      $('#efficiency'+rowNum+'').val('');
      $('#baseAmount'+rowNum+'').val('');
      $('#increPercnt'+rowNum+'').val('');
      $('#increAmount'+rowNum+'').val('');
    }


    function checkOutSmvRange() {
      var preStartSmv = $('#preStartSmv').val();
      var preEndSmv = $('#preEndSmv').val();

      var startSmv = $('#startSmv').val();
      var endSmv = $('#endSmv').val();
      $('#errorSmv').text('');

      if(startSmv != '' && endSmv !='' ){

        if(parseFloat(startSmv) < parseFloat(endSmv)){
          if(preStartSmv>startSmv && preEndSmv < endSmv){
            $.ajax({
              url: '<?php echo base_url("Incentive_con/checkOutSmvRange")?>', //This is the current doc
              type: "POST",
              data: ({
                startSmv: startSmv,
                endSmv: endSmv,
              }),
              success: function (data) {
                if(data =='notOk'){
                  $('#errorSmv').text('This SMV range already save or belong to a another SMV Range');
                  $('#save').attr('disabled','disabled');
                }else{
                  $('#errorSmv').text('');
                  $('#save').removeAttr('disabled','disabled');
                }
              }
            });
          }else{
            $('#errorSmv').text('');
            $('#save').removeAttr('disabled','disabled');
          }

        }else{
          $('#errorSmv').text('End SMV can not be less than Start Smv');
          $('#save').attr('disabled','disabled');
        }


      }
    }
    </script>
