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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Preparar y ejecutar la consulta
    $sql = "DELETE FROM contactos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Contacto eliminado exitosamente";
    } else {
        echo "Error al eliminar el contacto: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "ID de contacto no proporcionado";
}

// Cerrar conexión
$conn->close();
?>
