<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;

if(isset($_POST['id'])){
    $titulo=$_POST['title'];
    $autor=$_POST['autor'];
    $resumen=$_POST['resumen'];
    $tipo=$_POST['type'];
    $asignatura=$_POST['asignatura'];
    $tipo_lect=$_POST['type_lect'];
    $año=$_POST['year'];
    $claves=$_POST['claves'];
    $conocimiento=$_POST['conocimiento'];
    $tema=$_POST['tema'];
    $revista=$_POST['revista'];
    $editorial=$_POST['editorial'];
    $issn=$_POST['issn'];
    $isbn=$_POST['isbn'];
    $idioma=$_POST['idioma'];
    $url=$_POST['url'];
    $lugar=$_POST['place'];
    $id=$_POST['id'];
    
    $dataobject = array(
        "id"=>$id,
        "idCategoria" => $tipo,
        "idSubCategoria" => '2',
        "titulo" => $titulo,
        "autor" => $autor,
        "materia" => $asignatura,
        "ano" => $año,
        "resumen" => $resumen,
        "palabraclave" => $claves,
        "recurso" => $tema,
        "numeropagina" => $issn,
        "revista" => $revista,
        "lugarpublicacion" => $lugar,
        "editorial" => $editorial,
        "url" => $url,
        "isbn" => $isbn,
        "idioma" => $idioma,
        "areaconocimiento" => $conocimiento,
        "tipolectura" => $tipo_lect
    );
    
$idN = $DB->update_record("biblioteca_recursos", $dataobject, $bulk = false);
if (!$idN) {
    die('Query Failed');

}
echo "Task Updated Successfully";




}





