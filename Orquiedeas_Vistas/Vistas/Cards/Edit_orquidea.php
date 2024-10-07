<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

if (isset($_GET['id_orquidea'])) {
    $id_orquidea = $_GET['id_orquidea'];

    // Consultar la orquídea específica por su ID
    $query = "
        SELECT 
            o.nombre_planta,
            o.origen,
            o.id_grupo,
            o.id_clase,
            o.id_participante,
            o.foto
        FROM tb_orquidea o
        WHERE o.id_orquidea = '$id_orquidea'";
    
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $orquidea = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontraron datos para esta orquídea.";
        exit;
    }
} else {
    echo "ID de orquídea no proporcionado.";
    exit;
}

// Obtener los grupos
$grupos = mysqli_query($conexion, "SELECT id_grupo, nombre_grupo FROM grupo");

// Obtener las clases
$clases = mysqli_query($conexion, "SELECT id_clase, nombre_clase FROM clase");

// Obtener los participantes
$participantes = mysqli_query($conexion, "SELECT id, nombre FROM tb_participante");

?>

<div class="main-content" id="main-content">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3><i class="fas fa-leaf"></i> Editar Orquídea</h3>
            </div>
            <div class="card-body">
                <form id="form-editar-orquidea" enctype="multipart/form-data">
                    <input type="hidden" id="id_orquidea" name="id_orquidea" value="<?php echo $id_orquidea; ?>">

                    <div class="row">
                        <!-- Nombre de la Planta -->
                        <div class="mb-3 col-md-4">
                            <label for="edit_nombre_planta" class="form-label">Nombre de la Planta</label>
                            <input type="text" class="form-control" id="edit_nombre_planta" name="nombre_planta" value="<?php echo $orquidea['nombre_planta']; ?>" required>
                        </div>

                        <!-- Origen -->
                        <div class="mb-3 col-md-4">
                            <label for="edit_origen" class="form-label">Origen</label>
                            <select class="form-select" id="edit_origen" name="origen" required>
                                <option value="">Selecciona el Origen</option>
                                <option value="Especie" <?php echo $orquidea['origen'] == 'Especie' ? 'selected' : ''; ?>>Especie</option>
                                <option value="Hibrida" <?php echo $orquidea['origen'] == 'Hibrida' ? 'selected' : ''; ?>>Híbrida</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Grupo -->
                        <div class="mb-3 col-md-4">
                            <label for="edit_id_grupo" class="form-label">Grupo</label>
                            <select class="form-select" id="edit_id_grupo" name="id_grupo" required>
                                <option value="">Selecciona un Grupo</option>
                                <?php while ($row = mysqli_fetch_assoc($grupos)) { ?>
                                    <option value="<?php echo $row['id_grupo']; ?>" <?php echo $row['id_grupo'] == $orquidea['id_grupo'] ? 'selected' : ''; ?>>
                                        <?php echo $row['nombre_grupo']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Clase -->
                        <div class="mb-3 col-md-4">
                            <label for="edit_id_clase" class="form-label">Clase</label>
                            <select class="form-select" id="edit_id_clase" name="id_clase" required>
                                <option value="">Selecciona una Clase</option>
                                <?php while ($row = mysqli_fetch_assoc($clases)) { ?>
                                    <option value="<?php echo $row['id_clase']; ?>" <?php echo $row['id_clase'] == $orquidea['id_clase'] ? 'selected' : ''; ?>>
                                        <?php echo $row['nombre_clase']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Participante -->
                    <div class="mb-3">
                        <label for="edit_id_participante" class="form-label">Participante</label>
                        <select class="form-select" id="edit_id_participante" name="id_participante" required>
                            <option value="">Selecciona un Participante</option>
                            <?php while ($row = mysqli_fetch_assoc($participantes)) { ?>
                                <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $orquidea['id_participante'] ? 'selected' : ''; ?>>
                                    <?php echo $row['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Mostrar la imagen actual -->
                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Foto de la Orquídea</label><br>
                        <?php if (!empty($orquidea['foto'])) { ?>
                            <img src="../../Recursos/img/Saved_images/Images/<?php echo $orquidea['foto']; ?>" alt="Foto Orquídea" width="150">
                        <?php } ?>
                        <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Manejar la edición del formulario y la alerta
$(document).on('submit', '#form-editar-orquidea', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    var formData = new FormData(this); // Crear un FormData con los datos del formulario

    $.ajax({
        url: '../Backend/editar_orquidea.php', // Ruta al archivo PHP que procesa la edición
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualización exitosa!',
                    text: 'La orquídea ha sido actualizada correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Recargar la página o redirigir después de la edición
                    location.reload();  // Recargar la página actual
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Hubo un problema al actualizar la orquídea.',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud.',
                confirmButtonText: 'Aceptar'
            });
            console.error('Error al procesar la solicitud:', xhr.responseText);
        }
    });
});
</script>
