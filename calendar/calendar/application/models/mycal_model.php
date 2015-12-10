<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mycal_model extends CI_Model {
    function generate_calendar($year, $month) {

        $pref = array('show_next_prev' => 'TRUE', 'next_prev_url' => base_url() . 'my_calendar/showcal');
        $events = $this -> get_events($year, $month);

        $this -> load -> library('calendar', $pref);
        
        return $this -> calendar -> generate($year, $month, $events);
    }

    function get_events($year, $month) {

        $events = array();

        $query = $this -> db -> select('date,event') -> from('calendar') -> like('date', "$year-$month") -> get();
        $query = $query -> result();
        foreach ($query as $row) {
            $day = (int)substr($row -> date, 8, 2);
            $events[(int)$day] = $row -> event;
        }
        return $events;
    }

    function add_events($date, $event) {

        $query = $this -> db -> get_where('calendar', array('date' => $date));

        if ($query -> num_rows() > 0) {
            $this->db->where('date',$date);
            $this->db->update('calendar',array('event'=>$event));

        } else {

            $this -> db -> insert('calendar', array('date' => $date, 'event' => $event));
        }

    }
    
    function delete_event($date){
        $this->db->delete('calendar',array('date'=>$date));
    }

    function java_functions() {

        $function = "
            $('.field_set').fadeIn(600);
            $('.this_day').removeClass('selected');
            $(this).addClass('selected');
            var day_event = $('.selected .day_event').text();
            $('#day_event').val(day_event);
            if (day_event !=''){
                $('#addEvent').val('Save Event');
                $('#delete').show();
            }else {
                $('#addEvent').val('Add Event');
                $('#delete').hide();
            }
            
            
        ";

        $add_new_event = "
           var selected_day = $('.selected .day_num').text();
           var event = $('#day_event').val();
           if ( (selected_day == '') || (event == '')){
              if (selected_day == ''){
                  alert('select a valid day')
                  $('.this_day').removeClass('selected');
                  exit;
              }     
              if (event == ''){
                  alert('enter an event')
                  
              }     
           }
           else 
           {
               $.ajax({
                        url: window.location,
                        type: 'POST',
                        data: {
                            day: selected_day,
                            event: event
                        },
                        success: function(msg) {
                            location.reload();
                        }                       
                    }); 
           }
        ";
        $cancel_button = "
            $('.field_set').hide();
            $('.this_day').removeClass('selected');
                
                
        ";
        
        $delete_button = "
            var selected_day = $('.selected .day_num').text();
            var day_event = $('.selected .day_event').text();
            if (day_event != ''){
                
                $.ajax({
                        url: window.location,
                        type: 'POST',
                        data: {
                            day_to_delete: selected_day,
                            
                        },
                        success: function(msg) {
                            location.reload();
                        }                       
                    }); 
            }
        ";
        $click = "
            var div = $('.alink').attr('href');
             $('#' + div).toggle();
            
           
          
        ";
        $this -> javascript -> click('.this_day', $function);
        $this -> javascript -> click('#addEvent', $add_new_event);
        $this -> javascript -> click('#cancel', $cancel_button);
        $this -> javascript -> click('#click', $click);
        $this -> javascript -> click('#delete', $delete_button);
        $this -> javascript -> compile();
    }

}

/*end of file*/

