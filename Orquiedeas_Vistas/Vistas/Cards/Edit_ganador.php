<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

if (isset($_GET['id'])) {
    $id_ganador = $_GET['id'];

    // Consultar la orquídea específica por su ID
    $query = "
        SELECT 
            o.id_orquidea,
            o.id_grupo,
            o.id_clase,
            o.posicion,
            o.empate
        FROM tb_ganadores o
        WHERE o.id_ganador = '$id_ganador'";
    
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $ganador = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontraron datos para este ganador.";
        exit;
    }
} else {
    echo "ID del ganador no proporcionado.";
    exit;
}

// Obtener las orquideas
$orquideas = mysqli_query($conexion, "SELECT id_orquidea, nombre_planta FROM tb_orquidea");

// Obtener los grupos
$grupos = mysqli_query($conexion, "SELECT id_grupo, nombre_grupo FROM grupo");

// Obtener las clases
$clases = mysqli_query($conexion, "SELECT id_clase, nombre_clase FROM clase");

?>



<div class="card my-custom-card">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-award"></i> Editar Ganador</h5>
        <form id="form-editar-ganador" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para enviar el ID del ganador -->
            <input type="hidden" name="id_ganador" value="<?php echo $id_ganador; ?>">
            <!-- Select de Orquídea -->
            <div class="form-group">
                <label for="id_orquidea">Orquídea:</label>
                <select name="id_orquidea" id="id_orquidea" class="form-control" required>
                    <option value="">Seleccionar Orquídea</option>
                    <?php
                    $query = "SELECT o.id_orquidea, o.nombre_planta, p.nombre AS nombre_participante 
                    FROM tb_orquidea o 
                    INNER JOIN tb_participante p ON o.id_participante = p.id";
          $result = mysqli_query($conexion, $query);
          while ($row = mysqli_fetch_assoc($result)) {
              // Seleccionar la orquídea correspondiente al ganador que se está editando
              $selected = ($row['id_orquidea'] == $ganador['id_orquidea']) ? 'selected' : '';
              echo "<option value='" . $row['id_orquidea'] . "' $selected>" . $row['nombre_planta'] . " - Participante: " . $row['nombre_participante'] . "</option>";
          }
                    ?>
                </select>
            </div>

            <!-- Select de Categoría (Clase y Grupo) -->
            <div class="form-group">
                <label for="id_categoria">Categoría (Clase/Grupo):</label>
                <select name="id_categoria" id="id_categoria" class="form-control" required>
                    <option value="">Seleccionar Categoría</option>
                    <?php
                    $query = "
                    SELECT g.Cod_Grupo, c.nombre_clase, g.id_grupo, c.id_clase 
                    FROM clase c
                    INNER JOIN grupo g ON c.id_grupo = g.id_grupo";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Mantener la categoría seleccionada en el formulario de edición
                        $selected = ($row['id_grupo'] == $ganador['id_grupo'] && $row['id_clase'] == $ganador['id_clase']) ? 'selected' : '';
                        echo "<option value='" . $row['id_grupo'] . "-" . $row['id_clase'] . "' $selected>"
                            . $row['Cod_Grupo'] . ": " . $row['nombre_clase'] . "</option>";
                    }
        
                    ?>
                </select>
            </div>

            <!-- Select de Posición -->
            <div class="form-group">
                <label for="posicion">Posición:</label>
                <select name="posicion" id="posicion" class="form-control" required>
                    <option value="">Seleccionar Posición</option>
                    <option value="1" <?php echo ($ganador['posicion'] == 1) ? 'selected' : ''; ?>>1° Lugar</option>
                    <option value="2" <?php echo ($ganador['posicion'] == 2) ? 'selected' : ''; ?>>2° Lugar</option>
                    <option value="3" <?php echo ($ganador['posicion'] == 3) ? 'selected' : ''; ?>>3° Lugar</option>
                </select>
            </div>

            <!-- Checkbox de Empate -->
            <div class="form-group">
                <label for="empate">Empate:</label><br>
                <input type="checkbox" name="empate" id="empate" value="1" <?php echo ($ganador['empate'] == 1) ? 'checked' : ''; ?>> Marcar si hay empate
            </div>

            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary">Editar Ganador</button>
        </form>
    </div>
</div>

<script>
// Manejar la edición del formulario y la alerta
$(document).on('submit', '#form-editar-ganador', function(e) {
    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    var formData = new FormData(this); // Crear un FormData con los datos del formulario

    $.ajax({
        url: '../Backend/editar_ganador.php', // Ruta al archivo PHP que procesa la edición
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