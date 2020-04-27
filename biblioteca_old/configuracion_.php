<?php
require_once(dirname(__FILE__) . '../../config.php');

global $DB;
// We don't actually modify the session here as we have NO_MOODLE_COOKIES set.

$PAGE->set_context(context_system::instance());
//$PAGE->set_pagelayout('standard');
/*$courseid = !isset($_SESSION['idCurso']) ? 0 : $_SESSION['idCurso'];

if (is_null($courseid)) {
    //die('Location: '.$CFG->wwwroot );
    //header('Location: '.$CFG->wwwroot."/my/" );
    $url = new moodle_url('/my/');
    redirect($url);
}
//die("cccc");

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$PAGE->set_pagelayout('incourse');
require_course_login($course, true);*/


$PAGE->set_title("Biblioteca ICEB");
$PAGE->set_heading("Biblioteca 2");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/busqueda.php');
//$PAGE->navbar->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$previewnode = $PAGE->navigation->add('Biblioteca', new moodle_url('/biblioteca/menu.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add('Menu', new moodle_url('/biblioteca/menu.php'));
$thingnode1 = $thingnode ->add('Configutación', new moodle_url('/biblioteca/configuracion.php'));
$thingnode1->make_active();
$PAGE->set_pagelayout('course');
require_login();
$courseid = $_SESSION['idCurso'];
//$cat = required_param('cat', PARAM_INT);
$nombre = optional_param('nombre', '', PARAM_TEXT);
$autor = optional_param('autor', '', PARAM_TEXT);
$cat = optional_param('clase', '', PARAM_TEXT);
$tipo = optional_param('tipo', '', PARAM_TEXT);
$ordenar = optional_param('buscarselect', 'id', PARAM_TEXT);
$idN = 0;
$offset = 15;

$page = optional_param('page', 0, PARAM_INT);
//$perpage = optional_param('perpage', 30, PARAM_INT);


switch ($tipo) {
    case "new":
        $clase = required_param('clase', PARAM_INT);
        $nombre = required_param('nombre', PARAM_TEXT);
        $autor = optional_param('autor', '', PARAM_TEXT);
        $editorial = optional_param('editorial', '', PARAM_TEXT);
        $fecha = optional_param('fecha', '', PARAM_TEXT);
		$dir_subida = $_SERVER['DOCUMENT_ROOT'].'/media/biblioteca/' . $clase . "/";
        $dataobject = array(
            "idCategoria" => $clase,
			"idSubCategoria" => optional_param('subclase', 0, PARAM_INT),
            "titulo" => $nombre,
            "autor" => $autor,
			"materia" => $autor,
			"ano" => $fecha,
			"resumen" => optional_param('resumen', '', PARAM_TEXT),
			"palabraclave" => optional_param('palabraclave', '', PARAM_TEXT),
			"recurso" => optional_param('recursos', '', PARAM_TEXT),
			"numeropagina" => optional_param('numeropagina', '', PARAM_TEXT),
			"lugarpublicacion" => optional_param('lugarpublicacion', '', PARAM_TEXT),
            "editorial" => $editorial,
            "url" => optional_param('url', '', PARAM_TEXT),
            "isbn" => optional_param('isbn', '', PARAM_TEXT),
			"idioma" => optional_param('idioma', '', PARAM_TEXT),
			"areaconocimiento" => optional_param('areaconocimiento', '', PARAM_TEXT),
            "path" => '/media/biblioteca/' . $clase . "/" . $_FILES['archivo']['name']
        );
        //
        $tamano = $_FILES['archivo']['size'];
        $tipo = $_FILES['archivo']['type'];
        $archivo = $_FILES['archivo']['name'];
        $prefijo = substr(md5(uniqid(rand())), 0, 6);

        if ($archivo != "") {
            // guardamos el archivo a la carpeta files
            $destino = $dir_subida . $_FILES['archivo']['name'];
            if (copy($_FILES['archivo']['tmp_name'], $destino)) {
                $status = "Archivo subido: " . $archivo . "";
            } else {
                $status = "Error al subir el archivo";
            }
        }
		$idN = $DB->insert_record("biblioteca_recursos", $dataobject, $returnid = true, $bulk = false);
        break;
    case "update":
        $id = required_param('id', PARAM_INT);
        $clase = required_param('clase', PARAM_INT);
        $nombre = required_param('nombre', PARAM_TEXT);
        $autor = optional_param('autor', '', PARAM_TEXT);
        $editorial = optional_param('editorial', '', PARAM_TEXT);
        $fecha = optional_param('fecha', '', PARAM_TEXT);
        $dataobject = array(
			"id" => $id,
            "idCategoria" => $clase,
			"idSubCategoria" => optional_param('subclase', 0, PARAM_INT),
            "titulo" => $nombre,
            "autor" => $autor,
			"materia" => $autor,
			"ano" => $fecha,
			"resumen" => optional_param('resumen', '', PARAM_TEXT),
			"palabraclave" => optional_param('palabraclave', '', PARAM_TEXT),
			"recurso" => optional_param('recursos', '', PARAM_TEXT),
			"numeropagina" => optional_param('numeropagina', '', PARAM_TEXT),
			"lugarpublicacion" => optional_param('lugarpublicacion', '', PARAM_TEXT),
            "editorial" => $editorial,
            "url" => optional_param('url', '', PARAM_TEXT),
            "isbn" => optional_param('isbn', '', PARAM_TEXT),
			"idioma" => optional_param('idioma', '', PARAM_TEXT),
			"areaconocimiento" => optional_param('areaconocimiento', '', PARAM_TEXT),
            "path" => "/",
			"estado" => optional_param('estado', '', PARAM_TEXT)
        );
        $idN = $DB->update_record("biblioteca_recursos", $dataobject, $bulk = false);

        break;
    default :
        break;
}



$sqldes = 'SELECT * FROM mdl_biblioteca_categorias order by nombre';
$resultcat = $DB->get_records_sql($sqldes);

$sqlCat = 'SELECT * FROM mdl_biblioteca_atributos order by descripcion';
$resultdes = $DB->get_records_sql($sqlCat);

//$PAGE->navbar->add(get_string("config_name", "block_biblioteca"));
if ($cat > 0) {
    $cats = " and r.idCategoria=" . $cat;
} else {
    $cats = "";
}

$sqlCount = 'SELECT count(*) as  cantidad
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c 
        WHERE r.idCategoria = c.id and r.titulo like "' . $nombre . '%"
         and r.autor like "' . $autor . '%" ' . $cats . '       
        order by r.id';
$count = $DB->count_records_sql($sqlCount);

$start = $page * $offset; //calculo numero actual ej pg 3 inicia en :  2 * 5 = 10 
$maxpage = ceil($count / $offset); //numero de paginas

if ($start > $count) {
    $page = 0;
    $start = 0;
}

$sql = 'SELECT r.id, c.nombre as categoria, r.titulo, r.autor, r.url, r.estado 
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c 
        WHERE r.idCategoria = c.id and r.titulo like "' . $nombre . '%"
         and r.autor like "' . $autor . '%" ' . $cats . '       
        order by r.'.$ordenar.'
        limit ' . $start . ', ' . $offset;
//$results = $DB->get_records_sql('Some SQL query to get the results', array(parameters for query), $start, $perpage); 

$result = $DB->get_records_sql($sql); //, array( $catr->id )


echo $OUTPUT->header();
?>
<div class="section-navigation navigationtitle">
	<span class="mdl-left"></span>
<span class="mdl-left"><a href="/course/view.php?id=<?php echo $courseid;?>&section=1"><span class="larrow">◀︎</span>Regresar al Curso</a></span>
    <h3 class="sectionname" style="color: rgb(255, 255, 255); margin-left: 0px; width: 99%; background: rgb(230, 54, 61);     padding-left: 9px;"><span>Biblioteca</span></h3>
    </div>
<div class="contenedor">
    <p><?php echo get_string("config_intro", "block_biblioteca") ?></p>
    <p><?php
        if ($idN > 0) {
            echo $OUTPUT->box('El resurso se almaceno exitosamente iD:' . $idN);
        }
        ?></p>
    <hr style="border-bottom: 2px solid rgba(0,0,0,0.6); margin-left: -10px;
    margin-right: -10px;"/>    
    <br/>
    <form id="form1" name="form1" method="post" action="#">
        <table width="90%" border="0" align="center" cellspacing="1">
            <tr>
                <td width="13%" height="30">Titulo</td>
                <td width="87%"><label for="nombre"></label>
                    <input name="nombre" type="text" id="nombre" size="70" /></td>
            </tr>
            <tr>
                <td height="30">Autor</td>
                <td><input name="autor" type="text" id="autor" size="70" /></td>
            </tr>
            <tr>
                <td height="30">Clase</td>
                <td><select name="clase" id="clase">
                        <option value="0"><?php echo get_string("config_select", "block_biblioteca") ?></option>
                        <?php foreach ($resultcat as $row) { ?>      
                            <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td height="30" colspan="2" align="right"><input type="button" name="menu" id="menu" value="Menu" onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/menu.php' ?>')"/><input type="button" name="borrar3" id="borrar3" value="Nuevo" onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/config_nuevo.php' ?>')"/>
                    <input type="reset" name="borrar2" id="borrar2" value="Limpiar" />            
                    <input type="submit" name="borrar" id="borrar" value="Buscar" /></td>
            </tr>
        </table>
    </form>
    <form id="form1" name="form1" method="post" action="#">
        <table width="90%" border="0" align="center" cellspacing="1">
            <tr>
                <td width="13%" height="30">Ordenar por</td>
                <td width="65%"><label for="nombre">
                  <select name="buscarselect" id="buscarselect">
                    <option value="0"><?php echo get_string("config_select_atributo", "block_biblioteca") ?></option>
                    <?php foreach ($resultdes as $row) { ?>
                    <option value="<?php echo $row->value ?>"><?php echo $row->descripcion ?></option>
                    <?php } ?>
                  </select>
                </label></td>
                <td width="22%" align="right"><input type="submit" name="ordenar" id="ordenar" value="Ordenar" /></td>
            </tr>
        </table>
    </form>    
  <br/>
    <br/>
    <table width="90%" border="0" align="center" cellspacing="1">
        <tr>
            <td align="left">ID</td>
            <td align="left">Clase</td>
            <td align="left">Titulo</td>
            <td align="left">Autor</td>
            <td align="left">URL</td>
            <td align="left">Estado</td>
            <td align="left">Editar</td>
        </tr>
        <?php foreach ($result as $row) { ?>   
            <tr>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->categoria ?></td>
                <td><?php echo $row->titulo ?></td>
                <td><?php echo $row->autor ?></td>
                <td><?php echo $row->url ?></td>
                <td><?php echo $row->estado ?></td>
                <td><a href="<?php echo $CFG->wwwroot . '/biblioteca/config_update.php?idr=' . $row->id ?>">Editar</a></td>
            </tr>
        <?php } ?>
    </table>
    <div id="pager">
        <?php
        for ($i = 0; $i < $maxpage; $i++) {
            if ($i == $page) {
                ?>
                <span  class="pagerSpan"><?php echo $i; ?></span>
            <?php } else { ?>
                <a href="?page=<?php echo $i; ?>" title="Page <?php echo $i; ?>" class=""><?php echo $i; ?></a>
                <?php
            }
        }
        if ($page >= 0 && $page + 1 < $maxpage) {//
            echo '<a href="?page=' . ($page + 1) . '" title="Next Page" class="rax-active-pal">' .
            '<span class="ui-icon ui-icon-triangle-1-e">>></span></a>';
        }
        if ($page + 1 == $maxpage) {
            echo '<a href="?page=' . ($page - 1) . '" title="Prvious Page" class="rax-active-pal">' .
            '<span class="ui-icon ui-icon-triangle-1-w"><<</span></a>';
        }
        ?>
    </div>
</div>    
<?php
echo $OUTPUT->footer();
?>
