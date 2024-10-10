<?php 
include 'conexion.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estado de Orquídea</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
        <!-- Card para agregar el estado -->
        <div class="card" style="font-size: 0.9rem;">
            <div class="card-header bg-primary text-white">
                <h2 style="font-size: 1.5rem;">Agregar Estado a Orquídea</h2>
            </div>
            <div class="card-body" style="padding: 10px;">
                <!-- Cambiar la acción del formulario para que envíe a add_estado.php -->
                <form action="../Backend/add_estado.php" method="POST">
                    <div class="mb-3">
                        <label for="id_orquidea" class="form-label">Orquídea</label>
                        <select name="id_orquidea" id="id_orquidea" class="form-select" required>
                            <option value="">Selecciona una orquídea</option>
                            <?php
                            // Consultar las orquídeas que no tienen un estado almacenado
                            include 'conexion.php'; // Agregar la conexión a la base de datos
                            $query = "
                                SELECT o.id_orquidea, o.codigo_orquidea, p.nombre AS nombre_participante
                                FROM tb_orquidea o
                                INNER JOIN tb_participante p ON o.id_participante = p.id
                                WHERE o.id_orquidea NOT IN (SELECT id_orquidea FROM tb_almacenadas)"; // Excluir las orquídeas ya almacenadas
                            $orquideas = mysqli_query($conexion, $query);
                            if ($orquideas && mysqli_num_rows($orquideas) > 0) {
                                while ($row = mysqli_fetch_assoc($orquideas)) {
                                    // Mostrar el nombre del participante y el código de la orquídea
                                    echo '<option value="' . $row['id_orquidea'] . '">Orquídea: ' . $row['codigo_orquidea'] . ' - Participante: ' . $row['nombre_participante'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No hay orquídeas disponibles</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="">Selecciona un estado</option>
                            <option value="participando">Participando</option>
                            <option value="almacenada">Almacenada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo (opcional)</label>
                        <input type="text" name="motivo" id="motivo" class="form-control" placeholder="Motivo del cambio de estado">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Estado</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
