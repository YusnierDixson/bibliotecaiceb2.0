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
//$thingnode1 = $thingnode->add('Aspectos Generales del Programa', new moodle_url('/course/view.php?id='.$courseid.'&section=1'));
$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add('Bases de Datos', new moodle_url('/biblioteca/bases_datos.php'));
$thingnode2->make_active();


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
/*
$admins = get_admins();
$isadmin = false;
foreach($admins as $admin) {
    if ($USER->id == $admin->id) {
        $isadmin = true;
        break;
    }
}*/
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
    <p>Bases de Datos</p>
    <p>A continuación encontrarás enlaces a bases de datos especializadas que te serán útiles para profundizar y ampliar conocimientos relacionados con tu programa de estudios. </p>
    <hr style="border-bottom: 2px solid rgba(0,0,0,0.6); margin-left: -10px;
    margin-right: -10px;"/>
    <div style="text-align:center">
    <ul class="seccion">
<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://www.scielo.org/php/index.php?lang=es" target="_blank"><img src="/media/basedatos/SCIELO.png" style="float: left;"></a><br>
<a href="http://www.scielo.org/php/index.php?lang=es" target="_blank">SciELO;</a></h3>
<p dir="ltr" style="text-align: justify;">SciELO (Scientific Electronic Library Online o Biblioteca Científica Electrónica en
Línea) es un proyecto de biblioteca electrónica con acceso gratuito al texto completo de artículos de revistas de múltiples temas.<a href="http://www.scielo.org/php/index.php?lang=es" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="https://dialnet.unirioja.es/" target="_blank"><img src="/media/basedatos/Dialnet.png" style="float: left;"></a><br>
<a href="https://dialnet.unirioja.es/" target="_blank">Dialnet</a></h3>
<p dir="ltr" style="text-align: justify;"> Es una base de datos de acceso libre. Constituye una hemeroteca virtual que contiene
los índices de las revistas científicas y humanísticas de España, Portugal y Latinoamérica, incluyendo también libros, monografías, tesis doctorales y otros tipos de documentos.<a href="https://dialnet.unirioja.es/" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="https://www.ncbi.nlm.nih.gov/pubmed/" target="_blank"><img src="/media/basedatos/pubmed.png" style="float: left;"></a><br>
<a href="https://www.ncbi.nlm.nih.gov/pubmed/" target="_blank">PubMed</a></h3>
<p dir="ltr" style="text-align: justify;"> Es un motor de búsqueda de libre acceso a la base de datos MEDLINE de citaciones y
resúmenes de artículos de investigación biomédica. En casos excepcionales se puede obtener el texto completo sin pago previo. Ofrecido por la Biblioteca Nacional de Medicina de los Estados Unidos.<a href="https://www.ncbi.nlm.nih.gov/pubmed/" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://www.apa.org/pubs/databases/psycinfo/index.aspx" target="_blank"><img src="/media/basedatos/psycinfo.jpg" style="float: left;"></a><br>
<a href="http://www.apa.org/pubs/databases/psycinfo/index.aspx" target="_blank">PsycINFO</a></h3>
<p dir="ltr" style="text-align: justify;"> Base de datos bibliográfica de la American Psychological Association (APA) que
contiene citas y resúmenes de artículos de revistas, libros, tesis doctorales e informes.<a href="http://www.apa.org/pubs/databases/psycinfo/index.aspx" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://www.psicodoc.org/acerca.htm" target="_blank"><img src="/media/basedatos/psicodoc.jpg" style="float: left;"></a><br>
<a href="http://www.psicodoc.org/acerca.htm" target="_blank">Psicodoc</a></h3>
<p dir="ltr" style="text-align: justify;"> Es una base de datos internacional con interfaz multilingüe (español, inglés y
portugués) que facilita la búsqueda bibliográfica y el acceso al texto completo de las publicaciones científicas sobre psicología y otras disciplinas afines.<a href="http://www.psicodoc.org/acerca.htm" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://www.freemedicaljournals.com/" target="_blank"><img src="/media/basedatos/freemedical.jpg" style="float: left;"></a><br>
<a href="http://www.freemedicaljournals.com/" target="_blank">Free Medical Journals</a></h3>
<p dir="ltr" style="text-align: justify;"> Free Medical Journals se dedica a la promoción del acceso libre al texto completo de
revistas médicas publicadas en línea. Unas revistas liberan todos sus artículos recién publicados y otras los liberan pasado cierto período después de su publicación..<a href="http://www.freemedicaljournals.com/" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://www.pubpsych.es/" target="_blank"><img src="/media/basedatos/pubpsych.png" style="float: left;"></a><br>
<a href="http://www.pubpsych.es/" target="_blank">PubPsych</a></h3>
<p dir="ltr" style="text-align: justify;"> Buscador gratuito de recursos de información sobre psicología. Incluye más de 860.000 artículos a texto completo de las bases de datos que indexa: Psyndex, Pascal, Medline, etc.<a href="http://www.pubpsych.es/" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="https://scholar.google.es/" target="_blank"><img src="/media/basedatos/google_scholar.png" style="float: left;"></a><br>
<a href="https://scholar.google.es/" target="_blank">Google Académico</a></h3>
<p dir="ltr" style="text-align: justify;"> Es un buscador de Google enfocado en académico que se especializa en literatura científico-académica.<a href="https://scholar.google.es/" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://aplicacionesbiblioteca.udea.edu.co:2048/login?url=http://www.blackwellreference.com/public/" target="_blank"><img src="http://portal.udea.edu.co/wps/wcm/connect/udea/e759b8b7-6940-4f3e-be3a-2047f489500c/3/blackwell_reference_online_124.png?MOD=AJPERES&amp;CACHEID=e759b8b7-6940-4f3e-be3a-2047f489500c/3" style="float: left;"></a><br>
<a href="http://aplicacionesbiblioteca.udea.edu.co:2048/login?url=http://www.blackwellreference.com/public/" target="_blank">Blackwell&nbsp;Reference&nbsp;Online</a></h3>

<p dir="ltr" style="text-align: justify;">Esta base de datos ofrece información de más de 300 obras de referencia de consulta especializadas en ciencias sociales y humanidades. Y comprende áreas como: economía y negocios, historia, lenguaje y lingüística, literatura y estudios culturales, filosofía y religión, sociología y psicología. <a href="http://aplicacionesbiblioteca.udea.edu.co:2048/login?url=http://www.blackwellreference.com/public/" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

<h3 dir="ltr" style="text-align: justify;"><br>
<a href="http://aplicacionesbiblioteca.udea.edu.co:2048/login?url=http://journals.cambridge.org/action/login" target="_blank"><img src="http://portal.udea.edu.co/wps/wcm/connect/udea/e759b8b7-6940-4f3e-be3a-2047f489500c/4/cambridge.png?MOD=AJPERES&amp;CACHEID=e759b8b7-6940-4f3e-be3a-2047f489500c/4" style="float: left;"></a><br>
<a href="http://aplicacionesbiblioteca.udea.edu.co:2048/login?url=http://journals.cambridge.org/action/login" target="_blank">Cambridge&nbsp;Journals&nbsp;Online</a></h3>

<p dir="ltr" style="text-align: justify;">Esta Base de Datos Bibliográfica es editada por la Universidad de Cambridge y ofrece acceso a más de 200 títulos de revistas en áreas de Humanidades, Ciencias naturales y exactas y Ciencias sociales y humanas.<a href="http://aplicacionesbiblioteca.udea.edu.co:2048/login?url=http://journals.cambridge.org/action/login" target="_blank">[Ir a la Base de Datos Bibliográfica]</a>&nbsp;

</div>
<?php
echo $OUTPUT->footer();
?>
