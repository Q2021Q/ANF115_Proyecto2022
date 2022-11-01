<?php
$con = new mysqli ("localhost", "root","","sis_contable_anf115");
$sql = "SELECT saldo, idempresa from cuentageneral";
$res = $con->query($sql);
$con->close();
?>