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
//$PAGE->navbar->add(get_string("config_nuevo_name", "block_biblioteca"));
require_login();

$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id=' . $courseid));
//$thingnode1 = $thingnode->add('Aspectos Generales del Programa', new moodle_url('/course/view.php?id=' . $courseid . '&section=1'));
$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1->add('Configuración', new moodle_url('/biblioteca/configuracion.php'));
$thingnode3 = $thingnode2->add('Nuevo', new moodle_url('/biblioteca/config_nuevo.php'));
$thingnode3->make_active();
//$cat = required_param('cat', PARAM_INT);
$filt = optional_param('fil', '', PARAM_ALPHANUM);
$sqlCat = 'SELECT * FROM mdl_biblioteca_categorias order by nombre';
$resultcat = $DB->get_records_sql($sqlCat);
$courseid = $_SESSION['idCurso'];

$sqlSubCat = 'SELECT su.id, ca.nombre, su.nombre as subnom 
FROM mdl_biblioteca_subcategoria as su, mdl_biblioteca_categorias as ca
where su.idCategoria=ca.id';
$resultSubcat = $DB->get_records_sql($sqlSubCat);


$sql = 'SELECT r.id, c.nombre as categoria, r.titulo, r.autor, r.materia, r.url, r.estado 
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c 
        WHERE r.idCategoria = c.id order by r.id';
$result = $DB->get_records_sql($sql); //, array( $catr->id )

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
    <p><?php echo get_string("config_nuevo_intro", "block_biblioteca") ?></p>
    <form action="configuracion.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <table width="90%" border="0" align="center" cellspacing="1">
            <tr>
                <td width="15%" height="30"><b>Título</b></td>
                <td width="85%"><label for="nombre"></label>
                    <input name="nombre" type="text" id="nombre" size="70" required="true"/></td>
            </tr>
            <tr>
                <td height="30"><b>Autor</b></td>
                <td><input name="autor" type="text" id="autor" size="70" required="true"/></td>
            </tr>
            <tr>
                <td height="30"><b>Tipo</b></td>
                <td><select name="clase" id="clase" onchange="deshabilitar()">
                        <option value="0">Seleccione</option>
                        <?php foreach ($resultcat as $row) { ?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                        <?php } ?>
                    </select></td>
            </tr>

            <tr>
                <td height="30"><b>Sub Tipo</b></td>
                <td><select name="subclase" id="subclase">
                    <option value="0">Seleccione</option>
                        <?php foreach ($resultSubcat as $row) { ?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->nombre . ' - ' . $row->subnom ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td height="30"><b>Asignatura</b></td>
                <td><select name="materia" id="materia">
                    <option value="0">Seleccione</option>
                        <?php for ($i = 3; $i <= 16; $i++) { ?>
                            <option value="<?php echo get_section_name($course, $i) ?>"><?php echo get_section_name($course, $i) ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td height="30"><b>Tipo de Lectura</b></td>
                <td><select name="tipolectura" id="tipolectura" size="1">
                        <option value="libre">Libre</option>
                        <option value="obligatoria">Obligatoria</option>
                        <option value="recomendada">Recomendada</option>
                    </select><br><br></td>
            </tr>
            <tr>
                <td height="30"><b>Año Publicación</b></td>
                <td><select name="ano" id="ano">
                    <option value="0">Seleccione</option>
                        <?php $year = date("Y"); for ($i = 1945; $i <= $year; $i++) { ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td height="30"><b>Resumen</b></td>
                <td><textarea name="resumen" id="resumen" rows="5" cols="67" required="true"/></textarea></td>
            </tr>
            <tr>
                <td height="30"><b>Área Conocimiento</b></td>
                <td><input name="areaconocimiento" type="text" id="areaconocimiento" size="70" required="true"/></td>
            </tr>
            <tr>
                <td height="30"><b>Palabras Claves</b></td>
                <td><input name="palabraclave" type="text" id="palabraclave" size="70" required="true"/></td>
            </tr>
            <tr>
                <td height="30"><b>Tema</b></td>
                <td><input name="recurso" type="text" id="recurso" size="70" required="true"/></td>
            </tr>
            <tr>
                <td height="30"><b>Revista</b></td>
                <td><input name="revista" type="text" id="revista" size="70"/></td>
            </tr>
            <tr>
                <td height="30"><b>Lugar de Publicación</b></td>
                <td><input name="lugarpublicacion" type="text" id="lugarpublicacion" size="70"/></td>
            </tr>
            <tr>
                <td height="30"><b>Editorial</b></td>
                <td><input name="editorial" type="text" id="editorial" size="70"/></td>
            </tr>
            <tr>
                <td height="30"><b>ISSN</b></td>
                <td><input name="issn" type="text" id="issn" size="70"/></td>
            </tr>
            <tr>
                <td height="30"><b>ISBN</b></td>
                <td><input name="isbn"  type="text" id="isbn" size="70"/></td>
            </tr>
            <tr>
                <td height="30"><b>Idioma</b></td>
                <td><select name="idioma" id="idioma">
                        <option value="Español">Español</option>
                        <option value="Inglés">Ingles</option>
                        <option value="Portugues">Portugues</option>
                        <option value="Catalan">Catalan</option>
                        <option value="Frances">Frances</option>
                        <?php foreach ($resultcat as $row) { ?>
                        <?php } ?>
                    </select></td>
            </tr>
                      
            <tr>
                <td height="30"><b>URL Archivo</b></td>
                <td><input name="url" type="text" id="url" size="70" required="true"/></td>

            </tr>

            <tr>
                <td height="30" colspan="2" align="right"><input name="tipo" type="hidden" id="tipo" value="new"/>
                    <input type="button" name="borrar3" id="borrar3" value="Regresar"
                           onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/configuracion.php' ?>')"/>
                    <input type="reset" name="borrar2" id="borrar2" value="Limpiar"/>
                    <input type="submit" name="borrar" id="borrar" value="Guardar"/></td>
            </tr>
        </table>
    </form>
</div>
<script>
function deshabilitar(){
    var inputurl = document.getElementById('url');
    var inputisb = document.getElementById('isbn');
    var inputedit = document.getElementById('editorial');
    var inputiplec = document.getElementById('tipolectura');
    var inputissn = document.getElementById('issn');
    var inputrevista = document.getElementById('revista');
    var inputsubclase = document.getElementById('subclase');
    var opcion=document.getElementById('clase').value;
    //alert(document.getElementById('clase').value);
   if(opcion==1)
    {
        inputissn.disabled=true;
        inputrevista.disabled=true;
        inputisb.disabled=false;
        inputedit.disabled=false;
        inputiplec.disabled=false;
                
    }
    else if(opcion==2)
    {
        inputisb.disabled=true;
        inputedit.disabled=false;
        //inputiplec.disabled=false;
        inputissn.disabled=false;
        inputrevista.disabled=false;
       
    }
    else if (opcion==3)
    {
        
        inputisb.disabled=true;
        inputedit.disabled=true;
        inputissn.disabled=true;
        //inputiplec.disabled=false;
        inputrevista.disabled=true;
        
    }
    else if (opcion==4||opcion==5)
    {
       // inputiplec.disabled=true;
        inputisb.disabled=true;
        inputedit.disabled=true;
        inputissn.disabled=true;
        inputrevista.disabled=true;
    }
    else if (opcion==6||opcion==7)
    {
        //inputiplec.disabled=true;
        inputisb.disabled=true;
        inputedit.disabled=true;
        inputissn.disabled=true;
        inputrevista.disabled=true;
        inputsubclase.disabled=true;
    }
    else
    {
        inputedit.disabled=false;
        inputiplec.disabled=false;
        inputisb.disabled=false;
        inputissn.disabled=false;
        inputsubclase.disabled=false;
        inputrevista.disabled=false;
    }
 
}
</script>
<?php
echo $OUTPUT->footer();
?>
