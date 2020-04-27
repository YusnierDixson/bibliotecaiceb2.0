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

$PAGE->set_title("Lecturas");
$PAGE->set_heading("Lecturas");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/busqueda.php');
//$PAGE->navbar->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));


require_login();

$nombre = optional_param('nombre', '', PARAM_TEXT);
$autor = optional_param('autor', '', PARAM_TEXT);
$cat = optional_param('cat',1, PARAM_INT);
$materia = optional_param('materia', '', PARAM_TEXT);
$filt = optional_param('fil','',PARAM_ALPHANUM);
$catr = $DB->get_record('biblioteca_categorias', array('id'=>$cat));
$idN = 0;
$offset = 5;
$page = optional_param('page', 0, PARAM_INT);
$ordenar = optional_param('buscarselect', 'tipolectura', PARAM_TEXT);
$sectionid   = optional_param('sectionid', 0, PARAM_INT);
$section     = optional_param('section', 0, PARAM_INT);
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

$sqlCount = 'SELECT count(*) as  cantidad
        FROM mdl_biblioteca_recursos as r
        WHERE r.materia like "' . $materia . '%"
        order by r.id';

$count = $DB->count_records_sql($sqlCount);

$start = $page * $offset; //calculo numero actual ej pg 3 inicia en :  2 * 5 = 10

$maxpage = ceil($count / $offset); //numero de paginas

if ($start > $count) {
    $page = 0;
    $start = 0;
}

//$sql = 'SELECT * FROM mdl_biblioteca_recursos'
//        . ' WHERE materia like "' . $materia . '%"
//		order by '.$ordenar.' limit ' . $start . ', ' . $offset;

$sql = 'SELECT r.id, c.nombre as categoria,c.id as id1, r.titulo, r.materia, r.tipolectura
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c
        WHERE r.idCategoria = c.id and r.materia like "' . $materia . '%" and r.tipolectura="obligatoria"';
/*$sql = 'SELECT * FROM mdl_biblioteca_recursos'
    . ' WHERE materia like "' . $materia . '%" and tipolectura="obligatoria"' ;*/
$result = $DB->get_records_sql($sql, array( $catr->id ));

$sql2 = 'SELECT r.id, c.nombre as categoria,c.id as id1, r.titulo, r.materia, r.tipolectura
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c
        WHERE r.idCategoria = c.id and r.materia like "' . $materia . '%" and r.tipolectura="recomendada"';

$result2 = $DB->get_records_sql($sql2, array( $catr->id ));


//$previewnode = $PAGE->navigation->add($category->name, new moodle_url('course/index.php?categoryid='.$course->category), navigation_node::TYPE_CONTAINER);
//course/view.php?id=2
//Navegación en las lecturas Master Psicologia
if($courseid==12)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Actualización en psicología clínica y de la salud: el proceso salud-enfermedad.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Salud mental: clínica y psicofarmacología.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Estilo de vida y conductas de riesgo en salud.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Psico neuro inmunoendocrinología.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Emprendimiento en entornos sociosanitarios.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Métodos y técnicas de investigación (MPsCES).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Psicogerontología y Psicogeriatría: generalidades médico-clínicas, psicosociales y epidemiológicos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
elseif($materia=="Psicopatología y Neuropsicología del envejecimiento.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
}
elseif($materia=="Evaluación y diagnóstico psicológico del paciente geriátrico")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
}
elseif($materia=="Intervención psicológica del paciente geriátrico")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
}
elseif($materia=="Aspectos éticos, actitudes y competencias profesionales del servicio.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
}
elseif($materia=="Intervención familiar.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}


//Navegación en las lecturas Especialización EP
if($courseid==18)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Actualización en psicología clínica y de la salud: el proceso salud-enfermedad.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Salud mental: clínica y psicofarmacología.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Psicogeriatría: generalidades médico-clínicas, psicosociales y epidemiológicas.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Psicopatología y Neuropsicología del envejecimiento.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Evaluación y diagnóstico psicológico del paciente geriátrico")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Intervención psicológica del paciente geriátrico")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Intervención familiar")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
elseif($materia=="Aspectos éticos, actitudes y competencias profesionales del servicio.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}

//Navegación en las lecturas Especialización EPSDD
if($courseid==19)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Actualización en psicología clínica y de la salud: el proceso salud-enfermedad.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Salud mental: clínica y psicofarmacología.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="La discapacidad y la dependencia: generalidades médico-clínicas, psicosociales y epidemiológicas")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Aspectos psicológicos de la discapacidad y la dependencia")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Evaluación y diagnóstico psicológico en pacientes con discapacidad o dependencia")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Intervención psicológica del paciente con discapacidad o dependencia")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Intervención familiar")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
elseif($materia=="Aspectos éticos, actitudes y competencias profesionales del servicio.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}

//Lecturas Master Gestión TI-Especialización en Redes de Telecomunicaciones
if($courseid==14)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Innovación, estructura y mercado actual de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Dirección integrada de proyectos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Gestión de la información y el conocimiento.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Emprendimiento y TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Dirección estratégica de SI/TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Gestión de servicios de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Métodos y técnicas de investigación (MGTIE).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
elseif($materia=="Trabajo de investigación de máster (TIM).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
elseif($materia=="Redes de telecomunicaciones.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
}
elseif($materia=="Internet de las cosas (IoT).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
}
elseif($materia=="Seguridad de redes y comunicaciones.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
}
elseif($materia=="Gestión y monitorización de redes.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
}
elseif($materia=="Redes inalámbricas.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}



//Lecturas Master en Gestión de las TI y Emprendimiento: Esp. Adm. Proyectos
if($courseid==21)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Innovación, estructura y mercado actual de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Dirección integrada de proyectos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Gestión de la información y el conocimiento.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Emprendimiento y TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Dirección estratégica de SI/TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Gestión de servicios de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Métodos y técnicas de investigación (MGTIE).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
elseif($materia=="Trabajo de investigación de máster (TIM).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
elseif($materia=="Gestión de la calidad.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
}
elseif($materia=="Gestión de alcance y tiempo.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
}
elseif($materia=="Gestión de costos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
}
elseif($materia=="Herramientas para la gestión de proyectos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
}
elseif($materia=="Gestión de Riesgos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}

//Lecturas Master en Gestión de las TI y Emprendimiento: Esp. Desarrollo de Software
if($courseid==24)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Innovación, estructura y mercado actual de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Dirección integrada de proyectos.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Gestión de la información y el conocimiento.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Emprendimiento y TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Dirección estratégica de SI/TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Gestión de servicios de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Métodos y técnicas de investigación (MGTIE).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
elseif($materia=="Trabajo de investigación de máster (TIM).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
elseif($materia=="Gestión de Proyectos de Desarrollo de Software")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
}
elseif($materia=="Desarrollo de Aplicaciones Distribuidas y de Tiempo Real")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
}
elseif($materia=="Modelos y Arquitectura de Software")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=13'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=13'));
}
elseif($materia=="Base de Datos")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
}
elseif($materia=="Paradigmas de Programación")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}

//Lecturas Especialización en Redes de Telecomunicaciones
if($courseid==22)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Innovación, estructura y mercado actual de las TI.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Redes de telecomunicaciones.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Administración avanzada en GNU/Linux.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Internet de las cosas (IoT).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Seguridad de redes y comunicaciones.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Gestión y monitorización de redes.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Redes inalámbricas.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}


//Lecturas Master en Innovación y Emprendimiento
if($courseid==17)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($materia=="Iniciativa Emprendedora.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
}
elseif($materia=="Dirección Estratégica.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
}
elseif($materia=="Desarrollo del Liderazgo.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
}
elseif($materia=="Marketing Estratégico.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
}
elseif($materia=="Análisis Financiero.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
}
elseif($materia=="Dirección Avanzada de Operaciones.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
}
elseif($materia=="Métodos y técnicas de investigación (MIEE).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
}
elseif($materia=="Trabajo de investigación de máster (TIM).")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
}
elseif($materia=="Gestión de la Innovación.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
}
elseif($materia=="Marketing Digital.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
}
elseif($materia=="Innovación Abierta.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
}
elseif($materia=="Nuevos Modelos de Negocio.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
}
elseif($materia=="Desing Thinking.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
}
elseif($materia=="Lean Startup.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
}
elseif($materia=="RSC y Ética en los Negocios.")
{
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=17'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=17'));
}
//$thingnode3 = $thingnode2->add($materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$materia));
$thingnode2->make_active();
}
/*else
{
    $thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
$thingnode1 = $thingnode->add($materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
   $thingnode2->make_active();
}*/

echo $OUTPUT->header();
?>
<div class="section-navigation navigationtitle">
	<span class="mdl-left"></span>

    <h3 class="sectionname" style="color: rgb(255, 255, 255); margin-left: 0px; width: 99%; background: rgb(230, 54, 61);     padding-left: 9px;"><span>Lecturas</span></h3>
    </div>
<div style="margin-left: 30px;" class="editor-indent"><div id="intro" class="box generalbox" style="text-align: justify;"><div class="no-overflow"><p>En este apartado encontrarás las lecturas obligatorias y recomendadas. Sirven para aclarar y profundizar en los contenidos relacionados directamente con la materia que estás cursando. Las lecturas obligatorias forman parte del proceso de evaluación. <br></p></div>
</div>
<!--    <form id="form1" name="form1" method="post" action="#">-->
<!--      <table width="90%" border="0" align="center" cellspacing="1">-->
<!--        <tr>-->
<!--          <td width="13%" height="30">Titulo</td>-->
<!--          <td width="87%"><label for="nombre"></label>-->
<!--            <input name="nombre" type="text" id="nombre" size="70" /></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--          <td height="30">Autor</td>-->
<!--          <td><input name="autor" type="text" id="autor" size="70" /></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--          <td height="30" colspan="2" align="right"><input type="submit" name="borrar" id="borrar" value="Buscar" />-->
<!--            <input type="reset" name="borrar2" id="borrar2" value="Limpiar" />-->
<!--            -->
<!--        </tr>-->
<!--      </table>-->
<!--    </form>-->
<!--    <form id="form1" name="form1" method="post" action="#">-->
<!--      <table width="90%" border="0" align="center" cellspacing="1">-->
<!--        <tr>-->
<!--          <td width="13%" height="30">Ordenar por</td>-->
<!--          <td width="65%"><label for="nombre">-->
<!--            <select name="buscarselect" id="buscarselect">-->
<!--              <option value="0">--><?php //echo get_string("config_select_atributo", "block_biblioteca") ?><!--</option>-->
<!--              --><?php //foreach ($resultdes as $row) { ?>
<!--              <option value="--><?php //echo $row->value ?><!--">--><?php //echo $row->descripcion ?><!--</option>-->
<!--              --><?php //} ?>
<!--            </select>-->
<!--          </label></td>-->
<!--          <td width="22%" align="left"><input type="submit" name="ordenar" id="ordenar" value="Ordenar" /></td>-->
<!--        </tr>-->
<!--      </table>-->
<!--    </form>-->
<p>
    </p>
    <table width="100%" border="1" align="center" cellspacing="0" style="border: 1px solid black;">
        <tr>
            <th width="50%" bgcolor="#dc143c"><span style="color: #fff">Obligatorias</span></th>
            <th width="50%" bgcolor="#dc143c"><span style="color: #fff">Recomendadas</span></th>

        </tr>
        <tr>
            <th width="50%">
                <table width="95%" border="0" align="center" cellspacing="1" >
                    <thead>
                    <tr>




                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($result as $row){ ?>
                        <tr>
                            <td><a href="busqueda_detalle.php?cat=<?php echo $row->id1?>&id=<?php echo $row->id?>" target="_black"><i class="fa fa-file-text" aria-hidden="true"></i> <?php echo $row->titulo?>
                                </a></td>



                        </tr>
                    <?php }?>
                    <td></td>
                    <td></td>
                    </tbody>
                </table>
            </th>
            <th width="50%">
                <table width="95%" border="0" align="center" cellspacing="1" >
                    <thead>
                    <tr>




                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($result2 as $row){ ?>
                        <tr>
                            <td><a href="busqueda_detalle.php?cat=<?php echo $row->id1?>&id=<?php echo $row->id?>" target="_black"><i class="fa fa-file-text" aria-hidden="true"></i>
                                <?php echo $row->titulo?></a></td>

                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </th>
        </tr>
    </table>

    <div id="pager" style="display: none">
        <?php
        for ($i = 0; $i < $maxpage; $i++) {
            if ($i == $page) {
                ?>
                <span  class="pagerSpan"><?php echo $i; ?></span>
            <?php } else { ?>
      <a href="?cat=<?php echo $cat?>&page=<?php echo $i; ?>" title="Page <?php echo $i; ?>" class=""><?php echo $i; ?></a>
                <?php
            }
        }
        if ($page >= 0 && $page + 1 < $maxpage) {//
            echo '<a href="?cat='.$cat.'&page=' . ($page + 1) . '" title="Next Page" class="rax-active-pal">' .
            '<span class="ui-icon ui-icon-triangle-1-e">>></span></a>';
        }
        if ($page + 1 == $maxpage) {
            echo '<a href="?cat='.$cat.'&page=' . ($page - 1) . '" title="Prvious Page" class="rax-active-pal">' .
            '<span class="ui-icon ui-icon-triangle-1-w"><<</span></a>';
        }
        ?>
    </div>
</div>
<?php
echo $OUTPUT->footer();
?>
