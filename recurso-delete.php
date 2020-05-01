<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;



if(isset($_POST['id'])){
$id=$_POST['id'];

$select="id=".$id;
$idD =$DB->delete_records_select("biblioteca_recursos", $select);

if (!$idD) {
    die('Query Error');

}
echo "Task Deleted Successfully";


}





