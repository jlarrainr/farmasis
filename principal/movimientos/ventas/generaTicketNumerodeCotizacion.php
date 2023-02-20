<?php
require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php');    //CONEXION A BASE DE DATOS
require_once('MontosText.php');

function pintaDatos($Valor)
{
    if ($Valor <> "") {
        return "<tr><td style:'text-align:center'><center>" . $Valor . "</center></td></tr>";
    }
}

function zero_fill($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}
?>
<html>

<head>
    <meta charset="euc-jp">

    <script>
        function imprimir() {
            var f = document.form1;
            window.print();
            f.action = "venta_index.php";
            f.method = "post";
            f.submit();
        }
    </script>
    <style>
        body,
        table {
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body onload="imprimir()">
    <form name="form1" id="form1">
        <?php

        function cambiarFormatoFecha($fecha)
        {
            list($anio, $mes, $dia) = explode("-", $fecha);
            return $dia . "-" . $mes . "-" . $anio;
        }

        //set it to writable location, a place for temp generated PNG files
        $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        //html PNG location prefix
        $PNG_WEB_DIR = 'temp/';
        include "../../phpqrcode/qrlib.php";

        $filename = $PNG_TEMP_DIR . 'ventas.png';

        $matrixPointSize = 3;
        $errorCorrectionLevel = 'L';
        $framSize = 3; //Tama�����o en blanco

        $rd = $_REQUEST['rd'];
        $venta = $_REQUEST['vt'];
        $seriebol = "B001";
        $seriefac = "F001";
        $serietic = "T001";
        $filename = $PNG_TEMP_DIR . 'test' . $venta . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

        require_once('calcula_monto2.php');
        $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,nomcliente,pagacon,vuelto,bruto,hora,invtot,igv,valven,tipdoc,tipteclaimpresa "
            . "FROM venta where invnum = '$venta'";
        $resultV = mysqli_query($conexion, $sqlV);
        if (mysqli_num_rows($resultV)) {
            while ($row = mysqli_fetch_array($resultV)) {
                $invnum = $row['invnum'];
                $nrovent = $row['nrovent'];
                $invfec = cambiarFormatoFecha($row['invfec']);
                $cuscod = $row['cuscod'];
                $usecod = $row['usecod'];
                $codven = $row['codven'];
                $forpag = $row['forpag'];
                $fecven = $row['fecven'];
                $sucursal = $row['sucursal'];
                $correlativo = $row['correlativo'];
                $nomcliente = $row['nomcliente'];
                $pagacon = $row['pagacon'];
                $vuelto = $row['vuelto'];
                $valven = $row['valven'];
                $igv = $row['igv'];
                $invtot = $row['invtot'];
                $hora = $row['hora'];
                $tipdoc = $row['tipdoc'];
                $tipteclaimpresa = $row['tipteclaimpresa'];

                $sqlXCOM = "SELECT seriebol,seriefac,serietic FROM xcompa where codloc = '$sucursal'";
                $resultXCOM = mysqli_query($conexion, $sqlXCOM);
                if (mysqli_num_rows($resultXCOM)) {
                    while ($row = mysqli_fetch_array($resultXCOM)) {
                        $seriebol = $row['seriebol'];
                        $seriefac = $row['seriefac'];
                        $serietic = $row['serietic'];
                    }
                }
            }
        }

        //F9
        if ($tipteclaimpresa == "2") {
            if ($tipdoc == 1) {
                $serie = "F" . $seriefac;
            }
            if ($tipdoc == 2) {
                $serie = "B" . $seriebol;
            }
            if ($tipdoc == 4) {
                $serie = "T" . $serietic;
            }
        } else { //F8
            $serie = $correlativo;
        }

        if ($tipdoc == 1) {
            $TextDoc = "Factura electr&oacute;nica";
        }
        if ($tipdoc == 2) {
            $TextDoc = "Boleta electr&oacute;nica";
        }
        if ($tipdoc == 4) {
            $TextDoc = "";
        }
        $SerieQR = $serie;

        //TOMO LOS PATRAMETROS DEL TICKET
        $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
            . "FROM ticket where sucursal = '$sucursal'";
        $resultTicket = mysqli_query($conexion, $sqlTicket);
        if (mysqli_num_rows($resultTicket)) {
            while ($row = mysqli_fetch_array($resultTicket)) {
                $linea1 = $row['linea1'];
                $linea2 = $row['linea2'];
                $linea3 = $row['linea3'];
                $linea4 = $row['linea4'];
                $linea5 = $row['linea5'];
                $linea6 = $row['linea6'];
                $linea7 = $row['linea7'];
                $linea8 = $row['linea8'];
                $linea9 = $row['linea9'];
                $pie1 = $row['pie1'];
                $pie2 = $row['pie2'];
                $pie3 = $row['pie3'];
                $pie4 = $row['pie4'];
                $pie5 = $row['pie5'];
                $pie6 = $row['pie6'];
                $pie7 = $row['pie7'];
                $pie8 = $row['pie8'];
                $pie9 = $row['pie9'];
            }
        } else {
            $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9 "
                . "FROM ticket where sucursal = '1'";
            $resultTicket = mysqli_query($conexion, $sqlTicket);
            if (mysqli_num_rows($resultTicket)) {
                while ($row = mysqli_fetch_array($resultTicket)) {
                    $linea1 = $row['linea1'];
                    $linea2 = $row['linea2'];
                    $linea3 = $row['linea3'];
                    $linea4 = $row['linea4'];
                    $linea5 = $row['linea5'];
                    $linea6 = $row['linea6'];
                    $linea7 = $row['linea7'];
                    $linea8 = $row['linea8'];
                    $linea9 = $row['linea9'];
                    $pie1 = $row['pie1'];
                    $pie2 = $row['pie2'];
                    $pie3 = $row['pie3'];
                    $pie4 = $row['pie4'];
                    $pie5 = $row['pie5'];
                    $pie6 = $row['pie6'];
                    $pie7 = $row['pie7'];
                    $pie8 = $row['pie8'];
                    $pie9 = $row['pie9'];
                }
            }
        }
        $sqlUsu = "SELECT nomusu,abrev FROM usuario where usecod = '$usecod'";
        $resultUsu = mysqli_query($conexion, $sqlUsu);
        if (mysqli_num_rows($resultUsu)) {
            while ($row = mysqli_fetch_array($resultUsu)) {
                $nomusu = $row['abrev'];
            }
        }

        $MarcaImpresion = 0;
        $sqlDataGen = "SELECT desemp,rucemp,telefonoemp,MarcaImpresion FROM datagen";
        $resultDataGen = mysqli_query($conexion, $sqlDataGen);
        if (mysqli_num_rows($resultDataGen)) {
            while ($row = mysqli_fetch_array($resultDataGen)) {
                $desemp = $row['desemp'];
                $rucemp = $row['rucemp'];
                $telefonoemp = $row['telefonoemp'];
                $MarcaImpresion = $row['MarcaImpresion'];
            }
        }
        $departamento = "";
        $provincia = "";
        $distrito = "";
        $sqlCli = "SELECT descli,dircli,ruccli,dptcli,procli,discli FROM cliente where codcli = '$cuscod'";
        $resultCli = mysqli_query($conexion, $sqlCli);
        if (mysqli_num_rows($resultCli)) {
            while ($row = mysqli_fetch_array($resultCli)) {
                $descli = $row['descli'];
                $dircli = $row['dircli'];
                $ruccli = $row['ruccli'];
                $dptcli = $row['dptcli'];
                $procli = $row['procli'];
                $discli = $row['discli'];
            }
            if (strlen($dircli) > 0) {
                //VERIFICO LOS DPTO, PROV Y DIST
                if (strlen($dptcli) > 0) {
                    //                $sqlDPTO = "SELECT destab FROM titultabladet where codtab = '$dptcli'";
                    $sqlDPTO = "SELECT name FROM departamento where id = '$dptcli'";
                    $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                    if (mysqli_num_rows($resultDPTO)) {
                        while ($row = mysqli_fetch_array($resultDPTO)) {
                            $departamento = $row['name'];
                        }
                    }
                }
                if (strlen($procli) > 0) {
                    $sqlDPTO = "SELECT name FROM provincia where id = '$procli'";
                    $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                    if (mysqli_num_rows($resultDPTO)) {
                        while ($row = mysqli_fetch_array($resultDPTO)) {
                            $provincia = " | " . $row['name'];
                        }
                    }
                }

                if (strlen($discli) > 0) {
                    $sqlDPTO = "SELECT name FROM distrito where id = '$discli'";
                    $resultDPTO = mysqli_query($conexion, $sqlDPTO);
                    if (mysqli_num_rows($resultDPTO)) {
                        while ($row = mysqli_fetch_array($resultDPTO)) {
                            $distrito = " | " . $row['name'];
                        }
                    }
                }
                $Ubigeo = $departamento . $provincia . $distrito;
                if (strlen($Ubigeo) > 0) {
                    $dircli = $dircli . "  - " . $Ubigeo;
                }
            }
        }
        $SumInafectos = 0;
        $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta'";
        $resultDetTot = mysqli_query($conexion, $sqlDetTot);
        if (mysqli_num_rows($resultDetTot)) {
            while ($row = mysqli_fetch_array($resultDetTot)) {
                $igvVTADet = 0;
                $codproDet = $row['codpro'];
                $canproDet = $row['canpro'];
                $factorDet = $row['factor'];
                $prisalDet = $row['prisal'];
                $priproDet = $row['pripro'];
                $fraccionDet = $row['fraccion'];
                $sqlProdDet = "SELECT igv FROM producto where codpro = '$codproDet'";
                $resultProdDet = mysqli_query($conexion, $sqlProdDet);
                if (mysqli_num_rows($resultProdDet)) {
                    while ($row1 = mysqli_fetch_array($resultProdDet)) {
                        $igvVTADet = $row1['igv'];
                    }
                }
                if ($igvVTADet == 0) {
                    $MontoDetalle = $prisalDet * $canproDet;
                    $SumInafectos = $SumInafectos + $MontoDetalle;
                }
            }
        }
        $SumGrabado = $invtot - ($igv + $SumInafectos);
        ?>
        <table width="100%" border="4" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
                <td style="font-size: 22px;">
                    <center><b><?php echo $descli; ?></b></center>
                </td>
                <td style="font-size: 26px;">
                    <center><b><?php echo $TextDoc; ?> - <?php echo $serie . '-' . zero_fill($correlativo, 8); ?></b></center>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table style="width: 100%">
            <?php
            $i = 1;
            $sqlDet = "SELECT * FROM detalle_venta where invnum = '$venta'";
            $resultDet = mysqli_query($conexion, $sqlDet);
            if (mysqli_num_rows($resultDet)) {
            ?>
                <?php
                while ($row = mysqli_fetch_array($resultDet)) {
                    $codpro = $row['codpro'];
                    $canpro = $row['canpro'];
                    $factor = $row['factor'];
                    $prisal = $row['prisal'];
                    $pripro = $row['pripro'];
                    $fraccion = $row['fraccion'];
                    $idlote = $row['idlote'];

                    $factorP = 1;
                    $sqlProd = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
                    $resultProd = mysqli_query($conexion, $sqlProd);
                    if (mysqli_num_rows($resultProd)) {
                        while ($row1 = mysqli_fetch_array($resultProd)) {
                            $desprod = $row1['desprod'];
                            $codmar = $row1['codmar'];
                            $factorP = $row1['factor'];
                        }
                    }
                    if ($fraccion == "F") {
                        $cantemp = "C" . $canpro;
                    } else {
                        if ($factorP == 1) {
                            $cantemp = $canpro;
                        } else {
                            $cantemp = "F" . $canpro;
                        }
                    }
                    $Cantidad = $canpro;
                    $numlote = "";
                    $sqlLote = "SELECT numlote FROM movlote where idlote = '$idlote'";
                    $resulLote = mysqli_query($conexion, $sqlLote);
                    if (mysqli_num_rows($resulLote)) {
                        while ($row1 = mysqli_fetch_array($resulLote)) {
                            $numlote = $row1['numlote'];
                        }
                    }
                    $sqlMarca = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                    $resultMarca = mysqli_query($conexion, $sqlMarca);
                    if (mysqli_num_rows($resultMarca)) {
                        while ($row1 = mysqli_fetch_array($resultMarca)) {
                            $ltdgen = $row1['ltdgen'];
                        }
                    }
                    $marca = "";
                    $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                    $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                    if (mysqli_num_rows($resultMarcaDet)) {
                        while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                            $marca = $row1['destab'];
                            $abrev = $row1['abrev'];
                            if ($abrev == '') {
                                $marca = substr($marca, 0, 4);
                            } else {
                                $marca = substr($abrev, 0, 4);
                            }
                        }
                    }

                    if ($numlote <> "") {
                        $Producto = $desprod . "-" . $numlote;
                    } else {
                        $Producto = $desprod;
                    }

                    if ($MarcaImpresion == 1) {
                        $desprod = $desprod;
                    }
                ?>
            <?php
                    $i++;
                }
            }
            ?>
        </table>
    </form>
</body>

</html>