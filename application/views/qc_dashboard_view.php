
<!-- <link href="<?php echo base_url()?>assets/global_assets/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>assets/global_assets/jquery-ui-1.12.1/jquery-ui.min.js"></script> -->
<script src="<?php echo base_url()?>assets/js/productm/qcDashboard.js"></script>
<style>
   .team-header thead tr{ 
        background: white !important;
        color: black;
    }

    .style-info:hover{
        background: #82ccdd;
    }

    .dt-button {
      display: none !important;
    }

    .title-team{
      font-weight: bold;
    }
    .listview{
      overflow-y: auto;
      overflow-x: hidden;
      height: 100%;
      max-height: 60vh;
    }
    .scroll{
      overflow-x:hidden;
      overflow-y: auto;
    }

    .listview .card{
      margin-top: 5px !important; 
      margin-bottom: 5px !important; 
    }

    .listview .card .card-header{
      /* padding-top:5px !important; 
      padding-bottom:5px !important;  */
      padding: 8px !important;
        }

     tr td{
      font-weight: bold;
      color:#353b48 !important;
      font-size:0.7500rem !important;
     }
</style>

<div class="content-wrapper">
  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
      <div class="d-flex">
        <div class="breadcrumb">
          <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
          <span class="breadcrumb-item active">QC Dashboard</span>
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
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="card">
          <div class="input-group">
            <span class="input-group-prepend">
              <span class="input-group-text"><i class="icon-calendar5"></i></span>
            </span>
            <input id="date" name="date" type="text" class="form-control datepick" value="<?php echo date('Y-m-d');?>"
              placeholder="Select a date &hellip;" onchange="dateSelect();">
          </div>
        </div>
      </div>
      <div class="col-md-4"></div>
 </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card" >
          <div class="card-header ">
              <div class="row">
									<div class="col-sm-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="btn bg-transparent border-success-400 text-success-400 rounded-round border-2 btn-icon mr-3">
                          <i class="icon-thumbs-up3"></i>
                        </a>
                        <div>
                          <h5 class="font-weight-semibold mb-0" id="totalPassOut">0</h5>
                          <span class="text-muted font-size-sm">Total Out</span>
                        </div>
                    </div>
									</div>

									<div class="col-sm-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="btn bg-transparent border-warning-400 text-warning-400 rounded-round border-2 btn-icon mr-3">
                          <i class="icon-thumbs-down3"></i>
                        </a>
                        <div>
                        <h5 id="totalDefectAmount" class="font-weight-semibold mb-0 ">0</h5>
											  <span class="text-muted font-size-sm">Total Defect</span>
                        </div>
                    </div>
                  </div>
                  
									<div class="col-sm-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="btn bg-transparent border-teal-400 text-teal-400 rounded-round border-2 btn-icon mr-3">
                          <i class="icon-checkmark-circle2"></i>
                        </a>
                        <div>
                        <h5 id="totalRemakeAmount" class="font-weight-semibold mb-0 ">0</h5>
											  <span class="text-muted font-size-sm">Total Remake</span>
                        </div>
                    </div>
									</div>

									<div class="col-sm-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                          <a href="#" class="btn bg-transparent border-primary-400 text-primary-400 rounded-round border-2 btn-icon mr-3">
                            <i class="icon-percent"></i>
                          </a>
                          <div>
                          <h5 id="defectPercentage" class="font-weight-semibold mb-0 ">0%<h5>
                          <span class="text-muted font-size-sm">Defect Percentage</span>
                          </div>
                    </div>
                  </div>
							</div>
          </div>

          <div class="card-body">
            <div class="chart-container">
									<div class="chart has-fixed-height" id="totalDataChart"></div>
						</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card" >
          <div class="card-header header-elements-inline">
            <h5 class="card-title">Defect List</h5>
            <!-- <div class="header-elements">
              <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
              </div>
            </div> -->
          </div>

          <div class="card-body">
      
              <div class="listview ">

              </div>
              
          </div>
        </div>
      </div>
    </div>
    <!-- /gauges -->

    <!-- <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"></h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div> -->
        <!-- <div class="card-body"> -->
            <div class="row" id="teamWiseDataDiv">
            </div>
        <!-- </div> -->
    <!-- </div> -->
</div>

<script>
    var getDefectAll = '';
    var totalOut = 0;
    
    var today = new Date();
    if((today.getMonth()+1) <10){
      var todayMonth = '0'+(today.getMonth()+1);
    }else{
      var todayMonth = (today.getMonth()+1);
    }
    if((today.getDate()+1) < 10){
      var todayDate = '0'+(today.getDate());
    }else{
     var todayDate = (today.getDate());
    }    
    var date = today.getFullYear()+'-'+todayMonth+'-'+todayDate;


    $(document).ready(function(){
      getData();
      var table =  $('#fixedHead').DataTable( {
        scrollY:        '35vh',
        scrollCollapse: true,
        paging:         false,
        dom: 'Brtip',
        "ordering": false,
        "bFilter": false,
        "bInfo" : false,
      });

    });

    $('.datepick').pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'yyyy-mm-dd',
                max: true,
        });
     
    var timeTicket = setInterval(function() {
      var dateSelected = $('#date').val();

     var select_date = new Date(dateSelected);
     var datecurr = new Date(date);

      // console.log(select_date+'  '+datecurr );
      if(select_date.getTime() == datecurr.getTime()){
        // console.log('jjhsj');
        getData();
      }
    }, 45000);

    function getData(){
     var dateSelected = $('#date').val();

     getDefectAll =  $.ajax({
            data: {
                'location':'',
                'date':dateSelected
            },
            type:'POST',
            url: '<?php echo base_url("QcDashboard/getQcData") ?>'
        }).done(function(data) {


        
            var jsonData = JSON.parse(data);
            if(jsonData['totalData'].length>0){
              setTeamData(jsonData['teamData'],jsonData['remakeData']);
              setTotalData(jsonData['totalData']);
            }else{
              loaderOff();
              sweetAlert('No Data','Can`t find any data on this day','warning');
            }
            
            // EchartsPiesDonuts();
  

        }).fail(function(jqXHR, textStatus, errorThrown) {
            // If fail
            console.log(textStatus + ': ' + errorThrown);
        });

        
    }
 
    function setTeamData(teamData,remakeData){
        totalOut = 0;
        var teamCount = teamData.length;
        var html='';
        var totalDefect = 0;
        var totolRemake = 0;
        var p = 1;
        for(var i=0;i<teamCount;i++){
          // console.log(remakeData[i]);
          if(teamData[i].length > 0){
            html +=  '<div class="col-md-4">';
          html +=        '<div class="card border-dark has-fixed-height scroll">';
          html +=            '<div class="card-header text-dark-800 border-bottom-dark">';
          html +=                '<div class="text-center">';
          html +=                    '<h6 class="card-title mb-2 title-team">'+teamData[i][0]['teamName']+'</h6>';
          html +=                '</div>';

          var preStyle = '';
          var rowCount = teamData[i].length;
          var remakeRowCount = remakeData[i].length;
          for(var x=0;x<rowCount;x++){
            p++;
            if(preStyle != teamData[i][x]['style'].toString() ){
              preStyle = teamData[i][x]['style'].toString();
 
              html +=  '<div class="card">';
              html +=    '<div class="card-header row ">';
              html +=    '<div class="col-sm-6">';
              html +=       '<h6 class="card-title">';
              html +=        '<a data-toggle="collapse" class="text-default" href="#teamList'+(i+''+p)+'"><b>'+preStyle+'</b></a>';
               
              html +=      '</h6>';
              html += '<span class="text-muted font-size-sm">Style</span>'
              html +=    '</div>';
             
              html +=    '<div class="col-sm-2 text-right">';
              html +=       '<h6 class="card-title">';
              var passQty = 0;
                if(preStyle == teamData[i][x]['style'].toString()){
                  passQty = parseInt(teamData[i][x]['passQty']);  
                  totalOut += passQty;
                }
              html +=        '<a data-toggle="collapse" class="text-default " href="#teamList'+(i+''+p)+'"><b id="defectAmountTotal'+i+'">'+passQty+'</b></a>';
              html +=      '</h6>';
              html += '<span class="text-muted font-size-sm">Pass</span>';
              html +=    '</div>';




              html +=    '<div class="col-sm-2 text-right">';
              html +=       '<h6 class="card-title">';
              var totalDefectTotal = 0;
              for(var y = 0; y < rowCount; y++){
                if(preStyle == teamData[i][y]['style'].toString()){
                  totalDefectTotal += parseInt(teamData[i][y]['defectAmount']);
                
                } 
              }
              html +=        '<a data-toggle="collapse" class="text-default " href="#teamList'+(i+''+p)+'"><b id="defectAmountTotal'+i+'">'+totalDefectTotal+'</b></a>';
              html +=      '</h6>';
              html += '<span class="text-muted font-size-sm">Defect</span>';
              html +=    '</div>';


              html +=    '<div class="col-sm-2 text-right">';
              html +=       '<h6 class="card-title">';
              var totalRemakeQty = 0;
              for(var y = 0; y < remakeRowCount; y++){
                if(remakeData[i].length > 0){
                  if(preStyle == remakeData[i][y]['style'].toString()){
                  totalRemakeQty += parseInt(remakeData[i][y]['amount']); 
                  totolRemake += totalRemakeQty;
                } 
              }
                
              }
              html +=        '<a data-toggle="collapse" class="text-default " href="#teamList'+(i+''+p)+'"><b id="defectAmountTotal'+i+'">'+totalRemakeQty+'</b></a>';
              html +=      '</h6>';
              html += '<span class="text-muted font-size-sm">Remake</span>';
              html +=    '</div>';



              
              html +=    '</div>';
              html +=    '<div id="teamList'+(i+''+p)+'" class="collapse show" >';
              html +=        '<div class="card-body ">';
              html +=   '<div class="form-group row">'
              html +=   '<div class="table-responsive">'
              html +=     '<table class="table">'
              html +=     '<thead>'
              html +=    ' <tr>'
              html +=    '<th>Reason</th>'
              html +=   '<th>Amount</th>'
              html +=   '<th>From Total Out</th>'
              html +=   '<th>From Total Defect</th>'
              html +=   '</tr>'
              html +=   '</thead>'
              html +=   '<tbody id="inputTbl">'
              
              // var shortedArray = teamData[i].sort(function (a, b) {
              //           return b.defectAmount - a.defectAmount;
              //     });

              for(var y = 0; y < rowCount; y++){
                if(preStyle == teamData[i][y]['style'].toString() &&  teamData[i][y]['defectReason'] != undefined){
                html += "<tr>";
                html += "<td>" + teamData[i][y]['defectReason'].toString() + "</td>";
                html += "<td>" + teamData[i][y]['defectAmount'] + "</td>";
                html += "<td>" + ((parseInt(teamData[i][y]['defectAmount'])/totalOut)*100).toFixed(2) + '%'+"</td>";
                html += "<td>" + ((parseInt(teamData[i][y]['defectAmount'])/totalDefectTotal)*100).toFixed(2) + '%'+"</td>";
                html += "</tr>";
              }

            }

              html +=  ' </tbody>'
              html +=   '</table>'
              html +=  ' </div>'
              html +=  ' </div>'

              html +=      ' </div>';
              html +=    '</div>';
              html +=   ' </div>';

              }
          }

          html += '<div class="card-body">';
          html += '</div>';
          html +=            '</div>';
          html +=        '</div>';
          html +=    '</div>';
          } 
        }

        $('#teamWiseDataDiv').empty().append(html);
        $('#totalPassOut').text(totalOut);
        $('#totalRemakeAmount').text(totolRemake);
    }

    function setTotalData(totalData){
      var totalDefect = 0;
      reasons = [];
      totalCount = [];
      var rowCount = totalData.length;
      var html ='';
      var defectReaspon = '';
      var defectAmount = 0;
      for(var i = 0;i<rowCount;i++){

        if(defectReaspon =='' || defectReaspon == totalData[i]['rejectReason']){
          defectReaspon = totalData[i]['rejectReason'];
          defectAmount += parseInt(totalData[i]['amount']);
        }

        if(defectReaspon != totalData[i]['rejectReason']){
          var values = {
          'value':defectAmount,
          'name':defectReaspon
          }
          reasons.push(defectReaspon);
          totalCount.push(values);

          defectReaspon = totalData[i]['rejectReason'];
          defectAmount = parseInt(totalData[i]['amount']);
        }

        if(rowCount == (i+1)){
          var values = {
          'value':defectAmount,
          'name':defectReaspon
          }
          reasons.push(defectReaspon);
          totalCount.push(values);
        }
      }

      var totalDefect = 0;
      var preDefectReason = '';
      for(var i = 0;i<rowCount;i++){
        if(preDefectReason != totalData[i]['rejectReason'].toString() ){
          preDefectReason = totalData[i]['rejectReason'].toString();

        html +=  '<div class="card">';
        html +=    '<div class="card-header row">';
        html +=    '<div class="col-sm-6">';
        html +=       '<h6 class="card-title">';
        html +=        '<a data-toggle="collapse" class="text-default collapsed" href="#accordion-control-right-group'+i+'"><b>'+totalData[i]['rejectReason'].toString()+'</b></a>';
        html +=      '</h6>';
        html +=    '</div>';
        html +=    '<div class="col-sm-6 text-right">';
        html +=       '<h6 class="card-title">';
        var total = 0;
        for(var x = 0; x < rowCount; x++){
          if(preDefectReason == totalData[x]['rejectReason'].toString()){
          total += parseInt(totalData[x]['amount']);
        }
       }
       totalDefect += total;
        html +=        '<a data-toggle="collapse" class="text-default collapsed" href="#accordion-control-right-group'+i+'"><b id="defectAmountTotal'+i+'">'+total+'</b></a>';
        html +=      '</h6>';
        html +=    '</div>';
        html +=    '</div>';
        html +=    '<div id="accordion-control-right-group'+i+'" class="collapse" >';
        html +=        '<div class="card-body">';
        html +=   '<div class="form-group row">'
        html +=   '<div class="table-responsive">'
        html +=     '<table class="table">'
        html +=     '<thead>'
        html +=    ' <tr>'
        html +=     '<th>Team</th>'
        html +=    '<th>Style</th>'
        html +=   '<th>Amount</th>'
        html +=   '</tr>'
        html +=   '</thead>'
        html +=   '<tbody id="inputTbl">'
        var total = 0;
        for(var x = 0; x < rowCount; x++){
          if(preDefectReason == totalData[x]['rejectReason'].toString()){

          total += parseInt(totalData[x]['amount']);
          html += "<tr>";

          html += "<td>" + totalData[x]['line'].toString() + "</td>";
          html += "<td>" + totalData[x]['style'].toString() + "</td>";
          html += "<td>" + totalData[x]['amount'].toString() + "</td>";
          html += "</tr>";
        }

       }

        html +=  ' </tbody>'
        html +=   '</table>'
        html +=  ' </div>'
        html +=  ' </div>'

        html +=      ' </div>';
        html +=    '</div>';
        html +=   ' </div>';

        }

      }
      var defectPercentage = 0;
      defectPercentage = (totalDefect/totalOut) * 100;
      $('#defectPercentage').text(defectPercentage.toFixed(2)+'%');
      $('#totalDefectAmount').text(totalDefect);
      
      $('.listview').empty().append(html);
      loaderOff();
    }

    function dateSelect(){
      getDefectAll.abort(); 
      loaderOn();
      getData();
      
    }



  </script>






