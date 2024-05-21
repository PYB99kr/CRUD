<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Credenciales de la base de datos obtenidas del panel de control de InfinityFree
$servername = "sql107.infinityfree.com"; 
$username = "if0_36583898"; 
$password = "dinofree99"; 
$dbname = "if0_36583898_agenda_contactos";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }
    echo "Conexión exitosa a la base de datos";
    $conn->close();
} catch (Exception $e) {
    echo 'Error: ',  $e->getMessage(), "\n";
}
?>
