<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    public function __construct() {
      parent::__construct();

      if (!$this->ion_auth->logged_in()) {
        redirect('auth/login', 'refresh');
      }
    }

    public function index(){
      $this->load->model('Schedule_model');
      $this->load->model('Availability_model');

      if ($this->ion_auth->is_admin()) {
        $data["userRole"] = "ADMIN";
        $data["options"] = ["Sync Data", "Create User", "Edit Users", "Change Password", "Logout"];
        $data["href"] = ["data", "auth/create_user", "auth", "auth/change_password", "auth/logout"];
        $data["font"] = ["database","user-plus", "edit", "refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "Screeners", "Locations", "Requests"];
        $data["link"] = ["main/index", "screeners", "locations", "request/view"];
        $data["icon"] = ["calendar","user", "building", "exclamation-triangle"];

        $scheduleData['scheduleView'] = $this->Schedule_model->getSchedule();

        if ($this->input->is_ajax_request()) {
          echo json_encode($scheduleData);
          exit;
        }
          
      } elseif ($this->ion_auth->in_group("hostpial admin")) {
        $data["userRole"] = "HOSPITAL ADMIN";
        $data["options"] = ["Logout", "Change Password"];
        $data["href"] = ["auth/logout", "auth/change_password"];
        $data["font"] = ["refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "Screeners", "Locations", "Requests"];
        $data["link"] = ["main/index", "screeners", "locations", "request/view"];
        $data["icon"] = ["calendar","user", "building", "exclamation-triangle"];    

        $scheduleData['scheduleView'] = $this->Schedule_model->getSchedule();

        if ($this->input->is_ajax_request()) {
          echo json_encode($scheduleData);
          exit;
        } 
      } else {
        $data["userRole"] = "SCREENER";
        $data["options"] = ["Change Password", "Logout"];
        $data["href"] = ["auth/change_password", "auth/logout"];
        $data["font"] = ["refresh", "sign-out"];

        $data["sideMenu"] = ["Calendar", "Availability", "My Requests"];
        $data["link"] = ["main/index", "screeners/add", "request/view"];
        $data["icon"] = ["calendar","user", "check-square-o"];

        // $employeeid = $this->ion_auth->user()->row()->employeeid;
        // $screenerScheduleData['scheduleViewScreener'] = $this->Schedule_model->getScheduleScreener($employeeid);
        $first_name = $this->ion_auth->user()->row()->first_name;
        $last_name = $this->ion_auth->user()->row()->last_name;
        $screenerScheduleData['scheduleViewScreener'] = $this->Schedule_model->getScheduleScreenerByName($first_name, $last_name);

        if ($this->input->is_ajax_request()) {
          echo json_encode($screenerScheduleData);
          exit;
        }
      }

      $data["userFirstName"] = $this->ion_auth->user()->row()->first_name;
      $data["userLastName"] = $this->ion_auth->user()->row()->last_name;
      $availabilityData["availabilities"] = $this->Availability_model->getAvailability();
              
     //$data['eventsAll'] = $this->Events_model->listAll();
      $this->load->view('main/header');
      $this->load->view('main/sidebar', $data);
      $this->load->view('main/topbar', $data);
      $this->load->view('calendar/view', $availabilityData);
      $this->load->view('main/footer');
    }

    public function saveEvent() {
      $this->output->set_content_type('application/json');
      echo json_encode(array('check' => 'Ajax successful'));
    }

}
