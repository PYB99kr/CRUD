<?php
// Configuración de la base de datos
$servername = "sql107.infinityfree.com"; 
$username = "if0_36583898"; 
$password = "dinofree99"; 
$dbname = "if0_36583898_agenda_contactos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener todos los contactos
$sql = "SELECT * FROM contactos";
$result = $conn->query($sql);

$contactos = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contactos[] = $row;
    }
}

echo json_encode($contactos);

// Cerrar conexión
$conn->close();
?>
