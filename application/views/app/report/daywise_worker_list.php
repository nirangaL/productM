<style>
    th{
        text-align: center;
    }
    td{
        /* text-align: center; */
        font-weight:bold;
    }
    .width-15{
        width:75px;
    }

    .table-condensed{
      font-size: 25px;!importent
    }

    a.text-default:focus, a.text-default:hover {
      color: #333;
    }

    .title{
      font-size: 15px;
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
              <div href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-2">
                <i class="icon-people"></i>
              </div><span class="title"><b>Date Wise Worker Report</b></span>
            </div>
            <div class="card-body">
              <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold"></legend>
                <div class="form-group row">
                  <div class="col-3"></div>
                  <div class="col-6">
                    <div class="input-group">
                      <span class="input-group-prepend">
                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                      </span>
                      <input id="date" type="text" class="form-control daterange-single form-control-lg" value="<?php echo date('mm/dd/Y');?>" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="col-3"></div>
                </div>
                <div class="form-group row">
                  <div class="col-4"></div>
                  <div class="col-4 text-center">
                    <button class="btn btn-lg btn-primary" onclick="getData();"><i class="icon-search4"> Search</i></button>
                  </div>
                  <!-- <div class="col-4 text-center">
                    <h5 id="total" style="display:none;">Day Qty (Pcs): <b id="fullTotal"></b> </h3>
                  </div> -->
                </div>


                <div class="card">
                  <div id="tblData" class="card-body">

                  </div>
                </div>
              </fieldset>
            </div>
        </div>
        <!-- /form inputs -->
    </div>

    <div class="modal fade" id="appModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning-400" >
                    <h4 class="modal-title"><i class="icon-envelop4 mr-1"></i>Message</h4>
                </div>
                <div class="modal-body ">
                    <center><p id="appModalMsg"></p></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">

        function getData(){
            var date  = $('#date').val();
            // alert(date);

            if(date != ''){
              loaderOn();
                $.ajax({
                    url:'<?php echo base_url("app/report/Daywise_Worker_List_Con/getDayWiseWorkerList")?>',
                    type:'POST',
                    data:{
                        'date':date,
                    },
                    success:function (data) {

                      if(data!=''){
                        var html = "";
                        var json_value = JSON.parse(data);
                        html +=   '<div class="form-group row">'
                        html +=   '<div class="table-responsive">'
                        html +=     '<table class="table">'
                        html +=     '<thead>'
                        html +=    ' <tr>'
                        html +=     '<th>#</th>'
                        html +=     '<th>EPF No.</th>'
                        html +=    '<th>Name</th>'
                        html +=    '<th>Opa</th>'
                        html +=   '<th>In Time</th>'
                        html +=   '<th>Incen Range</th>'
                        html +=   '</tr>'
                        html +=   '</thead>'
                        html +=   '<tbody id="inputTbl">'
                        var total =0;
                        for(var x = 0; x < json_value.length; x++){
                          total +=parseFloat(json_value[x]['headCount']);
                            html += "<tr>";
                            // html += "<td style='text-align: center'>" + json_value[x]['delv'].toString() + "</td>";
                            html += "<td>" + (x +1) + "</td>";
                            html += "<td>" + json_value[x]['emp_no'].toString() + "</td>";
                            html += "<td>" + json_value[x]['emp_name'].toString() + "</td>";
                            html += "<td>" + json_value[x]['operation'].toString() + "</td>";
                            html += "<td>" + json_value[x]['inTime'].toString() + "</td>";
                            html += "<td style='text-align:center'>" + json_value[x]['headCount'].toString() + "</td>";
                            html += "</tr>";
                        }
                        html += '<tr><td colspan ="5" class="text-right">TOTAL Head Count</td><td style="font-size:20px;text-align:center;" >'+total+'</td></tr>'
                        html +=  ' </tbody>'
                        html +=   '</table>'
                        html +=  ' </div>'
                        html +=  ' </div>'
                        $('#tblData').empty().append(html);
                      }else{
                        $('#tblData').empty().append('<h4 style="color:grey;">No Result...</h4>');
                        // $('#total').css('display','none');
                        // $('#fullTotal').empty().append('0');
                      }

                    },
                    error:function (data){
                        sweetAlert('Something Went Wrong','','warning');
                    }
                });
                loaderOff();

            }
        }




    </script>
