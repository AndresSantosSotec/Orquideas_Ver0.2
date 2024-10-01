<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar la orquídea específica por su ID
    $query = "
        SELECT 
            o.nombre,
            o.numero_telefonico,
            o.direccion,
            o.id_tipo,
            o.id_departamento,
            o.id_municipio,
            o.id_aso
        FROM tb_participante o
        WHERE o.id = '$id'";
    
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $participante = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontraron datos para esta orquídea.";
        exit;
    }
} else {
    echo "ID de orquídea no proporcionado.";
    exit;
}

// Obtener los tipo participante
$tipoparticipantes = mysqli_query($conexion, "SELECT id_tipo, clase FROM tb_tipoparticipante");

// Obtener los departamentos
$departamentos = mysqli_query($conexion, "SELECT id_departamento, nombre_departamento FROM tb_departamento");

// Obtener los municipios
$municipios = mysqli_query($conexion, "SELECT id_municipio, id_departamento, nombre_municipio FROM tb_municipio");
// Obtener la asociacion
$asociacion = mysqli_query($conexion, "SELECT id_aso, Clase FROM tb_aso");



?>

<div class="main-content" id="main-content">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem;">
                <!-- Cambié el color de fondo del header para que sea más acorde al estilo de la segunda imagen -->
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-user-plus"></i> Editar Participante</h3>
                </div>
                <div class="card-body">
                    <form id="form-editar-participante">
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nombre_participante" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="edit_nombre_participante" name="nombre"  value="<?php echo $participante['nombre']; ?>"  required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numero_telefonico" class="form-label">Número Telefónico</label>
                                <input type="tel" class="form-control" id="numero_telefonico" name="numero_telefonico" value="<?php echo $participante['numero_telefonico']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"value="<?php echo $participante['direccion']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="tipo_participante" class="form-label">Tipo de Participante</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_tipo" id="nacional" value="1" value="<?php echo $participante['id_tipo']; ?>" required>
                                <label class="form-check-label" for="nacional">Nacional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="id_tipo" id="extranjero" value="2" value="<?php echo $participante['id_tipo']; ?>" required>
                                <label class="form-check-label" for="extranjero">Extranjero</label>
                            </div>
                        </div>

                        <!-- Campos que se mostrarán si es Nacional -->
                        <div id="campos_nacional">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="departamento" class="form-label">Departamento</label>
                                    <select class="form-select" id="departamento" name="id_departamento">
                                        <option value="">Selecciona un Departamento</option>
                                        <?php while ($row = mysqli_fetch_assoc($departamentos)) { ?>
                                            <option value="<?php echo $row['id_departamento']; ?>" <?php echo $row['id_departamento'] == $participante['id_departamento'] ? 'selected' : ''; ?>>
                                            <?php echo $row['nombre_departamento']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="municipio" class="form-label">Municipio</label>
                                    <select class="form-select" id="municipio" name="id_municipio">
                                        <option value="">Selecciona un Municipio</option>

                                        <?php while ($row = mysqli_fetch_assoc($municipios)) { ?>
                                            <option value="<?php echo $row['id_municipio']; ?>" <?php echo $row['id_municipio'] == $participante['id_municipio'] ? 'selected' : ''; ?>>
                                            <?php echo $row['nombre_municipio']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Asociacion" class="form-label">Asociación</label>
                                <select class="form-select" id="Asociacion" name="id_aso">
                                    <option value="">Selecciona una Asociación</option>
                                    <?php while ($row = mysqli_fetch_assoc($asociacion)) { ?>
                                            <option value="<?php echo $row['id_aso']; ?>" <?php echo $row['id_aso'] == $participante['id_aso'] ? 'selected' : ''; ?>>
                                            <?php echo $row['Clase']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Campo que se mostrará si es Extranjero -->
                        <div id="campo_extranjero" style="display: none;">
                            <div class="mb-3">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" class="form-control" id="pais" name="pais">
                            </div>
                        </div>

                        <!-- Botón de enviar alineado al centro y con un color más moderno -->
                        <div class="d-grid gap-2 d-md-block text-center">
                            <button type="submit" class="btn btn-success">Editar Participante</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
// Manejar la edición del formulario y la alerta
$(document).on('submit', '#form-editar-participante', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    var formData = new FormData(this); // Crear un FormData con los datos del formulario

    $.ajax({
        url: '../Backend/editar_participante.php', // Ruta al archivo PHP que procesa la edición
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log("Respuesta completa del servidor:", response); // Imprimir la respuesta completa
            try {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualización exitosa!',
                        text: 'El participante ha sido actualizado correctamente.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.reload();  // Recargar la página actual
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Hubo un problema al actualizar el participante.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (e) {
                console.error("Error al analizar JSON:", e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La respuesta del servidor no es válida.',
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
