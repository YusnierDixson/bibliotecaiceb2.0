<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;

     $id = $_POST['id'];
   
    $result=$DB->get_record('biblioteca_recursos', array('id' => $id));
    if (!$result) {
        die('Query Error');

    }

  $arrayob=(array)$result;
  
    $jsonstring=json_encode($arrayob);
    echo $jsonstring;



