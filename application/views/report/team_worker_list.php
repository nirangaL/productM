<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> -Date Wise Worker List
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
                    <a href="<?php echo base_url('Location_Dashboard_Con'); ?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Worker List</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">

          <!-- <?php
          //  echo $selectTeam;
          ?> -->

            <div class="card-body">
               <form action="<?php echo base_url('report/Team_Workers_List_Con/getTableData')?>" method="post">
                   <div class="row">
                       <label class="col-form-label col-sm-1">Date : </label>
                       <div class="col-sm-3">
                           <div class="input-group">
    										<span class="input-group-prepend">
    											<span class="input-group-text"><i class="icon-calendar5"></i></span>
    										</span>
                               <input id="date" name="date" type="text" class="form-control datepick" value="<?php if($selectDate !=''){echo $selectDate;}else{echo date('Y-m-d');}?>" placeholder="Select a date &hellip;">
                           </div>
                       </div>
                       <label class="col-form-label col-sm-1">Department : </label>
                       <div class="col-sm-2">
                           <select id="department" name="department" onchange="getTeam();" class="form-control select-search select2" data-fouc=""  data-placeholder="select Department"
                                   tabindex="-1" >
                                   <option></option>
                               <?php
                               if (!empty($department)) {
                                   foreach ($department as $row) {
                                       ?>
                                       <option value="<?php echo $row->depId; ?>" <?php if($row->depId == $selectDep){echo 'Selected';}?> > <?php echo $row->department; ?></option>
                                       <?php
                                   }
                               }
                               ?>
                           </select>

                           <input type="hidden" id="selectedTeam" value="<?php echo $selectTeam;?>">

                       </div>
                       <label class="col-form-label col-sm-1">Team : </label>
                       <div class="col-sm-2">
                           <select id="team" name="team" class="form-control select-search select2" data-fouc=""
                                   tabindex="-1" data-placeholder="select Team">
                           </select>
                       </div>
                       <div class="col-sm-2">
                           <div class="text-right">
                               <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </div>
                   </div>
<!--
                   <?php
                // print_r($tableData);?> -->

               </form>

            </div>

            <table id="workersTbl" class="table dataTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Team</th>
                    <th>Emp No</th>
                    <th>Emp Name</th>
                    <th>Department</th>
                    <th>Operatiion</th>
                    <!-- <th>Worker In</th> -->
                    <th>Worker In Time</th>
                    <th>worker Out</th>
                    <th>workerOut Time</th>
                    <th>Head Count</th>
                </tr>
                </thead>
                <tbody>

                <?php
                    if(!empty($tableData)){
                      $totalHeadCont = 0;
                      $i = 1;
                        foreach ($tableData as $row){
                          $totalHeadCont += (float)$row->headCount;

                            ?>
                        <tr>
                            <td><?php echo   $i;?></td>
                            <td><?php echo $row->line;?></td>
                            <td><?php echo $row->emp_no;?></td>
                            <td><?php echo $row->emp_name;?></td>
                            <td><?php echo $row->department;?></td>
                            <td><?php echo $row->operation;?></td>
                            <!-- <?php if($row->workerIn =='1'){
                              ?>
                              <td><span class="badge badge-success">&nbsp;&nbsp;IN&nbsp;&nbsp;</span></td>
                              <?php
                            }
                            ?> -->

                            <td><?php echo $row->workerInTime;?></td>
                            <?php if($row->workerOut =='1'){
                              ?>
                              <td><span class="badge badge-warning">&nbsp;&nbsp;Out&nbsp;&nbsp;</span></td>
                                <td><?php echo $row->workerOutTime;?></td>
                              <?php
                            }else{
                              ?>
                              <td>--</td>
                                <td>--</td>                            
                              <?php
                            }
                            ?>
                            <td><?php echo $row->headCount;?></td>

                        </tr>
                    <?php
                    $i++;
                        }

                    }
                ?>

                </tbody>
            </table>
        </div>
    </div>


    <script>

        $(document).ready(function () {
            $('.datepick').pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'yyyy-mm-dd',
            })

            var date = $('.datepick').val();
            var fileName  = 'Team Wise Worker List '+ date;

            $('#workersTbl').DataTable({
                retrieve: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: fileName
                    },
                    {
                        extend: 'pdfHtml5',
                        title: fileName
                    },
                    {
                        extend: 'csvHtml5',
                        title: fileName
                    }, {
                        extend: 'print',
                        title: fileName
                    }
                ]
            });

            var selectedTeam = $('#selectedTeam').val();

            if(selectedTeam !=''){
              getTeam();
            }

        });


        function getTeam(){
            var department = $('#department').val();
            var html='';
            if(department!=''){
              $.ajax({
                  url:'<?php echo base_url("report/Team_Workers_List_Con/getTeam")?>',
                  type:'POST',
                  data:{
                      'department':department,
                  },
                  success:function (data) {
                      var json_value = JSON.parse(data);
                        var selectedTeam = $('#selectedTeam').val();
                      if(selectedTeam =='All'){
                        html += "<option value='All' selected >All</option>";
                      }else{
                        html += "<option value='All'>All</option>";
                      }


                      for (var i = 0; i < json_value.length; i++) {



                        if(selectedTeam !=''){
                          if(selectedTeam == json_value[i]['teamId']){
                              html += "<option value='"+json_value[i]['teamId']+"' selected>"+json_value[i]['team']+"</option>";
                          }else{
                              html += "<option value='"+json_value[i]['teamId']+"' >"+json_value[i]['team']+"</option>";
                          }

                        }else{
                          html += "<option value='"+json_value[i]['teamId']+"'>"+json_value[i]['team']+"</option>"
                        }


                      }
                      $('#team').empty().append(html);
                  },
                  error:function (data){
                      sweetAlert('Something Went Wrong','','warning');
                  }
            });
          }
        }

    </script>
