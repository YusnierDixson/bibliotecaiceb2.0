<?php
require_once(dirname(__FILE__) . '../../config.php');
global $DB;
require_login();
$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category = $DB->get_record('course_categories', array("id" => $courseid));
$sections=$DB->get_records_list('course_sections','course', array("course" => $courseid),$sort='1',$fields='*', $limitfrom='', $limitnum='');

$PAGE->set_context(context_system::instance());



$sqlCat = 'SELECT * FROM mdl_biblioteca_categorias order by nombre';
$resultcat = $DB->get_records_sql($sqlCat);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/united/bootstrap.min.css" crossorigin="anonymous">
    
    <title>Biblioteca ICEB</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/biblioteca/menu.php">Biblioteca</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" id="search" type="search" placeholder="Buscar">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
    </form>
    </ul>
  </div>
</nav>
      
<div class="container p-4">
    <div class="row">
        <div class="col-md-5">
           <div class="card">
               <div class="card-body">
                   <form id="task-form">
                       <input type="hidden" id="taskId">
                       <div class="form-group">
                           <label for="titulo">Título</label>
                           <input type="text" id="title" required="true" placeholder="Título del recurso" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="autor">Autor(es)</label>
                           <input type="text" id="autor" required="true" placeholder="Autor o Autores" class="form-control">
                       </div>
                       <div class="form-group">
                       <label for="tipo">Tipo de recurso</label>
                          <select class="form-control" id="type">
                          <option value="0">Seleccione</option>
                        <?php foreach ($resultcat as $row) { ?>
                            <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                        <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                       <label for="asignatura">Asignatura</label>
                          <select class="form-control" id="asignatura">
                          <option value="0">Seleccione</option>
                          <?php foreach ($sections as $row) {?>
                             <option value="<?php if($row->name!=NULL||$row->name!="Aspectos Generales del Programa") echo $row->name ?>"><?php if($row->name!=NULL||$row->name!="Aspectos Generales del Programa") echo $row->name ?></option>
                        <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                       <label for="tipo">Tipo de lectura</label>
                          <select class="form-control" id="type_lect">
                          <option value="0">Seleccione</option>
                          <option value="obligatoria">Obligatoria</option>
                          <option value="recomendada">Recomendada</option>
                          <option value="libre">Libre</option>
                          </select>
                        </div>
                        <div class="form-group">
                       <label for="year">Año Publicación</label>
                          <select class="form-control" id="year">
                          <option value="0">Seleccione</option>
                          <?php $year = date("Y"); for ($i = $year; $i >= 1945; $i--) { ?>
                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                          </select>
                        </div>
                       <div class="form-group">
                          <label for="resumen">Resumen</label>
                           <textarea  id="resumen" required="true" cols="30" rows="8" class="form-control" placeholder="Resumen"></textarea>
                       </div>
                       <div class="form-group">
                           <label for="claves">Palabras claves</label>
                           <input type="text" required="true" id="claves" placeholder="Palabras claves" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="conocimieno">Área de Conocimiento</label>
                           <input type="text" required="true" id="conocimiento" placeholder="Área de Conocimiento" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="tema">Tema</label>
                           <input type="text" required="true" id="tema" placeholder="Tema" class="form-control">
                       </div>
                       <div class="form-group" id="div_revista" style="display:none;">
                           <label for="revista">Revista</label>
                           <input type="text" id="revista" placeholder="Revista" class="form-control">
                       </div>
                       <div class="form-group" id="div_edit" style="display:none;">
                           <label for="editorial">Editorial</label>
                           <input type="text" id="editorial" placeholder="Publicado por" class="form-control">
                       </div>
                       <div class="form-group" id="div_issn" style="display:none;">
                           <label for="issn">ISSN</label>
                           <input type="text" id="issn" placeholder="ISSN" class="form-control">
                       </div>
                       <div class="form-group" id="div_isbn" style="display:none;">
                           <label for="isbn">ISBN</label>
                           <input type="text" id="isbn" placeholder="ISBN" class="form-control">
                       </div>
                       <div class="form-group">
                       <label for="idioma">Idioma</label>
                          <select class="form-control" id="idioma">
                          <option value="Español">Español</option>
                        <option value="Inglés">Ingles</option>
                        <option value="Portugues">Portugues</option>
                        <option value="Catalan">Catalan</option>
                        <option value="Frances">Frances</option>
                          </select>
                        </div>
                        <div class="form-group">
                           <label for="url">URL Archivo</label>
                           <input type="url" id="url" required="true" placeholder="Acceso desde Google Drive" class="form-control">
                       </div>
                       <button type="submit" class="btn btn-primary btn-block text-center">Guardar</button>

                   </form>
               </div>
           </div>
        </div>
        <div class="col-md-7">
            <div class="card my-4" id="task-result" >
                <div class="card-body">
                    <ul id="container"></ul>
                </div>
            </div>
           <table class="table table-bordered table-sm">
               <thead>
                   <tr>
                       <td>Id</td>
                       <td>Name</td>
                       <td>Description</td>
                   </tr>
               </thead>
               <tbody id="tasks">

               </tbody>
           </table>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="app.js"></script>
    

</body>
</html>