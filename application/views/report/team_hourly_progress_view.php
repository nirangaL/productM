<style>
    .bold{
        font-weight: bold;
    }

</style>

<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Team Hourly Progress
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
                    <span class="breadcrumb-item active">Team Hourly Progress</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">

<!--            --><?php //print_r($tableData);?>

            <div class="card-body">
               <form action="<?php echo base_url('report/TeamHourlyProgress/getTableData')?>" method="post">
                   <div class="row">
                       <label class="col-form-label col-lg-1">Date : </label>
                       <div class="col-lg-3">
                           <div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar5"></i></span>
										</span>
                               <input id="date" name="date" type="text" class="form-control datepick" value="<?php if($selectDate !=''){echo $selectDate;}else{echo date('Y-m-d');}?>" placeholder="Select a date &hellip;">
                           </div>
                       </div>

                       <label class="col-form-label col-lg-1">Location : </label>
                       <div class="col-lg-2">
                           <select id="location" name="location" class="form-control select-search select2" data-fouc=""
                                   tabindex="-1" >
                               <!-- <option value="All">All</option> -->
                               <?php
                               if (!empty($location)) {
                                   foreach ($location as $row) {
                                       ?>
                                       <option value="<?php echo $row->location_id; ?>" <?php if($row->location_id == $selectLocation){echo 'Selected';}?> > <?php echo $row->location; ?></option>
                                       <?php
                                   }
                               }
                               ?>
                           </select>
                       </div>

                       <div class="col-lg-5">
                           <div class="text-right">
                               <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i>
                               </button>
                           </div>
                       </div>
                   </div>

                   <!-- <?php
                    // echo '<pre>';
                //    print_r($tableData);
                //    echo $maxHour;
                    //  echo '</pre>';?>  -->

               </form>

            </div>

            <table id="temaHourlyProgressTbl" class="table datatable table-bordered">
                <thead>
                <tr>
                    <!-- <th>Location</th> -->


                    <th rowspan="2">Team</th>
                    <th rowspan="2">Style</th>
                    <?php for($i=1;$i<= $maxHour;$i++){
                        ?>
                        <th colspan="2" class="text-center"><?php echo $i.' '?>Hour</th> 
                       
                    <?php } ?>
                    <!-- <th rowspan="2">TotalQty</th> -->
                </tr>
                <tr>
                    <?php for($i=1;$i<= $maxHour;$i++){
                        ?>
                        <th>QTY</th> 
                        <th>Effi %</th> 
                       
                    <?php } ?>
                </tr>
                </thead>
                <tbody>

                <?php
                    if(!empty($tableData)){
                     
                        foreach($tableData as $row){
                            if(!empty($row)){
                          ?>
                            <tr>
                                <td class="bold"><?php echo $row[0]->teamName;?></td>
                                <td class="bold"><?php echo $row[0]->style;?></td>
                                <?php foreach($row as $hour){
                                   ?>
                                    <td class="bold"><?php echo $hour->qty;?></td>
                                    <td><?php echo $hour->effi;?></td>
                                   <?php

                                } ?>

                            </tr>

                          <?php
                          }
                        }
                    }?>
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


            var fileName = 'Team Hourly Progress Report';

            $('#temaHourlyProgressTbl').DataTable({
                retrieve: true,
                "lengthChange": false,
                "bPaginate": false,
                "ordering": false,
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
        });


    </script>
