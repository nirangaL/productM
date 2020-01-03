<style>

    .qty{
        background-color: #f1f2f6;
        /* font-weight: bold; */
    }
    .amount{
        text-align: right;
    }
    .red{
        color: red;
    }
    th{
        text-align: center;
    }

    .colorTotal{
        font-size: 12px;
        font-weight: bolder;
        text-align: right;
        font-style: italic;
    }

    .stTotal{
       
        font-size: 14px;
        font-weight: bolder;
        text-align: right ;
    }

</style>

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
                    <th>Style</th>
                    <th>Delv/OrderQty</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Order Qty</th>
                    <th>(WIP)</th>
                    <th>In</th>
                    <th>(WIP)</th>
                    <th> Issue</th>
                    <th>(WIP)</th>
                    <th> Out</th> 
                    <th>Order Vs LineOut</th>
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

                        $ctOrderQty = 0;
                        $ctInQty = 0;
                        $ctIssueQty = 0;
                        $ctOutQty = 0;


                        $stTotalQty = 0;
                        $stInQty = 0;
                        $stIssueQty = 0;
                        $stOutQty = 0;
                        // echo count($tableData);
                        
                        $i = 1;
                        $colorCount = 0;
                        foreach($tableData as $row){   
                           
                            if($color != $row->color && $color !=''){
                                $colorCount +=1;
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="colorTotal">Color Total : </td>
                                    <td></td>
                                    <td class="colorTotal"><?php echo  $ctOrderQty ?></td>
                                    <td></td>
                                    <td class="colorTotal"><?php echo $ctInQty ?></td>
                                    <td></td>
                                    <td class="colorTotal"><?php echo $ctIssueQty ?></td>
                                    <td></td>
                                    <td class="colorTotal"><?php echo $ctOutQty ?></td>
                                    <td></td>
                                </tr>

                                
                            
                            <?php
                                
                                $stTotalQty += $ctOrderQty ;
                                $stInQty += $ctInQty;
                                $stIssueQty +=$ctIssueQty;
                                $stOutQty +=  $ctOutQty;

                                $ctOrderQty = 0;
                                $ctInQty = 0;
                                $ctIssueQty = 0;
                                $ctOutQty = 0;
                            }

                            if($color =='' || $color == $row->color){
                               
                                $ctOrderQty += (int)$row->orderQty;
                                $ctInQty += (int)$row->cutInQty;
                                $ctIssueQty += (int)$row->issueQty;
                                $ctOutQty += (int)$row->outQty;
                            }

                    ?>
                        <tr>
                            <?php 
                                 
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
                                    $color = '';
                                    ?>
                                <td><?php echo $row->delv.' / Odr.Qty : '.$row->delvOrderQty; ?></td>
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
                            <?php
                                $orderQtyVsLineIn = (int)$row->orderQty - (int)$row->cutInQty;
                                $lineInVsLineIssue = (int)$row->cutInQty - (int)$row->issueQty;
                                $lineIssuVsLineOut = (int)$row->issueQty - (int)$row->outQty;
                                $orderQtyVsLineOut = (int)$row->orderQty - (int)$row->outQty;
                            ?>
                            
                            <td class="qty amount"><?php echo $row->orderQty ?></td>

                            <?php
                                if($orderQtyVsLineIn>=0){
                                    ?>
                                    <td class="amount red"><?php echo $orderQtyVsLineIn;  ?></td>
                                    <?php
                                }else{
                                    ?>
                                    <td class="amount"><?php echo $orderQtyVsLineIn;  ?></td>
                                    <?php  
                                }
                            ?>

                            <td class="qty amount"><?php echo $row->cutInQty ?></td>

                            <?php
                                if($lineInVsLineIssue>=0){
                                    ?>
                                    <td class="amount red"><?php echo $lineInVsLineIssue;  ?></td>
                                    <?php
                                }else{
                                    ?>
                                    <td class="amount "><?php echo $lineInVsLineIssue;  ?></td>
                                    <?php  
                                }
                            ?>

                         
                            <td class="qty amount"><?php echo $row->issueQty ?></td>
                            <?php
                                if( $lineIssuVsLineOut>=0){
                                    ?>
                                    <td class="amount red"><?php echo  $lineIssuVsLineOut;  ?></td>
                                    <?php
                                }else{
                                    ?>
                                    <td class="amount "><?php echo  $lineIssuVsLineOut;  ?></td>
                                    <?php  
                                }
                            ?>

                            <td class="qty amount"><?php echo $row->outQty ?></td>

                           <?php
                                if( $orderQtyVsLineOut>=0){
                                    ?>
                                    <td class="amount red"><?php echo  $orderQtyVsLineOut;  ?></td>
                                    <?php
                                }else{
                                    ?>
                                    <td class="amount "><?php echo  $orderQtyVsLineOut;  ?></td>
                                    <?php  
                                }
                            ?>
                        </tr>
                    <?php

                        if($i == count($tableData)){

                            if( $colorCount != 0){
                                ?>
                                <tr>
                                <td></td>
                                <td></td>
                                <td class="colorTotal">Color Total : </td>
                                <td></td>
                                <td class="colorTotal"><?php echo  $ctOrderQty ?></td>
                                <td></td>
                                <td class="colorTotal"><?php echo $ctInQty ?></td>
                                <td></td>
                                <td class="colorTotal"><?php echo $ctIssueQty ?></td>
                                <td></td>
                                <td class="colorTotal"><?php echo $ctOutQty ?></td>
                                <td></td>
                            </tr>
                                <?php
                            }
                            ?>
                            
                            

                        <?php
                            $stTotalQty += $ctOrderQty ;
                            $stInQty += $ctInQty;
                            $stIssueQty +=$ctIssueQty;
                            $stOutQty+=  $ctOutQty;
                            $ctOrderQty = 0;
                            $ctInQty = 0;
                            $ctIssueQty = 0;
                            $ctOutQty = 0;

                            ?>
                             <tr>
                             <td></td>
                             <td></td>
                             <td></td>
                            <td class="stTotal">Total : </td>
                                <td class="stTotal"><?php echo  $stTotalQty ?></td>
                                <td></td>
                                <td class="stTotal"><?php echo $stInQty ?></td>
                                <td></td>
                                <td class="stTotal"><?php echo $stIssueQty ?></td>
                                <td></td>
                                <td class="stTotal"><?php echo $stOutQty ?></td>
                                <td></td>
                            </tr>
                            <?php

                        }
                        $i++;
                        }
                    }else{
                        ?>
                            <td colspan="12" class="text-center">No Result</td>
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
                "bPaginate": false,
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
