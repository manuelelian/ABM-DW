<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Cliente </title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      background-color: #f8fafc;
      color: #1e293b;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom py-3 mb-4">
    <div class="container-fluid px-0">
      <div class="d-flex align-items-center gap-3">
      <a href="<?=$ruta?>clientes" class="btn btn-outline-secondary fw-semibold px-3 py-2 rounded-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
      </a>
    </div>
  </nav>

  <!-- Formulario -->
  <div class="container py-2" style="max-width: 850px;">
    <div class="card shadow-sm border-0 rounded-4">
      
      <!-- Encabezado de la Card -->
      <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
          Agregar Cliente
        </h5>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
          Alta de Cliente
        </span>
      </div>

      <!-- Cuerpo del Formulario -->
      <div class="card-body p-4">
        <form action="" method="POST">
          
          <div class="row g-3">

            <!-- Nombre del Cliente -->
            <div class="col-md-8">
              <label for="nombre" class="form-label small fw-bold text-secondary">NOMBRE DEL CLIENTE</label>
              <input type="text" class="form-control bg-light" name="nombre" placeholder="Ej: Juanchon" value="<?= $datos['nombre'] ?>">
              <?php if (!empty($error_msg['nombre'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['nombre'] ?>
                  </div>
                <?php endif; ?>
            </div>

                        <!-- Domicilio -->
            <div class="col-md-8">
              <label for="domicilio" class="form-label small fw-bold text-secondary">DOMICILIO</label>
              <input type="text" class="form-control bg-light" name="domicilio" placeholder="Ej: Ov. Lagos 1447" value="<?= $datos['domicilio'] ?>">
              <?php if (!empty($error_msg['domicilio'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['domicilio'] ?>
                  </div>
                <?php endif; ?>
            </div>

          </div>

          <div class="col-12 d-flex justify-content-center">
            <?php if ($error === false): ?>
                <?php if (!empty($mensajeOk)): ?>
                    <div class="alert alert-success d-flex align-items-center rounded-3 px-3 py-2 border-0 shadow-sm mb-3" role="alert">
                        <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                        <div><?= $mensajeOk ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mensajeNoOk)): ?>
                    <div class="alert alert-danger d-flex align-items-center rounded-3 px-3 py-2 border-0 shadow-sm mb-3" role="alert">
                        <i class="fa-solid fa-circle-xmark me-2 fs-5"></i>
                        <div><?= $mensajeNoOk ?></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
          <!-- Botones de Acción -->
          <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <a href="<?=$ruta?>clientes" class="btn btn-light border px-4 fw-medium rounded-3">Cancelar</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3">
              Guardar Cliente
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>