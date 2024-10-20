
<div class="card my-custom-card">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-award"></i> Agregar Ganador</h5>
        <form method="POST" action="../Backend/add_ganador.php">
            <!-- Select de Orquídea -->
            <div class="form-group">
                <label for="id_orquidea">Orquídea:</label>
                <select name="id_orquidea" id="id_orquidea" class="form-control" required>
                    <option value="">Seleccionar Orquídea</option>
                    <?php
                    include '../../../Backend/Conexion_bd.php';
                    $query = "SELECT o.id_orquidea, o.nombre_planta, p.nombre AS nombre_participante 
                              FROM tb_orquidea o 
                              INNER JOIN tb_participante p ON o.id_participante = p.id";
                    $result = mysqli_query($conexion, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id_orquidea'] . "'>" . $row['nombre_planta'] . " - Participante: " . $row['nombre_participante'] . "</option>";
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
                    $query = "SELECT g.Cod_Grupo, c.nombre_clase, g.id_grupo, c.id_clase 
                              FROM clase c
                              INNER JOIN grupo g ON c.id_grupo = g.id_grupo";
                    $result = mysqli_query($conexion, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id_grupo'] . "-" . $row['id_clase'] . "'>" . $row['Cod_Grupo'] . " - " . $row['nombre_clase'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Select de Posición -->
            <div class="form-group">
                <label for="posicion">Posición:</label>
                <select name="posicion" id="posicion" class="form-control" required>
                    <option value="">Seleccionar Posición</option>
                    <option value="1">1° Lugar</option>
                    <option value="2">2° Lugar</option>
                    <option value="3">3° Lugar</option>
                </select>
            </div>

            <!-- Checkbox de Empate -->
            <div class="form-group">
                <label for="empate">Empate:</label><br>
                <input type="checkbox" name="empate" id="empate" value="1"> Marcar si hay empate
            </div>

            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary">Agregar Ganador</button>
        </form>
    </div>
</div>
