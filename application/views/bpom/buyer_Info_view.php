
<!-- Main content -->
<div class="content-wrapper">
  <!-- Page header -->
  <div class="page-header page-header-light">
    <div class="page-header-content header-elements-sm-inline">
      <div class="page-title d-flex">
        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">BPOM</span> - Buyer Purchase Order Manager
        </h4>
        <a href="#" class="header-elements-toggle text-default d-sm-none"><i class="icon-more"></i></a>
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

          <div class="breadcrumb-line breadcrumb-line-light header-elements-sm-inline">
            <div class="d-flex">
              <div class="breadcrumb">
                <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                <a href="<?php echo base_url('User_con/userList')?>" class="breadcrumb-item">Production</a>
                <span class="breadcrumb-item active">BPOM</span>
              </div>

              <a href="#" class="header-elements-toggle text-default d-sm-none"><i class="icon-more"></i></a>
            </div>

          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
          <div class="card">
            <div class="card-header bg-white header-elements-inline">
              <h6 class="card-title">Enter Buyer Information</h6>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                  <a class="list-icons-item" data-action="reload"></a>
                  <a class="list-icons-item" data-action="remove"></a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form class="wizard-form steps-state-saving wizard clearfix"   data-fouc="" id="steps-uid-2" role="application">
                <div class="steps clearfix"></div>
                <div class="content clearfix">
                  <fieldset id="steps-uid-2-p-0" role="tabpanel" aria-labelledby="steps-uid-2-h-0" class="body current" aria-hidden="false" style="">
                    <div class="row">

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Buyer Name</label>
                          <input type="text" name="bname" id="bname" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Enter Buyer Name" >
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Buying office Name</label>
                          <input type="text" name="buyoffname" id="buyoffname" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Enter Buying office Name" >
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label>Season Name</label>
                          <input type="text" name="seasonname" id="seasonname" class="form-control bg-slate-600 border-slate-600 border-1" placeholder="Enter Season Name">
                        </div>
                      </div>

                    </div>
                  </fieldset>
                </div>

                <div class="text-right">
                  <button type="button" id="save" name="save" class="btn btn-primary" onclick="AddBuyer();">Save<i class="icon-paperplane ml-2"></i> </button>
                  <button type="reset" class="btn btn-warning">Reset<i class="icon-reset ml-2"></i> </button>
                </div>
              </form>
            </div>

          </div>

          <div class="card">

            <div class="card-header bg-white header-elements-inline">
              <h6 class="card-title">Table View</h6>
              <div class="header-elements">
                <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
                  <a class="list-icons-item" data-action="reload"></a>
                  <a class="list-icons-item" data-action="remove"></a>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="col-md-6">
                <div class="table-responsive">
                  <table class="table table-dark bg-slate-600">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Buyer Name</th>
                        <th>Buying office Name</th>
                        <th>Season Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id='tblData'>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>

          </div>

        </div>


        <div id="buyerEditModal" class="modal fade modal-center" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Buyer</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
              </div>

              
              <div class="modal-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-4">
                      <label>Buer Id</label>
                      <input id='buyerId' name="buyerId" type="text" placeholder="" class="form-control" readonly="">
                    </div>
                    <div class="col-sm-8">
                      <label>Buer Name</label>
                      <input id='editBuyerName' name="editBuyerName" type="text" placeholder="Enter Buyer Name" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                   <div class="col-sm-6">
                    <label>Buying office Name</label>
                    <input id='editBuyerOffice' name="editBuyerOffice" type="text" placeholder="Enter Office Name" class="form-control">
                  </div>
                  <div class="col-sm-6">
                    <label>Season Name</label>
                    <input id='editSeason' name="editSeason" type="text" placeholder="Enter Season Name" class="form-control">
                  </div>
                </div>
              </div>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-primary" onclick="updateBuyer()">Update</button>
              <button type="submit" onclick="deleteBuyer()" class="btn bg-danger">Delete</button>
            </div>

          </div>
        </div>
      </div>



      <script>

        $(document).ready(function(){
          getTabledata();
        });


        function editBuyer(id){

          var buyerName = $('#tdBuyerName'+id+'' ).text();
          var buyerOff = $('#tdBOffice'+id+'' ).text();
          var season = $('#tdSeason'+id+'' ).text();


          $('#buyerId').val(id);
          $('#editBuyerName').val(buyerName);
          $('#editBuyerOffice').val(buyerOff);
          $('#editSeason').val(season);

          $('#buyerEditModal').modal('show');

        }

        function deleteBuyer(){
         var buyerId = $('#buyerId').val();

         if(buyerId!=''){

          $.ajax({
            url:'<?php echo base_url("bpom/Buyer_info_Con/deleteBuyer")?>',
            type:'POST',
            data:{
              'buyerId':buyerId
            },
            success:function(data){
              if(data=="deleted"){
                alert("Deleted");
                getTabledata();
                $('#buyerEditModal').modal('hide');
              }else{
               alert("Not Deleted");
             }
           },
           error:function(data){
            alert("loss connection");
          }
        });
        }

      }


      function AddBuyer(){

        var bname = $('#bname').val();
        var buyoffname = $('#buyoffname').val();
        var seasonname = $('#seasonname').val();;

        if(bname!='' && buyoffname!='' && seasonname!=''){

          $.ajax({
            url:'<?php echo base_url("bpom/Buyer_info_Con/insert_data")?>',
            type:'POST',
            data:{
              'bname':bname,
              'buyoffname':buyoffname,
              'seasonname':seasonname,
            },
            success:function(data){
              if(data=="added"){
               
                sweetAlert('Saved', '', 'success');
                clearText();
               getTabledata();
              }else{
               sweetAlert('Oops!. Something went Wrong', '', 'warning');
             }
           },
           error:function(data){
            alert("loss connection");
          }
        });
        }else{
          alert("Fill all the fields");

        }


      }

      function getTabledata() {

        $.ajax({
          url:'<?php echo base_url("bpom/Buyer_info_Con/getTableData")?>',
          type:'POST',
          data:{

          },
          success:function(data){

            if(data != ''){
              var html = "";

              var json_value = JSON.parse(data);

              for (var i = 0; i < json_value.length; i++) {
                html += "<tr>";
                html += "<td>" + json_value[i]['id'] + "</td>";
                html += "<td id='tdBuyerName"+json_value[i]['id']+"'>"  + json_value[i]['buyer'] +"</td>";
                html += "<td id='tdBOffice"+json_value[i]['id']+"'>"  + json_value[i]['buying_office'] +"</td>";
                html += "<td id='tdSeason"+json_value[i]['id']+"'>"  + json_value[i]['season'] +"</td>";
                html += "<td><input type='button' value='edit' class='btn btn-success' onclick='editBuyer("+json_value[i]['id']+")' ></td>";
                html += "</tr>";
              }

              $('#tblData').empty().append(html);
            }else{
              $('#tblData').empty();
            }

            

          },
          error:function(data){
            alert("loss connection");
          }
        });
      }


      function  clearText(){

        $('#bname').val('');
       $('#buyoffname').val('');
        $('#seasonname').val('');;

      }

  function updateBuyer(){

        var id = $('#buyerId').val();
        var bname = $('#editBuyerName').val();
        var buyoffname = $('#editBuyerOffice').val();
        var seasonname = $('#editSeason').val();;

        if(bname!='' && buyoffname!='' && seasonname!=''){

          $.ajax({
            url:'<?php echo base_url("bpom/Buyer_info_Con/updateBuyer")?>',
            type:'POST',
            data:{
              'id':id,
              'bname':bname,
              'buyoffname':buyoffname,
              'seasonname':seasonname,
            },
            success:function(data){
              if(data=="updated"){
               
                sweetAlert('updated', '', 'success');
                clearText();
               getTabledata();
               $('#buyerEditModal').modal('hide');
              }else{
               sweetAlert('Oops!. Something went Wrong', '', 'warning');
             }
           },
           error:function(data){
            alert("loss connection");
          }
        });
        }else{
          alert("Fill all the fields");

        }


      }

    </script>

