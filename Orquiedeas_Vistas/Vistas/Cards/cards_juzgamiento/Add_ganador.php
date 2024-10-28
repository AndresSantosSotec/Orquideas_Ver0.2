<?php
include '../../../Backend/Conexion_bd.php';

// Consultar orquídeas no juzgadas
$query = "SELECT o.id_orquidea, o.nombre_planta, p.nombre AS nombre_participante, g.Cod_Grupo 
          FROM tb_orquidea o
          INNER JOIN tb_participante p ON o.id_participante = p.id
          INNER JOIN grupo g ON o.id_grupo = g.id_grupo
          WHERE o.id_orquidea NOT IN (SELECT id_orquidea FROM tb_ganadores)";
$result_orquideas = mysqli_query($conexion, $query);

// Consultar categorías
$query_categorias = "SELECT g.Cod_Grupo, c.nombre_clase, g.id_grupo, c.id_clase 
                     FROM clase c
                     INNER JOIN grupo g ON c.id_grupo = g.id_grupo";
$result_categorias = mysqli_query($conexion, $query_categorias);
?>
<div class="card my-custom-card">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-award"></i> Agregar Ganador</h5>
        <form method="POST" action="../Backend/add_ganador.php">
            <!-- Filtros de búsqueda -->
            <div class="row mb-3">
                <div class="col-md-6">
                    
                    <label for="search_participante">Buscar Participante:</label>
                    <input type="text" id="search_participante" class="form-control" placeholder="Buscar por participante...">
                </div>
                <div class="col-md-6">
                    <label for="search_grupo">Buscar Grupo:</label>
                    <input type="text" id="search_grupo" class="form-control" placeholder="Ingresar letra del grupo (Ejemplo: A, B, C...)">
                </div>
            </div>
            <p><strong>Instrucciones:</strong> Escriba el nombre de la orquídea, participante o grupo (por ejemplo: <code>A</code>) para filtrar.</p>
            <!-- Select de Orquídea -->
            <div class="form-group mb-3">
                <label for="id_orquidea">Orquídea:</label>
                <select name="id_orquidea" id="id_orquidea" class="form-control" required>
                    <option value="">Seleccionar Orquídea</option>
                    <?php while ($row = mysqli_fetch_assoc($result_orquideas)): ?>
                        <option value="<?= $row['id_orquidea']; ?>"
                            data-participante="<?= strtolower($row['nombre_participante']); ?>"
                            data-grupo="<?= strtolower($row['Cod_Grupo']); ?>">
                            <?= $row['nombre_planta']; ?> - Participante: <?= $row['nombre_participante']; ?> - Grupo: <?= $row['Cod_Grupo']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Select de Categoría (Clase y Grupo) -->
            <div class="form-group mb-3">
                <label for="id_categoria">Categoría (Clase/Grupo):</label>
                <select name="id_categoria" id="id_categoria" class="form-control" required>
                    <option value="">Seleccionar Categoría</option>
                    <?php while ($row = mysqli_fetch_assoc($result_categorias)): ?>
                        <option value="<?= $row['id_grupo'] . '-' . $row['id_clase']; ?>">
                            <?= $row['Cod_Grupo']; ?> - <?= $row['nombre_clase']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Select de Posición -->
            <div class="form-group mb-3">
                <label for="posicion">Posición:</label>
                <select name="posicion" id="posicion" class="form-control" required>
                    <option value="">Seleccionar Posición</option>
                    <option value="1">1° Lugar</option>
                    <option value="2">2° Lugar</option>
                    <option value="3">3° Lugar</option>
                </select>
            </div>

            <!-- Checkbox de Empate -->
            <div class="form-group mb-3">
                <label for="empate">Empate:</label><br>
                <input type="checkbox" name="empate" id="empate" value="1"> Marcar si hay empate
            </div>

            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary w-100">Agregar Ganador</button>
        </form>
    </div>
</div>

<script>
    // Función para aplicar los filtros de búsqueda
    function applyFilters() {
        const searchParticipante = document.getElementById('search_participante').value.toLowerCase();
        const searchGrupo = document.getElementById('search_grupo').value.toLowerCase();
        const orquideaOptions = document.querySelectorAll('#id_orquidea option');

        orquideaOptions.forEach(option => {
            const participante = option.getAttribute('data-participante') || '';
            const grupo = option.getAttribute('data-grupo') || '';

            const matchesParticipante = participante.includes(searchParticipante);
            const matchesGrupo = grupo.includes(searchGrupo);

            option.style.display = matchesParticipante && matchesGrupo ? '' : 'none';
        });
    }

    // Agregar eventos a los inputs de búsqueda
    document.getElementById('search_participante').addEventListener('input', applyFilters);
    document.getElementById('search_grupo').addEventListener('input', applyFilters);
</script>