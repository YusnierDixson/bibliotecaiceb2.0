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


  $thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));

$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add($resultcat->nombre, new moodle_url('/biblioteca/busqueda.php'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
$thingnode3->make_active();
/*
//Navegación en las lecturas Master Psicologia
if($courseid==12)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($result->materia=="Actualización en psicología clínica y de la salud: el proceso salud-enfermedad.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Salud mental: clínica y psicofarmacología.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Estilo de vida y conductas de riesgo en salud.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Psico neuro inmunoendocrinología.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Emprendimiento en entornos sociosanitarios.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Métodos y técnicas de investigación (MPsCES).")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Psicogeriatría: generalidades médico-clínicas, psicosociales y epidemiológicas.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Psicopatología y Neuropsicología del envejecimiento.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Evaluación y diagnóstico psicológico del paciente geriátrico")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Intervención psicológica del paciente geriátrico")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Aspectos éticos, actitudes y competencias profesionales del servicio.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Intervención familiar.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
//$thingnode3 = $thingnode2->add($result->materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$result->materia));
$thingnode3->make_active();
}
else {
  // code...
  $thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
  //$thingnode1 = $thingnode->add('Aspectos Generales del Programa', new moodle_url('/course/view.php?id='.$courseid.'&section=1'));
  $thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
  $thingnode2 = $thingnode1->add($resultcat->nombre, new moodle_url('/biblioteca/busqueda.php'));
  $thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
  $thingnode3->make_active();
}

//Lecturas Master Gestión TI-Especialización en Redes de Telecomunicaciones
if($courseid==14)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));
if($result->materia=="Innovación, estructura y mercado actual de las TI.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Dirección integrada de proyectos.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Gestión de la información y el conocimiento.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Emprendimiento y TI.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Dirección estratégica de SI/TI.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Gestión de servicios de las TI.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Métodos y técnicas de investigación (MGTIE).")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Trabajo de investigación de máster (TIM).")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Redes de telecomunicaciones.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Internet de las cosas (IoT).")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Seguridad de redes y comunicaciones.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Gestión y monitorización de redes.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Redes inalámbricas.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
//$thingnode3 = $thingnode2->add($result->materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$result->materia));
$thingnode3->make_active();
}
else
{
  $thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));

$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add($resultcat->nombre, new moodle_url('/biblioteca/busqueda.php'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
$thingnode3->make_active();

}

//Lecturas Master en Innovación y Emprendimiento
if($courseid==17)
{
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));

if($result->materia=="Iniciativa Emprendedora.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=3'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Dirección Estratégica.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=4'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Desarrollo del Liderazgo.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=5'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Marketing Estratégico.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=6'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Análisis Financiero.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=7'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Dirección Avanzada de Operaciones.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=8'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Métodos y técnicas de investigación (MIEE).")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=9'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Trabajo de investigación de máster (TIM).")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=10'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Gestión de la Innovación.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=11'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Marketing Digital.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=12'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Innovación Abierta.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=14'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Nuevos Modelos de Negocio.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Desing Thinking.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=15'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="Lean Startup.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=16'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
elseif($result->materia=="RSC y Ética en los Negocios.")
{
$thingnode1 = $thingnode->add($result->materia, new moodle_url('/course/view.php?id='.$courseid.'&section=17'));
$thingnode2 = $thingnode1->add('Lecturas', new moodle_url('/course/view.php?id='.$courseid.'&section=17'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
}
//$thingnode3 = $thingnode2->add($result->materia, new moodle_url('/biblioteca/busqueda_materia.php?materia='.$result->materia));
$thingnode3->make_active();
}
else
{
  $thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));

$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add($resultcat->nombre, new moodle_url('/biblioteca/busqueda.php'));
$thingnode3 = $thingnode2->add('Detalle', new moodle_url('/biblioteca/busqueda_detalle.php'));
$thingnode3->make_active();

}*/


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
