<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;


$search=$_POST['search'];
if (!empty($search)) {
    $query="SELECT * FROM mdl_biblioteca_recursos WHERE titulo LIKE '$search%'";
    $result=$DB->get_records_sql($query);


   $jsonstring=json_encode($result);
   echo $jsonstring;
     
}

?>