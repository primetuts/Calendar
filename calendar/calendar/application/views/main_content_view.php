<?php
   
    // data to be passed to the field set
    $style = array('class' => 'field_set');
    
    //field set
    echo form_fieldset('Day Event', $style);
    
    //text field attribute to be passed to the echo form_input
        $text = array('name' => 'day_event', 'id' => 'day_event', 'style' => 'width:97%');
    //create the text field
    echo form_input($text) . br(2);
    // submit button attributes to be passed to echo form_submit    
        $text = array('name' => 'addEvent', 'id' => 'addEvent', 'value' => 'Add Event', 'style' => 'width:33%;padding:5px;', );
    // create the submit button.
    echo form_submit($text);
    
    $text = array('name' => 'cancel', 'id' => 'cancel', 'content' => 'Cancel', 'style' => 'width:33%;padding:5px;', );
    // create the cancel button.
    echo form_button($text);
    $text = array('name' => 'delete', 'id' => 'delete', 'content' => 'Delete event', 'style' => 'width:33%;padding:5px;', );
    // create the delete button.
    echo form_button($text);
    
    echo form_fieldset_close();
    echo br();
    echo $calendar . br(3);
?>