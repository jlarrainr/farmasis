<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$cod	 = $_POST['cod'];		///CODIGO UTILIZADO PARA ELIMINAR
$fechaActual = date('Y-m-d');
//mysqli_query($conexion,"DELETE from movmov where invnum = '$cod'");
function convertir_a_numero($str)
{
	  $legalChars = "%[^0-9\-\. ]%";
	  $str=preg_replace($legalChars,"",$str);
	  return $str;
}
$sql="SELECT numdoc,invfec,tipmov,tipdoc,sucursal FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    	$numdoc    = $row['numdoc'];
		$invfec    = $row['invfec'];
		$tipmov    = $row['tipmov'];
		$tipdoc    = $row['tipdoc'];
		$sucursal  = $row['sucursal'];
}
}
$sql="SELECT nomloc FROM xcompa where codloc = '$sucursal'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
    		$nomloc    = $row['nomloc'];
}
}
require_once('../tabla_local.php');
$sql="SELECT * FROM movmov where invnum = '$cod'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
	while ($row = mysqli_fetch_array($result)){
    	$codpro    = $row['codpro'];
		$qtypro    = $row['qtypro'];
		$qtyprf    = $row['qtyprf'];
		$pripro    = $row['pripro'];	//precio incluyendo el descuento e igv
		$prisal    = $row['prisal'];	//precio sin igv ni descuento
		$costre    = $row['costre'];	//costo real del producto. el pripro * la cantidad
		$desc1     = $row['desc1'];
		$desc2     = $row['desc2'];
		$desc3     = $row['desc3'];
		$costpr    = $row['costpr'];
		$stopro = 0;
		$cant_local = 0;
		/////////SELECCIONO EL PRODUCTO Y VEO SU FACTOR Y STOCK EN GENERAL
		$sql1="SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
		$result1 = mysqli_query($conexion,$sql1);
		if (mysqli_num_rows($result1)){
		while ($row1 = mysqli_fetch_array($result1)){
				$factor    = $row1['factor'];
				$stopro    = $row1['stopro'];
				$cant_loc  = $row1[2];
				//$sactual   = $stopro;
                                $sactual   = $cant_loc;
		}
		}
		if ($qtyprf <> "")
		{
			$text_char =  convertir_a_numero($qtyprf);
			$cant_unid = $text_char;
		}
		else
		{
			$cant_unid = $qtypro * $factor;
		}
		/////////////////////////////////////////////////////////////
		$cant_local = $cant_loc + $cant_unid ;
		$stopro = $stopro + $cant_unid;
		mysqli_query($conexion,"UPDATE producto set stopro = '$stopro', $tabla = '$cant_local' where codpro = '$codpro'");
		/////////////////////////////////////////////////////////////
		mysqli_query($conexion,"INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal, eliminado) values ('$numdoc','$codpro','$fechaActual','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$sucursal', '1')")	;
	}
}
mysqli_query($conexion,"UPDATE movmae set val_habil = '0' where invnum = '$cod'");
header("Location: consult_compras.php"); 
?>