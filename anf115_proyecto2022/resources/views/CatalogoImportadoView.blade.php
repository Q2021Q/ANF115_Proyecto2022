<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<a href="{{route('home_empresa')}}">HOME</a>

<h1>{{$nomE}}</h1>

    <h2>Catalogo de Cuentas</h2>
  
    
<?php
    $mensaje_error_si_no = '';
    $sms = $mensaje;
    if($error_cuenta == TRUE){
        $mensaje_error_si_no .= '<h3  style="color:#FF0000">';
        $mensaje_error_si_no .=  $sms;
        $mensaje_error_si_no .= '</h3>';
    }
       
     else{
        $mensaje_error_si_no .= '<h3 style="color:#9A4BF9">';
        $mensaje_error_si_no .=  $sms;
        $mensaje_error_si_no .= '</h3>';
     }
        
    echo $mensaje_error_si_no;
?>
    <table border="1">
            <tr>
            <th>Codigo de de la cuenta</th>      
            <th>Nombre de la cuenta</th
                           
            </tr>

            <?php

    $concat = '';

    foreach ($cuentasBalance as $indice_1 => $balance) {

       

        //compara las cuentas y si encuentra repetida $error = true
        $error = false;
        foreach($cuentasInvalidas as $indice => $elemento) {
            if ($indice_1 == $indice) {
                $error = true;
            }
        }

    if($error_cuenta == TRUE){
        if($error){
            $concat .= '<tr span style="color:blue" width="50%" bgcolor=FFC0CB>';
        }
        else
             $concat .= '<tr >';
    }
    else 
        $concat .= '<tr bgcolor=#EBF5FB>';
    
        //Concatenamos las tablas en una variable, también podriamos hacer el "echo" directamente
      
        $concat .= '<td >' .$balance->get_codigoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_nombreCuenta() .'</td>';
        
        $concat .= '</tr>';
    }

    echo $concat;
    ?>
    </table>

</body>
<script>

</script>
</html>

