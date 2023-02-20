<?php

require_once('conexion.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de locales</title>

    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
</head>

<body>

    <?php

    require_once('conexion.php');
    require_once 'convertfecha.php';
  
   $sqlDetalleVenta = "SELECT id,linea1,linea2,linea3,linea4,linea5,linea7 FROM ticket";
    $resultDetalleVenta = mysqli_query($conexion, $sqlDetalleVenta);
    
    
			
    if (mysqli_num_rows($resultDetalleVenta)) {
    ?>

        <table border='1' width="100%" align="center" id="customers">

            <thead>
                 <tr>
                    <th colspan='30'>
                        <h1>
                         REPORTE DE LOCALES
                        </h1>
                    </th>
                </tr>
                <tr>
                 
                    <th> ID </th>
                    <th> Nombre Local </th>
                     <th> Razon Social </th>
                     <th> Direccion </th>
                     
                      <th> RUC  </th>
                      <th> Nombre local Sistema  </th>
               
                
                </tr>
            </thead>
            <tbody>
                <?php
              
                
                while ($rowDetalleVenta = mysqli_fetch_array($resultDetalleVenta)) {

                    $id       = $rowDetalleVenta['id'];
                    $linea1       = $rowDetalleVenta['linea1'];
                    $linea2       = $rowDetalleVenta['linea2'];
                    $linea3         = $rowDetalleVenta['linea3'];
                    $linea4         = $rowDetalleVenta['linea4'];
                    $linea5         = $rowDetalleVenta['linea5'];
                    $linea7         = $rowDetalleVenta['linea7'];
                 
                

          
              
                    
                     
                        echo '<tr>
                    <td>' . $id . ' </td>
                    <td>' . $linea1 . ' </td>
                    <td>' . $linea2 . '</td>
                    <td>' . $linea3 . ' - ' .  $linea4 . '</td>
                    <td>' . $linea5 . ' </td>
                     <td>' . $linea7 . ' </td>
                   
          
                    
                 
                
                </tr>';
 
                }

                ?>
            </tbody>
        </table>
    <?php

    }
    ?>


</body>

</html>


<script>
    $(document).ready(function() {
            $('#customers').DataTable({
                 "pageLength": 100,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ãltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                    'excel'
                ]
                
            });
        }

    );
    
    
     
</script>