<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;
require_login();
$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category = $DB->get_record('course_categories', array("id" => $courseid));
$sections=$DB->get_records_list('course_sections','course', array("course" => $courseid),$sort='1',$fields='*', $limitfrom='', $limitnum='');

$PAGE->set_context(context_system::instance());

    $query="SELECT * FROM tareas";
    $result=mysqli_query($connection,$query);
    if (!$result) {
        die('Query Error'.mysqli_error($connection));

    }

    $json=array();
    while($row= mysqli_fetch_array($result)){
        $json[]=array(
            'name'=>$row['name'],
            'description'=>$row['description'],
            'id'=>$row['id']
        );
    }
    $jsonstring=json_encode($json);
    echo $jsonstring;



