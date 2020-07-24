<?php
// error_reporting(-1);
// ini_set('display_errors', 1);
class YearEfficiency extends MY_Controller{

    private $location;

    function __construct(){
        parent::__construct();
        $this->checkSession();
        $this->location = $this->myConlocation;
        $this->load->model('year_efficency_model');
    }

    public function index($location='',$year='',$yearData=''){

        if($location==''){
            $location  = $_SESSION['session_user_data']['location'];
        }
        if($year==''){
            $year = date('Y');
        }
        if($yearData==''){
            $yearData = $this->year_efficency_model->getYearData($location,$year);
        }

        $data['locations'] = $this->year_efficency_model->getLocations();
        $data['years'] = $this->year_efficency_model->getYears();
        $data['data'] = $yearData;
        $data['selectYear'] = $year;
        $data['selectLocation'] = $location;
        $data['minuteForHour']= $this->year_efficency_model->getMinutForHour($location,'Production');

        $this->load->view('template/header',$data);
        $this->load->view('template/sidebar');
        $this->load->view('year_efficiency_dashboard');
        $this->load->view('template/footer');
    }

    public function getYearData($location='',$year=''){
        if($location==''){
            $location  = $this->input->post('location');
            if($location==''){
                $location = $this->location;
            }
        }
        if($year==''){
            $year = $this->input->post('year');
            
        }

        $result = $this->year_efficency_model->getYearData($location,$year);     
        if($result){
            $this->index($location,$year,$result);
        }else{
            $this->index($location,$year,$result='Nodata');
        }
    }

}