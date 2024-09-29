<!-- Modal para editar la orquídea -->
<div class="modal fade" id="editOrquideaModal" tabindex="-1" aria-labelledby="editOrquideaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editOrquideaModalLabel">Editar Orquídea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-editar-orquidea" enctype="multipart/form-data">
                    <input type="hidden" id="id_orquidea" name="id_orquidea">

                    <!-- Nombre de la Planta -->
                    <div class="mb-3">
                        <label for="edit_nombre_planta" class="form-label">Nombre de la Planta</label>
                        <input type="text" class="form-control" id="edit_nombre_planta" name="nombre_planta" required>
                    </div>

                    <!-- Origen -->
                    <div class="mb-3">
                        <label for="edit_origen" class="form-label">Origen</label>
                        <select class="form-select" id="edit_origen" name="origen" required>
                            <option value="">Selecciona el Origen</option>
                            <option value="Especie">Especie</option>
                            <option value="Hibrida">Hibrida</option>
                        </select>
                    </div>

                    <!-- Grupo -->
                    <div class="mb-3">
                        <label for="edit_id_grupo" class="form-label">Grupo</label>
                        <select class="form-select" id="edit_id_grupo" name="id_grupo" required>
                            <option value="">Selecciona un Grupo</option>
                            <?php
                            // Llenar el select con los grupos de la base de datos
                            while ($row = mysqli_fetch_assoc($grupos)) {
                                echo '<option value="' . $row['id_grupo'] . '">' . $row['nombre_grupo'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Clase asociada -->
                    <div class="mb-3">
                        <label for="edit_id_clase" class="form-label">Clase</label>
                        <select class="form-select" id="edit_id_clase" name="id_clase" required>
                            <option value="">Selecciona una Clase</option>
                        </select>
                    </div>

                    <!-- Participante -->
                    <div class="mb-3">
                        <label for="edit_id_participante" class="form-label">Participante</label>
                        <select class="form-select" id="edit_id_participante" name="id_participante" required>
                            <option value="">Selecciona un Participante</option>
                            <?php
                            // Llenar el select con los participantes de la base de datos
                            while ($row = mysqli_fetch_assoc($participantes)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- QR (No editable) -->
                    <div class="mb-3">
                        <label for="edit_codigo_qr" class="form-label">Código QR (No editable)</label>
                        <input type="text" class="form-control" id="edit_codigo_qr" name="codigo_qr" readonly>
                    </div>

                    <!-- Botones de acción -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
