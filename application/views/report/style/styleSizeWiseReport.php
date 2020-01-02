<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Style Size Wise
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
                    <span class="breadcrumb-item active">Style Size Wise</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">

<!--            --><?php //print_r($tableData);?>

            <div class="card-body">
               <form action="<?php echo base_url('report/StyleSizeWise_con/getTableData')?>" method="post">
                   <div class="row">
                       <label class="col-form-label col-md-1">Style : </label>
                       <div class="col-md-3">
                           <select id="style" name="style" class="form-control select-search select2" data-fouc=""
                                   tabindex="-1" required>
                               <option value="">-- Select a Style --</option>
                               <?php
                               if (!empty($style)) {
                                   foreach ($style as $row) {
                                       ?>
                                       <option value="<?php echo $row->style; ?>" <?php if($row->style==$selectStyle){echo 'Selected';}?> > <?php echo $row->style . ' - ' . $row->scNumber ?></option>
                                       <?php
                                   }
                               }
                               ?>
                           </select>
                       </div>

                       <div class="col-md-1">
                           <div class="text-right">
                               <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i>
                               </button>
                           </div>
                       </div>
                   </div>
               </form>

            </div>

            <table id="StyleSizeWiseTable" class="table dataTable ">
                <thead>
                <tr>
                    <th>Location</th>
                    <th>Team</th>
                    <th>Style</th>
                    <th>Delivery</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Line In</th>
                    <th>Line Issue</th>
                    <th>Line Out</th> 
                </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($tableData)){
                        $location = '';
                        $team = '';
                        $style = '';
                        $delv = '';
                        $color = '';
                        foreach($tableData as $row){   
                    ?>
                        <tr>
                            <?php 
                                if($location != $row->location){
                                    $location = $row->location;
                                    ?>
                                <td><?php echo $row->location ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }

                                if($team != $row->teamName){
                                    $team = $row->teamName;
                                    ?>
                                <td><?php echo $row->teamName ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }

                                if($style != $row->style){
                                    $style = $row->style;
                                    ?>
                                <td><?php echo $row->style ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }

                                if($delv != $row->delv){
                                    $delv = $row->delv;
                                    ?>
                                <td><?php echo $row->delv ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }

                                if($color != $row->color){
                                    $color = $row->color;
                                    ?>
                                <td><?php echo $row->color ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }
                            ?>
                            <td><?php echo $row->size ?></td>
                            <td><?php echo $row->cutInQty ?></td>
                            <td><?php echo $row->issueQty ?></td>
                            <td><?php echo $row->outQty ?></td>
                        </tr>
                    <?php
                        }
                    }else{
                        ?>
                            <td colspan="9" class="text-center">No Result</td>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        var fileName  = 'Style Production Report '+ date;
        $('#StyleSizeWiseTable').DataTable({
                retrieve: true,
                "bSort" : false,
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
    });
    
    </script>
