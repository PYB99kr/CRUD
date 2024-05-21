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

// Verificar que se hayan recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario y sanitizarlos
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $email = $conn->real_escape_string($_POST['email']);
    $notas = $conn->real_escape_string($_POST['notas']);

    // Verificar que los datos no estén vacíos
    if (!empty($nombre) && !empty($telefono) && !empty($email)) {
        // Preparar y ejecutar la consulta
        $sql = "INSERT INTO contactos (nombre, telefono, email, notas) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $telefono, $email, $notas);

        if ($stmt->execute()) {
            echo "Contacto agregado exitosamente";
        } else {
            echo "Error en la ejecución de la consulta: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error: Todos los campos son requeridos";
    }
} else {
    echo "Método de solicitud no permitido";
}

// Cerrar conexión
$conn->close();
?>
