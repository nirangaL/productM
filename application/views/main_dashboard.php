<style >
    
    .ewu-col-offset .col-sm-4 {
  padding: 0;
  margin: 0.25rem 0;
}
.ewu-col-offset .col-sm-4 div {
  text-align: center;
  background: #f2f2f2;
  transition: background 0.25s;
  height: 100%;
  padding: 10%;
  overflow: hidden;
}
.ewu-col-offset .col-sm-4 div i {
  padding-top: 2rem;
  padding-bottom: 1rem;
}
.ewu-col-offset .col-sm-4 div i, .ewu-col-offset .col-sm-4 div h5 {
  position: relative;
  top: 2.5rem;
  transition: top 0.25s ease;
}
.ewu-col-offset .col-sm-4 div p {
  color: #fff;
  font-size: 0.6rem;
}
.ewu-col-offset .col-sm-4 div p, .ewu-col-offset .col-sm-4 div button {
  opacity: 0;
}
.ewu-col-offset .col-sm-4::after {
  content: "";
  display: block;
  background: #a10022;
  min-height: 0%;
  width: calc(100% - 0.5rem);
  left: 0.25rem;
  bottom: -0.25rem;
  position: absolute;
  z-index: -1;
  transition: all 0.25s;
}
.ewu-col-offset .col-sm-4:hover div {
  background: rgba(0, 0, 0, 0);
  transition: all 0.25s;
}
.ewu-col-offset .col-sm-4:hover div i, .ewu-col-offset .col-sm-4:hover div h5 {
  color: #fff;
  top: 0;
  transition: top 0.25s ease;
}
.ewu-col-offset .col-sm-4:hover div p, .ewu-col-offset .col-sm-4:hover div button {
  opacity: 1;
  transition: all 0.5s ease;
}
.ewu-col-offset .col-sm-4:hover::after {
  min-height: 100%;
}


    .title{
        font-weight: bolder;
        color: #2C3A47;
    }
    .icon-3x{
        font-size:62px !important;
        color: #2C3A47;
    }

</style>

<div class="content-wrapper">

<div class="content">
    <div class="container-fluid ewu-col-offset">
    <div class="row">
        <div class="col-sm-4">
            <a href="#">
                <div class="m-1" >
                    <i class="icon-search4 icon-3x"></i>
                    <h5 class="title">Inspection</h5>
                    <p>The purpose of fabric inspection is to determine the quality and acceptability for garments. As fabric is received, it should be inspected to determine acceptability from a quality viewpoint.</p>
                    <!-- <h6>&nbsp;</h6> -->
                </div>
            </a>
        </div>
       
        <div class="col-sm-4">
        <a href="#">
        <div class="m-1" >
            <i class="icon-scissors icon-3x"></i>
            <h5 class="title">Cutting</h5>
            <p>Cutting is the process which cut out the pattern pieces from specified fabric for making garments.Using the markers made from graded patterns and in accordance with the issue plan, fabrics are cut to prepare garment assembly.</p>
            <!-- <h6>&nbsp;</h6> -->
        </div>
        </a>
        </div>
        <div class="col-sm-4">
        <a href="<?php echo base_url('Location_Dashboard_Con/production')?>">
        <div class="m-1" >
            <i class="icon-hammer-wrench icon-3x"></i>
            <h5 class="title">Production</h5>
            <p>Apparel production is a type of assembly manufacture that involves a number of processes. Fabric-cutting operation is done in a fabric-cutting department, which usually serves several downstream sewing assembly lines.</p>
            <!-- <h6>&nbsp;</h6> -->
        </div>
        </a>
        </div>
        <div class="col-sm-4">
        <a href="<?php echo base_url('qcDashboard')?>">
        <div class="m-1" >
            <i class="icon-pencil-ruler icon-3x"></i>
            <h5 class="title">Quality Control</h5>
            <p>Quality control is a process by which entities review the quality of all factors involved in production.</p>
            <!-- <h6>&nbsp;</h6> -->
        </div>
        </a>
        </div>
        <div class="col-sm-4">
        <a href="#">
        <div class="m-1" >
            <i class="icon-make-group icon-3x"></i>
            <h5 class="title">Acceptable Quality Limit</h5>
            <p>The acceptable quality limit is the worst tolerable process average in percentage or ratio that is still considered acceptable; that is, it is at an acceptable quality level. Closely related terms are the rejectable quality limit and rejectable quality level.</p>
            <h6>&nbsp;</h6>
        </div>
        </a>
        </div>
        <div class="col-sm-4">
        <a href="#">
        <div class="m-1" >
            <i class="icon-truck icon-3x"></i>
            <h5 class="title">Finish Good</h5>
            <p>Finished goods are goods that have been completed by the manufacturing process, or purchased in a completed form.</p>
            <h6>&nbsp;</h6>
        </div>
        </a>
        </div>
    </div>
    </div>
     
  </div>
  <!-- /quick stats boxes -->
