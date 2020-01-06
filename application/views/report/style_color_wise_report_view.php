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
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Report</span> - Style Summary Report
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
                    <span class="breadcrumb-item active">Style Summary Report</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->
    <div class="content">
        <div class="card">

          <!-- <?php // print_r($CutDataFromGama);?> -->

            <div class="card-body">
               <form action="<?php echo base_url('report/StyleColorWiseReport/getTableData')?>" method="post">
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
            <div class="col-sm-12">                   
            <table id="StyleSizeWiseTable" class="table dataTable ">
                <thead>
                <tr>
                    <th>Style</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Order Qty</th>
                    <th>Cut</th>
                    <th>Line In</th>
                    <th>Line Issue</th>
                    <th>Line Out</th> 
                </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($CutDataFromGama)){
                        $location = '';
                        $team = '';
                        $style = '';
                        $delv = '';
                        $color = '';

                        $ctCutQty = 0;
                        $ctOrderQty = 0;
                        $ctInQty = 0;
                        $ctIssueQty = 0;
                        $ctOutQty = 0;

                        $stTotalQty = 0;
                        $stCutQty = 0;
                        $stInQty = 0;
                        $stIssueQty = 0;
                        $stOutQty = 0;
                        // echo count($tableData);
                        
                        $i = 1;
                        $colorCount = 0;
                        foreach($CutDataFromGama as $rowCut){   

                            foreach($ProductMData as $row){

                            if($rowCut->color == $row->color && $rowCut->size == $row->size){

                            
                            if($color != $row->color && $color !=''){
                                $colorCount +=1;
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="colorTotal">Color Total : </td>
                                    <td></td>
                                   
                                    <td class="colorTotal"><?php echo  $ctOrderQty ?></td>
                                    <td class="colorTotal"><?php echo  $ctCutQty ?></td>
                                    <td class="colorTotal"><?php echo $ctInQty ?></td>
                                    <td class="colorTotal"><?php echo $ctIssueQty ?></td>
                                    <td class="colorTotal"><?php echo $ctOutQty ?></td>
                                </tr>
                            <?php
                                
                                $stTotalQty += $ctOrderQty ;
                                $stCutQty += $ctCutQty ;
                                $stInQty += $ctInQty;
                                $stIssueQty +=$ctIssueQty;
                                $stOutQty +=  $ctOutQty;

                                $ctOrderQty = 0;
                                $ctCutQty = 0;
                                $ctInQty = 0;
                                $ctIssueQty = 0;
                                $ctOutQty = 0;
                            }

                            if($color =='' || $color == $rowCut->color){
                               
                                $ctOrderQty += (int)$row->orderQty;
                                $ctCutQty += (int)$rowCut->cutQty;
                                $ctInQty += (int)$row->cutInQty;
                                $ctIssueQty += (int)$row->issueQty;
                                $ctOutQty += (int)$row->outQty;
                            }

                    ?>
                        <tr>
                            <?php 
                                 
                                if($style != $rowCut->style){
                                    $style = $rowCut->style;
                                    ?>
                                <td><?php echo $rowCut->style ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }

                                if($color != $rowCut->color){
                                    $color = $rowCut->color;
                                    ?>
                                <td><?php echo $rowCut->color ?></td>
                                <?php
                                }else{
                                ?>
                                    <td></td>
                                <?php
                                }
                            ?>
                            <td><?php echo $rowCut->size ?></td>
                            <td class="qty amount"><?php echo $row->orderQty ?></td>
                            <td class="qty amount"><?php echo $rowCut->cutQty ?></td>
                            <td class="qty amount"><?php echo $row->cutInQty ?></td>
                            <td class="qty amount"><?php echo $row->issueQty ?></td>
                            <td class="qty amount"><?php echo $row->outQty ?></td>
                        </tr>
                    <?php

                        if($i == count($CutDataFromGama)){

                            if( $colorCount != 0){
                                ?>
                                <tr>
                                <td></td>
                                <td></td>
                                <td class="colorTotal">Color Total : </td>
                              
                                <td class="colorTotal"><?php echo  $ctOrderQty ?></td>

                                <td class="colorTotal"><?php echo  $ctOrderQty ?></td>
                             
                                <td class="colorTotal"><?php echo $ctInQty ?></td>
                              
                                <td class="colorTotal"><?php echo $ctIssueQty ?></td>
                               
                                <td class="colorTotal"><?php echo $ctOutQty ?></td>
                              
                            </tr>
                                <?php
                            }
                            ?>
                            
                            

                        <?php
                            $stTotalQty += $ctOrderQty ;
                            $stCutQty += $ctCutQty ;
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
                            <td class="stTotal">Total : </td>
                                <td class="stTotal"><?php echo  $stTotalQty ?></td>
                                <td class="stTotal"><?php echo  $stCutQty ?></td>
                                <td class="stTotal"><?php echo $stInQty ?></td>
                                <td class="stTotal"><?php echo $stIssueQty ?></td>
                                <td class="stTotal"><?php echo $stOutQty ?></td>
                                
                            </tr>
                            <?php

                        }
                        $i++;
                    }

                    }///// productM ForEach End /////

                        } ///// GamaSys data ForEach End //// 
                    }else{
                        ?>
                            <td colspan="8" class="text-center">No Result</td>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        var fileName  = 'Style Summary  Report '+ date;
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
