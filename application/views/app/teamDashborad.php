<!-- Main content -->

<style>

    .bg-teal{
        background-color: #80cbc4;
    }
    .bg-black{
        background-color:#dcdde1;
    }
    .bg-light-blue{
            background-color: #2980b9;
    }
    .bg-light-purple{
            background-color: #d1c4e9;
    }
    .bg-light-pink{
        background-color: #ee99fc;
    }
    .bg-light-red{
        background-color: #ef9a9a;
    }
    .bg-light-amber{
        background-color: #ffecb3;
    }
    .bg-light-brown{
        background-color: #bcaaa4;
    }
    .bg-light-blueGrey{
        background-color: #b0bec5;
    }

    .tile{
        height: 175px;
    }

    .tile:active{
        opacity: 0.5;

    }

    .icon{
        font-size: 80px;
        margin: 10px 0 10px 0;
    }

    .content {
        padding: 1.25rem 1.25rem;!importent;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }
    .title{
      font-family: "serif",Times,Times New Roman ;;
      font-size: 20px;
      color:#192a56;
      /* font-weight: bold; */
      /* font-style: italic; */
    }
    .data{
      font-family:  "Times",serif,Times New Roman ;
      font-size: 20px;
      color: #bdc3c7;
      font-weight: bold;
      font-style: italic;
    }
    .d-flex{
      font-size: 16px;
    }

</style>

<div class="content-wrapper animated fadeInDown ">

    <!-- Content area -->
    <div class="content" >

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6 text-left" >
              <div class="d-flex align-items-center  mb-2">
                <a href="<?php echo base_url('app/report/Daywise_Line_In_Con');?>" class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon mr-3">
                  <i class="icon-cart-add2"></i>
                </a>
                <div>
                  <div class="font-weight-semibold"> <?php
                  if(!empty($inQty[0]->totalQty)){
                    echo $inQty[0]->totalQty;
                  }else{
                    echo 0;
                  }
                  ?></div>
                  <span class="text-muted">Today In Qty</span>
                </div>
              </div>
            </div>
            <div class="col-6 ">
              <div class="d-flex align-items-center  mb-2">
                <a href="<?php echo base_url('app/report/Daywise_Line_Issue_Con');?>" class="btn bg-transparent warning-400 text-warning-400  rounded-round border-2 btn-icon mr-3">
                  <i class="icon-cart-remove"></i>
                </a>
                <div>
                  <div class="font-weight-semibold"><?php
                  if(!empty($issueQty[0]->totalQty)){
                    echo $issueQty[0]->totalQty;
                  }else{
                    echo 0;
                  }
                  ?> </div>
                  <span class="text-muted">Today Issue Qty</span>
                </div>
              </div>
            </div>
          </div>
</br>
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center  mb-2">
                <a href="<?php echo base_url('app/report/Daywise_Worker_List_Con');?>" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-3">
                  <i class="icon-people"></i>
                </a>
                <div>
                  <div class="font-weight-semibold"><?php
                  if(!empty($workers[0]->totalWorker)){
                    echo $workers[0]->totalWorker;
                  }else{
                    echo 0;
                  }
                  ?></div>
                  <span class="text-muted">
                    Workers
                  </span>
                </div>
              </div>
          </div>
          <div class="col-6 text-center"></div>
        </div>

      </div>
    </div>

        <div class="row">
            <div class="col-6">
                <a href="<?php echo base_url('app/Cut_In_Con')?>">
                    <div class="card tile bg-teal">
                        <div class="card-body text-center">
                            <i class="icon icon-cart-add2"></i>
                            <h3>Line In</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="<?php echo base_url('app/Product_In_Con')?>">
                    <div class="card tile bg-light-blue">
                        <div class="card-body text-center">
                          <i class="icon icon-cart-remove"></i>
                          <h3>Line Issue</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="<?php echo base_url('app/App_TeamRecorder_Con/workerList')?>">
                    <div class="card tile bg-light-pink">
                        <div class="card-body text-center">
                          <i class="icon icon-user-plus"></i>
                          <h3>Assign Workers</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="<?php echo base_url('app/Worker_Hourly_Out_Con')?>">
                    <div class="card tile bg-light-purple">
                        <div class="card-body text-center">
                          <i class="icon icon-alarm-check"></i>
                          <h3>Worker Hourly Out</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <a href="<?php echo base_url('app/report/App_Report_Con')?>">
                    <div class="card tile bg-light-red">
                        <div class="card-body text-center">
                          <i class="icon icon-book"></i>
                          <h3>Report</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="#">
                    <div class="card tile bg-light-amber">
                        <div class="card-body text-center">
                            <!--                            <i class="icon icon-user-plus"></i>-->
                            <!--                            <h3>Assign Workers</h3>-->
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-6 ">
                <a href="#">
                    <div class="card tile bg-light-brown">
                        <div class="card-body text-center">
                            <!--                            <i class="icon icon-user-plus"></i>-->
                            <!--                            <h3>Assign Workers</h3>-->
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="#">
                    <div class="card tile bg-light-blueGrey">
                        <div class="card-body text-center">
                            <!--                            <i class="icon icon-user-plus"></i>-->
                            <!--                            <h3>Assign Workers</h3>-->
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        $(document).ready(function () {
        });

        function sweetAlert(title,text,icon) {
            swal({
                title: title,
                text: text,
                icon: icon,
            });
        }

    </script>
