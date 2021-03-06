<?php
require_once(dirname(__FILE__) . '../../config.php');

global $DB;
// We don't actually modify the session here as we have NO_MOODLE_COOKIES set.
$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category = $DB->get_record('course_categories', array("id" => $courseid));

$PAGE->set_context(context_system::instance());
//$PAGE->set_pagelayout('standard');
$PAGE->set_pagelayout('course');

$PAGE->set_title("Biblioteca ICEB");
$PAGE->set_heading("Biblioteca");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/busqueda.php');
//$PAGE->navbar->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
//$PAGE->navbar->add(get_string("config_name", "block_biblioteca"), new moodle_url('/biblioteca/configuracion.php'));
//$PAGE->navbar->add(get_string("config_update_name", "block_biblioteca"));
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id=' . $courseid));
//$thingnode1 = $thingnode->add('Aspectos Generales del Programa', new moodle_url('/course/view.php?id=' . $courseid . '&section=1'));
$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add('Configuración', new moodle_url('/biblioteca/configuracion.php'));
$thingnode3 = $thingnode2->add('Eliminar Recurso', new moodle_url('/biblioteca/config_eliminar.php'));
$thingnode3->make_active();

require_login();
//$cat = required_param('cat', PARAM_INT);
$idr = required_param('idr', PARAM_INT);

$sqlCat = 'SELECT * FROM mdl_biblioteca_categorias order by nombre';
$resultcat = $DB->get_records_sql($sqlCat);

$sqlSubCat = 'SELECT su.id, ca.nombre, su.nombre as subnom 
FROM mdl_biblioteca_subcategoria as su, mdl_biblioteca_categorias as ca
where su.idCategoria=ca.id';
$resultSubcat = $DB->get_records_sql($sqlSubCat);

$result = $DB->get_record('biblioteca_recursos', array('id' => $idr));

echo $OUTPUT->header();
?>
<div class="section-navigation navigationtitle">
    <span class="mdl-left"></span>
    <span class="mdl-left"><a href="/course/view.php?id=<?php echo $courseid; ?>&section=1"><span
                    class="larrow">◀︎</span>Regresar al Curso</a></span>
    <h3 class="sectionname"
        style="color: rgb(255, 255, 255); margin-left: 0px; width: 99%; background: rgb(230, 54, 61);     padding-left: 9px;">
        <span>Biblioteca</span></h3>
</div>
<div class="contenedor">
    <p><?php
        
            echo $OUTPUT->box('Detalles del recurso a eliminar');
        
        ?></p>
    <form action="eliminar.php" method="post" enctype="multipart/form-data" name="form" id="form">
        <table width="90%" border="0" align="center" cellspacing="1">
            <tr>
                <td width="15%" height="30">Titulo</td>
                <td width="85%"><label for="nombre"></label>
                    <input name="nombre" type="text" id="nombre" value="<?php echo $result->titulo ?>" size="70"/></td>
            </tr>
            <tr>
                <td height="30">Autor</td>
                <td><input name="autor" type="text" id="autor2" value="<?php echo $result->autor ?>" size="70"/></td>
            </tr>
            <tr>
                <td height="30">Tipo</td>
                <td><select name="clase" id="clase">
                        <?php
                        foreach ($resultcat as $row) {
                            if ($result->idCategoria == $row->id) {
                                $sec = "selected";
                            } else {
                                $sec = "";
                            }
                            ?>
                            <option value="<?php echo $row->id ?>" <?php echo $sec; ?>><?php echo $row->nombre ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td height="30">Asignatura</td>
                <td>
                    <select name="materia" id="materia">
                        <?php for ($i = 3; $i <= 16; $i++) { ?>
                            <option value="<?php echo get_section_name($course, $i) ?>" <?php echo $result->materia== get_section_name($course, $i)?"selected":"" ?>><?php echo get_section_name($course, $i) ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td height="30" colspan="2" align="right"><input type="button" name="borrar3" id="borrar3"
                                                                 value="Regresar"
                                                                 onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/configuracion.php' ?>')"/>
                    <input type="submit" name="borrar" id="borrar" value="Eliminar"/>
                    <input name="id" type="hidden" id="id" value="<?php echo $idr; ?>"/>
                    <input name="tipo" type="hidden" id="tipo" value="delete"/></td>
            </tr>
        </table>
    </form>
</div>
<?php
echo $OUTPUT->footer();
?>
