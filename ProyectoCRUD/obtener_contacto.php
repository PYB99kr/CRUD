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

// Verificar que se haya recibido el ID del contacto
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener el contacto
    $sql = "SELECT * FROM contactos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $contacto = $result->fetch_assoc();
        echo json_encode($contacto);
    } else {
        echo json_encode(array("error" => "Contacto no encontrado"));
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo json_encode(array("error" => "ID de contacto no proporcionado"));
}

// Cerrar conexión
$conn->close();
?>
