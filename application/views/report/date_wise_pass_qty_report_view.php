<style>

tfoot {
    display: table-header-group;
}</style>
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Date Wise Pass Qty
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
                    <span class="breadcrumb-item active">Date Wise Pass Qty</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">
            <div class="card-body">
               <form action="<?php echo base_url('report/DateWisePassQtyReport/getTableData');?>" method="post">
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
                    

                       &nbsp;&nbsp;&nbsp;&nbsp;
                       <label class="col-form-label">Date : &nbsp;&nbsp;</label>
                       <div class="col-lg-3">
                        <div class="row">
                           <div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text"><i class="icon-calendar5"></i></span>
								</span>
                               <input id="date" name="date" type="text" class="form-control datepick" value="<?php if($selectedDate !=''){echo $selectedDate;}else{echo date('Y-m-d');}?>" placeholder="Select a date &hellip;">
                           </div>
                           <span class="error" id="error"><?php echo form_error('date'); ?></span>
                        </div>
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
            </div>

            <table id="dateWisePassReportTbl" class="table dataTable ">
                <thead>
                <tr>
                    <th>Team</th>
                    <th>Style</th>
                    <th>SC Number</th>
                    <th>Delivery</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Pass Qty</th>
                </tr>

                <tfoot>
                     <tr>
                        <th>Team</th>
                        <th>Style</th>
                        <th>SC Number</th>
                        <th>Delivery</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th></th>
                        </tr>
                </tfoot>

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
                            <td><?php echo $row->delivery;?></td>
                            <td><?php echo $row->color;?></td>
                            <td><?php echo $row->size;?></td>
                            <td><?php echo $row->passQty;?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <!-- <tfoot>
                        <tr>
                            <th>Team</th>
                            <th>Style</th>
                            <th>SC Number</th>
                            <th>Delivery</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th style="text-align:left">Total:</th>
                            </tr>
                        </tfoot> -->
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
             $('#dateWisePassReportTbl tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="  Search '+title+'" />' );
            } );

            var fileName  = 'Day Wise Pass Qty ' + date;
            var table = $('#dateWisePassReportTbl').DataTable({
                retrieve: true,
                "lengthChange": false,
                "bPaginate": false,
                // "bSort" : false,
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                // pageTotal+' ( '+ total +' total)'
                pageTotal + ' Total'
            );
        },
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
    
    </script>
