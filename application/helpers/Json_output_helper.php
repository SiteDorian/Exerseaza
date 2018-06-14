<?php

defined('BASEPATH') or exit('No direct script acces allowed');

function json_output($status, $raspuns){
    $ci =& get_instance();
    $ci->output->set_content_type('application/json');
    $ci->output->set_status_header($status);
    $ci->output->set_output(json_encode($raspuns));
}