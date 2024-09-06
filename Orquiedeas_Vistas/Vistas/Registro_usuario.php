<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Orquídeas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="Recursos/css/Estilos.css">
    <link rel="stylesheet" href="../../Recursos/css/Estilos.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-center">Registro de Usuarios</h1>

                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div class="alert alert-success">
                        Orquídea registrada exitosamente.
                    </div>
                <?php endif; ?>

                <form id="orquideaForm" action="registrar.php" method="POST" enctype="multipart/form-data">
                    <!-- Sección del Participante -->
                    <div class="mb-2">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="procedencia" class="form-label">Procedencia</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="procedencia" value="Regional" id="regional" required>
                                <label class="form-check-label" for="regional">Regional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="procedencia" value="Extranjero" id="extranjero" required>
                                <label class="form-check-label" for="extranjero">Extranjero</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="departamento_id" class="form-label">Departamento</label>
                        <select name="departamento_id" id="departamento_id" class="form-select" required>
                            <option value="">Seleccione un Departamento</option>
                            <option value="1">Departamento 1</option>
                            <option value="2">Departamento 2</option>
                        </select>
                    </div>
                    
                    <div class="mb-2">
                        <label for="municipio_id" class="form-label">Municipio</label>
                        <select name="municipio_id" id="municipio_id" class="form-select" required>
                            <option value="">Seleccione un Municipio</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="celular" class="form-label">Número de Celular</label>
                        <input type="text" name="celular" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <!-- Campo de contraseña con opción para mostrar/ocultar -->
                    <div class="mb-2">
                        <label for="pass" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" id="pass" name="pass" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Sección de la Orquídea -->

                    <button type="submit" class="btn btn-primary w-100 btn-sm">Registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('departamento_id').addEventListener('change', function() {
            let departamentoId = this.value;
            let municipioSelect = document.getElementById('municipio_id');

            municipioSelect.innerHTML = '<option value="">Cargando...</option>';

            fetch(`municipios.php?departamento_id=${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    municipioSelect.innerHTML = '<option value="">Seleccione un Municipio</option>';
                    data.forEach(municipio => {
                        municipioSelect.innerHTML += `<option value="${municipio.id}">${municipio.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching municipios:', error));
        });

        // Función para mostrar/ocultar la contraseña
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('pass');
            const toggleIcon = document.getElementById('toggleIcon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        }

        <?php if (isset($_GET['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                text: 'La orquídea ha sido registrada exitosamente.',
            });
        <?php endif; ?>
    </script>
</body>
</html>
