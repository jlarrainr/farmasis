<?php include('../../session_user.php');
require_once('../../../conexion.php');
$val     = $_REQUEST['val'];
$p1      = $_REQUEST['p1'];
$ord     = $_REQUEST['ord'];
$codpro  = $_REQUEST['codpro'];
$cant    = $_REQUEST['cant'];
$cant2   = $_REQUEST['cant2'];
$monto   = $_REQUEST['monto'];
$price   = $_REQUEST['price'];
$cuota   = $_REQUEST['cuota'];
$inicio  = $_REQUEST['inicio'];
$pagina  = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$factor  = $_REQUEST['factor'];
$codloc  = $_REQUEST['local'];
$state   = $_REQUEST['state'];
//$incent  = $_REQUEST['incent'];
//$hour   = date('G');
$date	= date('Y-m-d');
//$date	= CalculaFechaHora($hour);
$registros  = $_REQUEST['registros'];
mysqli_query($conexion,"UPDATE incentivadodet set estado = '1' where codpro = '$codpro' and invnum = '$invnum' and codloc = '$codloc'");
header("Location: incentivo3.php?cod=$codpro&p1=$p1&val=$val&inicio=$inicio&pagina=$pagina&tot_pag=$tot_pag&registros=$registros&valform=1");
?>