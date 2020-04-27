<?php
require_once(dirname(__FILE__) . '../../config.php');

global $DB;
// We don't actually modify the session here as we have NO_MOODLE_COOKIES set.
$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category =$DB->get_record('course_categories', array("id" => $courseid ));
$PAGE->set_context(context_system::instance());



$PAGE->set_title("Biblioteca ICEB");
$PAGE->set_heading("Biblioteca 2");
$PAGE->set_url($CFG->wwwroot . '/biblioteca/busqueda.php');
//$PAGE->navbar->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode = $PAGE->navigation->add($course->shortname, new moodle_url('/course/view.php?id='.$courseid));

$thingnode1 = $thingnode->add('Biblioteca', new moodle_url('/biblioteca/menu.php'));
$thingnode2 = $thingnode1 ->add('Configuración', new moodle_url('/biblioteca/configuracion.php'));
$thingnode2->make_active();
$PAGE->set_pagelayout('course');
require_login();
$courseid = $_SESSION['idCurso'];
//$cat = required_param('cat', PARAM_INT);
$nombre = optional_param('nombre', '', PARAM_TEXT);
$autor = optional_param('autor', '', PARAM_TEXT);
$materia = optional_param('materia', '', PARAM_TEXT);
$cat = optional_param('clase', '', PARAM_TEXT);
$tipo = optional_param('tipo', '', PARAM_TEXT);
$ordenar = optional_param('buscarselect', 'id', PARAM_TEXT);
$tipolectura = optional_param('tipolectura', '', PARAM_TEXT);
$idN = 0;
$offset = 15;

$page = optional_param('page', 0, PARAM_INT);



switch ($tipo) {
    case "new":
        $clase = required_param('clase', PARAM_INT);
        $nombre = required_param('nombre', PARAM_TEXT);
        $autor = optional_param('autor', '', PARAM_TEXT);
		$materia = optional_param('materia', '', PARAM_TEXT);
        $editorial = optional_param('editorial', '', PARAM_TEXT);
        $fecha = optional_param('ano', '', PARAM_TEXT);

        $dataobject = array(
            "idCategoria" => $clase,
			"idSubCategoria" => optional_param('subclase', 0, PARAM_INT),
            "titulo" => $nombre,
            "autor" => $autor,
			"materia" => $materia,
			"ano" => $fecha,
			"resumen" => optional_param('resumen', '', PARAM_TEXT),
			"palabraclave" => optional_param('palabraclave', '', PARAM_TEXT),
			"recurso" => optional_param('recurso', '', PARAM_TEXT),
			"numeropagina" => optional_param('issn', '', PARAM_TEXT),
            "revista" => optional_param('revista', '', PARAM_TEXT),
			"lugarpublicacion" => optional_param('lugarpublicacion', '', PARAM_TEXT),
            "editorial" => optional_param('editorial', '', PARAM_TEXT),
            "url" => optional_param('url', '', PARAM_TEXT),
            "isbn" => optional_param('isbn', '', PARAM_TEXT),
			"idioma" => optional_param('idioma', '', PARAM_TEXT),
			"areaconocimiento" => optional_param('areaconocimiento', '', PARAM_TEXT),
            "tipolectura" => optional_param('tipolectura', '', PARAM_TEXT)
        );

		$idN = $DB->insert_record("biblioteca_recursos", $dataobject, $returnid = true, $bulk = false);
        break;
    case "update":
        $id = required_param('id', PARAM_INT);
        $clase = required_param('clase', PARAM_INT);
        $nombre = required_param('nombre', PARAM_TEXT);
        $autor = optional_param('autor', '', PARAM_TEXT);
		$materia = optional_param('materia', '', PARAM_TEXT);
        $editorial = optional_param('editorial', '', PARAM_TEXT);
        $fecha = optional_param('ano', '', PARAM_TEXT);
        $materia = optional_param('materia', '', PARAM_TEXT);
        $dataobject = array(
			"id" => $id,
            "idCategoria" => $clase,
			"idSubCategoria" => optional_param('subclase', 0, PARAM_INT),
            "titulo" => $nombre,
            "autor" => $autor,
			"materia" => $materia,
			"ano" => $fecha,
			"resumen" => optional_param('resumen', '', PARAM_TEXT),
			"palabraclave" => optional_param('palabraclave', '', PARAM_TEXT),
			"recurso" => optional_param('recurso', '', PARAM_TEXT),
			"numeropagina" => optional_param('issn', '', PARAM_TEXT),
			"lugarpublicacion" => optional_param('lugarpublicacion', '', PARAM_TEXT),
            "editorial" => optional_param('editorial', '', PARAM_TEXT),
            "url" => optional_param('url', '', PARAM_TEXT),
            "isbn" => optional_param('isbn', '', PARAM_TEXT),
			"idioma" => optional_param('idioma', '', PARAM_TEXT),
			"areaconocimiento" => optional_param('areaconocimiento', '', PARAM_TEXT),
			"estado" => optional_param('estado', '', PARAM_TEXT),
            "tipolectura" => optional_param('tipolectura', '', PARAM_TEXT)
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


if ($cat > 0) {
    $cats = " and r.idCategoria=" . $cat;
} else {
    $cats = "";
}

$sqlCount = 'SELECT count(*) as  cantidad
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c
        WHERE r.idCategoria = c.id and r.titulo like "' . $nombre . '%"
         and r.autor like "' . $autor . '%" and r.tipolectura like "' . $tipolectura . '%"and r.materia like "' . $materia . '%"' . $cats . '
        order by r.id';
$count = $DB->count_records_sql($sqlCount);

$start = $page * $offset; //calculo numero actual ej pg 3 inicia en :  2 * 5 = 10
$maxpage = ceil($count / $offset); //numero de paginas

if ($start > $count) {
    $page = 0;
    $start = 0;
}

$sql = 'SELECT r.id, c.nombre as categoria, r.titulo, r.autor, r.materia, r.url, r.estado
        FROM mdl_biblioteca_recursos as r, mdl_biblioteca_categorias as c
        WHERE r.idCategoria = c.id and r.titulo like "' . $nombre . '%"
         and r.autor like "' . $autor . '%" and r.tipolectura like "' . $tipolectura . '%" and r.materia like "' . $materia . '%"' . $cats . '
        order by r.'.$ordenar.'
        limit ' . $start . ', ' . $offset;

$result = $DB->get_records_sql($sql); //, array( $catr->id )


echo $OUTPUT->header();
?>
<script type="text/javascript">
function confirmDel()
{
  var agree=confirm("¿Realmente desea eliminarlo? ");
  if (agree) return true ;
  return false;
}
</script>
<div class="section-navigation navigationtitle">
	<span class="mdl-left"></span>
<span class="mdl-left"><a href="/course/view.php?id=<?php echo $courseid;?>&section=1"><span class="larrow">◀︎</span>Regresar al Curso</a></span>
    <h3 class="sectionname" style="color: rgb(255, 255, 255); margin-left: 0px; width: 99%; background: rgb(230, 54, 61);     padding-left: 9px;"><span>Biblioteca</span></h3>
    </div>
<div class="contenedor">
    <p><?php echo get_string("config_intro", "block_biblioteca") ?></p>
    <p><?php
        if ($idN > 0 && $tipo=="new") {
            echo $OUTPUT->box('El resurso se almacenó exitosamente ID:' . $idN);
        }
        else
            if ($idN > 0 && $tipo=="update") {
            echo $OUTPUT->box('El resurso se modificó correctamente');
        }
        ?></p>
    <hr style="border-bottom: 2px solid rgba(0,0,0,0.6); margin-left: -10px;
    margin-right: -10px;"/>
    <br/>
    <form id="form1" name="form1" method="post" action="#">
        <table width="90%" border="0" align="center" cellspacing="1">
            <tr>
                <td width="13%" height="30"><b>Título</b></td>
                <td width="87%"><label for="nombre"></label>
                    <input name="nombre" type="text" id="nombre" size="70" /></td>
            </tr>
            <tr>
                <td height="30"><b>Autor</b></td>
                <td><input name="autor" type="text" id="autor" size="70" /></td>
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
                       <option value="0">Seleccione</option>
                        <option value="libre">Libre</option>
                        <option value="obligatoria">Obligatoria</option>
                        <option value="recomendada">Recomendada</option>
                    </select><br><br></td>
            </tr>
            <tr>
                <td height="30"><b>Tipo</b></td>
                <td><select name="clase" id="clase">
                        <option value="0"><?php echo get_string("config_select", "block_biblioteca") ?></option>
                        <?php foreach ($resultcat as $row) { ?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td height="30" colspan="2" align="right"><input type="button" name="borrar3" id="borrar3" value="Nuevo" onclick="javascript:window.location.assign('<?php echo $CFG->wwwroot . '/biblioteca/config_nuevo.php' ?>')"/>
                    <input type="reset" name="borrar2" id="borrar2" value="Limpiar" />
                    <input type="submit" name="borrar" id="borrar" value="Buscar" /></td>
            </tr>
        </table>
    </form>
    <form id="form1" name="form1" method="post" action="#">
        <table width="90%" border="0" align="center" cellspacing="1">
            <tr>
                <td width="13%" height="30"><b>Ordenar por</b></td>
                <td width="65%"><label for="nombre">
                  <select name="buscarselect" id="buscarselect">
              <option value="0"><?php echo get_string("config_select_atributo", "block_biblioteca") ?></option>
              <option value="autor">Autor</option>
  <option value="titulo">Título</option>
  <option value="materia">Asignatura</option>
  <option value="ano">Año</option>

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

            <th align="left">Tipo</th>
            <th align="left">Titulo</th>
            <th align="left">Autor</th>
			<th align="left">Asignatura</th>

            <th align="left">Editar</th>
        </tr>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo $row->categoria ?></td>
                <td><?php echo $row->titulo ?></td>
                <td><?php echo $row->autor ?></td>
				<td><?php echo $row->materia ?></td>


                <td><a href="<?php echo $CFG->wwwroot . '/biblioteca/config_update.php?idr=' . $row->id ?>">Editar</a></td>
                <td><a onclick="return confirmDel();" href="<?php echo $CFG->wwwroot . '/biblioteca/config_eliminar.php?idr=' . $row->id ?>">Eliminar</a></td>
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
                <a href="?page=<?php echo $i; ?>&nombre=<?php echo $nombre;?>&autor=<?php echo $autor;?>&materia=<?php echo $materia;?>&clase=<?php echo $cat;?>&buscarselect=<?php echo $ordenar;?>&tipolectura=<?php echo $tipolectura;?>" title="Page <?php echo $i; ?>" class=""><?php echo $i; ?></a>
                <?php
            }
        }
        if ($page >= 0 && $page + 1 < $maxpage) {//
            echo '<a href="?page=' . ($page + 1) .'&nombre='.$nombre.'&autor='.$autor.'&materia='.$materia. '&clase='.$cat.'&buscarselect='.$ordenar. '" title="Next Page" class="rax-active-pal">' .
            '<span class="ui-icon ui-icon-triangle-1-e">>></span></a>';
        }
        if ($page + 1 == $maxpage) {
            echo '<a href="?page=' . ($page - 1) .'&nombre='.$nombre.'&autor='.$autor.'&materia='.$materia. '&clase='.$cat.'&buscarselect='.$ordenar. '" title="Prvious Page" class="rax-active-pal">' .
            '<span class="ui-icon ui-icon-triangle-1-w"><<</span></a>';
        }
        ?>
    </div>
</div>
<?php
echo $OUTPUT->footer();
?>
