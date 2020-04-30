<?php
require_once(dirname(__FILE__) . '../../config.php');

global $DB;


$courseid = $_SESSION['idCurso'];
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$category =$DB->get_record('course_categories', array("id" => $courseid ));



require_login();

$idr = required_param('id', PARAM_INT);
$cat = optional_param('cat',1, PARAM_INT);

$result = $DB->get_record('biblioteca_recursos', array('id' => $idr));

$resultcat = $DB->get_record('biblioteca_categorias', array('id' => $cat ));

$resultsubcat = $DB->get_record('biblioteca_subcategoria', array('id' => $result->idsubcategoria));


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/united/bootstrap.min.css" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
        <a class="nav-link" href="/course/view.php?id=<?php echo $courseid;?>&section=1"">Regresar Curso <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/biblioteca/searchs.php">Catálogo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" target="_blank" href="<?php echo new moodle_url('/message/index.php?id=43'); ?>">Soporte</a>
      </li>
    </ul>
    
  </div>
</nav>
      
<div class="container p-4">
    <div class="row">

        <div class="col-md-10">
        <div class="card mb-3">
  <h3 class="card-header">Información del recurso</h3>
    <ul class="list-group list-group-flush">
    <li class="list-group-item"><h5 class="card-title">Título</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted" id="title"><?php echo $result->titulo ?></h5></li>
    </ul>
    
    <ul class="list-group list-group-flush">
    <li class="list-group-item"><h5 class="card-title">Autor(es)</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted" id="autor"><?php echo $result->autor ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush">
    <li class="list-group-item"><h5 class="card-title">Tipo</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted" id="type"><?php echo $resultcat->nombre ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="asignatura">
    <li class="list-group-item"><h5 class="card-title">Asignatura</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted" ><?php echo $result->materia ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="anno">
    <li class="list-group-item"><h5 class="card-title">Año de publicación</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted"><?php echo $result->ano ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="resumen">
    <li class="list-group-item"><h5 class="card-title">Resumen</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted"><?php echo $result->resumen ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="claves">
    <li class="list-group-item"><h5 class="card-title">Palabras claves</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted"><?php echo $result->palabraclave ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="conocimento">
    <li class="list-group-item"><h5 class="card-title">Área de conocimiento</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted"><?php echo $result->areaconocimiento ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="tema">
    <li class="list-group-item"><h5 class="card-title">Tema</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted"><?php echo $result->recurso ?></h5></li>
    </ul>
    <ul class="list-group list-group-flush" id="idioma">
    <li class="list-group-item"><h5 class="card-title">Idioma</h5></li>
    <li class="list-group-item"><h5 class="card-subtitle text-muted"><?php echo $result->idioma ?></h5></li>
    </ul>

  <div class="card-footer text-muted">
      <row>
      <a href="<?php echo $result->url ?>" target="_black" class="btn btn-primary btn-lg" role="button">Acceder al recurso</a>
  <a href="/biblioteca/searchs.php" target="_black" class="btn btn-secondary btn-lg" role="button">Regresar</a>
      </row>
  
  </div>
</div>
           

        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="app.js"></script>
    

</body>
</html>