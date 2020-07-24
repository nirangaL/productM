<script src="<?php echo base_url()?>assets/js/productm/year_effi_dashboard.js"></script>

<style>
  .bg-gray-light-m{
    background-color:#b2bec3;
    color:blanchedalmond;
  }
  .bg-gray-light-d{
    background-color:#dfe6e9;
    color:blanchedalmond;
  }

  .bg-gray-light-m span{
    font-weight: bold;
    font-size: 14px;
  }
  .bg-gray-light-d span{
    font-weight: bold;
    font-size: 12px;
  }
</style>


<div class="content-wrapper">
  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
      <div class="d-flex">
        <div class="breadcrumb">
          <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
          <span class="breadcrumb-item active">Dashboard</span>
        </div>

        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
      </div>

      <div class="header-elements d-none">
        <div class="breadcrumb justify-content-center">
          <a href="#" class="breadcrumb-elements-item">
            <i class="icon-comment-discussion mr-2"></i>
            Support
          </a>

          <div class="breadcrumb-elements-item dropdown p-0">
            <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
              <i class="icon-gear mr-2"></i>
              Settings
            </a>

            <div class="dropdown-menu dropdown-menu-right">
              <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
              <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
              <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page header -->

  <div class="content">

    <?php 
          $yearProduceMin = 0;
          $yearUsedMin = 0;

          // echo $selectYear;
    
    ?>

     <form action="<?php echo base_url('YearEfficiency/getYearData')?>" method="POST">
      <div class="row text-center mb-3">
          <div class="col-sm-4"></div>
          <?php if($this->MyConUserGroup == '1' || $this->MyConUserGroup == '13'){ ?>
          <div class="col-sm-2">
            <select name="location" id="location" class="select" data-placeholder="Select Location">
              <option value=""></option>
              <?php 
              $userAssignedLocation = $_SESSION['session_user_data']['location'];
               if(count($locations) > 0){
                  foreach ($locations as $location) {
                   ?>
                    <option value="<?php echo $location->id; ?>"
                    <?php 
                    if($selectLocation == $location->id){echo 'selected';}
                    ?>  
                    ><?php echo $location->location;?></option>
                   <?php
                  }
               }
              ?>
            </select>
          </div>
              <?php } ?>
          <div class="col-sm-2">
            <select name="year" id="year" class="select" data-placeholder="Select Year">
            <option value=""></option>
              <?php 
               if(count($years) > 0){
                  foreach ($years as $year) {
                  
                   ?>
                    <option value="<?php echo $year->year; ?>" 
                      <?php
                        if($selectYear == $year->year){echo 'selected';}
                      ?>
                    ><?php echo $year->year;?></option>
                   <?php
                  }
               }
              ?>
            </select>
          </div>
          <div class="col-sm-2 text-left">
            <input type="submit" class="btn btn-default" value="Find">
          </div>
          <div class="col-sm-2"></div>
      </div>
       </form>

      <!-- Charts -->
      <div class="row">
          <div class="col-md-4">
              <!-- Basic gauge chart -->
              <div class="card">
                  <div class="card-header header-elements-inline">
                      <h5 class="card-title"></h5>
                      <div class="header-elements">
                          <div class="list-icons">
                              <a class="list-icons-item" data-action="collapse"></a>
                              <a class="list-icons-item" data-action="reload"></a>
                          </div>
                      </div>
                  </div>
                  <div class="card-body">
                      <div class="chart-container">
                          <div class="chart has-fixed-height" id="gauge_basic"></div>
                      </div>
                  </div>
              </div>
              <!-- /basic gauge chart -->
          </div>
          <div class="col-md-8">
              <!-- Basic columns -->
              <div class="card">
                  <div class="card-header header-elements-inline">
                      <h5 class="card-title">Monthly Efficiency</h5>
                      <div class="header-elements">
                          <div class="list-icons">
                              <a class="list-icons-item" data-action="collapse"></a>
                          </div>
                      </div>
                  </div>

                  <div class="card-body">
                      <div class="chart-container">
                          <div class="chart has-fixed-height" id="columns_basic"></div>
                      </div>
                  </div>
              </div>
              <!-- /basic columns -->
          </div>
      </div>
       <!-- Charts -->

      <div class="row">
            <div class="accordion-sortable" id="accordion-controls" style="width: 100%">
            
               <?php 
                if($data != 'Nodata'){
                  $preMonth = '';
                  $i = 0;
                  foreach($data as $row) {
                    if($preMonth != $row->month){
                      $preMonth = $row->month;

                      $monthTotPlanQty = 0;
                      $monthTotActOut = 0;
                      $monthTotHour = 0;
                      $monthTotProduMin= 0;
                      $monthTotUsedMin = 0;
                      $monthEff = 0;
                      $dataRowCount = count($data);
                      $date = '';
                      for($y=0;$y< $dataRowCount;$y++){
                          if($preMonth == $data[$y]->month){

                           $monthTotPlanQty += (int)$data[$y]->totalPlanQty;
                            $monthTotActOut += (int)$data[$y]->actualOutQty;
                            $acutalOut = 0;

                            if($data[$y]->dayPlanType == '4' && ($date == $data[$y]->dateTime || $date=='')){
                              if($data[$y+1]->dayPlanType == '4' && ($data[$y+1])){
                                $acutalOut = $data[$y]->actualOutQty;
                              }else{
                                $monthTotProduMin += ((int)$data[$y]->actualOutQty + $acutalOut) *  $data[$y]->smv;
                                $monthTotUsedMin += (float)$data[$y]->workersCount * ((float)$minuteForHour * $data[$y]->workingHour);
                                $monthTotHour +=(float)$data[$y]->workingHour;
                              }
                            }else{
                              $monthTotProduMin += ((int)$data[$y]->actualOutQty) *  $data[$y]->smv;
                              $monthTotUsedMin += (float)$data[$y]->workersCount * ((float)$minuteForHour * (float)$data[$y]->workingHour);
                              $monthTotHour += (float)$data[$y]->workingHour;
                            }
                            $date = $data[$y]->dateTime;
                          }
                      }
                     
                      $yearProduceMin += $monthTotProduMin;
                      $yearUsedMin += $monthTotUsedMin;

                      $monthEff  = ($monthTotProduMin/ $monthTotUsedMin) * 100;
                      $monthTotProduMin =  number_format( $monthTotProduMin, 2, '.', '');
                      $monthTotUsedMin = number_format( $monthTotUsedMin, 2, '.', '');
                      $monthEff =  number_format($monthEff, 2, '.', '');

                      ?>
                    <div class="card">
                        <div class="card-header header-elements-inline bg-gray-light-m">
                          <div class="card-title row " style="width: 100%;" >
                            <div class="col-sm-1">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"></span><span class="text-slate-800"> <?php 
                              $monthNum  = $row->month;
                              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                              $monthName = $dateObj->format('F'); // March
                              echo $monthName;

                           

                            ?></span></a>
                               <script>
                                // console.log(month['<?php echo (int)$monthNum;?>']);
                                  monthEffi['<?php echo (int)$monthNum-1;?>'] = <?php echo $monthEff;?>
                                
                              </script>
                            </div>
                            <!-- <div class="col-sm-"></div> -->
                            <div class="col-sm-1">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"> M.Plan Out :</span><span class="text-slate-800"> <?php echo $monthTotPlanQty;?></span></a>
                            </div>
                            <div class="col-sm-2">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"> M.Act.Out :</span><span class="text-slate-800"> <?php echo $monthTotActOut;?></span></a>
                            </div>
                            <div class="col-sm-2">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"> M.Worked Hour :</span><span class="text-slate-800"> <?php echo $monthTotHour;?></span></a>
                            </div>
                            <div class="col-sm-2">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"> M.Produced Min :</span><span class="text-slate-800"> <?php echo $monthTotProduMin;?></span></a>
                            </div>
                            <div class="col-sm-2">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"> M.Used Min :</span><span class="text-slate-800"> <?php echo $monthTotUsedMin;?></span></a>
                            </div>
                            <div class="col-sm-2">
                            <a data-toggle="collapse" class="text-default" href="#monthHeader<?php echo $i;?>"><span class="summary text-slate-600"> M.Efficiency :</span><span class="text-slate-800"> <?php echo $monthEff.'%';?></span></a>
                            </div>
                          </div>

                          <div class="header-elements">
                            <div class="list-icons">
                                      <a class="list-icons-item" data-action="fullscreen"></a>
                                    </div>
                            </div>
                        </div>

                        <div id="monthHeader<?php echo $i;?>" class="collapse" data-parent="#accordion-controls">


                        <div class="card-body">
                              <?php
                                     $preDate = '';
                                     $x = 0;
                                    foreach ($data as $rowForDate) {
                                      if($preMonth == $rowForDate->month &&  $preDate != $rowForDate->dateTime){
                                        $preDate = $rowForDate->dateTime;

                                        $dayTotPlanQty = 0;
                                $dayTotActOut = 0;
                                $dayTotHour = 0;
                                $dayTotProduMin= 0;
                                $dayTotUsedMin = 0;
                                $dayEff = 0;
                                $dataRowCount = count($data);
                                $date = '';
                      for($y=0;$y< $dataRowCount;$y++){
                          if($preMonth == $data[$y]->month && $data[$y]->dateTime == $preDate) {

                           $dayTotPlanQty += (int)$data[$y]->totalPlanQty;
                            $dayTotActOut += (int)$data[$y]->actualOutQty;
                            $acutalOut = 0;

                            if($data[$y]->dayPlanType == '4' && ($date == $data[$y]->dateTime || $date=='')){
                              if($data[$y+1]->dayPlanType == '4' && ($data[$y+1])){
                                $acutalOut = $data[$y]->actualOutQty;
                              }else{
                                $dayTotProduMin += ((int)$data[$y]->actualOutQty + $acutalOut) *  $data[$y]->smv;
                                $dayTotUsedMin += (float)$data[$y]->workersCount * ((float)$minuteForHour * $data[$y]->workingHour);
                                $dayTotHour +=(float)$data[$y]->workingHour;
                              }
                            }else{
                              $dayTotProduMin += ((int)$data[$y]->actualOutQty) *  $data[$y]->smv;
                              $dayTotUsedMin += (float)$data[$y]->workersCount * ((float)$minuteForHour * (float)$data[$y]->workingHour);
                              $dayTotHour += (float)$data[$y]->workingHour;
                            }
                            $date = $data[$y]->dateTime;
                          }
                      }
                     
                      $dayEff  = ($dayTotProduMin/ $dayTotUsedMin) * 100;
                      $dayTotProduMin =  number_format( $dayTotProduMin, 2, '.', '');
                      $dayTotUsedMin = number_format( $dayTotUsedMin, 2, '.', '');
                      $dayEff =  number_format($dayEff, 2, '.', '');

                                        ?>
                                    <!-- Date wise-->
                                      <div class="collapsible-sortable">
                                        <div class="card">
                                          <div class="card-header header-elements-inline bg-gray-light-d">
                                            <div class="card-title row" style="width: 100%;">
                                              
                                                <div class="col-sm-1">
                                                <a data-toggle="collapse" class="text-default" href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"></span><span class="text-slate-800"> <?php 
                                                  $time=strtotime($preDate);
                                                  $month=date("F",$time);
                                                  $year=date("Y",$time);
                                                  $day=date("j",$time);

                                                  echo $day.' '.$month;
                                                
                                                ?></span></a>
                                                </div>
                                                <!-- <div class="col-sm-"></div> -->
                                                <div class="col-sm-1">
                                                <a data-toggle="collapse" class="text-default" href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"> D.Plan Out :</span><span class="text-slate-800"> <?php echo $dayTotPlanQty;?></span></a>
                                                </div>
                                                <div class="col-sm-2">
                                                <a data-toggle="collapse" class="text-default" href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"> D.Act.Out :</span><span class="text-slate-800"> <?php echo $dayTotActOut;?></span></a>
                                                </div>
                                                <div class="col-sm-2">
                                                <a data-toggle="collapse" class="text-default"href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"> D.Worked Hour :</span><span class="text-slate-800"> <?php echo $dayTotHour;?></span></a>
                                                </div>
                                                <div class="col-sm-2">
                                                <a data-toggle="collapse" class="text-default" href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"> D.Produced Min :</span><span class="text-slate-800"> <?php echo $dayTotProduMin;?></span></a>
                                                </div>
                                                <div class="col-sm-2">
                                                <a data-toggle="collapse" class="text-default" href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"> D.Used Min :</span><span class="text-slate-800"> <?php echo $dayTotUsedMin;?></span></a>
                                                </div>
                                                <div class="col-sm-2">
                                                <a data-toggle="collapse" class="text-default" href="#date<?php echo $i.''.$x;?>"><span class="summary text-slate-600"> D.Efficiency :</span><span class="text-slate-800"> <?php echo $dayEff.'%';?></span></a>
                                                </div>

                                              </div>
                                            
                                           

                                            <div class="header-elements">
                                              <div class="list-icons">
                                                <a class="list-icons-item" data-action="fullscreen"></a>
                                              </div>
                                            </div>
                                          </div>

                                          <div id="date<?php echo $i.''.$x;?>" class="collapse" style="width: 100%">
                                            <div class="card-body">
                                              <div class="table-responsive ">
                                              <table class="table dataTable">
                                                <thead>
                                                  <th>Team</th>
                                                  <th>Style</th>  
                                                  <th>SMV</th>  
                                                  <th>Workers</th>   
                                                  <th>Hours</th>   
                                                  <th>Plan Out</th>
                                                  <th>Act Out</th>
                                                  <th>Plan Eff</th>
                                                  <th>Act Eff</th>
                                                  <th>Qr Level</th>
                                                </thead>
                                                  <tbody>
                                                    <?php
                                                      $preTeam = '';
                                                      foreach ($data as $team) {
                                                        if($preMonth == $team->month && $preDate == $team->dateTime){
                                                          // $preTeam = $line_id;
                                                          ?>  
                                                          <tr>
                                                          <td><?php echo $team->line;?></td>
                                                          <td><?php echo $team->style;?></td>
                                                          <td><?php echo $team->smv;?></td>
                                                          <td><?php echo $team->workersCount;?></td>
                                                          <td><?php echo $team->workingHour?></td>
                                                          <td><?php echo $team->totalPlanQty;?></td>
                                                          <td><?php echo $team->actualOutQty;?></td>
                                                          <td><?php echo $team->forcastEffi;?></td>
                                                          <td><?php echo $team->efficiency;?></td>
                                                          <td><?php echo $team->qr_level;?></td>
                                                          </tr>
                                                          <?php
                                                        }
                                                      }

                                                    ?>
                                                </tbody>
                                              </table>
                                              </div>
                                              
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- /collapsible date wise -->

                                        <?php
                                      }
                                      $x++;
                                    }
                                  
                              ?>
                          </div>

                        </div>
                    </div>
                      <?php
                    }

                    $i++;
                  }
                }
               ?>
              
						</div>
						<!-- /accordion with controls -->


      </div>

  </div>


<script>
$(document).ready(function(){
  $('.dataTable').dataTable({
    "paging":   false,
        // "ordering": false,
        "info":     false,
        "bFilter": false,
      }
  );

  yearEffi.push(<?php echo (($yearProduceMin/$yearUsedMin)*100); ?>.toFixed(2));

});
</script>