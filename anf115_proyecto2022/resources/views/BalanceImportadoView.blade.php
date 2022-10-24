<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Balance General</h1>

    <table border="1">
            <tr>
                <th>Codigo de la cuenta</th>
                <th>Tipo de cuenta</th>
                <th>Nombre de la cuenta</th>
                <th>Saldo de la cuenta</th>
                <th>Cuenta de ratio</th>
            </tr>

            <?php

    $concat = '';

    foreach ($cuentasBalance as $balance) {

        //Concatenamos las tablas en una variable, también podriamos hacer el "echo" directamente
        $concat .= '<tr>';
        $concat .= '<td>' . $balance->get_codigoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_tipoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_nombreCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_saldoCuenta() .'</td>';
        $concat .= '<td>' . $balance->get_codigoCuentaRatio() .'</td>';
    
        $concat .= '</tr>';
    }

    echo $concat;
    ?>
    </table>

</body>
<script>

</script>
</html>

