<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="euc-jp">

    <title><?php echo $desemp ?></title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .Estilo1 {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
    <script>
        function eliminar_stock(valor) {
            var valor;

            //alert(valor); return; 
            var f = document.form1;
            ventana = confirm("Se eliminara el registro de este lote y no podra ser recuperado (No afectar\u00E1 el stock actual)");
            if (ventana) {
                f.method = "post";
                f.target = "_top";
                f.action = "reset_movlote.php?codigo=" + valor;
                f.submit();
            }
        }
    </script>
</head>
<?php
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
        $codloc = $row['codloc'];
    }
}
 $sql = "SELECT drogueria FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $drogueria = $row['drogueria'];
        }
    }
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$date = date('Y/m/d');
$hour = date('G');
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = $_REQUEST['val'];
$mes = $_REQUEST['mes'];
$year = $_REQUEST['year'];
$ckvencidos = $_REQUEST['ckvencidos'];

$local = $_REQUEST['local'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$resumen = $_REQUEST['resumen'];
$registros = $_REQUEST['registros'];

$cuento = strlen($mes);
if ($cuento == '2') {
    $mes = $mes;
} else {
    $mes = '0' . $mes;
}

$mes1 = date("m");
$año1 = date("Y");

$feca1 = $mes1 . '/' . $año1;
$feca2 = $mes . '/' . $year;

$D1 = $año1 . '/' . $mes1 . '/' . '00';
$D2 = $year . '/' . $mes . '/' . '00';
$fecha =      $mes . '/' .$year;
$fecha1 =      $mes . '/' .$year;

if ($local <> 'all') {
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
            $nombre = $row['nombre'];
            if ($nombre <> "") {
                $nomloc = $nombre;
            }
        }
    }
}


///modifcar lotes y vencimiento
$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";

//echo '$codpros = '.$codpros.'<br>';
//echo '$valform = '.$valform.'<br>';

if ($valform == 1) {
    $colspan = '2';
    $accion = 'GRABAR / CANCELAR';
} else {
    $colspan = '1';
    $accion = 'MODIFICAR';
}



?>

<body>
    <form id="form1" name="form1">
        <table width="100%" border="0" align="center">
            <tr>
                <td>
                    <table width="100%" border="0">
                        <tr>
                            <td width="260"><strong><?php echo $desemp ?> </strong></td>
                            <td width="380">
                                <div align="center"><strong>REPORTE DE PRODUCTOS POR VENCER -
                                        <?php
                                        if ($local == 'all') {
                                            echo 'TODAS LAS SUCURSALES';
                                        } else {
                                            echo $nomloc;
                                        }
                                        ?>
                                    </strong></div>
                            </td>
                            <td width="260">
                                <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                            </td>
                        </tr>

                    </table>
                    <table width="100%" border="0">
                        <tr>
                            <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                            <td width="633">
                                <div align="center"><b>
                                        <?php if ($val == 1) { ?>
                                            <?php if ($ckvencidos == 1) { ?>
                                                FECHAS ANTERIORES DEL <?php echo $feca1; ?>
                                            <?php } else { ?>

                                                FECHAS ENTRE EL <?php echo $feca1; ?> Y EL <?php echo $feca2;
                                                                                        }
                                                                                    }
                                                                                            ?>

                                    </b></div>
                            </td>
                            <td width="133">
                                <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
                </td>
            </tr>
        </table>
        <?php
        if ($val == 1) {
        ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        $i = 0;
                        if ($ckvencidos == 1) {



                            if ($local == 'all') {
                                $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock from movlote where vencim <= '$fecha'   AND  stock > 0 ";
                            } else {
                                $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock from movlote where vencim <= '$fecha' and codloc = '$local' AND  stock > 0 ";
                            }
                        } else {
 
//echo ' $D1 = '.$D1."<br>";
//echo ' $D2 = '.$D2."<br>";
                            if ($local == 'all') {
                                $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock from movlote where  vencim <= '$fecha'  and vencim >= '$fecha1' AND  stock > 0 ";
                            } else {
                                $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock from movlote where vencim <= '$fecha'   and vencim >= '$fecha1' and codloc = '$local' AND  stock > 0  ";
                            }
                        }
                        
                        //echo $sql;
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                    <th width="20" align="right"><strong>SUCURSAL</strong></th>
                                    <th width="20" align="right"><strong>CODIGO</strong></th>
                                    <th width="120">
                                        <div align="left"><strong>PRODUCTO </strong></div>
                                    </th>
                                    <th width="73">
                                        <div align="LEFT"><strong>PROVEEDOR</strong></div>
                                    </th>
                                    <th width="73">
                                        <div align="LEFT"><strong>MARCA</strong></div>
                                    </th>
                                    <th width="73">
                                        <div align="center"><strong>FACTOR</strong></div>
                                    </th>
                                    <th width="73">
                                        <div align="center"><strong>LOTE</strong></div>
                                    </th>
                                    <th width="73">
                                        <div align="center" class="Estilo1"><strong>VENCIMIENTO</strong></div>
                                    </th>
                                    <th width="30">
                                        <div align="right"><strong>STOCK ACTUAL</strong></div>
                                    </th>
                                    <th width="30">
                                        <div align="right"><strong>STOCK DEL LOTE</strong></div>
                                    </th>
                                    <?php if($drogueria == 0){?>
                                    <th width="3">
                                        <div align="center"><strong></strong></div>
                                    </th>
                                    <?php }?>
                                  
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $i++;

                                    $idlote = $row['idlote'];
                                    $codpro = $row['codpro'];
                                    $vencim = $row['vencim'];
                                    $codloc = $row['codloc'];
                                    $stock_movimiento = $row['stock'];
                                    $numlote = $row['numlote'];


                                    $sql1 = "SELECT desprod,codmar,factor,$tabla FROM producto WHERE codpro='$codpro' and eliminado='0'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {

                                            $desprod = $row1['desprod'];
                                            $codmar = $row1['codmar'];
                                            $factor = $row1['factor'];
                                            $stock = $row1[3];
                                        }
                                    }
                                    $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $destab = $row1['destab'];
                                        }
                                    }
                                    $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                            $nombre = $row1['nombre'];
                                            if ($nombre <> "") {
                                                $sucursal = $nombre;
                                            }
                                        }
                                    }
                                    
                                     $sql4 = "SELECT MA.cuscod,P.despro,MA.numero_documento,MA.numero_documento1 FROM `movmov` as MV INNER JOIN movmae MA ON MA.invnum=MV.invnum INNER JOIN proveedor AS P ON P.codpro=MA.cuscod where MV.numlote='$idlote' group by MV.numlote ";
                                        $result4 = mysqli_query($conexion, $sql4);
                                        while ($row4 = mysqli_fetch_array($result4)) {
                                            $cuscod = $row4["cuscod"];
                                            $despro = $row4["despro"];
                                            $numero_documento = $row4["numero_documento"];
                                            $numero_documento1 = $row4["numero_documento1"];
                                        }


                                ?>
                                    <tr height="25" onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                                        <td width="20" align="center"><?php echo $sucursal ?></td>
                                        <td width="20" align="center"><?php echo $codpro ?></td>
                                        <td width="130">
                                            <div align="left"><?php echo $desprod ?></div>
                                        </td>
                                         <td width="150">
                                                <div align="left"><?php echo $despro; ?></div>
                                            </td>
                                        <td width="60">
                                            <div align="left"><?php echo $destab ?></div>
                                        </td>
                                        <td width="60">
                                            <div align="center"><?php echo $factor ?></div>
                                        </td>
                                        <td width="60">
                                            <div align="center"><?php echo $numlote ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"  class="Estilo1">
                                                 <?php echo $vencim ?>
                                                </div>
                                            
                                        </td>
                                        <td width="45">
                                            <div align="right"><?php echo stockcaja($stock, $factor); ?></div>
                                        </td>
                                        <td width="45">
                                            <div align="right"><?php echo stockcaja($stock_movimiento, $factor); ?></div>
                                        </td>
                                         <?php if($drogueria == 0){ ?>
                                        <td>
                                            <div align="center">

                                                <img src="eliminar.svg" width="25" height="25" onclick="eliminar_stock('<?php echo $idlote; ?>')" ; />

                                            </div>
                                        </td>
                                        <?php } ?>
                                        
                                         
                                        
                                        <?php if (($valform == 1) and ($codpros == $idlote)) { ?>
                                                <td>
                                                    <div align="center">

                                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                                        <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                       
                                                        <input name="mes" type="hidden" id="mes" value="<?php echo $mes ?>" />
                                                        <input name="year" type="hidden" id="year" value="<?php echo $year ?>" />
                                                        <input name="ckvencidos" type="hidden" id="ckvencidos" value="<?php echo $ckvencidos ?>" />
                                                        <input name="idlote" type="hidden" id="idlote" value="<?php echo $idlote ?>" />
                                                        <input name="costpr" type="hidden" id="costpr" value="<?php echo $costpr ?>" />
                                                        <input name="utlcos" type="hidden" id="utlcos" value="<?php echo $utlcos ?>" />
                                                        <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
                                                        <!--   <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR"/>-->

                                                    </div>
                                                </td>
                                                <td>
                                                    <div align="center">
                                                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
                                                    </div>
                                                </td>
                                            <?php
                                            } else {
                                                
                                               
                                            ?>
                                              
                                            <?php } ?>
                                    </tr>
                                <?php }

                                ?>
                                <div>
                                    <b style="color:green; font-size:14px;"><?php echo "Hay " . $i . " productos en esta lista."; ?></b>
                                </div>
                            </table>
                        <?php
                        } else {
                        ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ///CIERRE DE VAL = 1
        ?>
    </form>
</body>

</html>