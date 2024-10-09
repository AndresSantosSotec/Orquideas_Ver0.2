<?php
include 'conexion.php'; // Ajusta la ruta de conexión

// Consultar las orquídeas que no tienen un estado almacenado
$query = "
    SELECT o.id_orquidea, o.codigo_orquidea, p.nombre AS nombre_participante
    FROM tb_orquidea o
    INNER JOIN tb_participante p ON o.id_participante = p.id
    WHERE o.id_orquidea NOT IN (SELECT id_orquidea FROM tb_almacenadas)"; // Excluir las orquídeas ya almacenadas en tb_almacenadas
$orquideas = mysqli_query($conexion, $query);

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_orquidea = $_POST['id_orquidea'];
    $estado = $_POST['estado'];
    $motivo = $_POST['motivo'];

    // Insertar el nuevo registro en la tabla tb_almacenadas
    $insertQuery = "INSERT INTO tb_almacenadas (id_orquidea, estado, motivo) VALUES ('$id_orquidea', '$estado', '$motivo')";
    if (mysqli_query($conexion, $insertQuery)) {
        echo "<script>
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Estado de la orquídea agregado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo agregar el estado.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <!-- Card para agregar el estado -->
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Agregar Estado a Orquídea</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="id_orquidea" class="form-label">Orquídea</label>
                    <select name="id_orquidea" id="id_orquidea" class="form-select" required>
                        <option value="">Selecciona una orquídea</option>
                        <?php
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

<!-- Agregar SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
