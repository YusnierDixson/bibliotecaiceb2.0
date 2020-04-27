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

$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add('Configuración', new moodle_url('/biblioteca/configuracion.php'));
$thingnode3 = $thingnode2->add('Eliminar Recurso', new moodle_url('/biblioteca/config_eliminar.php'));
$thingnode3->make_active();

require_login();
//$cat = required_param('cat', PARAM_INT);

        $id = required_param('id', PARAM_INT);
        $select="id=".$id;
        $idD =$DB->delete_records_select("biblioteca_recursos", $select);

      

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
        
            echo $OUTPUT->box('El resurso se eliminó de la base de datos');
        
        ?></p>
    <form action="" method="post" enctype="multipart/form-data" name="form" id="form">
        <table width="90%" border="0" align="center" cellspacing="1">
            
            <tr>
                <td height="30" colspan="2" align="right"><input type="button" name="borrar3" id="borrar3"
                                                                 value="Regresar"
                                                                 onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/configuracion.php' ?>')"/>
                   
            </tr>
        </table>
    </form>
</div>
<?php
echo $OUTPUT->footer();
?>
