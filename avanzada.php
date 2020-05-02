<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;
     $autor = $_POST['autor'];
     $tema = $_POST['tema'];
     $claves = $_POST['claves'];
     $type = $_POST['type'];
     $anno = $_POST['anno'];

     $sql = 'SELECT * FROM mdl_biblioteca_recursos'
     . ' WHERE idCategoria like "%' . $type . '%"
     and autor like "%' . $autor . '%"
     and palabraclave like "%' . $claves . '%"
     and recurso like "%' . $tema. '%"
     and ano like "%' . $ano . '%"
     order by titulo';

$result = $DB->get_records_sql($sql, $params=null);


 
  
    $jsonstring=json_encode($result);
    echo $jsonstring;

