<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;
//require_login();
//$courseid = $_SESSION['idCurso'];
//$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
//$category = $DB->get_record('course_categories', array("id" => $courseid));
//$sections=$DB->get_records_list('course_sections','course', array("course" => $courseid),$sort='1',$fields='*', $limitfrom='', $limitnum='');

//$PAGE->set_context(context_system::instance());

$search=$_POST['search'];
if (!empty($search)) {
    $query="SELECT * FROM mdl_biblioteca_recursos WHERE titulo LIKE '$search%'";
    $result=$DB->get_records_sql($query);
    if (!$result) {
        echo "Error BD Connection";
        }

   /* $json=array();
    while($row= mysqli_fetch_array($result)){
        $json[]=array(
            'name'=>$row['titulo'],
            'description'=>$row['materia'],
            'id'=>$row['id']
        );
    }*/
   $jsonstring=json_encode($result);
   echo $jsonstring;
     
}

?>