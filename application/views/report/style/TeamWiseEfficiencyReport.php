<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Team Wise Efficiency Report
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
                    <span class="breadcrumb-item active">Team Efficiency</span>
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
               <form action="<?php echo base_url('report/TeamWiseEfficiency_con/getTableData')?>" method="post">
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
<!--
                   <?php
                // print_r($tableData);?> -->

               </form>

            </div>

            <table id="dateWiseEfficTable" class="table dataTable">
                <thead>
                <tr>
                    <!-- <th>Location</th> -->
                    <th>Team</th>
                    <th>Buyer</th>
                    <th>Style</th>
                    <th>Delivery</th>
                    <th>SMV</th>
                    <th>Run Days</th>
                    <th>Workers Count</th>
                    <th>Planned Qty</th>
                    <th>Actual Qty</th>
                    <th>Produced Min</th>
                    <th>Used Min</th>
                    <th>Efficiency</th>
                    <th>QR Lvl</th>
                </tr>
                </thead>
                <tbody>

                <?php
                    if(!empty($tableData)){
                      $totalWorkerCount  = 0;
                      $totalPlanedQty = 0;
                      $totalOutQty = 0;
                      $totaProduceMin = 0;
                      $totalUsedMin = 0;
                      $previLine = '';
                      $thisLineEffAlreadyCal = 'no';
                        for($i=0;$i<count($tableData);$i++){
                          if($tableData[$i]->line == $tableData[$i+1]->line){
                            $workingMin =  (double)$tableData[$i]->workingHour * $tableData[$i]->minuuteForHour;
                            $workingMinNextRow =  (double)$tableData[$i+1]->workingHour * $tableData[$i+1]->minuuteForHour;

                            $produceMin = $tableData[$i]->actualOutQty * (float)$tableData[$i]->smv;
                            $produceMinNextRow = $tableData[$i+1]->actualOutQty * (float)$tableData[$i+1]->smv;


                            $totaProduceMin += ($produceMin+$produceMinNextRow);
                            $usedMin = (double)$tableData[$i]->workersCount * $workingMin;
                            $usedMinNext = (double)$tableData[$i+1]->workersCount * $workingMinNextRow;

                            $totalUsedMin += ($usedMin+$usedMinNext);

                            $lineEff = ($produceMin+$produceMinNextRow)/($usedMin+$usedMinNext)*100;
                            $totalWorkerCount +=  (double)$tableData[$i]->workersCount;
                          }else if($thisLineEffAlreadyCal == "yes"){
                            $workingMin =  (double)$tableData[$i]->workingHour * $tableData[$i]->minuuteForHour;
                            $produceMin = 0;
                            $produceMin = $tableData[$i]->actualOutQty * (float)$tableData[$i]->smv;
                            $usedMin = 0;
                            $usedMin = (double)$tableData[$i]->workersCount * $workingMin;
                          }else{
                              $totalWorkerCount +=  (double)$tableData[$i]->workersCount;
                            $workingMin =  (double)$tableData[$i]->workingHour * $tableData[$i]->minuuteForHour;
                            $produceMin = 0;
                            $produceMin = $tableData[$i]->actualOutQty * (float)$tableData[$i]->smv;
                            $totaProduceMin += $produceMin;
                            $usedMin = 0;
                            $usedMin = (double)$tableData[$i]->workersCount * $workingMin;
                            $totalUsedMin += $usedMin;
                          }
                          $previLine = $tableData[$i]->line;
                          $totalPlanedQty += $tableData[$i]->totalPlanQty;
                          $totalOutQty += $tableData[$i]->actualOutQty;


                            ?>
                        <tr>
                              <?php if($previLine == $tableData[$i+1]->line){
                                // $thisLineEffAlreadyCal = "yes";
                              ?>
                                <td rowspan="2"><?php echo $tableData[$i]->line;;?></td>
                              <?php
                            }else if($thisLineEffAlreadyCal !="yes"){
                              ?>
                                <td><?php echo $tableData[$i]->line;?></td>
                              <?php

                            }
                                ?>
                            <!-- <td><?php //echo $tableData[$i]->line;?></td> -->
                            <td><?php echo $tableData[$i]->buyer;?></td>
                            <td><?php echo $tableData[$i]->style;?></td>
                            <td><?php echo $tableData[$i]->delivery;?></td>
                            <td><?php echo $tableData[$i]->smv;?></td>
                            <td><?php echo $tableData[$i]->runDay;?></td>
                            <td><?php echo $tableData[$i]->workersCount;?></td>
                            <td><?php echo $tableData[$i]->totalPlanQty;?></td>
                            <td><?php echo $tableData[$i]->actualOutQty;?></td>
                            <td><?php echo $tableData[$i]->actualOutQty * (float)$tableData[$i]->smv;?></td>
                            <td><?php echo (double)$tableData[$i]->workersCount * $workingMin;?></td>
                            <?php if($previLine == $tableData[$i+1]->line){
                              $thisLineEffAlreadyCal = "yes";
                            ?>
                              <td rowspan="2"><?php echo number_format($lineEff,2).'%';?></td>
                            <?php
                          }else if($thisLineEffAlreadyCal !="yes"){
                            ?>
                              <td><?php echo $tableData[$i]->efficiency.'%';?></td>
                            <?php

                          }else{
                              $thisLineEffAlreadyCal = "no";
                          }
                              ?>

                            <td><?php echo $tableData[$i]->qr_level.'%';?></td>
                        </tr>
                    <?php
                        }
                        $factoryEff = (double)(($totaProduceMin/$totalUsedMin)*100);

                        ?>
                        <td colspan="6" style="font-weight:bold;font-size:16px;" class="text-center"><i>Factory Total</i></td>
                        <td style="font-weight:bold;font-size:16px;"><?php echo $totalWorkerCount;?></td>
                        <td style="font-weight:bold;font-size:16px;"><?php echo $totalPlanedQty;?></td>
                        <td style="font-weight:bold;font-size:16px;"><?php echo $totalOutQty;?></td>
                        <td style="font-weight:bold;font-size:16px;"><?php echo number_format((float)$totaProduceMin, 2, '.', '');?></td>
                        <td style="font-weight:bold;font-size:16px;"><?php echo number_format((float)$totalUsedMin, 2, '.', '');?></td>
                        <td style="font-weight:bold;font-size:16px;"><?php echo number_format((float)$factoryEff, 2, '.', '')."%";?></td>
                        <td></td>
                        <?php
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
        //
        //     $('#dateWiseEfficTable').DataTable({
        //         retrieve: true,
        //         buttons: [
        //             {
        //                 extend: 'excelHtml5',
        //                 title: 'Date Wise Efficiency'
        //             },
        //             {
        //                 extend: 'pdfHtml5',
        //                 title: 'Date Wise Efficiency'
        //             },
        //             {
        //                 extend: 'csvHtml5',
        //                 title: 'Date Wise Efficiency'
        //             }, {
        //                 extend: 'print',
        //                 title: 'Date Wise Efficiency'
        //             }
        //         ]
        //     });
        //
        //
        });


    </script>
