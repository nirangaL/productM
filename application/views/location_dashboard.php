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
        <h6 class="card-title">View Production Team</h6>
        <div class="header-elements">
          <div class="list-icons">
            <a class="list-icons-item" data-action="collapse"></a>
            <a class="list-icons-item" data-action="reload"></a>
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
              <th>Delv/PO</th>
              <th>Run.Days</th>
              <th>SMV</th>
              <th>Plan.Qty</th>
              <th>Out.Qty</th>
              <th>Effi%</th>
              <th>QR.Lvl%</th>
              <th>Incen</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="teamData">

          </tbody>
        </table>
      </div>
    </div>
    <!-- /View Production Team -->

    <div class="row">
      <div class="col-lg-3">
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


  <script>

  $(document).ready(function () {
    getAllData();
  });

  var timeTicket = setInterval(function () {
    getAllData();
  }, 10000);

  function getAllData() {

    $.ajax({
      url:'<?php echo base_url("Location_Dashboard_Con/getLocationData")?>',
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

          var teamsSize = json_value['team'].length;
          $('#teamData').empty();

          for(var i=0;i<teamsSize;i++){
            team.push(json_value['team'][i]);
            forEff = 0;
            actEf = 0;
            if(json_value['tvData'][i] == null ){
              forEff = 0;
              actEf = 0;
            }else{
              for(var x=0;x<json_value['tvData'][i]['gridData'].length;x++){
                forEff = json_value['tvData'][i]['gridData'][x]['ForEff'];
                actEf = json_value['tvData'][i]['gridData'][x]['actEff'];
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
            var nextS = 0;
            var smv = '';

            if(json_value['tvData'][i] != null){
              for(var x=0;x<json_value['tvData'][i]['gridData'].length;x++){
                teamName = json_value['tvData'][i]['gridData'][x]['lineName'];
                buyer = json_value['tvData'][i]['gridData'][x]['buyer'];
                style = json_value['tvData'][i]['gridData'][x]['style'];
                delv = json_value['tvData'][i]['gridData'][x]['delivery'];
                runDay = json_value['tvData'][i]['gridData'][x]['styleRunDatys'];
                pQty = json_value['tvData'][i]['gridData'][x]['dayPlanQty'];
                aQty = json_value['tvData'][i]['gridData'][x]['lineOutQty'];
                effi = json_value['tvData'][i]['gridData'][x]['actEff'];
                qrL = json_value['tvData'][i]['gridData'][x]['actualQrLevel'];
                incentive = json_value['tvData'][i]['gridData'][x]['incentive'];
                neededQrLvl = json_value['tvData'][i]['gridData'][x]['needQrLvl'];
                status = json_value['tvData'][i]['gridData'][x]['status'];
                neededQtyAtTime = json_value['tvData'][i]['gridData'][x]['neededQtyAtTime'];
                smv = json_value['tvData'][i]['gridData'][x]['smv'];


                if(json_value['tvData'][i]['gridData'][x]['whatData'] == 'feeding'){
                  html += "<tr>";
                  html += "<td>" + teamName + "</td>";
                  html += "<td>" + buyer + "</td>";
                  html += "<td>" + style + "</td>";
                  html += "<td colspan='9' style='color:orange;text-align:center;font-weight:bold;'>Feeding...</td>";
                  html += "</tr>";
                }else{
                  html += "<tr>";
                  html += "<td>" + teamName + "</td>";
                  html += "<td>" + buyer + "</td>";
                  html += "<td>" + style + "</td>";
                  html += "<td>" + delv + "</td>";
                  html += "<td>" + runDay + "</td>";
                  html += "<td>" + smv + "</td>";
                  html += "<td>" + pQty + "</td>";

                  if(neededQtyAtTime != '-'){
                    html += "<td>" + aQty + " / "+ neededQtyAtTime +"</td>";
                  }else{
                    html += "<td>" + '-' +"</td>";
                  }

                  if(effi == "nextStyle"){
                    html += "<td rowspan='2'>" + json_value['tvData'][i]['gridData'][(x+1)]['actEff']; + "</td>";
                    nextS = 1;
                  }else{
                    if(nextS == 1){
                      nextS = 0;
                    }else{
                      html += "<td>" + effi + "</td>";
                    }

                  }

                  // html += "<td>" + qrL + "</td>";

                  if(neededQrLvl <= parseFloat(qrL)){
                    html += "<td style='color:green;font-weight:bold;'>" + qrL + "</td>";
                  }else{
                    html += "<td style='color:red;font-weight:bold;'>" + qrL + "</td>";
                  }

                  html += "<td>" + incentive + "</td>";

                  if ( status == 'up') {
                    html += "<td>" + "<span class='badge bg-success-400'>Up</span>" + "</td>";

                  } else if (status == 'down') {
                    html += "<td>" + "<span class='badge bg-danger'>Down</span>" + "</td>";
                  } else {
                    html += "<td>" + '-' + "</td>";
                  }
                  html += "</tr>";

                }
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
              html +="<tr>";
            }

          }

          var totalWorkersCount = 0;
          var html2 = '';
          for(var i=0;i<teamsSize;i++){

            html2 +="<div class='col-sm-2'>";
            html2 +="<table class='table'>";
              html2 +="<thead>";
                html2 +="<tr>";
                html2 +="<th class='text-center bg-teal-800'>"+json_value['team'][i]+"</th>";
                // html2 +="<th>Workers</th>";
                html2 +="</tr>";
              html2 +="</thead>";
              html2 +="<tbody>";
                html2 +="<tr>";
                // html2 +="<td>"+json_value['team'][i]+"</td>";
                if(json_value['teamWorkers'][i]==''){
                  html2 +="<td class='text-center bg-teal-400'> 0 </td>";
                }else{
                  html2 +="<td class='text-center bg-teal-400'>"+json_value['teamWorkers'][i]['0']['workers']+"</td>";
                  totalWorkersCount += parseFloat(json_value['teamWorkers'][i]['0']['workers']);
                }
                html2 +="</tr>";
              html2 +="</tbody>";
            html2 +="</table>";
            html2 +="</div>";
          }

          $('#workerModalBody').empty().append(html2);
          $('#teamData').append(html);
          $('#workerCount').text(totalWorkersCount);
          // $('#avgWorkers').text(parseInt(json_value['workerCount'])/runTeamCount);

        }
      }
    }); /// Close Ajax ///
  }
</script>
