<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Qc Defect Log
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
                    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="<?php echo base_url('Workstudy_con') ?>" class="breadcrumb-item">Report</a>
                    <span class="breadcrumb-item active">Qc Defect Log</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">
            <div class="card-body">
               <form action="<?php echo base_url('report/Qc_defectlog/getTableData');?>" method="post">
                   <div class="row">
                        <label class="col-form-label">Team :  &nbsp;&nbsp;</label>
                       <div class="col-md-2">
                           <select id="team" name="team" class="form-control select-search select2" data-fouc="" data-placeholder="Select a Team"
                                   tabindex="-1" required>
                               <option value="All" <?php if($selectedTeam=='All'){echo 'Selected';}?>>All</option>
                               <?php
                               if (!empty($team)) {
                                   foreach ($team as $row) {
                                       ?>
                                       <option value="<?php echo $row->teamId; ?>" <?php if($row->teamId==$selectedTeam){echo 'Selected';}?> > <?php echo $row->team;?></option>
                                       <?php
                                   }
                               }
                               ?>
                           </select>
                       </div>
                       
                       <!-- <?php
                    //echo $selectedToTime;
                    ?> -->

                       &nbsp;&nbsp;&nbsp;&nbsp;
                       <label class="col-form-label">From : &nbsp;&nbsp;</label>
                       <div class="col-lg-3">
                        <div class="row">
                           <div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text"><i class="icon-calendar5"></i></span>
								</span>
                               <input id="fromDate" name="fromDate" type="text" class="form-control datepick" value="<?php if($selectedFromDate !=''){echo $selectedFromDate;}else{echo date('Y-m-d');}?>" placeholder="Select a date &hellip;">
                           </div>
                           <span class="error" id="error"><?php echo form_error('fromDate'); ?></span>
                        </div>
                        <div class="row">
                            <div class="input-group">
							    <span class="input-group-prepend">
								    <span class="input-group-text"><i class="icon-alarm"></i></span>
								</span>
								<input id="fromTime" name="fromTime" type="text"  class="form-control timepicker" value="<?php if($selectedFromTime !=''){echo $selectedFromTime;}else{echo set_value('fromTime');}?>" placeholder="select Time" required>
							</div> 
                        </div>
                        <span class="error" id="error"><?php echo form_error('fromTime'); ?></span>
                       </div>
                       &nbsp;&nbsp;&nbsp;&nbsp;
                       <label class="col-form-label">To : &nbsp;&nbsp;</label>
                       <div class="col-lg-3">
                        <div class="row">
                           <div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text"><i class="icon-calendar5"></i></span>
								</span>
                               <input id="toDate" name="toDate" type="text" class="form-control datepick" value="<?php if($selectedToDate !=''){echo $selectedToDate;}else{echo date('Y-m-d');}?>" placeholder="Select a date &hellip;" required>
                           </div>
                           <span class="error" id="error"><?php echo form_error('toDate'); ?></span>
                        </div>
                        <div class="row">
                            <div class="input-group">
							    <span class="input-group-prepend">
								    <span class="input-group-text"><i class="icon-alarm"></i></span>
								</span>
								<input id="toTime" name="toTime" type="text"  class="form-control timepicker" value="<?php if($selectedToTime !=''){echo $selectedToTime;}else{echo set_value('toTime');}?>" placeholder="select Time" required>
							</div> 
                        </div>
                        <span class="error" id="error"><?php echo form_error('toTime'); ?></span>
                       </div>
                       <label class="col-form-label"> &nbsp;&nbsp;</label>
                       <div class="col-md-1">
                           <div class="text-right">
                               <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i>
                               </button>
                           </div>
                       </div>
                   </div>
               </form>

            <div class="row">
                <h3>Count : &nbsp;</h3><h3><?php 
                if(!empty($tableData)){
                   echo count($tableData); 
                }else{
                    echo '0';
                }
                ?></h3>
            </div>
                
            </div>

            <table id="qcDefectLogTbl" class="table dataTable ">
                <thead>
                <tr>
                    <th>Team</th>
                    <th>Style</th>
                    <th>SC Number</th>
                    <th>Delivery</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Reason</th>
                    <th>Date Time</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if(!empty($tableData)){
                        foreach($tableData as $row){
                        ?>
                        <tr>
                            <td><?php echo $row->line;?></td>
                            <td><?php echo $row->style;?></td>
                            <td><?php echo $row->scNumber;?></td>
                            <td><?php echo $row->deliverNo;?></td>
                            <td><?php echo $row->color;?></td>
                            <td><?php echo $row->size;?></td>
                            <td><?php echo $row->reason;?></td>
                            <td><?php echo $row->datetime;?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tfoot>
                            <tr>
                            <th>Team</th>
                            <th>Style</th>
                            <th>SC Number</th>
                            <th>Delivery</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Reason</th>
                            <th>Date Time</th>
                            </tr>
                        </tfoot>
                        <?php
                    }else{
                ?>
                    <td colspan="7" class="text-center">No Result</td>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
       
    $(document).ready(function () {
        var currentDate = new Date();
        var date = currentDate.getDate() +'-'+(currentDate.getMonth()+1)+'-'+currentDate.getFullYear();

            $('.timepicker').timepicker({
                timeFormat: 'H:mm',
                interval: 15,
                minTime: '00',
                maxTime: '23:55pm',
                dynamic: true,
                dropdown: true,
                scrollbar: true
            });

                    // Setup - add a text input to each footer cell
            $('#qcDefectLogTbl tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder=" Search '+title+'" />' );
            } );

            var fileName  = 'Qc_Defect_Log '+ date;
            var table = $('#qcDefectLogTbl').DataTable({
                retrieve: true,
                // "bSort" : false,
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
                // Apply the search
            table.columns().every( function () {
                var that = this;
        
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );


        });

        $('.datepick').pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'yyyy-mm-dd',
        });
    // $(document).ready(function () {
    //     var fileName  = 'Style Production Report '+ date;
    //     $('#StyleSizeWiseTable').DataTable({
    //             retrieve: true,
    //             "bSort" : false,
    //             buttons: [
    //                 {
    //                     extend: 'excelHtml5',
    //                     title: fileName
    //                 },
    //                 {
    //                     extend: 'pdfHtml5',
    //                     title: fileName
    //                 },
    //                 {
    //                     extend: 'csvHtml5',
    //                     title: fileName
    //                 }, {
    //                     extend: 'print',
    //                     title: fileName
    //                 }
    //             ]
    //     });
    // });
    
    </script>
