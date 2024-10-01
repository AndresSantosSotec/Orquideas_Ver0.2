<div class="main-content" id="main-content">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 50rem;">
                <!-- Cambié el color de fondo del header para que sea más acorde al estilo de la segunda imagen -->
                <div class="card-header bg-success text-white">
                    <h3><i class="fas fa-user-plus"></i> Agregar Participante</h3>
                </div>
                <div class="card-body">
                    <form id="form-participante">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="numero_telefonico" class="form-label">Número Telefónico</label>
                                <input type="tel" class="form-control" id="numero_telefonico" name="numero_telefonico" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>

                        <div class="mb-3">
                            <label for="tipo_participante" class="form-label">Tipo de Participante</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_participante" id="nacional" value="1" required>
                                <label class="form-check-label" for="nacional">Nacional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_participante" id="extranjero" value="2" required>
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
                                        <?php
                                        // Cargar los departamentos de la base de datos
                                        while ($row = mysqli_fetch_assoc($consu)) {
                                            echo '<option value="' . $row['id_departamento'] . '">' . $row['nombre_departamento'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="municipio" class="form-label">Municipio</label>
                                    <select class="form-select" id="municipio" name="id_municipio">
                                        <option value="">Selecciona un Municipio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Asociacion" class="form-label">Asociación</label>
                                <select class="form-select" id="Asociacion" name="id_aso">
                                    <option value="">Selecciona una Asociación</option>
                                    <?php
                                    // Cargar las asociaciones de la base de datos
                                    while ($row = mysqli_fetch_assoc($consu1)) {
                                        echo '<option value="' . $row['id_aso'] . '">' . $row['clase'] . '</option>';
                                    }
                                    ?>
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
                            <button type="submit" class="btn btn-success">Agregar Participante</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>