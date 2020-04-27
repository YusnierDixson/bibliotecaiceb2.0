<?php
require_once(dirname(__FILE__) . '../../config.php');

global $DB;
// We don't actually modify the session here as we have NO_MOODLE_COOKIES set.
$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category =$DB->get_record('course_categories', array("id" => $courseid ));

$PAGE->set_context(context_system::instance());
//$PAGE->set_pagelayout('standard');
/*$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$PAGE->set_pagelayout('incourse');
require_course_login($course, true);*/
$PAGE->set_pagelayout('course');

$PAGE->set_title("Biblioteca");
$PAGE->set_heading("Biblioteca");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/busqueda.php');
//$PAGE->navbar->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));


require_login();

$nombre = optional_param('nombre', '', PARAM_TEXT);
$autor = optional_param('autor', '', PARAM_TEXT);
$materia = optional_param('materia', '', PARAM_TEXT);
$palabraclave = optional_param('palabraclave', '', PARAM_TEXT);
$cat = optional_param('cat',1, PARAM_INT);
$filt = optional_param('fil','',PARAM_ALPHANUM);
$catr = $DB->get_record('biblioteca_categorias', array('id'=>$cat));
$idN = 0;
$offset = 5;
$page = optional_param('page', 0, PARAM_INT);
$ordenar = optional_param('buscarselect', 'criterio', PARAM_TEXT);
$selbusq = optional_param('selbusq', '', PARAM_TEXT);
$criterio = optional_param('criterio', '', PARAM_TEXT);

//$PAGE->navbar->add($catr->nombre);


$sqlCat = 'SELECT * FROM mdl_biblioteca_atributos order by descripcion';
$resultdes = $DB->get_records_sql($sqlCat);

$sqldes = 'SELECT * FROM mdl_biblioteca_categorias order by nombre';
$resultcat = $DB->get_records_sql($sqldes);

if ($cat > 0) {
    $cats = " and r.idCategoria=" . $cat;
} else {
    $cats = "";
}


        $sql = 'SELECT * FROM mdl_biblioteca_recursos'
        . ' WHERE idCategoria = ?   
    and autor like "%'. $criterio. '%" 
    order by '.$criterio.' 
$result = $DB->get_records_sql($sql, array( $catr->id ));


//$previewnode = $PAGE->navigation->add($category->name, new moodle_url('course/index.php?categoryid='.$course->category), navigation_node::TYPE_CONTAINER);
//course/view.php?id=2
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
$thingnode1 = $thingnode->add('Aspectos Generales del Programa', new moodle_url('/course/view.php?id='.$courseid.'&section=1'));
$thingnode2 = $thingnode1->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode3 = $thingnode2->add($catr->nombre, new moodle_url('/biblioteca/busqueda1.php'));
$thingnode3->make_active();

echo $OUTPUT->header();
?>
<div class="section-navigation navigationtitle">
	<span class="mdl-left"></span>
<span class="mdl-left"><a href="/course/view.php?id=<?php echo $courseid;?>&section=1"><span class="larrow">◀︎</span>Regresar al Curso</a></span>
    <h3 class="sectionname" style="color: rgb(255, 255, 255); margin-left: 0px; width: 99%; background: rgb(230, 54, 61);     padding-left: 9px;"><span>Biblioteca</span></h3>
    </div>
<div class="contenedor">
    <p><?php echo $catr->nombre?></p>
    <p><?php echo get_string("intro_".$catr->id, "block_biblioteca")?></p>
    <hr style="border-bottom: 2px solid rgba(0,0,0,0.6); margin-left: -10px;
    margin-right: -10px;"/>
    <form id="form1" name="form1" method="post" action="#">
      <table width="90%" border="0" align="center" cellspacing="1">
        <tr>
          <td width="13%" height="30">Búsqueda por:<select name="selbusq" id ="selbusq">
  <option value="autor">Autor</option> 
  <option value="titulo">Titulo</option>
  <option value="materia">Asignatura</option>
  <option value="tema">Tema</option>
  <option value="palabraclave">Palabra Clave</option>
</select></td></tr>
          <tr>
          <td width="87%">
            <input name="criterio" type="text" id="criterio" size="70" /></td>
            </tr>
        
        
        <tr>
          <td height="30" colspan="2" align="right"><input type="submit" name="borrar" id="borrar" value="Buscar" />
            <input type="reset" name="borrar2" id="borrar2" value="Limpiar" />
            
        </tr>
      </table>
    </form>
    
<p>
      <!--<a href="?cat=<?php echo $catr->id?>">Todos</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=A">A</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=B">B</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=C">C</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=D">D</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=E">E</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=F">F</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=G">G</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=H">H</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=I">I</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=J">J</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=K">K</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=L">L</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=M">M</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=N">N</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=Ñ">Ñ</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=O">O</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=P">P</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=Q">Q</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=R">R</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=S">S</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=T">T</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=U">U</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=V">V</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=W">W</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=X">X</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=Y">Y</a> - 
      <a href="?cat=<?php echo $catr->id?>&fil=Z">Z</a>-->
    </p>
     <table width="90%" border="0" align="center" cellspacing="1">
         <thead>
             <tr>
                 <th>ID</th>
                 <th>Titulo</th>
                 <th>Autor</th>
                 <th>Asignatura</th>
                 <th>Palabra Clave</th>
             </tr>
         </thead>
         <tbody>
             <?php foreach ($result as $row){ ?>
             <tr>
                 <td><a href="busqueda_detalle.php?cat=<?php echo $cat?>&id=<?php echo $row->id?>"><i class="fa fa-file-text" aria-hidden="true"></i>
</a></td>
                 <td><?php echo $row->titulo?></td>
                 <td><?php echo $row->autor?></td>
                 <td><?php echo $row->materia?></td>
                 <td><?php echo $row->palabraclave?></td>
             </tr>
             <?php }?>
         </tbody>
     </table>
    
</div>
<?php
echo $OUTPUT->footer();
?>