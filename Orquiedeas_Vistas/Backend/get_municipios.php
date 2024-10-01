<?php
include 'Conexion_bd.php';

if (isset($_POST['id_departamento'])) {
    $id_departamento = $_POST['id_departamento'];

    // Consultar municipios según el departamento seleccionado
    $query = "SELECT id_municipio, nombre_municipio FROM tb_municipio WHERE id_departamento = $id_departamento";
    $result = mysqli_query($conexion, $query);

    // Generar las opciones para el select de municipios
    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Selecciona un Municipio</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['id_municipio'].'">'.$row['nombre_municipio'].'</option>';
        }
    } else {
        echo '<option value="">No hay municipios disponibles</option>';
    }
}
?>
