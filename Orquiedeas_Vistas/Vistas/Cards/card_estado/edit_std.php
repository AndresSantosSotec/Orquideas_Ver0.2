<?php
include 'conexion.php'; // Ajusta la ruta de conexión

if (isset($_GET['id_orquidea'])) {
    $id_orquidea = $_GET['id_orquidea'];

    // Consulta para obtener los detalles de la orquídea
    $query = "
        SELECT o.id_orquidea, o.codigo_orquidea, a.estado, a.motivo 
        FROM tb_orquidea o
        LEFT JOIN tb_almacenadas a ON o.id_orquidea = a.id_orquidea
        WHERE o.id_orquidea = '$id_orquidea'
    ";
    $resultado = mysqli_query($conexion, $query);
    $orquidea = mysqli_fetch_assoc($resultado);

    if ($orquidea) {
        ?>
        <div class="container mt-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3>Editar Estado de Orquídea</h3>
                </div>
                <div class="card-body">
                    <form action="../Backend/update_estado.php" method="POST">
                        <input type="hidden" name="id_orquidea" value="<?php echo $orquidea['id_orquidea']; ?>">

                        <div class="mb-3">
                            <label for="codigo_orquidea" class="form-label">Código de Orquídea</label>
                            <input type="text" class="form-control" id="codigo_orquidea" value="<?php echo $orquidea['codigo_orquidea']; ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select">
                                <option value="participando" <?php echo ($orquidea['estado'] == 'participando') ? 'selected' : ''; ?>>Participando</option>
                                <option value="almacenada" <?php echo ($orquidea['estado'] == 'almacenada') ? 'selected' : ''; ?>>Almacenada</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo (opcional)</label>
                            <input type="text" class="form-control" name="motivo" id="motivo" value="<?php echo $orquidea['motivo']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<p>No se encontró la orquídea.</p>";
    }
} else {
    echo "<p>ID de orquídea no proporcionado.</p>";
}
?>
