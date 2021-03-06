<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screeners extends CI_Controller {
    public function __construct() {
      parent::__construct();

      if (!$this->ion_auth->logged_in()) {
        redirect('auth/login', 'refresh');
      }
    }

    public function index(){

      if ($this->ion_auth->is_admin()) {
        $data["userRole"] = "ADMIN";
        $data["options"] = ["Sync Data", "Create User", "Edit Users", "Change Password", "Logout"];
        $data["href"] = ["data", "auth/create_user", "auth", "auth/change_password", "auth/logout"];
        $data["font"] = ["database","user-plus", "edit", "refresh", "sign-out"]; 

        $data["sideMenu"] = ["Calendar", "Screeners", "Check-in/Check-out", "Locations", "Requests"];
        $data["link"] = ["main/index", "screeners", "checkin", "locations", "request/view"];
        $data["icon"] = ["calendar","user", "list", "building", "exclamation-triangle"];

        $this->load->model('Screeners_model');
        $data['screenersAll'] = $this->Screeners_model->listAll();

      } elseif ($this->ion_auth->in_group("hostpial admin")) {
        $data["userRole"] = "HOSPITAL ADMIN";
        $data["options"] = ["Logout"];
        $data["href"] = ["auth/logout"];
        $data["font"] = ["refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "Screeners", "Check-in/Check-out", "Locations", "Requests"];
        $data["link"] = ["main/index", "screeners", "checkin", "locations", "request/view"];
        $data["icon"] = ["calendar","user", "list", "building", "exclamation-triangle"];

        $this->load->model('Screeners_model');
        $data['screenersAll'] = $this->Screeners_model->listAll();

      } else {
        redirect('main/index', 'refresh');
      }

      $this->load->model('Screeners_model');
      $data["userFirstName"] = $this->ion_auth->user()->row()->first_name;
      $data["userLastName"] = $this->ion_auth->user()->row()->last_name;
      $this->load->view('main/header');
      $this->load->view('main/sidebar', $data);
      $this->load->view('main/topbar', $data);
      //passing the data in list
      
      $this->load->view('screeners/list', $data);
      $this->load->view('main/footer');
    }

    public function add(){
      if ($this->ion_auth->is_admin()) {
        $data["userRole"] = "ADMIN";
        $data["options"] = ["Sync Data", "Create User", "Edit Users", "Change Password", "Logout"];
        $data["href"] = ["data", "auth/create_user", "auth", "auth/change_password", "auth/logout"];
        $data["font"] = ["database","user-plus", "edit", "refresh", "sign-out"];
        
        $data["sideMenu"] = ["Calendar", "Screeners", "Check-in/Check-out", "Locations", "Requests"];
        $data["link"] = ["main/index", "screeners", "checkin", "locations", "request/view"];
        $data["icon"] = ["calendar","user", "list", "building", "exclamation-triangle"];     
      } elseif ($this->ion_auth->in_group("hostpial admin")) {
        $data["userRole"] = "HOSPITAL ADMIN";
        $data["options"] = ["Logout"];
        $data["href"] = ["auth/logout"];
        $data["font"] = ["refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "Screeners", "Check-in/Check-out", "Locations", "Requests"];
        $data["link"] = ["main/index", "screeners", "checkin", "locations", "request/view"];
        $data["icon"] = ["calendar","user", "list", "building", "exclamation-triangle"];
      } else {
        $data["userRole"] = "SCREENER";
        $data["options"] = ["Change Password", "Logout"];
        $data["href"] = ["auth/change_password", "auth/logout"];
        $data["font"] = ["refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "My Profile", "My Requests"];
        $data["link"] = ["", "", ""];
        $data["icon"] = ["calendar","user", "check-square-o"];
      }
        
      $data["userFirstName"] = $this->ion_auth->user()->row()->first_name;
      $data["userLastName"] = $this->ion_auth->user()->row()->last_name;
      $this->load->view('main/header');
      $this->load->view('main/sidebar', $data);
      $this->load->view('main/topbar', $data);

        // Week 1 and week 2 timespan
        $day = date('w'); 
        $week_start = date('m/j/Y', strtotime('-'.$day.' days'));
        $week_end = date('m/j/Y', strtotime('+'.(6-$day).' days'));	
        $week_2start = date('m/j/Y', strtotime('+'.(7-$day).' days'));
        $week_2end = date('m/j/Y', strtotime('+'.(13-$day).' days'));

        // Getting individual dates for each day
        $datesArr = array();
        for($i = 0;  $i < 14; $i++) {
          $date = date('m/j/Y', strtotime("$week_start + $i days"));
          $datesArr[] = $date;
        }

        $data['week_start'] = $week_start;
        $data['week_2start'] = $week_2start;
        $data['week_end'] = $week_end;
        $data['week_2end'] = $week_2end;

        $mornTimeArr = array();
        $eveTimeArr = array();
        $nightTimeArr = array();

        for($i = 0; $i<14; $i++) {
          $datetime = new DateTime($datesArr[$i].'05:00:00');
          $mornTimeArr[] = $datetime->format('Y-m-d H:i:s');
        }
        for($i = 0; $i<14; $i++) {
          $datetime = new DateTime($datesArr[$i].'13:00:00');
          $eveTimeArr[] = $datetime->format('Y-m-d H:i:s');
        }
        for($i = 0; $i<14; $i++) {
          $datetime = new DateTime($datesArr[$i].'23:00:00');
          $nightTimeArr[] = $datetime->format('Y-m-d H:i:s');
        }	

      $data['datesArr'] = $datesArr;
      $data['mornTimeArr'] = $mornTimeArr;
      $data['eveTimeArr'] = $eveTimeArr;
      $data['nightTimeArr'] = $nightTimeArr;

      $firstname = $this->ion_auth->user()->row()->first_name;
      $lastname = $this->ion_auth->user()->row()->last_name;

      // Uneditable information
      $data['first_name'] = $firstname;
      $data['last_name'] = $lastname;
      $data['employeeid'] = $this->ion_auth->user()->row()->employeeid;
      $data['email'] = $this->ion_auth->user()->row()->email;

      $this->load->model('Availability_model');
      $data['avail'] = $this->Availability_model->screenerAvail($firstname, $lastname);

      $this->load->view('screeners/add', $data);
      $this->load->view('main/footer');
    }

    public function added_time() {
      // Uneditable information
      $data['first_name'] = $this->ion_auth->user()->row()->first_name;
      $data['last_name'] = $this->ion_auth->user()->row()->last_name;
      $data['employeeid'] = $this->ion_auth->user()->row()->employeeid;
      $data['email'] = $this->ion_auth->user()->row()->email;

      $this->load->model('Availability_model');
    
      // Getting Dates
      $morn_times = $this->input->post('morn_times');
      if ($morn_times != null) {
        $morn_time = $morn_times;
      } else {
        $morn_time = [];
      }

      $eve_times = $this->input->post('eve_times');
      
      if ($eve_times != null) {
        $eve_time = $eve_times;
      } else {
        $eve_time = [];
      }

      $night_times = $this->input->post('night_times');
      if ($night_times != null) {
        $night_time = $night_times;
      } else {
        $night_time = [];
      }

      for ($i=0; $i < sizeof($morn_time); $i++){
        $my_dt = new DateTime($morn_time[$i]);
        $expires_at = $my_dt->modify(' +8 hour');
        $end_date = $expires_at->format('Y-m-d H:i:s');
        
        $morn = array(
          'employeeid' => $data['employeeid'],
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'start' => $morn_time[$i],
          'end' => $end_date,
          'shift_type' => 'morning'
        );
          $this->Availability_model->addAvail($morn);
      }

      for($i=0; $i < sizeof($eve_time); $i++){
        $my_dt = new DateTime($eve_time[$i]);
        $expires_at = $my_dt->modify(' +8 hour');
        $end_date = $expires_at->format('Y-m-d H:i:s');

        $eve = array(
          'employeeid' => $data['employeeid'],
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'start' => $eve_time[$i],
          'end' => $end_date,
          'shift_type' => 'evening'
        );
        $this->Availability_model->addAvail($eve);
      }

      for($i=0; $i < sizeof($night_time); $i++){
        $my_dt = new DateTime($night_time[$i]);
        $expires_at = $my_dt->modify(' +8 hour');
        $end_date = $expires_at->format('Y-m-d H:i:s');

        $night = array(
          'employeeid' => $data['employeeid'],
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'start' => $night_time[$i],
          'end' => $end_date,
          'shift_type' => 'night'
        );
        $this->Availability_model->addAvail($night);
      }
        

      $morn_rule = $this->form_validation->set_rules('morn_times[]', 'Morn Times', 'required');
      $eve_rule = $this->form_validation->set_rules('eve_times[]', 'Eve Times', 'required');
      $night_rule = $this->form_validation->set_rules('night_times[]', 'Night Times', 'required');


      if ($this->form_validation->run() === FALSE){
        // If User selects nothing
        if ($morn_time === [] && $eve_time === [] && $night_time === []) {
          $cookie_name = "error_status";
          $cookie_value = "001";
          setcookie ( $cookie_name , $cookie_value , $expires = 0 , $path = "" , $domain = "" , $secure = false , $httponly = false );
          return redirect('screeners/add', 'refresh');
        } 
        // If User only selects one date
        elseif (($morn_time === [] && $eve_time === [] && $night_time != []) || ($morn_time === [] && $eve_time != [] && $night_time === []) || ($morn_time != [] && $eve_time === [] && $night_time === [])){
          $cookie_name = "error_status";
          $cookie_value = "none";
          setcookie ( $cookie_name , $cookie_value , $expires = 0 , $path = "/main" , $domain = "" , $secure = false , $httponly = false );
          return redirect('main/index', 'refresh');
        } 
        // If User only selects two dates
        elseif (($morn_time != [] && $eve_time != [] && $night_time === []) || ($morn_time != [] && $eve_time === [] && $night_time != []) || ($morn_time === [] && $eve_time != [] && $night_time != [])){
          $cookie_name = "error_status";
          $cookie_value = "none";
          setcookie ( $cookie_name , $cookie_value , $expires = 0 , $path = "/main" , $domain = "" , $secure = false , $httponly = false );
          return redirect('main/index', 'refresh');
        } 
        else {
          $cookie_name = "error_status";
          $cookie_value = "002";
          setcookie ( $cookie_name , $cookie_value , $expires = 0 , $path = "" , $domain = "" , $secure = false , $httponly = false );
          return redirect('screeners/add', 'refresh');
        }
      }
      else {
        $cookie_name = "error_status";
        $cookie_value = "none";
        setcookie ( $cookie_name , $cookie_value , $expires = 0 , $path = "/main" , $domain = "" , $secure = false , $httponly = false );
        return redirect('main/index', 'refresh'); 
      }

      
    }

    public function view($id){

     if ($this->ion_auth->is_admin()) {
       $data["userRole"] = "ADMIN";
       $data["options"] = ["Sync Data", "Create User", "Edit Users", "Change Password", "Logout"];
       $data["href"] = ["data", "auth/create_user", "auth", "auth/change_password", "auth/logout"];
       $data["font"] = ["database","user-plus", "edit", "refresh", "sign-out"];

       $data["sideMenu"] = ["Calendar", "Screeners", "Check-in/Check-out", "Locations", "Requests"];
       $data["link"] = ["main/index", "screeners", "checkin", "locations", "request/view"];
       $data["icon"] = ["calendar","user", "list", "building", "exclamation-triangle"];   
     } elseif ($this->ion_auth->in_group("hostpial admin")) {
       $data["userRole"] = "HOSPITAL ADMIN";
       $data["options"] = ["Logout"];
       $data["href"] = ["auth/logout"];
       $data["font"] = ["refresh", "sign-out"]; 

       $data["sideMenu"] = ["Calendar", "Screeners", "Check-in/Check-out", "Locations", "Requests"];
       $data["link"] = ["main/index", "screeners", "checkin", "locations", "request/view"];
       $data["icon"] = ["calendar","user", "list", "building", "exclamation-triangle"];
     } else {
        $data["userRole"] = "SCREENER";
        $data["options"] = ["Change Password", "Logout"];
        $data["href"] = ["auth/change_password", "auth/logout"];
        $data["font"] = ["refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "Availability", "My Requests"];
        $data["link"] = ["main/index", "screeners/add", "request/view"];
        $data["icon"] = ["calendar","user", "check-square-o"];
     }

     $this->load->model('Screeners_model');
     $data["userFirstName"] = $this->ion_auth->user()->row()->first_name;
     $data["userLastName"] = $this->ion_auth->user()->row()->last_name;
     $this->load->view('main/header', $data);
     $this->load->view('main/sidebar');
     $data['viewClient'] = $this->Screeners_model->viewClient($id);
     $this->load->view('screeners/view', $data);
     $this->load->view('main/footer');
    }

    public function editSchedule(){
      // if ($this->input->is_ajax_request()) {

          $scheduleData = array(
            'location' => $this->input->post('location'),
            'start' => $this->input->post('start'),
            'end' => $this->input->post('end'),
            'id' => $this->input->post('id')

          );
          $this->load->model('Screeners_model');
          $this->Screeners_model->editSchedule($scheduleData);
          return redirect('main/index');
      //     exit;
      // } else {
      //   echo "string";
      // }
    }

    public function addSchedule(){
      $newScheduleData = array(
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'location' => $this->input->post('location'),
        'start' => $this->input->post('start'),
        'end' => $this->input->post('end')

      );
      $this->load->model('Screeners_model');
      $this->Screeners_model->addSchedule($newScheduleData);
      return redirect('main/index');
    }
    
}
