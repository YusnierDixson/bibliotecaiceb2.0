<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;
     $autor = $_POST['autor'];
     $asig = $_POST['asigs'];
     $type = $_POST['type'];
     $anno = $_POST['anno'];
    // $sql="SELECT * FROM mdl_biblioteca_recursos WHERE idCategoria = 2";
     if($autor!='' && $asig!='' && $type==0 && $anno==0)
     {
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE autor like "%' . $autor . '%"
          and materia like "%' . $asig . '%" ORDER BY titulo DESC';
     } else if($autor!='' && $asig!='' && $type!=0 && $anno!=0){
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE autor like "%' . $autor . '%"
          and materia like "%' . $asig . '%" and idCategoria like "%' . $type . '%" and ano like "%' . $anno . '%"
          ORDER BY titulo DESC';
     } else if($autor!='' && $asig=='' && $type==0 && $anno==0){
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE autor like "%' . $autor . '%" ORDER BY titulo DESC';
     }
     else if($autor=='' && $asig!='' && $type==0 && $anno==0){
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE materia like "%' . $asig . '%" ORDER BY titulo DESC';
     }
     else if($autor=='' && $asig=='' && $type!=0 && $anno==0){
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE idCategoria = "'.$type.'" ORDER BY titulo DESC';
     }
     else if($autor=='' && $asig=='' && $type==0 && $anno!=0){
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE ano = "'.$anno.'" ORDER BY titulo DESC';
     }
     else if($autor=='' && $asig=='' && $type!=0 && $anno!=0){
          $sql = 'SELECT * FROM mdl_biblioteca_recursos'
          . ' WHERE ano = "'.$anno.'" and idCategoria = "'.$type.'" ORDER BY titulo DESC';
     }
    

$result = $DB->get_records_sql($sql);


 
  
    $jsonstring=json_encode($result);
    echo $jsonstring;

