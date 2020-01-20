
<style>
/* #teamData tr:nth-child(even) {background: #FCF8E8} */
#myPopoverContent {display: none; float: right;}
.popover{
    width:700px;
}

#test {margin-left: 250px;}

.names{
  font-weight: bold;
}

.qty{
  font-weight: bold;
}
.effi{
  background:#f1f2f6;
  /* font-weight: bold;  */
}


.cr-qty{
  background:#93d6b0 !important;
  font-weight: bold;
  color:black !important;
  /* background:red; */
}
.cr-effi{
  background: #66b98a !important;
  /* background:red; */
  color:black !important;
}

#hourlyOutTBody tr:hover td{
  background: #706fd3 ;
  color:white;
  /* font-size: .8300rem */
}


#tv-icon{
  cursor: pointer;
}

.summary{
  font-size:15px;
  font-family: inherit;
}

.summary span{
  font-weight: bold;
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


  <!-- Content area -->
  <div class="content">

  <!-- <?php 
  //  print_r($sessionData);
  ?> -->
    <!-- Gauges -->
    <div class="row">
      <div class="col-md-8">
        <div class="card" >
          <div class="card-header header-elements-inline">
            <h5 class="card-title">Efficiency Of Production Team</h5>
            <div class="header-elements">
              <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="chart-container">
              <div class="chart has-fixed-height" id="columns_clustered"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <!-- Basic gauge chart -->
        <div class="card" >
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
    </div>
    <!-- /gauges -->

    <!-- Dashboard content -->

    <!-- /quick stats boxes -->
    <!--View Production Team -->
    <div class="card" >
      <div class="card-header header-elements-sm-inline">
        <h5 class="card-title">View Production Team</h5>
        <span class="summary text-slate-600">Total Workers : <span id="totWorker" class="text-slate-800"></span></span>
        <span class="summary text-slate-600">No. of Style : <span id="totStyle" class="text-slate-800"></span></span>
        <span class="summary text-slate-600">Total Plan Qty : <span id="totPlan" class="text-slate-800"></span></span>
        <span class="summary text-slate-600">Total Out Qty : <span id="totOut" class="text-slate-800"></span></span>
        
        <div class="header-elements">
          <div class="list-icons">
          <button type="button" data-toggle="modal" data-target="#modal_full" class="btn btn-dark" ><i class="icon-alarm mr-2"></i> Hourly Progress</button>
            <a class="list-icons-item" data-action="collapse"></a>
            <!-- <a class="list-icons-item" data-action="reload"></a> -->
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table text-nowrap">
          <thead>
            <tr>
              <th>Team</th>
              <th>Buyer</th>
              <th>Style</th>
              <th>SMV</th>
              <th>Run.Days</th>
              <th>Workers</th>
              <th>Plan.Qty</th>
              <th>Out.Qty</th>
              <th>Plan.Effi%</th>
              <th>Effi%</th>
              <th>QR.Lvl%</th>
              <th>Incen</th>
              <th>Status</th>
              <th>Actions</th>
            <tr>
          </thead>
          <tbody id="teamData">

          </tbody>
        </table>
      </div>
    </div>
    <!-- /View Production Team -->

    <div class="row">
      <div class="col-lg-2">
        <!-- Members online -->
        <div class="card bg-teal-400" data-toggle="modal" data-target="#wokerModal" style="cursor:pointer;">
          <div class="card-body">
            <div class="d-flex">
              <h1 class="font-weight-semibold mb-0" id="workerCount"></h1>
              <!--                                    <span class="badge bg-teal-800 badge-pill align-self-center ml-auto">+53,6%</span>-->
              <div class="list-icons ml-auto">
                <div class="list-icons-item ">
                  <i class="icon-collaboration" style="font-size: 35px;"></i>
                </div>
              </div>
            </div>

            <div>
              <span class="font-size-lg">Employees are working on Production</span>
              <!-- <div class="font-size-md opacity-75"><span id="avgWorkers"></span> avg for a Teem</div> -->
            </div>
          </div>
        </div>
        <!-- /members online -->

      </div>
      <div class="col-lg-2">
        <!-- Members online -->
        <a href="<?php echo base_url('qcDashboard')?>">
          <div class="card bg-warning-400">
            <div class="card-body">
              <div class="d-flex">
                <h1 class="font-weight-semibold mb-0" id="totalDefect"></h1>
                <!--                                    <span class="badge bg-teal-800 badge-pill align-self-center ml-auto">+53,6%</span>-->
                <div class="list-icons ml-auto">
                  <div class="list-icons-item ">
                    <i class="icon-loop" style="font-size: 35px;"></i>
                  </div>
                </div>
              </div>

              <div>
                <span class="font-size-lg">Click to see more details of defect</span>
                <!-- <div class="font-size-md opacity-75"><span id="avgWorkers"></span> avg for a Teem</div> -->
              </div>
            </div>
          </div>
        </a>
        <!-- /members online -->

      </div>
    </div>

    <!-- Zoom option -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Factory Efficiency Of Previous Days </h5>
            <div class="header-elements">
              <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
              </div>
            </div>
					</div>

					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="line_values"></div>
						</div>
					</div>
				</div>
				<!-- /zoom option -->

  </div>


  <!-- Basic modal -->
 				<div id="wokerModal" class="modal fade" tabindex="-1">
 					<div class="modal-dialog modal-lg ">
 						<div class="modal-content">
 							<div class="modal-header bg-teal">
 								<h5 class="modal-title">Team Wise Head Count</h5>
 								<button type="button" class="close" data-dismiss="modal">&times;</button>
 							</div>

 							<div  class="modal-body">
                <div id="workerModalBody" class="row">
                <!-- <div id="workerModalBody" class="col-sm-12"> -->

                <!-- </div> -->
                </div>
 							</div>

 							<div class="modal-footer">
 								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
 							</div>
 						</div>
 					</div>
 				</div>
         <!-- /basic modal -->
         
         <!-- Full width modal -->
				<div id="modal_full" class="modal fade" tabindex="-1">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header bg-dark">
								<h5 class="modal-title"><i class="icon-alarm mr-2"></i> Hourly Progress</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
              <div class="table-responsive">
                <table id="hourlyOut" class="table text-nowrap table-bordered">
                  <thead id="hourlyOutTHead"></thead>
                  <tbody id="hourlyOutTBody"></tbody>
                </table>
              </div>
							</div>
						</div>
					</div>
				</div>
				<!-- /full width modal -->

  <script type="">

    var hourLength = 0;
    var loopStart = 1;
    $(document).ready(function () {
      getAllData();
    });

    var timeTicket = setInterval(function () {
      getAllData();
    }, 30000);


    function getAllData() {

      var totalWorkers = 0;
      var totalPlanQty = 0;
      var totalOutQty = 0;
      var totalDefectQty = 0;
      var styleArray = [];

      $.ajax({
        url:'<?php echo base_url("Location_Dashboard_Con/getLocationData") ?>',
        type:'POST',
        data:({

        }),
        success:function(data) {
          if(data!=null){

            var runTeamCount = 0;
            var workerCount = 0;
            var json_value = JSON.parse(data);

            if(json_value['LocaEffi'] != "nan"){
              LocaEffi = json_value['LocaEffi'];
            }else{
              LocaEffi = 0;
            }

            var dataVal = [];
            var forcastEffVal = [];
            var facEffVal = [];
            if(date.length == 0 ){
              for(var y=0;y<json_value['monthlyEffi'].length;y++){
                dateVal = json_value['monthlyEffi'][y]['date'];
                forcastEffVal = json_value['monthlyEffi'][y]['focastEffi'];
                facEffVal = json_value['monthlyEffi'][y]['effi'];
                date.push(dateVal);
                focastEff.push(forcastEffVal);
                facEff.push(facEffVal);
              }
            }

            team=[];
            expectEff=[];
            actualEff=[];

            var html = '';
            var teamsSize = json_value['team'].length;

            $('#teamData').empty();
            // $('#hourlyOutTHead').empty();
            $('#hourlyOutTBody').empty();
            for(var i=0;i<teamsSize;i++){
              team.push(json_value['team'][i]);
              forEff = 0;
              actEf = 0;
              if(json_value['tvData'][i] == null ){
                forEff = 0;
                actEf = 0;
              }else{
                // console.log(json_value['tvData'][i]['gridData'].length);
                if(Array.isArray(json_value['tvData'][i]['gridData']) && json_value['tvData'][i]['gridData'].length){
                  // console.log(i);
                for(var x=0;x<json_value['tvData'][i]['gridData'].length;x++){
                  forEff = json_value['tvData'][i]['gridData'][x]['ForEff'];
                  actEf = json_value['tvData'][i]['gridData'][x]['actEff'];
                  // console.log(json_value['team'][i]+" -"+forEff +" "+actEf);
                }
                }
               
                runTeamCount +=1;
              }
              expectEff.push(forEff);
              actualEff.push(actEf);

              var teamName = json_value['team'][i];
              var style = '-';
              var delv = '-';
              var runDay = '-';
              var pQty = '-';
              var aQty = '-';
              var effi = '-';
              var qrL = '-';
              var status = '-';
              var neededQtyAtTime = '-';
              var neededQrLvl = '-';
              var incentive = '-';
              var smv = '-';
              var noOfwokers = '-';
              var currentHour = '-';
              if(json_value['tvData'][i]['gridData'] != null){
                var dayPlanLength = json_value['tvData'][i]['gridData'].length;
                totalWorkers += parseFloat(json_value['tvData'][i]['gridData'][(dayPlanLength-1)]['noOfwokers']);
                for(var x=0;x<dayPlanLength;x++){
                  teamName = json_value['tvData'][i]['gridData'][x]['lineName'];
                  dayPlanType = json_value['tvData'][i]['gridData'][x]['dayPlanType'];
                  buyer = json_value['tvData'][i]['gridData'][x]['buyer'];
                  style = json_value['tvData'][i]['gridData'][x]['style'];
                  noOfwokers = json_value['tvData'][i]['gridData'][x]['noOfwokers'];
                  runDay = json_value['tvData'][i]['gridData'][x]['styleRunDatys'];
                  aQty = json_value['tvData'][i]['gridData'][x]['lineOutQty'];
                  ForEff = json_value['tvData'][i]['gridData'][x]['ForEff'];
                  effi = json_value['tvData'][i]['gridData'][x]['actEff'];
                  qrL = json_value['tvData'][i]['gridData'][x]['actualQrLevel'];
                  incentive = json_value['tvData'][i]['gridData'][x]['incentive'];
                  neededQrLvl = json_value['tvData'][i]['gridData'][x]['needQrLvl'];
                  status = json_value['tvData'][i]['gridData'][x]['status'];
                  smv = json_value['tvData'][i]['gridData'][x]['smv'];
                  currentHour = parseInt(json_value['tvData'][i]['gridData'][x]['currentHr']);
                  totalDefectQty += parseInt(json_value['tvData'][i]['gridData'][x]['defectQty']);

                  
                  if(jQuery.inArray(style, styleArray) !== -1){}else{styleArray.push(style)}
  
                   
                  if(dayPlanType=='4'){
                    pQty = json_value['tvData'][i]['gridData'][x]['styleDayPlanQty'];
                    neededQtyAtTime = json_value['tvData'][i]['gridData'][x]['styleNeedQty'];
                  }else{
                    pQty = json_value['tvData'][i]['gridData'][x]['dayPlanQty'];
                    neededQtyAtTime = json_value['tvData'][i]['gridData'][x]['neededQtyAtTime'];
                  }

                 
                  totalPlanQty += parseInt(pQty);
                  totalOutQty += parseInt(aQty);

                  if(json_value['tvData'][i]['gridData'][x]['whatData'] == 'feeding'){
                    html += "<tr>";
                    html += "<td>" + teamName + "</td>";
                    html += "<td>" + buyer + "</td>";
                    html += "<td>" + style + "</td>";
                    html += "<td colspan='8' style='color:orange;text-align:center;font-weight:bold;'>Feeding...</td>";
                    html += "</tr>";
                  }else{
                    html += "<tr>";
                    if(x==0){
                      html += "<td rowspan='"+json_value['tvData'][i]['gridData'].length+"'>" + teamName + "</td>";
                    }
                    html += "<td>" + buyer + "</td>";
                    html += "<td>" + style + "</td>";
                    html += "<td>" + smv + "</td>";
                    html += "<td>" + runDay + "</td>";
                    html += "<td>" + noOfwokers + "</td>";
                    html += "<td>" + pQty + "</td>";

                    if(neededQtyAtTime != '-'){
                      html += "<td>" + aQty + " / "+ neededQtyAtTime +"</td>";
                    }else{
                      html += "<td>" + '-' +"</td>";
                    }

                    if(dayPlanType == "4" ){
                        if(json_value['tvData'][i]['gridData'].length != (x+1)){
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['ForEff'] + "</td>";
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['actEff'] + "</td>"; 
                        }

                    }else if(((json_value['tvData'][i]['gridData'].length)-1) == (x+1)){
                       if(json_value['tvData'][i]['gridData'][(x)]['dayPlanType'] == "2" && json_value['tvData'][i]['gridData'][(x+1)]['dayPlanType'] == "1"){
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['ForEff'] + "</td>";
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['actEff'] + "</td>"; 
                        }else if(json_value['tvData'][i]['gridData'][(x)]['dayPlanType'] == "1" && json_value['tvData'][i]['gridData'][(x+1)]['dayPlanType'] == "2"){
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['ForEff'] + "</td>"; 
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['actEff'] + "</td>";           
                        }else if(json_value['tvData'][i]['gridData'][(x+1)]['dayPlanType'] == "2"){
                          // html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['actEff'] + "</td>";
                        } 
                    }else if((json_value['tvData'][i]['gridData'].length) == 2){
                     
                    }else{
                      html += "<td>" + ForEff + "</td>";
                      html += "<td>" + effi + "</td>";
                    }

                    if(dayPlanType == "4"){
                        if(json_value['tvData'][i]['gridData'].length != (x+1)){
                          if(neededQrLvl <= parseFloat(json_value['tvData'][i]['gridData'][(x+1)]['actualQrLevel'])){
                          html += "<td rowspan='2' style='color:green;font-weight:bold;'>" + json_value['tvData'][i]['gridData'][(x+1)]['actualQrLevel'] + "</td>";
                          }else{
                            html += "<td rowspan='2' style='color:red;font-weight:bold;'>" + json_value['tvData'][i]['gridData'][(x+1)]['actualQrLevel'] + "</td>";
                          }
                        }
                        
                    }else{
                      if(neededQrLvl <= parseFloat(qrL)){
                      html += "<td style='color:green;font-weight:bold;'>" + qrL + "</td>";
                    }else{
                      html += "<td style='color:red;font-weight:bold;'>" + qrL + "</td>";
                    }
                    }

                    if(dayPlanType == "4" ){
                        if(json_value['tvData'][i]['gridData'].length != (x+1)){
                          html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['incentive'] + "</td>";
                        }
                    }else {
                      html += "<td>" + incentive + "</td>";
                    }

                    // html += "<td>" + incentive + "</td>";

                    if ( status == 'up') {
                      html += "<td><span class='badge bg-success-400'>Up</span></td>";

                    } else if (status == 'down') {
                      html += "<td><span class='badge bg-danger'>Down</span></td>";
                    } else {
                      html += "<td>'-'</td>";
                    }
                    if(x==0){
                      html += "<td rowspan='"+json_value['tvData'][i]['gridData'].length+"' class='text-center'><i id='tv-icon' class='icon-display mr-2' onclick='showTeamDash("+json_value['tvData'][i]['gridData'][(x)]['line']+")'></i></td>";
                    }
                    
                    html += "</tr>";

                  }
                 
                }
                hourLength = 0;
                loopStart = 1;
                for(var x=0;x<json_value['tvData'][i]['hourlyData'].length;x++){
                  hourlyOut(teamName,json_value['tvData'][i]['hourlyData'][x],style,currentHour);
                }
              }else{
                html +="<tr>";
                html +="<td>"+json_value['team'][i]+"</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td>-</td>";
                html +="<td class='text-center'>-</td>";
                html +="<tr>";
              }
             
            }      
            workerDetailsModal(json_value['team'],json_value['teamWorkers']);
            $('#totWorker').text(totalWorkers);
                $('#totPlan').text(totalPlanQty);
                $('#totOut').text(totalOutQty);
                $('#totalDefect').text(totalDefectQty);
                $('#totStyle').text(styleArray.length);

            $('#teamData').append(html);
          }
        }
      }); /// Close Ajax ///
    }


    function workerDetailsModal(team,workers){
            var totalWorkersCount = 0;
            var html2 = '';
            var teamsSize = team.length;
            for(var i=0;i<teamsSize;i++){

              html2 +="<div class='col-sm-2'>";
              html2 +="<table class='table'>";
                html2 +="<thead>";
                  html2 +="<tr>";
                  html2 +="<th class='text-center bg-teal-800'>"+team[i]+"</th>";
                  // html2 +="<th>Workers</th>";
                  html2 +="</tr>";
                html2 +="</thead>";
                html2 +="<tbody>";
                  html2 +="<tr>";
                  // html2 +="<td>"+json_value['team'][i]+"</td>";
                  if(workers[i]==''){
                    html2 +="<td class='text-center bg-teal-400'> 0 </td>";
                  }else{
                    html2 +="<td class='text-center bg-teal-400'>"+workers[i]['0']['workers']+"</td>";
                    totalWorkersCount += parseFloat(workers[i]['0']['workers']);
                  }
                  html2 +="</tr>";
                html2 +="</tbody>";
              html2 +="</table>";
              html2 +="</div>";
            }
            $('#workerModalBody').empty().append(html2);
            $('#workerCount').text(totalWorkersCount);
    }

    Object.size = function(obj) {
      var size = 0, key;
      for (key in obj) {
          if (obj.hasOwnProperty(key)) size++;
      }
      return size;
      };

///// globel variable for hourlyOut Function
    var maxHour = 0;
    var hourTotalArray = [];

    function hourlyOut(teamName,hourlyOut,style,currentHour){
      console.log(currentHour);
      // console.log(size);
      var htmlTHead = "";
      var htmlTBody = "";
    
      hourLength += Object.size(hourlyOut);
      
      var totalHourQty = 0;
      var totalTeamQty = 0;
    
      if(maxHour<hourLength){
        maxHour = hourLength;
        htmlTHead +="<tr>";
        htmlTHead +="<th rowspan='2' class='text-center'>Team</th>";
        htmlTHead +="<th rowspan='2' class='text-center'>Style</th>";

          for(var i=0;i<hourLength;i++){
            htmlTHead +="<th colspan='2' class='text-center'>"+(i+1)+" Hour</th>";
          }
          htmlTHead +="</tr>";
          htmlTHead +="<tr>";
          for(var i=0;i<hourLength;i++){ 
            htmlTHead +="<th class='text-center'>QTY</th>";
            htmlTHead +="<th class='text-center'>Effi %</th>";
          }
          htmlTHead +="</tr>";
          $('#hourlyOutTHead').empty().append(htmlTHead);
      }

        
        htmlTBody +="<tr>";
          htmlTBody +="<td class='names'>"+teamName+"</td>";
          htmlTBody +="<td class='names'>"+hourlyOut[loopStart]['style']+"</td>";
       

            for(var i=loopStart;i<=hourLength;i++){

              var effi = (parseFloat(hourlyOut[i]['prodeMin'])/parseFloat(hourlyOut[i]['userMin'])) * 100;
            if(hourlyOut[i]['styleStartHour'] == 1 || hourlyOut[i]['styleStartHour'] == null){
              if(currentHour == i){
                htmlTBody +="<td class='cr-qty'>"+hourlyOut[i]['qty']+"</td>";
                htmlTBody +="<td class='cr-effi'>"+effi.toFixed(2)+"</td>";
              }else{
                htmlTBody +="<td class='qty'>"+hourlyOut[i]['qty']+"</td>";
                htmlTBody +="<td class='effi'>"+effi.toFixed(2)+"</td>";
              }
             
              // hourTotalArray.push((hourTotalArray[i] + parseInt(hourlyOut[i]['qty'])));
            }else{
              htmlTBody +="<td colspan='"+ (parseInt(hourlyOut[i]['styleStartHour'])-1)*2 +"'></td>";
              // htmlTBody +="<td colspan='"+hourlyOut[i]['styleStartHour']+"'></td>";
              for(var x=(parseInt(hourlyOut[i]['styleStartHour'])); x<= hourLength;x++){
                if(currentHour == x){
                  htmlTBody +="<td class='cr-qty'>"+hourlyOut[x]['qty']+"</td>";
                htmlTBody +="<td class='cr-effi'>"+effi.toFixed(2)+"</td>";
                }else{
                  htmlTBody +="<td class='qty'>"+hourlyOut[x]['qty']+"</td>";
                  htmlTBody +="<td class='effi'>"+effi.toFixed(2)+"</td>";
                }
                
                // hourTotalArray.push((hourTotalArray[x] + parseInt(hourlyOut[x]['qty'])));
              }
              break;
            }
          
          }
          loopStart += Object.size(hourlyOut);
          htmlTBody +="</tr>";
          // console.log(hourTotalArray);
        $('#hourlyOutTBody').append(htmlTBody);
        
            // $('#workerCount').text(totalWorkersCount);
    }


    function showTeamDash(team){
      self.close();
      var company  = <?php echo $sessionData['company'] ?>;
      var location  = <?php echo $sessionData['location'] ?>;
      document.cookie = 'company='+company+'';
      document.cookie = 'line='+team+'';
      document.cookie = 'location='+location+'';
 
     my_window = window.open('<?php echo base_url('tv/Tv_Production_Con')?>','TeamTv','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1280,height=760');

    }

</script>
