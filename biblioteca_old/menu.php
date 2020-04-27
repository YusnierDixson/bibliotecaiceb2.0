<?php
require_once(dirname(__FILE__) . '../../config.php');

$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category =$DB->get_record('course_categories', array("id" => $courseid ));
$PAGE->set_context(context_system::instance());

$PAGE->set_title("Biblioteca");
$PAGE->set_heading("Biblioteca");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/menu.php');
//$PAGE->navbar->add('Biblioteca');


//$previewnode = $PAGE->navigation->add($category->name, new moodle_url('course/index.php?categoryid='.$course->category), navigation_node::TYPE_CONTAINER);
//course/view.php?id=2
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));

$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode1->make_active();

//$PAGE->set_pagelayout('standard');
//$courseid = $_SESSION['idCurso'];
//if (isset($courseid))
//    header('/index.php');




//echo "<pre>";
//print_r($category);
//echo "</pre>";
$PAGE->set_pagelayout('course');
//require_course_login($course, true);
require_login();

$admins = get_admins();
$isadmin = false;
foreach($admins as $admin) {
    if ($USER->id == $admin->id) {
        $isadmin = true;
        break;
    }
}
$role = $DB->get_record('role', array('shortname' => 'editingteacher'));
$context = get_context_instance(CONTEXT_COURSE, $courseid);
$teachers = get_role_users($role->id, $context);
$isteacher=false;
foreach($teachers as $teacher) {
    if ($USER->id == $teacher->id) {
        $isteacher = true;
        break;
    }
}
/*
$context = get_context_instance (CONTEXT_SYSTEM);
$roles = get_user_roles($context, $USER->id, false);
$role = key($roles);
$roleid = $roles[$role]->roleid;
*/


echo $OUTPUT->header();
?>
	<div class="section-navigation navigationtitle">
	<span class="mdl-left"></span>
<span class="mdl-left"><a href="/course/view.php?id=<?php echo $courseid;?>&section=1"><span class="larrow">◀︎</span>Regresar al Curso</a></span>
    <h3 class="sectionname" style="color: rgb(255, 255, 255); margin-left: 0px; width: 99%; background: rgb(230, 54, 61);     padding-left: 9px;"><span>Biblioteca</span></h3>
    </div>
<div class="contenedor">
    <p>Menú</p>
    <p>A continuación encontrarás los diferentes recursos bibliográficos especializados de los que dispones para profundizar y ampliar conocimientos relacionados con tu programa de estudios. </p>
    <p><a href="https://drive.google.com/file/d/1QTW1iu1bBgHAdQKdnVi5unCO0fr_u6YE/view?usp=sharing" target="_blank">Ver Manual Biblioteca</a></p>
    <hr style="border-bottom: 2px solid rgba(0,0,0,0.6); margin-left: -10px;
    margin-right: -10px;"/>
    <div style="text-align:center">
    <ul class="seccion">
    <?php 
	//var_dump($isadmin);
	if($isadmin||$isteacher){?>
        <li id="soportet1" class="activity"> <a href="<?php echo new moodle_url('/biblioteca/configuracion.php'); ?>">
            <div class="tooltip"> <img role="presentation" alt=" " class=" activityicon panalicon" src="/media/icon_bib_conf.png"> <span class="tooltipnor">Configuración</span> <span class="tooltiptext">En este módulo podrá modificar, crear o deshabilitar recursos.</span>
                </div></a></li><?php }?>
                <li id="soportea1" class="activity"><a href="<?php echo new moodle_url('/message/index.php?id=43'); ?>">
                <div class="tooltip">
                    <img role="presentation" alt=" " id="soporte" class=" activityicon panalicon" src="/media/icon_soportebiblio.png"><span class="tooltipnor">Soporte Biblioteca</span>
                    <span class="tooltiptext">Aquí encontrará un contacto directo con el personal de soporte de la biblioteca</span>
                </div>
            </a></li>
        <li id="soportea1" class="activity"><a href="<?php echo new moodle_url('/biblioteca/busqueda.php?cat=1'); ?>">
                <div class="tooltip">
                    <img role="presentation" id="libro" alt=" " class=" activityicon panalicon" src="/media/icon_bib_libros.png"><span class="tooltipnor">Libros</span>
                    <span class="tooltiptext">Consulta libros de interés</span>
                </div>
            </a></li>
        <li id="soportec1" class="activity tooltip"><a href="<?php echo new moodle_url('/biblioteca/busqueda.php?cat=2'); ?>" >
                <div class="tooltip">
                    <img role="presentation" alt=" " id="articulo" class=" activityicon panalicon" src="/media/icon_bib_revistas.png"> <span class="tooltipnor">Artículos - Revistas</span>
                    <span class="tooltiptext">Consulta artículos o revistas de interés</span>  
                </div>
            </a></li>
        <li id="perfil1" class="activity">
            <a href="<?php echo new moodle_url('/biblioteca/busqueda.php?cat=3'); ?>">
			<div class="tooltip">
			<img role="presentation" alt=" " id="tesis" class=" activityicon panalicon" src="/media/icon_bib_tesis.png"> <span class="tooltipnor">Tesis</span>
			<span class="tooltiptext">Consulta tesis y trabajos de investigación de Máster</span>
			</div> 
			</a></li>
            </ul><br/>
            <ul class="seccion">
        <li id="calificaciones1" class="activity"><a href="<?php echo new moodle_url('/biblioteca/busqueda.php?cat=4'); ?>">
		<div class="tooltip">
		<img role="presentation" alt=" " id="libro" class=" activityicon panalicon" src="/media/icon_videos.png"> <span class="tooltipnor">Videos</span>
		<span class="tooltiptext">Consulta videos de interés</span>
		</div> 
		</a></li>
        <li id="soportec1" class="activity tooltip"><a href="<?php echo new moodle_url('/biblioteca/busqueda.php?cat=5'); ?>" >
                <div class="tooltip">
                    <img role="presentation" alt=" " id="libro" class=" activityicon panalicon" src="/media/icon_bib_audio.png"> <span class="tooltipnor">Audios</span>
                    <span class="tooltiptext">Consulta audios de interés</span>  
                </div>
            </a></li>
        <li id="soportec1" class="activity tooltip"><a href="<?php echo new moodle_url('/biblioteca/bases_datos.php'); ?>" >
                <div class="tooltip">
                    <img role="presentation" alt=" " id="base" class=" activityicon panalicon" src="/media/icon_bd.png"> <span class="tooltipnor">Bases de Datos</span>
                    <span class="tooltiptext">Consulta bases de datos de interés</span>  
                </div>
            </a></li>     
    </ul>
    </div>
    <p>&nbsp;</p>
</div>
<?php
echo $OUTPUT->footer();
?>
