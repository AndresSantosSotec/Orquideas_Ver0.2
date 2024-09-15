<?php
include '../Backend/Conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_grupo = $_POST['id_grupo'];

    // Consultar las clases basadas en el grupo seleccionado
    $clases = mysqli_query($conexion, "SELECT id_clase, nombre_clase FROM clase WHERE id_grupo = $id_grupo");

    // Generar las opciones de clases
    while ($row = mysqli_fetch_assoc($clases)) {
        echo '<option value="' . $row['id_clase'] . '">' . $row['nombre_clase'] . '</option>';
    }
}
