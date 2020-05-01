<?php

require_once(dirname(__FILE__) . '../../config.php');
global $DB;
require_login();
$admins = get_admins();
$isadmin = false;
foreach($admins as $admin) {
    if ($USER->id == $admin->id) {
        $isadmin = true;
        break;
    }
}
$estadistica=array('revista'=>0,'libro'=>0,'tesis'=>0,'mono'=>0,'generi'=>0,'isadmin'=>false);

$estadistica['revista']=$DB->count_records("biblioteca_recursos", array("idCategoria" => 2));
$estadistica['libro']=$DB->count_records("biblioteca_recursos", array("idCategoria" => 1));
$estadistica['tesis']=$DB->count_records("biblioteca_recursos", array("idCategoria" => 3));
$estadistica['mono']=$DB->count_records("biblioteca_recursos", array("idCategoria" => 7));
$estadistica['generi']=$DB->count_records("biblioteca_recursos", array("idCategoria" => 6));
$estadistica['isadmin']=$isadmin;
$jsonestad=json_encode($estadistica);
echo $jsonestad;