<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo2 {color: #FF0000}
-->
</style>
<?php require_once('../../conexion.php');	//CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once("../../funciones/functions.php");	//DESHABILITA TECLAS
require_once('../../convertfecha.php');	//CONEXION A BASE DE DATOS
require_once("../../funciones/funct_principal.php");	//IMPRIMIR-NUME
$sql="SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$users    = $row['nomusu'];
}
}
$hour   = date('G');
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min	   = date('i');
if ($hour <= 12)
{
    $hor    = "am";
}
else
{
    $hor    = "pm";
}
$mov    = $_REQUEST['mov'];
$user   = $_REQUEST['user'];
$local  = $_REQUEST['local'];
$invnum = $_REQUEST['invnum'];
$desc_mov = $_REQUEST['tex'];
function formato($c) {
printf("%08d",  $c);
} 
function formato1($c) {
printf("%06d",  $c);
} 
////////////////////////////
/*
if ($mov == 1)
{
$desc_mov = "TODOS LOS MOVIMIENTOS";
}
if ($mov == 2)
{
$desc_mov = "SOLAMENTE INGRESOS";
}
if ($mov == 3)
{
$desc_mov = "SOLAMENTE SALIDAS";
}
if ($mov == 4)
{
$desc_mov = "COMPRAS";
}
if ($mov == 5)
{
$desc_mov = "INGRESO POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 6)
{
$desc_mov = "DEVOLUCION EN BUEN ESTADO";
}
if ($mov == 7)
{
$desc_mov = "CANJE AL LABORATORIO";
}
if ($mov == 8)
{
$desc_mov = "OTROS INGRESOS";
}
if ($mov == 9)
{
$desc_mov = "SALIDAS VARIAS";
}
if ($mov == 10)
{
$desc_mov = "GUIAS DE REMISION";
}
if ($mov == 11)
{
$desc_mov = "SALIDA POR TRANSFERENCIA DE SUCURSAL";
}
if ($mov == 12)
{
$desc_mov = "CANJE PROVEEDOR";
}
if ($mov == 13)
{
$desc_mov = "PRESTAMOS CLIENTE";
}
if ($user == 1)
{
$desc_user = "CLIENTE";
}
if ($user == 2)
{
$desc_user = "PROVEEDOR";
}
if ($user == 3)
{
$desc_user = "SUCURSAL";
}
*/
////////////////////////////
 $sql = "SELECT * FROM movmae where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row['invnum'];
            $invnumrecib = $row['invnumrecib'];
            $nro_compra = $row['nro_compra'];
            $invfec = $row['invfec'];
            $usecod = $row['usecod'];   //usuario
            $cuscod = $row['cuscod'];  //proveedor
            $numdoc = $row['numdoc'];
            $numdocD1 = $row['numero_documento'];
            $numdocD2 = $row['numero_documento1'];
            $fecdoc = $row['fecdoc'];
            $plazo = $row['plazo'];
            $forpag = $row['forpag'];
//            $invtot = $row['invtot'];
            $destot = $row['destot'];
            $valven = $row['valven'];
            $tipmov = $row['tipmov'];
            $tipdoc = $row['tipdoc'];
            $refere = $row['refere'];
            $fecven = $row['fecven'];
//            $monto = $row['monto'];
          //  $hora = $row['hora'];
            $saldo = $row['saldo'];
            $moneda = $row['moneda'];
            $suspendido = $row['suspendido'];
            $costo = $row['costo'];
            $igv = $row['igv'];
            $codanu = $row['codanu'];
            $codrec = $row['codrec'];
            $orden = $row['orden'];
            $sucursal = $row['sucursal'];   //sucursal origen
            $sucursal1 = $row['sucursal1']; //sucursal destino
            $incluidoIGV = $row['incluidoIGV'];
            $empresa = $row['empresa'];
           /* $dafecto = $row['dafecto'];
            $dinafecto = $row['dinafecto'];
            $digv = $row['digv'];
            $dtotal = $row['dtotal'];*/
            $monto = $row['invtot'];
             $hora = date("g:i a", strtotime($row['hora']));

 if($empresa <> 0){
         $sqlProv     = "SELECT destab FROM titultabladet where tiptab = 'EMP'  and codtab = '$empresa'";
            $resultProv  = mysqli_query($conexion, $sqlProv);
            if (mysqli_num_rows($resultProv)) 
            {
                while ($row = mysqli_fetch_array($resultProv))
                {
                    $destab_empresa     = $row['destab'];
                }
            }
 }else{
                $empresa = 0;
                $destab_empresa ="";
            }
            $sqlProv = "SELECT despro FROM proveedor where codpro = '$cuscod'";
            $resultProv = mysqli_query($conexion, $sqlProv);
            if (mysqli_num_rows($resultProv)) {
                while ($row = mysqli_fetch_array($resultProv)) {
                    $Proveedor = $row['despro'];
                }
            }
            $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal1'";
            $resultSuc = mysqli_query($conexion, $sqlSuc);
            if (mysqli_num_rows($resultSuc)) {
                while ($row = mysqli_fetch_array($resultSuc)) {
                    $sucursal_destino = $row['nombre'];
                }
            }
            $sqlSuc = "SELECT nombre FROM xcompa where codloc = '$sucursal'";
            $resultSuc = mysqli_query($conexion, $sqlSuc);
            if (mysqli_num_rows($resultSuc)) {
                while ($row = mysqli_fetch_array($resultSuc)) {
                    $Sucursal = $row['nombre'];
                }
            }
            if ($incluidoIGV == 1) {
                $incluidoIGV = "SI";
            } else {
                $incluidoIGV = "NO";
            }

            if ($tipmov == 1) {
                $desctip_mov = "INGRESO";
            } else {
                $desctip_mov = "SALIDA";
            }
        }
    }
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $desemp?></title>
</head>

<body>
<table width="930" border="0" align="center">
  <tr>
    <td><table width="914" border="0">
      <tr>
        <td width="260"><strong><?php echo $desemp?> </strong></td>
        <td width="380"><div align="center"><strong>REPORTE DE INGRESOS Y SALIDAS  -
          <?php if ($local == 'all'){ echo 'TODAS LAS SUCURSALES';} else { echo $nomloc;}?>
        </strong></div></td>
        <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y');?> - HORA : <?php echo $hour;?>:<?php echo $min;?> <?php echo $hor?></strong></div></td>
      </tr>
    </table>
        <table width="914" border="0">
          <tr>
            <td width="267"><strong><?php echo $desc_mov?></strong></td>
            <td width="366"><div align="center"><b>
              <?php if ($val == 1){?>
              NRO DE DOCUMENTO ENTRE EL <?php echo $desc; ?> Y EL <?php echo $desc1; } if ($vals == 2){?> FECHAS ENTRE EL <?php echo $date1; ?> Y EL <?php echo $date2; }?></b></div></td>
            <td width="267"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $users?></span></div></td>
          </tr>
        </table>
      <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
       <table width="100%" border="0" align="center" style="background:#f0f0f0;border: 1px solid #cdcdcd;border-spacing:0;border-collapse: collapse;" class="no-spacing" cellspacing="0">
                        <tr>
                            <td style="text-align: left;width:20%"><b>FECHA / HORA : </b><?php echo fecha($invfec).' - '.$hora ?></td>
                            <td style="text-align: left;width:20%"><b>INTERNO : </b><?php echo formato($invnum) ?></td>
                            <td style="text-align: left;width:20%"><b>TIPO MOV : </b><?php echo $desctip_mov ?></td>
                            <td style="text-align: left;width:20%"><?php if (($desc_mov <> 'INGRESO POR COMPRA')) { ?><b>N&ordm; DOCUMENTO : </b><?php echo formato($numdoc); }?></td>
                            <td style="text-align: left;width:20%;"><b>MONTO : </b><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' '); ?></td>
                        </tr>
                        <?php if ($Sucursal <> '') { ?>
                            <tr>
                                <td  colspan="3">
                                    <b>REFERENCIA : </b>
                                    <?php
                                    echo $refere;
                                    echo "...";
                                    ?>
                                </td>
                                <td style="text-align: left;" ><?php if ($sucursal1 <> 0) { ?><b> LOCAL ENVIO :</b><?php } else { ?><b>LOCAL  : </b><?php } ?><?php echo $Sucursal; ?></td>
                                <td style="text-align: left;" > <?php if ($sucursal1 <> 0) { ?><b>LOCAL DES  : </b><?php echo $sucursal_destino; ?> <?php } ?></td>
                            </tr>
                        <?php } ?>


                        <?php if (($desc_mov == 'INGRESO POR COMPRA')) { ?>
                            <tr>
                                <td style="text-align: left;background:#1384a0;color:#ffffff;" ><b>PROVEEDOR : </b><?php echo $Proveedor; ?></td>
                                <td style="text-align: left;background:#1384a0;color:#ffffff;" ><b>EMPRESA : </b><?php echo $destab_empresa; ?></td>
                                <td style="text-align: left;background:#1384a0;color:#ffffff;"  ><b>N&ordm; DOC : </b><?php echo $numdocD1 . '-' . $numdocD2; ?> </td>			
                                <td style="text-align: left;" ><b>TIPO. DOC : </b><?php echo $forpag; ?></td>
                                <td style="text-align: left;" ><b>INCLUIDO IGV : </b> <?php echo $incluidoIGV; ?></td>			
                                <td style="text-align: left;" ><b>LOCAL : </b><?php echo $Sucursal; ?></td>
                            </tr>


                            <?php if ($plazo > 0) { ?>
                                <tr>
                                    <td colspan="2" style="text-align: left;width:50%" ><b>Plazo : </b><?php echo $plazo; ?></td>
                                    <td colspan="3 "style="text-align: left;width:50%" ><b>Fecha. P : </b><?php echo fecha($fecven).' - '.$hora; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td style="text-align: left;" ><b></b> <?php// echo number_format($dafecto, 2, '.', ' '); ?></td>
                                <td style="text-align: left;" ><b></b> <?php //echo number_format($dinafecto, 2, '.', ' '); ?></td>
                                <td style="text-align: left;" ><b></b> <?php //echo number_format($digv, 2, '.', ' '); ?></td>
                                <td style="text-align: left;" ><b></b><?php //echo number_format($dtotal, 2, '.', ' '); ?></td>
                                <td style="text-align: left;" ></td>
                            </tr>

                        <?php } ?>
                    </table>
    
    </td>
  </tr>
</table>
<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="926" border="0" align="center">
          <tr>
            <td width="50"><?php echo fecha($invfec).' - '.$hora?></td>
            <td width="174"><div align="center"><?php echo $desctip?></div></td>
            <td width="124"><div align="left"><?php echo formato($numdoc);?></div></td>
            <td width="156"><div align="left">
              <?php ?>
            </div></td>
            <td width="311"><?php if ($refere <> ""){?>
                <?php echo $refere;?>
              <?php }?></td>
            <td width="85"><div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' ');?></div></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php
if ($tipmov == 1)
{
	if ($tipdoc == 2)
	{
	?>
	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td><table width="926" border="0" align="center">
		  <tr>
			<td width="150"><strong>DE LOCAL:</strong> <?php echo $nombre1?></td>
			<td width="150"><strong>A LOCAL:</strong> <?php echo $nombre?></td>
			<td width="310"><strong>USUAURIO ORIG: </strong> <?php echo $nomusuorig;?></td>
			<td width="316"><strong>USUAURIO DEST: </strong><?php echo $nomusudest;?></td>
		  </tr>
		</table></td>
	  </tr>
	</table>
	<?php
	}
}
if ($tipmov == 2)
{
	if ($tipdoc == 3)
	{
	?>
	<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td><table width="926" border="0" align="center">
		  <tr>			
			<td width="150"><strong>DE LOCAL:</strong> <?php echo $nombre?></td>
			<td width="150"><strong>A LOCAL:</strong> <?php echo $nombre1?></td>
			<td width="310"><strong>USUAURIO ORIG: </strong> <?php echo $nomusudest;?></td>
			<td width="316"><strong>USUAURIO DEST: </strong><?php echo $nomusuorig;?></td>
		  </tr>
		</table></td>
	  </tr>
	</table>
	<?php
	}
}
?>
<div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>

<table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<?php $sql="SELECT * FROM movmov where invnum = '$invnum'";
	$result = mysqli_query($conexion,$sql);
	if (mysqli_num_rows($result)){
	?>
	<table width="926" border="1" align="center" id="customers">
	    <tr>
        <th width="5"><strong>CODIGO</strong></th>
        <th width="373"><strong>PRODUCTO</strong></th>
        <th width="80"><strong>MARCA/LABORATORIO</strong></th>
        <th width="25"><strong>LOTE</strong></th>
        <th width="25"><strong>VENCIMIENTO</strong></th>
        
        <th width="62"><div align="right"><strong>CANTIDAD</strong></div></th>
        <th width="76"><div align="right"><strong>COSTO </strong></div></th>
        <th width="58"><div align="right"><strong>DESC 1 </strong></div></th>
        <th width="58"><div align="right"><strong>DESC 2 </strong></div></th>
        <th width="58"><div align="right"><strong>DESC 3 </strong></div></th>
        <th width="76"><div align="right"><strong>TOTAL DCTO </strong></div></th>
		<th width="64"><div align="right"><strong>SUB TOTAL </strong></div></th>
      </tr>
      <?php while ($row = mysqli_fetch_array($result)){
	  		$codpro    = $row['codpro'];
			$qtypro    = $row['qtypro'];
			$qtyprf    = $row['qtyprf'];
			$pripro    = $row['pripro'];
			$prisal    = $row['prisal'];
			$costre    = $row['costre'];
			$desc1     = $row['desc1'];
			$desc2     = $row['desc2'];
			$desc3     = $row['desc3'];
			$sql1="SELECT desprod,factor,codmar FROM producto where codpro = '$codpro'";
			$result1 = mysqli_query($conexion,$sql1);
			if (mysqli_num_rows($result1)){
			while ($row1 = mysqli_fetch_array($result1)){
	  		$desprod    = $row1['desprod'];
			$factor     = $row1['factor'];
			$codmar     = $row1['codmar'];
			}
			}
			                             $numlote2='';
  $vencim='';
  $codkard='';
  $idlote='';
                                
                                 $sqlkar="SELECT codkard FROM kardex WHERE invnum='$invnum' and codpro = '$codpro'";
        $resultkar = mysqli_query($conexion,$sqlkar);
        if (mysqli_num_rows($resultkar)){
            while ($rowkar = mysqli_fetch_array($resultkar)){
                $codkard   = $rowkar['codkard'];
        }}                 
        
        $sqlkl="SELECT IdLote FROM kardexLote WHERE codkard ='$codkard' and IdLote <>'0'";
        $resultkl = mysqli_query($conexion,$sqlkl);
        if (mysqli_num_rows($resultkl)){
            while ($rowkl = mysqli_fetch_array($resultkl)){
                $idlote   = $rowkl['IdLote'];
        }}
  
   $sqllo="SELECT numlote,vencim FROM movlote WHERE idlote='$idlote'";
        $resultlo = mysqli_query($conexion,$sqllo);
        if (mysqli_num_rows($resultlo)){
            while ($rowlo = mysqli_fetch_array($resultlo)){
                $numlote2   = $rowlo['numlote'];
                $vencim   = $rowlo['vencim'];
        }}
			$sql1 = "SELECT destab,abrev FROM titultabladet  where codtab = '$codmar'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $destab = $row1['destab'];
                                        $abrev = $row1['abrev'];
                                        if ($abrev <> '') {
                                            $destab = $abrev;
                                        }
                                    }
                                }
			
			if ($qtyprf == "")
			{
			$cantidad = $qtypro;
			}
			else
			{
			$cantidad = $qtyprf;
			}
	  ?>
	  <tr>
        <td width="5"><?php echo $codpro;?></td>
        <td width="373"><?php echo $desprod; echo " "; /*if ($pripro == 0){?>(BONIF)<?php }*/?></td>
        <td ><?php echo $destab; ?></td>
                                    <td ><div align="center"><?php echo $numlote2 ?></div></td>
                                    <td ><div align="center"><?php echo $vencim ?></div></td>
        <td width="62"><div align="right"><?php echo $cantidad?></div></td>
        <td width="76"><div align="right"><?php echo $prisal?></div></td>
        <td width="58"><div align="right"><?php echo $desc1?></div></td>
        <td width="58"><div align="right"><?php echo $desc2?></div></td>
        <td width="58"><div align="right"><?php echo $desc3?></div></td>
        <td width="76"><div align="right"><?php echo $pripro?></div></td>
		<td width="64"><div align="right"><?php echo $costre?></div></td>
      </tr>
	  <?php }
	  ?>
    </table>
	<?php }
	?>
	</td>
  </tr>
</table>
</body>
</html>
