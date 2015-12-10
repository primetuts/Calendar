<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class My_calendar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this -> jquery -> script(base_url() . 'js/jquery/jquery.js', TRUE);

    }

    function index($year = null, $month = null) {
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        $this -> showcal($year, $month);

    }

    function showcal($year = null, $month = null) {
        
        $this -> load -> model('mycal_model');

        $this -> mycal_model -> java_functions();
        if ($this -> input -> post('day')) {

            $day = $this -> input -> post('day');
            $event = trim($this -> input -> post('event'));
            $date = "$year-$month-$day";
            $this -> mycal_model -> add_events($date, $event);
        }
        
        if ($this -> input -> post('day_to_delete')) {

            $day = $this -> input -> post('day_to_delete');
            $date = "$year-$month-$day";
            $this -> mycal_model -> delete_event($date);
        }
        
        $data['title'] = 'My calendar';
        $data['calendar'] = $this -> mycal_model -> generate_calendar($year, $month);
        $this -> load -> view('header_view', $data);
        $this -> load -> view('main_content_view', $data);

    }
}
