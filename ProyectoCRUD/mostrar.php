<?php
// Datos de conexión a la base de datos
$servername = "sql107.infinityfree.com"; 
$username = "if0_36583898"; 
$password = "dinofree99"; 
$dbname = "if0_36583898_agenda_contactos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para seleccionar todos los contactos
$sql = "SELECT id, nombre, telefono, email, notas FROM contactos";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos
if ($result->num_rows > 0) {
    // Generar una tabla HTML para mostrar los contactos
    echo "<table>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Correo Electrónico</th><th>Notas</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td><td>".$row["nombre"]."</td><td>".$row["telefono"]."</td><td>".$row["email"]."</td><td>".$row["notas"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron contactos.";
}

// Cerrar conexión
$conn->close();
?>
