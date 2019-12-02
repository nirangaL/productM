<style>
  .list{
    border: 0.5px solid lightgray;
    margin-bottom: 5px;
  }
  .list-icon{
        font-size: 36px;
  }
</style>

<!-- Main content -->
<div class="content-wrapper animated zoomIn">
    <!-- Content area -->
    <div class="content">
      <div class="card">
        <div class="card-header header-elements-inline">
          <h5 class="card-title">Report</h5>
        </div>

        <div class="card-body">
          <ul class="media-list media-list-linked">
            <!-- Date wise Line In Qty Report  -->
            <li class="list">
              <a href="<?php echo base_url('app/report/Daywise_Line_In_Con');?>" class="media">
              <div class="bg-transparent border-teal text-teal mr-3"><i class="icon-cart-add2 list-icon"></i></div>
                <div class="media-body">
                  <div class="media-title font-weight-semibold">Date Wise Line In</div>
                  <span class="text-muted">To view date wise line in qty </span>
                </div>
                <div class="align-self-center ml-3">
                  <i class="icon-arrow-right22"></i>
                </div>
              </a>
            </li>
            <!-- /Date wise Line In Qty Report /// -->

            <!-- Date wise Line In Qty Report  -->
            <li class="list">
              <a href="<?php echo base_url('app/report/Daywise_Line_Issue_Con');?>" class="media">
                <div class="bg-transparent warning-400 text-warning-400 mr-3"><i class="icon-cart-remove list-icon"></i></div>
                <div class="media-body">
                  <div class="media-title font-weight-semibold">Date Wise Line Issue</div>
                  <span class="text-muted">To view date wise line issue qty </span>
                </div>
                <div class="align-self-center ml-3">
                  <i class="icon-arrow-right22"></i>
                </div>
              </a>
            </li>
            <!-- /Date wise Line In Qty Report /// -->

            <!-- Date wise Workers Report  -->
            <li class="list">
              <a href="<?php echo base_url('app/report/Daywise_Worker_List_Con');?>" class="media">
                <div class="bg-transparent border-indigo-400 text-indigo-400 mr-3"><i class="icon-people list-icon"></i></div>
                <div class="media-body">
                  <div class="media-title font-weight-semibold">Date Wise Workers</div>
                  <span class="text-muted">To view date wise Workers</span>
                </div>
                <div class="align-self-center ml-3">
                  <i class="icon-arrow-right22"></i>
                </div>
              </a>
            </li>
              <!-- /Date wise Line In Qty Report /// -->

              <li class="list">
                <a href="<?php echo base_url('app/report/Date_Range_Line_In_Con');?>" class="media">
                  <div class="bg-transparent order-teal text-teal mr-3"><i class="icon-calendar22 list-icon"></i></div>
                  <div class="media-body">
                    <div class="media-title font-weight-semibold"> Line Input Between Date Range</div>
                    <span class="text-muted">To view Line in within some time period</span>
                  </div>
                  <div class="align-self-center ml-3">
                    <i class="icon-arrow-right22"></i>
                  </div>
                </a>
              </li>


            <li class="list">
              <a href="<?php echo base_url('app/report/Date_Range_Line_Issue_Con');?>" class="media">
                <div class="bg-transparent warning-400 text-warning-400 mr-3"><i class="icon-calendar2 list-icon"></i></div>
                <div class="media-body">
                  <div class="media-title font-weight-semibold">Line Issuing Between Date Range</div>
                  <span class="text-muted">To view Line issuing within some time period</span>
                </div>
                <div class="align-self-center ml-3">
                  <i class="icon-arrow-right22"></i>
                </div>
              </a>
            </li>



          </div>
        </div>
      </div>
