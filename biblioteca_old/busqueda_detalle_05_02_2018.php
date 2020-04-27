<?php
require_once(dirname(__FILE__) . '../../config.php');

global $DB;
// We don't actually modify the session here as we have NO_MOODLE_COOKIES set.

$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category =$DB->get_record('course_categories', array("id" => $courseid ));

$PAGE->set_context(context_system::instance());
//$PAGE->set_pagelayout('standard');
$PAGE->set_pagelayout('course');

$PAGE->set_title("Biblioteca ICEB");
$PAGE->set_heading("Biblioteca");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/busqueda.php');
//$PAGE->navbar->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
//$PAGE->navbar->add(get_string("config_name", "block_biblioteca"), new moodle_url('/biblioteca/configuracion.php'));
//$PAGE->navbar->add(get_string("config_update_name", "block_biblioteca"));
require_login();
//$cat = required_param('cat', PARAM_INT);
$idr = required_param('id', PARAM_INT);
$cat = optional_param('cat',1, PARAM_INT);

$result = $DB->get_record('biblioteca_recursos', array('id' => $idr));

$resultcat = $DB->get_record('biblioteca_categorias', array('id' => $cat ));

$resultsubcat = $DB->get_record('biblioteca_subcategoria', array('id' => $result->idsubcategoria));

//$previewnode = $PAGE->navigation->add($category->name, new moodle_url('course/index.php?categoryid='.$course->category), navigation_node::TYPE_CONTAINER);
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
//$thingnode1 = $thingnode->add('Aspectos Generales del Programa', new moodle_url('/course/view.php?id='.$courseid.'&section=1'));
$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add($resultcat->nombre, new moodle_url('/biblioteca/busqueda.php'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
$thingnode3->make_active();

echo $OUTPUT->header();
?>
<div class="contenedor">
      <form action="configuracion.php" method="post" enctype="multipart/form-data" name="form" id="form">
        <table width="90%" border="0" align="center" cellspacing="1">
          <tr>
            <td width="15%" height="30"><b>Título</b></td>
            <td width="85%"><label for="nombre"></label>
              <?php echo $result->titulo ?></td>
          </tr>
          <tr>
            <td height="30"><b>Autor</b></td>
            <td><?php echo $result->autor ?></td>
          </tr>
          <tr>
            <td height="30"><b>Tipo</b></td>
            <td><?php echo $resultcat->nombre ?></td>
          </tr>
          <tr>
            <td height="30"><b>Asignatura</b></td>
            <td><?php echo $result->materia ?></td>
          </tr>
          <tr>
            <td height="30"><b>Resumen</b></td>
            <td><?php echo $result->resumen ?></td>
          </tr>
          <tr>
            <td height="30"><b>Palabras Claves</b></td>
            <td><?php echo $result->palabraclave ?></td>
          </tr>
          <tr>
            <td height="30"><b>Tema</b></td>
            <td><?php echo $result->recurso ?></td>
          </tr>
          <tr>
            <td height="30"><b>Lugar de Publicación</b></td>
            <td><?php echo $result->lugarpublicacion ?></td>
          </tr>
          <tr>
            <td height="30"><b>Editorial</b></td>
            <td><?php echo $result->editorial ?></td>
          </tr>
          <tr>
            <td height="30"><b>Idioma</b></td>
            <td><?php echo $result->idioma ?></td>
          </tr>
          <tr>
            <td height="30"><b>Área Conocimiento</b></td>
            <td><?php echo $result->areaconocimiento ?></td>
          </tr>
          <tr>
            <td height="30"><b>Año Publicación</b></td>
            <td><?php echo $result->ano ?></td>
          </tr>
          <tr>
            <td height="30" colspan="2" align="right"><input type="button" name="borrar3" id="borrar3" value="Regresar" onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/busqueda.php?cat='.$cat ?>')"/>
              <a class="botton" href="<?php echo $result->url ?>"><b>Ver</b></a>
              <!--<input type="submit" name="borrar" id="borrar" value="Descargar" />--></td>
          </tr>
        </table>
    </form>
</div>   
<?php
echo $OUTPUT->footer();
?>
