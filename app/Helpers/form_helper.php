<?php

use CodeIgniter\CodeIgniter;

// Displaying error of form 
function display_form_errors($validation, $field){
    if ($validation->hasError($field)) {
        return $validation->getError($field);
    }
}