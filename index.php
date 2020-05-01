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
    <ul class="navbar-nav ml-auto">
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" id="search" type="search" placeholder="Buscar por titulo">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
    </form>
    </ul>
  </div>
</nav>
      
<div class="container p-4">
    <div class="row">
        <div class="col-md-3">
           <div class="list-group">
             <a href="#" class="list-group-item list-group-item-action active">
             Cras justo odio
             </a>
             <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in
             </a>
            <a href="#" class="list-group-item list-group-item-action disabled">Morbi leo risus
              </a>
           </div>
        </div>
        <div class="col-md-9">
        <div class="jumbotron">
        <h1 class="display-5">Bienvenidos a la Biblioteca de ICEB</h1>
        <p class="lead">A continuación encontrarás los diferentes recursos bibliográficos especializados de los que dispones para profundizar y ampliar conocimientos relacionados con tu programa de estudios. </p>
        <hr class="my-4">
         <p>Contamos con un catálogo con diferentes tipos de recursos utilizados para los programas de estudios</p>
         <p class="lead">
         <a class="btn btn-primary btn-lg" href="/biblioteca/searchs.php" role="button">Saber más</a>
         </p>
         </div>
         </div>

    </div>
</div>



    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="app.js"></script>
    

</body>
</html>