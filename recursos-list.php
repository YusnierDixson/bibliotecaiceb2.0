<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;




$result=$DB->get_records('biblioteca_recursos', $conditions=null, 'id DESC', $fields='*', $limitfrom=0, $limitnum=5);


    //$result=$DB->get_records_sql($query);
    if (!$result) {
        echo "Error BD Connection";
        }


    $jsonstring=json_encode($result);
    echo $jsonstring;



